<?php
defined('BASEPATH') OR exit('No direct script access allowed')
?>
<script>
    var getSelectedVersionDataURL = "<?php echo base_url('Inventory/getSelectedVersionData'); ?>";
    var checkSerialNumberUniqueURL = "<?php echo base_url('Inventory/isDuplicateSerialNumber'); ?>";
    var inventory_id = "<?php echo ($screenType == 'edit') ? trim($editInventoryId) : '' ?> ";
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
                    <?php echo ($screenType == 'edit') ? $this->lang->line('header_edit_machine') : $this->lang->line('btn_machine_inventory') ?> 
                </h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php echo $this->lang->line('header_machine_information'); ?> 
                    </div>
                    <div class="panel-body"> 
                        <?php
                        $attributes = array("name" => "inventory_add_edit", "id" => "inventory_add_edit", "data-parsley-validate" => "", "class" => "form-horizontal", 'novalidate' => '');
                        echo form_open_multipart($form_action_path, $attributes);
                        ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3 required"><?= $this->lang->line('label_machine_version'); ?></label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id='version' name='version' required='true' data-parsley-required-message="Please Select Machine Version">
                                            <option value=''><?= $this->lang->line('label_select_version'); ?></option>
                                            <?php
                                            foreach ($versionList as $versionData) {
                                                echo "<option value='" . $versionData['version_id'] . "' " . set_select('version', $editVersionId, $versionData['version_id'] == $editVersionId) . ">" . $versionData['version_name'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3"><?= $this->lang->line('label_machine_hot_cold'); ?></label>
                                    <div class="col-sm-9">
                                        <span id='hot_cold' name='hot_cold'>-- N/A --</span>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3"><?= $this->lang->line('label_machine_gen'); ?></label>
                                    <div class="col-sm-9">
                                        <span id='gen' name='gen'>-- N/A --</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3"><?= $this->lang->line('label_machine_machine_abb'); ?></label>
                                    <div class="col-sm-9">
                                        <span id='machine_abb' name='machine_abb'>-- N/A --</span>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3"><?= $this->lang->line('label_machine_mpr'); ?></label>
                                    <div class="col-sm-9">
                                        <span id='mpr' name='mpr'>-- N/A --</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3"><?= $this->lang->line('label_machine_bev_type'); ?></label>
                                    <div class="col-sm-9">
                                        <span id='bev_type' name='bev_type'>-- N/A --</span>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3 required"><?= $this->lang->line('label_machine_sr_number'); ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" id='machine_sr_number' name='machine_sr_number' class="form-control" placeholder="Enter Machine Serial Number" value="<?php echo set_value('machine_sr_number', (isset($editMachineSrNumber)) ? $editMachineSrNumber : ''); ?>" required='true' data-parsley-required-message="Please Enter Machine Serial Number" data-parsley-maxlength="11" data-parsley-maxlength-message ='Max. 11 Characters are allowed.' data-parsley-trigger="keyup" data-parsley-machine_sr_number />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3 required"><?= $this->lang->line('label_machine_assets'); ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" id='assets' name='assets'  class="form-control" placeholder="Enter Asset Number" value="<?php echo set_value('assets', (isset($editMachineAsset)) ? $editMachineAsset : ''); ?>" required='true' data-parsley-required-message="Please Enter Asset Number" data-parsley-type="digits" data-parsley-type-message="Only digits are allowed" data-parsley-maxlength="11" data-parsley-maxlength-message ='Max. 11 Characters are allowed.' data-parsley-trigger="keyup"/>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3 required"><?= $this->lang->line('label_machine_bmb'); ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" id='bmb' name='bmb' class="form-control" placeholder="Enter BMB" value="<?php echo set_value('bmb', (isset($editMachinebmb)) ? $editMachinebmb : ''); ?>" required='true' data-parsley-required-message="Please Enter BMB" data-parsley-type="digits" data-parsley-type-message="Only digits are allowed" data-parsley-maxlength="5" data-parsley-maxlength-message ='Max. 5 digits are allowed.' data-parsley-trigger="keyup" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3 required"><?= $this->lang->line('label_machine_id'); ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" id='machine_id' name='machine_id' class="form-control" placeholder="Enter Machine ID" value="<?php echo set_value('machine_id', (isset($editMachineId)) ? $editMachineId : ''); ?>" required='true' data-parsley-required-message="Please Enter Machine Id" data-parsley-maxlength="12" data-parsley-maxlength-message ='Max. 12 Characters are allowed.' data-parsley-trigger="keyup"/>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3 required"><?= $this->lang->line('label_machine_tag_number'); ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" id='machine_tag_number' name='machine_tag_number' class="form-control" placeholder="Enter Machine Tag Number" value="<?php echo set_value('machine_tag_number', (isset($editMachineTagNumber)) ? $editMachineTagNumber : ''); ?>" required='true' data-parsley-required-message="Please Enter Machine Tag Number" data-parsley-maxlength="15" data-parsley-maxlength-message ='Max. 15 Characters are allowed.' data-parsley-trigger="keyup"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3 required"><?= $this->lang->line('label_machine_model_number'); ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" id='machine_model_number' name='machine_model_number' class="form-control" placeholder="Enter Machine Model Number" value="<?php echo set_value('machine_model_number', (isset($editMachineModelNumber)) ? $editMachineModelNumber : ''); ?>" required='true' data-parsley-required-message="Please Enter Machine Model Number" data-parsley-maxlength="15" data-parsley-maxlength-message ='Max. 15 Characters are allowed.' data-parsley-trigger="keyup"/>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3 required"><?= $this->lang->line('label_machine_name'); ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" id='machine_name' name='machine_name' class="form-control" placeholder="Enter Machine Name" value="<?php echo set_value('machine_name', (isset($editMachineName) ? $editMachineName : '')); ?>" required='true' data-parsley-required-message="Please Enter Machine Name" data-parsley-maxlength="100" data-parsley-maxlength-message ='Max. 100 Characters are allowed.' data-parsley-trigger="keyup"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3 required"><?= $this->lang->line('label_machine_manufacturing_year'); ?></label>
                                    <div class="col-sm-9">
                                        <select class="form-control"id='machine_manufacturing_year' name='machine_manufacturing_year' required='true' data-parsley-required-message="Please Select Machine Manufacturing Year">
                                            <option value=''>Select Manufacturing Year</option>
                                            <?php
                                            foreach ($manufacturing_year as $m_year) {
                                                //echo '<option value="' . $m_year . '">' . $m_year . '</option>';
                                                echo "<option value='" . $m_year . "' " . set_select('machine_manufacturing_year', (isset($editMachineManufacturingYear) ? $editMachineManufacturingYear : ''), $m_year == (isset($editMachineManufacturingYear) ? $editMachineManufacturingYear : '' )) . ">" . $m_year . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3 required"><?= $this->lang->line('label_machine_end_of_life'); ?></label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id='machine_end_of_life' name='machine_end_of_life' required='true' data-parsley-required-message="Please Select Machine End Of Life">
                                            <option value=''>Select Machine End Of Life</option>
                                            <?php
                                            foreach ($end_of_life as $eol_year) {
                                                echo "<option value='" . $eol_year . "' " . set_select('machine_end_of_life', (isset($editMachineEndOfLife) ? $editMachineEndOfLife : ''), $eol_year == (isset($editMachineEndOfLife) ? $editMachineEndOfLife : '')) . ">" . $eol_year . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3 required"><?= $this->lang->line('label_machine_location'); ?></label>
                                    <div class="col-sm-9">
                                        <textarea id="machine_location" name="machine_location" class="form-control" placeholder="Enter Machine Location" required='true' data-parsley-required-message="Please Enter Machine Location"><?= set_value('machine_location', (isset($editMachineLocation) ? $editMachineLocation : '')) ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3 required"><?= $this->lang->line('label_machine_tech_status'); ?></label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id='tech_status' name='tech_status' required='true' data-parsley-required-message="Please Select Machine Version" required='true' data-parsley-required-message="Please Enter Technical Status">
                                            <option value=''>Select Technical Status</option>
                                            <?php
                                            foreach ($technicalStatusDrpdown as $techStatusData) {
                                                echo "<option value='" . $techStatusData['code_id'] . "' " . set_select('tech_status', $editMachineTechnicalStatus, $techStatusData['code_id'] == $editMachineTechnicalStatus) . ">" . $techStatusData['code_name'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!--<div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3 required"><?= $this->lang->line('label_machine_tech_sap_purchase_date'); ?></label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input type="text" id='sap_purchase_date' name='sap_purchase_date' class="form-control" placeholder="DD/MM/YYYY" value="<?php echo set_value('sap_purchase_date', (isset($editMachineSapPurchaseDate)) ? $editMachineSapPurchaseDate : ''); ?>" required='true' data-parsley-required-message="Please Enter Sap Purchase Date" readonly='true' >
                                            <div class="input-group-btn">
                                                <button class="btn btn-default" type="button">
                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>-->

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3 required"><?= $this->lang->line('label_machine_tech_sap_purchase_date'); ?></label>
                                    <div class="col-sm-9">
                                        <div class="input-group" id='sap_purchase_date'>
                                            <input type="text" class="form-control" placeholder="MM/DD/YYYY" name='sap_purchase_date' value="<?php echo set_value('sap_purchase_date', (isset($editMachineSapPurchaseDate) ? $editMachineSapPurchaseDate : '')) ?>" required='true' data-parsley-required-message="Please Enter Sap Purchase Date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <!--<div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3 required"><?= $this->lang->line('label_machine_ta_depc_date'); ?></label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input type="text" id='ta_depc_date' name='ta_depc_date' class="form-control" placeholder="DD/MM/YYYY" value="<?php echo set_value('ta_depc_date', (isset($editMachineTaDepcDate)) ? $editMachineTaDepcDate : ''); ?>" required='true' data-parsley-required-message="Please Enter TA Depc. Date" readonly='true' >
                                            <div class="input-group-btn">
                                                <button class="btn btn-default" type="button">
                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>-->

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3 required"><?= $this->lang->line('label_machine_ta_depc_date'); ?></label>
                                    <div class="col-sm-9">
                                        <div class="input-group" id='ta_depc_date'>
                                            <input type="text" id='ta_depc_date' name='ta_depc_date' class="form-control" placeholder="MM/DD/YYYY" value="<?php echo set_value('ta_depc_date', (isset($editMachineTaDepcDate)) ? $editMachineTaDepcDate : ''); ?>" required='true' data-parsley-required-message="Please Enter TA Depc. Date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--<div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3 required"><?= $this->lang->line('label_machine_machine_preparation_date'); ?></label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="DD/MM/YYYY" value="<?php echo set_value('machine_preparation_date', (isset($editMachinePreparationDate)) ? $editMachinePreparationDate : ''); ?>" id='machine_preparation_date' name='machine_preparation_date' required='true' data-parsley-required-message="Please Enter Machine Preparation Date" readonly='true'>
                                            <div class="input-group-btn">
                                                <button class="btn btn-default" type="button">
                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3 required"><?= $this->lang->line('label_machine_machine_preparation_date'); ?></label>
                                    <div class="col-sm-9">
                                        <div class="input-group" id='machine_preparation_date'>
                                            <input type="text" class="form-control" placeholder="MM/DD/YYYY" value="<?php echo set_value('machine_preparation_date', (isset($editMachinePreparationDate)) ? $editMachinePreparationDate : ''); ?>"  name='machine_preparation_date' required='true' data-parsley-required-message="Please Enter Machine Preparation Date" >
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <!--<div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3 required"><?= $this->lang->line('label_machine_inst_date'); ?></label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input type="text" id='inst_date' name='inst_date' class="form-control" placeholder="DD/MM/YYYY" value="<?php echo set_value('inst_date', (isset($editMachineInstallationDate)) ? $editMachineInstallationDate : ''); ?>" required='true' data-parsley-required-message="Please Enter Installation Date" readonly='true'>
                                            <div class="input-group-btn">
                                                <button class="btn btn-default" type="button">
                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3 required"><?= $this->lang->line('label_machine_inst_date'); ?></label>
                                    <div class="col-sm-9">
                                        <div class="input-group" id='inst_date'>
                                            <input type="text"  name='inst_date' class="form-control" placeholder="MM/DD/YYYY" value="<?php echo set_value('inst_date', (isset($editMachineInstallationDate)) ? $editMachineInstallationDate : ''); ?>" required='true' data-parsley-required-message="Please Enter Installation Date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3 required"><?= $this->lang->line('label_machine_status'); ?></label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id='status' name='status' required='true' data-parsley-required-message="Please Select Status">
                                            <option value=''>Select Status</option>
                                            <?php
                                            foreach ($statusDrpdown as $statusData) {
                                                echo "<option value='" . $statusData['code_id'] . "' " . set_select('status', (isset($editMachineStatusId) ? $editMachineStatusId : ''), $statusData['code_id'] == (isset($editMachineStatusId) ? $editMachineStatusId : '')) . ">" . $statusData['code_name'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3 required">Warehouse Location</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id='warehouse_location' name='warehouse_location' required='true' data-parsley-required-message="Please Select Warehouse">
                                            <option value=''>Select Warehouse</option>
                                            <?php
                                            foreach ($wareHouserLocationDrpdown as $wareHouserLocationData) {
                                                echo "<option value='" . $wareHouserLocationData['code_id'] . "' " . set_select('warehouse_location', (isset($editMachineWarehouseLocationId) ? $editMachineWarehouseLocationId : ''), $wareHouserLocationData['code_id'] == (isset($editMachineWarehouseLocationId) ? $editMachineWarehouseLocationId : '')) . ">" . $wareHouserLocationData['code_name'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 text-center">
                                <div class="bottom-buttons">
                                    <input class='btn btn-primary' type='submit' name='add_save' id='add_save' value='<?php echo ($screenType == 'edit') ? $this->lang->line('label_btn_update') : 'Save' ?>' />

                                    <a href="<?php echo base_url('Inventory') ?>" class="btn btn-default"><?= $this->lang->line('label_btn_cancel') ?></a>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>