<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AssignedMaintenance extends CI_Controller {

    function __construct() {

        parent::__construct();

        $this->viewname = $this->uri->segment(1);
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('form_validation', 'Session', 'upload'));
    }

    /*
      @Author : Maitrak Modi
      @Desc   : Maintenance Listing
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
            $this->session->unset_userdata('maintenance_backoffice_data');
        }
        /* End - Reset All Fields */

        $searchsort_session = $this->session->userdata('maintenance_backoffice_data'); // store data in session

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
            m.maintenance_status, m.responase_date, m.visited_date, m.updated_at,
            mi.machine_serial_number, mi.machine_name, mi.machine_id,
            c.code_name
            ');

        $join_tables = array(
            MACHINE_INVENTORY . ' as mi' => 'm.location_id = mi.inventory_id',
            CODELOOKUP . ' as c' => 'm.maintenance_status = c.code_id',
        );

        //$whereCond = array();
        $whereCond = array('m.is_delete' => '0');

        if (!empty($searchtext)) {
            $searchtext = html_entity_decode(trim(addslashes($searchtext)));
            $where_search = '(m.contact_person  LIKE "%' . $searchtext . '%" '
                    . 'OR m.contact_number LIKE "%' . $searchtext . '%" '
                    . 'OR mi.machine_serial_number LIKE "%' . $searchtext . '%" '
                    . 'OR mi.machine_name LIKE "%' . $searchtext . '%" '
                    . 'OR mi.machine_id LIKE "%' . $searchtext . '%" '
                    . 'OR IF(m.request_type = "cm", "Corrective Maintenance", "Preventive Maintenance") LIKE "%' . $searchtext . '%" '
                    . 'OR m.maintenance_status LIKE "%' . $searchtext . '%" '
                    . 'OR m.responase_date LIKE "%' . $searchtext . '%" '
                    . 'OR m.visited_date LIKE "%' . $searchtext . '%" '
                    . 'OR DATE_FORMAT(m.updated_at,"%Y-%m-%d") LIKE "%' . $searchtext . '%" '
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

        $this->session->set_userdata('maintenance_backoffice_data', $sortsearchpage_data);
        setActiveSession('maintenance_backoffice_data'); // set current Session active

        $data['crnt_view'] = $this->viewname;
        /* End Pagination */

        $data['crnt_view'] = $this->viewname;
        $data['form_action_path'] = $this->viewname . '/index';

        //$data['main_content'] = '/customerlist';
        $data['header'] = array('menu_module' => 'assigned_maintenance', 'menu_child' => 'assigned_maintenance');
        $data['footerJs'] = array(
            '0' => base_url() . 'uploads/custom/js/Maintenance/Maintenance_list.js',
        );

        if ($this->input->post('result_type') == 'ajax') {
            $this->load->view($this->viewname . '/ajaxList', $data);
        } else {
            $data['main_content'] = '/maintenanceList';
            $this->parser->parse('layouts/DefaultTemplate', $data);
        }
    }

    /*
      @Author : Maitrak Modi
      @Desc   : get assigned Maintenance
      @Input 	:
      @Output	:
      @Date   : 29th May 2017
     */

    public function edit($maintenanceId) {

        $assignMachineData = $this->getMaintenanceDetails($maintenanceId);

        if (!empty($assignMachineData)) {

            $this->formValidation(); // form Validation fields
            if ($this->form_validation->run() == FALSE) {

                $data['validation'] = validation_errors();

                $data = array(
                    'customer_code' => $assignMachineData['customer_code'],
                    'customer_name' => $assignMachineData['customer_name'],
                    'mobile_number' => $assignMachineData['mobile_number'],
                    'location' => $assignMachineData['location'],
                    'machine_serial_number' => $assignMachineData['machine_serial_number'],
                    'request_type' => $assignMachineData['r_type'],
                    'contact_person' => $assignMachineData['contact_person'],
                    'contact_number' => $assignMachineData['contact_number'],
                    'machine_id' => $assignMachineData['machine_id'],
                    'asset' => $assignMachineData['asset'],
                    'address_of_machine' => $assignMachineData['address_of_machine'],
                    'machine_issues' => $assignMachineData['issues'],
                    'preventive_maintenance' => $assignMachineData['preventive_maintenance'],
                    'assigned_to' => $assignMachineData['zone_name'],
                );

                /* Editable info */
                $data['editStatus'] = $assignMachineData['maintenance_status'];
                $data['editPartReplaced'] = $assignMachineData['part_replaced'];
                $data['editResponseDate'] = (!empty($assignMachineData['responase_date'])) ? date('m/d/y', strtotime($assignMachineData['responase_date'])) : '';
                $data['editVisitedDate'] = (!empty($assignMachineData['visited_date'])) ? date('m/d/y', strtotime($assignMachineData['visited_date'])) : '';
                $data['editActionTaken'] = $assignMachineData['action_taken'];
                $data['editComment'] = $assignMachineData['comments'];
                $data['editResolution'] = $assignMachineData['resolution'];

                /* Start -  Status */
                $table = CODELOOKUP;
                $fields = array('code_id, parent_code_id, code_name');
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

                $data['statusList'] = '';

                if (isset($nested['collection_order_status'])) {
                    $data['statusList'] = $nested['collection_order_status']['children'];
                }
                /* End -  Status */

                $data['crnt_view'] = $this->viewname;
                $data['form_action_path'] = $this->viewname . '/edit/' . $maintenanceId;
                $data['main_content'] = '/assignMaintenance';

                $data['footerJs'] = array(
                    '0' => base_url() . 'uploads/assets/js/bootstrap-datetimepicker.min.js',
                    '1' => base_url() . 'uploads/custom/js/Maintenance/Maintenance_backoffice.js',
                );


                $data['screenType'] = 'edit';

                $data['header'] = array('menu_module' => 'assigned_maintenance', 'menu_child' => 'assigned_maintenance');

                $this->parser->parse('layouts/DefaultTemplate', $data);
            } else {

                $this->updateAssignMaintenance($maintenanceId);
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
      @Desc   : Update assigned Maintenance
      @Input 	: manintenance id
      @Output	:
      @Date   : 29th May 2017
     */

    protected function updateAssignMaintenance($maintenanceId) {

        $data = array(
            'maintenance_status' => $this->input->post('status'),
            'part_replaced' => $this->input->post('parts_replaced'),
            'action_taken' => $this->input->post('action_taken'),
            'comments' => $this->input->post('comments'),
            'resolution' => $this->input->post('resolution'),
            'responase_date' => date('Y-m-d', strtotime($this->input->post('response_date'))),
            'visited_date' => date('Y-m-d', strtotime($this->input->post('visited_date'))),
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
      @Desc   : get assigned Maintenance Details
      @Input 	:
      @Output	:
      @Date   : 29th May 2017
     */

    protected function getMaintenanceDetails($maintenanceId = '') {

        $tableName = MAINTENANCE . ' as m';

        $fields = array('m.*, IF(m.request_type = "cm", "Corrective Maintenance", "Preventive Maintenance") as r_type,
            ce.customer_id, ce.customer_name, ce.customer_code, ce.location, ce.mobile_number,
            mi.inventory_id, mi.machine_serial_number, mi.machine_id, mi.asset,
            l.firstname as zone_name');

        $join_tables = array(
            //CUSTOMER_MACHINE_INFORMATION . ' as cmi' => 'm.customer_id  = cmi.customer_id',
            CUSTOMER_ENROLMENT . ' as ce' => 'm.customer_id  = ce.customer_id',
            MACHINE_INVENTORY . ' as mi' => 'm.location_id = mi.inventory_id',
            LOGIN . ' as l' => 'm.assigned_to = l.login_id'
        );

        $whereCond = array('m.is_delete' => '0', 'm.maintenance_id' => $maintenanceId);

        $data['assignedRecords'] = $this->common_model->get_records($tableName, $fields, $join_tables, 'left', $whereCond, '', '', '', '', '', '', '');

        return $data['assignedRecords'][0];
    }

    /*
      @Author : Maitrak Modi
      @Desc   :  Form validation
      @Input 	:
      @Output	:
      @Date   : 1st June 2017
     */

    public function formValidation() {

        $this->form_validation->set_rules('response_date', 'Response Date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('visited_date', 'Visited Date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('action_taken', 'Action Taken', 'trim|xss_clean');
        $this->form_validation->set_rules('comments', 'Comments', 'trim|xss_clean');
        $this->form_validation->set_rules('resolution', 'Resolution', 'trim|xss_clean');
    }

    /*
      @Author : Maitrak Modi
      @Desc   : Maintenance soft delete
      @Input 	:
      @Output	:
      @Date   : 1st June 2017
     */

    public function deleteMaintenance() {

        $maintenanceId = $this->input->post('maintenanceId');

        if (!empty($maintenanceId)) {

            $tableName = MAINTENANCE;
            $data = array('is_delete' => '1');
            $where = array('maintenance_id' => $maintenanceId);

            if ($this->common_model->update($tableName, $data, $where)) {
                $msg = 'Maintenance has been deleted successfully.';
                $this->session->set_flashdata('msg', "<div class='alert alert-success text-center'>$msg</div>");
            } else {
                // error
                $msg = $this->lang->line('error_msg');
            }

            echo base_url($this->viewname);
        }
    }

}
