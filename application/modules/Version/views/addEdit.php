<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script>
    var checkVersionNameUniqueURL = "<?php echo base_url('Version/isDuplicateVersionName'); ?>";
    var version_id = "<?php echo ($screenType == 'edit') ? trim($currentVersionId) : '' ?> ";
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
                <h1 class="page-head-line"><?php echo ($screenType == 'edit') ? 'Edit' : 'Add' ?>  Version</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Version
                    </div>
                    <div class="panel-body"> 
                        <?php
                        $attributes = array("name" => "version_add_edit", "id" => "version_add_edit", "data-parsley-validate" => "", "class" => "form-horizontal", 'novalidate' => '');
                        echo form_open_multipart($form_action_path, $attributes);
                        ?>
                      <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-3 required">Version</label>
                                <div class="col-sm-9">
                                    <input type="text" id='version' maxlength="255" name='version' class="form-control" placeholder="Enter Version" value="<?php echo set_value('version', (isset($editVersion)) ? $editVersion : ''); ?>" required='true' data-parsley-required-message="Please Enter Version" data-parsley-maxlength='255' data-parsley-maxlength-message="Max. 255 Characters are allowed" data-parsley-trigger="keyup" data-parsley-version />
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-3 required">Hot/Cold</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id='hot_cold' name='hot_cold' required='true' data-parsley-required-message="Please Select Hot/Cold">
                                        <option value=''>Select Hot/Cold</option>
                                        <?php
                                        foreach ($hot_cold_drpdwn_data as $hcData) {
                                            echo "<option value='" . $hcData['code_id'] . "' " . set_select('hot_cold', $editHotCold, $hcData['code_id'] == $editHotCold) . ">" . $hcData['code_name'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="clearfix"></div>
                        
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-3 required">GEN</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id='gen' name='gen' required='true' data-parsley-required-message="Please Select GEN">
                                        <option value=''>Select GEN</option>
                                        <?php
                                        foreach ($gen_drpdwn_data as $gData) {
                                            echo "<option value='" . $gData['code_id'] . "' " . set_select('gen', $editGen, $gData['code_id'] == $editGen) . ">" . $gData['code_name'] . "</option>";
                                        }
                                        ?>											
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-3 required">Machine Abb</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id='machine_abb' name='machine_abb' required='true' data-parsley-required-message="Please Select Machine Abb">
                                        <option value=''>Select Machine Abb</option>
                                        <?php
                                        foreach ($machine_abb_drpdwn_data as $mbData) {
                                            echo "<option value='" . $mbData['code_id'] . "' " . set_select('machine_abb', $editMachineAbb, $mbData['code_id'] == $editMachineAbb) . ">" . $mbData['code_name'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="clearfix"></div>
                        
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-3 required">MPR</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id='mpr' name='mpr' required='true' data-parsley-required-message="Please Select MPR">
                                        <option value="">Select MPR</option>
                                        <?php
                                        foreach ($machine_mpr_drpdwn_data as $mmData) {
                                            echo "<option value='" . $mmData['code_id'] . "' " . set_select('mpr', $editMachineMpr, $mmData['code_id'] == $editMachineMpr) . " >" . $mmData['code_name'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-3 required">BevType</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id='bev_type' name='bev_type' required='true' data-parsley-required-message="Please Select BevType">
                                        <option value="">Select BevType</option>
                                        <?php
                                        foreach ($bev_type_drpdwn_data as $btData) {
                                            echo "<option value='" . $btData['code_id'] . "' " . set_select('bev_type', $editBevType, $btData['code_id'] == $editBevType) . " >" . $btData['code_name'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="clearfix"></div>
                        
                        <div class="col-sm-12 text-center">
                            <div class="bottom-buttons">
                                <input class='btn btn-primary' type='submit' name='add_save' id='add_save' value='<?php echo ($screenType == 'edit') ? 'Update' : 'Save' ?>' />
                                
                                <a href="<?php echo base_url('Version') ?>" class="btn btn-default">Cancel</a>
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