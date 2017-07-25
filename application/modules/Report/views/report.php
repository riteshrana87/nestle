<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script>
    var showReportURL = "<?php echo base_url('Report/showReportList'); ?>";
    var downloadReportURL = "<?php echo base_url('Report/generateExcelFile'); ?>";
    //var downloadexcelURL = "<?php //echo base_url('Report/downloadExcelFile'); ?>";
    var generateExcelFileURL = "<?php echo base_url('Report/generateExcelFileUrl'); ?>";
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
                <h1 class="page-head-line">Reports</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Nestle Reports
                    </div>
                    <div class="panel-body">
                        <?php
                        $attributes = array("name" => "generate_report_form", "id" => "generate_report_form", "data-parsley-validate" => "", "class" => "form-horizontal", 'novalidate' => '');
                        echo form_open_multipart($form_action_path, $attributes);
                        ?>
                      <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-3 required">Start Date</label>
                                <div class="col-sm-9">
                                    <div class="input-group" id='start_date'>
                                        <input type="text" class="form-control" placeholder="MM/DD/YYYY" name='start_date' value="<?php echo set_value('start_date', (isset($editStartDate) ? $editStartDate : '')) ?>" required='true' data-parsley-required-message="Please Enter Start Date" >
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-3 required">End Date</label>
                                <div class="col-sm-9">
                                    <div class="input-group" id='end_date'>
                                        <input type="text" class="form-control" placeholder="MM/DD/YYYY" name='end_date' value="<?php echo set_value('end_date', (isset($editEndDate) ? $editEndDate : '')) ?>" required='true' data-parsley-required-message="Please Enter End Date" >
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-3 required">Report Type</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id='report_type' name='report_type' required='true' data-parsley-required-message="Please Select Report Type">
                                        <option value=''>Select Report Type</option>
                                        <?php
                                        foreach ($report_type as $report_key => $report_vlaue) {
                                            echo "<option value='" . $report_key . "' " . set_select('report_type', $editReportType, $report_key == $editReportType) . ">" . $report_vlaue . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6" style='display: none;' id='report_status_div'>
                            <div class="form-group">
                                <label class="control-label col-sm-3 required">Report Status</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id='report_status' name='report_status'>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-sm-12 text-center">
                            <div class="bottom-buttons">
                                <input class='btn btn-primary' type='submit' name='show_report' id='show_report' value='Show Report' />
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                      </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="whitebox" id="common_div">
        </div>
    </div>
</div>