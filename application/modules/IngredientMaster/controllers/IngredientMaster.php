<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class IngredientMaster extends CI_Controller {

    function __construct() {

        parent::__construct();
        if (checkPermission('IngredientMaster', 'view') == false) {
            redirect('/User');
        }
        $this->viewname = $this->uri->segment(1);
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('form_validation', 'Session'));
    }

    /*
      @Author : Ritesh rana
      @Desc   : Ingredient Category Index Page
      @Input 	:
      @Output	:
      @Date   : 10/03/2017
     */

    public function index() {
        $searchtext = '';
        $perpage = '';
        $searchtext = $this->input->post('searchtext');
        $sortfield = $this->input->post('sortfield');
        $sortby = $this->input->post('sortby');
        $perpage = 10;
        $allflag = $this->input->post('allflag');
        if (!empty($allflag) && ($allflag == 'all' || $allflag == 'changesorting' || $allflag == 'changesearch')) {
            $this->session->unset_userdata('ingredientmaster_data');
        }

        $searchsort_session = $this->session->userdata('ingredientmaster_data');
        //Sorting
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
                $sortfield = 'cat_id';
                $sortby = 'desc';
                $data['sortfield'] = $sortfield;
                $data['sortby'] = $sortby;
            }
        }
        //Search text
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
                $config['per_page'] = '10';
                $data['perpage'] = '10';
            }
        }
        //pagination configuration
        $config['first_link'] = 'First';
        $config['base_url'] = base_url() . $this->viewname . '/index';

        if (!empty($allflag) && ($allflag == 'all' || $allflag == 'changesorting' || $allflag == 'changesearch')) {
            $config['uri_segment'] = 0;
            $uri_segment = 0;
        } else {
            $config['uri_segment'] = 3;
            $uri_segment = $this->uri->segment(3);
        }
        //Query
        $table = CATEGORY . ' as ct';
        $where = array("ct.is_deleted" => '0');
        $fields = array("ct.cat_id, ct.cat_name , ct.created_by, ct.created_date, ct.status, l.firstname, l.lastname ");
        $join_tables = array(LOGIN . ' as l' => 'l.login_id=ct.created_by');
        if (!empty($searchtext)) {
            $searchtext = html_entity_decode(trim(addslashes($searchtext)));
            $match = '';
            $where_search = '((ct.cat_name LIKE "%' . $searchtext . '%" OR ct.created_date LIKE "%' . date("Y-m-d", strtotime($searchtext)) . '%" OR ct.status LIKE "%' . $searchtext . '%") AND ct.is_deleted = "0")';

            $data['information'] = $this->common_model->get_records($table, $fields, $join_tables, 'left', '', $match, $config['per_page'], $uri_segment, $sortfield, $sortby, '', $where_search);

            $config['total_rows'] = $this->common_model->get_records($table, $fields, $join_tables, 'left', '', $match, '', '', $sortfield, $sortby, '', $where_search, '', '', '1');
        } else {
            $data['information'] = $this->common_model->get_records($table, $fields, $join_tables, 'left', '', '', $config['per_page'], $uri_segment, $sortfield, $sortby, '', $where);
            $config['total_rows'] = $this->common_model->get_records($table, $fields, $join_tables, 'left', '', '', '', '', $sortfield, $sortby, '', $where, '', '', '1');
        }
