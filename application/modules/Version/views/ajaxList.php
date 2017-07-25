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
                if (isset($sortfield) && $sortfield == 'hot_cold_name') {
                    if ($sortby == 'asc') {
                        echo "class = 'sort-desc'";
                    } else {
                        echo "class = 'sort-asc'";
                    }
                } else {
                    echo "class = 'sort'";
                }
                ?> onclick="apply_sorting('hot_cold_name', '<?php echo $sorttypepass; ?>')">Hot/Cold</th>
                <th <?php
                if (isset($sortfield) && $sortfield == 'gen_name') {
                    if ($sortby == 'asc') {
                        echo "class = 'sort-desc'";
                    } else {
                        echo "class = 'sort-asc'";
                    }
                } else {
                    echo "class = 'sort'";
                }
                ?> onclick="apply_sorting('gen_name', '<?php echo $sorttypepass; ?>')">GEN</th>
                <th <?php
                if (isset($sortfield) && $sortfield == 'machine_abb_name') {
                    if ($sortby == 'asc') {
                        echo "class = 'sort-desc'";
                    } else {
                        echo "class = 'sort-asc'";
                    }
                } else {
                    echo "class = 'sort'";
                }
                ?> onclick="apply_sorting('machine_abb_name', '<?php echo $sorttypepass; ?>')">Machine Abb</th>
                <th <?php
                if (isset($sortfield) && $sortfield == 'machine_mpr_name') {
                    if ($sortby == 'asc') {
                        echo "class = 'sort-desc'";
                    } else {
                        echo "class = 'sort-asc'";
                    }
                } else {
                    echo "class = 'sort'";
                }
                ?> onclick="apply_sorting('machine_mpr_name', '<?php echo $sorttypepass; ?>')">MPR</th>
                <th <?php
                if (isset($sortfield) && $sortfield == 'bev_type_name') {
                    if ($sortby == 'asc') {
                        echo "class = 'sort-desc'";
                    } else {
                        echo "class = 'sort-asc'";
                    }
                } else {
                    echo "class = 'sort'";
                }
                ?> onclick="apply_sorting('bev_type_name', '<?php echo $sorttypepass; ?>')">BevType</th>
                <th> Action</th>
        <input type="hidden" id="sortfield" name="sortfield" value="<?php if (isset($sortfield)) echo $sortfield; ?>" />
        <input type="hidden" id="sortby" name="sortby" value="<?php if (isset($sortby)) echo $sortby; ?>" />
        </tr>
        </thead>
        <tbody>
            <?php if (isset($listRecords) && count($listRecords) > 0) { ?>
                <?php foreach ($listRecords as $data) { ?>
                    <tr>
                        <td><?php echo $data['version_name'] ?></td>
                        <td><?php echo $data['hot_cold_name'] ?></td>
                        <td><?php echo $data['gen_name'] ?></td>
                        <td><?php echo $data['machine_abb_name'] ?></td>
                        <td><?php echo $data['machine_mpr_name'] ?></td>
                        <td><?php echo $data['bev_type_name'] ?></td>
                        <td class="text-center">
                    <?php if(checkPermission('Version','edit')){ ?>
                            <a class="btn btn-link" title="Edit" href="<?php echo base_url('Version/edit/' . $data['version_id']) ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
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