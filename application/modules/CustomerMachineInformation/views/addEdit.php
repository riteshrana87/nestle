<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script>
    var getSelectedVersionDataURL = "<?php echo base_url('CustomerMachineInformation/getSelectedVersionData'); ?>";
    var getSelectedSrNumberDataURL = "<?php echo base_url('CustomerMachineInformation/getSelectedSrNumberData'); ?>";
    var cuurentSRNumber = "<?php echo (isset($editSerialNumber) ? $editSerialNumber : ''); ?>";
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
                    <?php echo ($screenType == 'edit') ? 'Edit Customer' : 'Add Customer'; ?>
                </h1>
            </div>
        </div>
        <?php
        $attributes = array("name" => "customer_add_edit", "id" => "customer_add_edit", "data-parsley-validate" => "", "class" => "form-horizontal", 'novalidate' => '');
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
                                        <label class="control-label col-sm-3 required">Customer Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" id='customer_name' name='customer_name' class="form-control" placeholder="Enter Customer Name" value="<?php echo set_value('customer_name', (isset($editCustomerName) ? $editCustomerName : '')) ?>" required='true' data-parsley-required-message="Please Enter Customer Name"  data-parsley-maxlength="100" data-parsley-maxlength-message ='Max. 100 Characters are allowed.' data-parsley-trigger="keyup"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 required">Customer Code</label>
                                        <div class="col-sm-9">
                                            <input type="text" id='customer_code' name='customer_code' class="form-control" placeholder="Enter Customer Code" value="<?php echo set_value('customer_code', (isset($editCustomerCode) ? $editCustomerCode : '')) ?>" required='true' data-parsley-required-message="Please Enter Customer Code" data-parsley-maxlength="100" data-parsley-maxlength-message ='Max. 100 Characters are allowed.' data-parsley-trigger="keyup"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 required">Mobile Number</label>
                                        <div class="col-sm-9">
                                            <input type="text" id='mobile_number' name='mobile_number' class="form-control" placeholder="Enter Mobile Number" value="<?php echo set_value('mobile_number', (isset($editMobileNumber) ? $editMobileNumber : '')) ?>" required='true' data-parsley-required-message="Please Enter Mobile Number" data-parsley-maxlength="15" data-parsley-pattern="^[\d\+\-\.\(\)\/\s]*$" data-parsley-trigger="keyup"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 required">Sales Representative</label>
                                        <div class="col-sm-9">
                                            <?php echo ucfirst($user_info['FIRSTNAME'] . ' ' . $user_info['LASTNAME']); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 required">Trading Type</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id='trading_type' name='trading_type' required='true' data-parsley-required-message="Please Select Trading Type">
                                                <option value=''>Select Trading Type</option>
                                                <?php
                                                foreach ($tradingTypeList as $tradingTypeData) {
                                                    echo "<option value='" . $tradingTypeData['code_id'] . "' " . set_select('trading_type', (isset($editTradingType) ? $editTradingType : ''), $tradingTypeData['code_id'] == (isset($editTradingType) ? $editTradingType : '')) . ">" . $tradingTypeData['code_name'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-3 required">Email</label>
                                            <div class="col-sm-9">
                                                <input type="email" data-parsley-email id='email' name='email' class="form-control" placeholder="Enter Email Id" value="<?php echo set_value('email', (isset($editEmail) ? $editEmail : '')) ?>" required='true' data-parsley-required-message="Please Enter email"/>
                                            </div>
                                        </div>

                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 required">Location/Outlet Name</label>
                                        <div class="col-sm-9">
                                            <textarea id='location' rows='3' name='location' class="form-control" placeholder="Enter Machine Location"  required='true' data-parsley-required-message="Please Enter Location"><?php echo set_value('location', (isset($editLocation) ? $editLocation : '')) ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div>
                                <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3 required">Commercial/Institutional</label>
                                    <div class="col-sm-9">
                                        <input type="text" id='com_inst' name='com_inst' class="form-control" placeholder="Enter Commercial/Institutional" value="<?php echo set_value('com_inst', (isset($editCommercialInstitutional) ? $editCommercialInstitutional : '')) ?>" required='true' data-parsley-required-message="Please Enter Commercial/Institutional" data-parsley-maxlength="50" data-parsley-maxlength-message ='Max. 50 Characters are allowed.' data-parsley-trigger="keyup"/>
                                    </div>
                                </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 required">New Channel Classification</label>
                                        <div class="col-sm-9">
                                            <input type="text" id='new_channel_classification' name='new_channel_classification' class="form-control" placeholder="Enter New Channel Classification" value="<?php echo set_value('new_channel_classification', (isset($editNewChannelClassification) ? $editNewChannelClassification : '')) ?>" required='true' data-parsley-required-message="Please Enter New Channel Classification"  data-parsley-maxlength="100" data-parsley-maxlength-message ='Max. 100 Characters are allowed.'/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 required">PO Box </label>
                                        <div class="col-sm-9">
                                            <input type="text" id='pob' name='pob' class="form-control" placeholder="Enter POB" value="<?php echo set_value('pob', (isset($editPOB) ? $editPOB : '')) ?>" required='true' data-parsley-required-message="Please Enter POB" data-parsley-type="digits" data-parsley-type-message="Only digits are allowed" data-parsley-maxlength="10" data-parsley-maxlength-message ='Max. 10 digits are allowed.' data-parsley-trigger="keyup"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 required">Route</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id='route' name='route' required='true' data-parsley-required-message="Please Select Route">
                                                <option value=''>Select Route</option>
                                                <?php
                                                foreach ($routeList as $routeData) {
                                                    echo "<option value='" . $routeData['id'] . "' " . set_select('route', (isset($editRoute) ? $editRoute : ''), $routeData['id'] == (isset($editRoute) ? $editRoute : '')) . ">" . $routeData['name'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="clearfix"></div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 required">Contact Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" id='contact_name' name='contact_name' class="form-control" placeholder="Enter Contact Name" value="<?php echo set_value('contact_name', (isset($editContactName) ? $editContactName : '')) ?>" required='true' data-parsley-required-message="Please Enter Contact Name"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 required">Contact Number</label>
                                        <div class="col-sm-9">
                                            <input type="text" id='contact_number' name='contact_number' class="form-control" placeholder="Enter Contact Number" value="<?php echo set_value('contact_number', (isset($editContactNumber) ? $editContactNumber : '')) ?>" required='true' data-parsley-required-message="Please Enter Contact Number" data-parsley-maxlength="100" data-parsley-maxlength-message ='Max. 100 Characters are allowed.'/>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 required">Emirates</label>
                                        <div class="col-sm-9 m-b-15">
                                            <select class="form-control" id='emirates' name="emirates" required='true' data-parsley-required-message="Please Select Emirates">
                                                <option value=''>Select Emirates</option>
                                                <?php
                                                foreach ($emirateList as $emirateData) {
                                                    echo "<option value='" . $emirateData['id'] . "' " . set_select('emirates', (isset($editEmirates) ? $editEmirates : ''), $emirateData['id'] == (isset($editEmirates) ? $editEmirates : '')) . ">" . $emirateData['name'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <label class="control-label col-sm-3">Contract Available</label>
                                        <div class="col-sm-9">
                                            <label class="radio-inline"><input type="radio" name="contract_available" id='contract_available_yes' value="yes" <?php echo set_radio('contract_available', 'yes', (isset($editContractAvailable) ? (($editContractAvailable == 'yes') ? TRUE : FALSE) : TRUE)); ?> >Yes</label>
                                            <label class="radio-inline"><input type="radio" name="contract_available" id='contract_available_no' value="no" <?php echo set_radio('contract_available', 'no', (isset($editContractAvailable) ? (($editContractAvailable == 'no') ? TRUE : FALSE) : FALSE)); ?>>No</label>
                                        </div>

                                    </div>
                                </div>


                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">Special Note</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" rows="5" id="customer_comments" name='customer_comments' placeholder="Enter Special Note"><?php echo set_value('customer_comments', (isset($editCustomerSpecialNote) ? $editCustomerSpecialNote : '')) ?></textarea>
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
                        <div class="panel-heading">Machine Information</div>
                        <div class="panel-collapse">
                            <div class="panel-body">

                                <!--<form class="form-horizontal">-->

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 required">Version</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id='version' name='version' required='true' data-parsley-required-message="Please Select Machine Version">
                                                <option value=''>Select Version</option>
                                                <?php
                                                foreach ($versionList as $versionData) {
                                                    echo "<option value='" . $versionData['version_id'] . "' " . set_select('version', (isset($editVersion) ? $editVersion : ''), $versionData['version_id'] == (isset($editVersion) ? $editVersion : '')) . ">" . $versionData['version_name'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">GEN</label>
                                        <div class="col-sm-9">
                                            <span id='gen' name='gen'>-- N/A --</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">Hot/Cold</label>
                                        <div class="col-sm-9">
                                            <span id='hot_cold' name='hot_cold'>-- N/A --</span>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">MPR</label>
                                        <div class="col-sm-9">
                                            <span id='mpr' name='mpr'>-- N/A --</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">BevType</label>
                                        <div class="col-sm-9">
                                            <span id='bev_type' name='bev_type'>-- N/A --</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">Machine Abb</label>
                                        <div class="col-sm-9">
                                            <span id='machine_abb' name='machine_abb'>-- N/A --</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 required">Serving Size</label>
                                        <div class="col-sm-9">
                                            <select class="form-control"  id='serving_size' name='serving_size' required='true' data-parsley-required-message="Please Select Serving Size">
                                                <option value=''>Select Serving Size</option>
                                                <option <?php if(isset($editServingSize) && $editServingSize == '7oz'){
                                                    echo "selected";}?> value='7oz'>7oz</option>
                                                <option <?php if(isset($editServingSize) && $editServingSize == '9oz'){
                                                    echo "selected";}?> value='9oz'>9oz</option>
                                                <option <?php if(isset($editServingSize) && $editServingSize == '12oz'){
                                                    echo "selected";}?> value='12oz'>12oz</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 text-center">
                    <div class="bottom-buttons">
                        <input class='btn btn-primary' type='submit' name='add_save' id='add_save' value='<?php echo ($screenType == 'edit') ? 'Update' : 'Add' ?>' />
                        <a href="<?php echo base_url('CustomerMachineInformation') ?>" class="btn btn-default">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>