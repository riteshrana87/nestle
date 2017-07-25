<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CustomerMachineInformation extends CI_Controller {

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
        $tableName = CUSTOMER_MACHINE_INFORMATION . ' as cmi';
        $fields = array('cmi.customer_machine_information_id, cmi.customer_id, cmi.sr_number_id,
            ce.customer_name, ce.customer_code, ce.mobile_number, ce.sales_representative, ce.emirates_id,
            v.version_name,
            em.name as emirate_name, mi.machine_serial_number');

        $join_tables = array(
            CUSTOMER_ENROLMENT . ' as ce' => 'cmi.customer_id = ce.customer_id',
            VERSION_MASTER . ' as v' => 'cmi.version_id = v.version_id',
            EMIRATE . ' as em' => 'ce.emirates_id = em.emirate_id',
            MACHINE_INVENTORY . ' as mi' => 'cmi.sr_number_id = mi.inventory_id',
        );
        $whereCond = array('ce.is_delete' => '0', 'cmi.machine_assign_type' => 'First_Installation');

        if (!empty($searchtext)) {
            $searchtext = html_entity_decode(trim(addslashes($searchtext)));
            $where_search = '(ce.customer_name  LIKE "%' . $searchtext . '%" '
                    . 'OR ce.mobile_number LIKE "%' . $searchtext . '%" '
                    . 'OR mi.machine_serial_number LIKE "%' . $searchtext . '%" '
                    . 'OR ce.customer_code LIKE "%' . $searchtext . '%" '
                    . 'OR v.version_name LIKE "%' . $searchtext . '%" '
                    . 'OR em.name LIKE "%' . $searchtext . '%" ' . ')';

            $data['listRecords'] = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', $config['per_page'], $uri_segment, $sortfield, $sortby, '', $where_search);
            $config['total_rows'] = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', '', '', $sortfield, $sortby, '', $where_search, '', '', '1');
        } else {
            $data['listRecords'] = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', $config['per_page'], $uri_segment, $sortfield, $sortby, '', '');
            $config['total_rows'] = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', '', '', $sortfield, $sortby, '', '', '', '', '1');
        }
        //echo $this->db->last_query();exit;
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
        $data['header'] = array('menu_module' => 'masters', 'menu_child' => 'Customermachineinformation');
        $data['footerJs'] = array(
            '0' => base_url() . 'uploads/assets/js/bootstrap-datetimepicker.min.js',
            '1' => base_url() . 'uploads/custom/js/CustomerMachineInformation/CustomerMachineInformation.js'
        );

        if ($this->input->post('result_type') == 'ajax') {
            $this->load->view($this->viewname . '/ajaxList', $data);
        } else {
            $data['main_content'] = '/customerlist';
            $this->parser->parse('layouts/DefaultTemplate', $data);
        }
    }

    /*
      @Author : Ritesh Rana
      @Desc   :Customer Machine Information  Edit Function
      @Input 	: Customer Id
      @Output	:
      @Date   : 22 th May 2017
     */

    public function edit($customerId) {

        $tableName = CUSTOMER_MACHINE_INFORMATION . ' as cmi';
        $fields = array('cmi.customer_id, ss.code_name as serving_size, ce.customer_name, ce.customer_code,cmi.version_id,
            v.version_name, cmi.sr_number_id, cmi.installation_date, cmi.zone, cmi.machine_installed_location, cmi.machine_comment, cmi.machine_menu_file, cmi.machine_picture,
            mi.machine_serial_number');
        $join_tables = array(
            VERSION_MASTER . ' as v' => 'cmi.version_id = v.version_id',
            CUSTOMER_ENROLMENT . ' as ce' => 'cmi.customer_id = ce.customer_id',
            MACHINE_INVENTORY . ' as mi' => 'mi.inventory_id = cmi.sr_number_id',
            CODELOOKUP . ' as ss' => 'cmi.serving_size = ss.code_id',
        );
        $match = array('cmi.customer_id' => $customerId);
        $data['editCustomerRecord'] = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $match, '', '', '', '', '', '', '');

        if (!empty($data['editCustomerRecord'][0])) {

            $this->formValidation($customerId); // Form fields validation

            if ($this->form_validation->run() == FALSE) {

                //$table = CODELOOKUP;
                //$fields = array('*');
                //$match = array('isactive' => 'active');

                /* Start - Set Parent Child Array */
                //$nested = array();
                //$sourceData = $this->common_model->get_records($table, $fields, '', '', $match, '', '', '', '', '', '', '');
                $data['versionList'] = getVersionList(); // get version list

                /* Start - Zone List */
                $tableName = LOGIN . ' as l';
                $zoneFields = array('l.login_id as id, l.firstname as name, l.role_id, rm.role_name');
                $whereCond = array('l.status' => 'active', 'l.is_delete' => 0, 'rm.is_delete' => 0, 'rm.role_slug' => 'zone', 'rm.status' => '1'); // zone slug

                $join_tables = array(
                    ROLE_MASTER . ' as rm' => 'l.role_id = rm.role_id',
                );
                $data['zoneList'] = $this->common_model->get_records($tableName, $zoneFields, $join_tables, 'left', $whereCond, '', '', '', '', '', '', '');
                /* End - Zone List */

                /* Start - Edit data in form */
                $data['editCustomerId'] = $data['editCustomerRecord'][0]['customer_id'];
                $data['editCustomerName'] = $data['editCustomerRecord'][0]['customer_name'];
                $data['editCustomerCode'] = $data['editCustomerRecord'][0]['customer_code'];
                $data['editZone'] = $data['editCustomerRecord'][0]['zone'];
                $data['editMachineInstalledLocation'] = $data['editCustomerRecord'][0]['machine_installed_location'];
                //$data['editSerialNumber'] = $data['editCustomerRecord'][0]['sr_number_id'];
                $data['editVersion'] = $data['editCustomerRecord'][0]['version_id'];
                $data['editVersionName'] = $data['editCustomerRecord'][0]['version_name'];
                $data['editInstallationDate'] = (!empty($data['editCustomerRecord'][0]['installation_date'])) ? date('m/d/Y', strtotime($data['editCustomerRecord'][0]['installation_date'])) : '';
                $data['editMachineComment'] = $data['editCustomerRecord'][0]['machine_comment'];
                $data['editMachinePicture'] = $data['editCustomerRecord'][0]['machine_picture'];
                $data['editMachineMenuFile'] = $data['editCustomerRecord'][0]['machine_menu_file'];
                $data['editServingSize'] = $data['editCustomerRecord'][0]['serving_size'];
                $data['editMachineSerialNumber'] = $data['editCustomerRecord'][0]['machine_serial_number'];

                /* End - Edit data in form */

                $data['footerJs'] = array(
                    '0' => base_url() . 'uploads/assets/js/bootstrap-datetimepicker.min.js',
                    '1' => base_url() . 'uploads/custom/js/CustomerMachineInformation/CustomerMachineInformation.js'
                );
                $data['header'] = array('menu_module' => 'masters', 'menu_child' => 'Customermachineinformation');
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

            redirect('CustomerMachineInformation');
        }
    }

    /*
      @Author : Ritesh Rana
      @Desc   : Customer Enrolment update Data
      @Input 	:
      @Output	:
      @Date   : 22th May 2017
     */

    public function updateData($customerId) {
        // pr($_FILES);exit;
        // Updated Array Data
        $upload_dir = $this->config->item('delivery_order_upload_root_url') . 'CustomerMachineInformation';
        if (!is_dir($upload_dir)) {
            //create directory
            mkdir($upload_dir, 0777, TRUE);
        }
        //pr($_FILES['attachments']);exit;
        if (is_dir($upload_dir)) {
            $file_path = $this->config->item('machine_information_upload_path');
            $data['file_view'] = $this->viewname;
            $upload_data = uploadImage('attachments', $file_path, $data['file_view']);
            $file_name = $upload_data[0]['file_name'];
            if (!empty($file_name)) {
                $insert_data['machine_picture'] = $upload_data[0]['file_name'];
            }
        }

        if (is_dir($upload_dir)) {
            $file_path = $this->config->item('machine_information_upload_path');
            $data['file_view'] = $this->viewname;
            $machine_upload_data = uploadImage('attachments_menu', $file_path, $data['file_view']);
            $machine_file_name = $machine_upload_data[0]['file_name'];
            if (!empty($machine_file_name)) {
                $insert_data['machine_menu_file'] = $machine_upload_data[0]['file_name'];
            }
        }
        /**
         * SOFT DELETION CODE STARTS Ritesh rana
         */
        $machinesoftDeletedImages = $this->input->post('machinesoftDeletedImages');
        $MachinesoftDeletedImagesUrls = $this->input->post('MachinesoftDeletedImagesUrls');
        if (!empty($MachinesoftDeletedImagesUrls)) {
            unlink($MachinesoftDeletedImagesUrls);
        }
        if (!empty($MachinesoftDeletedImagesUrls)) {
            $file_menu_data['machine_menu_file'] = '';
            $where = array('customer_id' => $customerId);
            $this->common_model->update(CUSTOMER_MACHINE_INFORMATION, $file_menu_data, $where);
        }
        $softDeleteImagesArr = $this->input->post('softDeletedImages');
        $softDeleteImagesUrlsArr = $this->input->post('softDeletedImagesUrls');
        if (!empty($softDeleteImagesUrlsArr)) {
            unlink($softDeleteImagesUrlsArr);
        }
        if (!empty($softDeleteImagesUrlsArr)) {
            $file_data['machine_picture'] = '';
            $where = array('customer_id' => $customerId);
            $this->common_model->update(CUSTOMER_MACHINE_INFORMATION, $file_data, $where);
        }

        $insert_data['customer_id'] = $this->input->post('customer_id');
        $insert_data['version_id'] = $this->input->post('version');

        if ($this->input->post('sr_number')) {
            $insert_data['sr_number_id'] = $this->input->post('sr_number');
        }
        $insert_data['installation_date'] = date('Y-m-d', strtotime($this->input->post('installation_date')));
        $insert_data['zone'] = $this->input->post('zone');
        $insert_data['machine_assign_type'] = 'First_Installation';
        $insert_data['machine_installed_location'] = $this->input->post('machine_installed_location');
        $insert_data['machine_comment'] = $this->input->post('machine_comment');
        //$insert_data['is_assign'] = '1';
        $insert_data['created_by'] = $this->session->userdata['LOGGED_IN']['ID'];
        $insert_data['created_at'] = date("Y-m-d H:i:s");
        $insert_data['updated_by'] = $this->session->userdata['LOGGED_IN']['ID'];
        $insert_data['updated_at'] = date("Y-m-d H:i:s");


        //pr($data);exit;
        // update customer
        //$where = array('customer_id' => $customerId, );
        //echo $customerId.'<br/>' . $this->input->post('version').'<br/>'.$this->input->post('sr_number'); exit;
        $whereCond = array('customer_id' => $customerId, 'version_id' => $this->input->post('version'),'machine_assign_type' => 'First_Installation');

        if ($this->common_model->update(CUSTOMER_MACHINE_INFORMATION, $insert_data, $whereCond)) { //Update data
            //Start - IS_ASSIGN IN Machine Inventory
            $updateInventoryData = array(
                //'is_assign' => 1,
                'updated_by' => $this->session->userdata['LOGGED_IN']['ID'],
                'updated_at' => date("Y-m-d H:i:s")
            );

            $inventoryStatus = $this->getInvetoryStatus('Active');

            if (!empty($inventoryStatus)) {
                $updateInventoryData['machine_status_id'] = $inventoryStatus['code_id'];
            }

            $whereCond = array('inventory_id' => $this->input->post('sr_number'));

            if (!$this->common_model->update(MACHINE_INVENTORY, $updateInventoryData, $whereCond)) { //Update data
                $msg = $this->lang->line('error_msg');
                $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");
            }

            //$file_data['is_assign'] = '1';
            //$where = array('inventory_id' => $this->input->post('sr_number'));
            //$this->common_model->update(MACHINE_INVENTORY, $file_data, $where);
            //End - IS_ASSIGN IN Machine Inventory

            $msg = 'Machine has been assigned to the customer.'; //$this->lang->line('CUSTOMER_UPDATE_MSG');
            $this->session->set_flashdata('msg', "<div class='alert alert-success text-center'>$msg</div>");
        } else {
            // error
            $msg = $this->lang->line('error_msg');
            $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");
        }

        redirect('CustomerMachineInformation');
    }

    /*
      @Author : Maitrak Modi
      @Desc   : Customer Enrolment Form validation
      @Input 	:
      @Output	:
      @Date   : 16th March 2017
     */

    public function formValidation($id = null) {
        $this->form_validation->set_rules('customer_id', 'Customer Id', 'trim|required|max_length[100]|xss_clean');
        $this->form_validation->set_rules('customer_code', 'Customer Code', 'trim|required|max_length[100]|xss_clean');
        $this->form_validation->set_rules('version', 'Version', 'trim|required|xss_clean');
        if (empty($id)) {
            $this->form_validation->set_rules('sr_number', 'Serial Number', 'trim|required|xss_clean');
        }
        $this->form_validation->set_rules('installation_date', 'Installation Date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('zone', 'Zone', 'trim|required|xss_clean');
        $this->form_validation->set_rules('machine_installed_location', 'Machine Installed Location', 'trim|required|xss_clean');
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
                //$finalInventoryData = $machineInventoryData[0];
                $finalInventoryData = array(
                    'inventory_id' => $machineInventoryData[0]['inventory_id'],
                    'machine_serial_number' => $machineInventoryData[0]['machine_serial_number'],
                    'asset' => $machineInventoryData[0]['asset'],
                    'bmb' => $machineInventoryData[0]['bmb'],
                    'technial_status' => $machineInventoryData[0]['technial_status'],
                    'sap_purchase_date' => date('m/d/Y', strtotime($machineInventoryData[0]['sap_purchase_date'])),
                    'ta_depc_date' => date('m/d/Y', strtotime($machineInventoryData[0]['ta_depc_date'])),
                );
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

    public function deleteAssignedMachineToCustomer() {

        $customer_assigned_machine_Id = $this->input->post('customer_assigned_machine_Id');
        $assigned_machine_id = $this->input->post('assigned_machine_id');

        if (!empty($customer_assigned_machine_Id) && !empty($assigned_machine_id)) {

            $tableName = CUSTOMER_MACHINE_INFORMATION;

            $data = array(
                'sr_number_id ' => '0',
                'installation_date' => NULL,
                'zone' => NULL,
                'machine_installed_location' => '',
                'machine_comment' => '',
                'updated_by' => $this->session->userdata['LOGGED_IN']['ID'],
                'updated_at' => date("Y-m-d H:i:s")
            );

            // pr($data);
            // exit;
            $where = array('customer_machine_information_id' => $customer_assigned_machine_Id);

            if ($this->common_model->update($tableName, $data, $where)) {

                $updateInventoryData = array(
                    //'is_assign' => 1,
                    'updated_by' => $this->session->userdata['LOGGED_IN']['ID'],
                    'updated_at' => date("Y-m-d H:i:s")
                );

                $inventoryStatus = $this->getInvetoryStatus('Available');

                if (!empty($inventoryStatus)) {
                    $updateInventoryData['machine_status_id'] = $inventoryStatus['code_id'];
                }

                $whereCond = array('inventory_id' => $assigned_machine_id);

                if (!$this->common_model->update(MACHINE_INVENTORY, $updateInventoryData, $whereCond)) { //Update data
                    $msg = $this->lang->line('error_msg');
                    $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");
                }

                $msg = 'Assigned machine has been removed successfully.';
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
            echo base_url('CustomerMachineInformation');
        }
    }

    /*
      @Author : Maitrak Modi
      @Desc   : Get Inventory Status
      @Input 	:$passStatus
      @Output	: type
      @Date   : 2nd June 2017
     */

    protected function getInvetoryStatus($passStatus = '') {
        /* Start - Set Parent Child Array */
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

        $data['inventoryStatus'] = $nested['machine_status_id']['children']; // get serving size listing
        if (!empty($passStatus)) {
            //echo $passStatus; exit;
            $key = array_search($passStatus, array_column($data['inventoryStatus'], 'code_name'));

            if (!is_null($key)) {
                return $data['inventoryStatus'][$key];
            }
        } else {
            return $data['inventoryStatus'];
        }
    }

}
