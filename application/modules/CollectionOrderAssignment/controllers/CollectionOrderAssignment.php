<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CollectionOrderAssignment extends CI_Controller {

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
        $fields = array('co.collection_id,co.collection_order_id, co.contact_person, co.contact_number, co.sales_representative, co.co_date_time , co.last_due_date_time, c.code_name as co_status,l.firstname,l.lastname');
        $join_tables = array(
            PAYMENT_TERMS . ' as pt' => 'co.payment_terms_id = pt.payment_terms_id',
            CODELOOKUP . ' as c' => 'co.collection_order_status = c.code_id',
            LOGIN . ' as l' => 'co.sales_representative = l.login_id',
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
        $data['header'] = array('menu_module' => 'order_assignment', 'menu_child' => 'collection_order_assignment');
        $data['footerJs'] = array(
            '0' => base_url() . 'uploads/custom/js/CollectionorderAssignment/collection_order_list.js',
        );

        if ($this->input->post('result_type') == 'ajax') {
            $this->load->view($this->viewname . '/ajaxList', $data);
        } else {
            $data['main_content'] = '/collectionOrderAssignmentlist';
            $this->parser->parse('layouts/DefaultTemplate', $data);
        }
    }

    /*
      @Author : Maitrak Modi
      @Desc   :Customer Enrolment Edit Function
      @Input 	: Collection Order Id
      @Output	:
      @Date   : 17 th March 2017
     */

    public function edit($collectionOrderId) {
//pr($_POST);exit;
        $tableName = COLLECTION_ORDER . ' as co';
        $fields = array('co.*,ce.customer_code,ce.customer_name');
        $match = array('co.collection_id' => $collectionOrderId);
        $join_tables = array(
            CUSTOMER_ENROLMENT . ' as ce' => 'co.customer_id = ce.customer_id',
        );
        $data['editCollectionRecord'] = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $match, '', '', '', '', '', '', '');
//pr($data['editCollectionRecord']);exit;
        //exit;
        if (!empty($data['editCollectionRecord'][0])) {
            //pr($data['customerDetails']);exit;

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
                $data['editCollectionOrderId'] = $data['editCollectionRecord'][0]['collection_order_id'];
                $data['editCollectionId'] = $data['editCollectionRecord'][0]['collection_id'];
                $data['editDeliveryOrderId'] = $data['editCollectionRecord'][0]['delivery_order_id'];
                $data['editCustomerCode'] = $data['editCollectionRecord'][0]['customer_code'];
                $data['editCustmerId'] = $data['editCollectionRecord'][0]['customer_id'];
                $data['editCustmerName'] = $data['editCollectionRecord'][0]['customer_name_id'];
                $data['editSrNumber'] = $data['editCollectionRecord'][0]['sr_number_installation'];
                $data['editStatus'] = $data['editCollectionRecord'][0]['collection_order_status'];
                $data['editPaymentTerms'] = $data['editCollectionRecord'][0]['payment_terms_id'];
                $data['editContactPerson'] = $data['editCollectionRecord'][0]['contact_person'];
                $data['editContactNumber'] = $data['editCollectionRecord'][0]['contact_number'];
                $data['editSalesRepresantative'] = $data['editCollectionRecord'][0]['sales_representative'];
                $data['editCollectionDatetime'] = date('m/d/y h:i A', strtotime($data['editCollectionRecord'][0]['co_date_time']));
                $data['editLastDueDateTime'] = date('m/d/y h:i A', strtotime($data['editCollectionRecord'][0]['last_due_date_time']));

                //$data['editCollectionDatetime'] = $data['editCollectionRecord'][0]['co_date_time'];
                // $data['editLastDueDateTime'] = $data['editCollectionRecord'][0]['last_due_date_time'];
                $data['editComment'] = $data['editCollectionRecord'][0]['comments'];
                $data['editPickUpLocation'] = $data['editCollectionRecord'][0]['pickup_location'];
                $data['editPartialCollectionAmount'] = $data['editCollectionRecord'][0]['partial_collection_amount'];
                $data['editCoTrip'] = $data['editCollectionRecord'][0]['collection_trip_failed'];
                $data['editReasonOfCollection'] = $data['editCollectionRecord'][0]['reason_for_payment'];
                $data['editAttachment'] = $data['editCollectionRecord'][0]['attachments'];
                $data['editLocationAttachments'] = $data['editCollectionRecord'][0]['location_attachments'];
                $data['editzone'] = $data['editCollectionRecord'][0]['zone'];
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
                                            <td>' . $editCheque["reference"] . '</td>
                                            <td>' . $editCheque["invoice"] . '</td>
                                            <td>' . $editCheque["po"] . '</td>
                                            <td>' . $editCheque["amount"] . '</td>
                                        </tr>';

                        $editTotalAmout += $editCheque["amount"];
                    }

                    $data['editChequeData'] = $editChequeData;
                    $data['editTotalAmout'] = $editTotalAmout;
                }
                /* End - Edit Cheque Info */

                $data['footerJs'] = array(
                    //'0' => base_url() . 'uploads/assets/js/moment.min.js',
                    //'0' => base_url() . 'uploads/assets/js/bootstrap-datetimepicker.min.js',

                    '0' => base_url() . 'uploads/custom/js/CollectionorderAssignment/CollectionorderAssignment.js',
                );

                $tableName = LOGIN . ' as l';
                $zoneFields = array('l.login_id as id, l.firstname as name, l.role_id, rm.role_name');
                $whereCond = array('l.status' => 'active', 'l.is_delete' => 0, 'rm.is_delete' => 0, 'rm.role_slug' => 'zone', 'rm.status' => '1'); // zone slug

                $join_tables = array(
                    ROLE_MASTER . ' as rm' => 'l.role_id = rm.role_id',
                );
                $data['zoneList'] = $this->common_model->get_records($tableName, $zoneFields, $join_tables, 'left', $whereCond, '', '', '', '', '', '', '');

                /* Query */
                $tableName = CUSTOMER_ENROLMENT . ' as ce';
                $fields = array('ce.customer_id, ce.customer_name, ce.customer_code, 
                                ce.contact_number, ce.location,
                                r.name as route_name
                            ');

                $join_tables = array(
                    //MACHINE_INVENTORY . ' as mi' => 'ce.inventory_id = mi.inventory_id',
                    ROUTE . ' as r' => 'ce.route_id = r.route_id',
                );
                $whereCond = array('ce.customer_id' => $data['editCollectionRecord'][0]['customer_id'], 'ce.is_delete' => '0');

                $data['customerDetails'] = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', '', '', '', '', '', '');
                $data['crnt_view'] = $this->viewname;
                $data['form_action_path'] = $this->viewname . '/edit/' . $collectionOrderId;
                $data['main_content'] = '/addEdit';

                $data['screenType'] = 'edit';
                $data['header'] = array('menu_module' => 'order_assignment', 'menu_child' => 'collection_order_assignment');
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
      @Input  :
      @Output :
      @Date   : 17th March 2017
     */

    public function updateData($collectionOrderId, $attachmentName) {
        $data = array(
            'comments' => $this->input->post('comment'),
            'partial_collection_amount' => $this->input->post('partial_collection_amount'),
            'collection_trip_failed' => $this->input->post('collection_trip_failed'),
            'reason_for_payment' => $this->input->post('reason_of_collection'),
            'zone' => $this->input->post('zone'),
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
                if (!$this->uploadAttachment($collectionOrderId)) { // File upload function call
                    $msg = $this->lang->line('error_msg');
                    $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");
                }
            }
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

        $this->form_validation->set_rules('zone', 'Zone', 'trim|required|xss_clean');
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
        $tableName = CUSTOMER_ENROLMENT . ' as ce';
        $fields = array('ce.customer_id, ce.customer_name, ce.customer_code, 
                        ce.mobile_number,ce.contact_name,ce.contact_number, ce.location, ce.email,
                        r.name as route_name');

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
            EMIRATE . ' as em' => 'ce.emirates_id = em.emirate_id'
        );

        $whereCond = array('ce.customer_name' => $selectedCustomerName, 'ce.is_delete' => '0');

        $data['customerInfo'] = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', '', '', '', '', '', '');

        $this->load->view($this->viewname . '/CustomerPopUpInfo', $data);
    }

}
