<script>
    var allowedImgType = "<?php echo ALLOWED_IMAGE_ATTACHMENT_TYPE; ?>";
    var allowedMaxFileSize = "<?php echo ALLOWED_MAX_FILE_SIZE; ?>";
</script>
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
                            <select class="form-control" id='version_installation' name='version_installation' required='true' data-parsley-required-message="Please Select Machine Version">
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
                            <span id="no_sr_numberSpan" ></span>
                            <select class="form-control" id='sr_number_installation' name='sr_number_installation' required='true' data-parsley-required-message="Please Select Serial Number">
                                <option value=''>Select Serial Number</option>
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

                <?php /* <div class="col-sm-6">
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
                  </div> */ ?>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3 required">Installation Date</label>
                        <div class="col-sm-9">
                            <div class="input-group" id='installation_date'>
                                <input type="text" class="form-control" placeholder="MM/DD/YYYY" name='installation_date' value="" required='true' data-parsley-required-message="Please Enter Installation Date" >
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
                            <textarea class="form-control" rows="3" id="machine_installed_location" name='machine_installed_location' placeholder="Enter Machine Installed Location" required='true' data-parsley-required-message="Please Enter Machine Installed Location" ><?php echo set_value('machine_installed_location', (isset($editMachineSpecialNote) ? $editMachineSpecialNote : '')) ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3 required">Serving Size</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="serving_size" name='serving_size' required="true" data-parsley-required-message="Please Select Serving Size">
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

                            <input type="hidden" name="removeFile" id='removeFile' value='0' />
                            <div><span class="file_error"></span></div>
                            <div id="image-holder"></div>
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

                            <input type="hidden" name="removeFile_menu" id='removeFile_menu' value='0' />
                            <div><span class="file_error_menu"></span></div>
                            <div id="image-holder-menu"></div>

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
<script>
    $(document).ready(function () {
        $('#installation_date').datetimepicker({format: 'L'});
    });
</script>