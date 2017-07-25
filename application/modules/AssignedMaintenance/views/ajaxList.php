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
                if (isset($sortfield) && $sortfield == 'machine_name') {
                    if ($sortby == 'asc') {
                        echo "class = 'sort-desc'";
                    } else {
                        echo "class = 'sort-asc'";
                    }
                } else {
                    echo "class = 'sort'";
                }
                ?> onclick="apply_sorting('machine_name', '<?php echo $sorttypepass; ?>')">Machine Name</th>

                <th <?php
                if (isset($sortfield) && $sortfield == 'machine_id') {
                    if ($sortby == 'asc') {
                        echo "class = 'sort-desc'";
                    } else {
                        echo "class = 'sort-asc'";
                    }
                } else {
                    echo "class = 'sort'";
                }
                ?> onclick="apply_sorting('machine_id', '<?php echo $sorttypepass; ?>')">Machine id</th>

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
                ?> onclick="apply_sorting('machine_serial_number', '<?php echo $sorttypepass; ?>')">Machine Serial Number</th>

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
                if (isset($sortfield) && $sortfield == 'r_type') {
                    if ($sortby == 'asc') {
                        echo "class = 'sort-desc'";
                    } else {
                        echo "class = 'sort-asc'";
                    }
                } else {
                    echo "class = 'sort'";
                }
                ?> onclick="apply_sorting('r_type', '<?php echo $sorttypepass; ?>')">Request Type</th>

                <th <?php
                if (isset($sortfield) && $sortfield == 'code_name') {
                    if ($sortby == 'asc') {
                        echo "class = 'sort-desc'";
                    } else {
                        echo "class = 'sort-asc'";
                    }
                } else {
                    echo "class = 'sort'";
                }
                ?> onclick="apply_sorting('code_name', '<?php echo $sorttypepass; ?>')">Status</th>

                <th <?php
                if (isset($sortfield) && $sortfield == 'responase_date') {
                    if ($sortby == 'asc') {
                        echo "class = 'sort-desc'";
                    } else {
                        echo "class = 'sort-asc'";
                    }
                } else {
                    echo "class = 'sort'";
                }
                ?> onclick="apply_sorting('responase_date', '<?php echo $sorttypepass; ?>')">Response Date</th>

                <th <?php
                if (isset($sortfield) && $sortfield == 'visited_date') {
                    if ($sortby == 'asc') {
                        echo "class = 'sort-desc'";
                    } else {
                        echo "class = 'sort-asc'";
                    }
                } else {
                    echo "class = 'sort'";
                }
                ?> onclick="apply_sorting('visited_date', '<?php echo $sorttypepass; ?>')">Visited Date</th>

                <th <?php
                if (isset($sortfield) && $sortfield == 'updated_at') {
                    if ($sortby == 'asc') {
                        echo "class = 'sort-desc'";
                    } else {
                        echo "class = 'sort-asc'";
                    }
                } else {
                    echo "class = 'sort'";
                }
                ?> onclick="apply_sorting('updated_at', '<?php echo $sorttypepass; ?>')">Assigned Updated Date</th>

                <th class="text-center">Action</th>
        <input type="hidden" id="sortfield" name="sortfield" value="<?php if (isset($sortfield)) echo $sortfield; ?>" />
        <input type="hidden" id="sortby" name="sortby" value="<?php if (isset($sortby)) echo $sortby; ?>" />
        </tr>
        </thead>
        <tbody>
            <?php if (isset($listRecords) && count($listRecords) > 0) { ?>
                <?php foreach ($listRecords as $data) { ?>
                    <tr>
                        <td><?php echo $data['machine_name'] ?></td>
                        <td><?php echo $data['machine_id'] ?></td>
                        <td><?php echo $data['machine_serial_number'] ?></td>
                        <td><?php echo $data['contact_person'] ?></td>
                        <td><?php echo $data['contact_number'] ?></td>
                        <td><?php echo $data['r_type'] ?></td>
                        <td><?php echo (!empty($data['code_name'])) ? $data['code_name'] : '---'; ?></td>
                        <td><?php echo (!empty($data['responase_date'])) ? $data['responase_date'] : '---'; ?></td>
                        <td><?php echo (!empty($data['visited_date'])) ? $data['visited_date'] : '---'; ?></td>
                        <td><?php echo (!empty($data['updated_at'])) ? date('Y-m-d', strtotime($data['updated_at'])) : '---'; ?></td>
                        <td class="text-center" width="8%">
                            <?php if (checkPermission('AssignedMaintenance', 'edit')) { ?>
                                <a class="btn btn-link" title="Edit" href="<?php echo base_url($crnt_view . '/edit/' . $data['maintenance_id']) ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <?php } ?>
                            <?php if (checkPermission('AssignedMaintenance', 'delete')) { ?>
                                <a class="btn btn-link" title="Delete" id='delete' name='delete' onclick="return delete_collection_order(<?php echo $data['maintenance_id'] ?>, $(this));"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="11" class="text-center"><?= lang('common_no_record_found') ?></td>
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