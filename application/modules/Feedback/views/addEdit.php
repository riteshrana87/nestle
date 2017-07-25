<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script>
    var getCustomerLocationsURL = "<?php echo base_url('Feedback/getPopUpData'); ?>";
</script>
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
                    <?php echo ($screenType == 'edit') ? 'Edit Feedback' : 'Feedback'; ?>
                </h1>
            </div>
        </div>
        <?php
        $attributes = array("name" => "feedback_add_edit", "id" => "feedback_add_edit", "data-parsley-validate" => "", "class" => "form-horizontal", 'novalidate' => '');
        echo form_open_multipart($form_action_path, $attributes);
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Feedback
                        </div>
                        <div class="panel-collapse">
                            <div class="panel-body">
                              <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 required">Date</label>
                                        <div class="col-sm-9">
                                            <div class="input-group" id='feedback_date'>
                                                <input type="text" class="form-control" placeholder="MM/DD/YYYY" name='feedback_date' value="<?php echo set_value('feedback_date', (isset($editFeedBackDate) ? $editFeedBackDate : '')) ?>" required='true' data-parsley-required-message="Please Select Date" >
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 required">Auditor</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="feedback_auditor" name="feedback_auditor" placeholder="Enter Auditor" value="<?php echo set_value('feedback_auditor', (isset($editAuditor) ? $editAuditor : '')) ?>" required="true" data-parsley-required-message="Please Enter Auditor" data-parsley-maxlength="100" data-parsley-maxlength-message ='Max. 100 Characters are allowed.' data-parsley-trigger="keyup"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 required">Ticket Date</label>
                                        <div class="col-sm-9">
                                            <div class="input-group" id='ticket_date'>
                                                <input type="text" class="form-control" placeholder="MM/DD/YYYY" name='ticket_date' value="<?php echo set_value('ticket_date', (isset($editTicketDate) ? $editTicketDate : '')) ?>" required='true' data-parsley-required-message="Please Select Ticket Date" >
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 required">Subject</label>
                                        <div class="col-sm-9">
                                            <input type="text" id='subject' name='subject' class="form-control" placeholder="Enter Subject" value="<?php echo set_value('subject', (isset($editSubject) ? $editSubject : '')) ?>" required='true' data-parsley-required-message="Please Enter Subject" data-parsley-maxlength="100" data-parsley-maxlength-message ='Max. 100 Characters are allowed.' data-parsley-trigger="keyup"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 required">Ticket No</label>
                                        <div class="col-sm-9">
                                            <input type="text" id='ticket_number' name='ticket_number' class="form-control" placeholder="Enter Ticket Number" value="<?php echo set_value('ticket_number', (isset($editTicketNumber) ? $editTicketNumber : '')) ?>" required='true' data-parsley-required-message="Please Enter Ticket Number" data-parsley-maxlength="50" data-parsley-maxlength-message ='Max. 50 Characters are allowed.'/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 required" for="name"><?= $this->lang->line('co_customer_name'); ?></label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <select class="form-control chosen-select" id='customer_name' name='customer_name' required='true' data-parsley-required-message="Please Select Customer Name" data-parsley-errors-container="#customer_name_error">
                                                    <option class='cust_name_class' value=''>Select Customer Name</option>
                                                    <?php
                                                    foreach ($customerNameList as $customerNameData) {
                                                        echo "<option class='cust_name_class' value='" . $customerNameData['customer_name'] . "' " . set_select('customer_name', (isset($editCustomerName) ? $editCustomerName : ''), $customerNameData['customer_name'] == (isset($editCustomerName) ? $editCustomerName : '')) . ">" . $customerNameData['customer_name'] . "</option>";
                                                        //echo "<option class='cust_name_class' value='" . $customerNameData['customer_id'] . "' >" . $customerNameData['customer_name'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                                <div class="input-group-btn">
                                                    <button class="btn btn-default" type="button">
                                                        <i class="fa fa-user" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <span id="customer_name_error"></span>
                                        </div>
                                    </div>
                                </div>
                                <input type='hidden' id='customer_id' name='customer_id' value='<?php echo set_value('customer_id', (isset($editCustomerId) ? $editCustomerId : '')) ?>' />
                                <?php /* <div class="col-sm-6">
                                  <div class="form-group">
                                  <label class="control-label col-sm-3 required">Customer Name</label>
                                  <div class="col-sm-9">
                                  <input type="text" id='customer_name' name='customer_name' class="form-control" placeholder="Enter Customer Name" value="<?php echo set_value('customer_name') ?>" required='true' data-parsley-required-message="Please Enter Customer Name"/>
                                  </div>
                                  </div>
                                  </div> */ ?>

                                <div class="clearfix"></div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 required">Phone Number</label>
                                        <div class="col-sm-9">
                                            <input type="text" id='phone_number' name='phone_number' class="form-control" placeholder="Enter Phone Number" value="<?php echo set_value('phone_number', (isset($editPhoneNumber) ? $editPhoneNumber : '')) ?>" required='true' data-parsley-required-message="Please Enter Phone Number"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 required">Overall Level of Satisfaction</label>
                                        <div class="col-sm-9">
                                            <input type="text" id='satisfaction_level' name='satisfaction_level' class="form-control" placeholder="Enter Overall Level of Satisfaction" value="<?php echo set_value('satisfaction_level', (isset($editSatisfactionLevel) ? $editSatisfactionLevel : '')) ?>" required='true' data-parsley-required-message="Please Enter Overall Level of Satisfaction" data-parsley-maxlength="150" data-parsley-maxlength-message ='Max. 150 Characters are allowed.' data-parsley-trigger="keyup"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 required">Attitude of the Employee</label>
                                        <div class="col-sm-9">
                                            <input type="text" id='attitude_of_emp' name='attitude_of_emp' class="form-control" placeholder="Enter Attitude of the Employee" value="<?php echo set_value('attitude_of_emp', (isset($editAttitudeOfEmp) ? $editAttitudeOfEmp : '')) ?>" required='true' data-parsley-required-message="Please Enter Attitude of the Employee"  data-parsley-maxlength="100" data-parsley-maxlength-message ='Max. 100 Characters are allowed.'/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 required">Specific AFI's</label>
                                        <div class="col-sm-9">
                                            <input type="text" id='specific_afi' name='specific_afi' class="form-control" placeholder="Enter Specific AFI's" value="<?php echo set_value('specific_afi', (isset($editSpecificaAfi) ? $editSpecificaAfi : '')) ?>" required='true' data-parsley-required-message="Please Enter Specific AFI's" data-parsley-maxlength="100" data-parsley-maxlength-message ='Max. 100 characters are allowed.' data-parsley-trigger="keyup"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div>
                    </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 text-center">
                    <div class="bottom-buttons">
                        <input class='btn btn-primary' type='submit' name='add_save' id='add_save' value='<?php echo ($screenType == 'edit') ? 'Update' : 'Submit' ?>' />
                        <a href="<?php echo base_url($crnt_view) ?>" class="btn btn-default">Cancel</a>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Available Locations</h4>
                        </div>
                        <div class="modal-body" id='modal-body'>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-ok" data-dismiss="modal">Ok</button>
                            <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>