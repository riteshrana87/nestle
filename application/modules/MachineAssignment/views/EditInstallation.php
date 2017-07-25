<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script>
    var machinePicturePath = '<?php echo $this->config->item('machine_assignment_attachment_base_url'); ?>';
    var selVersionId = '<?php echo $editVersionId; ?>';
    var getSelectedVersionDataURL = "<?php echo base_url('MachineAssignment/getSelectedVersionData'); ?>";
    var getSelectedSrNumberDataURL = "<?php echo base_url('MachineAssignment/getSelectedSrNumberData'); ?>";
    var isSerialNumber = "<?php echo $editMachineSerialNumber;?>"
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

                                <!--<form class="form-horizontal">-->
                                <div class="row">
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

                                    <?php /* <div class="col-sm-6">
                                      <div class="form-group">
                                      <label class="control-label col-sm-3">Serial Number</label>
                                      <div class="col-sm-9">
                                      <span id='sr_number_installation' name='sr_number_installation'><?php echo (!empty($editMachineSerialNumber)) ? $editMachineSerialNumber : $this->lang->line('NA'); ?></span>
                                      </div>
                                      </div>
                                      </div> */ ?>
                                    <?php if (!empty($editMachineSerialNumber)) { ?>
                                        <div class = "col-sm-6">
                                            <div class = "form-group">
                                                <label class = "control-label col-sm-3">Serial Number</label>
                                                <div class = "col-sm-9">
                                                    <span ><?php echo (!empty($editMachineSerialNumber)) ? $editMachineSerialNumber : $this->lang->line('NA'); ?></span>
                                                    <input type='hidden' name='sr_number_installation' id='sr_number_installation' value='<?php echo $sr_number_id;?>'>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label col-sm-3">Serial Number</label>
                                                <div class="col-sm-9">
                                                    <span id="no_sr_numberSpan" ></span>
                                                    <select class="form-control" id='sr_number_installation' name='sr_number_installation' required='true' data-parsley-required-message="Please Select Serial Number">
                                                        <option value=''>Select Serial Number</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
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
                                            <label class="control-label col-sm-3 required">Installation Date</label>
                                            <div class="col-sm-9">
                                                <div class="input-group" id='installation_date'>
                                                    <input type="text" class="form-control" placeholder="MM/DD/YYYY" name='installation_date' value="<?php echo set_value('installation_date', (isset($editInstallationDate)) ? $editInstallationDate : ''); ?>" required='true' data-parsley-required-message="Please Enter Installation Date" >
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar" aria-hidden="true"></i>
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
                                            <label class="control-label col-sm-3 required">Machine Installed Location</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control" rows="3" id="machine_installed_location" name='machine_installed_location' placeholder="Enter Machine Installed Location" required='true' data-parsley-required-message="Please Enter Machine Installed Location"><?php echo set_value('machine_installed_location', (isset($editMachineInstalledLocation) ? $editMachineInstalledLocation : '')) ?></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-sm-3 required">Serving Size</label>
                                            <div class="col-sm-9">
                                                <select class="form-control" id="serving_size" name='serving_size' required="true">
                                                    <option value=''>Select Serving Size</option>
                                                    <?php
                                                    foreach ($servingSize as $serving_size) {
                                                        echo "<option value='" . $serving_size['code_id'] . "' " . set_select('serving_size', (isset($editServingSize) ? $editServingSize : ''), $serving_size['code_id'] == (isset($editServingSize) ? $editServingSize : '')) . ">" . $serving_size['code_name'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="clearfix"></div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-sm-3">Machine Picture</label>
                                            <div class="col-sm-9 image_part file-uploader">
                                                <label class="attachment">
                                                    <i class="fa fa-cloud-upload"></i>
                                                    <div class="clearfix"></div>
                                                    <input type="file" class="form-control" id='machine_picture' name='machine_picture' style="display: none">
                                                </label>

                                                <input type="hidden" name="removeFilePicture" id='removeFilePicture' value='0' />
                                                <div><span class="file_error"></span></div>
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
                                                        <img id="dynamic" class="thumb-image" width="75" src="<?php echo $iconImg; ?>" /><a href="javascript:void(0);" class='delFile' data-id="<?php echo 'delete_' . $customer_machine_information_id ?>" > X </a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3">Special Note</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control" rows="3" id="machine_comment" name='machine_comment' placeholder="Enter Special Note"><?php echo set_value('machine_comment', (isset($editMachineComment) ? $editMachineComment : '')) ?></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-sm-3">Machine Menu File</label>
                                            <div class="col-sm-9 image_part file-uploader" id="dragAndDropFiles">
                                                <label class="attachments">
                                                    <i class="fa fa-cloud-upload"></i>
                                                    <div class="clearfix"></div>
                                                    <input type="file" class="form-control" id='machine_menu_file' name='machine_menu_file' style="display: none">
                                                </label>

                                                <input type="hidden" name="removeFileMenu" id='removeFileMenu' value='0' />
                                                <div><span class="file_error_menu"></span></div>
                                                <div id="image-holder-menu">
                                                    <?php
                                                    if (!empty($editMachineFileMenu)) {

                                                        $ext = pathinfo($editMachineFileMenu, PATHINFO_EXTENSION);
                                                        $attributes = array('jpg', 'jpeg', 'png');
                                                        if (in_array($ext, $attributes)) {
                                                            $iconImg = $this->config->item('machine_assignment_attachment_base_url') . $customer_machine_information_id . '/Menu/' . $editMachineFileMenu;
                                                            //echo $iconImg; exit;
                                                        } else {
                                                            $iconImg = base_url('/uploads/images/icons64/file-64.png');
                                                        }
                                                        ?>
                                                        <img id="dynamic" class="thumb-image" width="75" src="<?php echo $iconImg; ?>" /><a href="javascript:void(0);" class='delFileMenu' data-id="<?php echo 'delete_' . $customer_machine_information_id ?>" > X </a>
                                                    <?php } ?>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="clearfix"></div>

                                    <div class="col-sm-6">

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