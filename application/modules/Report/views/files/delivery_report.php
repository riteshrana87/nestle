<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>Delivery Order Id</th>
                <th>Customer Name</th>
                <th>Contact Person</th>
                <th>Contact Number</th>
                <th>Total Amount</th>
                <th>Order Date</th>
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
                    <td><?php echo $data['delivery_order'] ?></td>
                    <td><?php echo $data['customer_name'] ?></td>
                    <td><?php echo $data['contact_name'] ?></td>
                    <td><?php echo $data['contact_number']; ?></td>
                    <td><?php echo $data['total_amount']; ?></td>
                    <td><?php echo $data['order_date']; ?></td>
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