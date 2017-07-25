<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script>
    var baseurl = '<?php echo base_url(); ?>';
    var getSelectedVersionDataURL = "<?php echo base_url('MachineAssignment/getSelectedVersionData'); ?>";
    var getSelectedSrNumberDataURL = "<?php echo base_url('MachineAssignment/getSelectedSrNumberData'); ?>";
    var getCustomerDetailsURL = "<?php echo base_url('MachineAssignment/getCustomerDetails'); ?>";
    var getCustomerLocationsURL = "<?php echo base_url('MachineAssignment/getPopUpData'); ?>";
    var getVersionDataPullOut = "<?php echo base_url('MachineAssignment/getVersionDataPullOut'); ?>";
    var getSelectedSrNumberDataPullOut = "<?php echo base_url('MachineAssignment/getSrNumberDataPullOut'); ?>";
    var machinePicturePath = '<?php echo $this->config->item('machine_assignment_attachment_base_url'); ?>';
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
                    Machine Assignment
                </h1>
            </div>
        </div>
        <?php
        $attributes = array("name" => "customer_machine_assign", "id" => "customer_machine_assign", "data-parsley-validate" => "", "class" => "form-horizontal", 'novalidate' => '', 'enctype' => 'multipart/form-data');
        echo form_open_multipart($form_action_path, $attributes);
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Customer Information
                        </div>
                        <div class="panel-collapse">
                            <div class="panel-body">
                                <div class="row">

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-sm-3 required" for="name">Customer Code</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <select class="form-control chosen-select" id='cust_code' name='cust_code' required='true' data-parsley-required-message="Please Select Customer Code" data-parsley-errors-container="#customer_code_error">
                                                        <option value='' class='cust_code_class'>Select Customer Code</option>
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
                                            <label class="control-label col-sm-3 ">Mobile Number</label>
                                            <div class="col-sm-9">
                                                <span id='cust_number' name='cust_number'><?= $this->lang->line('NA'); ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="clearfix"></div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-sm-3 required" for="name">Customer Name</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <select class="form-control chosen-select-name" id='cust_name' name='cust_name' required='true' data-parsley-required-message="Please Select Customer Name" data-parsley-errors-container="#customer_name_error">
                                                        <option value='' class='cust_name_class'>Select Customer Name</option>
                                                        <?php
                                                        foreach ($customerNameList as $customerNameData) {
                                                            echo "<option class='cust_name_class' value='" . $customerNameData['customer_name'] . "' >" . $customerNameData['customer_name'] . "</option>";
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
                                            <label class="control-label col-sm-3 ">Location/Outlet Name</label>
                                            <div class="col-sm-9">
                                                <span id='cust_location' name='cust_location'><?= $this->lang->line('NA'); ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="clearfix"></div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-sm-3 ">Email</label>
                                            <div class="col-sm-9">
                                                <span id='cust_email' name='cust_email'><?= $this->lang->line('NA'); ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-sm-3 ">Route</label>
                                            <div class="col-sm-9">
                                                <span id='cust_route' name='cust_route'><?= $this->lang->line('NA'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">Machine Assignment Type</div>
                        <div class="panel-collapse">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-sm-3 required">Assignment Type</label>
                                            <div class="col-sm-9">
                                                <select class="form-control" onChange="machine_assignment_type()" id='assignment_type' name='assignment_type' required='true' data-parsley-required-message="Please Select Assignment Type">
                                                    <option value=''>Select Assign Type</option>
                                                    <option value='installation'>Installation</option>
                                                    <option value='pull_out'>Pull out</option>
                                                    <option value='replacement'>Replacement</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="assignment_detail">
                </div>
                <br>
                <div class="col-sm-12 text-center">
                    <div class="bottom-buttons">
                        <input class='btn btn-primary' type='submit' name='add_save' id='add_save' value='<?php echo ($screenType == 'edit') ? 'Save' : 'Add' ?>' />
                        <a href="<?php echo base_url($crnt_view) ?>" class="btn btn-default">Cancel</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Customer Information</h4>
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
        <input type='hidden' name='customer_id' id='customer_id' value="" />

        <?php echo form_close(); ?>
    </div>
</div>