<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script>
    var bas_url = '<?php echo base_url(); ?>';
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
                    Customer Master - Back Office
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
                                            <?php
                                            if (isset($editCustomerName)) {
                                                echo $editCustomerName;
                                            } else {
                                                echo "Record Not Found";
                                            }
                                            ?>
                                            <input type="hidden" name="customer_id" value="<?php echo set_value('customer_id', (isset($editCustomerId) ? $editCustomerId : '')) ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 required">Customer Code</label>
                                        <div class="col-sm-9">
                                            <?php
                                            if (isset($editCustomerCode)) {
                                                echo $editCustomerCode;
                                            } else {
                                                echo "Record Not Found";
                                            }
                                            ?>
                                            <input type="hidden" name="customer_code" value="<?php echo set_value('customer_code', (isset($editCustomerCode) ? $editCustomerCode : '')) ?>">

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
                                            <?php
                                            if (isset($editVersionName)) {
                                                echo $editVersionName;
                                            } else {
                                                echo "Record Not Found";
                                            }
                                            ?>
                                            <input type="hidden" id='version' name='version' value="<?php echo set_value('version', (isset($editVersion) ? $editVersion : '')) ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 required">Serial Number</label>
                                        <div class="col-sm-9">
                                            <span id="no_sr_numberSpan" ></span>
                                            <?php
                                            if (isset($editMachineSerialNumber)) {
                                                echo $editMachineSerialNumber;
                                            } else {
                                                ?>
                                                <select class="form-control" id='sr_number' name='sr_number' required='true' data-parsley-required-message="Please Select Serial Number">
                                                </select>
                                            <?php }?>
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
                                        <label class="control-label col-sm-3">Asset Number</label>
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
                                            <div class="input-group" id="installation_date">
                                                <input type="text" class="form-control" placeholder="MM/DD/YYYY" name='installation_date' value="<?php echo set_value('installation_date', (isset($editInstallationDate) ? (!empty($editInstallationDate) ? $editInstallationDate : '') : '')) ?>" required='true' data-parsley-required-message="Please Enter Installation Date" />
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
                                        <label class="control-label col-sm-3">Serving Size
                                        </label>
                                        <div class="col-sm-9">
                                            <span id='serving_size' name='serving_size'><?php echo set_value('serving_size', (isset($editServingSize) ? $editServingSize : '-- N/A --')) ?></span>

                                        </div>
                                    </div>
                                </div>


                                <div class="clearfix"></div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">Special Note</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" rows="3" id="machine_comment" name='machine_comment' placeholder="Enter Special Note"><?php echo set_value('machine_comment', (isset($editMachineComment) ? $editMachineComment : '')) ?></textarea>
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
                                                <?= lang('DROP_IMAGES_HERE') ?>
                                                <input type="file" onchange="showimagepreview(this)" name="attachments" style="display: none" id="upl" multiple />
                                            </label>
                                            <?php
                                            if (!empty($editMachinePicture)) {
                                                $arr_list = explode('.', $editMachinePicture);
                                                $image_path = $this->config->item('delivery_order_upload_base_url') . 'CustomerMachineInformation/' . $editMachinePicture;
                                                $arr = $arr_list[1];
                                                if (!file_exists($this->config->item('delivery_order_upload_base_url') . $editMachinePicture)) {
                                                    ?>
                                                    <div id="img_<?php echo $editCustomerId; ?>" class="eachImage"><span class="preview">
                                                            <?php if ($arr == 'jpg' || $arr == 'jpeg' || $arr == 'png' || $arr == 'gif') { ?>
                                                                <img src="<?= $image_path; ?>"  width="75"/>
                                                            <?php } else { ?>
                                                                <div><img src="<?php echo base_url('/uploads/images/icons64/file-64.png'); ?>"/>
                                                                    <p class="img_show"><?php echo $arr; ?>
                                                                      <a title=""
                                                                        <?php echo lang('delete'); ?>" class="delete_file remove_drag_img" href="javascript:;" data-id="img_<?php echo $editCustomerId; ?>" data-name="<?php echo $editMachinePicture; ?>" data-path="<?php echo $this->config->item('delivery_order_upload_root_url') . 'CustomerMachineInformation' ?>">x
                                                                      </a>
                                                                    </p>
                                                                </div>
                                                            <?php } ?>
                                                            <p class="img_name"><?php echo $editMachinePicture; ?></p>
                                                            <span class="overlay" style="display: none;"> <span class="updone">100%</span></span>
                                                        </span> </div>
                                                <?php } ?>
                                                <?php ?>
                                                <div id="deletedImagesDiv"></div>
                                            <?php } ?>
                                        </div>

                                        <label class="control-label col-sm-3">Machine Menu File</label>
                                        <div class="col-sm-9 image_part file-uploader" id="MachinedragAndDropFiles">
                                            <label name="attachments_menu" class="attachments">
                                                <i class="fa fa-cloud-upload"></i>
                                                <div class="clearfix"></div>
                                                <?= lang('DROP_IMAGES_HERE') ?>
                                                <input type="file" onchange="showmachineimagepreview(this)" name="attachments_menu" style="display: none" id="upl_machine" multiple />
                                            </label>
                                            <?php
                                            if (!empty($editMachineMenuFile)) {
                                                $arr_list = explode('.', $editMachineMenuFile);
                                                $image_path = $this->config->item('delivery_order_upload_base_url') . 'CustomerMachineInformation/' . $editMachineMenuFile;
                                                $arr = $arr_list[1];
                                                if (!file_exists($this->config->item('delivery_order_upload_base_url') . $editMachineMenuFile)) {
                                                    ?>
                                                    <div id="remove_img_<?php echo $editCustomerId; ?>" class="machine"><span class="preview">
                                                            <?php if ($arr == 'jpg' || $arr == 'jpeg' || $arr == 'png' || $arr == 'gif') { ?>
                                                                <img src="<?= $image_path; ?>"  width="75"/>
                                                            <?php } else { ?>
                                                                <div><img src="<?php echo base_url('/uploads/images/icons64/file-64.png'); ?>"/>
                                                                    <p class="img_show"><?php echo $arr; ?></p>
                                                                  <a title=""
                                                                    <?php echo lang('delete'); ?>" class="machine_delete_file remove_drag_img" href="javascript:;" data-id="remove_img_<?php echo $editCustomerId; ?>" data-name="<?php echo $editMachineMenuFile; ?>" data-path="<?php echo $this->config->item('delivery_order_upload_root_url') . 'CustomerMachineInformation' ?>">x
                                                                  </a>
                                                                </div>
                                                            <?php } ?>
                                                            <p class="img_name"><?php echo $editMachineMenuFile; ?></p>
                                                            <span class="overlay" style="display: none;"> <span class="updone">100%</span></span>
                                                        </span> </div>
                                                <?php } ?>
                                                <?php ?>
                                                <div id="machinedeletedImagesDiv"></div>
                                            <?php } ?>
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
                        <a href="<?php echo base_url('CustomerMachineInformation') ?>" class="btn btn-default">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>