//pr($data['campaign_info']);exit;
        $this->ajax_pagination->initialize($config);
        $data['pagination'] = $this->ajax_pagination->create_links();
        $data['uri_segment'] = $uri_segment;
        $sortsearchpage_data = array(
            'sortfield' => $data['sortfield'],
            'sortby' => $data['sortby'],
            'searchtext' => $data['searchtext'],
            'perpage' => trim($data['perpage']),
            'uri_segment' => $uri_segment,
            'total_rows' => $config['total_rows']);

        $this->session->set_userdata('ingredientmaster_data', $sortsearchpage_data);
        setActiveSession('ingredientmaster_data'); // set current Session active
        $data['header'] = array('menu_module' => 'masters', 'menu_child' => 'ingredientmaster');
        $data['crnt_view'] = $this->viewname;
        $data['meta_title'] = 'Ingredient Master Listing';
        $data['footerJs'][0] = base_url('uploads/custom/js/ingredient/ingredient.js');
        if ($this->input->post('result_type') == 'ajax') {
            $this->load->view($this->viewname . '/ajaxlist', $data);
        } else {
            $data['main_content'] = '/ingredientmasterlist';
            $this->parser->parse('layouts/DefaultTemplate', $data);
        }
    }

    /*
      @Author : Ritesh rana
      @Desc   : Ingredient Category insertdata
      @Input 	:
      @Output	:
      @Date   : 10/03/2017
     */

    public function insertdata() {
        if (!validateFormSecret()) {
            $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>" . lang('error') . "</div>");
            redirect($this->viewname . '/ingredientmasterlist'); //Redirect On Listing page
        }
        $data['crnt_view'] = $this->viewname;
        //insert the ingredient category details into database
        $data = array(
            'cat_name' => trim($this->input->post('cat_name')),
            'description' => trim($this->input->post('description')),
            'created_by' => $this->session->userdata['LOGGED_IN']['ID'],
            'created_date' => datetimeformat(),
            'status' => $this->input->post('status')
        );
        //Insert Record in Database
        if ($this->common_model->insert(CATEGORY, $data)) {
            $msg = $this->lang->line('category_add_msg');
            $this->session->set_flashdata('msg', "<div class='alert alert-success text-center'>$msg</div>");
        } else {
            // error
            $msg = $this->lang->line('error_msg');
            $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");
        }

        redirect('IngredientMaster');
    }

    /*
      @Author : ritesh rana
      @Desc   : Ingredient Category list view Page
      @Input 	:
      @Output	:
      @Date   : 10/03/2017
     */

    public function addcategory() {
        $this->formValidation();
        //echo $randomMachineId; exit;
        if ($this->form_validation->run() == FALSE) {
            $data['footerJs'][0] = base_url('uploads/custom/js/ingredient/ingredient.js');
            $data['crnt_view'] = $this->viewname;
            $data['validation'] = validation_errors();
            $data['header'] = array('menu_module' => 'masters', 'menu_child' => 'ingredientmaster');
            $data['form_action_path'] = $this->viewname . '/addcategory';
            $data['main_content'] = '/addeditingredientmaster';
            $data['meta_title'] = 'Add Ingredient Master';
            $this->parser->parse('layouts/DefaultTemplate', $data);
        } else {
            $this->insertdata();
        }
    }

    /*
      @Author : Ritesh Rana
      @Desc   : ingredientmaster Edit Page
      @Input 	:
      @Output	:
      @Date   : 10/03/2017
     */

    public function edit($id) {
        $this->formValidation();
        //echo $randomMachineId; exit;
        if ($this->form_validation->run() == FALSE) {
            $data['footerJs'][0] = base_url('uploads/custom/js/ingredient/ingredient.js');
            $this->session->unset_userdata('FORM_SECRET', '');
            $table = CATEGORY . ' as ct';
            $match = "ct.cat_id = " . $id;
            $data['validation'] = validation_errors();
            $fields = array("ct.cat_id, ct.cat_name , ct.created_by, ct.created_date, ct.status ,ct.description");
            $data['editRecord'] = $this->common_model->get_records($table, $fields, '', '', $match);
            $data['form_action_path'] = $this->viewname . '/edit/' . $id;
            $data['id'] = $id;
            $data['crnt_view'] = $this->viewname;
            $data['header'] = array('menu_module' => 'masters', 'menu_child' => 'ingredientmaster');
            $data['main_content'] = '/addeditingredientmaster';
            $data['meta_title'] = 'Edit Ingredient Master';
            $this->parser->parse('layouts/DefaultTemplate', $data);
        } else {
            $this->updatedata();
        }
    }

    /*
      @Author : Ritesh rana
      @Desc   : Ingredient Category Update Query
      @Input 	: Post record from Ingredient Category
      @Output	: Update data in database and redirect
      @Date   : 10/03/2017
     */

    public function updatedata() {
        $status = $this->input->post('status');
        $id = $this->input->post('cat_id');
        $data['id'] = $id;
        $data['crnt_view'] = $this->viewname;
        $data = array(
            'cat_name' => trim($this->input->post('cat_name')),
            'description' => trim($this->input->post('description')),
            'updated_by' => $this->session->userdata['LOGGED_IN']['ID'],
            'updated_date' => datetimeformat(),
            'status' => $status
        );
        //Update Record in Database
        $where = array('cat_id' => $id);
        // Update form data into database
        if ($this->common_model->update(CATEGORY, $data, $where)) {

            $msg = $this->lang->line('category_update_msg');
            $this->session->set_flashdata('msg', "<div class='alert alert-success text-center'>$msg</div>");
        } else {    // error
            $msg = $this->lang->line('error_msg');
            $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");
        }
        redirect('IngredientMaster'); //Redirect On Listing page
    }

    /*
      @Author : Ritesh Rana
      @Desc   : ingredient category List Delete Query
      @Input 	: Post id from List page
      @Output	: Delete data from database and redirect
      @Date   : 10/03/2017
     */

    public function deletedata($id) {

        //Delete Record From Database
        if (!empty($id)) {

            $data = array('is_deleted' => 1);

            $where = array('cat_id' => $id);

            if ($this->common_model->update(CATEGORY, $data, $where)) {
                $msg = $this->lang->line('ingredient_delete_msg');
                $this->session->set_flashdata('msg', "<div class='alert alert-success text-center'>$msg</div>");
                unset($id);
            } else {
                // error
                $msg = $this->lang->line('error_msg');
                $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");
            }
        }
        redirect('IngredientMaster');
    }

    /*
      @Author : Ritesh Rana
      @Desc   : Ingredient Category Edit Page
      @Input 	:
      @Output	:
      @Date   : 10/03/2017
     */

    public function view($id) {
        //Get Records From Login Table
        $data['footerJs'][0] = base_url('uploads/custom/js/ingredient/ingredient.js');
        $table = CATEGORY . ' as ct';
        $match = "ct.cat_id = " . $id;
        $fields = array("ct.cat_id, ct.cat_name , ct.created_by, ct.created_date, ct.status,ct.description");
        $data['editRecord'] = $this->common_model->get_records($table, $fields, '', '', $match);

        $data['readonly'] = array("disabled" => "disabled");

        $data['id'] = $id;
        $data['crnt_view'] = $this->viewname;
        $data['main_content'] = '/addeditingredientMaster';
        $this->parser->parse('layouts/DefaultTemplate', $data);
    }

    /*
      @Author : Ritesh Rana
      @Desc   : form validation
      @Input 	:
      @Output	:
      @Date   : 10/03/2017
     */

    public function formValidation($id = null) {
        $this->form_validation->set_rules('cat_name', 'category Name', 'trim|required|min_length[2]|max_length[100]|xss_clean');
    }

}
