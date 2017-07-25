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
                if (isset($sortfield) && $sortfield == 'collection_order_id') {
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

                <th <?php
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
                        <td><?php echo ucfirst($data['firstname'].' '.$data['lastname']) ?></td>
                        <td><?php echo $data['co_date_time'] ?></td>
                        <td><?php echo $data['last_due_date_time'] ?></td>
                        <td><?php echo $data['co_status'] ?></td>
                        <td class="text-center">
                    <?php if(checkPermission('CollectionOrderAssignment','edit')){ ?>
                            <a class="btn btn-link" title="Edit" href="<?php echo base_url($crnt_view.'/edit/' . $data['collection_id']) ?>"><i class="fa fa-reply-all fa-flip-horizontal" aria-hidden="true"></i></a>
                        <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="8" class="text-center"><?= lang('common_no_record_found') ?></td>
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