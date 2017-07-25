<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>Customer Name</th>
                <th>Customer Code</th>
                <th>Version Name</th>
                <th>Serial Number</th>
                <th>Type</th>
                <th>Installed Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($listRecords) && count($listRecords) > 0) { ?>
                <tr colspan='6'> 
                    <div class="text-right m-b-10">
                        <input name="exportFile" id="exportFile" value="Download Excel File" style="" class="btn btn-primary" type="button">
                    </div>
                </tr>
                <?php foreach ($listRecords as $data) { ?>

                <tr>
                    <td><?php echo $data['customer_name'] ?></td>
                    <td><?php echo $data['customer_code'] ?></td>
                    <td><?php echo $data['version_name'] ?></td>
                    <td><?php echo $data['machine_serial_number'] ?></td>
                    <td><?php echo $data['machine_assign_type'] ?></td>
                    <td><?php echo $data['installation_date'] ?></td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="6" class="text-center"><?= lang('common_no_record_found') ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<div class="clearfix visible-xs-block"></div>
<div class="row" id="common_tb">
    <?php if (isset($pagination) && !empty($pagination)) { ?>
        <div class="col-sm-12">
            <?php echo $pagination; ?>
        </div>
    <?php } ?>
</div>