<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Feedback extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->viewname = $this->uri->segment(1);
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('form_validation', 'Session'));
    }

    /*
      @Author : Maitrak Modi
      @Desc   : Feedback Listing
      @Input  :
      @Output :
      @Date   : 22nd June 2017
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
            $this->session->unset_userdata('feedback_data');
        }
        /* End - Reset All Fields */

        $searchsort_session = $this->session->userdata('feedback_data'); // store data in session

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
                $sortfield = 'feedback_id';
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
        $tableName = FEEDBACK . ' as f';
        $fields = array('f.*');

        $join_tables = array();
        $whereCond = array('is_delete' => 0);

        if (!empty($searchtext)) {
            $searchtext = html_entity_decode(trim(addslashes($searchtext)));
            $where_search = '(f.auditor  LIKE "%' . $searchtext . '%" '
                    . 'OR f.feedback_date LIKE "%' . $searchtext . '%" '
                    . 'OR f.ticket_date LIKE "%' . $searchtext . '%" '
                    . 'OR f.subject LIKE "%' . $searchtext . '%" '
                    . 'OR f.ticket_number LIKE "%' . $searchtext . '%" '
                    . 'OR f.phone_number LIKE "%' . $searchtext . '%" '
                    . 'OR f.satisfaction_level LIKE "%' . $searchtext . '%" '
                    . 'OR f.attitude_of_emp LIKE "%' . $searchtext . '%" '
                    . 'OR f.specific_afi LIKE "%' . $searchtext . '%" ' . ')';

            $data['listRecords'] = $this->common_model->get_records($tableName, $fields, $join_tables, '', $whereCond, '', $config['per_page'], $uri_segment, $sortfield, $sortby, '', $where_search);
            $config['total_rows'] = $this->common_model->get_records($tableName, $fields, $join_tables, '', $whereCond, '', '', '', $sortfield, $sortby, '', $where_search, '', '', '1');
        } else {
            $data['listRecords'] = $this->common_model->get_records($tableName, $fields, $join_tables, '', $whereCond, '', $config['per_page'], $uri_segment, $sortfield, $sortby, '', '');
            $config['total_rows'] = $this->common_model->get_records($tableName, $fields, $join_tables, '', $whereCond, '', '', '', $sortfield, $sortby, '', '', '', '', '1');
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
        $this->session->set_userdata('feedback_data', $sortsearchpage_data);
        setActiveSession('feedback_data'); // set current Session active

        $data['crnt_view'] = $this->viewname;
        /* End Pagination */

        $data['crnt_view'] = $this->viewname;
        $data['form_action_path'] = $this->viewname . '/index';

        $data['header'] = array('menu_module' => 'masters', 'menu_child' => 'feedback');

        $data['footerJs'] = array(
            '0' => base_url() . 'uploads/custom/js/Feedback/FeedbackList.js'
        );

        if ($this->input->post('result_type') == 'ajax') {
            $this->load->view($this->viewname . '/ajaxList', $data);
        } else {
            $data['main_content'] = '/feedbacklist';
            $this->parser->parse('layouts/DefaultTemplate', $data);
        }
    }

    /*
      @Author : Maitrak Modi
      @Desc   : Feedback Add function
      @Input  :
      @Output :
      @Date   : 22nd June 2017
     */

    public function add() {

        $this->formValidation(); // Form validation

        if ($this->form_validation->run() == FALSE) {

            $data['validation'] = validation_errors();

            $data['customerNameList'] = $this->getCustomeList(); // customer name list

            $data['crnt_view'] = $this->viewname;
            $data['form_action_path'] = $this->viewname . '/add';
            $data['main_content'] = '/addEdit';
            $data['screenType'] = 'add';

            $data['footerJs'] = array(
                '0' => base_url() . 'uploads/assets/js/bootstrap-datetimepicker.min.js',
                '1' => base_url() . 'uploads/custom/js/Feedback/Feedback.js',
            );

            $data['header'] = array('menu_module' => 'masters', 'menu_child' => 'feedback');

            $this->parser->parse('layouts/DefaultTemplate', $data);
        } else {
            //success form
            $this->insertData();
        }
    }

    /*
      @Author : Maitrak Modi
      @Desc   : Feedback Insert Data
      @Input  :
      @Output :
      @Date   : 22nd June 2017
     */

    public function insertData() {

        // Inserted Array Data
        $data = array(
            'customer_id' => $this->input->post('customer_id'),
            'customer_name' => $this->input->post('customer_name'),
            'feedback_date' => date('Y-m-d', strtotime($this->input->post('feedback_date'))),
            'auditor' => $this->input->post('feedback_auditor'),
            'ticket_date' => date('Y-m-d', strtotime($this->input->post('ticket_date'))),
            'subject' => $this->input->post('subject'),
            'phone_number' => $this->input->post('phone_number'),
            'ticket_number' => $this->input->post('ticket_number'),
            'satisfaction_level' => $this->input->post('satisfaction_level'),
            'attitude_of_emp' => $this->input->post('attitude_of_emp'),
            'specific_afi' => $this->input->post('specific_afi'),
            'created_by' => $this->session->userdata['LOGGED_IN']['ID'],
            'created_at' => date("Y-m-d H:i:s"),
            'updated_by' => $this->session->userdata['LOGGED_IN']['ID'],
            'updated_at' => date("Y-m-d H:i:s")
        );

        // Insert query

        if ($this->common_model->insert(FEEDBACK, $data)) {
            $msg = 'Feedback has been submitted successfully.'; //$this->lang->line('');
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
      @Desc   :Feedback Edit Function
      @Input  : Feedback Id
      @Output :
      @Date   : 21st June 2017
     */

    public function edit($feedBackId) {

        $tableName = FEEDBACK . ' as f';
        $fields = array('f.*');
        $match = array('f.feedback_id' => $feedBackId);
        $data['editFeedBackRecord'] = $this->common_model->get_records($tableName, $fields, '', '', $match, '', '', '', '', '', '', '');

        if (!empty($data['editFeedBackRecord'][0])) {

            $this->formValidation(); // Form fields validation

            if ($this->form_validation->run() == FALSE) {

                $data['validation'] = validation_errors();

                /* Start - Edit data in form */
                $data['editCustomerId'] = $data['editFeedBackRecord'][0]['customer_id'];
                $data['editCustomerName'] = $data['editFeedBackRecord'][0]['customer_name'];
                $data['editFeedBackDate'] = date('m/d/Y', strtotime($data['editFeedBackRecord'][0]['feedback_date']));
                $data['editAuditor'] = $data['editFeedBackRecord'][0]['auditor'];
                $data['editTicketDate'] = date('m/d/Y', strtotime($data['editFeedBackRecord'][0]['ticket_date']));
                $data['editSubject'] = $data['editFeedBackRecord'][0]['subject'];
                $data['editPhoneNumber'] = $data['editFeedBackRecord'][0]['phone_number'];
                $data['editTicketNumber'] = $data['editFeedBackRecord'][0]['ticket_number'];
                $data['editSatisfactionLevel'] = $data['editFeedBackRecord'][0]['satisfaction_level'];
                $data['editAttitudeOfEmp'] = $data['editFeedBackRecord'][0]['attitude_of_emp'];
                $data['editSpecificaAfi'] = $data['editFeedBackRecord'][0]['specific_afi'];
                /* End - Edit data in form */

                $data['customerNameList'] = $this->getCustomeList(); // customer name list

                $data['footerJs'] = array(
                    '0' => base_url() . 'uploads/assets/js/bootstrap-datetimepicker.min.js',
                    '1' => base_url() . 'uploads/custom/js/Feedback/Feedback.js',
                );

                $data['crnt_view'] = $this->viewname;
                $data['form_action_path'] = $this->viewname . '/edit/' . $feedBackId;
                $data['main_content'] = '/addEdit';

                $data['screenType'] = 'edit';

                $data['header'] = array('menu_module' => 'masters', 'menu_child' => 'feedback');

                $this->parser->parse('layouts/DefaultTemplate', $data);
            } else {
                // success form
                $this->updateData($feedBackId);
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
      @Desc   : Feedback update Data
      @Input  : Feedback ID
      @Output :
      @Date   : 22nd June 2017
     */

    public function updateData($feedBackId) {

        // Updated Array Data
        $data = array(
            'customer_id' => $this->input->post('customer_id'),
            'customer_name' => $this->input->post('customer_name'),
            'feedback_date' => date('Y-m-d', strtotime($this->input->post('feedback_date'))),
            'auditor' => $this->input->post('feedback_auditor'),
            'ticket_date' => date('Y-m-d', strtotime($this->input->post('ticket_date'))),
            'subject' => $this->input->post('subject'),
            'phone_number' => $this->input->post('phone_number'),
            'ticket_number' => $this->input->post('ticket_number'),
            'satisfaction_level' => $this->input->post('satisfaction_level'),
            'attitude_of_emp' => $this->input->post('attitude_of_emp'),
            'specific_afi' => $this->input->post('specific_afi'),
            'updated_by' => $this->session->userdata['LOGGED_IN']['ID'],
            'updated_at' => date("Y-m-d H:i:s")
        );

        // update feedback
        $where = array('feedback_id' => $feedBackId);

        if ($this->common_model->update(FEEDBACK, $data, $where)) { //Update data
            $msg = 'Feedback has been updated.';
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
      @Desc   : Form valiation
      @Input  :
      @Output :
      @Date   : 21st June 2017
     */

    public function formValidation() {

        $this->form_validation->set_rules('feedback_date', 'Date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('feedback_auditor', 'Auditor', 'trim|required|max_length[100]|xss_clean');
        $this->form_validation->set_rules('ticket_date', 'Auditor', 'trim|required|xss_clean');
        $this->form_validation->set_rules('subject', 'Subject', 'trim|required|max_length[100]|xss_clean');
        $this->form_validation->set_rules('ticket_number', 'Ticket Number', 'trim|required|max_length[50]|xss_clean');
        $this->form_validation->set_rules('customer_name', 'Customer Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('phone_number', 'Phone Number', 'trim|required|xss_clean');
        $this->form_validation->set_rules('satisfaction_level', 'Overall Level of Satisfaction', 'trim|required|max_length[150]|xss_clean');
        $this->form_validation->set_rules('attitude_of_emp', 'Attitude of the Employee', 'trim|required|max_length[100]|xss_clean');
        $this->form_validation->set_rules('specific_afi', 'Attitude of the Employee', 'trim|required|max_length[100]|xss_clean');
    }

    /*
      @Author : Maitrak Modi
      @Desc   : get customer list based on type
      @Input  :
      @Output :
      @Date   : 22nd June 2017
     */

    public function getCustomeList() {

        $tableName = CUSTOMER_ENROLMENT . ' as ce';
        $fields = array('ce.customer_name, ce.customer_id, ce.customer_code');

        $whereCond = array('ce.is_delete' => '0');

        $groupBy = array('ce.customer_name');

        $data['customerCodeRecords'] = $this->common_model->get_records($tableName, $fields, '', '', $whereCond, '', '', '', '', '', $groupBy);
        //echo $this->db->last_query(); exit;
        return $data['customerCodeRecords'];
    }

    /*
      @Author : Maitrak Modi
      @Desc   : Feedback soft delete
      @Input  :
      @Output :
      @Date   : 22nd June 2017
     */

    public function deleteFeedback() {

        $feedBackId = $this->input->post('feedBackId');

        if (!empty($feedBackId)) {

            $tableName = FEEDBACK;
            $data = array('is_delete' => '1',
                'updated_by' => $this->session->userdata['LOGGED_IN']['ID'],
                'updated_at' => date("Y-m-d H:i:s")
            );
            $where = array('feedback_id' => $feedBackId);

            if ($this->common_model->update($tableName, $data, $where)) {
                $msg = 'Feedback has been deleted succssfully.';
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
        }
    }

    /*
      @Author : Maitrak Modi
      @Desc   : get pop up data
      @Input  :
      @Output :
      @Date   : 22nd June 2017
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

}
