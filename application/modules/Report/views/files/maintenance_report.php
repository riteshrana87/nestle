<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>Contact Name</th>
                <th>Contact Number</th>
                <th>Request Type</th>
                <th>Status</th>
                <th>Response Date</th>
                <th>Visited Date</th>
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
                    <td><?php echo $data['contact_person'] ?></td>
                    <td><?php echo $data['contact_number'] ?></td>
                    <td><?php echo $data['r_type'] ?></td>
                    <td><?php echo (!empty($data['code_name'])) ? $data['code_name'] : '---'; ?></td>
                    <td><?php echo (!empty($data['responase_date'])) ? $data['responase_date'] : '---'; ?></td>
                    <td><?php echo (!empty($data['visited_date'])) ? $data['visited_date'] : '---'; ?></td>
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