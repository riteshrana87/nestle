<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script>
    var getCustomerDetailsURL = "<?php echo base_url('Maintenance/getCustomerDetails'); ?>";
    var getCustomerLocationsURL = "<?php echo base_url('Maintenance/getPopUpData'); ?>";
    var customerCodeId = "<?php echo (isset($editCustmerId)) ? $editCustmerId : '' ?>";
</script>

<?= isset($validation) ? $validation : ''; ?>
<div class="content-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-head-line">Maintenance - Sales Person</h1>
            </div>
        </div>
        <?php
        $attributes = array("name" => "maintenance_add_edit", "id" => "maintenance_add_edit", "data-parsley-validate" => "", "class" => "form-horizontal", 'novalidate' => '');
        echo form_open_multipart($form_action_path, $attributes);
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php echo ($screenType == 'edit') ? 'Edit' : 'Add' ?> Maintenance - Sales Person
                    </div>
                    <div class="panel-body">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Customer Information
                            </div>
                            <div class="panel-body">
                              <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 required" for="name"><?= $this->lang->line('co_customer_name'); ?></label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <select class="form-control chosen-select" id='cust_name' name='cust_name' required='true' data-parsley-required-message="Please Select Customer Name" data-parsley-errors-container="#customer_name_error">
                                                    <option class='cust_name_class' value=''>Select Customer Name</option>
                                                    <?php
                                                    foreach ($customerNameList as $customerNameData) {
                                                        echo "<option class='cust_name_class' value='" . $customerNameData['customer_name'] . "' " . set_select('cust_name', (isset($editCustmerId) ? $editCustmerId : ''), $customerNameData['customer_id'] == (isset($editCustmerId) ? $editCustmerId : '')) . ">" . $customerNameData['customer_name'] . "</option>";
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

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3"><?= $this->lang->line('co_location'); ?></label>
                                        <div class="col-sm-9">
                                            <span id='cust_location' name='cust_location'><?= $this->lang->line('NA'); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <input type='hidden' name='location_id' id='location_id' value="<?php echo set_value('location_id', (isset($editLocationId) ? $editLocationId : '')) ?>" />
                                <input type='hidden' name='assigned_to' id='assigned_to' value='<?php echo set_value('assigned_to', (isset($editAssignedTo) ? $editAssignedTo : '')) ?>"'/>

                                <div class="clearfix"></div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 required" for="name">Customer Code</label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <select class="form-control chosen-select" id='cust_code' name='cust_code' required='true' data-parsley-required-message="Please Select Customer Code" data-parsley-errors-container="#customer_code_error">
                                                    <option class='cust_code_class' value=''>Select Customer Code</option>
                                                    <?php
                                                    foreach ($customerCodeList as $customerCodeData) {
                                                        echo "<option class='cust_code_class' value='" . $customerCodeData['customer_id'] . "' " . set_select('cust_code', (isset($editCustmerId) ? $editCustmerId : ''), $customerCodeData['customer_id'] == (isset($editCustmerId) ? $editCustmerId : '')) . ">" . $customerCodeData['customer_code'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                                <div class="input-group-btn">
                                                    <button class="btn btn-default" type="button">
                                                        <i class="fa fa-user" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <span id="customer_code_error"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">Asset Number</label>
                                        <div class="col-sm-9">
                                            <span id='asset_number' name='asset_number'><?= $this->lang->line('NA'); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3"><?= $this->lang->line('co_customer_number'); ?></label>
                                        <div class="col-sm-9">
                                            <span id='cust_number' name='cust_number'><?= $this->lang->line('NA'); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">Serial Number</label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <select class="form-control chosen-select" id='machine_sr_number' name='machine_sr_number' required='true' data-parsley-required-message="Please Select Serial Number" data-parsley-errors-container="#serial_number_error">
                                                    <option class='sr_number_class' value=''>Select Serial Number Code</option>
                                                    <?php
                                                    foreach ($customerSerialList as $customerSerialData) {
                                                        echo "<option class='sr_number_class' value='" . $customerSerialData['sr_number_id'] . "' " . set_select('machine_sr_number', (isset($editCustmerId) ? $editCustmerId : ''), $customerSerialData['sr_number_id'] == (isset($editCustmerId) ? $editCustmerId : '')) . ">" . $customerSerialData['machine_serial_number'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                                <div class="input-group-btn">
                                                    <button class="btn btn-default" type="button">
                                                        <i class="fa fa-user" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <span id="serial_number_error"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">Machine Id</label>
                                        <div class="col-sm-9">
                                            <span id='machine_id' name='machine_id'><?= $this->lang->line('NA'); ?></span>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                      <div class='row'>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-3 required" for="name">Request Type</label>
                                <div class="col-sm-9 chosen">
                                    <div class="input-group">
                                        <select class="form-control" id='request_type' name='request_type' required='true' data-parsley-required-message="Please Select Request Type" data-parsley-errors-container="#request_type_error">
                                            <option value=''>Select Request Type</option>
                                            <option value='cm' <?php echo set_select('request_type', 'cm', (isset($editRequestType) ? $editRequestType : '') == 'cm'); ?>  >Corrective Maintenance</option>
                                            <option value='pm' <?php echo set_select('request_type', 'pm', (isset($editRequestType) ? $editRequestType : '') == 'pm'); ?> >Preventive Maintenance</option>
                                            <?php
                                            /* foreach ($customerCodeList as $customerCodeData) {
                                              echo "<option value='" . $customerCodeData['customer_id'] . "' " . set_select('request_type', (isset($editCustmerId) ? $editCustmerId : ''), $customerCodeData['customer_id'] == (isset($editCustmerId) ? $editCustmerId : '')) . ">" . $customerCodeData['customer_code'] . '-' . $customerCodeData['customer_name'] . "</option>";
                                              } */
                                            ?>
                                        </select>
                                    </div>
                                    <span id="request_type_error"></span>
                                </div>
                            </div>
                        </div>
                      
                        <div class="col-sm-6" id='preventive_maintenance_radio' name='preventive_maintenance_radio' style='display:none'>
                            <div class="form-group">
                                <label class="control-label col-sm-3" >Preventive Maintenance</label>
                                <div class="col-sm-9">
                                    <label class="radio-inline"><input type="radio" id='reventive_maintenance_yes' name='preventive_maintenance'  value="yes" <?php echo set_radio('preventive_maintenance', 'yes', (isset($editPreventiveMaintenance) ? (($editPreventiveMaintenance == 'yes') ? TRUE : FALSE) : TRUE)); ?> >Yes</label>
                                    <label class="radio-inline"><input type="radio" id='reventive_maintenance_no' name='preventive_maintenance'  value="no" <?php echo set_radio('preventive_maintenance', 'no', (isset($editPreventiveMaintenance) ? (($editPreventiveMaintenance == 'no') ? TRUE : FALSE) : FALSE)); ?>>No</label>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-3 required">Contact Person</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" placeholder="Enter Contact Person" id='contact_person' name='contact_person' value="<?php echo set_value('contact_person', (isset($editContactPerson) ? $editContactPerson : '')) ?>" required='true' data-parsley-required-message="Please Enter Contact Person" data-parsley-maxlength="100" data-parsley-maxlength-message ='Max. 100 Characters are allowed.' data-parsley-trigger="keyup"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-3 required">Contact Number</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" placeholder="Enter Contact Number" id='contact_number' name='contact_number' value="<?php echo set_value('contact_number', (isset($editContactNumber) ? $editContactNumber : '')) ?>" required='true' data-parsley-required-message="Please Enter Contact Number" data-parsley-maxlength="15" data-parsley-maxlength-message ='Max. 15 Characters are allowed.' data-parsley-pattern="^[\d\+\-\.\(\)\/\s]*$" data-parsley-pattern-message='Please Enter Valid Contact Number' data-parsley-trigger="keyup"/>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-3 required" for="name">Address Of Machine</label>
                                <div class="col-sm-9 chosen">
                                    <textarea id='addr_of_machine' name='addr_of_machine' class="form-control" placeholder="Please Enter Address Of Machine" required='true' data-parsley-required-message="Please Enter Address Of Machine" data-parsley-trigger="keyup"><?php echo set_value('addr_of_machine', (isset($editAdressOfMachine) ? $editAdressOfMachine : '')) ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-3 required">Issues</label>
                                <div class="col-sm-9">
                                    <textarea id='issues' name='issues' class="form-control" placeholder="Enter Issues" maxlength="1000" required='true' data-parsley-required-message="Please Enter Issues" data-parsley-trigger="keyup"><?php echo set_value('issues', (isset($editIssues) ? $editIssues : '')) ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-sm-12 text-center">
                            <div class="bottom-buttons">
                                <input class='btn btn-primary' type='submit' name='add_save' id='add_save' value='<?php echo ($screenType == 'edit') ? 'Update' : 'Save' ?>' />
                                <a href="<?php echo base_url($crnt_view) ?>" class="btn btn-default">Cancel</a>
                            </div>
                        </div>
                      </div>
                    </div>
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