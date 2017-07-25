<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Zone extends CI_Controller {

    function __construct() {

        parent::__construct();

        $this->viewname = $this->uri->segment(1);
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('form_validation', 'Session'));
    }

    /*
      @Author : Maitrak Modi
      @Desc   : Zone Assign
      @Input 	:
      @Output	:
      @Date   : 28th March 2017
     */

    public function assign() {

        $this->form_validation->set_rules('zone_list', 'Zone', 'trim|required|xss_clean'); // form validation

        if ($this->form_validation->run() == FALSE) {

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
                '0' => base_url() . 'uploads/custom/js/zone/zone.js'
            );

            $data['crnt_view'] = $this->viewname;
            $data['form_action_path'] = $this->viewname . '/assign';
            $data['main_content'] = '/zoneAssign';
            $data['header'] = array('menu_module' => 'masters', 'menu_child' => 'zone');
            $this->parser->parse('layouts/DefaultTemplate', $data);
        } else {
            //success form
            $this->updateSelectedData();
        }
    }

    /*
      @Author : Maitrak Modi
      @Desc   : Zone Assign
      @Input 	:
      @Output	:
      @Date   : 28th March 2017
     */

    public function updateSelectedData() {
        //pr($_POST);exit;
        $zoneID = $this->input->post('zone_list');
        $errorStatus = false;

        // Listbox1 Data
		$selectBoxFirst = $this->input->post('selectBox1');
        if (isset($selectBoxFirst) && !empty($selectBoxFirst)) {

            $lstBox1 = explode(',', $selectBoxFirst);

            foreach ($lstBox1 as $lb1) {
                $data = array(
                    'zone_id' => '',
                    'updated_by' => $this->session->userdata['LOGGED_IN']['ID'],
                    'updated_at' => date("Y-m-d H:i:s")
                );
                $whereCond1 = array('customer_id' => $lb1);

                if (!$this->common_model->update(CUSTOMER_ENROLMENT, $data, $whereCond1)) { //Update data
                    $errorStatus = true;
                }
            }
        }

        // Listbox2 Data
		$selectBoxSecond = $this->input->post('selectBox2');
        if (isset($selectBoxSecond) && !empty($selectBoxSecond)) {

            $lstBox2 = explode(',', $selectBoxSecond);

            foreach ($lstBox2 as $lb2) {
                //echo $lb2.'<br/>';
                $data = array(
                    'zone_id' => $zoneID,
                    'updated_by' => $this->session->userdata['LOGGED_IN']['ID'],
                    'updated_at' => date("Y-m-d H:i:s")
                );
                $whereCond2 = array('customer_id' => $lb2);
                //pr($whereCond2);
                if (!$this->common_model->update(CUSTOMER_ENROLMENT, $data, $whereCond2)) { //Update data
                    $errorStatus = true;
                }
            }
        }

        if ($errorStatus) {
            $msg = $this->lang->line('error_msg');
            $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");
        } else {
            $msg = 'Customer has been assigned Successfully.';
            $this->session->set_flashdata('msg', "<div class='alert alert-success text-center'>$msg</div>");
        }

        //return true;
        //$data = array('d' => '10');
        redirect($this->viewname . '/assign');
    }

    /*
      @Author : Maitrak Modi
      @Desc   : Zone Assign Both ListBox Select
      @Input 	:
      @Output	:
      @Date   : 28th March 2017
     */

    public function getBothSelectBox() {

        $customerListBox1 = '';
        $customerListBox2 = '';

        $selectedZone = trim($this->input->post('selectedZone'));

        /* Start - All Customer List */
        $table = CUSTOMER_ENROLMENT . ' as ce';
        $customerFields = array('ce.customer_id, ce.customer_name');
        $whereConditionBox1 = array('ce.is_delete' => '0');

        if (!empty($selectedZone)) {
            $whereConditionBox1 = array('ce.is_delete' => '0', 'ce.zone_id !=' => $selectedZone);
            $whereConditionBox2 = array('ce.is_delete' => '0', 'ce.zone_id ' => $selectedZone);

            /* Start - Selectd Zone customer */
            $data['customerListBox2'] = $this->common_model->get_records($table, $customerFields, '', '', $whereConditionBox2, '', '', '', '', '', '', '');

            if (!empty($data['customerListBox2'])) {

                foreach ($data['customerListBox2'] as $customerDataBox2) {
                    $customerListBox2 .= '<option value="' . $customerDataBox2['customer_id'] . '" >' . $customerDataBox2['customer_name'] . '</option>';
                }
            }
            /* End - Selectd Zone customer */
        }

        $data['customerListBox1'] = $this->common_model->get_records($table, $customerFields, '', '', $whereConditionBox1, '', '', '', '', '', '', '');


        if (!empty($data['customerListBox1'])) {
            foreach ($data['customerListBox1'] as $customerDataBox1) {
                $customerListBox1 .= '<option value="' . $customerDataBox1['customer_id'] . '">' . $customerDataBox1['customer_name'] . '</option>';
            }
        }
        /* End - All Customer List */

        $returnData = array(
            'listBox1' => $customerListBox1,
            'listBox2' => $customerListBox2
        );

        echo json_encode($returnData);
    }

}
