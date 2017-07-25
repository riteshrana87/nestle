<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CollectionOrder extends CI_Controller {

    function __construct() {

        parent::__construct();

        $this->viewname = $this->uri->segment(1);
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('form_validation', 'Session', 'upload'));
    }

    /*
      @Author : Maitrak Modi
      @Desc   : Collection Order Listing
      @Input 	:
      @Output	:
      @Date   : 14th March 2017
     */

    public function index() {

        /* Post Parameters */
        $searchtext = $this->input->post('searchtext');
        $sortfield = $this->input->post('sortfield');
        $sortby = $this->input->post('sortby');
        $perpage = NO_OF_RECORDS_PER_PAGE;
        $allflag = $this->input->post('allflag');

        /* Start - Reset All Fields */
        if (!empty($allflag) && ($allflag == 'all' || $allflag == 'changesorting' || $allflag == 'changesearch')) {
            $this->session->unset_userdata('co_data');
        }
        /* End - Reset All Fields */

        $searchsort_session = $this->session->userdata('co_data'); // store data in session

        /* Default Sorting */
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
                $sortfield = 'collection_id';
                $sortby = 'desc';
                $data['sortfield'] = $sortfield;
                $data['sortby'] = $sortby;
            }
        }

        /* Search text */
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
                $config['per_page'] = NO_OF_RECORDS_PER_PAGE;
                $data['perpage'] = NO_OF_RECORDS_PER_PAGE;
            }
        }

        $config['first_link'] = 'First';
        $config['base_url'] = base_url() . $this->viewname . '/index';

        if (!empty($allflag) && ($allflag == 'all' || $allflag == 'changesorting' || $allflag == 'changesearch')) {
            $config['uri_segment'] = 0;
            $uri_segment = 0;
        } else {
            $config['uri_segment'] = 3;
            $uri_segment = $this->uri->segment(3);
        }

        /* Start - Filter Query */
        $tableName = COLLECTION_ORDER . ' as co';
        $fields = array('co.collection_id,co.collection_order_id, co.contact_person, co.contact_number, 
            co.co_date_time , co.last_due_date_time, 
            c.code_name as co_status
            ');

        /* co.sales_representative, */

        $join_tables = array(
            PAYMENT_TERMS . ' as pt' => 'co.payment_terms_id = pt.payment_terms_id',
            CODELOOKUP . ' as c' => 'co.collection_order_status = c.code_id',
        );

        $whereCond = array('co.is_delete' => '0', 'c.isactive' => 'active');

        if (!empty($searchtext)) {
            $searchtext = html_entity_decode(trim(addslashes($searchtext)));
            $where_search = '(co.contact_person  LIKE "%' . $searchtext . '%" '
                    . 'OR co.contact_number LIKE "%' . $searchtext . '%" '
                    . 'OR co.collection_order_id LIKE "%' . $searchtext . '%" '
                    . 'OR co.sales_representative LIKE "%' . $searchtext . '%" '
                    . 'OR co.co_date_time LIKE "%' . $searchtext . '%" '
                    . 'OR co.last_due_date_time LIKE "%' . $searchtext . '%" '
                    . 'OR c.code_name LIKE "%' . $searchtext . '%" '
                    . ')';

            $data['listRecords'] = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', $config['per_page'], $uri_segment, $sortfield, $sortby, '', $where_search);
            $config['total_rows'] = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', '', '', $sortfield, $sortby, '', $where_search, '', '', '1');
        } else {
            $data['listRecords'] = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', $config['per_page'], $uri_segment, $sortfield, $sortby, '', '');
            $config['total_rows'] = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', '', '', $sortfield, $sortby, '', '', '', '', '1');
        }

        /* Start Pagination */
        $this->ajax_pagination->initialize($config);
        $data['pagination'] = $this->ajax_pagination->create_links();
        $data['uri_segment'] = $uri_segment;
        $sortsearchpage_data = array(
            'sortfield' => $data['sortfield'],
            'sortby' => $data['sortby'],
            'searchtext' => $data['searchtext'],
            'perpage' => trim($data['perpage']),
            'uri_segment' => $uri_segment,
            'total_rows' => $config['total_rows']
        );

        $this->session->set_userdata('co_data', $sortsearchpage_data);
        setActiveSession('co_data'); // set current Session active

        $data['crnt_view'] = $this->viewname;
        /* End Pagination */

        $data['crnt_view'] = $this->viewname;
        $data['form_action_path'] = $this->viewname . '/index';

        //$data['main_content'] = '/customerlist';
        $data['header'] = array('menu_module' => 'order_management', 'menu_child' => 'collection_order');
        $data['footerJs'] = array(
            '0' => base_url() . 'uploads/custom/js/Collectionorder/collection_order_list.js',
        );

        if ($this->input->post('result_type') == 'ajax') {
            $this->load->view($this->viewname . '/ajaxList', $data);
        } else {
            $data['main_content'] = '/collectionOrderlist';
            $this->parser->parse('layouts/DefaultTemplate', $data);
        }
    }

    /*
      @Author : Maitrak Modi
      @Desc   : Collection Order Add function
      @Input 	:
      @Output	:
      @Date   : 16th March 2017
     */

    public function add() {

        $this->formValidation(); // form Validation fields

        if ($this->form_validation->run() == FALSE) {

            $data['validation'] = validation_errors();

            $data['paymentTermsList'] = getMasterTableList(PAYMENT_TERMS); // get payment terms list


            $data['customerCodeList'] = $this->getCustomerCodeList(); // customer code list
            $data['customerNameList'] = $this->getCustomerNameList(); // customer name list
            $data['InventoryList'] = $this->getInventoryList(); // Inventory list

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

            $data['coStatusList'] = $nested['collection_order_status']['children'];
            /* End -  COllection Order Status */

            $data['crnt_view'] = $this->viewname;
            $data['form_action_path'] = $this->viewname . '/add';
            $data['main_content'] = '/addEdit';
            $data['screenType'] = 'add';

            $data['footerJs'] = array(
                //'0' => base_url() . 'uploads/assets/js/moment.min.js',
                '0' => base_url() . 'uploads/assets/js/bootstrap-datetimepicker.min.js',
                '1' => base_url() . 'uploads/custom/js/Collectionorder/Collectionorder.js',
            );

            $data['header'] = array('menu_module' => 'order_management', 'menu_child' => 'collection_order');
            $this->parser->parse('layouts/DefaultTemplate', $data);
        } else {
            //success form
            $this->insertData();
        }
    }

    /*
      @Author : Maitrak Modi
      @Desc   : Customer Enrolment Insert Data
      @Input 	:
      @Output	:
      @Date   : 17th March 2017
     */

    public function insertData() {

        // Inserted Array Data
        $data = array(
            'delivery_order_id' => '1',
            'collection_order_id' => $this->input->post('collection_order_id'),
            'customer_id' => $this->input->post('cust_code'),
            'customer_name_id' => $this->input->post('cust_name'),
            'sr_number_installation' => $this->input->post('sr_number_installation'),
            'collection_order_status' => $this->input->post('status'),
            'payment_terms_id' => $this->input->post('payment_terms'),
            'contact_person' => $this->input->post('contact_person'),
            'contact_number' => $this->input->post('contact_number'),
            'pickup_location' => $this->input->post('pickup_location'),
            'sales_representative' => $this->session->userdata['LOGGED_IN']['ID'],
            'co_date_time' => date('Y-m-d H:i:s', strtotime($this->input->post('collection_datetime'))),
            'last_due_date_time' => date('Y-m-d H:i:s', strtotime($this->input->post('last_due_datetime'))),
            'comments' => $this->input->post('comment'),
            'partial_collection_amount' => $this->input->post('partial_collection_amount'),
            'collection_trip_failed' => $this->input->post('collection_trip_failed'),
            'reason_for_payment' => $this->input->post('reason_of_collection'),
            'created_by' => $this->session->userdata['LOGGED_IN']['ID'],
            'created_at' => date("Y-m-d H:i:s"),
            'updated_by' => $this->session->userdata['LOGGED_IN']['ID'],
            'updated_at' => date("Y-m-d H:i:s")
        );

        // Insert query
        if ($this->common_model->insert(COLLECTION_ORDER, $data)) {

            $collectionOrderLastId = $this->db->insert_id(); // last inserted id of collection

            /* Start - Insert Cheque Information */
            $totalNoOfChequeInfoRow = count($this->input->post('reference'));
            $insertChequeData = array();

            /* if ((!empty($this->input->post('reference')[0]) || (!empty($this->input->post('invoice')[0])) ||
              (!empty($this->input->post('po')[0])) || (!empty($this->input->post('amount')[0])))) { */

            for ($i = 0; $i < $totalNoOfChequeInfoRow; $i++) {

                $reference = $this->input->post('reference')[$i];
                $invoice = $this->input->post('invoice')[$i];
                $po = $this->input->post('po')[$i];
                $amount = $this->input->post('amount')[$i];

                if ((!empty($reference) || (!empty($invoice)) || (!empty($po)) || (!empty($amount)))) {

                    $insertChequeData [] = array(
                        'collection_id' => $collectionOrderLastId,
                        'reference' => $reference,
                        'invoice' => $invoice,
                        'po' => $po,
                        'amount' => $amount,
                        'created_by' => $this->session->userdata['LOGGED_IN']['ID'],
                        'created_at' => date("Y-m-d H:i:s"),
                        'updated_by' => $this->session->userdata['LOGGED_IN']['ID'],
                        'updated_at' => date("Y-m-d H:i:s")
                    );
                }
            }
            //}
            //pr($insertChequeData); exit;
            if (count($insertChequeData) > 0) {
                $this->common_model->insert_batch(CO_CHEQUE_INFO, $insertChequeData); // batch insert data of cheque info
            }
            /* End - Insert Cheque Information */

            if (!$this->uploadAttachment($collectionOrderLastId)) { // File upload function call
                $msg = $this->lang->line('error_msg');
                $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");
            }

            //MAILING FUNCTION
            $this->sendCollectionMail($collectionOrderLastId);

            $msg = $this->lang->line('co_insert_msg');
            $this->session->set_flashdata('msg', "<div class='alert alert-success text-center'>$msg</div>");
        } else {
            // error
            $msg = $this->lang->line('error_msg');
            $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");
        }

        redirect($this->viewname);
    }

    /*
      @Author : Maitrak Modi
      @Desc   :Customer Enrolment Edit Function
      @Input 	: Collection Order Id
      @Output	:
      @Date   : 17 th March 2017
     */

    public function edit($collectionOrderId) {

        $tableName = COLLECTION_ORDER;
        $fields = array('*');
        $match = array('collection_id' => $collectionOrderId);

        $data['editCollectionRecord'] = $this->common_model->get_records($tableName, $fields, '', '', $match, '', '', '', '', '', '', '');
        //pr($data['editCollectionRecord']);
        //exit;
        if (!empty($data['editCollectionRecord'][0])) {

            $this->formValidation(); // form Validation fields

            if ($this->form_validation->run() == FALSE) {

                $data['validation'] = validation_errors();

                $data['paymentTermsList'] = getMasterTableList(PAYMENT_TERMS); // get payment terms list
                $data['customerCodeList'] = $this->getCustomerCodeList(); // customer code list
                $data['customerNameList'] = $this->getCustomerNameList(); // customer name list
                $data['InventoryList'] = $this->getInventoryList(); // Inventory list

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

                $data['coStatusList'] = $nested['collection_order_status']['children'];
                /* End -  COllection Order Status */

                /* Start - Edit data in form */
                $data['editCollectionId'] = $data['editCollectionRecord'][0]['collection_id'];
                $data['editDeliveryOrderId'] = $data['editCollectionRecord'][0]['delivery_order_id'];
                $data['editCustmerId'] = $data['editCollectionRecord'][0]['customer_id'];
                $data['editCustomerNameId'] = $data['editCollectionRecord'][0]['customer_name_id'];
                $data['editSrNumberInstallation'] = $data['editCollectionRecord'][0]['sr_number_installation'];
                $data['editStatus'] = $data['editCollectionRecord'][0]['collection_order_status'];
                $data['editPaymentTerms'] = $data['editCollectionRecord'][0]['payment_terms_id'];
                $data['editContactPerson'] = $data['editCollectionRecord'][0]['contact_person'];
                $data['editContactNumber'] = $data['editCollectionRecord'][0]['contact_number'];
                // $data['editSalesRepresantative'] = $data['editCollectionRecord'][0]['sales_representative'];
                $data['editCollectionDatetime'] = date('m/d/y H:i', strtotime($data['editCollectionRecord'][0]['co_date_time']));
                $data['editLastDueDateTime'] = date('m/d/y H:i', strtotime($data['editCollectionRecord'][0]['last_due_date_time']));

                //$data['editCollectionDatetime'] = $data['editCollectionRecord'][0]['co_date_time'];
                // $data['editLastDueDateTime'] = $data['editCollectionRecord'][0]['last_due_date_time'];
                $data['editComment'] = $data['editCollectionRecord'][0]['comments'];
                $data['editPickUpLocation'] = $data['editCollectionRecord'][0]['pickup_location'];
                $data['editPartialCollectionAmount'] = $data['editCollectionRecord'][0]['partial_collection_amount'];
                $data['editCoTrip'] = $data['editCollectionRecord'][0]['collection_trip_failed'];
                $data['editReasonOfCollection'] = $data['editCollectionRecord'][0]['reason_for_payment'];
                $data['editAttachment'] = $data['editCollectionRecord'][0]['attachments'];
                $data['editLocationAttachment'] = $data['editCollectionRecord'][0]['location_attachments'];
                $data['editCollectionOrderId'] = $data['editCollectionRecord'][0]['collection_order_id'];

                /* End - Edit data in form */

                /* Start - Edit Cheque Info */
                $tableName = CO_CHEQUE_INFO;
                $chequeField = array('co_cheque_info_id, collection_id, reference, invoice, po, amount');
                $matchCond = array('collection_id' => $collectionOrderId);

                $data['editCheque'] = $this->common_model->get_records($tableName, $chequeField, '', '', $matchCond, '', '', '', '', '', '', '');
                $editChequeData = '';
                $editTotalAmout = '';
                if (!empty($data['editCheque'])) {

                    foreach ($data['editCheque'] as $editCheque) {

                        $editChequeData .= '<tr>
                                            <td><input type="text" id="reference" name="reference[]" class="form-control"  value="' . $editCheque["reference"] . '" /></td>
                                            <td><input type="text" id="invoice" name="invoice[]" class="form-control" value="' . $editCheque["invoice"] . '" /></td>
                                            <td><input type="text" id="po" name="po[]" class="form-control" value="' . $editCheque["po"] . '" /></td>
                                            <td><input type="text" id="amount" name="amount[]" class="form-control amount" maxlength="12" data-parsley-pattern="^\d+(\.\d{1,2})?$" data-parsley-pattern-message="Allow upto 2 decimal point. e.g: 4.00" data-parsley-trigger="keyup" value="' . $editCheque["amount"] . '" /></td>
                                            <td><a href="javascript:void(0);" class="btn btn-link delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
                                        </tr>';

                        $editTotalAmout += $editCheque["amount"];
                    }

                    $data['editChequeData'] = $editChequeData;
                    $data['editTotalAmout'] = $editTotalAmout;
                }
                /* End - Edit Cheque Info */

                $data['footerJs'] = array(
                    //'0' => base_url() . 'uploads/assets/js/moment.min.js',
                    '0' => base_url() . 'uploads/assets/js/bootstrap-datetimepicker.min.js',
                    '1' => base_url() . 'uploads/custom/js/Collectionorder/Collectionorder.js',
                );

                $data['crnt_view'] = $this->viewname;
                $data['form_action_path'] = $this->viewname . '/edit/' . $collectionOrderId;
                $data['main_content'] = '/addEdit';

                $data['screenType'] = 'edit';
                $data['header'] = array('menu_module' => 'order_management', 'menu_child' => 'collection_order');
                $this->parser->parse('layouts/DefaultTemplate', $data);
            } else {
                // success form
                $this->updateData($collectionOrderId, $data['editCollectionRecord']);
            }
        } else {
            // error
            $msg = $this->lang->line('error_msg');
            $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");

            redirect($this->viewname);
        }
    }

    /*
      @Author : Maitrak Modi
      @Desc   : Collection Order Update Data
      @Input 	:
      @Output	:
      @Date   : 17th March 2017
     */

    public function updateData($collectionOrderId, $attachmentName) {
        /* pr($_POST);
          exit;
         */
        $data = array(
            'delivery_order_id' => '1',
            'customer_id' => $this->input->post('cust_code'),
            'collection_order_status' => $this->input->post('status'),
            'payment_terms_id' => $this->input->post('payment_terms'),
            'contact_person' => $this->input->post('contact_person'),
            'contact_number' => $this->input->post('contact_number'),
            //  'sales_representative' => $this->input->post('sales_representative'),
            'co_date_time' => date('Y-m-d H:i:s', strtotime($this->input->post('collection_datetime'))),
            'last_due_date_time' => date('Y-m-d H:i:s', strtotime($this->input->post('last_due_datetime'))),
            'comments' => $this->input->post('comment'),
            'pickup_location' => $this->input->post('pickup_location'),
            'partial_collection_amount' => $this->input->post('partial_collection_amount'),
            'collection_trip_failed' => $this->input->post('collection_trip_failed'),
            'reason_for_payment' => $this->input->post('reason_of_collection'),
            //'attachment' => $this->input->post('payment_terms'),
            //'created_by' => $this->session->userdata['LOGGED_IN']['ID'],
            //'created_at' => date("Y-m-d H:i:s"),
            'updated_by' => $this->session->userdata['LOGGED_IN']['ID'],
            'updated_at' => date("Y-m-d H:i:s")
        );

        $whereCond = array('collection_id' => $collectionOrderId);

        if ($this->input->post('removeFile')) {

            if (!empty($attachmentName[0]['attachments'])) {
                unlink($this->config->item('collection_order_attachment_url') . $collectionOrderId . '/' . $attachmentName[0]['attachments']);
                $data['attachments'] = '';
            }
        }

        if ($this->input->post('removeLocationFile')) {
            if (!empty($attachmentName[0]['location_attachments'])) {
                unlink($this->config->item('collection_order_attachment_url') . $collectionOrderId . '/' . $attachmentName[0]['location_attachments']);
                $data['location_attachments'] = '';
            }
        }

        if ($this->common_model->update(COLLECTION_ORDER, $data, $whereCond)) { //Update data
            if (!empty($_FILES)) {
                /* if(!empty($attachmentName[0]['attachments'])){
                  unlink($this->config->item('collection_order_attachment_url') . $collectionOrderId . '/' . $attachmentName[0]['attachments']);
                  }

                  if(!empty($attachmentName[0]['location_attachments'])) {
                  unlink($this->config->item('collection_order_attachment_url') . $collectionOrderId . '/' . $attachmentName[0]['location_attachments']);
                  }
                 */
                if (!$this->uploadAttachment($collectionOrderId)) { // File upload function call
                    $msg = $this->lang->line('error_msg');
                    $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");
                }
            }


            /* Start - Insert Cheque Information */

            $totalNoOfChequeInfoRow = count($this->input->post('reference'));

            if ($this->common_model->delete(CO_CHEQUE_INFO, $whereCond)) { // Delete Existing record
                $insertChequeData = array();

                //pr($_POST); exit;
                //echo $totalNoOfChequeInfoRow; exit;
                // Create Batch array for insert data
                for ($i = 0; $i < $totalNoOfChequeInfoRow; $i++) {

                    $reference = $this->input->post('reference')[$i];
                    $invoice = $this->input->post('invoice')[$i];
                    $po = $this->input->post('po')[$i];
                    $amount = $this->input->post('amount')[$i];

                    //echo $reference.'-'.$invoice.'-'.$po.'-'.$amount; exit;
                    if ((!empty($reference) || (!empty($invoice)) || (!empty($po)) || (!empty($amount)))) {

                        $insertChequeData [] = array(
                            'collection_id' => $collectionOrderId,
                            'reference' => $reference,
                            'invoice' => $invoice,
                            'po' => $po,
                            'amount' => $amount,
                            'created_by' => $this->session->userdata['LOGGED_IN']['ID'],
                            'created_at' => date("Y-m-d H:i:s"),
                            'updated_by' => $this->session->userdata['LOGGED_IN']['ID'],
                            'updated_at' => date("Y-m-d H:i:s")
                        );
                    }
                }

                //$this->common_model->update_batch(CO_CHEQUE_INFO, $updateChequeData, 'collection_id'); // batch insert data of cheque info
                if (!empty($insertChequeData)) {
                    $this->common_model->insert_batch(CO_CHEQUE_INFO, $insertChequeData);
                }
            }
            /* End - Insert Cheque Information */

            $msg = $this->lang->line('co_update_msg');
            $this->session->set_flashdata('msg', "<div class='alert alert-success text-center'>$msg</div>");
        } else {
            // error
            $msg = $this->lang->line('error_msg');
            $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");
        }

        redirect($this->viewname);
    }

    /*
      @Author : Maitrak Modi
      @Desc   : Collection Order Form validation
      @Input 	:
      @Output	:
      @Date   : 16th March 2017
     */

    public function formValidation() {

        $this->form_validation->set_rules('cust_code', 'Customer Code', 'trim|required|xss_clean');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|xss_clean');
        $this->form_validation->set_rules('payment_terms', 'Payment Terms', 'trim|required|xss_clean');
        $this->form_validation->set_rules('contact_person', 'Contact Person', 'trim|required|max_length[100]|xss_clean');
        $this->form_validation->set_rules('contact_number', 'Contact Number', 'trim|required|max_length[15]|xss_clean');
        //$this->form_validation->set_rules('sales_representative', 'Sales Representative', 'trim|required|max_length[100]|xss_clean');
        $this->form_validation->set_rules('collection_datetime', 'Collection Date Time', 'trim|required|xss_clean');
        $this->form_validation->set_rules('last_due_datetime', 'Last Due Date Time', 'trim|required|xss_clean');
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
            ce.customer_id, ce.customer_name, ce.customer_code, ce.location, ce.mobile_number, ce.contact_name,ce.contact_number,ce.email,
            mi.inventory_id, mi.machine_serial_number, mi.machine_id, mi.asset,
            r.name as route_name            
            ');

        $join_tables = array(
            CUSTOMER_ENROLMENT . ' as ce' => 'cmi.customer_id = ce.customer_id',
            MACHINE_INVENTORY . ' as mi' => 'cmi.sr_number_id = mi.inventory_id',
            ROUTE . ' as r' => 'ce.route_id = r.route_id',
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
                );

                /* $json_customer_details = array(
                  'customer_id' => $customerDetails['customer_id'],
                  'customer_name' => $customerDetails['customer_name'],
                  'customer_code' => $customerDetails['customer_code'],
                  'customer_mobile_number' => $customerDetails['mobile_number'],
                  'customer_location' => $customerDetails['location'],
                  'customer_email' => $customerDetails['email'],
                  'customer_route_name' => $customerDetails['route_name'],
                  'contact_name' => $customerDetails['contact_name'],
                  'contact_number' => $customerDetails['contact_number'],
                  ); */
            }
        }

        // Query 
        /* $tableName = CUSTOMER_ENROLMENT . ' as ce';
          $fields = array('ce.customer_id, ce.customer_name, ce.customer_code,
          ce.mobile_number,ce.contact_name,ce.contact_number, ce.location, ce.email,
          r.name as route_name
          ');

          $join_tables = array(
          ROUTE . ' as r' => 'ce.route_id = r.route_id',
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
          );
          }
          } */
        echo json_encode($json_customer_details);
    }

    /*
      @Author : Maitrak Modi
      @Desc   : CO upload attachment
      @Input 	:
      @Output	:
      @Date   : 23rd March 2017
     */

    public function uploadAttachment($collectionOrderId) {

//        pr($_FILES);exit;
        /* Start - Upload Attachment File */
        $uploadCoDir = $this->config->item('collection_order_attachment_url');
        $uploadCoUploadDirPath = $uploadCoDir . $collectionOrderId;

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
            foreach ($_FILES as $key => $file_data) {

                if (!empty($_FILES[$key]['name'])) {

                    //$no_of_files = 1;
                    //$upload_size = '';
                    //$upload_type = 'doc|docx|pdf|xls|xlsx'; // Allow file type
                    $redirect = $this->viewname;

                    //Upload Attchment
                    $uploadedFileData = uploadImage($key, $uploadCoUploadDirPath, $redirect);
                    //pr($uploadedFileData); exit;
                    if (!empty($uploadedFileData)) {
                        $updateData[$key] = $uploadedFileData[0]['file_name'];
                    }
                    $where = array('collection_id' => $collectionOrderId);

                    if (!$this->common_model->update(COLLECTION_ORDER, $updateData, $where)) {
                        return false;
                    }
                }
            }
        }
        /* End - Upload Attachment File */
        return true;
    }

    /*
      @Author : Maitrak Modi
      @Desc   : check customer code
      @Input 	:
      @Output	:
      @Date   : 21st March 2017
     */

    public function checkCustomerCode() {

        $customerCode = html_entity_decode(trim(addslashes($this->input->post('customerCode'))));

        $tableName = CUSTOMER_ENROLMENT . ' as ce';
        $fields = array('ce.customer_id, ce.customer_code');
        $whereCond = array('ce.is_delete' => '0', 'ce.customer_code' => $customerCode);

        $data['customerCodeRecords'] = $this->common_model->get_records($tableName, $fields, '', '', $whereCond, '', '10', '', '', '', '', '');

        pr($data['customerCodeRecords']);
        exit;
    }

    /*
      @Author : Maitrak Modi
      @Desc   : CO soft delete inventory
      @Input 	:
      @Output	:
      @Date   : 24th March 2017
     */

    public function deleteCollection() {

        $collectionId = $this->input->post('collectionId');

        if (!empty($collectionId)) {

            $tableName = COLLECTION_ORDER;
            $data = array('is_delete' => '1');
            $where = array('collection_id' => $collectionId);

            if ($this->common_model->update($tableName, $data, $where)) {
                $msg = 'Collection Order has been deleted succssfully.';
                //$customMsg = "<div class='alert alert-success text-center'>$msg</div>";
                //$statusCode = 'success';
                $this->session->set_flashdata('msg', "<div class='alert alert-success text-center'>$msg</div>");
            } else {
                // error
                $msg = $this->lang->line('error_msg');
                //$customMsg = "<div class='alert alert-danger text-center'>$msg</div>";
                //$statusCode = 'error';
                //$this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");
            }

            /* $returnData = array(
              'msg' => $customMsg,
              //  'statusCode' => $statusCode,
              ); */

            //echo json_encode($returnData);
            echo base_url($this->viewname);
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
        $where_not_in = array('cmi.sr_number_id' => '0', 'cmi.machine_assign_type ' => 'Pullout');
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
                        ce.mobile_number,ce.contact_name,ce.contact_number, ce.location, ce.email,r.name as route_name');

        $join_tables = array(
            CUSTOMER_ENROLMENT . ' as ce' => 'cmi.customer_id = ce.customer_id',
            ROUTE . ' as r' => 'ce.route_id = r.route_id',
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
                );
            }
        }
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
      @Desc   : send mail of collection order
      @Input  : $collectionOrderId
      @Output : return true or false
      @Date   : 4th July 2017
     */

    protected function sendCollectionMail($collectionOrderId) {

        $getCollectionData = $this->getAllCollectionMailDetail($collectionOrderId); // get details

        if (!empty($getCollectionData)) {

            $find = array(
                '{CUSTOMER_NAME}',
                '{ADDRESS}',
                '{CUSTOMER_CODE}',
                '{CONTACT_PERSON}',
                '{CONTACT_NUMBER}',
                '{COLLECTION_ADDRESS}',
                '{SALES_REPRESENTATIVE}',
                '{COLLECTION_DATE}',
                '{COLLECTION_TOTAL_AMOUNT}',
            );

            $replace = array(
                'CUSTOMER_NAME' => $getCollectionData['customer_name'],
                'ADDRESS' => $getCollectionData['location'],
                'CUSTOMER_CODE' => $getCollectionData['customer_code'],
                'CONTACT_PERSON' => $getCollectionData['contact_person'],
                'CONTACT_NUMBER' => $getCollectionData['contact_number'],
                'COLLECTION_ADDRESS' => $getCollectionData['pickup_location'],
                'SALES_REPRESENTATIVE' => $this->session->userdata['LOGGED_IN']['FIRSTNAME'],
                'COLLECTION_DATE' => $getCollectionData['co_date_time'],
                'COLLECTION_TOTAL_AMOUNT' => $getCollectionData['collectionAmount'],
            );

            $to = $this->config->item('co_email_id'); // Set Email id in config

            $message = '<p> Hello, </p>';
            $message .= '<p><b>Find New Collection Order Details.</b></p>';
            $message .= '<p></p>';
            $message .= '<table border="1">'
                    . '<tr><td><b>Customer Name :</b></td><td>{CUSTOMER_NAME}</td></tr>'
                    . '<tr><td><b>Customer Code :</b></td><td>{CUSTOMER_CODE}</td></tr>'
                    . '<tr><td><b>Customer Address :</b></td><td>{ADDRESS}</td></tr>'
                    . '<tr><td><b>Contact Person :</b></td><td>{CONTACT_PERSON}</td></tr>'
                    . '<tr><td><b>Contact Number :</b></td><td>{CONTACT_NUMBER}</td></tr>'
                    . '<tr><td><b>Collection Order Address :</b></td><td>{COLLECTION_ADDRESS}</td></tr>'
                    . '<tr><td><b>Sales Representative :</b></td><td>{SALES_REPRESENTATIVE}</td></tr>'
                    . '<tr><td><b>Collection Date Time :</b></td><td>{COLLECTION_DATE}</td></tr>'
                    . '<tr><td><b>Collection Total Amount :</b></td><td>{COLLECTION_TOTAL_AMOUNT}</td></tr>';
            $message .= '</table>';

            $subject = 'New Collection Order has been placed on dated - ' . date('Y-m-d H:i:s');

            $message .= '<p> </p>';
            $message .= '<p>Thank You,</p>';
            $message .= '<p><b><i>Nestle Team<i><b></p>';

            $finalEmailBody = str_replace($find, $replace, $message);

            return send_mail($to, $subject, $finalEmailBody, $attach = NULL);
        }
    }

    /*
      @Author : Maitrak Modi
      @Desc   : get Collection order details
      @Input  : $collectionOrderId
      @Output : return collection order details
      @Date   : 4th July 2017
     */

    protected function getAllCollectionMailDetail($collectionOrderId) {

        $tableName = COLLECTION_ORDER . ' as co';

        $fields = array('co.contact_person, co.contact_number, co.pickup_location, co.co_date_time, 
                        SUM(coc.amount) as collectionAmount,
                        ce.customer_code, ce.customer_name, ce.location');
        $match = array('co.collection_id' => $collectionOrderId);

        $join_tables = array(
            CO_CHEQUE_INFO . ' as coc' => 'co.collection_id = coc.collection_id',
            CUSTOMER_ENROLMENT . ' as ce' => 'co.customer_id = ce.customer_id',
        );
        $data['editCollectionRecord'] = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $match, '', '', '', '', '', '', '');

        //pr($data['editCollectionRecord']);
        // exit;
        return $data['editCollectionRecord'][0];
    }

}
