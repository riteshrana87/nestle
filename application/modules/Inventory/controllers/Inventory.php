<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends CI_Controller {

    function __construct() {

        parent::__construct();
        if (checkPermission('User', 'view') == false) {
            redirect('/Dashboard');
        }
        $this->viewname = $this->uri->segment(1);
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('form_validation', 'Session'));
    }

    /*
      @Author : Maitrak Modi
      @Desc   : Version Master Listing
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
            $this->session->unset_userdata('inventory_data');
        }
        /* End - Reset All Fields */

        $searchsort_session = $this->session->userdata('inventory_data'); // store data in session

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
                $sortfield = 'inventory_id';
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
        $tableName = MACHINE_INVENTORY . ' as mi';
        $fields = array('mi.inventory_id, mi.machine_serial_number, mi.asset, mi.bmb,
            mi.machine_name, mi.machine_model_number, mi.machine_preaparation_date, mi.machine_status_id,
            v.version_name,
            c.code_name');

        $join_tables = array(
            VERSION_MASTER . ' as v' => 'mi.version_id = v.version_id',
            CODELOOKUP . ' as c' => 'mi.machine_status_id = c.code_id',
        );
        $whereCond = array('is_delete' => '0');

        if (!empty($searchtext)) {
            $searchtext = html_entity_decode(trim(addslashes($searchtext)));
            $where_search = '(mi.machine_serial_number LIKE "%' . $searchtext . '%" '
                    . 'OR mi.asset LIKE "%' . $searchtext . '%" '
                    . 'OR mi.bmb LIKE "%' . $searchtext . '%" '
                    . 'OR mi.machine_name LIKE "%' . $searchtext . '%" '
                    . 'OR mi.machine_model_number LIKE "%' . $searchtext . '%" '
                    . 'OR mi.machine_preaparation_date LIKE "%' . $searchtext . '%" '
                    . 'OR v.version_name LIKE "%' . $searchtext . '%" '
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

        $this->session->set_userdata('inventory_data', $sortsearchpage_data);
        setActiveSession('inventory_data'); // set current Session active

        $data['crnt_view'] = $this->viewname;
        /* End Pagination */

        $data['crnt_view'] = $this->viewname;
        $data['form_action_path'] = $this->viewname . '/index';

        $data['main_content'] = '/inventorylist';
        $data['header'] = array('menu_module' => 'masters', 'menu_child' => 'inventory');
        $data['footerJs'] = array(
            '0' => base_url() . 'uploads/custom/js/Inventory/InventoryList.js',
        );

        $data['meta_title'] = 'Machine Inventory Listing';

        if ($this->input->post('result_type') == 'ajax') {
            $this->load->view($this->viewname . '/ajaxList', $data);
        } else {
            $data['main_content'] = '/invnetorylist';
            $this->parser->parse('layouts/DefaultTemplate', $data);
        }
    }

    /*
      @Author : Maitrak Modi
      @Desc   : Machine Inventory Add function
      @Input 	:
      @Output	:
      @Date   : 10th March 2017
     */

    public function add() {

        $this->formValidation(); // form Validation fields

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

            $data['statusDrpdown'] = $nested['machine_status_id']['children'];
            $data['technicalStatusDrpdown'] = $nested['inventory_technical_status']['children'];
            $data['wareHouserLocationDrpdown'] = $nested['warehouse_location']['children'];

            /* Start - Version List */
            $data['versionList'] = getVersionList(); // get version list
            /* End - Version List */

            $data['manufacturing_year'] = range(date('Y') - 2, date('Y'));
            $data['end_of_life'] = range(date('Y'), date('Y') + 5);
            $data['editVersionId'] = '';

            $data['crnt_view'] = $this->viewname;
            $data['form_action_path'] = $this->viewname . '/add';
            $data['main_content'] = '/addEdit';

            $data['validation'] = validation_errors();
            $data['header'] = array('menu_module' => 'masters', 'menu_child' => 'inventory');
            $data['footerJs'] = array(
                '0' => base_url() . 'uploads/assets/js/bootstrap-datetimepicker.min.js',
                '1' => base_url() . 'uploads/custom/js/Inventory/Inventory.js',
            );
            $data['screenType'] = 'add';
            $data['meta_title'] = 'Add Machine Inventory';
            $this->parser->parse('layouts/DefaultTemplate', $data);
        } else {
            //success form
            $this->insertData();
        }
    }

    /*
      @Author : Maitrak Modi
      @Desc   : Machine Inventory Insert Data
      @Input 	:
      @Output	:
      @Date   : 10th March 2017
     */

    public function insertData() {

        // Inserted Array Data
        $data = array(
            'machine_id' => $this->input->post('machine_id'),
            'machine_tag_number' => $this->input->post('machine_tag_number'),
            'machine_serial_number' => $this->input->post('machine_sr_number'),
            'machine_model_number' => $this->input->post('machine_model_number'),
            'machine_name' => $this->input->post('machine_name'),
            'machine_manufacturing_year' => $this->input->post('machine_manufacturing_year'),
            'machine_end_of_life' => $this->input->post('machine_end_of_life'),
            'machine_location' => $this->input->post('machine_location'),
            'bmb' => $this->input->post('bmb'),
            'asset' => $this->input->post('assets'),
            'technial_status' => $this->input->post('tech_status'),
            'sap_purchase_date' => date('Y-m-d', strtotime($this->input->post('sap_purchase_date'))),
            'ta_depc_date' => date('Y-m-d', strtotime($this->input->post('ta_depc_date'))),
            'installation_date' => date('Y-m-d', strtotime($this->input->post('inst_date'))),
            'machine_preaparation_date' => date('Y-m-d', strtotime($this->input->post('machine_preparation_date'))),
            'version_id' => $this->input->post('version'),
            'machine_status_id' => $this->input->post('status'),
            'machine_warehouse_location' => $this->input->post('warehouse_location'),
            'created_by' => $this->session->userdata['LOGGED_IN']['ID'],
            'created_at' => date("Y-m-d H:i:s"),
            'updated_by' => $this->session->userdata['LOGGED_IN']['ID'],
            'updated_at' => date("Y-m-d H:i:s")
        );

        // Insert query
        if ($this->common_model->insert(MACHINE_INVENTORY, $data)) {
            $msg = $this->lang->line('INVENTORY_INSERT_MSG');
            $this->session->set_flashdata('msg', "<div class='alert alert-success text-center'>$msg</div>");
        } else {
            // error
            $msg = $this->lang->line('error_msg');
            $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");
        }

        redirect('Inventory');
    }

    /*
      @Author : Maitrak Modi
      @Desc   : Version Master Edit Function
      @Input 	: Version Id
      @Output	:
      @Date   : 10th March 2017
     */

    public function edit($inventoryId) {

        $tableName = MACHINE_INVENTORY;
        $fields = array('*');
        $match = array('inventory_id' => $inventoryId);

        $data['editInventoryRecord'] = $this->common_model->get_records($tableName, $fields, '', '', $match, '', '', '', '', '', '', '');

        if (!empty($data['editInventoryRecord'][0])) {

            $this->formValidation(); // Form fields validation
            if ($this->form_validation->run() == FALSE) {

                $table = CODELOOKUP;
                $fields = array('parent_code_id, code_id, code_name');
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

                $data['statusDrpdown'] = $nested['machine_status_id']['children'];
                $data['technicalStatusDrpdown'] = $nested['inventory_technical_status']['children'];
                $data['wareHouserLocationDrpdown'] = $nested['warehouse_location']['children'];

                /* Start - Version Master for Dropdown data */
                $data['versionList'] = getVersionList(); // get version list
                /* End - Version Master for Dropdown data */

                /* Start - Edit data in form */
                $data['editInventoryId'] = $inventoryId;
                $data['editVersionId'] = $data['editInventoryRecord'][0]['version_id'];
                $data['editMachineId'] = $data['editInventoryRecord'][0]['machine_id'];
                $data['editMachineTagNumber'] = $data['editInventoryRecord'][0]['machine_tag_number'];
                $data['editMachineSrNumber'] = $data['editInventoryRecord'][0]['machine_serial_number'];
                $data['editMachineModelNumber'] = $data['editInventoryRecord'][0]['machine_model_number'];
                $data['editMachineName'] = $data['editInventoryRecord'][0]['machine_name'];
                $data['editMachineManufacturingYear'] = $data['editInventoryRecord'][0]['machine_manufacturing_year'];
                $data['editMachineEndOfLife'] = $data['editInventoryRecord'][0]['machine_end_of_life'];
                $data['editMachineLocation'] = $data['editInventoryRecord'][0]['machine_location'];
                $data['editMachinebmb'] = $data['editInventoryRecord'][0]['bmb'];
                $data['editMachineAsset'] = $data['editInventoryRecord'][0]['asset'];
                $data['editMachineTechnicalStatus'] = $data['editInventoryRecord'][0]['technial_status'];
                $data['editMachineSapPurchaseDate'] = date('m/d/Y', strtotime($data['editInventoryRecord'][0]['sap_purchase_date']));
                $data['editMachineTaDepcDate'] = date('m/d/Y', strtotime($data['editInventoryRecord'][0]['ta_depc_date']));
                $data['editMachineInstallationDate'] = date('m/d/Y', strtotime($data['editInventoryRecord'][0]['installation_date']));
                $data['editMachineStatusId'] = $data['editInventoryRecord'][0]['machine_status_id'];
                $data['editMachinePreparationDate'] = date('m/d/Y', strtotime($data['editInventoryRecord'][0]['machine_preaparation_date']));
                $data['editMachineWarehouseLocationId'] = $data['editInventoryRecord'][0]['machine_warehouse_location'];

                //pr($data); exit;
                $data['manufacturing_year'] = range(date('Y') - 2, date('Y'));
                $data['end_of_life'] = range(date('Y'), date('Y') + 5);


                $data['crnt_view'] = $this->viewname;
                $data['form_action_path'] = $this->viewname . '/edit/' . $inventoryId;
                $data['main_content'] = '/addEdit';

                $data['validation'] = validation_errors();

                $data['footerJs'] = array(
                    '0' => base_url() . 'uploads/assets/js/bootstrap-datetimepicker.min.js',
                    '1' => base_url() . 'uploads/custom/js/Inventory/Inventory.js',
                );

                $data['screenType'] = 'edit';
                $data['meta_title'] = 'Edit Machine Inventory';
                $this->parser->parse('layouts/DefaultTemplate', $data);
            } else {
                // success form
                $this->updateData($inventoryId);
            }
        } else {
            // error
            $data['header'] = array('menu_module' => 'masters', 'menu_child' => 'inventory');
            $msg = $this->lang->line('error_msg');
            $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");

            redirect('Inventory');
        }
    }

    /*
      @Author : Maitrak Modi
      @Desc   : Machine Inventory Update data
      @Input 	: Version Id
      @Output	:
      @Date   : 10th March 2017
     */

    public function updateData($inventoryId) {

        //pr($_POST); exit;
        $data = array(
            'machine_id' => $this->input->post('machine_id'),
            'machine_tag_number' => $this->input->post('machine_tag_number'),
            'machine_serial_number' => $this->input->post('machine_sr_number'),
            'machine_model_number' => $this->input->post('machine_model_number'),
            'machine_name' => $this->input->post('machine_name'),
            'machine_manufacturing_year' => $this->input->post('machine_manufacturing_year'),
            'machine_end_of_life' => $this->input->post('machine_end_of_life'),
            'machine_location' => $this->input->post('machine_location'),
            'bmb' => $this->input->post('bmb'),
            'asset' => $this->input->post('assets'),
            'technial_status' => $this->input->post('tech_status'),
            'sap_purchase_date' => date('Y-m-d', strtotime($this->input->post('sap_purchase_date'))),
            'ta_depc_date' => date('Y-m-d', strtotime($this->input->post('ta_depc_date'))),
            'version_id' => $this->input->post('version'),
            'installation_date' => date('Y-m-d', strtotime($this->input->post('inst_date'))),
            'machine_status_id' => $this->input->post('status'),
            'machine_warehouse_location' => $this->input->post('warehouse_location'),
            'machine_preaparation_date' => date('Y-m-d', strtotime($this->input->post('machine_preparation_date'))),
            //'created_by' => $this->session->userdata['LOGGED_IN']['ID'],
            //'created_at' => date("Y-m-d H:i:s"),
            'updated_by' => $this->session->userdata['LOGGED_IN']['ID'],
            'updated_at' => date("Y-m-d H:i:s")
        );
        //pr($data); exit;

        /* Update Data */
        $where = array('inventory_id' => $inventoryId);

        if ($this->common_model->update(MACHINE_INVENTORY, $data, $where)) { //Update data
            $msg = $this->lang->line('INVENTORY_UPDATE_MSG');
            $this->session->set_flashdata('msg', "<div class='alert alert-success text-center'>$msg</div>");
        } else {
            // error
            $msg = $this->lang->line('error_msg');
            $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");
        }

        redirect('Inventory');
    }

    /*
      @Author : Maitrak Modi
      @Desc   : Machine Inventory form fields validation
      @Input 	:
      @Output	:
      @Date   : 15th March 2017
     */

    function formValidation() {

        $this->form_validation->set_rules('machine_id', $this->lang->line('label_machine_id'), 'trim|required|max_length[12]|xss_clean');
        $this->form_validation->set_rules('machine_tag_number', $this->lang->line('label_machine_tag_number'), 'trim|required|max_length[15]|xss_clean');
        $this->form_validation->set_rules('machine_sr_number', $this->lang->line('label_machine_sr_number'), 'trim|required|max_length[11]|xss_clean');
        $this->form_validation->set_rules('machine_model_number', $this->lang->line('label_machine_model_number'), 'trim|required|max_length[11]|xss_clean');
        $this->form_validation->set_rules('machine_name', $this->lang->line('label_machine_name'), 'trim|required|max_length[100]|xss_clean');
        $this->form_validation->set_rules('machine_manufacturing_year', $this->lang->line('label_machine_manufacturing_year'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('machine_end_of_life', $this->lang->line('label_machine_end_of_life'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('machine_location', $this->lang->line('label_machine_location'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('bmb', $this->lang->line('label_machine_bmb'), 'trim|required|numeric|xss_clean');
        $this->form_validation->set_rules('assets', $this->lang->line('label_machine_assets'), 'trim|required|numeric|max_length[11]|xss_clean');
        $this->form_validation->set_rules('tech_status', $this->lang->line('label_machine_tech_status'), 'trim|required|max_length[50]|xss_clean');
        $this->form_validation->set_rules('sap_purchase_date', $this->lang->line('label_machine_tech_sap_purchase_date'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('ta_depc_date', $this->lang->line('label_machine_ta_depc_date'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('version', $this->lang->line('label_machine_version'), 'trim|required|xss_clean');
        //  $this->form_validation->set_rules('hot_cold', 'Hot/Cold', 'trim|required|xss_clean');
        // $this->form_validation->set_rules('gen', 'Gen', 'trim|required|xss_clean');
        // $this->form_validation->set_rules('machine_abb', 'Machine Abb', 'trim|required|xss_clean');
        //$this->form_validation->set_rules('mpr', 'MPR', 'trim|required|xss_clean');
        // $this->form_validation->set_rules('bev_type', 'bevType', 'trim|required|xss_clean');
        //$this->form_validation->set_rules('quantity', 'Quantity', 'trim|required|xss_clean');
        $this->form_validation->set_rules('inst_date', $this->lang->line('label_machine_inst_date'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('status', $this->lang->line('label_machine_status'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('machine_preparation_date', $this->lang->line('label_machine_machine_preparation_date'), 'trim|required|xss_clean');
    }

    /*
      @Author : Maitrak Modi
      @Desc   : Machine Inventory get Selected Version data
      @Input 	:
      @Output	:
      @Date   : 15th March 2017
     */

    public function getSelectedVersionData() {

        $selversionId = trim($this->input->post('selVersionId'));
        $returnData = array();
        if (!empty($selversionId)) {

            // fetch Version Data
            $tableName = VERSION_MASTER . ' as v';
            $fields = array('v.version_id, v.version_name,
                        ch.code_name as hot_cold_name,
                        cg.code_name as gen_name,
                        cma.code_name as machine_abb_name,
                        cmm.code_name as machine_mpr_name,
                        cbv.code_name as bev_type_name');

            $join_tables = array(
                CODELOOKUP . ' as ch' => 'v.hot_cold_type = ch.code_id',
                CODELOOKUP . ' as cg' => 'v.gen = cg.code_id',
                CODELOOKUP . ' as cma' => 'v.machine_abb = cma.code_id',
                CODELOOKUP . ' as cmm' => 'v.machine_mpr  = cmm.code_id',
                CODELOOKUP . ' as cbv' => 'v.bev_type = cbv.code_id',
            );

            $whereMatch = array('version_id' => $selversionId, 'version_isactive' => 'active');
            $versionData = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereMatch, '', '', '', '', '', '', '');

            if (!empty($versionData[0])) {
                $statusCode = 'success';
                $msg = 'success';
                $finalVersionData = $versionData[0];
            } else {
                $statusCode = 'error';
                $errormsg = $this->lang->line('error_msg');
                $msg = "<div class='alert alert-danger text-center'>$errormsg</div>";
                $finalVersionData = array();
            }

            $returnData = array(
                'statusCode' => $statusCode,
                'msg' => $msg,
                'versionData' => $finalVersionData
            );
            //pr($returnData);
        }
        echo json_encode($returnData);
    }

    /*
      @Author : Maitrak Modi
      @Desc   : Machine Inventory soft delete inventory
      @Input 	:
      @Output	:
      @Date   : 15th March 2017
     */

    public function deleteInventory() {

        $inventoryId = $this->input->post('inventoryId');
        //echo $inventoryId;
        //exit;
        if (!empty($inventoryId)) {

            $tableName = MACHINE_INVENTORY;
            $data = array('is_delete' => '1');
            $where = array('inventory_id' => $inventoryId);

            if ($this->common_model->update($tableName, $data, $where)) {
                $msg = $this->lang->line('INVENTORY_DELETE_MSG');
                //$customMsg = "<div class='alert alert-success text-center'>$msg</div>";
                //$statusCode = 'success';
                $this->session->set_flashdata('msg', "<div class='alert alert-success text-center'>$msg</div>");
            } else {
                // error
                $msg = $this->lang->line('error_msg');
                // $customMsg = "<div class='alert alert-danger text-center'>$msg</div>";
                //$statusCode = 'error';
                $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");
            }

            echo base_url($this->viewname);
            /*
              $returnData = array(
              'msg' => $customMsg,
              //'statusCode' => $statusCode,
              );

              echo json_encode($returnData);
             */
        }
    }
    
    /*
      @Author : Maitrak Modi
      @Desc   : Inventory Master Check Duplicate serial number
      @Input 	: 
      @Output	:
      @Date   : 7th July 2017
     */

    public function isDuplicateSerialNumber() {

        $isduplicate = 0;
        $serialNumber = trim($this->input->post('currentSerialNumber'));
        $inventory_id = trim($this->input->post('inventory_id'));

        if (!empty($serialNumber)) {

            $tableName = MACHINE_INVENTORY;
            $fields = array('COUNT(inventory_id) AS cntData');

            if (!empty($inventory_id)) { // edit 
                $match = array('machine_serial_number' => $serialNumber, 'inventory_id <>' => $inventory_id);
            } else {
                $match = array('machine_serial_number' => $serialNumber);
            }

            $duplicateVersionName = $this->common_model->get_records($tableName, $fields, '', '', $match);
            //echo $this->db->last_query();
            //pr($duplicateVersionName);

            if ($duplicateVersionName[0]['cntData'] > 0) {
                $isduplicate = 1;
            } else {
                $isduplicate = 0;
            }
        }

        echo $isduplicate;
    }

}
