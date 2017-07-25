<div class="panel-group">
    <div class="panel panel-default">

        <div class="panel-heading">Replacement Machine</div>

        <div class="panel-collapse">
            <div class="panel-body"> 
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3 required">Version</label>
                        <div class="col-sm-9">
                            <select class="form-control" id='version_replacement' name='version_replacement' required='true' data-parsley-required-message="Please Select Machine Version">
                                <option value=''>Select Version</option>
                                <?php
                                foreach ($versionListReplecement as $versionListReplecementData) {
                                    echo "<option value='" . $versionListReplecementData['version_id'] . "'>" . $versionListReplecementData['version_name'] . "</option>";
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
                            <span id="no_sr_numberSpanReplace" ></span>
                            <select class="form-control" id='sr_number_replacement' name='sr_number_replacement' required='true' data-parsley-required-message="Please Select Serial Number">
                                <option value=''> Select Serial Number</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3">GEN</label>
                        <div class="col-sm-9">
                            <span id='gen_replacement' name='gen_replacement'>-- N/A --</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3">Hot/Cold</label>
                        <div class="col-sm-9">
                            <span id='hot_cold_replacement' name='hot_cold_replacement'>-- N/A --</span>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3">MPR</label>
                        <div class="col-sm-9">
                            <span id='mpr_replacement' name='mpr_replacement'>-- N/A --</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3">Machine Abb</label>
                        <div class="col-sm-9">
                            <span id='machine_abb_replacement' name='machine_abb_replacement'>-- N/A --</span>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3">BevType</label>
                        <div class="col-sm-9">
                            <span id='bev_type_replacement' name='bev_type_replacement'>-- N/A --</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3">Assets Number</label>
                        <div class="col-sm-9">
                            <span id='assets_replacement' name='assets_replacement'>-- N/A --</span>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3">BMB</label>
                        <div class="col-sm-9">
                            <span id='bmb_replacement' name='bmb_replacement'>-- N/A --</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3">Technical Status</label>
                        <div class="col-sm-9">
                            <span id='tech_status_replacement' name='tech_status_replacement'>-- N/A --</span>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3">Sap Purchase Date</label>
                        <div class="col-sm-9">
                            <span id='sap_purchase_date_replacement' name='sap_purchase_date_replacement'>-- N/A --</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3">TA Depc. Date</label>
                        <div class="col-sm-9">
                            <span id='ta_depc_date_replacement' name='ta_depc_date_replacement'>-- N/A --</span>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3">Last PM</label>
                        <div class="col-sm-9">
                            <span id='last_pm_replacement' name='last_pm_replacement'>-- N/A --</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3">Days Till Last PM</label>
                        <div class="col-sm-9">
                            <span id='days_till_last_pm_replacement' name='days_till_last_pm_replacement'>-- N/A --</span>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3 ">Installation Date</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span id='installation_date_replacement' name='installation_date_replacement'>-- N/A --</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3">Zone</label>
                        <div class="col-sm-9">
                            <span id='zone_replacement' name='zone_replacement'>-- N/A --</span>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3">Machine Installed Location</label>
                        <div class="col-sm-9">
                            <span id='machine_installed_location_replacement' name='machine_installed_location_replacement'>-- N/A --</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3">Serving Size</label>
                        <div class="col-sm-9">
                            <span id='serving_size_replacement' name='serving_size_replacement'>-- N/A --</span>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3">Machine Picture</label>
                        <div class="col-sm-9 image_part file-uploader m-b-15" >
                            <span id='machine_picture_replacement' name='machine_picture_replacement'>-- N/A --</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <label class="control-label col-sm-3">Machine Menu File</label>
                    <div class="col-sm-9 image_part file-uploader" >
                        <span id='machine_menu_file_replacement' name='machine_menu_file_replacement'>-- N/A --</span>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3">Special Note</label>
                        <div class="col-sm-9">
                            <span id='special_note_replacement' name='special_note_replacement'>-- N/A --</span>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<div class="panel-group">
    <div class="panel panel-default">
        <div class="panel-heading">Assign New Machine</div>
        <div class="panel-collapse">
            <div class="panel-body">

                <!--<form class="form-horizontal">-->

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3 required">Version</label>
                        <div class="col-sm-9">
                            <select class="form-control" id='version_assign' name='version_assign' required='true' data-parsley-required-message="Please Select Machine Version">
                                <option value=''>Select Version</option>
                                <?php
                                foreach ($versionListAssign as $versionDataAssign) {
                                    echo "<option value='" . $versionDataAssign['version_id'] . "' >" . $versionDataAssign['version_name'] . "</option>";
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
                            <select class="form-control" id='sr_number_assign' name='sr_number_assign' required='true' data-parsley-required-message="Please Select Serial Number">
                                <option value=''> Select Serial Number</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3">GEN</label>
                        <div class="col-sm-9">
                            <span id='gen_assign' name='gen_assign'>-- N/A --</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3">Hot/Cold</label>
                        <div class="col-sm-9">
                            <span id='hot_cold_assign' name='hot_cold_assign'>-- N/A --</span>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3">MPR</label>
                        <div class="col-sm-9">
                            <span id='mpr_assign' name='mpr_assign'>-- N/A --</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3">Machine Abb</label>
                        <div class="col-sm-9">
                            <span id='machine_abb_assign' name='machine_abb_assign'>-- N/A --</span>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3">BevType</label>
                        <div class="col-sm-9">
                            <span id='bev_type_assign' name='bev_type_assign'>-- N/A --</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3">Assets Number</label>
                        <div class="col-sm-9">
                            <span id='assets_assign' name='assets_assign'>-- N/A --</span>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3">BMB</label>
                        <div class="col-sm-9">
                            <span id='bmb_assign' name='bmb_assign'>-- N/A --</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3">Technical Status</label>
                        <div class="col-sm-9">
                            <span id='tech_status_assign' name='tech_status_assign'>-- N/A --</span>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3">Sap Purchase Date</label>
                        <div class="col-sm-9">
                            <span id='sap_purchase_date_assign' name='sap_purchase_date_assign'>-- N/A --</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3">TA Depc. Date</label>
                        <div class="col-sm-9">
                            <span id='ta_depc_date_assign' name='ta_depc_date_assign'>-- N/A --</span>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3">Last PM</label>
                        <div class="col-sm-9">
                            <span id='last_pm_assign' name='last_pm_assign'>-- N/A --</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3">Days Till Last PM</label>
                        <div class="col-sm-9">
                            <span id='days_till_last_pm_assign' name='days_till_last_pm_assign'>-- N/A --</span>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>
                
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3 required">Installation Date</label>
                        <div class="col-sm-9">
                            <div class="input-group" id='installation_date_assign'>
                                <input type="text" class="form-control" placeholder="MM/DD/YYYY" name='installation_date_assign' value="" required='true' data-parsley-required-message="Please Enter Installation Date" >
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
                            <select class="form-control" id='zone_assign' name='zone_assign' required='true' data-parsley-required-message="Please Select Zone">
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
                            <textarea class="form-control" rows="3" id="machine_installed_location_assign" name='machine_installed_location_assign' placeholder="Enter Machine Installed Location" required='true' data-parsley-required-message="Please Enter Machine Installed Location"><?php echo set_value('machine_installed_location', (isset($editMachineSpecialNote) ? $editMachineSpecialNote : '')) ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3 required">Serving Size</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="serving_size_assign" name='serving_size_assign' required="true" data-parsley-required-message="Please Select Serving Size">
                                <option value=''>Select Serving Size</option>
                                <?php
                                foreach ($servingSize as $serving_size) {

                                    echo "<option value='" . $serving_size['code_id'] . "' " . set_select('serving_size_assign', (isset($editServingSize) ? $editServingSize : ''), $serving_size['code_id'] == (isset($editServingSize) ? $editServingSize : '')) . ">" . $serving_size['code_name'] . "</option>";
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
                            <textarea class="form-control" rows="3" id="machine_comment_assign" name='machine_comment_assign' placeholder="Enter Special Note"><?php echo set_value('machine_comment', (isset($editMachineSpecialNote) ? $editMachineSpecialNote : '')) ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#installation_date_assign').datetimepicker({format: 'L'});
    });
</script>