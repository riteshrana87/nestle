<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (isset($sortby) && $sortby == 'asc') {
    $sorttypepass = 'desc';
} else {
    $sorttypepass = 'asc';
}
?>
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th <?php
                if (isset($sortfield) && $sortfield == 'delivery_order') {
                    if ($sortby == 'asc') {
                        echo "class = 'sort-desc'";
                    } else {
                        echo "class = 'sort-asc'";
                    }
                } else {
                    echo "class = 'sort'";
                }
                ?> onclick="apply_sorting('delivery_order', '<?php echo $sorttypepass; ?>')">Delivery Order Id</th>
                <th <?php
                if (isset($sortfield) && $sortfield == 'customer_name') {
                    if ($sortby == 'asc') {
                        echo "class = 'sort-desc'";
                    } else {
                        echo "class = 'sort-asc'";
                    }
                } else {
                    echo "class = 'sort'";
                }
                ?> onclick="apply_sorting('customer_name', '<?php echo $sorttypepass; ?>')">Customer Name</th>

                <th <?php
                if (isset($sortfield) && $sortfield == 'contact_name') {
                    if ($sortby == 'asc') {
                        echo "class = 'sort-desc'";
                    } else {
                        echo "class = 'sort-asc'";
                    }
                } else {
                    echo "class = 'sort'";
                }
                ?> onclick="apply_sorting('contact_name', '<?php echo $sorttypepass; ?>')">Contact Person</th>

                <th <?php
                if (isset($sortfield) && $sortfield == 'contact_number') {
                    if ($sortby == 'asc') {
                        echo "class = 'sort-desc'";
                    } else {
                        echo "class = 'sort-asc'";
                    }
                } else {
                    echo "class = 'sort'";
                }
                ?> onclick="apply_sorting('contact_number', '<?php echo $sorttypepass; ?>')"> Contact Number</th>

                <?php /* ?><th <?php if(isset($sortfield) && $sortfield == 'name'){if($sortby == 'asc'){echo "class = 'sort-desc'";}else{echo "class = 'sort-asc'";}}else{echo "class = 'sort'";} ?> onclick="apply_sorting('name','<?php echo $sorttypepass;?>')"> Payment Terms</th>
                  <?php */ ?>
                <th <?php
                if (isset($sortfield) && $sortfield == 'machine_serial_number') {
                    if ($sortby == 'asc') {
                        echo "class = 'sort-desc'";
                    } else {
                        echo "class = 'sort-asc'";
                    }
                } else {
                    echo "class = 'sort'";
                }
                ?> tabindex="0" aria-controls="example1" rowspan="1" colspan="1" onclick="apply_sorting('machine_serial_number', '<?php echo $sorttypepass; ?>')"> Machine Name </th>
                <th <?php
                if (isset($sortfield) && $sortfield == 'total_amount') {
                    if ($sortby == 'asc') {
                        echo "class = 'sort-desc'";
                    } else {
                        echo "class = 'sort-asc'";
                    }
                } else {
                    echo "class = 'sort'";
                }
                ?> onclick="apply_sorting('total_amount', '<?php echo $sorttypepass; ?>')"> Total Amount</th>

                <th <?php
                if (isset($sortfield) && $sortfield == 'order_date') {
                    if ($sortby == 'asc') {
                        echo "class = 'sort-desc'";
                    } else {
                        echo "class = 'sort-asc'";
                    }
                } else {
                    echo "class = 'sort'";
                }
                ?> onclick="apply_sorting('order_date', '<?php echo $sorttypepass; ?>')"> Order Date</th>
                
                <th <?php
                if (isset($sortfield) && $sortfield == 'delivery_status') {
                    if ($sortby == 'asc') {
                        echo "class = 'sort-desc'";
                    } else {
                        echo "class = 'sort-asc'";
                    }
                } else {
                    echo "class = 'sort'";
                }
                ?> onclick="apply_sorting('delivery_status', '<?php echo $sorttypepass; ?>')">Status</th>
                <th <?php
                if (isset($sortfield) && $sortfield == 'delivery_date') {
                    if ($sortby == 'asc') {
                        echo "class = 'sort-desc'";
                    } else {
                        echo "class = 'sort-asc'";
                    }
                } else {
                    echo "class = 'sort'";
                }
                ?> onclick="apply_sorting('delivery_date', '<?php echo $sorttypepass; ?>')">Delivery Date</th>

                <th><?= lang('actions') ?></th>
        <input type="hidden" id="sortfield" name="sortfield" value="<?php if (isset($sortfield)) echo $sortfield; ?>" />
        <input type="hidden" id="sortby" name="sortby" value="<?php if (isset($sortby)) echo $sortby; ?>" />
        </tr>
        </thead>
        <tbody>
            <tr>
                <?php if (isset($information) && count($information) > 0) { ?>
                    <?php foreach ($information as $data) { ?>
                    <tr>
                        <td><?php echo $data['delivery_order']; ?></td>
                        <td><?php echo $data['customer_name']; ?></td>
                        <td><?php echo $data['contact_name']; ?></td>
                        <td><?php echo $data['contact_number']; ?></td>
                        <td><?php echo $data['machine_serial_number']; ?></td>
                        <td><?php echo showTotaldata($data['delivery_order_id']); ?></td>
                        <td><?php echo $data['order_date']; ?></td>
                        <td><?php echo $data['d_status']; ?></td>
                        <td><?php echo (!empty($data['delivery_date']))? date('Y-m-d', strtotime($data['delivery_date'])):''; ?></td>
                        <td class="text-center">

                            <?php /* if(checkPermission('IngredientCategory','view')){ ?>
                              <a class="btn btn-link" href="<?php echo base_url($crnt_view.'/view/'.$data['cat_id']);?>" title="<?= lang('view')?>" >
                              <i class="fa fa-file-text-o" aria-hidden="true"></i>
                              </a>
                              <?php } */ ?>

                            <?php if (checkPermission('DeliveryOrderAssignment', 'edit')) { ?>
                                <a class="btn btn-link" href="<?php echo base_url($crnt_view . '/edit_record/' . $data['delivery_order_id']); ?>" title="Assignment">
                                    <i class="fa fa-reply-all fa-flip-horizontal" aria-hidden="true"></i>
                                </a>
                            <?php } ?>
                            <?php /* if(checkPermission("DeliveryOrder","delete")){?><a class="btn btn-link" data-href="javascript:;" title="<?= lang('delete')?>" onclick="delete_request(<?php echo $data['cat_id']; ?>);" ><i class="fa fa-trash-o" aria-hidden="true"></i></a><?php } */ ?>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="10" class="text-center"><?= lang('common_no_record_found') ?></td>
                </tr>
            <?php } ?>
            </tr>
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