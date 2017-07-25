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
                <th <?php if (isset($sortfield) && $sortfield == 'cat_name') {
    if ($sortby == 'asc') {
        echo "class = 'sort-desc'";
    } else {
        echo "class = 'sort-asc'";
    }
} else {
    echo "class = 'sort'";
} ?> onclick="apply_sorting('cat_name', '<?php echo $sorttypepass; ?>')">Ingredient Name</th>

                <th <?php if (isset($sortfield) && $sortfield == 'subcat_name') {
    if ($sortby == 'asc') {
        echo "class = 'sort-desc'";
    } else {
        echo "class = 'sort-asc'";
    }
} else {
    echo "class = 'sort'";
} ?> onclick="apply_sorting('subcat_name', '<?php echo $sorttypepass; ?>')">Type Name</th>

                <th <?php if (isset($sortfield) && $sortfield == 'price') {
                    if ($sortby == 'asc') {
                        echo "class = 'sort-desc'";
                    } else {
                        echo "class = 'sort-asc'";
                    }
                } else {
                    echo "class = 'sort'";
                } ?> onclick="apply_sorting('price', '<?php echo $sorttypepass; ?>')">Price</th>
                
                <th <?php if (isset($sortfield) && $sortfield == 'packaging') {
                    if ($sortby == 'asc') {
                        echo "class = 'sort-desc'";
                    } else {
                        echo "class = 'sort-asc'";
                    }
                } else {
                    echo "class = 'sort'";
                } ?> onclick="apply_sorting('packaging', '<?php echo $sorttypepass; ?>')">Packaging</th>
                
                <th <?php if (isset($sortfield) && $sortfield == 'created_date') {
                    if ($sortby == 'asc') {
                        echo "class = 'sort-desc'";
                    } else {
                        echo "class = 'sort-asc'";
                    }
                } else {
                    echo "class = 'sort'";
                } ?> onclick="apply_sorting('created_date', '<?php echo $sorttypepass; ?>')"> Created Date</th>

                <th <?php if (isset($sortfield) && $sortfield == 'status') {
                        if ($sortby == 'asc') {
                            echo "class = 'sort-desc'";
                        } else {
                            echo "class = 'sort-asc'";
                        }
                    } else {
                        echo "class = 'sort'";
                    } ?> tabindex="0" aria-controls="example1" rowspan="1" colspan="1" onclick="apply_sorting('status', '<?php echo $sorttypepass; ?>')">  <?= lang('status') ?></th>
                <th><?= lang('actions') ?></th>
        <input type="hidden" id="sortfield" name="sortfield" value="<?php if (isset($sortfield)) echo $sortfield; ?>" />       <input type="hidden" id="sortby" name="sortby" value="<?php if (isset($sortby)) echo $sortby; ?>" />
        </tr>
        </thead>
        <tbody>
            <tr>
        <?php if (isset($information) && count($information) > 0) { ?>
        <?php
        foreach ($information as $data) {
            if ($data['status'] == 'active') {
                $data['status'] = lang('active');
            } else {
                $data['status'] = lang('inactive');
            }
            ?>
                    <tr>
                        <td><?php echo $data['cat_name']; ?></td>
                        <td><?php echo $data['subcat_name']; ?></td>
                        <td><?php echo $data['price']; ?></td>
                        <td><?php echo $data['packaging']; ?></td>
                        <td><?php echo date("Y-m-d", strtotime($data['created_date'])); ?>  </td>
                        <td><?php echo $data['status']; ?></td>
                        <td class="text-center">
        <?php /* if(checkPermission('IngredientItems','view')){ ?>
          <a class="btn btn-link" href="<?php echo base_url($crnt_view.'/view/'.$data['subcat_id']);?>" title="<?= lang('view')?>" >
          <i class="fa fa-file-text-o" aria-hidden="true"></i>
          </a>
          <?php } */ ?>
        <?php if (checkPermission('IngredientType', 'edit')) { ?>
                                <a class="btn btn-link" href="<?php echo base_url($crnt_view . '/edit/' . $data['subcat_id']); ?>" title="<?= lang('edit') ?>">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </a>
        <?php } ?>
        <?php if (checkPermission("IngredientType", "delete")) { ?><a class="btn btn-link" data-href="javascript:;" title="<?= lang('delete') ?>" onclick="delete_request(<?php echo $data['subcat_id']; ?>);" ><i class="fa fa-trash-o" aria-hidden="true"></i></a><?php } ?></td>
                    </tr>
    <?php } ?>
<?php } else { ?>
                <tr>
                    <td colspan="6" class="text-center"><?= lang('common_no_record_found') ?></td>
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