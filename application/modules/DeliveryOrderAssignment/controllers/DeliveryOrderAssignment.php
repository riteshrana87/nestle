<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class DeliveryOrderAssignment extends CI_Controller {

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
      @Desc   : DeliveryOrderAssignment index
      @Input  :
      @Output :
      @Date   : 28/03/2017
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
            $this->session->unset_userdata('deliveryorderassignment_data');
        }
        $searchsort_session = $this->session->userdata('deliveryorderassignment_data');
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
        $fields = array("do.customer_code, do.sr_number, do.delivery_order_id, do.delivery_order, do.order_date, ce.contact_name, ce.contact_number, do.total_amount, do.payment_terms, do.delivery_status, do.delivery_date,"
            . "ce.customer_name, mi.machine_serial_number,"
            . "cl.code_name as d_status");
        $join_tables = array(
            CUSTOMER_ENROLMENT . ' as ce' => 'ce.customer_id=do.customer_code',
            MACHINE_INVENTORY . ' as mi' => 'do.sr_number = mi.inventory_id',
            CODELOOKUP . ' as cl' => 'do.delivery_status = cl.code_id',
        );


        if (!empty($searchtext)) {
            $searchtext = html_entity_decode(trim(addslashes($searchtext)));
            $match = '';
            $where_search = '((ce.customer_name LIKE "%' . $searchtext . '%" '
                    . 'OR do.order_date LIKE "%' . date("Y-m-d", strtotime($searchtext)) . '%" '
                    . 'OR do.total_amount LIKE "%' . $searchtext . '%" '
                    . 'OR ce.contact_name LIKE "%' . $searchtext . '%" '
                    . 'OR ce.contact_number LIKE "%' . $searchtext . '%" '
                    . 'OR mi.machine_serial_number LIKE "%' . $searchtext . '%" '
                    . 'OR do.delivery_status LIKE "%' . $searchtext . '%"'
                    . 'OR DATE_FORMAT(do.delivery_date,"%Y-%m-%d") LIKE "%' . $searchtext . '%"'
                    . ')'
                    . 'AND do.is_deleted = "0")';
            $data['information'] = $this->common_model->get_records($table, $fields, $join_tables, 'left', '', $match, $config['per_page'], $uri_segment, $sortfield, $sortby, '', $where_search);
//echo($this->db->last_query());exit;
            $config['total_rows'] = $this->common_model->get_records($table, $fields, $join_tables, 'left', '', $match, '', '', $sortfield, $sortby, '', $where_search, '', '', '1');
        } else {
            $data['information'] = $this->common_model->get_records($table, $fields, $join_tables, 'left', '', '', $config['per_page'], $uri_segment, $sortfield, $sortby, '', $where);
            $config['total_rows'] = $this->common_model->get_records($table, $fields, $join_tables, 'left', '', '', '', '', $sortfield, $sortby, '', $where, '', '', '1');
        }
