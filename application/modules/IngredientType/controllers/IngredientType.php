<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class IngredientType extends CI_Controller {

    function __construct() {

        parent::__construct();
        if (checkPermission('IngredientType', 'view') == false) {
            redirect('/Dashboard');
        }
        $this->viewname = $this->uri->segment(1);
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('form_validation', 'Session'));
    }

    /*
      @Author : Ritesh rana
      @Desc   : Ingredient type Index Page
      @Input 	:
      @Output	:
      @Date   : 10/03/2017
     */

    public function index() {
                
        $searchtext = $this->input->post('searchtext');
        $sortfield = $this->input->post('sortfield');
        $sortby = $this->input->post('sortby');
        $perpage = 10;
        $allflag = $this->input->post('allflag');
        if (!empty($allflag) && ($allflag == 'all' || $allflag == 'changesorting' || $allflag == 'changesearch')) {
            $this->session->unset_userdata('ingredienttype_data');
        }

        $searchsort_session = $this->session->userdata('ingredienttype_data');
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
                $sortfield = 'subcat_id';
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
        $table = SUBCATEGORY . ' as sc';
        $where = array("sc.is_deleted" => '0');
        $fields = array("sc.subcat_id, ct.cat_name , sc.created_by, sc.created_date, sc.status,sc.price,sc.subcat_name, sc.packaging");
        $join_tables = array(LOGIN . ' as l' => 'l.login_id=sc.created_by', CATEGORY . ' as ct' => 'ct.cat_id=sc.cat_id');
        if (!empty($searchtext)) {
            $searchtext = html_entity_decode(trim(addslashes($searchtext)));
            $match = '';
            $where_search = '((sc.subcat_name LIKE "%' . $searchtext . '%" OR sc.packaging LIKE "%' . $searchtext . '%" OR sc.price LIKE "%' . $searchtext . '%" OR ct.cat_name LIKE "%' . $searchtext . '%" OR sc.created_date LIKE "%' . $searchtext . '%" OR sc.status LIKE "%' . $searchtext . '%") AND sc.is_deleted = "0")';

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

        $this->session->set_userdata('ingredienttype_data', $sortsearchpage_data);
        setActiveSession('ingredienttype_data'); // set current Session active
        $data['header'] = array('menu_module' => 'masters', 'menu_child' => 'ingredienttype');
        $data['crnt_view'] = $this->viewname;
        $data['meta_title'] = 'Ingredient Type Listing';
        $data['footerJs'][0] = base_url('uploads/custom/js/ingredienttype/ingredienttype.js');
        if ($this->input->post('result_type') == 'ajax') {
            $this->load->view($this->viewname . '/ajaxlist', $data);
        } else {
            $data['main_content'] = '/ingredienttypelist';
            $this->parser->parse('layouts/DefaultTemplate', $data);
        }
    }

    /*
      @Author : Ritesh rana
      @Desc   : Ingredient Type insertdata
      @Input 	:
      @Output	:
      @Date   : 10/03/2017
     */

    public function insertdata() {
        if (!validateFormSecret()) {
            $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>" . lang('error') . "</div>");
            redirect($this->viewname . '/ingredienttypelist'); //Redirect On Listing page
        }
        $data['crnt_view'] = $this->viewname;
        //insert the ingredient category details into database
        $data = array(
            'cat_id' => trim($this->input->post('cat_id')),
            'subcat_name' => trim($this->input->post('subcat_name')),
            'price' => $this->input->post('price'),
            'packaging' => $this->input->post('packaging'),
            'created_by' => $this->session->userdata['LOGGED_IN']['ID'],
            'created_date' => datetimeformat(),
            'status' => $this->input->post('status')
        );
        //Insert Record in Database
        if ($this->common_model->insert(SUBCATEGORY, $data)) {
            $msg = $this->lang->line('Items_add_msg');
            $this->session->set_flashdata('msg', "<div class='alert alert-success text-center'>$msg</div>");
        } else {
            // error
            $msg = $this->lang->line('error_msg');
            $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");
        }
        redirect('IngredientType');
    }

    /*
      @Author : ritesh rana
      @Desc   : Ingredient Type list view Page
      @Input 	:
      @Output	:
      @Date   : 10/03/2017
     */

    public function additems() {
        $this->formValidation();
        if ($this->form_validation->run() == FALSE) {
            $data['footerJs'][0] = base_url('uploads/custom/js/ingredienttype/ingredienttype.js');
            $table = CATEGORY . ' as ct';
            $where = array("ct.status" => "'active'", "ct.is_deleted" => '0');
            $fields = array("ct.cat_id, ct.cat_name");
            $data['category_data'] = $this->common_model->get_records($table, $fields, '', '', '', '', '', '', '', '', '', $where);
            $data['crnt_view'] = $this->viewname;
            $data['validation'] = validation_errors();
            $data['form_action_path'] = $this->viewname . '/additems';
            $data['header'] = array('menu_module' => 'masters', 'menu_child' => 'ingredienttype');
            $data['main_content'] = '/addingredienttype';
            $data['meta_title'] = 'Add Ingredient Type';
            $this->parser->parse('layouts/DefaultTemplate', $data);
        } else {
            $this->insertdata();
        }
    }

    /*
      @Author : Ritesh Rana
      @Desc   : Ingredient Type Edit Page
      @Input 	:
      @Output	:
      @Date   : 10/03/2017
     */

    public function edit($id) {
        $this->formValidation();
        if ($this->form_validation->run() == FALSE) {
            $data['footerJs'][0] = base_url('uploads/custom/js/ingredienttype/ingredienttype.js');
            $this->session->unset_userdata('FORM_SECRET', '');
            $table = SUBCATEGORY . ' as sc';
            $match = "sc.subcat_id = " . $id;
            $fields = array("sc.cat_id, sc.subcat_name, sc.created_by, sc.created_date, sc.status,sc.price,sc.subcat_id, sc.packaging");
            $data['editRecord'] = $this->common_model->get_records($table, $fields, '', '', $match);

            $data['id'] = $id;
            $table = CATEGORY . ' as ct';
            $where = array("ct.status" => "'active'", "ct.is_deleted" => '0');
            $fields = array("ct.cat_id, ct.cat_name");
            $data['category_data'] = $this->common_model->get_records($table, $fields, '', '', '', '', '', '', '', '', '', $where);
            $data['validation'] = validation_errors();
            $data['crnt_view'] = $this->viewname;
            $data['form_action_path'] = $this->viewname . '/edit/' . $id;
            $data['header'] = array('menu_module' => 'masters', 'menu_child' => 'ingredienttype');
            $data['main_content'] = '/addingredienttype';
            $data['meta_title'] = 'Edit Ingredient Type';
            $this->parser->parse('layouts/DefaultTemplate', $data);
        } else {
            $this->updatedata();
        }
    }

    /*
      @Author : Ritesh rana
      @Desc   : Ingredient type Update Query
      @Input 	: Post record from Ingredient type
      @Output	: Update data in database and redirect
      @Date   : 10/03/2017
     */

    public function updatedata() {
        $status = $this->input->post('status');
        $id = $this->input->post('subcat_id');
        $data['id'] = $id;
        $data['crnt_view'] = $this->viewname;

        $data = array(
            'cat_id' => trim($this->input->post('cat_id')),
            'subcat_name' => trim($this->input->post('subcat_name')),
            'price' => $this->input->post('price'),
            'packaging' => $this->input->post('packaging'),
            'updated_by' => $this->session->userdata['LOGGED_IN']['ID'],
            'updated_date' => datetimeformat(),
            'status' => $status
        );

        //Update Record in Database
        $where = array('subcat_id' => $id);
        // Update form data into database
        if ($this->common_model->update(SUBCATEGORY, $data, $where)) {

            $msg = $this->lang->line('Items_update_msg');
            $this->session->set_flashdata('msg', "<div class='alert alert-success text-center'>$msg</div>");
        } else {    // error
            $msg = $this->lang->line('error_msg');
            $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");
        }
        redirect('IngredientType'); //Redirect On Listing page
    }

    /*
      @Author : Ritesh Rana
      @Desc   : ingredient Type List Delete Query
      @Input 	: Post id from List page
      @Output	: Delete data from database and redirect
      @Date   : 10/03/2017
     */

    public function deletedata($id) {

        //Delete Record From Database
        if (!empty($id)) {
            $data = array('is_deleted' => 1);
            $where = array('subcat_id' => $id);
            if ($this->common_model->update(SUBCATEGORY, $data, $where)) {
                $msg = $this->lang->line('ingredient_type_delete_msg');
                $this->session->set_flashdata('msg', "<div class='alert alert-success text-center'>$msg</div>");
                unset($id);
            } else {
                // error
                $msg = $this->lang->line('error_msg');
                $this->session->set_flashdata('msg', "<div class='alert alert-danger text-center'>$msg</div>");
            }
        }
        redirect('IngredientType');
    }

    /*
      @Author : Ritesh Rana
      @Desc   : Ingredient Type Edit Page
      @Input 	:
      @Output	:
      @Date   : 10/03/2017
     */

    public function view($id) {
        //Get Records From Login Table
        $data['footerJs'][0] = base_url('uploads/custom/js/ingredienttype/ingredienttype.js');
        $table = SUBCATEGORY . ' as sc';
        $match = "sc.subcat_id = " . $id;
        $fields = array("sc.cat_id, sc.subcat_name , sc.created_by, sc.created_date, sc.status,sc.price,sc.packaging");
        $data['editRecord'] = $this->common_model->get_records($table, $fields, '', '', $match);

        $countryName = "";
        $data['categoryName'] = "";
        if (isset($data['editRecord'][0]['cat_id'])) {
            $countryName = getCategoryName($data['editRecord'][0]['cat_id']);
            if (isset($countryName[0]['cat_name'])) {
                $data['categoryName'] = $countryName[0]['cat_name'];
            }

            if ($data['categoryName'] != NULL) {
                $data['categoryName'] = $data['categoryName'];
            }
        }
        
        $data['form_action_path'] = $this->viewname . '/view/'.$id;
        
        $data['readonly'] = array("disabled" => "disabled");
        $data['id'] = $id;
        $data['crnt_view'] = $this->viewname;
        $data['main_content'] = '/addingredienttype';
        $this->parser->parse('layouts/DefaultTemplate', $data);
    }

    /*
      @Author : Ritesh Rana
      @Desc   : Form validation
      @Input 	:
      @Output	:
      @Date   : 10/03/2017
     */

    public function formValidation($id = null) {
        $this->form_validation->set_rules('cat_id', 'category Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('subcat_name', 'Subcategory Name', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        $this->form_validation->set_rules('price', 'Price', 'trim|required|numeric|min_length[2]|max_length[11]|xss_clean');
        $this->form_validation->set_rules('packaging', 'Packaging', 'trim|required|min_length[2]|max_length[50]|xss_clean');
    }

}
