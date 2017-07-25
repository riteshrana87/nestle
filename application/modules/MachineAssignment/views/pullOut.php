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
                            <select class="form-control" id='version_pullout' name='version_pullout' required='true' data-parsley-required-message="Please Select Machine Version">
                                <option value=''>Select Version</option>
                                <?php
                                foreach ($versionList as $versionData) {
                                    echo "<option value='" . $versionData['version_id'] . "' >" . $versionData['version_name'] . "</option>";
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
                            <select class="form-control" id='sr_number_pullout' name='sr_number_pullout' required='true' data-parsley-required-message="Please Select Serial Number">
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

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3 ">Installation Date</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span id='installation_date' name='installation_date'>-- N/A --</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3">Zone</label>
                        <div class="col-sm-9">
                            <span id='zone' name='zone'>-- N/A --</span>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3">Machine Installed Location</label>
                        <div class="col-sm-9">
                            <span id='machine_installed_location' name='machine_installed_location'>-- N/A --</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3">Serving Size</label>
                        <div class="col-sm-9">
                            <span id='serving_size' name='serving_size'>-- N/A --</span>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3">Machine Picture</label>
                        <div class="col-sm-9 image_part file-uploader m-b-15" >
                            <span id='machine_picture' name='machine_picture'>-- N/A --</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <label class="control-label col-sm-3">Machine Menu File</label>
                    <div class="col-sm-9 image_part file-uploader" >
                        <span id='machine_menu_file' name='machine_menu_file'>-- N/A --</span>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3">Special Note</label>
                        <div class="col-sm-9">
                            <span id='special_note' name='special_note'>-- N/A --</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-3 required">Pullout Location</label>
                        <div class="col-sm-9">
                            <select name='pullout_location' id='pullout_location' class="form-control" required="true" data-parsley-required-message="Please Select Pullout Location">
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
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>