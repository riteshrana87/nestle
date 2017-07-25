<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class DeliveryOrder extends CI_Controller {

    function __construct() {

        parent::__construct();
        $this->module = 'Projectmanagement';
        $this->viewname = $this->router->fetch_class();
        $this->user_info = $this->session->userdata('LOGGED_IN');  //Current Login information
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('form_validation', 'Session'));
    }

    /*
      @Author : Ritesh Rana
      @Desc   : DeliveryOrder index
      @Input  :
      @Output :
      @Date   : 22/03/2017
     */

    public function index() {

        $searchtext = '';
        $perpage = '';
        $searchtext = $this->input->post('searchtext');
        $sortfield = $this->input->post('sortfield');
        $sortby = $this->input->post('sortby');
        $perpage = 10;
        $allflag = $this->input->post('allflag');
        if (!empty($allflag) && ($allflag == 'all' || $allflag == 'changesorting' || $allflag == 'changesearch')) {
            $this->session->unset_userdata('deliveryOrder_data');
        }
        $searchsort_session = $this->session->userdata('deliveryOrder_data');
        //Sorting
        if (!empty($sortfield) && !empty($sortby)) {
            $data['sortfield'] = $sortfield;
            $data['sortby'] = $sortby;
        } else {
            if (!empty($searchsort_session['sortfield'])) {
                $data['sortfield'] = $searchsort_session['sortfield'];
                $data['sortby'] = $searchsort_session['sortby'];
                $sortfield = $searchsort_session['sortfield'];
                $sortby = $searchsort_session['sortby'];
            } else {
                $sortfield = 'delivery_order_id';
                $sortby = 'desc';
                $data['sortfield'] = $sortfield;
                $data['sortby'] = $sortby;
            }
        }
        //Search text
        if (!empty($searchtext)) {
            $data['searchtext'] = $searchtext;
        } else {
            if (empty($allflag) && !empty($searchsort_session['searchtext'])) {
                $data['searchtext'] = $searchsort_session['searchtext'];
                $searchtext = $data['searchtext'];
            } else {
                $data['searchtext'] = '';
            }
        }

        if (!empty($perpage) && $perpage != 'null') {
            $data['perpage'] = $perpage;
            $config['per_page'] = $perpage;
        } else {
            if (!empty($searchsort_session['perpage'])) {
                $data['perpage'] = trim($searchsort_session['perpage']);
                $config['per_page'] = trim($searchsort_session['perpage']);
            } else {
                $config['per_page'] = '10';
                $data['perpage'] = '10';
            }
        }
        //pagination configuration
        $config['first_link'] = 'First';
        $config['base_url'] = base_url() . $this->viewname . '/index';

        if (!empty($allflag) && ($allflag == 'all' || $allflag == 'changesorting' || $allflag == 'changesearch')) {
            $config['uri_segment'] = 0;
            $uri_segment = 0;
        } else {
            $config['uri_segment'] = 3;
            $uri_segment = $this->uri->segment(3);
        }
        //Query
        $table = DELIVERY_ORDER . ' as do';
        $where = array("do.is_deleted" => '0');
        $fields = array("do.customer_code,do.sr_number,, do.delivery_order_id , do.delivery_order, do.order_date, ce.contact_name, ce.contact_number, do.total_amount,do.payment_terms,ce.customer_name,mi.machine_serial_number, do.caller_name, do.caller_number");
        $join_tables = array(CUSTOMER_ENROLMENT . ' as ce' => 'ce.customer_id=do.customer_code',
            MACHINE_INVENTORY . ' as mi' => 'do.sr_number = mi.inventory_id');

        if (!empty($searchtext)) {
            $searchtext = html_entity_decode(trim(addslashes($searchtext)));
            $match = '';
            $where_search = '((ce.customer_name LIKE "%' . $searchtext . '%" OR do.order_date LIKE "%' . date("Y-m-d", strtotime($searchtext)) . '%" OR do.total_amount LIKE "%' . $searchtext . '%" OR ce.contact_name LIKE "%' . $searchtext . '%" OR ce.contact_number LIKE "%' . $searchtext . '%" OR mi.machine_serial_number LIKE "%' . $searchtext . '%")AND do.is_deleted = "0")';

            $data['information'] = $this->common_model->get_records($table, $fields, $join_tables, 'left', '', $match, $config['per_page'], $uri_segment, $sortfield, $sortby, '', $where_search);
//echo($this->db->last_query());exit;
            $config['total_rows'] = $this->common_model->get_records($table, $fields, $join_tables, 'left', '', $match, '', '', $sortfield, $sortby, '', $where_search, '', '', '1');
        } else {
            $data['information'] = $this->common_model->get_records($table, $fields, $join_tables, 'left', '', '', $config['per_page'], $uri_segment, $sortfield, $sortby, '', $where);
            $config['total_rows'] = $this->common_model->get_records($table, $fields, $join_tables, 'left', '', '', '', '', $sortfield, $sortby, '', $where, '', '', '1');
        }
//pr($this->db->last_query());exit;
        $this->ajax_pagination->initialize($config);
        $data['pagination'] = $this->ajax_pagination->create_links();
        $data['uri_segment'] = $uri_segment;
        $sortsearchpage_data = array(
            'sortfield' => $data['sortfield'],
            'sortby' => $data['sortby'],
            'searchtext' => $data['searchtext'],
            'perpage' => trim($data['perpage']),
            'uri_segment' => $uri_segment,
            'total_rows' => $config['total_rows']);
        $this->session->set_userdata('deliveryOrder_data', $sortsearchpage_data);
        setActiveSession('deliveryOrder_data'); // set current Session active

        $data['header'] = array('menu_module' => 'order_management', 'menu_child' => 'delivery_order');
        $data['crnt_view'] = $this->viewname;
        $data['footerJs'][0] = base_url('uploads/assets/js/bootstrap-datetimepicker.min.js');
        $data['footerJs'][1] = base_url('uploads/custom/js/deliveryorder/deliveryorder.js');
        if ($this->input->post('result_type') == 'ajax') {
            $this->load->view($this->viewname . '/DeliveryOrderAjaxList', $data);
        } else {
            $data['main_content'] = '/DeliveryOrder';
            $this->parser->parse('layouts/DefaultTemplate', $data);
        }
    }

    /*
      @Author : Ritesh Rana
      @Desc   : Insert data
      @Input  : Post data
      @Output : Insert
      @Date   : 22/03/2017
     */

    public function insertdata() {

        if ($this->input->post('delivery_order_id')) {
            $id = $invoice_id = $this->input->post('delivery_order_id');
        }
        if (!empty($id)) { //update
            $insert_data['customer_code'] = $this->input->post('cust_code');
            $insert_data['customer_name'] = $this->input->post('cust_name');
            $insert_data['sr_number'] = $this->input->post('sr_number_installation');
            $insert_data['delivery_order'] = $this->input->post('delivery_order');
            $insert_data['order_date'] = date('Y-m-d', strtotime($this->input->post('order_date')));
            //$insert_data['payment_terms'] = $this->input->post('payment_terms');
            $insert_data['caller_name'] = $this->input->post('caller_name');
            $insert_data['caller_number'] = $this->input->post('caller_number');
            $insert_data['lpo_number'] = $this->input->post('lpo_number');
            $insert_data['remarks'] = $this->input->post('remarks');
            $insert_data['delivery_location'] = $this->input->post('delivery_location');
            $insert_data['priority'] = $this->input->post('priority');
            $insert_data['order_type'] = $this->input->post('order_type');
            //$insert_data['zone'] = '';
            $insert_data['delivery_date'] = date('Y-m-d H:i:s', strtotime($this->input->post('delivery_date')));
            $insert_data['total_amount'] = $this->input->post('amount_total');
            $insert_data['created_date'] = datetimeformat();
            $insert_data['created_by'] = !empty($this->user_info['ID']) ? $this->user_info['ID'] : '';
            $insert_data['updated_by'] = !empty($this->user_info['ID']) ? $this->user_info['ID'] : '';
            $insert_data['updated_date'] = datetimeformat();
            $where = array('delivery_order_id' => $id);
            $success_update = $this->common_model->update(DELIVERY_ORDER, $insert_data, $where);
            //Delete DO item
            $delete_item_id = $this->input->post('delete_item_id');
            if (!empty($delete_item_id)) {
                $delete_item = substr($delete_item_id, 0, -1);
                $delete_item_id = explode(',', $delete_item);
                $where1 = array('delivery_order_id' => $id);
                $this->common_model->delete_where_in(DELIVERY_ITEM_LIST, $where1, 'do_menu_id', $delete_item_id);
                //echo $this->db->last_query();exit;
            }
            //update DO item
            $where1 = array('delivery_order_id' => $id);
            $invoice_item = $this->common_model->get_records(DELIVERY_ITEM_LIST, array('do_menu_id'), '', '', $where1, '');

            if (!empty($invoice_item)) {

                for ($i = 0; $i < count($invoice_item); $i++) {
                    # code...
                    $update_item['ingredient_id'] = ucfirst($this->input->post('item_name_' . $invoice_item[$i]['do_menu_id']));
                    $update_item['subcat_id'] = $this->input->post('subcat_name_' . $invoice_item[$i]['do_menu_id']);
                    $update_item['quantity'] = $this->input->post('qty_hours_' . $invoice_item[$i]['do_menu_id']);
                    $update_item['price'] = $this->input->post('rate_' . $invoice_item[$i]['do_menu_id']);
                    $update_item['sub_total'] = $this->input->post('cost_' . $invoice_item[$i]['do_menu_id']);
                    $where = array('do_menu_id' => $invoice_item[$i]['do_menu_id']);
                    $success_update = $this->common_model->update(DELIVERY_ITEM_LIST, $update_item, $where);
                }
            }
            $msg = $this->lang->line('delivery_order_update_msg');
            $this->session->set_flashdata('msg', "<div class='alert alert-success text-center'>$msg</div>");
        } else { //insert
            $insert_data['customer_code'] = $this->input->post('cust_code');
            $insert_data['customer_name'] = $this->input->post('cust_name');
            $insert_data['sr_number'] = $this->input->post('sr_number_installation');
            $insert_data['delivery_order'] = $this->input->post('delivery_order');
            $insert_data['order_date'] = date('Y-m-d', strtotime($this->input->post('order_date')));
            $insert_data['payment_terms'] = ''; //$this->input->post('payment_terms');
            $insert_data['caller_name'] = $this->input->post('caller_name');
            $insert_data['caller_number'] = $this->input->post('caller_number');
            $insert_data['lpo_number'] = $this->input->post('lpo_number');
            $insert_data['remarks'] = $this->input->post('remarks');
            $insert_data['delivery_location'] = $this->input->post('delivery_location');
            $insert_data['priority'] = $this->input->post('priority');
            $insert_data['order_type'] = $this->input->post('order_type');
            $insert_data['delivery_date'] = date('Y-m-d H:i:s', strtotime($this->input->post('delivery_date')));
            $insert_data['total_amount'] = $this->input->post('amount_total');
            $insert_data['created_by'] = !empty($this->user_info['ID']) ? $this->user_info['ID'] : '';
            $insert_data['updated_by'] = !empty($this->user_info['ID']) ? $this->user_info['ID'] : '';
            $insert_data['updated_date'] = datetimeformat();

            $id = $this->common_model->insert(DELIVERY_ORDER, $insert_data);

            //MAILING FUNCTION
            $this->sendDeliveryOrderMail($id);

            $msg = $this->lang->line('delivery_order_add_msg');
            $this->session->set_flashdata('msg', "<div class='alert alert-success text-center'>$msg</div>");
        }
        //Insert new item limit
        $item_name = $this->input->post('item_name');
        $subcat_name = $this->input->post('subcat_name');
        $qty_hours = $this->input->post('qty_hours');
        $rate = $this->input->post('rate');
        $cost = $this->input->post('cost');
        for ($i = 0; $i < count($item_name); $i++) {
            $item_data['delivery_order_id'] = $id;
            $item_data['ingredient_id'] = ucfirst($item_name[$i]);
            $item_data['subcat_id'] = ucfirst($subcat_name[$i]);
            $item_data['quantity'] = $qty_hours[$i];
            $item_data['price'] = $rate[$i];
            $item_data['sub_total'] = $cost[$i];
            $item_data['created_by'] = !empty($this->user_info['ID']) ? $this->user_info['ID'] : '';
            $item_data['created_date'] = datetimeformat();
            $this->common_model->insert(DELIVERY_ITEM_LIST, $item_data);
        }
        $whereCond = array('delivery_order_id' => $id);

        if ($this->input->post('removeFile')) {
            $tableName = DELIVERY_ORDER;
            $fields = array('*');
            $match = array('delivery_order_id' => $id);
            $edit_record = $this->common_model->get_records($tableName, $fields, '', '', $match, '', '', '', '', '', '', '');
            if (!empty($edit_record[0]['attachments'])) {
                unlink($this->config->item('delivery_order_upload_base_url') . 'DeliveryOrder/' . $edit_record[0]['delivery_order_id'] . '/' . $edit_record[0]['attachments']);
                $data['attachments'] = '';
                $this->common_model->update(DELIVERY_ORDER, $data, $whereCond);
            }
        }

        $upload_dir = $this->config->item('delivery_order_upload_root_url') . 'DeliveryOrder';

        if (!is_dir($upload_dir)) {
            //create directory
            mkdir($upload_dir, 0777, TRUE);
        }

        if (is_dir($upload_dir)) {
            if (!$this->uploadAttachment($id)) { // File upload function call
                $msg = $this->lang->line('error_msg');
                $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");

                //$msg = $this->lang->line('co_insert_msg');
                //$this->session->set_flashdata('msg', "<div class='alert alert-success text-center'>$msg</div>");
            }
        }

        //Upload data
        redirect('DeliveryOrder');
    }

    /*
      @Author : Ritesh rana
      @Desc   : Add record
      @Input  : Add id
      @Output : Give record
      @Date   : 20/03/2017
     */

    public function add_record() {
        $this->formValidation();
        if ($this->form_validation->run() == FALSE) {
            $data['footerJs'][0] = base_url('uploads/assets/js/bootstrap-datetimepicker.min.js');
            $data['footerJs'][1] = base_url('uploads/custom/js/deliveryorder/deliveryorder.js');

            $data['customerCodeList'] = $this->getCustomerCodeList(); // customer code list
            $data['customerNameList'] = $this->getCustomerNameList(); // customer name list
            $data['InventoryList'] = $this->getInventoryList(); // Inventory list
            //pr($data['InventoryList']);exit;
            //
            //get payment terms
            /* $table = PAYMENT_TERMS . ' as pt';
              $match = "isactive = 'active'";
              $fields = array("pt.payment_terms_id,pt.name");
              $data['payment_terms'] = $this->common_model->get_records($table, $fields, '', '', $match); */

            //get codelookup data
            /* $table = CODELOOKUP . ' as cl';
              $match = "isactive = 'active'";
              $fields = array("cl.code_id,cl.code_name");
              $data['codelookup'] = $this->common_model->get_records($table, $fields, '', '', $match);
             */
            $data['header'] = array('menu_module' => 'order_management', 'menu_child' => 'delivery_order');

            /* Start -  COllection Order Status */
            $table = CODELOOKUP;
            $fields = array('*');
            $match = array('isactive' => 'active');

            $nested = array();
            $sourceData = $this->common_model->get_records($table, $fields, '', '', $match, '', '', '', '', '', '', '');

            foreach ($sourceData as &$s) {
                if (is_null($s['parent_code_id'])) {
                    $nested[$s['code_name']] = &$s;
                } else {
                    $pid = $s['parent_code_id'] - 1;
                    if (isset($sourceData[$pid])) {

                        if (!isset($sourceData[$pid]['children'])) {
                            $sourceData[$pid]['children'] = array();
                        }
                        $sourceData[$pid]['children'][] = &$s;
                    }
                }
            }

            $data['priority'] = $nested['priority']['children'];
            //$data['priority'] = '';

            /*$data['priority'] = array(
                '1' => 'Priority 1',
                '2' => 'Priority 2',
                '3' => 'Priority 3',
            );*/

            $data['orderType'] = array(
                'email' => 'Email',
                'incomming_call' => 'Incoming Call',
                'outbound_call' => 'Outbound Call'
            );

            $data['deliveryOrderId_view'] = $this->viewname;
//        pr($data['codelookup']);exit;
            $data['validation'] = validation_errors();
            $data['deliveryOrderId'] = $this->common_model->deliveryOrder();
            $data['form_action_path'] = $this->viewname . '/add_record';
            $data['main_content'] = '/Add_DeliveryOrder';
            $this->parser->parse('layouts/DefaultTemplate', $data);
        } else {
            $this->insertdata();
        }
    }

    /*
      @Author : Ritesh Rana
      @Desc   : Edit record
      @Input  : Edit id
      @Output : Give edit record
      @Date   : 23/03/2017
     */

    public function edit_record($id = '') {
        $this->formValidation();
        if ($this->form_validation->run() == FALSE) {
            $data['footerJs'][0] = base_url('uploads/assets/js/bootstrap-datetimepicker.min.js');
            $data['footerJs'][1] = base_url('uploads/custom/js/deliveryorder/deliveryorder.js');
            //pr($id);exit;
            //Get Records From PROSPECT_MASTER Table

            $data['customerCodeList'] = $this->getCustomerCodeList(); // customer code list
            $data['customerNameList'] = $this->getCustomerNameList(); // customer name list
            $data['InventoryList'] = $this->getInventoryList(); // Inventory list

            $table = DELIVERY_ORDER . ' as do';
            $match = "delivery_order_id = " . $id;
            $fields = array("do.delivery_order_id, do.customer_code, do.customer_name , do.delivery_order, do.order_date, do.payment_terms,do.caller_name,do.caller_number, ce.contact_name, ce.contact_number,do.delivery_location,do.lpo_number,do.sr_number,do.remarks,do.delivery_date,ce.route_id,do.attachments,do.total_amount,do.created_by,do.created_date,mi.machine_serial_number,ce.mobile_number,r.name,do.priority,do.order_type");
            $join_tables = array(
                CUSTOMER_ENROLMENT . ' as ce' => 'do.customer_code = ce.customer_id',
                MACHINE_INVENTORY . ' as mi' => 'do.sr_number = mi.inventory_id',
                ROUTE . ' as r' => 'ce.route_id = r.route_id',
            );

            $edit_record = $this->common_model->get_records($table, $fields, $join_tables, 'left', $match);

            //pr($edit_record);exit;
            //Get item
            $table = DELIVERY_ITEM_LIST;
            $match = "delivery_order_id = " . $id;
            $field = array('*');
            $data['item_details'] = $this->common_model->get_records($table, $field, '', '', $match);
            //pr($data['item_details']);exit;
            $data['edit_record'] = $edit_record;

            //get customer
            $table = CUSTOMER_ENROLMENT . ' as ce';
            $match = "is_delete = '0'";
            $fields = array("ce.customer_id, ce.customer_name, ce.customer_code");
            $data['customer_info'] = $this->common_model->get_records($table, $fields, '', '', $match);


            //get codelookup data
            $table = CODELOOKUP . ' as cl';
            $match = "isactive = 'active'";
            $fields = array("cl.code_id, cl.code_name");
            $data['codelookup'] = $this->common_model->get_records($table, $fields, '', '', $match);

            //get category data
            $table = CATEGORY . ' as ct';
            $match = "ct.status = 'active' AND ct.is_deleted = 0";
            $fields = array("ct.cat_id, ct.cat_name , ct.created_by, ct.created_date, ct.status");
            $data['category_info'] = $this->common_model->get_records($table, $fields, '', '', $match);

            $cat_id = $this->input->post("category_val");
            $table = SUBCATEGORY . ' as sct';
            $match = "sct.status = 'active' AND sct.is_deleted = 0 AND sct.cat_id = $cat_id";
            $data['header'] = array('menu_module' => 'order_management', 'menu_child' => 'delivery_order');
            $fields = array("sct.subcat_id, sct.subcat_name");
            $data['subcategory_info'] = $this->common_model->get_records($table, $fields, '', '', $match);

             /* Start -  COllection Order Status */
            $table = CODELOOKUP;
            $fields = array('*');
            $match = array('isactive' => 'active');

            $nested = array();
            $sourceData = $this->common_model->get_records($table, $fields, '', '', $match, '', '', '', '', '', '', '');

            foreach ($sourceData as &$s) {
                if (is_null($s['parent_code_id'])) {
                    $nested[$s['code_name']] = &$s;
                } else {
                    $pid = $s['parent_code_id'] - 1;
                    if (isset($sourceData[$pid])) {

                        if (!isset($sourceData[$pid]['children'])) {
                            $sourceData[$pid]['children'] = array();
                        }
                        $sourceData[$pid]['children'][] = &$s;
                    }
                }
            }
            
            $data['priority'] = $nested['priority']['children'];
            
            /*$data['priority'] = array(
                '1' => 'Priority 1',
                '2' => 'Priority 2',
                '3' => 'Priority 3',
            );*/

            $data['orderType'] = array(
                'email' => 'Email',
                'incomming_call' => 'Incoming Call',
                'outbound_call' => 'Outbound Call'
            );

            $data['validation'] = validation_errors();
            $data['deliveryOrderId_view'] = $this->viewname;
            $data['form_action_path'] = $this->viewname . '/edit_record/' . $id;
            $data['main_content'] = '/Add_DeliveryOrder';
            $data['crnt_view'] = $this->viewname;
            $this->parser->parse('layouts/DefaultTemplate', $data);
        } else {

            $this->insertdata();
        }
    }

    /*
      @Author : Ritesh Rana
      @Desc   : get category data
      @Input  :
      @Output :
      @Date   : 23/03/2017
     */

    function category_data() {
        $table = CATEGORY . ' as ct';
        $match = "ct.status = 'active' AND ct.is_deleted = 0";
        $fields = array("ct.cat_id, ct.cat_name , ct.created_by, ct.created_date, ct.status");
        $data['category_info'] = $this->common_model->get_records($table, $fields, '', '', $match);
        echo json_encode($data);
    }

    /*
      @Author : Ritesh Rana
      @Desc   : get subcategory data
      @Input  :
      @Output :
      @Date   : 23/03/2017
     */

    function subcategory_data() {
        $cat_id = $this->input->post("category_val");
        $table = SUBCATEGORY . ' as sct';
        $match = "sct.status = 'active' AND sct.is_deleted = 0 AND sct.cat_id = $cat_id";
        $fields = array("sct.subcat_id, sct.subcat_name");
        $data['subcategory_info'] = $this->common_model->get_records($table, $fields, '', '', $match);
        echo json_encode($data);
    }

    /*
      @Author : Ritesh Rana
      @Desc   : get subcategory all data
      @Input  :
      @Output :
      @Date   : 23/03/2017
     */

    function subcategory_all_data() {
        $subcat_id = $this->input->post("subcategory_val");
        $table = SUBCATEGORY . ' as sct';
        $match = "sct.status = 'active' AND sct.is_deleted = 0 AND sct.subcat_id = $subcat_id";
        $fields = array("sct.subcat_id, sct.subcat_name,sct.price");
        $subcategory_all_info = $this->common_model->get_records($table, $fields, '', '', $match);
        $price = $subcategory_all_info[0]['price'];
        echo json_encode(array('price' => $price));
        die();
    }

    /*
      @Author : Ritesh Rana
      @Desc   : get  customer data
      @Input  :
      @Output :
      @Date   : 23/03/2017
     */

    function customerData() {
        $customer_id = $this->input->post('customer_id');
        $table = CUSTOMER_ENROLMENT . ' as ce';
        $match = "ce.is_delete = '0' AND ce.customer_id = $customer_id";

        $fields = array("ce.customer_id,ce.customer_name,ce.contact_name,ce.contact_number,ce.customer_code ,ce.location,ce.email");
        $data['customer_info'] = $this->common_model->get_records($table, $fields, '', '', $match);


        // pr($data['customer_info']);exit;
        //echo $this->db->last_query();exit;
        $this->load->view($this->viewname . '/CustomerDetail', $data);
    }

    /*
      @Author : Ritesh Rana
      @Desc   : get customer data
      @Input  :
      @Output :
      @Date   : 23/03/2017
     */

    function customerDetail() {
        $customer_id = $this->input->post('customer_id');
        $table = CUSTOMER_ENROLMENT . ' as ce';
        $match = "ce.is_delete = '0' AND ce.customer_id = $customer_id";
        $fields = array("ce.customer_id,ce.customer_name,ce.contact_name,ce.contact_number,ce.customer_code ,ce.location,ce.route_id,ce.sales_representative");
        $customer_info = $this->common_model->get_records($table, $fields, '', '', $match);
        //echo $this->db->last_query();exit;
        $contact_name = $customer_info[0]['contact_name'];
        $contact_number = $customer_info[0]['contact_number'];
        $route_id = $customer_info[0]['route_id'];
        $location = $customer_info[0]['location'];
        $sales_representative = $customer_info[0]['sales_representative'];

        echo json_encode(array('contact_name' => $contact_name, 'contact_number' => $contact_number, 'route_id' => $route_id, 'location' => $location, 'sales_representative' => $sales_representative));
        die();
    }

    /*
      @Author : Ritesh Rana
      @Desc   : form validation
      @Input  :
      @Output :
      @Date   : 23/03/2017
     */

    public function formValidation($id = null) {
        $this->form_validation->set_rules('cust_code', 'Customer Code', 'trim|required|xss_clean');
        $this->form_validation->set_rules('cust_name', 'Customer Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('sr_number_installation', 'Serial Number', 'trim|required|xss_clean');
        $this->form_validation->set_rules('delivery_order', 'Delivery Order', 'trim|required|xss_clean');
        $this->form_validation->set_rules('order_date', 'order date', 'trim|required|xss_clean');
        //$this->form_validation->set_rules('payment_terms', 'Payment Terms', 'trim|required|xss_clean');
        $this->form_validation->set_rules('caller_name', 'caller name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('caller_number', 'Caller Number', 'trim|required|xss_clean');
        $this->form_validation->set_rules('lpo_number', 'Lpo Number', 'trim|required|xss_clean');
        $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required|xss_clean');
        $this->form_validation->set_rules('delivery_location', 'Delivery Location', 'trim|required|xss_clean');
        $this->form_validation->set_rules('priority', 'priority', 'trim|required|xss_clean');
        $this->form_validation->set_rules('order_type', 'Order Type', 'trim|required|xss_clean');
        $this->form_validation->set_rules('delivery_date', 'Delivery Date', 'trim|required|xss_clean');
    }

    /*
      @Author : Ritesh rana
      @Desc   : download attachment function
      @Input    :
      @Output   :
      @Date   : 24/03/2017
     */

    function download($id) {
        if (!empty($id)) {
            $params['fields'] = ['*'];
            $params['table'] = DELIVERY_ORDER . ' as do';
            $params['match_and'] = 'do.delivery_order_id =' . $id . '';
            $task_files = $this->common_model->get_records_array($params);
            if (count($task_files) > 0) {
                $pth = file_get_contents(base_url($this->config->item('delivery_order_upload_root_url') . 'DeliveryOrder' . '/' . $task_files[0]['attachments']));
                $this->load->helper('download');
                force_download($task_files[0]['file_name'], $pth);
            }
            redirect($this->module . '/Invoices');
        }
    }

    /*
      @Author : Ritesh Rana
      @Desc   : delete delivery order
      @Input  :
      @Output :
      @Date   : 23/03/2017
     */

    public function deletedata($id) {
        //Delete Record From Database
        if (!empty($id)) {
            $data = array('is_deleted' => 1);
            $where = array('delivery_order_id' => $id);
            if ($this->common_model->update(DELIVERY_ORDER, $data, $where)) {
                $msg = $this->lang->line('delivery_order_delete_msg');
                $this->session->set_flashdata('msg', "<div class='alert alert-success text-center'>$msg</div>");
                unset($id);
            } else {
                // error
                $msg = $this->lang->line('error_msg');
                $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");
            }
        }
        redirect('DeliveryOrder');
    }

    public function lastDeliveryList() {

        $data['main_content'] = '/DeliveryList';
        $this->parser->parse('layouts/DefaultTemplate', $data);
    }

    /*
      @Author : Ritesh Rana
      @Desc   : get Customer code
      @Input 	:
      @Output	:
      @Date   : 25rd May 2017
     */

    public function getCustomerCodeList() {

        $customerCode = html_entity_decode(trim(addslashes($this->input->post('selCustomerCode'))));
        //echo $customerCode; exit;

        $tableName = CUSTOMER_MACHINE_INFORMATION . ' as cmi';
        $fields = array('ce.customer_name,ce.customer_id,ce.customer_code ');
        $join_tables = array(
            CUSTOMER_ENROLMENT . ' as ce' => 'cmi.customer_id = ce.customer_id',
        );
        $where_search = '';
        if (!empty($customerCode)) {
            $where_search = '(ce.customer_code  LIKE "%' . $customerCode . '%" )';
        }
        $whereCond = array('ce.is_delete' => '0');
        $where_not_in = array('cmi.sr_number_id' => '0', 'cmi.machine_assign_type ' => 'Pullout');
        $group_by = array('ce.customer_code');
        $data['customerCodeRecords'] = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', '', '', '', '', $group_by, $where_search, '', '', '', '', $where_not_in);
        //print_r($data['customerCodeRecords']);
        return $data['customerCodeRecords'];
    }

    /*
      @Author : Ritesh Rana
      @Desc   : get Customer name
      @Input 	:
      @Output	:
      @Date   : 25rd May 2017
     */

    public function getCustomerNameList() {

        $customerCode = html_entity_decode(trim(addslashes($this->input->post('selCustomerCode'))));
        //echo $customerCode; exit;

        $tableName = CUSTOMER_MACHINE_INFORMATION . ' as cmi';
        $fields = array('ce.customer_name,ce.customer_id,ce.customer_code ');
        $join_tables = array(
            CUSTOMER_ENROLMENT . ' as ce' => 'cmi.customer_id = ce.customer_id',
        );
        $where_search = '';
        if (!empty($customerCode)) {
            $where_search = '(ce.customer_code  LIKE "%' . $customerCode . '%" )';
        }
        $whereCond = array('ce.is_delete' => '0');
        $where_not_in = array('cmi.sr_number_id' => '0', 'cmi.machine_assign_type ' => 'Pullout');
        $group_by = array('ce.customer_name');
        $data['customerNameRecords'] = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', '', '', '', '', $group_by, $where_search, '', '', '', '', $where_not_in);
        return $data['customerNameRecords'];
    }

    /*
      @Author : Ritesh Rana
      @Desc   : get Customer name
      @Input 	:
      @Output	:
      @Date   : 25rd May 2017
     */

    public function getInventoryList() {
        $customerCode = html_entity_decode(trim(addslashes($this->input->post('selCustomerCode'))));
        //echo $customerCode; exit;

        $tableName = CUSTOMER_MACHINE_INFORMATION . ' as cmi';
        $fields = array('ce.customer_name,ce.customer_id,ce.customer_code,mi.machine_serial_number,mi.inventory_id');
        $join_tables = array(
            CUSTOMER_ENROLMENT . ' as ce' => 'cmi.customer_id = ce.customer_id',
            MACHINE_INVENTORY . ' as mi' => 'cmi.sr_number_id = mi.inventory_id',
        );
        $where_search = '';
        if (!empty($customerCode)) {
            $where_search = '(ce.customer_code  LIKE "%' . $customerCode . '%" )';
        }
        $whereCond = array('ce.is_delete' => '0');
        $where_not_in = array('cmi.sr_number_id' => '0', 'cmi.machine_assign_type ' => 'Pullout');
        $group_by = array('cmi.sr_number_id');
        $data['customerInventoryList'] = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', '', '', '', '', $group_by, $where_search, '', '', '', '', $where_not_in);

        return $data['customerInventoryList'];
    }

    /*
      @Author : Maitrak Modi
      @Desc   : get Macthed Customer code list
      @Input 	:
      @Output	:
      @Date   : 22nd March 2017
     */

    public function getCustomerDetails() {

        $selCustomerCode = $this->input->post('selCustomerCode'); // query data
        $selType = $this->input->post('selType'); // query data

         /* Query */
        $tableName = CUSTOMER_MACHINE_INFORMATION . ' as cmi';
        $fields = array('cmi.customer_id as cId, cmi.sr_number_id, cmi.zone,
            ce.customer_id, ce.customer_name, ce.customer_code, ce.location, ce.mobile_number, ce.email,ce.contact_name,ce.contact_number,
            mi.inventory_id, mi.machine_serial_number, mi.machine_id, mi.asset,
            r.name as route_name,
            pt.name, pt.description
            ');

        $join_tables = array(
            CUSTOMER_ENROLMENT . ' as ce' => 'cmi.customer_id = ce.customer_id',
            MACHINE_INVENTORY . ' as mi' => 'cmi.sr_number_id = mi.inventory_id',
            ROUTE . ' as r' => 'ce.route_id = r.route_id',
            PAYMENT_TERMS . ' as pt' => 'ce.payment_terms_id = pt.payment_terms_id',
        );

        if ($selType == 'sr_number') {
            $whereCond = array('cmi.sr_number_id' => $selCustomerCode, 'ce.is_delete' => '0', 'mi.is_delete' => '0');
        } else {
            $whereCond = array('ce.customer_id' => $selCustomerCode, 'ce.is_delete' => '0', 'mi.is_delete' => '0');
        }

        $data['customerDetails'] = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', '', '', '', '', '', '');

        $json_customer_details = array();

        if (!empty($data['customerDetails'])) {

            foreach ($data['customerDetails'] as $customerDetails) {

                $json_customer_details = array(
                    'customer_id' => $customerDetails['cId'],
                    'customer_name' => $customerDetails['customer_name'],
                    'customer_mobile_number' => $customerDetails['mobile_number'],
                    'customer_location' => $customerDetails['location'],
                    'machine_sr_id' => $customerDetails['sr_number_id'],
                    'serial_number' => $customerDetails['machine_serial_number'],
                    // 'zone_name' => $customerDetails['zone_name'],
                    'machine_id' => $customerDetails['machine_id'],
                    'asset' => $customerDetails['asset'],
                    'assigned_to' => $customerDetails['zone'],
                    'customer_email' => $customerDetails['email'],
                    'customer_route_name' => $customerDetails['route_name'],
                    'contact_name' => $customerDetails['contact_name'],
                    'contact_number' => $customerDetails['contact_number'],
                    'payment_terms' => (!empty($customerDetails['name'])) ? $customerDetails['name'] . ' - ' . $customerDetails['description'] : $this->lang->line('NA'),
                );
            }
        }

        
        // Query
        /*$tableName = CUSTOMER_ENROLMENT . ' as ce';
        $fields = array('ce.customer_id, ce.customer_name, ce.customer_code, 
                        ce.mobile_number,ce.contact_name,ce.contact_number, ce.location, ce.email,
                        r.name as route_name,
                        pt.name, pt.description
                    ');

        $join_tables = array(
            ROUTE . ' as r' => 'ce.route_id = r.route_id',
            PAYMENT_TERMS . ' as pt' => 'ce.payment_terms_id = pt.payment_terms_id',
        );

        if ($selType == 'code') {
            $whereCond = array('ce.customer_code' => $selCustomerCode, 'ce.is_delete' => '0');
        }
        if ($selType == 'name') {
            $whereCond = array('ce.customer_id' => $selCustomerCode, 'ce.is_delete' => '0');
        }


        $data['customerDetails'] = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', '', '', '', '', '', '');
        //echo $this->db->last_query(); exit;
        //pr($data['customerDetails']);
        // exit;

        $json_customer_details = array();

        if (!empty($data['customerDetails'])) {

            foreach ($data['customerDetails'] as $customerDetails) {

                $json_customer_details = array(
                    'customer_id' => $customerDetails['customer_id'],
                    'customer_name' => $customerDetails['customer_name'],
                    'customer_code' => $customerDetails['customer_code'],
                    'customer_mobile_number' => $customerDetails['mobile_number'],
                    'customer_location' => $customerDetails['location'],
                    'customer_email' => $customerDetails['email'],
                    'customer_route_name' => $customerDetails['route_name'],
                    'contact_name' => $customerDetails['contact_name'],
                    'contact_number' => $customerDetails['contact_number'],
                    'payment_terms' => (!empty($customerDetails['name'])) ? $customerDetails['name'] . ' - ' . $customerDetails['description'] : $this->lang->line('NA'),
                );
            }
        }*/
        echo json_encode($json_customer_details);
    }

    /*
      @Author : Maitrak Modi
      @Desc   : get pop up data
      @Input 	:
      @Output	:
      @Date   : 23rd May 2017
     */

    public function getPopUpData() {

        $selectedCustomerName = $this->input->post('selectedCustomerName'); // query data

        /* Query */
        $tableName = CUSTOMER_ENROLMENT . ' as ce';
        $fields = array('ce.customer_id, ce.customer_name, ce.customer_code, ce.location, em.name as emirate_name');

        $join_tables = array(
            CUSTOMER_MACHINE_INFORMATION . ' as cmi' => 'cmi.customer_id = ce.customer_id',
            EMIRATE . ' as em' => 'ce.emirates_id = em.emirate_id'
        );

        $whereCond = array('ce.customer_name' => $selectedCustomerName, 'ce.is_delete' => '0');

        $where_not_in = array('cmi.sr_number_id' => '0', 'cmi.machine_assign_type ' => 'Pullout');

        $data['customerInfo'] = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', '', '', '', '', '', '', '', '', '', '', $where_not_in);

        $this->load->view($this->viewname . '/CustomerPopUpInfo', $data);
    }

    /*
      @Author : Maitrak Modi
      @Desc   : Machine Inventory get Selected Version data
      @Input  :
      @Output :
      @Date   : 22nd May 2017
     */

    public function getSelectedInventoryData() {

        $selCustomerId = trim($this->input->post('selCustomerId'));

        if (!empty($selCustomerId)) {

            $tableName = CUSTOMER_MACHINE_INFORMATION . ' as cmi';
            $fields = array('ce.customer_name,ce.customer_id,ce.customer_code,mi.machine_serial_number,mi.inventory_id');
            $join_tables = array(
                CUSTOMER_ENROLMENT . ' as ce' => 'cmi.customer_id = ce.customer_id',
                MACHINE_INVENTORY . ' as mi' => 'cmi.sr_number_id = mi.inventory_id',
            );
            $where_search = '';
            if (!empty($selCustomerId)) {
                $where_search = '(ce.customer_id  LIKE "%' . $selCustomerId . '%" )';
            }
            $whereCond = array('ce.is_delete' => '0');
            $where_not_in = array('cmi.sr_number_id' => '0');
            $srNumberList = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', '', '', '', '', '', $where_search, '', '', '', '', $where_not_in);

            if (!empty($srNumberList)) {
                foreach ($srNumberList as $sr_number_value) {
                    $sr_number_drpdwn = $sr_number_value['inventory_id'];
                }
            }
        }

        $returnData = array(
            'srDrpDwnData' => $sr_number_drpdwn
        );
        echo json_encode($returnData);
    }

    /*
      @Author : Ritesh Rana
      @Desc   : get Macthed Customer code list
      @Input 	:
      @Output	:
      @Date   : 25nd March 2017
     */

    public function getInvontoryByCustomerDetails() {

        $srnumber = $this->input->post('SrNumber'); // query data

        /* Query */

        $tableName = CUSTOMER_MACHINE_INFORMATION . ' as cmi';
        $fields = array('ce.customer_id, ce.customer_name, ce.customer_code, 
                        ce.mobile_number,ce.contact_name,ce.contact_number, ce.location, ce.email,
                        r.name as route_name,
                        pt.name, pt.description');

        $join_tables = array(
            CUSTOMER_ENROLMENT . ' as ce' => 'cmi.customer_id = ce.customer_id',
            ROUTE . ' as r' => 'ce.route_id = r.route_id',
            PAYMENT_TERMS . ' as pt' => 'ce.payment_terms_id = pt.payment_terms_id',
        );
        $where_search = '';
        if (!empty($srnumber)) {
            $where_search = '(cmi.sr_number_id  LIKE "%' . $srnumber . '%" )';
        }
        $whereCond = array('ce.is_delete' => '0');
        $where_not_in = array('cmi.sr_number_id' => '0');
        $data['customerDetails'] = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', '', '', '', '', '', $where_search, '', '', '', '', $where_not_in);

        //echo $this->db->last_query(); exit;
        //pr($data['customerDetails']);
        // exit;

        $json_customer_details = array();

        if (!empty($data['customerDetails'])) {

            foreach ($data['customerDetails'] as $customerDetails) {

                $json_customer_details = array(
                    'customer_id' => $customerDetails['customer_id'],
                    'customer_name' => $customerDetails['customer_name'],
                    'customer_code' => $customerDetails['customer_code'],
                    'customer_mobile_number' => $customerDetails['mobile_number'],
                    'customer_location' => $customerDetails['location'],
                    'customer_email' => $customerDetails['email'],
                    'customer_route_name' => $customerDetails['route_name'],
                    'contact_name' => $customerDetails['contact_name'],
                    'contact_number' => $customerDetails['contact_number'],
                    'payment_terms' => (!empty($customerDetails['name'])) ? $customerDetails['name'] . ' - ' . $customerDetails['description'] : $this->lang->line('NA'),
                );
            }
        }
        echo json_encode($json_customer_details);
    }

    /*
      @Author : Mehul Patel
      @Desc   : Get Last Five Delivery Order List
      @Input 	:
      @Output	:
      @Date   : 31st May 2017
     */

    function viewLastFiveDeliveryOrderList($customer_id) {

        $table = DELIVERY_ORDER . '  as deliveryorder ';
        $fields = array('deliveryorder.delivery_order as order_id,deliveryorder.order_date as order_date,deliveryorder.remarks');
        $where = array('deliveryorder.customer_code' => $customer_id);
        $data['orderLists'] = $this->common_model->get_records($table, $fields, '', '', $where, '', '', '', '', '', '', '', '', '', '', '', '');
        $data['agent_name'] = $this->session->userdata['LOGGED_IN']['FIRSTNAME'] . " " . $this->session->userdata['LOGGED_IN']['LASTNAME'];
        $data['crnt_view'] = $this->viewname;
        $data['main_content'] = '/LastDeliveryOrderAjaxList';
        $this->parser->parse('layouts/DefaultTemplate', $data);
    }

    /*
      @Author : Mehul Patel
      @Desc   : Upload Attachment
      @Input  :
      @Output :
      @Date   : 31st May 2017
     */

    public function uploadAttachment($deliveryOrderId) {

        /* Start - Upload Attachment File */
        $uploadCoDir = $this->config->item('delivery_order_upload_root_url') . 'DeliveryOrder';
        $uploadCoUploadDirPath = $uploadCoDir . '/' . $deliveryOrderId;
        //echo $uploadCoUploadDirPath; exit;

        if (!is_dir($uploadCoDir)) {

            mkdir($uploadCoDir, 0777, TRUE); //create directory

            chmod($uploadCoDir, 0777);
        }

        if (!is_dir($uploadCoUploadDirPath)) {
            mkdir($uploadCoUploadDirPath, 0777, TRUE); //create directory

            chmod($uploadCoUploadDirPath, 0777);
        }

        if (is_dir($uploadCoDir) && is_dir($uploadCoUploadDirPath)) {
            //pr($_FILES); exit;

            if (!empty($_FILES['attachments']['name'])) {

                //$no_of_files = 1;
                //$upload_size = '';
                //$upload_type = 'doc|docx|pdf|xls|xlsx'; // Allow file type
                $redirect = $this->viewname;

                //Upload Attchment
                $uploadedFileData = uploadImage('attachments', $uploadCoUploadDirPath, $redirect);
                //pr($uploadedFileData); exit;
                if (!empty($uploadedFileData)) {
                    $updateData['attachments'] = $uploadedFileData[0]['file_name'];
                }
                $where = array('delivery_order_id' => $deliveryOrderId);

                if (!$this->common_model->update(DELIVERY_ORDER, $updateData, $where)) {
                    return false;
                }
            }
        }
        /* End - Upload Attachment File */
        return true;
    }

    /*
      @Author : Maitrak Modi
      @Desc   : send mail of delivery order
      @Input  : $collectionOrderId
      @Output : return true or false
      @Date   : 4th July 2017
     */

    protected function sendDeliveryOrderMail($deliveryOrderId) {

        $getDeliveryOrderData = $this->getDelieryOrderMailDetail($deliveryOrderId); // get details

        if (!empty($getDeliveryOrderData)) {

            $find = array(
                '{CUSTOMER_NAME}',
                '{ADDRESS}',
                '{CUSTOMER_CODE}',
                '{CALLER_PERSON}',
                '{CALLER_NUMBER}',
                '{DO_ADDRESS}',
                '{LPO_NUMBER}',
                '{SALES_REPRESENTATIVE}',
                '{DO_DATE}',
                '{DO_TOTAL_AMOUNT}',
            );

            $replace = array(
                'CUSTOMER_NAME' => $getDeliveryOrderData['customer_name'],
                'ADDRESS' => $getDeliveryOrderData['location'],
                'CUSTOMER_CODE' => $getDeliveryOrderData['customer_code'],
                'CALLER_PERSON' => $getDeliveryOrderData['caller_name'],
                'CALLER_NUMBER' => $getDeliveryOrderData['caller_number'],
                'DO_ADDRESS' => $getDeliveryOrderData['delivery_location'],
                'LPO_NUMBER' => $getDeliveryOrderData['lpo_number'],
                'SALES_REPRESENTATIVE' => $this->session->userdata['LOGGED_IN']['FIRSTNAME'],
                'DO_DATE' => $getDeliveryOrderData['delivery_date'],
                'DO_TOTAL_AMOUNT' => $getDeliveryOrderData['total_amount'],
            );

            $to = $this->config->item('do_email_id'); // Set Email id in config

            $message = '<p> Hello, </p>';
            $message .= '<p><b>Find New Delivery Order Details.</b></p>';
            $message .= '<p></p>';
            $message .= '<table border="1">'
                    . '<tr><td><b>Customer Name :</b></td><td>{CUSTOMER_NAME}</td></tr>'
                    . '<tr><td><b>Customer Code :</b></td><td>{CUSTOMER_CODE}</td></tr>'
                    . '<tr><td><b>Customer Address :</b></td><td>{ADDRESS}</td></tr>'
                    . '<tr><td><b>Caller Name :</b></td><td>{CALLER_PERSON}</td></tr>'
                    . '<tr><td><b>Caller Number :</b></td><td>{CALLER_NUMBER}</td></tr>'
                    . '<tr><td><b>Delivery Order Address :</b></td><td>{DO_ADDRESS}</td></tr>'
                    . '<tr><td><b>LPO Number(if any) :</b></td><td>{LPO_NUMBER}</td></tr>'
                    . '<tr><td><b>Sales Representative :</b></td><td>{SALES_REPRESENTATIVE}</td></tr>'
                    . '<tr><td><b>Delivery Order Date Time :</b></td><td>{DO_DATE}</td></tr>'
                    . '<tr><td><b>Delivery Order Total Amount :</b></td><td>{DO_TOTAL_AMOUNT}</td></tr>';
            $message .= '</table>';

            $subject = 'New Delivery Order has been placed on dated - ' . date('Y-m-d H:i:s');

            $message .= '<p> </p>';
            $message .= '<p>Thank You,</p>';
            $message .= '<p><b><i>Nestle Team<i><b></p>';

            $finalEmailBody = str_replace($find, $replace, $message);

            //echo $finalEmailBody; exit;
            return send_mail($to, $subject, $finalEmailBody, $attach = NULL);
        }
    }

    /*
      @Author : Maitrak Modi
      @Desc   : get Delivery order details
      @Input  : $deliveryOrderId
      @Output : return delivery order details
      @Date   : 4th July 2017
     */

    protected function getDelieryOrderMailDetail($deliveryOrderId) {

        $tableName = DELIVERY_ORDER . ' as do';

        $fields = array('do.caller_name, do.caller_number, do.delivery_location, do.lpo_number, do.delivery_date, do.total_amount,
                        ce.customer_code, ce.customer_name, ce.location, ce.contact_number, ce.contact_name');
        $match = array('do.delivery_order_id' => $deliveryOrderId);

        $join_tables = array(
            CUSTOMER_ENROLMENT . ' as ce' => 'do.customer_code = ce.customer_id',
        );
        $data['editDeliveryOrderRecord'] = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $match, '', '', '', '', '', '', '');

        //pr($data['editDeliveryOrderRecord']);
        //exit;
        return $data['editDeliveryOrderRecord'][0];
    }

}
