<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Version extends CI_Controller {

    function __construct() {

        parent::__construct();
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
            $this->session->unset_userdata('version_data');
        }
        /* End - Reset All Fields */

        $searchsort_session = $this->session->userdata('version_data'); // store data in session

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

        /* Sorting */
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
                $sortfield = 'version_id';
                $sortby = 'desc';
                $data['sortfield'] = $sortfield;
                $data['sortby'] = $sortby;
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
        $tableName = VERSION_MASTER . ' as v';
        $fields = array('v.version_id, v.version_name,v.version_isactive, 
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

        if (!empty($searchtext)) {
            $searchtext = html_entity_decode(trim(addslashes($searchtext)));
            $where_search = '(v.version_name LIKE "%' . $searchtext . '%" '
                    // . 'OR v.version_isactive LIKE "%' . $searchtext . '%" '
                    . 'OR ch.code_name LIKE "%' . $searchtext . '%" '
                    . 'OR cg.code_name LIKE "%' . $searchtext . '%" '
                    . 'OR cma.code_name LIKE "%' . $searchtext . '%" '
                    . 'OR cmm.code_name LIKE "%' . $searchtext . '%" '
                    . 'OR cbv.code_name LIKE "%' . $searchtext . '%" '
                    . ')';

            $data['listRecords'] = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', '', '', $config['per_page'], $uri_segment, $sortfield, $sortby, '', $where_search);
            $config['total_rows'] = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', '', '', '', '', $sortfield, $sortby, '', $where_search, '', '', '1');
        } else {
            $data['listRecords'] = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', '', '', $config['per_page'], $uri_segment, $sortfield, $sortby, '', '');
            $config['total_rows'] = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', '', '', '', '', $sortfield, $sortby, '', '', '', '', '1');
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

        $this->session->set_userdata('version_data', $sortsearchpage_data);

        setActiveSession('version_data'); // set current Session active

        $data['crnt_view'] = $this->viewname;
        /* End Pagination */

        $data['crnt_view'] = $this->viewname;
        $data['form_action_path'] = $this->viewname . '/index';

        $data['main_content'] = '/versionlist';
        $data['header'] = array('menu_module' => 'masters', 'menu_child' => 'version');
        $data['footerJs'] = array(
            '0' => base_url() . 'uploads/custom/js/Version/Version.js'
        );
        
        $data['meta_title'] = 'Version Master Listing';

        if ($this->input->post('result_type') == 'ajax') {
            $this->load->view($this->viewname . '/ajaxList', $data);
        } else {
            $data['main_content'] = '/versionlist';
            $this->parser->parse('layouts/DefaultTemplate', $data);
        }
    }

    /*
      @Author : Maitrak Modi
      @Desc   : Version Master Add function
      @Input 	:
      @Output	:
      @Date   : 10th March 2017
     */

    public function add() {

        $this->formValidation(); // Form fields validation 

        if ($this->form_validation->run() == FALSE) {

            $table = CODELOOKUP;
            $fields = array('*');
            $match = array('isactive' => 'active');

            /* Start - SET Parent Child Array */
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

            /* All Dropdown values */
            $data['hot_cold_drpdwn_data'] = $nested['hot_cold_type']['children'];
            $data['gen_drpdwn_data'] = $nested['gen']['children'];
            $data['machine_abb_drpdwn_data'] = $nested['machine_abb']['children'];
            $data['machine_mpr_drpdwn_data'] = $nested['machine_mpr']['children'];
            $data['bev_type_drpdwn_data'] = $nested['bev_type']['children'];

            $data['crnt_view'] = $this->viewname;
            $data['form_action_path'] = $this->viewname . '/add';

            $data['main_content'] = '/addEdit';
            $data['validation'] = validation_errors();

            $data['screenType'] = 'add';

            $data['editVersion'] = '';
            $data['editHotCold'] = '';
            $data['editGen'] = '';
            $data['editMachineAbb'] = '';
            $data['editMachineMpr'] = '';
            $data['editBevType'] = '';

            $data['footerJs'] = array(
                '0' => base_url() . 'uploads/custom/js/Version/Version.js'
            );

            $data['meta_title'] = 'Add Version Master';
            //pr($data); exit;
            $this->parser->parse('layouts/DefaultTemplate', $data);
        } else {
            // success form
            $this->insertData();
        }
    }

    /*
      @Author : Maitrak Modi
      @Desc   : Version Master Insert Data
      @Input 	:
      @Output	:
      @Date   : 10th March 2017
     */

    public function insertData() {

        $data = array(
            'hot_cold_type' => $this->input->post('hot_cold'),
            'gen' => $this->input->post('gen'),
            'machine_abb' => $this->input->post('machine_abb'),
            'machine_mpr' => $this->input->post('mpr'),
            'bev_type' => $this->input->post('bev_type'),
            'version_name' => $this->input->post('version'),
            'version_description' => $this->input->post('version'),
            'version_isactive' => 'active',
            'created_by' => $this->session->userdata['LOGGED_IN']['ID'],
            'created_at' => date("Y-m-d H:i:s"),
            'updated_by' => $this->session->userdata['LOGGED_IN']['ID'],
            'updated_at' => date("Y-m-d H:i:s")
        );

        if ($this->common_model->insert(VERSION_MASTER, $data)) {
            $msg = 'Version data has been inserted successfully.';
            $this->session->set_flashdata('msg', "<div class='alert alert-success text-center'>$msg</div>");
        } else {
            // error
            $msg = $this->lang->line('error_msg');
            $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");
        }

        redirect('Version');
    }

    /*
      @Author : Maitrak Modi
      @Desc   : Version Master Edit Function
      @Input 	: Version Id
      @Output	:
      @Date   : 10th March 2017
     */

    public function edit($versionId) {

        $tableName = VERSION_MASTER;
        $fields = array('*');
        $match = array('version_id' => $versionId);

        $data['editRecord'] = $this->common_model->get_records($tableName, $fields, '', '', $match, '', '', '', '', '', '', '');

        if (!empty($data['editRecord'][0])) {

            $this->formValidation(); // Form fields validation

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

                /* All Dropdown Values */
                $data['hot_cold_drpdwn_data'] = $nested['hot_cold_type']['children'];
                $data['gen_drpdwn_data'] = $nested['gen']['children'];
                $data['machine_abb_drpdwn_data'] = $nested['machine_abb']['children'];
                $data['machine_mpr_drpdwn_data'] = $nested['machine_mpr']['children'];
                $data['bev_type_drpdwn_data'] = $nested['bev_type']['children'];

                /* Selecd values of dropdown */
                $data['editVersion'] = $data['editRecord'][0]['version_name'];
                $data['editHotCold'] = $data['editRecord'][0]['hot_cold_type'];
                $data['editGen'] = $data['editRecord'][0]['gen'];
                $data['editMachineAbb'] = $data['editRecord'][0]['machine_abb'];
                $data['editMachineMpr'] = $data['editRecord'][0]['machine_mpr'];
                $data['editBevType'] = $data['editRecord'][0]['bev_type'];

                $data['currentVersionId'] = $versionId;

                $data['screenType'] = 'edit';
                $data['crnt_view'] = $this->viewname;
                $data['form_action_path'] = $this->viewname . '/edit/' . $versionId;

                $data['main_content'] = '/addEdit';
                $data['validation'] = validation_errors();

                $data['footerJs'] = array(
                    '0' => base_url() . 'uploads/custom/js/Version/Version.js'
                );
                //pr($data); exit;
                $data['meta_title'] = 'Edit Version Master';
                $this->parser->parse('layouts/DefaultTemplate', $data);
            } else {
                // success form
                $this->updateData($versionId);
            }
        } else {
            // error
            $msg = $this->lang->line('error_msg');
            $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");

            redirect('Version');
        }
    }

    /*
      @Author : Maitrak Modi
      @Desc   : Version Master Update data
      @Input 	: Version Id
      @Output	:
      @Date   : 10th March 2017
     */

    public function updateData($versionId) {

        $data = array(
            'hot_cold_type' => $this->input->post('hot_cold'),
            'gen' => $this->input->post('gen'),
            'machine_abb' => $this->input->post('machine_abb'),
            'machine_mpr' => $this->input->post('mpr'),
            'bev_type' => $this->input->post('bev_type'),
            'version_name' => $this->input->post('version'),
            'version_description' => $this->input->post('version'),
            //'version_isactive' => 'active',
            //'created_by' => $this->session->userdata['LOGGED_IN']['ID'],
            //'created_at' => date("Y-m-d H:i:s"),
            'updated_by' => $this->session->userdata['LOGGED_IN']['ID'],
            'updated_at' => date("Y-m-d H:i:s")
        );

        /* Update Data */
        $where = array('version_id' => $versionId);

        if ($this->common_model->update(VERSION_MASTER, $data, $where)) { //Update data
            $msg = 'Version data has been updated successfully.';
            $this->session->set_flashdata('msg', "<div class='alert alert-success text-center'>$msg</div>");
        } else {
            // error
            $msg = $this->lang->line('error_msg');
            $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");
        }

        redirect('Version');
    }

    /*
      @Author : Maitrak Modi
      @Desc   : Version Master Form Feilds Server Side validation
      @Input 	: Version Id
      @Output	:
      @Date   : 10th March 2017
     */

    public function formValidation() {

        $this->form_validation->set_rules('version', 'Version', 'trim|required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('hot_cold', 'Hot/Cold', 'trim|required|xss_clean');
        $this->form_validation->set_rules('gen', 'Gen', 'trim|required|xss_clean');
        $this->form_validation->set_rules('machine_abb', 'Machine Abb', 'trim|required|xss_clean');
        $this->form_validation->set_rules('mpr', 'MPR', 'trim|required|xss_clean');
        $this->form_validation->set_rules('bev_type', 'bevType', 'trim|required|xss_clean');
    }

    /*
      @Author : Maitrak Modi
      @Desc   : Version Master Check Duplicate version name
      @Input 	: Version Id
      @Output	:
      @Date   : 14th March 2017
     */

    public function isDuplicateVersionName() {

        $isduplicate = 0;
        $versionName = trim($this->input->post('versionName'));
        $version_id = trim($this->input->post('version_id'));

        if (!empty($versionName)) {

            $tableName = VERSION_MASTER;
            $fields = array('COUNT(version_id) AS cntData');

            if (!empty($version_id)) { // edit 
                $match = array('version_name' => $versionName, 'version_id <>' => $version_id);
            } else {
                $match = array('version_name' => $versionName);
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

    /* public function deleteVersion() {

      $version_id = trim($this->input->post('version_id'));

      if (!empty($version_id)) {

      $tableName = VERSION_MASTER;
      $fields = array('*');
      $match = array('version_id' => $version_id);

      if ($this->common_model->update($tableName, $data, $where)) {
      $msg = $this->lang->line('user_delete_msg');
      $this->session->set_flashdata('msg', "<div class='alert alert-success text-center'>$msg</div>");
      unset($id);
      //redirect($this->viewname . '/userlist'); //Redirect On Listing page
      } else {
      // error
      $msg = $this->lang->line('error_msg');
      $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");

      // redirect($this->viewname);
      // redirect($this->viewname . '/userlist'); //Redirect On Listing page
      }
      }
      } */

    /* public function changeStatus() {

      $version_id = trim($this->input->post('version_id'));
      $version_status = trim($this->input->post('versionStatus'));
      $updateStatus = '';
      $statusCode = 'error';
      if (!empty($version_id) && !empty($version_status)) {

      if ($version_status == 'active') {
      $updateStatus = 'inactive';
      } else {
      $updateStatus = 'active';
      }

      $tableName = VERSION_MASTER;
      $updateData = array('version_isactive' => $updateStatus);
      $where = array('version_id' => $version_id);

      if ($this->common_model->update($tableName, $updateData, $where)) {

      $msg = "<div class='alert alert-success text-center'>Status has been updated successfully.</div>";
      $statusCode = 'success';
      //$this->session->set_flashdata('msg', "<div class='alert alert-success text-center'>$msg</div>");
      } else {
      $statusCode = 'error';
      $errormsg = $this->lang->line('error_msg');
      $msg = "<div class='alert alert-danger text-center'>$errormsg</div>";
      }
      } else {
      $statusCode = 'error';
      $errormsg = $this->lang->line('error_msg');
      $msg = "<div class='alert alert-danger text-center'>$errormsg</div>";
      }

      $returnData = array(
      'statusCode' => $statusCode,
      'msg' => $msg,
      'updateStatus' => $updateStatus
      );

      echo json_encode($returnData);
      //redirect('Version');
      } */
}
