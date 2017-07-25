<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script>
    var getSelectedVersionDataURL = "<?php echo base_url('Customer/getSelectedVersionData'); ?>";
    var getSelectedSrNumberDataURL = "<?php echo base_url('Customer/getSelectedSrNumberData'); ?>";
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
                   Machine information
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
                              <div class="row">
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
                                        <label class="control-label col-sm-3 required">Serial Number</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id='sr_number' name='sr_number' required='true' data-parsley-required-message="Please Select Serial Number">
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">GEN</label>
                                        <div class="col-sm-9">
                                            <span id='gen' name='gen'>-- N/A --</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">Hot/Cold</label>
                                        <div class="col-sm-9">
                                            <span id='hot_cold' name='hot_cold'>-- N/A --</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">MPR</label>
                                        <div class="col-sm-9">
                                            <span id='mpr' name='mpr'>-- N/A --</span>
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
                                        <label class="control-label col-sm-3">BevType</label>
                                        <div class="col-sm-9">
                                            <span id='bev_type' name='bev_type'>-- N/A --</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">Assets Number</label>
                                        <div class="col-sm-9">
                                            <span id='assets' name='assets'>-- N/A --</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">BMB</label>
                                        <div class="col-sm-9">
                                            <span id='bmb' name='bmb'>-- N/A --</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">Technical Status</label>
                                        <div class="col-sm-9">
                                            <span id='tech_status' name='tech_status'>-- N/A --</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">Sap Purchase Date</label>
                                        <div class="col-sm-9">
                                            <span id='sap_purchase_date' name='sap_purchase_date'>-- N/A --</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">TA Depc. Date</label>
                                        <div class="col-sm-9">
                                            <span id='ta_depc_date' name='ta_depc_date'>-- N/A --</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">Last PM</label>
                                        <div class="col-sm-9">
                                            <span id='last_pm' name='last_pm'>-- N/A --</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">Days Till Last PM</label>
                                        <div class="col-sm-9">
                                            <span id='days_till_last_pm' name='days_till_last_pm'>-- N/A --</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 required">Installation Date</label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <input type="text" data-format="DD/MM/yyyy" id='installation_date' name='installation_date' class="form-control" placeholder="DD/MM/YYYY" value="<?php echo set_value('installation_date', (isset($editInstallationDate)) ? $editInstallationDate : ''); ?>" required='true' data-parsley-required-message="Please Select Installation Date" readonly>
                                                <div class="input-group-btn">
                                                    <button class="btn btn-default" type="button">
                                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 required">Zone</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id='zone' name='zone' required='true' data-parsley-required-message="Please Select Zone">
                                                <option value=''>Select Zone</option>
                                                <?php
                                                foreach ($zoneList as $zoneData) {
                                                    echo "<option value='" . $zoneData['id'] . "' " . set_select('zone', (isset($editZone) ? $editZone : ''), $zoneData['id'] == (isset($editZone) ? $editZone : '')) . ">" . $zoneData['name'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">Machine Installed Location</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" rows="3" id="machine_installed_location" name='machine_installed_location' placeholder="Enter Machine Installed Location"><?php echo set_value('machine_installed_location', (isset($editMachineSpecialNote) ? $editMachineSpecialNote : '')) ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">Machine picture</label>
                                        <div class="col-sm-9 image_part file-uploader m-b-15" id="dragAndDropFiles">
                                            <label name="attachments" class="attachments">
                                                <i class="fa fa-cloud-upload"></i>
                                                <div class="clearfix"></div>
                                    <input name="attachments" style="display: none" id="upl" multiple="" type="file">
                                            </label>

                                        </div>

                                        <label class="control-label col-sm-3">Machine Menu File</label>
                                        <div class="col-sm-9 image_part file-uploader" id="dragAndDropFiles">
                                            <label name="attachments" class="attachments">
                                                <i class="fa fa-cloud-upload"></i>
                                                <div class="clearfix"></div>
                                                <input name="attachments" style="display: none" id="upl" multiple="" type="file">
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">Special Note</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" rows="3" id="machine_comment" name='machine_comment' placeholder="Enter Special Note"><?php echo set_value('machine_comment', (isset($editMachineSpecialNote) ? $editMachineSpecialNote : '')) ?></textarea>
                                        </div>
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
                        <input class="btn btn-info" type='reset' name='customer_reset' id='customer_reset' value='Reset' />
                        <a href="<?php echo base_url('Customer') ?>" class="btn btn-default">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>