//pr($data['information']);exit;
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
        $this->session->set_userdata('deliveryorderassignment_data', $sortsearchpage_data);
        setActiveSession('deliveryorderassignment_data'); // set current Session active

        $data['header'] = array('menu_module' => 'order_assignment', 'menu_child' => 'delivery_order_assignment');
        $data['crnt_view'] = $this->viewname;
        $data['footerJs'][0] = base_url('uploads/assets/js/bootstrap-datetimepicker.min.js');
        $data['footerJs'][1] = base_url('uploads/custom/js/DeliveryOrderAssignment/DeliveryOrderAssignment.js');
        if ($this->input->post('result_type') == 'ajax') {
            $this->load->view($this->viewname . '/DeliveryOrderAssignmentAjaxList', $data);
        } else {
            $data['main_content'] = '/DeliveryOrderAssignment';
            $this->parser->parse('layouts/DefaultTemplate', $data);
        }
    }

    /*
      @Author : Ritesh Rana
      @Desc   : Insert data
      @Input  : Post data
      @Output : Insert
      @Date   : 28/03/2017
     */

    public function insertdata() {
        if ($this->input->post('delivery_order_id')) {
            $id = $invoice_id = $this->input->post('delivery_order_id');
        }
        /**
         * SOFT DELETION CODE STARTS Ritesh rana
         */
        if (!empty($id)) { //update
            $insert_data['zone'] = $this->input->post('zone');
            $insert_data['delivery_date'] = date('Y-m-d H:i:s', strtotime($this->input->post('delivery_date')));
            $insert_data['delivery_status'] = $this->input->post('delivery_status');

            $insert_data['updated_by'] = !empty($this->user_info['ID']) ? $this->user_info['ID'] : '';
            $insert_data['updated_date'] = datetimeformat();
            //  pr($insert_data);exit;
            $where = array('delivery_order_id' => $id);
            $success_update = $this->common_model->update(DELIVERY_ORDER, $insert_data, $where);

            $msg = $this->lang->line('delivery_order_update_msg');
            $this->session->set_flashdata('msg', "<div class='alert alert-success text-center'>$msg</div>");
        }

        redirect('DeliveryOrderAssignment');
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
            $data['footerJs'][1] = base_url('uploads/custom/js/DeliveryOrderAssignment/DeliveryOrderAssignment.js');

            $tableName = LOGIN . ' as l';
            $zoneFields = array('l.login_id as id, l.firstname as name, l.role_id, rm.role_name');
            $whereCond = array('l.status' => 'active', 'l.is_delete' => 0, 'rm.is_delete' => 0, 'rm.role_slug' => 'zone', 'rm.status' => '1'); // zone slug

            $join_tables = array(
                ROLE_MASTER . ' as rm' => 'l.role_id = rm.role_id',
            );
            $data['zoneList'] = $this->common_model->get_records($tableName, $zoneFields, $join_tables, 'left', $whereCond, '', '', '', '', '', '', '');

            //Get Records From PROSPECT_MASTER Table

            $data['customerCodeList'] = $this->getCustomerCodeList(); // customer code list
            $data['customerNameList'] = $this->getCustomerNameList(); // customer name list
            $data['InventoryList'] = $this->getInventoryList(); // Inventory list

            $table = DELIVERY_ORDER . ' as do';
            $match = "delivery_order_id = " . $id;
            $fields = array("do.delivery_order_id, do.customer_code, 
                ce.customer_code as cust_code, ce.customer_name, ce.location as customer_location, ce.email,
                do.delivery_order, do.order_date, do.caller_name, do.caller_number, 
                ce.contact_name, ce.contact_number, do.delivery_location, do.lpo_number,
                do.sr_number, do.remarks, do.delivery_date, ce.route_id, do.attachments, do.total_amount,
                do.created_by, do.created_date, mi.machine_serial_number, ce.mobile_number, r.name, do.priority, do.order_type,
                do.zone,
                do.delivery_status,
                pt.name as payment_terms_name, pt.description
                ");

            $join_tables = array(
                CUSTOMER_ENROLMENT . ' as ce' => 'do.customer_code = ce.customer_id',
                MACHINE_INVENTORY . ' as mi' => 'do.sr_number = mi.inventory_id',
                ROUTE . ' as r' => 'ce.route_id = r.route_id',
                PAYMENT_TERMS . ' as pt' => 'ce.payment_terms_id = pt.payment_terms_id',
            );

            $data['edit_record'] = $this->common_model->get_records($table, $fields, $join_tables, 'left', $match);
            // pr($data['edit_record']);
            // exit;
            //Get item
            $table = DELIVERY_ITEM_LIST;
            $match = "delivery_order_id = " . $id;
            $field = array('*');
            $data['item_details'] = $this->common_model->get_records($table, $field, '', '', $match);
            //pr($data['item_details']);exit;
            //get customer

            $table = CODELOOKUP;
            $fields = array('*');
            $match = array('isactive' => 'active');

            /* Start - Set Parent Child Array */
            $nested = array();
            $sourceData = $this->common_model->get_records($table, $fields, '', '', $match, '', '', '', '', '', '', '');
            // echo $this->db->last_query(); exit;
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

            $data['deliveryOrderList'] = $nested['delivery_order_status']['children']; // Trading type list
            //
            //get category data
            $table = CATEGORY . ' as ct';
            $match = "ct.status = 'active' AND ct.is_deleted = 0";
            $fields = array("ct.cat_id, ct.cat_name , ct.created_by, ct.created_date, ct.status");
            $data['category_info'] = $this->common_model->get_records($table, $fields, '', '', $match);

            $cat_id = $this->input->post("category_val");
            $table = SUBCATEGORY . ' as sct';
            $match = "sct.status = 'active' AND sct.is_deleted = 0 AND sct.cat_id = $cat_id";
            $fields = array("sct.subcat_id, sct.subcat_name");
            $data['subcategory_info'] = $this->common_model->get_records($table, $fields, '', '', $match);

            $data['header'] = array('menu_module' => 'order_assignment', 'menu_child' => 'delivery_order_assignment');

            $data['validation'] = validation_errors();

            $data['deliveryOrderId_view'] = $this->viewname;
            $data['form_action_path'] = $this->viewname . '/edit_record/' . $id;
            $data['main_content'] = '/AddDeliveryOrderAssignment';
            $this->parser->parse('layouts/DefaultTemplate', $data);
        } else {

            $this->insertdata();
        }
    }

    /*
      @Author : Ritesh rana
      @Desc   : category data
      @Input    :
      @Output   :
      @Date   : 24/03/2017
     */

    function category_data() {
        $table = CATEGORY . ' as ct';
        $match = "ct.status = 'active' AND ct.is_deleted = 0";
        $fields = array("ct.cat_id, ct.cat_name , ct.created_by, ct.created_date, ct.status");
        $data['category_info'] = $this->common_model->get_records($table, $fields, '', '', $match);
        echo json_encode($data);
    }

    /*
      @Author : Ritesh rana
      @Desc   : get subcategory data
      @Input    :
      @Output   :
      @Date   : 24/03/2017
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
      @Author : Ritesh rana
      @Desc   : get all subcategory data
      @Input    :
      @Output   :
      @Date   : 24/03/2017
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
      @Author : Ritesh rana
      @Desc   : get customer data
      @Input    :
      @Output   :
      @Date   : 24/03/2017
     */

    function customerData() {
        $customer_id = $this->input->post('customer_id');
        $table = CUSTOMER_ENROLMENT . ' as ce';
        $match = "ce.is_delete = '0' AND ce.customer_id = $customer_id";
        $fields = array("ce.customer_id,ce.customer_name,ce.contact_name,ce.contact_number,ce.customer_code ,ce.location");
        $data['customer_info'] = $this->common_model->get_records($table, $fields, '', '', $match);
        //echo $this->db->last_query();exit;
        $this->load->view($this->viewname . '/CustomerDetail', $data);
    }

    /*
      @Author : Ritesh rana
      @Desc   : get customer detail
      @Input    :
      @Output   :
      @Date   : 24/03/2017
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
      @Author : Ritesh rana
      @Desc   : form validation
      @Input    :
      @Output   :
      @Date   : 24/03/2017
     */

    public function formValidation($id = null) {
        $this->form_validation->set_rules('zone', 'Zone', 'trim|required|xss_clean');
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
        $where_not_in = array('cmi.sr_number_id' => '0');
        $group_by = array('ce.customer_code');
        $data['customerCodeRecords'] = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', '', '', '', '', $group_by, $where_search, '', '', '', '', $where_not_in);

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
        $where_not_in = array('cmi.sr_number_id' => '0');
        $group_by = array('ce.customer_code');
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
        $where_not_in = array('cmi.sr_number_id' => '0');
        $group_by = array('ce.customer_code');
        $data['customerInventoryList'] = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', '', '', '', '', $group_by, $where_search, '', '', '', '', $where_not_in);

        return $data['customerInventoryList'];
    }

}
