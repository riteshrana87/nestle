<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>Collection Order Id</th>
                <th>Contact Name</th>
                <th>Contact Number</th>
                <th>Collection Date Time</th>
                <th>Last Due Date Time</th>
                <th>Collection Order Status</th>
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
                    <td><?php echo $data['collection_order_id'] ?></td>
                    <td><?php echo $data['contact_person'] ?></td>
                    <td><?php echo $data['contact_number'] ?></td>
                    <td><?php echo $data['co_date_time']; ?></td>
                    <td><?php echo $data['last_due_date_time']; ?></td>
                    <td><?php echo $data['co_status']; ?></td>
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