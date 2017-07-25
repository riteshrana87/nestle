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
                <h1 class="page-head-line">Maintenance - Back Office </h1>
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
                        <?php //echo ($screenType == 'edit') ? 'Edit' : 'Add' ?> Maintenance - Back Office 
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
                                        <label class="control-label col-sm-3" for="name"><?= $this->lang->line('co_customer_name'); ?></label>
                                        <div class="col-sm-9">
                                            <span id='cust_name' name='cust_name'><?= (isset($customer_name)) ? $customer_name : '' ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3"><?= $this->lang->line('co_location'); ?></label>
                                        <div class="col-sm-9">
                                            <span id='cust_location' name='cust_location'><?= (isset($location)) ? $location : '' ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="name">Customer Code</label>
                                        <div class="col-sm-9">
                                            <span id='cust_code' name='cust_code'><?= (isset($customer_code)) ? $customer_code : '' ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">Asset Number</label>
                                        <div class="col-sm-9">
                                            <span id='asset_number' name='asset_number'><?= (isset($asset)) ? $asset : '' ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3"><?= $this->lang->line('co_customer_number'); ?></label>
                                        <div class="col-sm-9">
                                            <span id='cust_number' name='cust_number'><?= (isset($mobile_number)) ? $mobile_number : '' ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">Serial Number</label>
                                        <div class="col-sm-9">
                                            <span id='serial_number' name='serial_number'><?= (isset($machine_serial_number)) ? $machine_serial_number : '' ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">Machine Id</label>
                                        <div class="col-sm-9">
                                            <span id='machine_id' name='machine_id'><?= (isset($machine_id)) ? $machine_id : '' ?></span>
                                        </div>
                                    </div>
                                </div>
                              </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="name">Request Type</label>
                                <div class="col-sm-9 chosen">
                                    <span id='request_type' name='request_type'><?= (isset($request_type)) ? $request_type : '' ?></span>
                                </div>
                            </div>
                        </div>
                      <div class='row'>
                        <?php if ($request_type == 'Corrective Maintenance') { ?>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3" >Preventive Maintenance</label>
                                    <div class="col-sm-9">
                                        <span id='preventive_maintenance_radio' name='preventive_maintenance_radio'><?= (isset($preventive_maintenance)) ? $preventive_maintenance : '' ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="clearfix"></div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-3">Contact Person</label>
                                <div class="col-sm-9">
                                    <span id='contact_person' name='contact_person'><?= (isset($contact_person)) ? $contact_person : '' ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-3">Contact Number</label>
                                <div class="col-sm-9">
                                    <span id='contact_number' name='contact_number'><?= (isset($contact_number)) ? $contact_number : '' ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="name">Address Of Machine</label>
                                <div class="col-sm-9 chosen">
                                    <span id='addr_of_machine' name='addr_of_machine'><?= (isset($address_of_machine)) ? $address_of_machine : '' ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-3">Issues</label>
                                <div class="col-sm-9">
                                    <span id='issues' name='issues'><?= (isset($machine_issues)) ? $machine_issues : '' ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <hr class="hr-2" />
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-3 required" for="name">Status</label>
                                <div class="col-sm-9 chosen">
                                    <div class="input-group">
                                        <select class="form-control chosen-select" id='status' name='status' required='true' data-parsley-required-message="Please Select Status" data-parsley-errors-container="#status_type_error">
                                            <option value=''>Select Status</option>
                                            <?php
                                            foreach ($statusList as $statusData) {
                                                echo "<option value='" . $statusData['code_id'] . "' " . set_select('status', (isset($editStatus) ? $editStatus : ''), $statusData['code_id'] == (isset($editStatus) ? $editStatus : '')) . ">" . $statusData['code_name'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <span id="status_type_error"></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-3">Assigned To</label>
                                <div class="col-sm-9">
                                    <span id='assigned_to' name='assigned_to'><?= (isset($assigned_to)) ? $assigned_to : '' ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-3 required">Parts Replaced</label>
                                <div class="col-sm-9">
                                    <textarea id='parts_replaced' name='parts_replaced' class="form-control" placeholder="Enter Parts Replaced" required='true' data-parsley-required-message="Please Enter Parts Replaced"><?php echo set_value('parts_replaced', (isset($editPartReplaced) ? $editPartReplaced : '')) ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-3 required">Action Taken</label>
                                <div class="col-sm-9">
                                    <textarea id='action_taken' name='action_taken' class="form-control" placeholder="Enter Action Taken" required='true' data-parsley-required-message="Please Enter Action Taken"><?php echo set_value('action_taken', (isset($editActionTaken) ? $editActionTaken : '')) ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-3 required">Comments</label>
                                <div class="col-sm-9">
                                    <textarea id='comments' name='comments' class="form-control" placeholder="Enter Comments" required='true' data-parsley-required-message="Please Enter Comments"><?php echo set_value('comments', (isset($editComment) ? $editComment : '')) ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-3 required">Resolution</label>
                                <div class="col-sm-9">
                                    <textarea id='resolution' name='resolution' class="form-control" placeholder="Enter Resolution" required='true' data-parsley-required-message="Please Enter Resolution"><?php echo set_value('resolution', (isset($editResolution) ? $editResolution : '')) ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-3 required">Response Date</label>
                                <div class="col-sm-9">
                                    <div class="input-group" id='response_date'>
                                        <input type="text" class="form-control" placeholder="MM/DD/YYYY" name='response_date' value="<?php echo set_value('response_date', (isset($editResponseDate) ? $editResponseDate : '')) ?>" required='true' data-parsley-required-message="Please Enter Response Date" >
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-3 required">Visited Date</label>
                                <div class="col-sm-9">
                                    <div class="input-group" id='visited_date'>
                                        <input type="text" class="form-control" placeholder="MM/DD/YYYY" name='visited_date' value="<?php echo set_value('visited_date', (isset($editVisitedDate) ? $editVisitedDate : '')) ?>" required='true' data-parsley-required-message="Please Enter Visited Date" >
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 text-center">
                            <div class="bottom-buttons">
                                <input class='btn btn-primary' type='submit' name='add_save' id='add_save' value='<?php echo ($screenType == 'edit') ? 'Update' : 'Add' ?>' />
                                <a href="<?php echo base_url($crnt_view) ?>" class="btn btn-default">Cancel</a>
                            </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>