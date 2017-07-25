<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>Auditor</th>
                <th>Feedback Date</th>
                <th>Customer Name</th>
                <th>Ticket Date</th>
                <th>Subject</th>
                <th>Ticket Number</th>
                <th>Phone Number</th>
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
                    <td><?php echo $data['auditor'] ?></td>
                    <td><?php echo $data['feedback_date'] ?></td>
                    <td><?php echo $data['customer_name'] ?></td>
                    <td><?php echo $data['ticket_date'] ?></td>
                    <td><?php echo $data['subject'] ?></td>
                    <td><?php echo $data['ticket_number'] ?></td>
                    <td><?php echo $data['phone_number'] ?></td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="7" class="text-center"><?= lang('common_no_record_found') ?></td>
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