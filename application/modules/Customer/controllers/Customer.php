<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {

    function __construct() {

        parent::__construct();
        /* if(checkPermission('User','view') == false)
          {
          redirect('/Dashboard');
          } */
        $this->viewname = $this->uri->segment(1);
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('form_validation', 'Session'));
    }

    /*
      @Author : Maitrak Modi
      @Desc   : Customer Enrolment Listing
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
            $this->session->unset_userdata('customer_data');
        }
        /* End - Reset All Fields */

        $searchsort_session = $this->session->userdata('customer_data'); // store data in session

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
                $sortfield = 'customer_id';
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
        $tableName = CUSTOMER_ENROLMENT . ' as ce';
        $fields = array('ce.customer_id, ce.customer_name, ce.customer_code, ce.mobile_number,
            ce.sales_representative, ce.pob, ce.emirates_id, ce.contract_available ,
            v.version_name,
            em.name as emirate_name,
            r.name as route_name');

        $join_tables = array(
            VERSION_MASTER . ' as v' => 'ce.version_id = v.version_id',
            EMIRATE . ' as em' => 'ce.emirates_id = em.emirate_id',
            ROUTE . ' as r' => 'ce.route_id = r.route_id',
        );
        $whereCond = array('ce.is_delete' => '0');

        if (!empty($searchtext)) {
            $searchtext = html_entity_decode(trim(addslashes($searchtext)));
            $where_search = '(ce.customer_name  LIKE "%' . $searchtext . '%" '
                    . 'OR ce.mobile_number LIKE "%' . $searchtext . '%" '
                    . 'OR ce.sales_representative LIKE "%' . $searchtext . '%" '
                    . 'OR ce.contract_available LIKE "%' . $searchtext . '%" '
                    . 'OR ce.pob LIKE "%' . $searchtext . '%" '
                    . 'OR v.version_name LIKE "%' . $searchtext . '%" '
                    . 'OR em.name LIKE "%' . $searchtext . '%" '
                    . 'OR r.name LIKE "%' . $searchtext . '%" ' . ')';

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
        $this->session->set_userdata('customer_data', $sortsearchpage_data);
        setActiveSession('customer_data'); // set current Session active

        $data['crnt_view'] = $this->viewname;
        /* End Pagination */

        $data['crnt_view'] = $this->viewname;
        $data['form_action_path'] = $this->viewname . '/index';

        //$data['main_content'] = '/customerlist';
        $data['header'] = array('menu_module' => 'masters', 'menu_child' => 'customer');
        $data['footerJs'] = array(
            '0' => base_url() . 'uploads/custom/js/Customer/CustomerList.js'
        );

        if ($this->input->post('result_type') == 'ajax') {
            $this->load->view($this->viewname . '/ajaxList', $data);
        } else {
            $data['main_content'] = '/customerlist';
            $this->parser->parse('layouts/DefaultTemplate', $data);
        }
    }

    /*
      @Author : Maitrak Modi
      @Desc   : Customer Enrolment Add function
      @Input 	:
      @Output	:
      @Date   : 16th March 2017
     */

    public function add() {

        $this->formValidation(); // form Validation fields

        if ($this->form_validation->run() == FALSE) {

            $data['validation'] = validation_errors();

            $data['versionList'] = getVersionList(); // get version list

            $data['emirateList'] = getMasterTableList(EMIRATE); // get emirates list

            $data['routeList'] = getMasterTableList(ROUTE); // get route list

            /* Start - Zone List */
            /*
              $tableName = LOGIN . ' as l';
              $zoneFields = array('l.login_id as id, l.firstname as name, l.role_id, rm.role_name');
              $whereCond = array('l.status' => 'active', 'l.is_delete' => 0, 'rm.is_delete' => 0, 'rm.role_slug' => 'zone', 'rm.status' => '1'); // zone slug

              $join_tables = array(
              ROLE_MASTER . ' as rm' => 'l.role_id = rm.role_id',
              );
              $data['zoneList'] = $this->common_model->get_records($tableName, $zoneFields, $join_tables, 'left', $whereCond, '', '', '', '', '', '', '');
             */
            /* End - Zone List */

            /* Start - Payment Terms List */
            /* $tableName = PAYMENT_TERMS . ' as pt';
              $zoneFields = array('pt.payment_terms_id, pt.name, pt.description ');
              $whereCond = array('pt.isactive' => 'active');

              $data['paymentTermsList'] = $this->common_model->get_records($tableName, $zoneFields, '', '', $whereCond, '', '', '', '', '', '', '');
             */
            /* End - Payment Terms List */

            $data['paymentTermsList'] = getMasterTableList(PAYMENT_TERMS); // get payment terms list
            //pr($data['paymentTermsList']);
            //exit;

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
            $data['servingSize'] = $nested['serving_size']['children']; // get serving size listing
            $data['tradingTypeList'] = $nested['trading_type_id']['children']; // Trading type list

            $data['crnt_view'] = $this->viewname;
            $data['form_action_path'] = $this->viewname . '/add';
            $data['main_content'] = '/addEdit';
            $data['screenType'] = 'add';
            $data['footerJs'] = array(
                '0' => base_url() . 'uploads/custom/js/Customer/Customer.js'
            );

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
            'customer_name' => $this->input->post('customer_name'),
            'customer_code' => $this->input->post('customer_code'),
            'mobile_number' => $this->input->post('mobile_number'),
            'sales_representative' => $this->session->userdata['LOGGED_IN']['ID'],
            'trading_type_id' => $this->input->post('trading_type'),
            'email' => $this->input->post('email'),
            'location' => $this->input->post('location'),
            'commercial_institutional' => $this->input->post('com_inst'),
            'pob' => $this->input->post('pob'),
            'new_channel_classification' => $this->input->post('new_channel_classification'),
            'contact_name' => $this->input->post('contact_name'),
            'contact_number' => $this->input->post('contact_number'),
            'emirates_id' => $this->input->post('emirates'),
            'contract_available' => $this->input->post('contract_available'),
            'customer_special_note' => $this->input->post('customer_comments'),
            'version_id' => $this->input->post('version'),
            'route_id' => $this->input->post('route'),
            'payment_terms_id' => $this->input->post('payment_terms'),
            'created_by' => $this->session->userdata['LOGGED_IN']['ID'],
            'created_at' => date("Y-m-d H:i:s"),
            'updated_by' => $this->session->userdata['LOGGED_IN']['ID'],
            'updated_at' => date("Y-m-d H:i:s")
        );

        // Insert query
        $customer_id = $this->common_model->insert(CUSTOMER_ENROLMENT, $data);

        if (!empty($customer_id)) {

            $data = array(
                'customer_id' => $customer_id,
                'version_id' => $this->input->post('version'),
                'serving_size' => $this->input->post('serving_size'),
                'created_by' => $this->session->userdata['LOGGED_IN']['ID'],
                'created_at' => date("Y-m-d H:i:s"),
                'updated_by' => $this->session->userdata['LOGGED_IN']['ID'],
                'updated_at' => date("Y-m-d H:i:s")
            );
            $this->common_model->insert(CUSTOMER_MACHINE_INFORMATION, $data);

            $msg = $this->lang->line('CUSTOMER_INSERT_MSG');
            $this->session->set_flashdata('msg', "<div class='alert alert-success text-center'>$msg</div>");
        } else {
            // error
            $msg = $this->lang->line('error_msg');
            $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");
        }

        redirect('Customer');
    }

    /*
      @Author : Maitrak Modi
      @Desc   :Customer Enrolment Edit Function
      @Input 	: Version Id
      @Output	:
      @Date   : 17 th March 2017
     */

    public function edit($customerId) {

        $tableName = CUSTOMER_ENROLMENT . ' as ce';
        $fields = array('ce.*, cmi.serving_size');
        $join_tables = array(
            CUSTOMER_MACHINE_INFORMATION . ' as cmi' => 'ce.customer_id = cmi.customer_id',
        );

        $match = array('cmi.customer_id' => $customerId);

        $data['editCustomerRecord'] = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $match, '', '', '', '', '', '', '');
        //pr($data['editCustomerRecord']);
        //exit;

        if (!empty($data['editCustomerRecord'][0])) {

            $this->formValidation($customerId); // Form fields validation

            if ($this->form_validation->run() == FALSE) {

                $table = CODELOOKUP;
                $fields = array('*');
                $match = array('isactive' => 'active');

                /* Start - Set Parent Child Array */
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
                
                $data['servingSize'] = $nested['serving_size']['children']; // get serving size listing
                $data['tradingTypeList'] = $nested['trading_type_id']['children'];

                $data['versionList'] = getVersionList(); // get version list

                $data['emirateList'] = getMasterTableList(EMIRATE); // get emirates list

                $data['routeList'] = getMasterTableList(ROUTE); // get route list

                /* Start - Payment Terms List */
                /* $tableName = PAYMENT_TERMS . ' as pt';
                  $zoneFields = array('pt.payment_terms_id, pt.name, pt.description ');
                  $whereCond = array('pt.isactive' => 'active');

                  $data['paymentTermsList'] = $this->common_model->get_records($tableName, $zoneFields, '', '', $whereCond, '', '', '', '', '', '', ''); */
                /* End - Payment Terms List */

                $data['paymentTermsList'] = getMasterTableList(PAYMENT_TERMS); // get payment terms list

                /* Start - Edit data in form */
                $data['editCustomerId'] = $data['editCustomerRecord'][0]['customer_id'];
                $data['editCustomerName'] = $data['editCustomerRecord'][0]['customer_name'];
                $data['editCustomerCode'] = $data['editCustomerRecord'][0]['customer_code'];
                $data['editMobileNumber'] = $data['editCustomerRecord'][0]['mobile_number'];
                $data['editSalesRepresantative'] = $data['editCustomerRecord'][0]['sales_representative'];
                $data['editTradingType'] = $data['editCustomerRecord'][0]['trading_type_id'];
                $data['editEmail'] = $data['editCustomerRecord'][0]['email'];
                $data['editLocation'] = $data['editCustomerRecord'][0]['location'];
                $data['editCommercialInstitutional'] = $data['editCustomerRecord'][0]['commercial_institutional'];
                $data['editPOB'] = $data['editCustomerRecord'][0]['pob'];
                $data['editNewChannelClassification'] = $data['editCustomerRecord'][0]['new_channel_classification'];
                $data['editContactName'] = $data['editCustomerRecord'][0]['contact_name'];
                $data['editContactNumber'] = $data['editCustomerRecord'][0]['contact_number'];
                $data['editEmirates'] = $data['editCustomerRecord'][0]['emirates_id'];
                $data['editCustomerSpecialNote'] = $data['editCustomerRecord'][0]['customer_special_note'];
                $data['editVersion'] = $data['editCustomerRecord'][0]['version_id'];
                $data['editRoute'] = $data['editCustomerRecord'][0]['route_id'];
                $data['editServingSize'] = $data['editCustomerRecord'][0]['serving_size'];
                $data['editContractAvailable'] = $data['editCustomerRecord'][0]['contract_available'];
                $data['editPaymentTermsId'] = $data['editCustomerRecord'][0]['payment_terms_id'];
                /* End - Edit data in form */
                
                $data['footerJs'] = array(
                    '0' => base_url() . 'uploads/custom/js/Customer/Customer.js'
                );
                $data['crnt_view'] = $this->viewname;
                $data['form_action_path'] = $this->viewname . '/edit/' . $customerId;
                $data['main_content'] = '/addEdit';

                $data['validation'] = validation_errors();

                $data['screenType'] = 'edit';
                $this->parser->parse('layouts/DefaultTemplate', $data);
            } else {
                // success form
                $this->updateData($customerId);
            }
        } else {
            // error
            $msg = $this->lang->line('error_msg');
            $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");

            redirect('Customer');
        }
    }

    /*
      @Author : Ritesh Rana
      @Desc   : Customer Enrolment update Data
      @Input 	:
      @Output	:
      @Date   : 19th May 2017
     */

    public function updateData($customerId) {

        // Updated Array Data
        $data = array(
            'customer_name' => $this->input->post('customer_name'),
            'mobile_number' => $this->input->post('mobile_number'),
            'sales_representative' => $this->session->userdata['LOGGED_IN']['ID'],
            'trading_type_id' => $this->input->post('trading_type'),
            'email' => $this->input->post('email'),
            'location' => $this->input->post('location'),
            'commercial_institutional' => $this->input->post('com_inst'),
            'pob' => $this->input->post('pob'),
            'new_channel_classification' => $this->input->post('new_channel_classification'),
            'contact_name' => $this->input->post('contact_name'),
            'contact_number' => $this->input->post('contact_number'),
            'emirates_id' => $this->input->post('emirates'),
            'contract_available' => $this->input->post('contract_available'),
            'customer_special_note' => $this->input->post('customer_comments'),
            'version_id' => $this->input->post('version'),
            'route_id' => $this->input->post('route'),
            'payment_terms_id' => $this->input->post('payment_terms'),
            'updated_by' => $this->session->userdata['LOGGED_IN']['ID'],
            'updated_at' => date("Y-m-d H:i:s")
        );

        // update customer
        $where = array('customer_id' => $customerId);

        if ($this->common_model->update(CUSTOMER_ENROLMENT, $data, $where)) { //Update data
            
            $data = array(
                'version_id' => $this->input->post('version'),
                'serving_size' => $this->input->post('serving_size'),
                'created_by' => $this->session->userdata['LOGGED_IN']['ID'],
                'created_at' => date("Y-m-d H:i:s"),
                'updated_by' => $this->session->userdata['LOGGED_IN']['ID'],
                'updated_at' => date("Y-m-d H:i:s")
            );

            $this->common_model->update(CUSTOMER_MACHINE_INFORMATION, $data, $where);

            $msg = $this->lang->line('CUSTOMER_UPDATE_MSG');
            $this->session->set_flashdata('msg', "<div class='alert alert-success text-center'>$msg</div>");
        } else {
            // error
            $msg = $this->lang->line('error_msg');
            $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");
        }

        redirect('Customer');
    }

    /*
      @Author : Maitrak Modi
      @Desc   : Customer Enrolment Form validation
      @Input 	:
      @Output	:
      @Date   : 16th March 2017
     */

    public function formValidation($id = null) {
        $this->form_validation->set_rules('customer_name', 'Customer Name', 'trim|required|max_length[100]|xss_clean');
        if (empty($id)) {
            $this->form_validation->set_rules('customer_code', 'Customer Code', 'trim|required|max_length[100]|xss_clean');
        }

        $this->form_validation->set_rules('mobile_number', 'Mobile Number', 'trim|required|max_length[15]|xss_clean');
        $this->form_validation->set_rules('trading_type', 'Trading Type', 'trim|required|xss_clean');
        $this->form_validation->set_rules('location', 'Location', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
        $this->form_validation->set_rules('com_inst', 'Commercial/Institutional', 'trim|required|max_length[50]|xss_clean');
        $this->form_validation->set_rules('pob', 'POB', 'trim|required|numeric|max_length[10]|xss_clean');
        $this->form_validation->set_rules('new_channel_classification', 'New Channel Classification', 'trim|required|max_length[100]|xss_clean');
        $this->form_validation->set_rules('emirates', 'Emirates', 'trim|required|xss_clean');
        $this->form_validation->set_rules('contract_available', 'Contract Available', 'trim|required|xss_clean');
        $this->form_validation->set_rules('version', 'Version', 'trim|required|xss_clean');
        $this->form_validation->set_rules('route', 'Route', 'trim|required|xss_clean');
        $this->form_validation->set_rules('payment_terms', 'Payment Terms', 'trim|required|xss_clean');
    }

    /*
      @Author : Maitrak Modi
      @Desc   : Machine Inventory get Selected Version data
      @Input 	:
      @Output	:
      @Date   : 17th March 2017
     */

    public function getSelectedVersionData() {

        $selversionId = trim($this->input->post('selVersionId'));
        $editSerialNumber = trim($this->input->post('cuurentSRNumber'));

        $sr_number_drpdwn = '';

        $finalVersionData = array();

        if (!empty($selversionId)) {

            // fetch Version Data
            $tableName = MACHINE_INVENTORY . ' as mi';

            $fields = array('GROUP_CONCAT(mi.inventory_id) as inventory_id, GROUP_CONCAT(mi.machine_serial_number) as sr_number,
            v.version_id, v.version_name,
            ms.code_name as machine_current_status,
            ch.code_name as hot_cold_name,
            cg.code_name as gen_name,
            cma.code_name as machine_abb_name,
            cmm.code_name as machine_mpr_name,
            cbv.code_name as bev_type_name');

            $join_tables = array(
                VERSION_MASTER . ' as v' => 'mi.version_id = v.version_id',
                CODELOOKUP . ' as ms' => 'mi.machine_status_id = ms.code_id',
                CODELOOKUP . ' as ch' => 'v.hot_cold_type = ch.code_id',
                CODELOOKUP . ' as cg' => 'v.gen = cg.code_id',
                CODELOOKUP . ' as cma' => 'v.machine_abb = cma.code_id',
                CODELOOKUP . ' as cmm' => 'v.machine_mpr = cmm.code_id',
                CODELOOKUP . ' as cbv' => 'v.bev_type = cbv.code_id',
            );

            //$whereMatch = array('v.version_id' => $selversionId, 'v.version_isactive' => 'active', 'mi.is_assign' => 0);
            $whereMatch = array('v.version_id' => $selversionId, 'v.version_isactive' => 'active', 'ms.code_name' => 'Available', 'mi.is_delete' => '0');
            $versionData = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereMatch, '', '', '', '', '', '', '');

            if (!empty($versionData[0])) {

                if (!empty($versionData[0]['inventory_id'])) {
                    $inventoryIdList = explode(',', $versionData[0]['inventory_id']); // inventory id list
                }

                if (!empty($versionData[0]['sr_number'])) {
                    $sr_number_drpdwn = '<option value = "">Select Serial Number</option>';
                    $srNumberList = explode(',', $versionData[0]['sr_number']); // sr number list

                    foreach ($srNumberList as $sr_number_key => $sr_number_value) {
                        $sr_number_drpdwn .= "<option value='" . $inventoryIdList[$sr_number_key] . "' " . set_select('sr_number', (isset($editSerialNumber) ? $editSerialNumber : ''), $inventoryIdList[$sr_number_key] == (isset($editSerialNumber) ? $editSerialNumber : '')) . ">" . $sr_number_value . "</option>";
                        //$sr_number_drpdwn .= '<option value = "' . $inventoryIdList[$sr_number_key] . '" >' . $sr_number_value . '</option>';
                    }
                }
                //$versionData[0]['sr_number_drpdwn'] = $sr_number_drpdwn;
                $finalVersionData = $versionData[0];
            }
        }
        $returnData = array(
            'versionData' => $finalVersionData,
            'srDrpDwnData' => $sr_number_drpdwn
        );
        echo json_encode($returnData);
    }

    /*
      @Author : Maitrak Modi
      @Desc   : Machine Inventory get Selected Serial Number
      @Input 	:
      @Output	:
      @Date   : 17th March 2017
     */

    public function getSelectedSrNumberData() {

        $selInvnetoryId = trim($this->input->post('selInvnetoryId'));
        //$returnData = array();
        $finalInventoryData = array();
        $statusCode = 'error';
        $errormsg = $this->lang->line('error_msg');
        $msg = "<div class='alert alert-danger text-center'>$errormsg</div>";

        if (!empty($selInvnetoryId)) {

            // fetch Machine Data
            $tableName = MACHINE_INVENTORY . ' as mi';

            $fields = array('mi.inventory_id, mi.machine_serial_number,
            mi.asset, mi.bmb, mi.technial_status, mi.sap_purchase_date,
            mi.ta_depc_date'
            );

            $whereMatch = array('mi.inventory_id' => $selInvnetoryId);
            $machineInventoryData = $this->common_model->get_records($tableName, $fields, '', '', $whereMatch, '', '', '', '', '', '', '');

            if (!empty($machineInventoryData[0])) {

                $statusCode = 'success';
                $msg = 'success';
                $finalInventoryData = $machineInventoryData[0];
            }
            //pr($returnData);
        }
        //pr($finalInventoryData); exit;
        $returnData = array(
            'statusCode' => $statusCode,
            'msg' => $msg,
            'inventoryData' => $finalInventoryData
        );

        echo json_encode($returnData);
    }

    /*
      @Author : Maitrak Modi
      @Desc   : Customer soft delete inventory
      @Input 	:
      @Output	:
      @Date   : 20th March 2017
     */

    public function deleteCustomer() {

        $customerId = $this->input->post('customerId');

        if (!empty($customerId)) {

            $tableName = CUSTOMER_ENROLMENT;
            $data = array('is_delete' => '1');
            $where = array('customer_id' => $customerId);

            if ($this->common_model->update($tableName, $data, $where)) {
                $msg = 'Customer has been deleted succssfully.';
                //$customMsg = "<div class='alert alert-success text-center'>$msg</div>";
                $statusCode = 'success';
                $this->session->set_flashdata('msg', "<div class='alert alert-success text-center'>$msg</div>");
            } else {
                // error
                $msg = $this->lang->line('error_msg');
                // $customMsg = "<div class='alert alert-danger text-center'>$msg</div>";
                $statusCode = 'error';
                $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");
            }
            /*
              $returnData = array(
              'msg' => $customMsg,
              //  'statusCode' => $statusCode,
              );
              echo json_encode($returnData);
             */
            echo base_url('Customer');
        }
    }

    /*
      @Author : Maitrak Modi
      @Desc   :Customer Enrolment Edit Function
      @Input 	: Version Id
      @Output	:
      @Date   : 17 th March 2017
     */

    public function machineInformation($customerId) {

        $tableName = CUSTOMER_ENROLMENT;
        $fields = array('*');
        $match = array('customer_id' => $customerId);

        $data['editCustomerRecord'] = $this->common_model->get_records($tableName, $fields, '', '', $match, '', '', '', '', '', '', '');
        if (!empty($data['editCustomerRecord'][0])) {

            $this->formValidation(); // Form fields validation

            if ($this->form_validation->run() == FALSE) {

                $table = CODELOOKUP;
                $fields = array('*');
                $match = array('isactive' => 'active',);

                /* Start - Set Parent Child Array */
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

                $data['tradingTypeList'] = $nested['trading_type_id']['children'];

                $data['versionList'] = getVersionList(); // get version list

                $data['emirateList'] = getMasterTableList(EMIRATE); // get emirates list

                $data['routeList'] = getMasterTableList(ROUTE); // get route list
                //$data['zoneList'] = getMasterTableList(ZONE); // get zone list

                $data['paymentTermsList'] = getMasterTableList(PAYMENT_TERMS); // get payment terms list

                $data['paymentFacilityList'] = getMasterTableList(PAYMENT_FACILITY); // get payment facility list

                /* Start - Zole List */
                $tableName = LOGIN . ' as l';
                $zoneFields = array('l.login_id as id, l.firstname as name, l.role_id, rm.role_name');
                $whereCond = array('l.status' => 'active', 'l.is_delete' => 0, 'rm.is_delete' => 0, 'rm.role_slug' => 'zone', 'rm.status' => '1'); // zone slug

                $join_tables = array(
                    ROLE_MASTER . ' as rm' => 'l.role_id = rm.role_id',
                );
                $data['zoneList'] = $this->common_model->get_records($tableName, $zoneFields, $join_tables, 'left', $whereCond, '', '', '', '', '', '', '');
                /* End - Zole List */

                /* Start - Edit data in form */
                $data['editCustomerId'] = $data['editCustomerRecord'][0]['customer_id'];
                $data['editCustomerName'] = $data['editCustomerRecord'][0]['customer_name'];
                $data['editCustomerCode'] = $data['editCustomerRecord'][0]['customer_code'];
                $data['editCustomerContactNumber'] = $data['editCustomerRecord'][0]['customer_contact_number'];
                $data['editSalesRepresantative'] = $data['editCustomerRecord'][0]['sales_representative'];
                $data['editTradingType'] = $data['editCustomerRecord'][0]['trading_type_id'];
                $data['editLocation'] = $data['editCustomerRecord'][0]['location'];
                $data['editCommercialInstitutional'] = $data['editCustomerRecord'][0]['commercial_institutional'];
                $data['editPOB'] = $data['editCustomerRecord'][0]['pob'];
                $data['editNewChannelClassification'] = $data['editCustomerRecord'][0]['new_channel_classification'];
                $data['editRTM'] = $data['editCustomerRecord'][0]['rtm'];
                $data['editContactName'] = $data['editCustomerRecord'][0]['contact_name'];
                $data['editContactNumber'] = $data['editCustomerRecord'][0]['contact_number'];
                $data['editEmirates'] = $data['editCustomerRecord'][0]['emirates_id'];
                $data['editZone'] = $data['editCustomerRecord'][0]['zone_id'];
                $data['editCustomerSpecialNote'] = $data['editCustomerRecord'][0]['customer_special_note'];
                $data['editSerialNumber'] = $data['editCustomerRecord'][0]['inventory_id'];
                $data['editVersion'] = $data['editCustomerRecord'][0]['version_id'];
                $data['editInstallationDate'] = date('d/m/Y', strtotime($data['editCustomerRecord'][0]['installation_date']));
                $data['editMachineSpecialNote'] = $data['editCustomerRecord'][0]['machine_info_special_note'];
                $data['editRoute'] = $data['editCustomerRecord'][0]['route_id'];
                $data['editPaymentTerms'] = $data['editCustomerRecord'][0]['payment_terms_id'];
                $data['editPaymentFacility'] = $data['editCustomerRecord'][0]['payment_facility_id'];
                $data['editCreditLimit'] = $data['editCustomerRecord'][0]['credit_limit'];
                $data['editOtherSpecialNote'] = $data['editCustomerRecord'][0]['other_special_note'];
                $data['editContractAvailable'] = $data['editCustomerRecord'][0]['contract_available'];
                $data['editValid'] = $data['editCustomerRecord'][0]['customer_valid'];
                /* End - Edit data in form */

                $data['footerJs'] = array(
                    '0' => base_url() . 'uploads/custom/js/Customer/Customer.js'
                );

                $data['crnt_view'] = $this->viewname;
                $data['form_action_path'] = $this->viewname . '/edit/' . $customerId;
                $data['main_content'] = '/machineInformation';

                $data['validation'] = validation_errors();

                $data['screenType'] = 'edit';
                $this->parser->parse('layouts/DefaultTemplate', $data);
            } else {
                // success form
                $this->updateData($customerId);
            }
        } else {
            // error
            $msg = $this->lang->line('error_msg');
            $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");

            redirect('Customer');
        }
    }

    public function isDuplicateCustomerCode() {
        $customer_code = $this->input->post('customer_code');
        $tableName = CUSTOMER_ENROLMENT . ' as ce';
        $fields = array('ce.customer_code,ce.customer_name');

        if (!empty($customer_code)) {
            $match = array('ce.customer_code' => $customer_code, 'is_delete' => '0');
        }
        $duplicateCode = $this->common_model->get_records($tableName, $fields, '', '', $match, '', '', '', '', '', '', '');
        $count = count($duplicateCode);
        if (isset($duplicateCode) && empty($duplicateCode) && $count == 0) {
            echo 1;
        } else {
            echo 0;
        }
    }

}
