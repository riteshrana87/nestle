<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

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
                    Edit Machine Assignment
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
                                        <label class="control-label col-sm-3" for="name">Customer Name</label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <span id='customer_name' name='customer_name'><?php echo (!empty($customer_name)) ? $customer_name : $this->lang->line('NA'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="name">Customer Code</label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <span id='customer_code' name='customer_code'><?php echo (!empty($customer_code)) ? $customer_code : $this->lang->line('NA'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 ">Mobile Number</label>
                                        <div class="col-sm-9">
                                            <span id='customer_mobile_number' name='customer_mobile_number'><?php echo (!empty($customer_mobile_number)) ? $customer_mobile_number : $this->lang->line('NA'); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 ">Location/Outlet Name</label>
                                        <div class="col-sm-9">
                                            <span id='customer_location' name='customer_location'><?php echo (!empty($customer_location)) ? $customer_location : $this->lang->line('NA'); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 ">Email</label>
                                        <div class="col-sm-9">
                                            <span id='customer_email' name='customer_email'><?php echo (!empty($customer_email)) ? $customer_email : $this->lang->line('NA'); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 ">Route</label>
                                        <div class="col-sm-9">
                                            <span id='customer_route_name' name='customer_route_name'><?php echo (!empty($customer_route_name)) ? $customer_route_name : $this->lang->line('NA'); ?></span>
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
                        <div class="panel-heading">Machine Assignment Type</div>
                        <div class="panel-collapse">
                            <div class="panel-body">
                              <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">Assignment Type</label>
                                        <div class="col-sm-9">
                                            <span id='machine_assign_type' name='machine_assign_type'><?php echo (!empty($machine_assign_type)) ? $machine_assign_type : $this->lang->line('NA'); ?></span>
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
                              <div class="row">
                                <!--<form class="form-horizontal">-->

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">Version</label>
                                        <div class="col-sm-9">
                                            <span id='version_installation' name='version_installation'><?php echo (!empty($editVersion)) ? $editVersion : $this->lang->line('NA'); ?></span>
                                            <?php /* <select class="form-control" id='version_installation' name='version_installation' required='true' data-parsley-required-message="Please Select Machine Version">
                                              <option value=''>Select Version</option>
                                              <?php
                                              /*foreach ($versionList as $versionData) {
                                              echo "<option value='" . $versionData['version_id'] . "' " . set_select('version', (isset($editVersion) ? $editVersion : ''), $versionData['version_id'] == (isset($editVersion) ? $editVersion : '')) . ">" . $versionData['version_name'] . "</option>";
                                              }
                                              ?>
                                              </select> */ ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">Serial Number</label>
                                        <div class="col-sm-9">
                                            <span id='sr_number_installation' name='sr_number_installation'><?php echo (!empty($editMachineSerialNumber)) ? $editMachineSerialNumber : $this->lang->line('NA'); ?></span>
                                            <?php /* <select class="form-control" id='sr_number_installation' name='sr_number_installation' required='true' data-parsley-required-message="Please Select Serial Number">
                                              <option value=''>Select Serial Number</option>
                                              </select> */ ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">GEN</label>
                                        <div class="col-sm-9">
                                            <span id='gen' name='gen'><?php echo (!empty($editGenName)) ? $editGenName : $this->lang->line('NA'); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">Hot/Cold</label>
                                        <div class="col-sm-9">
                                            <span id='hot_cold' name='hot_cold'><?php echo (!empty($editHotColdName)) ? $editHotColdName : $this->lang->line('NA'); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">MPR</label>
                                        <div class="col-sm-9">
                                            <span id='mpr' name='mpr'><?php echo (!empty($editMachineMprName)) ? $editMachineMprName : $this->lang->line('NA'); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">Machine Abb</label>
                                        <div class="col-sm-9">
                                            <span id='machine_abb' name='machine_abb'><?php echo (!empty($editMachineAbbName)) ? $editMachineAbbName : $this->lang->line('NA'); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">BevType</label>
                                        <div class="col-sm-9">
                                            <span id='bev_type' name='bev_type'><?php echo (!empty($editBevTypeName)) ? $editBevTypeName : $this->lang->line('NA'); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">Assets Number</label>
                                        <div class="col-sm-9">
                                            <span id='assets' name='assets'><?php echo (!empty($editAsset)) ? $editAsset : $this->lang->line('NA'); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">BMB</label>
                                        <div class="col-sm-9">
                                            <span id='bmb' name='bmb'><?php echo (!empty($editBmb)) ? $editBmb : $this->lang->line('NA'); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">Technical Status</label>
                                        <div class="col-sm-9">
                                            <span id='tech_status' name='tech_status'><?php echo (!empty($editMachineTechStatus)) ? $editMachineTechStatus : $this->lang->line('NA'); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">Sap Purchase Date</label>
                                        <div class="col-sm-9">
                                            <span id='sap_purchase_date' name='sap_purchase_date'><?php echo (!empty($editSapPurchaseDate)) ? $editSapPurchaseDate : $this->lang->line('NA'); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">TA Depc. Date</label>
                                        <div class="col-sm-9">
                                            <span id='ta_depc_date' name='ta_depc_date'><?php echo (!empty($editTaDepcDate)) ? $editTaDepcDate : $this->lang->line('NA'); ?></span>
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
                                        <label class="control-label col-sm-3">Installation Date</label>
                                        <div class="col-sm-9">
                                            <span id='installation_date' name='installation_date'><?php echo (!empty($editInstallationDate)) ? $editInstallationDate : $this->lang->line('NA'); ?></span>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">Zone</label>
                                        <div class="col-sm-9">
                                            <span id='zone' name='zone'><?php echo (!empty($editZoneName)) ? $editZoneName : $this->lang->line('NA'); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">Machine Installed Location</label>
                                        <div class="col-sm-9">
                                            <span id='machine_installed_location' name='machine_installed_location'><?php echo (!empty($editMachineInstalledLocation)) ? $editMachineInstalledLocation : $this->lang->line('NA'); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">Serving Size</label>
                                        <div class="col-sm-9">
                                            <span id='serving_size' name='serving_size'><?php echo (!empty($editServingSize)) ? $editServingSize : $this->lang->line('NA'); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">Machine Picture</label>
                                        <div class="col-sm-9 image_part file-uploader m-b-15" >                                 
                                            <div id="image-holder">
                                                <?php
                                                if (!empty($editMachinePicture)) {

                                                    $ext = pathinfo($editMachinePicture, PATHINFO_EXTENSION);
                                                    $attributes = array('jpg', 'jpeg', 'png');
                                                    if (in_array($ext, $attributes)) {
                                                        $iconImg = $this->config->item('machine_assignment_attachment_base_url') . $customer_machine_information_id . '/' . $editMachinePicture;
                                                        //echo $iconImg; exit;
                                                    } else {
                                                        $iconImg = base_url('/uploads/images/icons64/file-64.png');
                                                    }
                                                    ?>
                                                    <img id="dynamic" class="thumb-image" width="75" src="<?php echo $iconImg; ?>" />
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label class="control-label col-sm-3">Machine Menu File</label>
                                    <div class="col-sm-9 image_part file-uploader" >
                                        <div id="image-holder-menu">
                                            <?php
                                            if (!empty($editMachineFileMenu)) {
                                                $iconImg = $this->config->item('machine_assignment_attachment_base_url') . $customer_machine_information_id . '/Menu/' . $editMachineFileMenu;
                                                ?>
                                                <a href="<?php echo $iconImg; ?>" download><?php echo $editMachineFileMenu; ?></a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">Special Note</label>
                                        <div class="col-sm-9">
                                            <span id='special_note' name='special_note'><?php echo (!empty($editMachineComment)) ? $editMachineComment : $this->lang->line('NA'); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">Pullout Location</label>
                                        <div class="col-sm-9">
                                            <select name='pullout_location' id='pullout_location' class="form-control" required="true">
                                                <option value="">Select Pullout Location</option>
                                                <?php
                                                foreach ($pulloutLocationList as $pulloutLocationData) {
                                                    echo "<option value='" . $pulloutLocationData['code_id'] . "' " . set_select('pullout_location', (isset($editPulloutLocation) ? $editPulloutLocation : ''), $pulloutLocationData['code_id'] == (isset($editPulloutLocation) ? $editPulloutLocation : '')) . ">" . $pulloutLocationData['code_name'] . "</option>";
                                                }
                                                ?>
                                            </select>
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
                        <a href="<?php echo base_url($crnt_view) ?>" class="btn btn-default">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>