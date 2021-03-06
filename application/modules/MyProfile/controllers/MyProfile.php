<?php
/*
@Author : sanket Jayani
@Desc   : Campaign Group Create/Update
@Date   : 21/01/2016
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class MyProfile extends CI_Controller 
{
    function __construct()
    {
        parent::__construct();
        $this->module = $this->uri->segment(1);
        $this->viewname = $this->uri->segment(1);
        $this->load->library(array('form_validation','Session'));
        $this->load->model('MyProfile_model');
    }

    public function index()
    {
        $data['footerJs'][0] = base_url('uploads/custom/js/MyProfile/MyProfile.js');
        $data['main_content'] = '/'.$this->viewname;
        $user_id =  $this->session->userdata('LOGGED_IN')['ID'];
        $data['profile_data'] = $this->MyProfile_model->getUserData($user_id);
        
        /*$table = COUNTRIES.' as cm';
        $fields = array("cm.country_name,cm.country_id");
        
        $data['country_data']      = $this->common_model->get_records($table,$fields,'','','','','','','','','',''); */
        $this->parser->parse('layouts/DefaultTemplate', $data);
    }
    /*
	 @Author : Ritesh Rana
	 @Desc   : update profile
	 @Input 	:
	 @Output	:
	 @Date   : 22/03/2017
	 */

    public function updateProfile()
    {
        $data['firstname'] = $this->input->post('fname');
        $data['lastname'] = $this->input->post('lname');
        $data['address'] = $this->input->post('address');
        //$data['city'] = $this->input->post('profile_city');
        //$data['state'] = $this->input->post('profile_state');
        //$data['zipcode'] = $this->input->post('zipcode');
        //$data['country'] = $this->input->post('country_id');
        $data['mobile_number'] = $this->input->post('mobile_number');
        $data['modified_date'] = datetimeformat();
        
        $user_id =  $this->session->userdata('LOGGED_IN')['ID'];
        $where = $this->db->where('login_id', $user_id);
        $updateProfile = $this->common_model->update(LOGIN, $data,$where); 
       if($updateProfile)
        {
            $_SESSION['LOGGED_IN']['FIRSTNAME'] = $data['firstname'];
            $_SESSION['LOGGED_IN']['LASTNAME'] = $data['lastname'];
           
            $msg = $this->lang->line('USERPROFILE_UPDATED');
            $this->session->set_flashdata('msg',"<div class='alert alert-success text-center'>$msg</div>");
        }else
        {
            $msg = $this->lang->line('FAIL_USERPROFILE_UPDATED');
            $this->session->set_flashdata('msg',"<div class='alert alert-danger text-center'>$msg</div>");
        }
        redirect($this->viewname);
    }

    /*
	 @Author : Ritesh Rana
	 @Desc   : change password
	 @Input 	:
	 @Output	:
	 @Date   : 22/03/2017
	 */
    function ChangePassword()
    {
        $data['footerJs'][0] = base_url('uploads/custom/js/MyProfile/MyProfile.js');
        $data['main_content'] = '/ChangePassword';
        $user_id =  $this->session->userdata('LOGGED_IN')['ID'];
        $data['profile_data'] = $this->MyProfile_model->getUserData($user_id);
        $data['header'] = array('menu_module' => 'MyProfile' , 'menu_child' => 'changepassword');
        $this->parser->parse('layouts/DefaultTemplate', $data);
    }
    /*
	 @Author : Ritesh Rana
	 @Desc   : Update password
	 @Input 	:
	 @Output	:
	 @Date   : 10/03/2017
	 */
    function updatePassword()
    {
        $user_id =  $this->session->userdata('LOGGED_IN')['ID'];
        $data['password'] = md5($this->input->post('password'));
        $data['modified_date'] = datetimeformat();
        
        $where = $this->db->where('login_id', $user_id);
        $updatePassword = $this->db->update(LOGIN, $data, $where); 
        
        if($updatePassword)
        {
            $msg = $this->lang->line('MSG_UPDATE_PASSWORD');
            $this->session->set_flashdata('msg',"<div class='alert alert-success text-center'>$msg</div>");
            
        }else
        {
            $msg = $this->lang->line('FAIL_USERPROFILE_UPDATED');
            $this->session->set_flashdata('msg',"<div class='alert alert-danger text-center'>$msg</div>");
        }
        redirect('MyProfile/ChangePassword');
    }
    
}
