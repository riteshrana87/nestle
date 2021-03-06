<?php
if (isset($editRecord) && $editRecord == "updatedata") {
    $record = "updatedata";
} else {
    $record = "insertdata";
}
?>
<script>
    var formAction = "<?php echo $record; ?>";
    var check_email_url = "<?php echo base_url('User/isDuplicateEmail'); ?>";
</script>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$formAction = !empty($editRecord) ? 'edit' : 'registration';
$path = $form_action_path;
if (isset($readonly)) {
    $disable = $readonly['disabled'];
} else {
    $disable = "";
}
$main_user_data = $this->session->userdata('LOGGED_IN');
$main_user_id = $main_user_data['ID'];
?>
<?php echo $this->session->flashdata('verify_msg'); ?>
<div class="content-wrapper">
    <div class="container">
        <div clas="row">
            <div class="col-md-12 error-list">
                <?= isset($validation) ? $validation : ''; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-head-line">
                    <?PHP if ($formAction == "registration") { ?>
                        <?= $this->lang->line('add_create_user') ?>
                    <?php } elseif ($formAction == "edit" && !isset($readonly)) { ?>
                        <?= $this->lang->line('edit_user') ?>
                    <?php } elseif (isset($readonly)) { ?>
                        <?= $this->lang->line('view_profile') ?>
                    <?php } elseif ($formAction == "registration") { ?>
                        <?= $this->lang->line('UPLOAD_NOTE_IMPORTANT') ?>
                    <?php } ?>
                </h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        User Information
                    </div>
                    <div class="panel-body">
                        <?php
                        $attributes = array("name" => "registration", "id" => "registration", "data-parsley-validate" => "", "class" => "form-horizontal");

                        echo form_open_multipart($path, $attributes);
                        ?>

                        <div class="hide">
                            <input name="login_id" type="hidden" value="<?= !empty($editRecord[0]['login_id']) ? $editRecord[0]['login_id'] : '' ?>"  />
                            <input name="role_selected_id" id="role_selected_id" type="hidden" value="<?= !empty($editRecord[0]['role_id']) ? $editRecord[0]['role_id'] : '' ?>"  />
                            <input name="selected_status" id="selected_status" type="hidden" value="<?= isset($editRecord[0]['status']) ? $editRecord[0]['status'] : '' ?>"  />
                        </div>
                      <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name" class="control-label col-sm-3 required"><?= $this->lang->line('firstname'); ?><?php if ($disable == "") { ?><?php } ?></label>

                                <div class="col-sm-9"> 
                                    <?php if ($disable == "") { ?>
                                        <input class="form-control" name="fname" placeholder="Enter First Name" type="text" value="<?php echo set_value('fname', (!empty($editRecord[0]['firstname'])) ? $editRecord[0]['firstname'] : '') ?>" required="" <?php echo $disable; ?> />
                                    <?php } else { ?>
                                        <p><?php echo $editRecord[0]['firstname']; ?></p>
                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="lname" class="control-label col-sm-3 required"><?= $this->lang->line('lastname') ?><?php if ($disable == "") { ?><?php } ?></label>
                                <div class="col-sm-9">
                                    <?php if ($disable == "") { ?>
                                        <input class="form-control" name="lname" placeholder="Enter Last Name" type="text" value="<?PHP
                                        if ($formAction == "registration") {
                                            echo set_value('lname');
                                            ?><?php } else { ?><?= !empty($editRecord[0]['lastname']) ? $editRecord[0]['lastname'] : '' ?><?php } ?>" data-parsley-pattern="/^([^0-9]*)$/" required="" <?php echo $disable; ?> />
                                           <?php } else { ?>
                                        <p><?php echo $editRecord[0]['lastname']; ?></p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="email" class="control-label col-sm-3 required">
                                    <?= $this->lang->line('emails') ?>
                                    <?php if ($disable == "") { ?><?php } ?></label>
                                <div class="col-sm-9">
                                    <?php if ($disable == "") { ?>
                                        <?php
                                        if (isset($editRecord[0]['email']) && $editRecord[0]['email'] != "") {
                                            echo $editRecord[0]['email'];
                                        } else {
                                            ?>
                                            <input class="form-control" id="email" name="email" autocomplete="false" placeholder="Enter Email Id" data-parsley-trigger="change" required="" type="email" value="<?PHP
                                            if ($formAction == "registration") {
                                                echo set_value('email');
                                                ?><?php } else { ?><?= !empty($editRecord[0]['email']) ? $editRecord[0]['email'] : '' ?><?php } ?>" <?PHP
                                                   if ($formAction == "registration") {
                                                       echo set_value('email');
                                                       ?><?php } else { ?><?= !empty($editRecord[0]['email']) ? 'disabled="disabled"' : '' ?><?php } ?>  <?php echo $disable; ?> data-parsley-email />
                                               <?php } ?>
                                           <?php } else { ?>
                                        <p><?php echo $editRecord[0]['email']; ?></p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="mobile_number" class="control-label col-sm-3 required">
                                    Mobile Number
                                    <?php if ($disable == "") { ?><?php } ?></label>
                                <div class="col-sm-9">
                                    <?php if ($disable == "") { ?>
                                        <input class="form-control" name="mobile_number" id="mobile_number" placeholder="Enter Mobile Number" type="text" value="<?PHP
                                        if ($formAction == "registration") {
                                            echo set_value('mobile_number');
                                            ?><?php } else { ?><?= !empty($editRecord[0]['mobile_number']) ? $editRecord[0]['mobile_number'] : '' ?><?php } ?>" data-parsley-pattern="^[\d\+\-\.\(\)\/\s]*$" maxlength="25" required="" <?php echo $disable; ?> />
                                           <?php } else { ?>
                                        <p><?php echo $editRecord[0]['mobile_number']; ?></p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <?php if (empty($editRecord)) { ?>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="password" class="control-label col-sm-3 required">
                                        <?= $this->lang->line('password') ?>
                                        <?php if ($disable == "") { ?><?php } ?></label>
                                    <div class="col-sm-9">
                                        <input class="form-control" id="password" name="password" placeholder="<?= $this->lang->line('password') ?>" type="password" data-parsley-minlength="6" <?php if ($formAction == "registration") { ?> data-parsley-required="true"  <?php } ?> <?php echo $disable; ?> />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="cpassword" class="control-label col-sm-3 required">
                                        <?= $this->lang->line('cpassword') ?>
                                        <?php if ($disable == "") { ?><?php } ?></label>
                                    <div class="col-sm-9">
                                        <input class="form-control" id="cpassword" name="cpassword" placeholder="<?= $this->lang->line('cpassword') ?>" type="password" data-parsley-equalto="#password" data-parsley-minlength="6" <?php if ($formAction == "registration") { ?> data-parsley-required="true" <?php } ?> <?php echo $disable; ?> />
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        <?php } ?>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="address" class="control-label col-sm-3">
                                    Address
                                </label>
                                <div class="col-sm-9">
                                    <?php if ($disable == "") { ?>
                                        <textarea class="form-control" rows="4" name="address" placeholder="Enter Address" type="text"><?php
                                            if ($formAction == "registration") {
                                                echo set_value('address');
                                                ?><?php } else { ?><?= !empty($editRecord[0]['address']) ? $editRecord[0]['address'] : '' ?><?php } ?></textarea>
                                    <?php } else { ?>
                                        <p><?php echo $editRecord[0]['address']; ?></p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-3 required m-b-15" for="usertype"><?= $this->lang->line('usertype') ?><?php if ($disable == "") { ?><?php } ?></label>
                                <div class="col-sm-9 m-b-15">
                                    <?php if ($disable == "" && ($formAction == "registration")) { ?>
                                    <select class="chosen-select form-control" data-parsley-errors-container="#usertype_error" placeholder="<?= $this->lang->line('usertype') ?>"  name="usertype" id="usertype" required="" <?php echo $disable; ?> >
                                            <?php /* ?><option value="">
                                              <?= $this->lang->line('usertype_select') ?>
                                              </option><?php */ ?>
                                            <?php
                                            $salutions_id = "";
                                            if (!empty($editRecord[0]['role_id'])) {
                                                $salutions_id = $editRecord[0]['role_id'];
                                            }
                                            ?>
                                            <?php
                                            foreach ($userType as $row) {
                                                if ($salutions_id == $row['role_id']) {
                                                    ?>
                                                    <option selected value="<?php echo $row['role_id']; ?>"><?php echo $row['role_name']; ?></option>
                                                <?php } else { ?>
                                                    <option value="<?php echo $row['role_id']; ?>"><?php echo $row['role_name']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    <?php } elseif ($disable == "" && ($this->session->userdata['LOGGED_IN']['ID'] == $editRecord[0]['login_id'])) { ?>
                                        <p><?php echo $roleName; // pr($userType)       ?></p>
                                    <?php } elseif ($disable == "" && ($this->session->userdata['LOGGED_IN']['ID'] != $editRecord[0]['login_id'])) { ?>
                                        <select class="chosen-select form-control" data-parsley-errors-container="#usertype_error"  placeholder="<?= $this->lang->line('usertype') ?>"  name="usertype" id="usertype" required="true" <?php echo $disable; ?> >
                                            <?php /* ?><option value="">
                                              <?= $this->lang->line('usertype_select') ?>
                                              </option><?php */ ?>
                                            <?php $salutions_id = $editRecord[0]['role_id']; ?>

                                            <?php
                                            foreach ($userType as $row) {
                                                if ($salutions_id == $row['role_id']) {
                                                    ?>
                                                    <option selected value="<?php echo $row['role_id']; ?>"><?php echo $row['role_name']; ?></option>
                                                <?php } else { ?>
                                                    <option value="<?php echo $row['role_id']; ?>"><?php echo $row['role_name']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    <?php } else { ?>
                                        <p><?php echo $roleName; ?></p>
                                    <?php } ?>
                                    <span id="usertype_error"></span>
                                </div>
                                <label for="position" class="control-label col-sm-3 required">
                                    Position
                                    <?php if ($disable == "") { ?><?php } ?></label>
                                <div class="col-sm-9">
                                    <?php if ($disable == "") { ?>
                                        <input class="form-control" name="position" id="position" placeholder="Enter Position" type="text" value="<?php
                                        if ($formAction == "registration") {
                                            echo set_value('Position');
                                            ?><?php } else { ?><?= !empty($editRecord[0]['position']) ? $editRecord[0]['position'] : '' ?><?php } ?>" maxlength="25" required="" <?php echo $disable; ?> />
                                           <?php } else { ?>
                                        <p><?php echo $editRecord[0]['position']; ?></p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-3 required" for="status">
                                    <?= $this->lang->line('user_status') ?>
                                </label>
                                <div class="col-sm-9">
                                    <?php if ((isset($editRecord[0]['login_id']) && $this->session->userdata['LOGGED_IN']['ID'] != $editRecord[0]['login_id']) && $disable == "") { ?>

                                        <select class="form-control " data-parsley-errors-container="#STATUS_error" placeholder="<?php echo lang('user_status'); ?>"  name="status" id="status" required="true" <?php echo $disable; ?> >
                                            <!-- <option value="">
                                            <?= $this->lang->line('user_status') ?>
                  </option> -->
                                            <?php
                                            $options = array(array('s_status' => lang('active')), array('s_status' => lang('inactive')));
                                            if (isset($editRecord[0]['status']) && $editRecord[0]['status'] != "") {
                                                $selected = $editRecord[0]['status'];
                                            } else {
                                                $selected = lang('active');
                                            }
                                            ?>
                                            <?php
                                            foreach ($options as $rows) {
                                                if ($selected == $rows['s_status']) {
                                                    ?>
                                                    <option selected value="<?php echo $rows['s_status']; ?>"><?php echo $rows['s_status']; ?></option>
                                                <?php } else { ?>

                                                    <option value="<?php echo $rows['s_status']; ?>"><?php echo $rows['s_status']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                        <span id="STATUS_error"></span>
                                    <?php } elseif ((isset($editRecord[0]['login_id']) && $this->session->userdata['LOGGED_IN']['ID'] == $editRecord[0]['login_id']) && $disable == "") { ?>
                                        <?php if ($editRecord[0]['status'] == 'active') { ?>
                                            <p><?= lang('active') ?></p>
                                        <?php } else { ?>
                                            <p><?= lang('inactive') ?></p>
                                        <?php } ?>
                                    <?php } elseif ($disable == "" && $formAction == "registration") { ?>
                                        <select class="form-control " data-parsley-errors-container="#STATUS_error" placeholder="<?php echo lang('user_status'); ?>"  name="status" id="status" required="true" <?php echo $disable; ?> >
                                            <!-- <option value="">
                                            <?= $this->lang->line('user_status') ?>
                  </option> -->
                                            <?php
                                            $options = array(array('s_status' => lang('active')), array('s_status' => lang('inactive')));
                                            //$options = array('1'=>lang('active'),'0'=>lang('inactive'));
                                            if (isset($editRecord[0]['status']) && $editRecord[0]['status'] != "") {
                                                $selected = $editRecord[0]['status'];
                                            } else {
                                                $selected = lang('active');
                                            }
                                            ?>
                                            <?php
                                            foreach ($options as $rows) {
                                                if ($selected == $rows['s_status']) {
                                                    ?>
                                                    <option selected value="<?php echo $rows['s_status']; ?>"><?php echo $rows['s_status']; ?></option>
                                                <?php } else { ?>

                                                    <option value="<?php echo $rows['s_status']; ?>"><?php echo $rows['s_status']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    <?php } elseif ($disable != "") { ?>

                                        <?php if (isset($editRecord[0]['status']) && $editRecord[0]['status'] == 1) { ?>
                                            <p><?= lang('active') ?></p>
                                        <?php } else { ?>
                                            <p><?= lang('inactive') ?></p>
                                        <?php } ?>

                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="mobile_number" class="control-label col-sm-3 required">
                                    Member Of
                                </label>
                                <div class="col-sm-9">
                                    <select class="form-control" data-parsley-errors-container="#usertype_error" placeholder="<?= $this->lang->line('memberof') ?>"  name="memberof" id="memberof" required="" <?php echo $disable; ?> >
                                        <option value="Nestle" <?php if (isset($editRecord[0]['memberof']) && $editRecord[0]['memberof'] == "Nestle") { ?> selected <?php } ?> >Nestle</option>
                                        <option value="Backoffice" <?php if (isset($editRecord[0]['memberof']) && $editRecord[0]['memberof'] == "Backoffice") { ?> selected <?php } ?> >Backoffice</option>
                                        <option value="IBT Call Center" <?php if (isset($editRecord[0]['memberof']) && $editRecord[0]['memberof'] == "IBT Call Center") { ?> selected <?php } ?>>IBT Call Center</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="">
                            <div class="clearfix"></div>
                            <div class="col-sm-12 text-center">
                                <div class="bottom-buttons">
                                    <?php if (!isset($readonly)) { ?>
                                        <input name="login_id" id="login_id" type="hidden" value="<?= !empty($editRecord[0]['login_id']) ? $editRecord[0]['login_id'] : '' ?>" />
                                        <input type="hidden" id="form_secret" name="form_secret"  value="<?php echo createFormToken(); ?>">
                                        <?php if ($formAction == "registration") { ?>
                                            <input type="submit" class="btn btn-primary" name="submit_btn" id="submit_btn" value="<?= $this->lang->line('create_user') ?>" />
                                        <?php } else { ?>
                                            <input type="submit" class="btn btn-primary" name="submit_btn" id="submit_btn" value="<?= $this->lang->line('edit_user') ?>" />
                                        <?php } ?>

                                        <a href="<?php echo base_url('User') ?>" class="btn btn-default">Cancel</a>
                                    <?php } ?>


                                </div>
                            </div>

                            <?php echo form_close(); ?> </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>