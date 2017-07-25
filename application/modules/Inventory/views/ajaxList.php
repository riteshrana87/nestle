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
                if (isset($sortfield) && $sortfield == 'version_name') {
                    if ($sortby == 'asc') {
                        echo "class = 'sort-desc'";
                    } else {
                        echo "class = 'sort-asc'";
                    }
                } else {
                    echo "class = 'sort'";
                }
                ?> onclick="apply_sorting('version_name', '<?php echo $sorttypepass; ?>')">Version Name</th>

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
                ?> onclick="apply_sorting('machine_serial_number', '<?php echo $sorttypepass; ?>')">Machine Sr Number</th>

                <th <?php
                if (isset($sortfield) && $sortfield == 'asset') {
                    if ($sortby == 'asc') {
                        echo "class = 'sort-desc'";
                    } else {
                        echo "class = 'sort-asc'";
                    }
                } else {
                    echo "class = 'sort'";
                }
                ?> onclick="apply_sorting('asset', '<?php echo $sorttypepass; ?>')">Asset Number</th>

                <th <?php
                if (isset($sortfield) && $sortfield == 'bmb') {
                    if ($sortby == 'asc') {
                        echo "class = 'sort-desc'";
                    } else {
                        echo "class = 'sort-asc'";
                    }
                } else {
                    echo "class = 'sort'";
                }
                ?> onclick="apply_sorting('bmb', '<?php echo $sorttypepass; ?>')">BMB</th>

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
                if (isset($sortfield) && $sortfield == 'machine_model_number') {
                    if ($sortby == 'asc') {
                        echo "class = 'sort-desc'";
                    } else {
                        echo "class = 'sort-asc'";
                    }
                } else {
                    echo "class = 'sort'";
                }
                ?> onclick="apply_sorting('machine_model_number', '<?php echo $sorttypepass; ?>')">Machine Model Number</th>

                <th <?php
                if (isset($sortfield) && $sortfield == 'machine_preaparation_date') {
                    if ($sortby == 'asc') {
                        echo "class = 'sort-desc'";
                    } else {
                        echo "class = 'sort-asc'";
                    }
                } else {
                    echo "class = 'sort'";
                }
                ?> onclick="apply_sorting('machine_preaparation_date', '<?php echo $sorttypepass; ?>')">Machine Preparation Date</th>

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

                <th class="text-center">Action</th>
        <input type="hidden" id="sortfield" name="sortfield" value="<?php if (isset($sortfield)) echo $sortfield; ?>" />
        <input type="hidden" id="sortby" name="sortby" value="<?php if (isset($sortby)) echo $sortby; ?>" />
        </tr>
        </thead>
        <tbody>
            <?php if (isset($listRecords) && count($listRecords) > 0) { ?>
                <?php foreach ($listRecords as $data) { ?>
                    <tr>
                        <td><?php echo $data['version_name'] ?></td>
                        <td><?php echo $data['machine_serial_number'] ?></td>
                        <td><?php echo $data['asset'] ?></td>
                        <td><?php echo $data['bmb'] ?></td>
                        <td><?php echo $data['machine_name'] ?></td>
                        <td><?php echo $data['machine_model_number'] ?></td>
                        <td><?php echo $data['machine_preaparation_date'] ?></td>
                        <td><?php echo $data['code_name'] ?></td>
                        <td class="text-center" width="11%">
                    <?php if(checkPermission('Inventory','edit')){ ?>
                            <a class="btn btn-link" title="Edit" href="<?php echo base_url('Inventory/edit/' . $data['inventory_id']) ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                        <?php } ?>
                    <?php if(checkPermission('Inventory','delete')){ ?>
                            <a class="btn btn-link" title="Delete" id='delete' name='delete' onclick="return delete_inventory(<?php echo $data['inventory_id'] ?>, $(this));"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                        <?php } ?>

                            <?php /* <a class="btn btn-link" title="Mark as Active" id='version_status' name='version_status' href="javascript:void(0);" onclick='return changeStatus("<?php echo $data['version_id'] ?>", "<?php echo $data['version_isactive'] ?>");'><i class="fa fa-plus-square-o" aria-hidden="true"></i></a>

                              <a class="btn btn-link" title="Add"><i class="fa fa-plus-square-o" aria-hidden="true"></i></a>
                              <a class="btn btn-link" title="View"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
                              <a class="btn btn-link" title="Delete" id='delete' name='delete' onclick="return delete_version('1');"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                              <a class="btn btn-link" title="Upload"><i class="fa fa-upload" aria-hidden="true"></i></a> */ ?>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="9" class="text-center"><?= lang('common_no_record_found') ?></td>
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