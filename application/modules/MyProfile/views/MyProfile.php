<div class="content-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-head-line">
                    <?= lang('MY_PROFILE') ?>
                </h1>
            </div>
        </div>
        <div class="clearfix"></div>
        <?php echo $this->session->flashdata('msg'); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?= lang('MY_PROFILE') ?>
                    </div>
                    <div class="panel-body">
                        <form action="<?php echo base_url(); ?>MyProfile/updateProfile" name="update_myprofile" id="update_myprofile" class="form-horizontal" data-parsley-validate="" enctype="multipart/form-data" method="post" accept-charset="utf-8" novalidate>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3 required"><?php echo lang('firstname'); ?></label>
                                    <div class="col-sm-9">
                                        <input class="form-control" name="fname" placeholder="<?php echo lang('firstname'); ?>" type="text" maxlength="20" value="<?php
                                        if ($profile_data['firstname'] != '') {
                                            echo htmlentities($profile_data['firstname']);
                                        }
                                        ?>" data-parsley-pattern="/^([^0-9]*)$/" required="" data-parsley-id="4">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3 required"><?php echo lang('lastname'); ?></label>
                                    <div class="col-sm-9">
                                        <input class="form-control" name="lname" placeholder="<?php echo lang('lastname'); ?>" type="text" maxlength="20" value="<?php
                                        if ($profile_data['lastname'] != '') {
                                            echo htmlentities($profile_data['lastname']);
                                        }
                                        ?>" data-parsley-pattern="/^([^0-9]*)$/" required="" data-parsley-id="6">
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3 required"><?php echo lang('emails'); ?></label>
                                    <div class="col-sm-9">
                                        <input class="form-control" name="email" placeholder="Email" data-parsley-trigger="change" required="" type="email" disabled="true" value="<?php
                                        if ($profile_data['email'] != '') {
                                            echo $profile_data['email'];
                                        }
                                        ?>" data-parsley-id="8">
                                    </div>
                                </div>
                            </div>

                            <?php /* <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3 required"><?php echo lang('addresss'); ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="address" placeholder="<?php echo lang('ADDRESS_1'); ?>" required value="<?php
                                        if ($profile_data['address'] != '') {
                                            echo htmlentities($profile_data['address']);
                                        }
                                        ?>" data-parsley-id="14"/>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-sm-6">
                              <div class="form-group">
                              <label class="control-label col-sm-3 required"><?php echo lang('MY_PROFILE_CITY'); ?></label>
                              <div class="col-sm-9">
                              <input type="text" class="form-control" name="profile_city" id="profile_city" placeholder="<?php echo lang('MY_PROFILE_CITY'); ?>"
                              value="<?= (isset($profile_data['city'])) ? htmlentities($profile_data['city']) : '' ?>" data-parsley-id="14" required/>
                              </div>
                              </div>
                              </div>

                              <div class="col-sm-6">
                              <div class="form-group">
                              <label class="control-label col-sm-3"><?php echo lang('MY_PROFILE_STATE'); ?></label>
                              <div class="col-sm-9">
                              <input type="text" class="form-control" name="profile_state" id="profile_state" placeholder="<?php echo lang('MY_PROFILE_STATE'); ?>" value="<?= (isset($profile_data['state'])) ? htmlentities($profile_data['state']) : '' ?>"data-parsley-id="14"/>                                    </div>
                              </div>
                              </div>
                              <div class="clearfix"></div> */
                            ?>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3">Address</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" rows="4" name="address" placeholder="Enter Address" type="text"><?= (isset($profile_data['address'])) ? $profile_data['address'] : '' ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <?php /*<div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3"><?php echo lang('MY_PROFILE_COUNTRY'); ?></label>
                                    <div class="col-sm-9">
                                        <select class="chosen-select form-control" placeholder="country"  name="country_id" id="country_id" required>
                                            <option value=""><?= $this->lang->line('select_country') ?></option>
                                            <?php $country_id = $profile_data['country']; ?>
                                            <?php
                                            foreach ($country_data as $row) {
                                                if ($country_id == $row['country_id']) {
                                                    ?>
                                                    <option selected value="<?php echo $row['country_id']; ?>"><?php echo $row['country_name']; ?></option>
                                                <?php } else { ?>
                                                    <option value="<?php echo $row['country_id']; ?>"><?php echo $row['country_name']; ?></option>

                                                <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div> */ ?>
                            
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3 required">Mobile Number</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" name="mobile_number" placeholder="Mobile Number" type="text" value="<?php
                                        if ($profile_data['mobile_number'] != '') {
                                            echo $profile_data['mobile_number'];
                                        }
                                        ?>" data-parsley-pattern="^[\d\+\-\.\(\)\/\s]*$" maxlength="25" required="true" data-parsley-id="16">
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                                
                                <div class="col-sm-12 text-center">
                                    <div class="bottom-buttons">
                                        <input type="submit" class="btn btn-primary" name="submit_btn" id="submit_btn" value="<?php echo lang('EST_EDIT_SAVE'); ?>" />
                                        <!-- <input type="reset"  class="btn btn-info" name="reset" id="reset_btn" value="Reset" />-->
                                        <a href="<?php echo base_url('Dashboard') ?>" class="btn btn-default">Cancel</a>
                                    </div>
                               </div>                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>