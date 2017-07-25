<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script>
    var getBothSelectBox = "<?php echo base_url('Zone/getBothSelectBox'); ?>";
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
                <h1 class="page-head-line">Zone Assignment</h1>
            </div>
        </div>
        <div class="row">
            <div id='flashMsg' name='flashMsg'></div>
            <?php echo $this->session->flashdata('msg'); ?>
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Zone Assignment
                    </div>
                    <div class="panel-body"> 
                        <?php
                        $attributes = array("name" => "zone_assignment", "id" => "zone_assignment", "data-parsley-validate" => "", "class" => "form-horizontal", 'novalidate' => '');
                        echo form_open_multipart($form_action_path, $attributes);
                        ?>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-3 required">Zone</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id='zone_list' name='zone_list' required='true' data-parsley-required-message="Please Select Zone">
                                        <option value=''>Select Zone</option>
                                        <?php
                                        foreach ($zoneList as $zoneData) {
                                            echo "<option value='" . $zoneData['id'] . "' " . set_select('zone', '') . ">" . $zoneData['name'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                      <div class="col-md-12">
                        <div class="row">
                          <div class="col-md-1"></div>
                          <div class="col-md-10">
                            <div class="row  row-eq-height p-lr-15">
                              <div class="col-sm-5">
                                <div class="form-group">
                                  <label class="control-label">List Of Customers</label>
                                  <select class="form-control m-h-250" multiple="multiple" id='lstBox1' name='lstBox1[]'>
                                  </select>
                                </div>
                              </div>
                              <div class="col-sm-2">
                                <div class="subject-info-arrows text-center">
                                  <div class="tc">
                                  <!--<input type='button' id='btnAllRight' value='>>' class="btn btn-default" /><br />-->
                                  <input type='button' id='btnRight' value='>>' class="btn btn-default" /><br />
                                  <input type='button' id='btnLeft' value='<<' class="btn btn-default" /><br />
                                  <!--<input type='button' id='btnAllLeft' value='<<' class="btn btn-default" />-->
                                  </div>
                                </div>
                              </div>
                              <div class='col-sm-5'>
                                <div class="form-group">
                                  <label class="control-label">Selected Customers</label>
                                  <select class="form-control m-h-250" multiple="multiple" id='lstBox2' name='lstBox2[]'>
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-1"></div>
                        </div>
                      </div>
                        <!--<div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label col-sm-3">List Of Customers</label>
                                <div class="col-sm-9">
                                    <select class="form-control" multiple="multiple" id='lstBox1' name='lstBox1[]'>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="subject-info-arrows text-center">
                                <input type='button' id='btnAllRight' value='>>' class="btn btn-default" /><br />
                                <input type='button' id='btnRight' value='>' class="btn btn-default" /><br />
                                <input type='button' id='btnLeft' value='<' class="btn btn-default" /><br />
                                <input type='button' id='btnAllLeft' value='<<' class="btn btn-default" />
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label col-sm-3">Selected Customers</label>
                                <div class="col-sm-9">
                                    <select class="form-control" multiple="multiple" id='lstBox2' name='lstBox2[]'>
                                    </select>
                                </div>
                            </div>
                        </div>-->
                        <input type="hidden" name="selectBox1" id="selectBox1" value=""/>
                        <input type="hidden" name="selectBox2" id="selectBox2" value=""/>

                        <div class="clearfix"></div>

                        <div class="col-sm-12 text-center">
                            <div class="bottom-buttons">
                                <input class='btn btn-primary' type='submit' name='add_save' id='add_save' value='Save' />  
                                <!--<a href="<?php echo base_url($crnt_view) ?>" class="btn btn-default">Cancel</a> -->
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>