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
                if (isset($sortfield) && $sortfield == 'customer_code') {
                    if ($sortby == 'asc') {
                        echo "class = 'sort-desc'";
                    } else {
                        echo "class = 'sort-asc'";
                    }
                } else {
                    echo "class = 'sort'";
                }
                ?> onclick="apply_sorting('customer_code', '<?php echo $sorttypepass; ?>')">Customer code</th>

                <th <?php
                if (isset($sortfield) && $sortfield == 'version_name') {
                    if ($sortby == 'asc') {
                        echo "class = 'sort-desc'";
                    } else {
                        echo "class = 'sort-asc'";
                    }
                } else {
                    echo "class = 'sort'";
                }
                ?> onclick="apply_sorting('version_name', '<?php echo $sorttypepass; ?>')">Version Number</th>

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
                ?> onclick="apply_sorting('machine_serial_number', '<?php echo $sorttypepass; ?>')">Serial Number</th>

                <th <?php
                if (isset($sortfield) && $sortfield == 'machine_assign_type') {
                    if ($sortby == 'asc') {
                        echo "class = 'sort-desc'";
                    } else {
                        echo "class = 'sort-asc'";
                    }
                } else {
                    echo "class = 'sort'";
                }
                ?> onclick="apply_sorting('machine_assign_type', '<?php echo $sorttypepass; ?>')">Type</th>

                <th <?php
                if (isset($sortfield) && $sortfield == 'installation_date') {
                    if ($sortby == 'asc') {
                        echo "class = 'sort-desc'";
                    } else {
                        echo "class = 'sort-asc'";
                    }
                } else {
                    echo "class = 'sort'";
                }
                ?> onclick="apply_sorting('installation_date', '<?php echo $sorttypepass; ?>')">Installed Date</th>
                <th>Action</th>
        <input type="hidden" id="sortfield" name="sortfield" value="<?php if (isset($sortfield)) echo $sortfield; ?>" />
        <input type="hidden" id="sortby" name="sortby" value="<?php if (isset($sortby)) echo $sortby; ?>" />
        </tr>
        </thead>
        <tbody>
            <?php if (isset($listRecords) && count($listRecords) > 0) { ?>
                <?php foreach ($listRecords as $data) { ?>
                    <tr>
                        <td><?php echo $data['customer_name'] ?></td>
                        <td><?php echo $data['customer_code'] ?></td>
                        <td><?php echo $data['version_name'] ?></td>
                        <td><?php echo $data['machine_serial_number'] ?></td>
                        <td><?php echo $data['machine_assign_type'] ?></td>
                        <td><?php echo $data['installation_date'] ?></td>
                        <td class="text-center">
                            <?php if (checkPermission('MachineAssignment', 'edit')) { ?>
                                <?php //if (empty($data['sr_number_id']) || ($data['machine_assign_type']  == 'Pullout')) { ?>
                                    <a class="btn btn-link" title="Edit" href="<?php echo base_url($crnt_view . '/edit/' . $data['customer_machine_information_id']) ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                <?php //} ?>
                            <?php } ?>
                            <?php if (checkPermission('MachineAssignment', 'delete')) { ?>
                                <?php if (!empty($data['sr_number_id']) && $data['machine_assign_type']  == 'Installation') { ?>
                                <?php //if ($data['machine_assign_type']  == 'Installation') { ?>
                                    <a class="btn btn-link" title="Remove Assigned Machine" id='delete' name='delete' onclick="return delete_assign_machine(<?php echo $data['customer_machine_information_id'] ?>, '<?php echo $data['sr_number_id'] ?>', $(this));"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                <?php } ?>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="10" class="text-center"><?= lang('common_no_record_found') ?></td>
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