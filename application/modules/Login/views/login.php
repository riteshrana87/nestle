<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content-wrapper login-w">
  <div class="login-wrapper">
  <div class="container-fluid">
      <div class="login-custm-width">
        <div class="blue-logoin-box">
          <div class="login-maintitle text-center">Login</div>
          <div class="row">
            <div class="col-xs-10 col-xs-offset-1 col-md-10 col-md-offset-1">
              <?php echo $this->session->flashdata('msgs'); ?>
              <?php if(isset($error) && !empty($error))
					{ ?>
              <?php echo $error; ?>
              <?php 	} ?>
              <?php 
		$attributes = array("name" => "frmlogin", "id" => "frmlogin", "data-parsley-validate" => "");
	  echo form_open('Login/verifylogin', $attributes); ?>
              <div class="form-group">
                <input class="form-control form-control-login" name="email" placeholder=""<?php echo lang('COMMON_LABEL_EMAIL')?>" type="email" required />
              </div>
              <div class="form-group">
                <input class="form-control form-control-login" name="password" data-parsley-minlength="5" placeholder=""<?php echo lang('COMMON_LABEL_PASSWORD')?>" type="password" required />
              </div>
            </div>
            <div class="clr"></div>
          </div>
          <div class="row login-links">
            <div class="col-xs-11 col-xs-offset-1 col-md-11 col-md-offset-1 pad-tb6">
              <label class="checkbox-inline">
                <?php /*?>
                <input type="checkbox" class="checkbox" name="" id=""/>
                <a href="#" class="white-link">
                  <?php echo lang('LOGIN_REMEMBER_ME')?>
                </a>
                <?php */?>
                <input type="checkbox" class="checkbox" name="" id=""/>
                <?php echo lang('LOGIN_REMEMBER_ME')?>
              </label>
              <input type="hidden" id="remove_session" name="session" value=""<?php echo $session_id;?>">
            </div>
            <!--         <div class="col-xs-5 col-md-5 text-right  pad-tb6"> <a class="white-link" href="-->
            <?php //echo base_url('Login/forgotpassword');?>
            <!--" class="white-link">-->
            <?php //echo lang('COMMON_FORGET_PASS_MENU')?>
            <!--</a> </div>-->
            <div class="clr"></div>
          </div>
          <div class="row">
            <div class="col-xs-10 col-xs-offset-1 col-md-10 col-md-offset-1 text-center">
              <input type="hidden" name="timezone" id="timezone">
                <button name="lgnsubmit" type="submit" id="lgnsubmit"  class="btn btn-primary">
                  <?php echo lang('COMMON_LABEL_LOGIN')?>
                </button>
              </div>
            <div class="clr"></div>
          </div>
          <div class="clr"></div>
          <?php echo form_close(); ?>

          <div class="clr"></div>
        </div>
        <div class="clr"></div>
      </div>
  </div>
  </div>
</div>