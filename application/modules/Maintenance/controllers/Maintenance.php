<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Maintenance extends CI_Controller {

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
            $this->session->unset_userdata('maintenance_data');
        }
        /* End - Reset All Fields */

        $searchsort_session = $this->session->userdata('maintenance_data'); // store data in session

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
                $sortfield = 'm.maintenance_id';
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
        $tableName = MAINTENANCE . ' as m';
        $fields = array('m.maintenance_id, m.contact_person, m.contact_number, IF(m.request_type = "cm", "Corrective Maintenance", "Preventive Maintenance") as r_type,
            m.maintenance_status, m.responase_date, m.visited_date,
            c.code_name
            ');

        $join_tables = array(
            //    PAYMENT_TERMS . ' as pt' => 'co.payment_terms_id = pt.payment_terms_id',
            CODELOOKUP . ' as c' => 'm.maintenance_status = c.code_id',
        );

        //$whereCond = array();
        $whereCond = array('m.is_delete' => '0');

        if (!empty($searchtext)) {
            $searchtext = html_entity_decode(trim(addslashes($searchtext)));
            $where_search = '(m.contact_person  LIKE "%' . $searchtext . '%" '
                    . 'OR m.contact_number LIKE "%' . $searchtext . '%" '
                    . 'OR IF(m.request_type = "cm", "Corrective Maintenance", "Preventive Maintenance") LIKE "%' . $searchtext . '%" '
                    . 'OR m.maintenance_status LIKE "%' . $searchtext . '%" '
                    . 'OR m.responase_date LIKE "%' . $searchtext . '%" '
                    . 'OR m.visited_date LIKE "%' . $searchtext . '%" '
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

        $this->session->set_userdata('maintenance_data', $sortsearchpage_data);
        setActiveSession('maintenance_data'); // set current Session active

        $data['crnt_view'] = $this->viewname;
        /* End Pagination */

        $data['crnt_view'] = $this->viewname;
        $data['form_action_path'] = $this->viewname . '/index';

        //$data['main_content'] = '/customerlist';
        $data['header'] = array('menu_module' => 'maintenance', 'menu_child' => 'maintenance');
        $data['footerJs'] = array(
            '0' => base_url() . 'uploads/custom/js/Maintenance/Maintenance_list.js',
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
      @Desc   : CM Add function
      @Input 	:
      @Output	:
      @Date   : 16th March 2017
     */

    public function add() {

        $this->formValidation(); // form Validation fields

        if ($this->form_validation->run() == FALSE) {

            $data['validation'] = validation_errors();

            $data['customerCodeList'] = $this->getCustomerCodeList('code'); // customer code list
            $data['customerNameList'] = $this->getCustomerCodeList('name'); // customer name list
            $data['customerSerialList'] = $this->getCustomerCodeList('serial_number'); // customer name list

            $data['crnt_view'] = $this->viewname;
            $data['form_action_path'] = $this->viewname . '/add';
            $data['main_content'] = '/addEdit';
            $data['screenType'] = 'add';

            $data['footerJs'] = array(
                '0' => base_url() . 'uploads/assets/js/bootstrap-datetimepicker.min.js',
                '1' => base_url() . 'uploads/custom/js/Maintenance/Maintenance.js',
            );

            $data['header'] = array('menu_module' => 'maintenance', 'menu_child' => 'maintenance');

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

        // Insert Data
        $data = array(
            'request_type' => $this->input->post('request_type'),
            'customer_id' => $this->input->post('cust_code'),
            'location_id' => $this->input->post('machine_sr_number'),
            'request_type' => $this->input->post('request_type'),
            'preventive_maintenance' => ($this->input->post('request_type') == 'cm') ? $this->input->post('preventive_maintenance') : '',
            'issues' => $this->input->post('issues'),
            'contact_person' => $this->input->post('contact_person'),
            'contact_number' => $this->input->post('contact_number'),
            'address_of_machine' => $this->input->post('addr_of_machine'),
            'assigned_to' => $this->input->post('assigned_to'),
            'created_by' => $this->session->userdata['LOGGED_IN']['ID'],
            'created_at' => date("Y-m-d H:i:s"),
            'updated_by' => $this->session->userdata['LOGGED_IN']['ID'],
            'updated_at' => date("Y-m-d H:i:s")
        );

        // Insert query
        if ($this->common_model->insert(MAINTENANCE, $data)) {

            $inserted_maintenance_Id = $this->db->insert_id();


            $this->sendMaintenanceMail($inserted_maintenance_Id);
            $this->send_maintenance_sms($inserted_maintenance_Id);

            $msg = 'Maintenance has been added successfully.';
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

    public function edit($maintenanceId) {

        $tableName = MAINTENANCE;
        $fields = array('*');
        $match = array('maintenance_id' => $maintenanceId);

        $data['editMaintenanceRecord'] = $this->common_model->get_records($tableName, $fields, '', '', $match, '', '', '', '', '', '', '');
        // pr($data['editCollectionRecord']);
        //exit;
        if (!empty($data['editMaintenanceRecord'][0])) {

            $this->formValidation(); // form Validation fields

            if ($this->form_validation->run() == FALSE) {

                $data['validation'] = validation_errors();

                //$data['customerCodeList'] = $this->getCustomerCodeList(); // customer code list
                //$data['customerNameList'] = $this->getCustomerCodeList('name'); // customer name list
                //$data['customerSerialList'] = $this->getCustomerCodeList(); // customer name list

                $data['customerCodeList'] = $this->getCustomerCodeList('code'); // customer code list
                $data['customerNameList'] = $this->getCustomerCodeList('name'); // customer name list
                $data['customerSerialList'] = $this->getCustomerCodeList('serial_number'); // customer name list

                /* Start - Edit data in form */
                $data['editMaintenanceId'] = $data['editMaintenanceRecord'][0]['maintenance_id'];
                $data['editRequestType'] = $data['editMaintenanceRecord'][0]['request_type'];
                $data['editCustmerId'] = $data['editMaintenanceRecord'][0]['customer_id'];
                $data['editLocationId'] = $data['editMaintenanceRecord'][0]['location_id'];
                $data['editPMRadio'] = $data['editMaintenanceRecord'][0]['preventive_maintenance'];
                $data['editContactPerson'] = $data['editMaintenanceRecord'][0]['contact_person'];
                $data['editContactNumber'] = $data['editMaintenanceRecord'][0]['contact_number'];
                $data['editIssues'] = $data['editMaintenanceRecord'][0]['issues'];
                $data['editAssignedTo'] = $data['editMaintenanceRecord'][0]['assigned_to'];
                $data['editAdressOfMachine'] = $data['editMaintenanceRecord'][0]['address_of_machine'];
                $data['editPreventiveMaintenance'] = $data['editMaintenanceRecord'][0]['preventive_maintenance'];
                /* End - Edit data in form */

                $data['footerJs'] = array(
                    '0' => base_url() . 'uploads/assets/js/bootstrap-datetimepicker.min.js',
                    '1' => base_url() . 'uploads/custom/js/Maintenance/Maintenance.js',
                );

                $data['crnt_view'] = $this->viewname;
                $data['form_action_path'] = $this->viewname . '/edit/' . $maintenanceId;
                $data['main_content'] = '/addEdit';

                $data['screenType'] = 'edit';
                $data['header'] = array('menu_module' => 'maintenance', 'menu_child' => 'maintenance');
                $this->parser->parse('layouts/DefaultTemplate', $data);
            } else {
                // success form
                $this->updateData($maintenanceId);
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

    public function updateData($maintenanceId) {

        $data = array(
            'request_type' => $this->input->post('request_type'),
            'customer_id' => $this->input->post('cust_code'),
            'location_id' => $this->input->post('machine_sr_number'),
            'request_type' => $this->input->post('request_type'),
            'preventive_maintenance' => ($this->input->post('request_type') == 'cm') ? $this->input->post('preventive_maintenance') : '',
            'issues' => $this->input->post('issues'),
            'contact_person' => $this->input->post('contact_person'),
            'contact_number' => $this->input->post('contact_number'),
            'assigned_to' => $this->input->post('assigned_to'),
            'address_of_machine' => $this->input->post('addr_of_machine'),
            'updated_by' => $this->session->userdata['LOGGED_IN']['ID'],
            'updated_at' => date("Y-m-d H:i:s")
        );

        $whereCond = array('maintenance_id' => $maintenanceId);

        if ($this->common_model->update(MAINTENANCE, $data, $whereCond)) { //Update data
            $msg = 'Maintenance has been updated successfully.';
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
      @Desc   : Maintenance Form validation
      @Input 	:
      @Output	:
      @Date   : 16th March 2017
     */

    public function formValidation() {
        $this->form_validation->set_rules('request_type', 'Request Type', 'trim|required|xss_clean');
        $this->form_validation->set_rules('contact_person', 'Contact Person', 'trim|required|max_length[100]|xss_clean');
        $this->form_validation->set_rules('contact_number', 'Contact Number', 'trim|required|max_length[15]|xss_clean');
        $this->form_validation->set_rules('addr_of_machine', 'Address Of Machine', 'trim|xss_clean');
        $this->form_validation->set_rules('issues', 'Issues', 'trim|max_length[1000]|xss_clean');
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

        $this->load->view($this->viewname . '/CustomerLocationList', $data);
    }

    /*
      @Author : Maitrak Modi
      @Desc   : get Macthed Customer code list
      @Input 	:
      @Output	:
      @Date   : 22nd March 2017
     */

    public function getCustomerDetails() {

        $selCustomerCode = $this->input->post('selCustomerId'); // query data
        $searchType = $this->input->post('searchType'); // query data

        /* Query */
        $tableName = CUSTOMER_MACHINE_INFORMATION . ' as cmi';
        $fields = array('cmi.customer_id as cId, cmi.sr_number_id, cmi.zone,
            ce.customer_id, ce.customer_name, ce.customer_code, ce.location, ce.mobile_number,
            mi.inventory_id, mi.machine_serial_number, mi.machine_id, mi.asset            
            ');

        $join_tables = array(
            CUSTOMER_ENROLMENT . ' as ce' => 'cmi.customer_id = ce.customer_id',
            MACHINE_INVENTORY . ' as mi' => 'cmi.sr_number_id = mi.inventory_id'
        );

        if ($searchType == 'sr_number') {
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
                    'assigned_to' => $customerDetails['zone']
                );
            }
        }

        echo json_encode($json_customer_details);
    }

    /*
      @Author : Maitrak Modi
      @Desc   : soft delete maintenance
      @Input 	:
      @Output	:
      @Date   : 24th March 2017
     */

    public function deleteMaintenance() {

        $maintenanceId = $this->input->post('maintenanceId');

        if (!empty($maintenanceId)) {

            $tableName = MAINTENANCE;
            $data = array('is_delete' => '1');
            $where = array('maintenance_id' => $maintenanceId);

            if ($this->common_model->update($tableName, $data, $where)) {
                $msg = 'Maintenance has been deleted successfully.';
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
      @Author : Maitrak Modi
      @Desc   : get customer list based on type
      @Input 	:
      @Output	:
      @Date   : 29th May 2017
     */

    public function getCustomerCodeList($groupBy = '') {

        $tableName = CUSTOMER_MACHINE_INFORMATION . ' as cmi';
        $fields = array('ce.customer_name, ce.customer_id, ce.customer_code,
            cmi.sr_number_id, cmi.zone,
            mi.machine_serial_number');

        $join_tables = array(
            CUSTOMER_ENROLMENT . ' as ce' => 'cmi.customer_id = ce.customer_id',
            MACHINE_INVENTORY . ' as mi' => 'cmi.sr_number_id = mi.inventory_id',
        );

        $whereCond = array('ce.is_delete' => '0', 'cmi.sr_number_id !=' => 0, 'cmi.is_delete' => '0');
        $whereIn = array('cmi.machine_assign_type' => array('Installation', 'First_Installation'));

        if ($groupBy == 'name') {
            $groupBy = array('ce.customer_name');
        }
        if ($groupBy == 'code') {
            $groupBy = array('ce.customer_code');
        }
        if ($groupBy == 'serial_number') {
            $groupBy = array('cmi.sr_number_id');
        }

        $data['customerCodeRecords'] = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', '', '', '', '', $groupBy, '', '', $whereIn);
        //echo $this->db->last_query(); exit;
        return $data['customerCodeRecords'];
    }

    /*
      @Author : Maitrak Modi
      @Desc   : get assigned Maintenance Details
      @Input 	:
      @Output	:
      @Date   : 29th May 2017
     */

    protected function getMaintenanceDetails($maintenanceId = '') {

        $tableName = MAINTENANCE . ' as m';

        $fields = array('m.contact_person, m.contact_number, m.address_of_machine, m.issues,
                        ce.customer_name, ce.customer_code, ce.location,
                        mi.machine_id,
                        l.firstname as zone_name, l.mobile_number as zone_mobile_number');

        $join_tables = array(
            //CUSTOMER_MACHINE_INFORMATION . ' as cmi' => 'm.customer_id  = cmi.customer_id',
            CUSTOMER_ENROLMENT . ' as ce' => 'm.customer_id  = ce.customer_id',
            MACHINE_INVENTORY . ' as mi' => 'm.location_id = mi.inventory_id',
            LOGIN . ' as l' => 'm.assigned_to = l.login_id'
        );

        $whereCond = array('m.is_delete' => '0', 'm.maintenance_id' => $maintenanceId);

        $data['maintenanceRecords'] = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', '', '', '', '', '', '');

        //pr($data['maintenanceRecords']);
        //exit;
        return $data['maintenanceRecords'][0];
    }

    /**
     * 
     * @param type $maintenanceId
     */
    protected function send_maintenance_sms($maintenanceId = '') {

        $assignMachineData = $this->getMaintenanceDetails($maintenanceId);

        //pr($this->session->userdata['LOGGED_IN']);
        //exit;
        if (!empty($assignMachineData)) {

            //$zone_mobile_number = '971501512786'; //$assignMachineData['zone_mobile_number'];
            $zone_mobile_number = $assignMachineData['zone_mobile_number'];

            $zone_message_content = "Name: " . $assignMachineData['customer_name'] . "\r\n";

            //$zone_message_content .= 'Caller Name:' . $this->session->userdata['LOGGED_IN']['FIRSTNAME'] .' '.$this->session->userdata['LOGGED_IN']['LASTNAME'].'\r\n';
            $zone_message_content .= "Name: " . $assignMachineData['contact_person'] . "\r\n";
            $zone_message_content .= "Number: " . $assignMachineData['contact_number'] . "\r\n";

            $zone_message_content .= "Address: " . $assignMachineData['location'] . "\r\n";
            $zone_message_content .= "Machine Location: " . $assignMachineData['address_of_machine'] . "\r\n";
            $zone_message_content .= "Issue: " . $assignMachineData['issues'] . "\r\n";

            send_sms($zone_mobile_number, $zone_message_content); // send SMS functionality
        }

        return true;
    }

    /*
      @Author : Maitrak Modi
      @Desc   : send mail of maintenance
      @Input  : $maintenanceId
      @Output : return true or false
      @Date   : 4th July 2017
     */

    protected function sendMaintenanceMail($maintenanceId) {

        $maintenanceData = $this->getMaintenanceDetails($maintenanceId);

        if (!empty($maintenanceData)) {

            $find = array(
                '{CUSTOMER_NAME}',
                '{ADDRESS}',
                '{CUSTOMER_CODE}',
                '{CONTACT_PERSON}',
                '{CONTACT_NUMBER}',
                '{MACHINE_LOCATION}',
                '{MACHINE_ID}',
                '{SALES_REPRESENTATIVE}',
                '{ZONE}',
                '{ISSUES}',
            );

            $replace = array(
                'CUSTOMER_NAME' => $maintenanceData['customer_name'],
                'ADDRESS' => $maintenanceData['location'],
                'CUSTOMER_CODE' => $maintenanceData['customer_code'],
                'CONTACT_PERSON' => $maintenanceData['contact_person'],
                'CONTACT_NUMBER' => $maintenanceData['contact_number'],
                'MACHINE_LOCATION' => $maintenanceData['address_of_machine'],
                'MACHINE_ID' => $maintenanceData['machine_id'],
                'SALES_REPRESENTATIVE' => $this->session->userdata['LOGGED_IN']['FIRSTNAME'],
                'ZONE' => $maintenanceData['zone_name'],
                'ISSUES' => $maintenanceData['issues'],
            );

            //$to = 'maitrak.modi@c-metric.com'; //$getCollectionData['zone_email'];
            $to = $this->config->item('maintenance_email_id'); // Set Email id in config

            $message = '<p> Hello, </p>';
            $message .= '<p><b>Find Maintenance Details.</b></p>';
            $message .= '<p></p>';
            $message .= '<table border="1">'
                    . '<tr><td><b>Customer Name :</b></td><td>{CUSTOMER_NAME}</td></tr>'
                    . '<tr><td><b>Customer Code :</b></td><td>{CUSTOMER_CODE}</td></tr>'
                    . '<tr><td><b>Customer Address :</b></td><td>{ADDRESS}</td></tr>'
                    . '<tr><td><b>Contact Person :</b></td><td>{CONTACT_PERSON}</td></tr>'
                    . '<tr><td><b>Contact Number :</b></td><td>{CONTACT_NUMBER}</td></tr>'
                    . '<tr><td><b>Machine Location:</b></td><td>{MACHINE_LOCATION}</td></tr>'
                    . '<tr><td><b>Machine Id :</b></td><td>{MACHINE_ID}</td></tr>'
                    . '<tr><td><b>Sales Representative :</b></td><td>{SALES_REPRESENTATIVE}</td></tr>'
                    . '<tr><td><b>Zone :</b></td><td>{ZONE}</td></tr>'
                    . '<tr><td><b>Issues :</b></td><td>{ISSUES}</td></tr>';
            $message .= '</table>';

            $subject = 'New Maintenance has been placed on dated - ' . date('Y-m-d H:i:s');

            $message .= '<p> </p>';
            $message .= '<p>Thank You,</p>';
            $message .= '<p><b><i>Nestle Team<i><b></p>';

            $finalEmailBody = str_replace($find, $replace, $message);

            // echo $finalEmailBody; exit;
            return send_mail($to, $subject, $finalEmailBody, $attach = NULL);
        }
    }

}
