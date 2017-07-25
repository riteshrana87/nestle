<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MachineAssignment extends CI_Controller {

    function __construct() {
        parent::__construct();
        /* if(checkPermission('User','view') == false)
          {
          redirect('/Dashboard');
          } */
        $this->viewname = $this->uri->segment(1);
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('form_validation', 'Session', 'upload'));
    }

    /*
      @Author : Ritesh Rana
      @Desc   : Machine Assignment Listing
      @Input 	:
      @Output	:
      @Date   : 18th may 2017
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
            $this->session->unset_userdata('machine_assign_data');
        }
        /* End - Reset All Fields */

        $searchsort_session = $this->session->userdata('machine_assign_data'); // store data in session

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
                $sortfield = 'customer_machine_information_id';
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
//$tableName = CUSTOMER_ENROLMENT . ' as ce';
        $fields = array('cmi.customer_machine_information_id, cmi.customer_id, cmi.version_id, cmi.sr_number_id, cmi.machine_assign_type, cmi.installation_date,
            ce.customer_code, ce.customer_name,
            mi.machine_serial_number,
            v.version_name,
            r.name as route_name');

        $join_tables = array(
            CUSTOMER_ENROLMENT . ' as ce' => 'cmi.customer_id = ce.customer_id',
            MACHINE_INVENTORY . ' as mi' => 'cmi.sr_number_id = mi.inventory_id',
            VERSION_MASTER . ' as v' => 'cmi.version_id = v.version_id',
            ROUTE . ' as r' => 'ce.route_id = r.route_id',
        );
        $whereCond = array('cmi.is_delete' => '0', 'ce.is_delete' => '0', 'cmi.machine_assign_type!=' => 'First_Installation');

        if (!empty($searchtext)) {
            $searchtext = html_entity_decode(trim(addslashes($searchtext)));
            $where_search = '(cmi.machine_assign_type  LIKE "%' . $searchtext . '%" '
                    . 'OR cmi.installation_date LIKE "%' . $searchtext . '%" '
                    . 'OR ce.customer_name LIKE "%' . $searchtext . '%" '
                    . 'OR ce.customer_code LIKE "%' . $searchtext . '%" '
                    . 'OR mi.machine_serial_number LIKE "%' . $searchtext . '%" '
                    . 'OR v.version_name LIKE "%' . $searchtext . '%" '
                    . ')';

            $data['listRecords'] = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', $config['per_page'], $uri_segment, $sortfield, $sortby, '', $where_search);
            $config['total_rows'] = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', '', '', $sortfield, $sortby, '', $where_search, '', '', '1');
        } else {

            $data['listRecords'] = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', $config['per_page'], $uri_segment, $sortfield, $sortby, '', '');
            $config['total_rows'] = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', '', '', $sortfield, $sortby, '', '', '', '', '1');
        }

        /* pr($data['listRecords'] );
          exit; */
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
        $this->session->set_userdata('machine_assign_data', $sortsearchpage_data);
        setActiveSession('machine_assign_data'); // set current Session active

        $data['crnt_view'] = $this->viewname;
        /* End Pagination */

        $data['crnt_view'] = $this->viewname;
        $data['form_action_path'] = $this->viewname . '/index';

        $data['header'] = array('menu_module' => 'order_assignment', 'menu_child' => 'machine_assignment');


        $data['footerJs'] = array(
            '0' => base_url() . 'uploads/custom/js/MachineAssignment/MachineAssignment.js'
        );
        if ($this->input->post('result_type') == 'ajax') {
            $this->load->view($this->viewname . '/ajaxList', $data);
        } else {
            $data['main_content'] = '/MachineAssignment';
            $this->parser->parse('layouts/DefaultTemplate', $data);
        }
    }

    /*
      @Author : Ritesh Rana
      @Desc   :machine assignment insert Function
      @Input 	: customer id
      @Output	:
      @Date   : 18th May 2017
     */

    public function assignment() {

        $assignment_data = $this->input->post('assignment_type');

        $this->formValidation($assignment_data); // Form fields validation

        if ($this->form_validation->run() == FALSE) {

            $data['customerCodeList'] = $this->getCustomerCodeList(); // customer code list
            $data['customerNameList'] = $this->getCustomerNameList(); // customer name list

            $data['footerJs'] = array(
                '0' => base_url() . 'uploads/assets/js/bootstrap-datetimepicker.min.js',
                '1' => base_url() . 'uploads/custom/js/MachineAssignment/MachineAssignment.js',
                '2' => base_url() . 'uploads/custom/js/MachineAssignment/Installation.js',
                '3' => base_url() . 'uploads/custom/js/MachineAssignment/Pullout.js',
                '4' => base_url() . 'uploads/custom/js/MachineAssignment/Replacement.js',
            );

            $data['crnt_view'] = $this->viewname;
            $data['form_action_path'] = $this->viewname . '/assignment/';
            $data['header'] = array('menu_module' => 'order_assignment', 'menu_child' => 'machine_assignment');
            $data['main_content'] = '/AddMachineAssignment';
            $data['validation'] = validation_errors();

            $data['screenType'] = 'edit';
            $this->parser->parse('layouts/DefaultTemplate', $data);
        } else {

            if ($assignment_data == 'installation') {
// success form
                $this->insertInstallationData();
            }

            if ($assignment_data == 'pull_out') {
                $this->UpdatePullOutData(); // Update Pullout data
            }

            if ($assignment_data == 'replacement') {
                $this->UpdateReplacementData(); // Update Replacement data
            }
        }
    }

    /*
      @Author : Ritesh Rana
      @Desc   : Get HTML by Assignment type
      @Input  :
      @Output :
      @Date   : 18th May 2017
     */

    function assignmentData() {

        $assignment_data = $this->input->post('assignment_type');
        $selCustomerId = $this->input->post('customerId');

        if (!empty($assignment_data)) {

            /* Start - codelook up table data */
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
            $data['pulloutLocationList'] = $nested['pullout_location']['children']; // get pull out listing
            /* End - codelook up table data */

            /* Start - Zone List */
            $tableName = LOGIN . ' as l';
            $zoneFields = array('l.login_id as id, l.firstname as name, l.role_id, rm.role_name');
            $whereCond = array('l.status' => 'active', 'l.is_delete' => 0, 'rm.is_delete' => 0, 'rm.role_slug' => 'zone', 'rm.status' => '1'); // zone slug

            $join_tables = array(
                ROLE_MASTER . ' as rm' => 'l.role_id = rm.role_id',
            );
            $data['zoneList'] = $this->common_model->get_records($tableName, $zoneFields, $join_tables, 'left', $whereCond, '', '', '', '', '', '', '');
            /* End - Zone List */

            // INSTALLATION  ASSIGN TYPE DATA
            if ($assignment_data == 'installation') {
                $data['versionList'] = getVersionList(); // get version list
                $this->load->view($this->viewname . '/installation', $data);
            }
        }

// PULL OUT ASSIGN TYPE DATA
        if ($assignment_data == 'pull_out') {

            $tableName = CUSTOMER_MACHINE_INFORMATION . ' as cmi';
            $fields = array('cmi.customer_machine_information_id, cmi.customer_id, cmi.version_id,  vm.version_name');

            $join_tables = array(
                VERSION_MASTER . ' as vm' => 'cmi.version_id = vm.version_id'
            );

            $versionGroupBy = 'cmi.version_id';
            $whereCond = array('cmi.customer_id' => $selCustomerId, 'cmi.machine_assign_type' => 'Installation', 'vm.version_isactive' => 'active', 'cmi.is_delete' => '0');
            $data['versionList'] = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', '', '', '', '', $versionGroupBy, '');

            $this->load->view($this->viewname . '/pullOut', $data);
        }

// REPLACEMENT ASSIGN TYPE DATA
        if ($assignment_data == 'replacement') {

            /* Replacement Section */
            $tableName = CUSTOMER_MACHINE_INFORMATION . ' as cmi';
            $fields = array('cmi.customer_machine_information_id, cmi.customer_id, cmi.version_id,  vm.version_name');

            $join_tables = array(
                VERSION_MASTER . ' as vm' => 'cmi.version_id = vm.version_id',
            );

            $versionGroupBy = 'cmi.version_id';
            $whereCond = array('cmi.customer_id' => $selCustomerId, 'cmi.machine_assign_type' => 'Installation', 'vm.version_isactive' => 'active', 'cmi.is_delete' => '0');
            $data['versionListReplecement'] = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', '', '', '', '', $versionGroupBy, '');
            /* Replacement Section */

            /* Assign Section */
            $data['versionListAssign'] = getVersionList(); // get version list
            /* Assign Section */

            $this->load->view($this->viewname . '/replacement', $data);
        }
    }

    /*     * ******************************************* START - INSTALLATION ********************************************************** */

    /*
      @Author : Maitrak Modi
      @Desc   : Machine Assigment data insertData
      @Input 	:
      @Output	:
      @Date   : 17th March 2017
     */

    public function insertInstallationData() {

        $machineData = array(
            'customer_id' => $this->input->post('customer_id'),
            'version_id' => $this->input->post('version_installation'),
            'sr_number_id' => $this->input->post('sr_number_installation'),
            'installation_date' => date('Y-m-d', strtotime($this->input->post('installation_date'))),
            'zone' => $this->input->post('zone'),
            'machine_installed_location' => $this->input->post('machine_installed_location'),
            'serving_size' => $this->input->post('serving_size'),
            'machine_comment' => $this->input->post('machine_comment'),
            'machine_assign_type' => ucfirst($this->input->post('assignment_type')),
            //'created_by' => $this->session->userdata['LOGGED_IN']['ID'],
            //'created_at' => date("Y-m-d H:i:s"),
            'updated_by' => $this->session->userdata['LOGGED_IN']['ID'],
            'updated_at' => date("Y-m-d H:i:s")
        );

        $getMachineData = $this->getAllMachineDetails($machineData); // get details

        if ($getMachineData) {
            //Update Query
            $tableName = CUSTOMER_MACHINE_INFORMATION;
            $whereCond = array('customer_id' => $machineData['customer_id'], 'version_id' => $machineData['version_id'], 'sr_number_id' => $machineData['sr_number_id']);
            $machineAssignId = $this->common_model->update($tableName, $machineData, $whereCond);
        } else {

            $machineData['created_by'] = $this->session->userdata['LOGGED_IN']['ID'];
            $machineData['created_at'] = date("Y-m-d H:i:s");
            // Insert query
            $machineAssignId = $this->common_model->insert(CUSTOMER_MACHINE_INFORMATION, $machineData);
        }

        if ($machineAssignId) {

            $updateInventoryData = array(
                //'is_assign' => 1,
                'updated_by' => $this->session->userdata['LOGGED_IN']['ID'],
                'updated_at' => date("Y-m-d H:i:s")
            );

            $inventoryStatus = $this->getInvetoryStatus('Active');

            if (!empty($inventoryStatus)) {
                $updateInventoryData['machine_status_id'] = $inventoryStatus['code_id'];
            }

            $whereCond = array('inventory_id' => $this->input->post('sr_number_installation'));

            if (!$this->common_model->update(MACHINE_INVENTORY, $updateInventoryData, $whereCond)) { //Update data
                $msg = $this->lang->line('error_msg');
                $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");
            }

            if (!empty($_FILES)) {

                if (!empty($_FILES['machine_picture']['name'])) {
                    $this->uploadAttachment($machineAssignId, 'machine_picture');
                }

                if (!empty($_FILES['machine_menu_file']['name'])) {
                    $this->uploadAttachmentMenu($machineAssignId, 'machine_menu_file');
                }
            }

            /* if (!$this->uploadAttachment($machineAssignId, 'machine_picture') || !$this->uploadAttachmentMenu($machineAssignId, 'machine_menu_file')) { // File upload function call
              $msg = $this->lang->line('error_msg');
              $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");
              } */

            /* if (!$this->uploadAttachmentMenu($machineAssignId, 'attachment_menu')) { // File upload function call
              $msg = $this->lang->line('error_msg');
              $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");
              } */

            //MAILING FUNCTION
            //$this->sendMailToZone($machineData, 'Installation');

            $msg = 'Machine has been assigned successfully.';
            $this->session->set_flashdata('msg', "<div class='alert alert-success text-center'>$msg</div>");
        } else {
            // error
            $msg = $this->lang->line('error_msg');
            $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");
        }

        redirect($this->viewname);
        //pr($machineData);
        //exit;
    }

    /*
      @Author : Maitrak Modi
      @Desc   : Machine Inventory get Selected Version data
      @Input  :
      @Output :
      @Date   : 22nd May 2017
     */

    public function getSelectedVersionData() {

        $selversionId = trim($this->input->post('selVersionId'));

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

                        $sr_number_drpdwn .= "<option value='" . $inventoryIdList[$sr_number_key] . "' >" . $sr_number_value . "</option>";
                        //$sr_number_drpdwn .= '<option value = "' . $inventoryIdList[$sr_number_key] . '" >' . $sr_number_value . '</option>';
                    }
                }
                //$versionData[0]['pm_date'] = date('y-m-d');
                //$versionData[0]['last_pm_days'] = date('y-m-d');

                $finalVersionData = $versionData[0];
            }
        }

        $returnData = array(
            'versionData' => $finalVersionData,
            'srDrpDwnData' => $sr_number_drpdwn
        );
        // pr($returnData);
        // exit;
        echo json_encode($returnData);
    }

    /*
      @Author : Maitrak Modi
      @Desc   : Machine Inventory get Selected Serial Number
      @Input  :
      @Output :
      @Date   : 22nd May 2017
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
            mi.ta_depc_date,
            ts.code_name as machine_tech_status'
            );

            $join_tables = array(
                CODELOOKUP . ' as ts' => 'mi.technial_status = ts.code_id',
            );

            $whereMatch = array('mi.inventory_id' => $selInvnetoryId, 'mi.is_delete' => '0');
            $machineInventoryData = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereMatch, '', '', '', '', '', '', '');

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

    /*     * ******************************************* END - INSTALLATION ********************************************************** */


    /*     * ******************************************** START - PULL OUT ************************************************************ */

    /*
      @Author : Maitrak Modi
      @Desc   : Machine Inventory get Selected Version data for Pull Out
      @Input  :
      @Output :
      @Date   : 22nd May 2017
     */

    public function getVersionDataPullOut() {

        $selversionId = trim($this->input->post('selVersionId'));
        $selCustomerId = trim($this->input->post('selCustomerId'));

        $sr_number_drpdwn = '';

        $finalVersionData = array();

        if (!empty($selversionId)) {

            // fetch Version Data

            $tableName = CUSTOMER_MACHINE_INFORMATION . ' as cmi';

            $fields = array('GROUP_CONCAT(mi.inventory_id) as inventory_id, GROUP_CONCAT(mi.machine_serial_number) as sr_number,
            v.version_id, v.version_name,
            ms.code_name as machine_status,
            ch.code_name as hot_cold_name,
            cg.code_name as gen_name,
            cma.code_name as machine_abb_name,
            cmm.code_name as machine_mpr_name,
            cbv.code_name as bev_type_name');

            $join_tables = array(
                MACHINE_INVENTORY . ' as mi' => 'mi.inventory_id = cmi.sr_number_id',
                VERSION_MASTER . ' as v' => 'cmi.version_id = v.version_id',
                CODELOOKUP . ' as ms' => 'mi.machine_status_id = ms.code_id',
                CODELOOKUP . ' as ch' => 'v.hot_cold_type = ch.code_id',
                CODELOOKUP . ' as cg' => 'v.gen = cg.code_id',
                CODELOOKUP . ' as cma' => 'v.machine_abb = cma.code_id',
                CODELOOKUP . ' as cmm' => 'v.machine_mpr = cmm.code_id',
                CODELOOKUP . ' as cbv' => 'v.bev_type = cbv.code_id',
            );

            //  $groupBy = 'cmi.sr_number_id';
            $whereMatch = array('v.version_id' => $selversionId, 'v.version_isactive' => 'active', 'ms.code_name' => 'Active', 'cmi.customer_id' => $selCustomerId, 'cmi.is_delete' => '0', 'mi.is_delete' => '0');
            $versionData = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereMatch, '', '', '', '', '', '', '');
            //echo $this->db->last_query();
            //exit;
            //pr($versionData);
            //exit;
            if (!empty($versionData[0])) {

                if (!empty($versionData[0]['inventory_id'])) {
                    $inventoryIdList = explode(',', $versionData[0]['inventory_id']); // inventory id list
                }

                if (!empty($versionData[0]['sr_number'])) {
                    $sr_number_drpdwn = '<option value = "">Select Serial Number</option>';
                    $srNumberList = explode(',', $versionData[0]['sr_number']); // sr number list

                    foreach ($srNumberList as $sr_number_key => $sr_number_value) {
                        $sr_number_drpdwn .= "<option value='" . $inventoryIdList[$sr_number_key] . "' >" . $sr_number_value . "</option>";
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
      @Input  :
      @Output :
      @Date   : 22nd May 2017
     */

    public function getSrNumberDataPullOut() {

        $selInvnetoryId = trim($this->input->post('selInvnetoryId'));
        $selVersionId = trim($this->input->post('selVersionId'));

//$returnData = array();
        $finalInventoryData = array();
        $statusCode = 'error';
        $errormsg = $this->lang->line('error_msg');
        $msg = "<div class='alert alert-danger text-center'>$errormsg</div>";

        if (!empty($selInvnetoryId)) {

// fetch Machine Data
            $tableName = CUSTOMER_MACHINE_INFORMATION . ' as cmi';

            $fields = array('mi.inventory_id, mi.machine_serial_number,
            mi.asset, mi.bmb, mi.technial_status, mi.sap_purchase_date,
            mi.ta_depc_date, 
            cmi.customer_machine_information_id, cmi.customer_id, cmi.installation_date, cmi.machine_assign_type, cmi.machine_installed_location, 
            cmi.machine_comment, cmi.machine_picture, cmi.machine_menu_file, cmi.serving_size,
            cu.code_name as serving_size_name,
            pl.code_name as pullout_location,
            l.firstname as zone_name'
            );

            $join_tables = array(
                MACHINE_INVENTORY . ' as mi' => 'cmi.sr_number_id = mi.inventory_id',
                CODELOOKUP . ' as cu' => 'cmi.serving_size = cu.code_id',
                CODELOOKUP . ' as pl' => 'cmi.pullout_location_id = pl.code_id',
                LOGIN . ' as l' => 'cmi.zone = l.login_id',
            );

            $whereMatch = array('cmi.sr_number_id' => $selInvnetoryId, 'cmi.version_id' => $selVersionId, 'cmi.is_delete' => '0');
            $machineInventoryData = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereMatch, '', '', '', '', '', '', '');

            if (!empty($machineInventoryData[0])) {

                $statusCode = 'success';
                $msg = 'success';
                $finalInventoryData = $machineInventoryData[0];
            }
        }
        $returnData = array(
            'statusCode' => $statusCode,
            'msg' => $msg,
            'inventoryData' => $finalInventoryData
        );

        echo json_encode($returnData);
    }

    /*
      @Author : Maitrak Modi
      @Desc   : Update Pull Out data
      @Input  :
      @Output :
      @Date   : 23nd May 2017
     */

    public function UpdatePullOutData() {

        $customer_id = $this->input->post('customer_id');
        $version = $this->input->post('version_pullout');
        $sr_number = $this->input->post('sr_number_pullout');

        $pullOutData = array(
            'customer_id' => $customer_id,
            'version_id' => $version,
            'sr_number_id' => $sr_number,
            'machine_assign_type' => 'Pullout',
            'pullout_location_id' => $this->input->post('pullout_location'),
            'updated_by' => $this->session->userdata['LOGGED_IN']['ID'],
            'updated_at' => date("Y-m-d H:i:s")
        );

        $whereCond = array('customer_id' => $customer_id, 'version_id' => $version, 'sr_number_id' => $sr_number);

        if ($this->common_model->update(CUSTOMER_MACHINE_INFORMATION, $pullOutData, $whereCond)) { //Update data

            /* Start - Update Machine Status */
            $inventoryStatus = $this->getInvetoryStatus('Under Repair');

            if ($inventoryStatus) {
                $updateInventoryData['machine_status_id'] = $inventoryStatus['code_id'];
            }

            $whereCondMachine = array('inventory_id' => $sr_number);

            if (!$this->common_model->update(MACHINE_INVENTORY, $updateInventoryData, $whereCondMachine)) { //Update data
                $msg = $this->lang->line('error_msg');
                $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");
            }
            /* End - Update Machine Status */

            //MAILING FUNCTION
            //$this->sendMailToZone($pullOutData, 'Pullout'); // Send Pull Out Data Mail

            $msg = 'Machine is assigned for Pullout.';
            $this->session->set_flashdata('msg', "<div class='alert alert-success text-center'>$msg</div>");
        } else {
            // error
            $msg = $this->lang->line('error_msg');
            $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");
        }

        redirect($this->viewname);
        exit;

        /* $tableName = CUSTOMER_MACHINE_INFORMATION . ' as cmi';
          $fields = array('cmi.*');
          $whereCond = array('customer_id' => $customer_id, 'version_id' => $version, 'sr_number_id' => $sr_number);
          $data['listRecords'] = $this->common_model->get_records($tableName, $fields, '', '', $whereCond, '', 1, 0, '', '', '', '');

          if (!empty($data['listRecords'][0])) {

          $pullOutData = array(
          'customer_id' => $data['listRecords'][0]['customer_id'],
          'version_id' => $data['listRecords'][0]['version_id'],
          'sr_number_id' => $data['listRecords'][0]['sr_number_id'],
          'installation_date' => $data['listRecords'][0]['installation_date'],
          'zone' => $data['listRecords'][0]['zone'],
          'machine_assign_type' => 'Pullout',
          'machine_installed_location' => $data['listRecords'][0]['machine_installed_location'],
          'machine_comment' => $data['listRecords'][0]['machine_comment'],
          'machine_picture' => $data['listRecords'][0]['machine_picture'],
          'machine_menu_file' => $data['listRecords'][0]['machine_menu_file'],
          'serving_size' => $data['listRecords'][0]['serving_size'],
          'pullout_location_id' => $this->input->post('pullout_location'),
          'created_by' => $this->session->userdata['LOGGED_IN']['ID'],
          'created_at' => date("Y-m-d H:i:s"),
          'updated_by' => $this->session->userdata['LOGGED_IN']['ID'],
          'updated_at' => date("Y-m-d H:i:s")
          );
          $lastMachineId = $this->common_model->insert(CUSTOMER_MACHINE_INFORMATION, $pullOutData);
          if ($lastMachineId) { //Insert data
          $src = $this->config->item('machine_assignment_attachment_url') . $data['listRecords'][0]['customer_machine_information_id'];  // source folder or file
          $dest = $this->config->item('machine_assignment_attachment_url') . $lastMachineId;   // destination folder or file
          copyr($src, $dest); // Copy folder
          //MAILING FUNCTION
          $this->sendMailToZone($pullOutData, 'Pullout'); // Send Pull Out Data Mail

          $msg = 'Machine is assigned for Pullout.';
          $this->session->set_flashdata('msg', "<div class='alert alert-success text-center'>$msg</div>");
          } else {
          // error
          $msg = $this->lang->line('error_msg');
          $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");
          }

          redirect($this->viewname);
          }
          exit; */
    }

    /*     * ****************************************** END - PULL OUT ******************************************************************* */

    /*     * ******************************************** START - REPLACEMENT ************************************************************ */

    /*
      @Author : Maitrak Modi
      @Desc   : Update Replacement Data
      @Input  :
      @Output :
      @Date   : 23nd May 2017
     */

    public function UpdateReplacementData() {


        /* Add New Assign Machine */
        $addMachineData = array(
            'customer_id' => $this->input->post('customer_id'),
            'version_id' => $this->input->post('version_assign'),
            'sr_number_id' => $this->input->post('sr_number_assign'),
            'installation_date' => date('Y-m-d', strtotime($this->input->post('installation_date_assign'))),
            'zone' => $this->input->post('zone_assign'),
            'machine_installed_location' => $this->input->post('machine_installed_location_assign'),
            'serving_size' => $this->input->post('serving_size_assign'),
            'machine_comment' => $this->input->post('machine_comment_assign'),
            'machine_assign_type' => 'Installation',
            'created_by' => $this->session->userdata['LOGGED_IN']['ID'],
            'created_at' => date("Y-m-d H:i:s"),
            'updated_by' => $this->session->userdata['LOGGED_IN']['ID'],
            'updated_at' => date("Y-m-d H:i:s")
        );

        // Insert query
        $machineAssignId = $this->common_model->insert(CUSTOMER_MACHINE_INFORMATION, $addMachineData);

        if ($machineAssignId) {

            /* Update Assign Data to Machine Inventory table */
            $updateInventoryData = array(
                //'is_assign' => 1,
                'updated_by' => $this->session->userdata['LOGGED_IN']['ID'],
                'updated_at' => date("Y-m-d H:i:s")
            );

            $inventoryStatus = $this->getInvetoryStatus('Active');
            if ($inventoryStatus) {
                $updateInventoryData['machine_status_id'] = $inventoryStatus['code_id'];
            }
            $whereCond = array('inventory_id' => $this->input->post('sr_number_assign'));

            if (!$this->common_model->update(MACHINE_INVENTORY, $updateInventoryData, $whereCond)) { //Update data
                $msg = $this->lang->line('error_msg');
                $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");
            }

// Upload images
            if (!$this->uploadAttachment($machineAssignId, 'machine_picture') || !$this->uploadAttachmentMenu($machineAssignId, 'machine_menu_file')) { // File upload function call
                $msg = $this->lang->line('error_msg');
                $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");
            }

            /* Update Installed Machine Status */
            $customer_id = $this->input->post('customer_id');
            $version_replacement = $this->input->post('version_replacement');
            $sr_number_replacement = $this->input->post('sr_number_replacement');

            $replaceMachineData = array(
                'customer_id' => $this->input->post('customer_id'),
                'version_id' => $this->input->post('version_replacement'),
                'sr_number_id' => $this->input->post('sr_number_replacement'),
                'machine_assign_type' => 'Pullout',
                'updated_by' => $this->session->userdata['LOGGED_IN']['ID'],
                'updated_at' => date("Y-m-d H:i:s")
            );

            $whereReplacementCond = array('customer_id' => $customer_id, 'version_id' => $version_replacement, 'sr_number_id' => $sr_number_replacement);

            if ($this->common_model->update(CUSTOMER_MACHINE_INFORMATION, $replaceMachineData, $whereReplacementCond)) { //Update data

                /* Start - Update Machine Status */
                $inventoryStatus = $this->getInvetoryStatus('Under Repair');

                if ($inventoryStatus) {
                    $updateInventoryData['machine_status_id'] = $inventoryStatus['code_id'];
                }

                $whereCondMachine = array('inventory_id' => $sr_number_replacement);

                if (!$this->common_model->update(MACHINE_INVENTORY, $updateInventoryData, $whereCondMachine)) { //Update data
                    $msg = $this->lang->line('error_msg');
                    $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");
                }
                /* End - Update Machine Status */

                /* Update Installed Machine Status */
                //$this->sendMailToZone($addMachineData, 'Replacement', $replaceMachineData);

                $msg = 'Machine has been replaced successfully.';
                $this->session->set_flashdata('msg', "<div class='alert alert-success text-center'>$msg</div>");
            } else {
                $msg = $this->lang->line('error_msg');
                $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");
            }
        } else {
// error
            $msg = $this->lang->line('error_msg');
            $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");
        }

        redirect($this->viewname);
    }

    /*     * ******************************************** END - REPLACEMENT ************************************************************ */

    /*
      @Author : Maitrak Modi
      @Desc   : Machine Assignment Form validation
      @Input  :
      @Output :
      @Date   : 22nd May 2017
     */

    public function formValidation($assignmentType) {

        $this->form_validation->set_rules('cust_code', 'Customer Code', 'trim|required|max_length[100]|xss_clean');
        $this->form_validation->set_rules('cust_name', 'Customer Name', 'trim|required|max_length[100]|xss_clean');
        $this->form_validation->set_rules('assignment_type', 'Assignment Type', 'trim|required|xss_clean');

        if ($assignmentType == 'pull_out') {
            $this->form_validation->set_rules('pullout_location', 'Pullout Location', 'trim|required|xss_clean');
            $this->form_validation->set_rules('version_pullout', 'Version', 'trim|required|xss_clean');
            $this->form_validation->set_rules('sr_number_pullout', 'Serial Number', 'trim|required|xss_clean');
        }

        if ($assignmentType == 'installation') {
            $this->form_validation->set_rules('version_installation', 'Version', 'trim|required|xss_clean');
            $this->form_validation->set_rules('sr_number_installation', 'Serial Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('installation_date', 'Installation Date', 'trim|required|xss_clean');
            $this->form_validation->set_rules('zone', 'Zone', 'trim|required|xss_clean');
            $this->form_validation->set_rules('serving_size', 'Serving Size', 'trim|required|xss_clean');
        }

        if ($assignmentType == 'replacement') {
            $this->form_validation->set_rules('version_replacement', 'Version', 'trim|required|xss_clean');
            $this->form_validation->set_rules('sr_number_replacement', 'Serial Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('sr_number_assign', 'Serial Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('sr_number_assign', 'Serial Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('installation_date_assign', 'Installation Date', 'trim|required|xss_clean');
            $this->form_validation->set_rules('zone_assign', 'Zone', 'trim|required|xss_clean');
            $this->form_validation->set_rules('serving_size_assign', 'Serving Size', 'trim|required|xss_clean');
        }
    }

    /*
      @Author : Maitrak Modi
      @Desc   : get Macthed Customer code
      @Input 	:
      @Output	:
      @Date   : 23rd May 2017
     */

    public function getCustomerCodeList() {

        $customerCode = html_entity_decode(trim(addslashes($this->input->post('selCustomerCode'))));

        $tableName = CUSTOMER_ENROLMENT . ' as ce';
        $fields = array('ce.customer_id, ce.customer_code,ce.customer_name');
        $where_search = '';
        if (!empty($customerCode)) {
            $where_search = '(ce.customer_code  LIKE "%' . $customerCode . '%" )';
        }
        $whereCond = array('ce.is_delete' => '0');
        $group_by = array('ce.customer_code');
        $data['customerCodeRecords'] = $this->common_model->get_records($tableName, $fields, '', '', $whereCond, '', '', '', '', '', $group_by, $where_search);

        return $data['customerCodeRecords'];
    }

    /*
      @Author : Maitrak Modi
      @Desc   : get Macthed Customer name
      @Input 	:
      @Output	:
      @Date   : 23rd May 2017
     */

    public function getCustomerNameList() {

        $customerCode = html_entity_decode(trim(addslashes($this->input->post('selCustomerCode'))));
        //echo $customerCode; exit;

        $tableName = CUSTOMER_ENROLMENT . ' as ce';
        $fields = array('ce.customer_id, ce.customer_code, ce.customer_name');
        $where_search = '';
        if (!empty($customerCode)) {
            //$where_search = '(ce.customer_code  LIKE "%' . $customerCode . '%" )';
            $where_search = '(ce.customer_code  LIKE "%' . $customerCode . '%" )';
        }
        $whereCond = array('ce.is_delete' => '0');
        $groupBy = array('ce.customer_name');
        $data['customerNameRecords'] = $this->common_model->get_records($tableName, $fields, '', '', $whereCond, '', '', '', '', '', $groupBy, $where_search);

        return $data['customerNameRecords'];
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
                        ce.mobile_number, ce.location, ce.email,
                        r.name as route_name
                    ');

        $join_tables = array(
            ROUTE . ' as r' => 'ce.route_id = r.route_id',
        );

        $whereCond = array('ce.customer_id' => $selCustomerCode, 'ce.is_delete' => '0');

        $data['customerDetails'] = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', '', '', '', '', '', '');

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

    /*
      @Author : Maitrak Modi
      @Desc   : CO upload attachment
      @Input 	:
      @Output	:
      @Date   : 23rd March 2017
     */

    public function uploadAttachment($machineAssignedId, $file_name) {

        /* Start - Upload Attachment File */
        $uploadCoDir = $this->config->item('machine_assignment_attachment_url');
        $uploadCoUploadDirPath = $uploadCoDir . $machineAssignedId;

        if (!is_dir($uploadCoDir)) {

            mkdir($uploadCoDir, 0777, TRUE); //create directory

            chmod($uploadCoDir, 0777);
        }

        if (!is_dir($uploadCoUploadDirPath)) {
            mkdir($uploadCoUploadDirPath, 0777, TRUE); //create directory

            chmod($uploadCoUploadDirPath, 0777);
        }

        if (is_dir($uploadCoDir) && is_dir($uploadCoUploadDirPath)) {

            if (!empty($_FILES[$file_name]['name'])) {

                //$no_of_files = 1;
                //$upload_size = '';
                //$upload_type = 'doc|docx|pdf|xls|xlsx'; // Allow file type
                $redirect = $this->viewname;

                //Upload Attchment
                $uploadedFileData = uploadImage($file_name, $uploadCoUploadDirPath, $redirect, '', '', '');

                if (!empty($uploadedFileData)) {
                    $updateData[$file_name] = $uploadedFileData[0]['file_name'];
                }

                $where = array('customer_machine_information_id' => $machineAssignedId);

                if (!$this->common_model->update(CUSTOMER_MACHINE_INFORMATION, $updateData, $where)) {
                    return false;
                }
            }
        }
        /* End - Upload Attachment File */
        return true;
    }

    /*
      @Author : Maitrak Modi
      @Desc   : CO upload attachment
      @Input 	:
      @Output	:
      @Date   : 23rd March 2017
     */

    public function uploadAttachmentMenu($machineAssignedId, $file_name) {

        /* Start - Upload Attachment File */
        $uploadCoDir = $this->config->item('machine_assignment_attachment_url');
        $uploadCoUploadDirPath = $uploadCoDir . $machineAssignedId . '/Menu';

        if (!is_dir($uploadCoDir)) {

            mkdir($uploadCoDir, 0777, TRUE); //create directory

            chmod($uploadCoDir, 0777);
        }

        if (!is_dir($uploadCoUploadDirPath)) {
            mkdir($uploadCoUploadDirPath, 0777, TRUE); //create directory

            chmod($uploadCoUploadDirPath, 0777);
        }

        if (is_dir($uploadCoDir) && is_dir($uploadCoUploadDirPath)) {

            if (!empty($_FILES[$file_name]['name'])) {

                //$no_of_files = 1;
                //$upload_size = '';
                //$upload_type = 'doc|docx|pdf|xls|xlsx'; // Allow file type
                $redirect = $this->viewname;

                //Upload Attchment
                $uploadedFileData = uploadImage($file_name, $uploadCoUploadDirPath, $redirect, '', '', '');

                if (!empty($uploadedFileData)) {
                    $updateData[$file_name] = $uploadedFileData[0]['file_name'];
                }

                $where = array('customer_machine_information_id' => $machineAssignedId);

                if (!$this->common_model->update(CUSTOMER_MACHINE_INFORMATION, $updateData, $where)) {
                    return false;
                }
            }
        }
        /* End - Upload Attachment File */
        return true;
    }

    /**
     * 
     * @param type $machineData
     * @param type $replacementMachineData
     */
    public function sendMailToZone($machineData, $assignType = '', $replacementMachineData = array()) {

        $replaceMachineData = '';

        $getMachineData = $this->getAllMachineDetails($machineData); // get details

        if ($getMachineData) {

            $find = array(
                '{ZONE_NAME}',
                '{VERSION_NAME}',
                '{SERIAL_NUMBER}',
                '{INSTALLED_DATE}',
                '{INSTALLATION_LOCATION}',
                '{SERVING_SIZE}',
                '{PULLOUT_LOCATION}'
            );

            $replace = array(
                'ZONE_NAME' => $getMachineData['zone_name'],
                'VERSION_NAME' => $getMachineData['version_name'],
                'SERIAL_NUMBER' => $getMachineData['machine_serial_number'],
                'INSTALLED_DATE' => $getMachineData['installation_date'],
                'INSTALLATION_LOCATION' => $getMachineData['machine_installed_location'],
                'SERVING_SIZE' => $getMachineData['serving_size_name'],
                'PULLOUT_LOCATION' => $getMachineData['pullout_location'],
            );

            $to = $getMachineData['zone_email'];

            $message = '<p> Hello {ZONE_NAME}.</p>';
            $message .= '<p><b>Machine Details are as below.</b></p>';
            $message .= '<p></p>';
            $message .= '<p><b>Version :</b> {VERSION_NAME}</p>';
            $message .= '<p><b>Serial Number :</b> {SERIAL_NUMBER}</p>';
            $message .= '<p><b>Installation Date:</b> {INSTALLED_DATE}</p>';
            $message .= '<p><b>Machine Installation Location:</b> {INSTALLATION_LOCATION}</p>';
            $message .= '<p><b>Serving Size:</b> {SERVING_SIZE}</p>';

            //INSTALLED
            if ($assignType == 'Installation') {
                $subject = 'New Machine Installation';
            }

            // PULL OUT
            if ($assignType == 'Pullout') {
                $subject = 'Machine Pullout';
                $message .= '<p><b>Pullout Location:</b> {PULLOUT_LOCATION}</p>';
            }

            // REPLACEMENT
            if ($assignType == 'Replacement') {

                $subject = 'Machine Replacement and Add New Machine';

                $getReplacedMachineData = $this->getAllMachineDetails($replacementMachineData); // get details

                $findReplaceMachine = array(
                    '{ZONE_NAME}',
                    '{VERSION_NAME}',
                    '{SERIAL_NUMBER}',
                    '{INSTALLED_DATE}',
                    '{INSTALLATION_LOCATION}',
                    '{SERVING_SIZE}',
                    '{PULLOUT_LOCATION}'
                );

                $replaceMachine = array(
                    'ZONE_NAME' => $getReplacedMachineData['zone_name'],
                    'VERSION_NAME' => $getReplacedMachineData['version_name'],
                    'SERIAL_NUMBER' => $getReplacedMachineData['machine_serial_number'],
                    'INSTALLED_DATE' => $getReplacedMachineData['installation_date'],
                    'INSTALLATION_LOCATION' => $getReplacedMachineData['machine_installed_location'],
                    'SERVING_SIZE' => $getReplacedMachineData['serving_size_name'],
                    'PULLOUT_LOCATION' => $getReplacedMachineData['pullout_location'],
                );

                $replaceMessage = '<p></p>';
                $replaceMessage .= '<p></p>';
                $replaceMessage .= '<p></p>';
                $replaceMessage .= '<p><b>Machined is assigned for pullout.</b></p>';
                $replaceMessage .= '<p></p>';
                $replaceMessage .= '<p><b>Version :</b> {VERSION_NAME}</p>';
                $replaceMessage .= '<p><b>Serial Number :</b> {SERIAL_NUMBER}</p>';
                $replaceMessage .= '<p><b>Installation Date:</b> {INSTALLED_DATE}</p>';
                $replaceMessage .= '<p><b>Machine Installation Location:</b> {INSTALLATION_LOCATION}</p>';
                $replaceMessage .= '<p><b>Serving Size:</b> {SERVING_SIZE}</p>';

                $replaceMachineData = str_replace($findReplaceMachine, $replaceMachine, $replaceMessage);
            }

//echo $replaceMachineData;
//exit;
            $message .= $replaceMachineData;
            $message .= '<p> </p>';
            $message .= '<p>Thank You,</p>';
            $message .= '<p><b><i>Nestle Team<i><b></p>';

            $finalEmailBody = str_replace($find, $replace, $message);

            return send_mail($to, $subject, $finalEmailBody, $attach = NULL);
        }
    }

    /**
     * 
     * @param type $machineData
     * @return boolean
     */
    public function getAllMachineDetails($machineData) {

        $tableName = CUSTOMER_MACHINE_INFORMATION . ' as cmi';

        $fields = array('cmi.machine_assign_type, cmi.installation_date, cmi.machine_installed_location,
            ce.customer_code, ce.customer_name,
            mi.machine_serial_number,
            v.version_name,
            cu.code_name as serving_size_name,
            pl.code_name as pullout_location,
            l.firstname as zone_name, l.email as zone_email');

        $join_tables = array(
            CUSTOMER_ENROLMENT . ' as ce' => 'cmi.customer_id = ce.customer_id',
            MACHINE_INVENTORY . ' as mi' => 'cmi.sr_number_id = mi.inventory_id',
            VERSION_MASTER . ' as v' => 'cmi.version_id = v.version_id',
            CODELOOKUP . ' as cu' => 'cmi.serving_size = cu.code_id',
            CODELOOKUP . ' as pl' => 'cmi.pullout_location_id = pl.code_id',
            LOGIN . ' as l' => 'cmi.zone = l.login_id'
        );

        $whereCond = array('cmi.customer_id' => $machineData['customer_id'], 'cmi.version_id' => $machineData['version_id'], 'cmi.sr_number_id' => $machineData['sr_number_id'],
            'cmi.is_delete' => '0',
            'ce.is_delete' => '0',
            'l.status' => 'active',
            'l.is_delete' => 0);

        $data['listRecords'] = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', 1, 0, '', '', '', '');

        if (!empty($data['listRecords'][0])) {
            return $data['listRecords'][0];
        }

        return false;
    }

    /**
     * 
     * @param type $assignId
     */
    public function edit($assignId) {

        if (!empty($assignId)) {

            $tableName = CUSTOMER_MACHINE_INFORMATION . ' as cmi';
            $fields = array('cmi.*,
                ce.customer_name, ce.customer_code, ce.mobile_number, ce.email, ce.location,
                mi.machine_serial_number, mi.bmb, mi.sap_purchase_date, mi.ta_depc_date, mi.asset, 
                r.name as route_name,
                vm.version_name,
                ch.code_name as hot_cold_name,
                cg.code_name as gen_name,
                cma.code_name as machine_abb_name,
                cmm.code_name as machine_mpr_name,
                cbv.code_name as bev_type_name,
                ts.code_name as machine_tech_status,
                l.firstname as zone_name,
                ss.code_name as serving_size_val');


            $join_tables = array(
                CUSTOMER_ENROLMENT . ' as ce' => 'ce.customer_id = cmi.customer_id',
                MACHINE_INVENTORY . ' as mi' => 'cmi.sr_number_id = mi.inventory_id',
                ROUTE . ' as r' => 'ce.route_id = r.route_id',
                VERSION_MASTER . ' as vm' => 'vm.version_id = cmi.version_id',
                CODELOOKUP . ' as ch' => 'vm.hot_cold_type = ch.code_id',
                CODELOOKUP . ' as cg' => 'vm.gen = cg.code_id',
                CODELOOKUP . ' as cma' => 'vm.machine_abb = cma.code_id',
                CODELOOKUP . ' as cmm' => 'vm.machine_mpr = cmm.code_id',
                CODELOOKUP . ' as cbv' => 'vm.bev_type = cbv.code_id',
                CODELOOKUP . ' as ts' => 'mi.technial_status = ts.code_id',
                CODELOOKUP . ' as pl' => 'cmi.pullout_location_id = pl.code_id',
                CODELOOKUP . ' as ss' => 'cmi.serving_size = ss.code_id',
                LOGIN . ' as l' => 'cmi.zone = l.login_id'
            );

            $whereCond = array('cmi.customer_machine_information_id' => $assignId, 'cmi.is_delete' => '0');

            $dataRecord['editAssignData'] = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', '', '', '', '', '', '');

            //pr($data['editAssignData']);
            //exit;

            if (!empty($dataRecord['editAssignData'][0])) {

                $machineAssignType = $dataRecord['editAssignData'][0]['machine_assign_type'];
                $customerMachineInfoId = $dataRecord['editAssignData'][0]['customer_machine_information_id'];

                // data assign will come here
                $data = array(
                    'customer_machine_information_id' => $customerMachineInfoId,
                    'customer_id' => $dataRecord['editAssignData'][0]['customer_id'],
                    'customer_name' => $dataRecord['editAssignData'][0]['customer_name'],
                    'customer_code' => $dataRecord['editAssignData'][0]['customer_code'],
                    'customer_mobile_number' => $dataRecord['editAssignData'][0]['mobile_number'],
                    'customer_email' => $dataRecord['editAssignData'][0]['email'],
                    'customer_location' => $dataRecord['editAssignData'][0]['location'],
                    'customer_route_name' => $dataRecord['editAssignData'][0]['route_name'],
                    'machine_assign_type' => $machineAssignType,
                    'editVersionId' => $dataRecord['editAssignData'][0]['version_id'],
                    'editVersion' => $dataRecord['editAssignData'][0]['version_name'],
                    'sr_number_id' => $dataRecord['editAssignData'][0]['sr_number_id'],
                    'editInstallationDate' => (!empty($dataRecord['editAssignData'][0]['installation_date'])) ? date('m/d/Y', strtotime($dataRecord['editAssignData'][0]['installation_date'])) : '',
                    'editZone' => $dataRecord['editAssignData'][0]['zone'],
                    'editMachineInstalledLocation' => $dataRecord['editAssignData'][0]['machine_installed_location'],
                    'editMachineComment' => $dataRecord['editAssignData'][0]['machine_comment'],
                    'attachment' => $dataRecord['editAssignData'][0]['machine_picture'],
                    'attachment_menu' => $dataRecord['editAssignData'][0]['machine_menu_file'],
                    'editServingSize' => $dataRecord['editAssignData'][0]['serving_size_val'],
                    'editMachineSerialNumber' => $dataRecord['editAssignData'][0]['machine_serial_number'],
                    'editHotColdName' => $dataRecord['editAssignData'][0]['hot_cold_name'],
                    'editGenName' => $dataRecord['editAssignData'][0]['gen_name'],
                    'editMachineAbbName' => $dataRecord['editAssignData'][0]['machine_abb_name'],
                    'editMachineMprName' => $dataRecord['editAssignData'][0]['machine_mpr_name'],
                    'editBevTypeName' => $dataRecord['editAssignData'][0]['bev_type_name'],
                    'editBmb' => $dataRecord['editAssignData'][0]['bmb'],
                    'editAsset' => $dataRecord['editAssignData'][0]['asset'],
                    'editSapPurchaseDate' => $dataRecord['editAssignData'][0]['sap_purchase_date'],
                    'editTaDepcDate' => $dataRecord['editAssignData'][0]['ta_depc_date'],
                    'editMachineTechStatus' => $dataRecord['editAssignData'][0]['machine_tech_status'],
                    'editPulloutLocation' => $dataRecord['editAssignData'][0]['pullout_location_id'],
                    'editZoneName' => $dataRecord['editAssignData'][0]['zone_name'],
                    'editMachinePicture' => $dataRecord['editAssignData'][0]['machine_picture'],
                    'editMachineFileMenu' => $dataRecord['editAssignData'][0]['machine_menu_file'],
                );

                //pr($data);
                //exit;
                $this->editFormValidation($machineAssignType); // form Validation fields

                if ($this->form_validation->run() == FALSE) {

                    $data['crnt_view'] = $this->viewname;
                    $data['form_action_path'] = $this->viewname . '/edit/' . $assignId;
                    $data['header'] = array('menu_module' => 'Assign Machine', 'menu_child' => 'Assign Machine');

                    $data['screenType'] = 'edit';

                    $data['validation'] = validation_errors();

                    /* Start - codelook up table data */
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
                    $data['pulloutLocationList'] = $nested['pullout_location']['children']; // get pull out listing
                    /* End - codelook up table data */

                    //INSTALLATION
                    if ($machineAssignType == 'Installation') {

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


                        $data['footerJs'] = array(
                            '0' => base_url() . 'uploads/assets/js/bootstrap-datetimepicker.min.js',
                            '1' => base_url() . 'uploads/custom/js/MachineAssignment/EditInstallation.js',
                        );

                        $data['main_content'] = '/EditInstallation';
                        $this->parser->parse('layouts/DefaultTemplate', $data);
                    }

                    //PULLOUT
                    if ($machineAssignType == 'Pullout') {
                        $data['footerJs'] = array(
                            '0' => base_url() . 'uploads/custom/js/MachineAssignment/EditPullout.js',
                        );

                        $data['main_content'] = '/EditPullout';
                        $this->parser->parse('layouts/DefaultTemplate', $data);
                    }

                    //REPLACEMENT
                    if ($machineAssignType == 'Replacement') {
                        //Replacement Page
                    }
                } else {

                    //On Success
                    $this->updateEditData($customerMachineInfoId, $machineAssignType, $data['editMachinePicture'], $data['editMachineFileMenu']); // Call update data function
                }
            } else {
                $msg = $this->lang->line('error_msg');
                $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");
            }
        } else {
            $msg = $this->lang->line('error_msg');
            $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");
        }
    }

    /*
      @Author : Maitrak Modi
      @Desc   : Machine Assignment Edit Form validation
      @Input  :
      @Output :
      @Date   : 2nd June 2017
     */

    public function editFormValidation($assignmentType) {

        if ($assignmentType == 'Installation') {

            $this->form_validation->set_rules('installation_date', 'Installation Date', 'trim|required|xss_clean');
            $this->form_validation->set_rules('zone', 'Zone', 'trim|required|xss_clean');
            $this->form_validation->set_rules('serving_size', 'Serving Size', 'trim|required|xss_clean');
        }

        if ($assignmentType == 'Pullout') {
            $this->form_validation->set_rules('pullout_location', 'Pullout Location', 'trim|required|xss_clean');
        }
    }

    /**
     * @Author : Maitrak Modi
     * @Desc   : Machine Assignment Edit Form
     * @param type $customerMachineInfoId
     * @param type $assignmentType
     * @Date   : 2nd June 2017
     */
    protected function updateEditData($customerMachineInfoId, $assignmentType, $machinePicture = '', $machineFileMenu = '') {

        if ($assignmentType == 'Installation') {

            $updatedData = array(
                'installation_date' => date('Y-m-d', strtotime($this->input->post('installation_date'))),
                'sr_number_id' => $this->input->post('sr_number_installation'),
                'zone' => $this->input->post('zone'),
                'machine_installed_location' => $this->input->post('machine_installed_location'),
                'serving_size' => $this->input->post('serving_size'),
                'machine_comment' => $this->input->post('machine_comment'),
                'updated_by' => $this->session->userdata['LOGGED_IN']['ID'],
                'updated_at' => date("Y-m-d H:i:s")
            );

            // Remove machine picture
            if ($this->input->post('removeFilePicture')) {

                if (!empty($machinePicture)) {

                    unlink($this->config->item('machine_assignment_attachment_url') . $customerMachineInfoId . '/' . $machinePicture);
                    $updatedData['machine_picture'] = '';
                }
            }

            // Remove machine file menu
            if ($this->input->post('removeFileMenu')) {

                if (!empty($machineFileMenu)) {
                    unlink($this->config->item('machine_assignment_attachment_url') . $customerMachineInfoId . '/Menu/' . $machineFileMenu);
                    $updatedData['machine_menu_file'] = '';
                }
            }
        }


        if ($assignmentType == 'Pullout') {

            $updatedData = array(
                'pullout_location_id' => $this->input->post('pullout_location'),
                'updated_by' => $this->session->userdata['LOGGED_IN']['ID'],
                'updated_at' => date("Y-m-d H:i:s")
            );
        }


        $whereCond = array('customer_machine_information_id' => $customerMachineInfoId, 'is_delete' => '0');

        if ($this->common_model->update(CUSTOMER_MACHINE_INFORMATION, $updatedData, $whereCond)) { //Update data
            
            if ($assignmentType == 'Installation') {
                
                $updateInventoryData = array(
                    //'is_assign' => 1,
                    'updated_by' => $this->session->userdata['LOGGED_IN']['ID'],
                    'updated_at' => date("Y-m-d H:i:s")
                );

                $inventoryStatus = $this->getInvetoryStatus('Active');

                if (!empty($inventoryStatus)) {
                    $updateInventoryData['machine_status_id'] = $inventoryStatus['code_id'];
                }

                $whereCond = array('inventory_id' => $this->input->post('sr_number_installation'));

                if (!$this->common_model->update(MACHINE_INVENTORY, $updateInventoryData, $whereCond)) { //Update data
                    $msg = $this->lang->line('error_msg');
                    $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");
                }
            }

            if (!empty($_FILES)) {

                if (!empty($_FILES['machine_picture']['name'])) {
                    $this->uploadAttachment($customerMachineInfoId, 'machine_picture');
                }

                if (!empty($_FILES['machine_menu_file']['name'])) {
                    $this->uploadAttachmentMenu($customerMachineInfoId, 'machine_menu_file');
                }
            }

            $msg = 'Machine data has been updated successfully.';
            $this->session->set_flashdata('msg', "<div class='alert alert-success text-center'>$msg</div>");
        } else {
            $msg = $this->lang->line('error_msg');
            $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");
        }

        redirect($this->viewname);
    }

    /*
      @Author : Maitrak Modi
      @Desc   : soft delete Assign Machine
      @Input 	:
      @Output	:
      @Date   : 2nd June 2017
     */

    public function deleteAssignedMachine() {

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

            echo base_url($this->viewname);

            /* $assignedMachineId = $this->input->post('assignedMachineId');

              if (!empty($assignedMachineId)) {

              $tableName = CUSTOMER_MACHINE_INFORMATION;
              $data = array('is_delete' => '1');
              $where = array('customer_machine_information_id' => $assignedMachineId);

              if ($this->common_model->update($tableName, $data, $where)) {
              $msg = 'Assign Machine has been deleted successfully.';
              $this->session->set_flashdata('msg', "<div class='alert alert-success text-center'>$msg</div>");
              } else {
              // error
              $msg = $this->lang->line('error_msg');
              }

              echo base_url($this->viewname);
              } */
        }
    }

    /*
      @Author : Maitrak Modi
      @Desc   : Get Inventory Status
      @Input 	:$passStatus
      @Output	: type
      @Date   : 2nd June 2017
     */

    Protected function getInvetoryStatus($passStatus = '') {
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
