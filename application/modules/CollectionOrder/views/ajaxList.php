<?php
//pr($listRecords);exit;
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
                if (isset($sortfield) && $sortfield == 'Collection Order Id') {
                    if ($sortby == 'asc') {
                        echo "class = 'sort-desc'";
                    } else {
                        echo "class = 'sort-asc'";
                    }
                } else {
                    echo "class = 'sort'";
                }
                ?> onclick="apply_sorting('collection_order_id', '<?php echo $sorttypepass; ?>')">Collection Order Id</th>
                <th <?php
                if (isset($sortfield) && $sortfield == 'contact_person') {
                    if ($sortby == 'asc') {
                        echo "class = 'sort-desc'";
                    } else {
                        echo "class = 'sort-asc'";
                    }
                } else {
                    echo "class = 'sort'";
                }
                ?> onclick="apply_sorting('contact_person', '<?php echo $sorttypepass; ?>')">Contact Person</th>

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
                ?> onclick="apply_sorting('contact_number', '<?php echo $sorttypepass; ?>')">Contact Number</th>

                <?php 
                /*<th <?php
                if (isset($sortfield) && $sortfield == 'sales_representative') {
                    if ($sortby == 'asc') {
                        echo "class = 'sort-desc'";
                    } else {
                        echo "class = 'sort-asc'";
                    }
                } else {
                    echo "class = 'sort'";
                }
                ?> onclick="apply_sorting('sales_representative', '<?php echo $sorttypepass; ?>')">Sales Representative</th>
                 */ ?>
                
                <th <?php
                if (isset($sortfield) && $sortfield == 'co_date_time') {
                    if ($sortby == 'asc') {
                        echo "class = 'sort-desc'";
                    } else {
                        echo "class = 'sort-asc'";
                    }
                } else {
                    echo "class = 'sort'";
                }
                ?> onclick="apply_sorting('co_date_time', '<?php echo $sorttypepass; ?>')">Collection Date Time</th>
                
                <th <?php
                if (isset($sortfield) && $sortfield == 'last_due_date_time') {
                    if ($sortby == 'asc') {
                        echo "class = 'sort-desc'";
                    } else {
                        echo "class = 'sort-asc'";
                    }
                } else {
                    echo "class = 'sort'";
                }
                ?> onclick="apply_sorting('last_due_date_time', '<?php echo $sorttypepass; ?>')">Last Due Date Time</th>

                <th <?php
                if (isset($sortfield) && $sortfield == 'co_status') {
                    if ($sortby == 'asc') {
                        echo "class = 'sort-desc'";
                    } else {
                        echo "class = 'sort-asc'";
                    }
                } else {
                    echo "class = 'sort'";
                }
                ?> onclick="apply_sorting('co_status', '<?php echo $sorttypepass; ?>')">Collection Order Status</th>

                <th class="text-center">Action</th>
        <input type="hidden" id="sortfield" name="sortfield" value="<?php if (isset($sortfield)) echo $sortfield; ?>" />
        <input type="hidden" id="sortby" name="sortby" value="<?php if (isset($sortby)) echo $sortby; ?>" />
        </tr>
        </thead>
        <tbody>
            <?php if (isset($listRecords) && count($listRecords) > 0) { ?>
                <?php foreach ($listRecords as $data) { ?>
                    <tr>
                        <td><?php echo $data['collection_order_id'] ?></td>
                        <td><?php echo $data['contact_person'] ?></td>
                        <td><?php echo $data['contact_number'] ?></td>
                        <?php /*<td><?php echo $data['sales_representative'] ?></td>*/ ?>
                        <td><?php echo $data['co_date_time'] ?></td>
                        <td><?php echo $data['last_due_date_time'] ?></td>
                        <td><?php echo $data['co_status'] ?></td>
                        <td class="text-center">
                    <?php if(checkPermission('CollectionOrder','edit')){ ?>
                            <a class="btn btn-link" title="Edit" href="<?php echo base_url($crnt_view.'/edit/' . $data['collection_id']) ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
                         <?php if(checkPermission("CollectionOrder","delete")){?>
                            <a class="btn btn-link" title="Delete" id='delete' name='delete' onclick="return delete_collection_order(<?php echo $data['collection_id'] ?>, $(this));"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                        <?php } ?>
                        </td>
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