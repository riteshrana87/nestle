<?php
if (isset($editRecord) && $editRecord == "updatedata") {
    $record = "updatedata";
} else {
    $record = "insertdata";
}
?>
<script>
    var formAction = "<?php echo $record; ?>";
    var check_email_url = "<?php echo base_url('User/isDuplicateEmail'); ?>";
</script>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$formAction = !empty($editRecord) ? 'edit' : 'additems';
$path = $form_action_path;
if (isset($readonly)) {
    $disable = $readonly['disabled'];
} else {
    $disable = "";
}
$main_user_data = $this->session->userdata('LOGGED_IN');
$main_user_id = $main_user_data['ID'];
?>
<?php echo $this->session->flashdata('verify_msg'); ?>
<div class="content-wrapper">
    <div class="container">
        <div clas="row">
            <div class="col-md-12 error-list">
                <?= isset($validation) ? $validation : ''; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-head-line">
                    <?PHP if ($formAction == "additems") { ?>
                        <?= $this->lang->line('Add_Items'); ?>
                    <?php } elseif ($formAction == "edit" && !isset($readonly)) { ?>
                        <?= $this->lang->line('Update_Items') ?>
                    <?php } elseif (isset($readonly)) { ?>
                        <?= $this->lang->line('View_Items') ?>
                    <?php } ?>
                </h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?PHP if ($formAction == "additems") { ?>
                            <?= $this->lang->line('add_ingredient_type_title'); ?>
                        <?php } elseif ($formAction == "edit" && !isset($readonly)) { ?>
                            <?= $this->lang->line('add_ingredient_type_title') ?>
                        <?php } elseif (isset($readonly)) { ?>
                            <?= $this->lang->line('View_Items') ?>
                        <?php } ?>
                    </div>
                    <div class="panel-body">
                        <?php
                        $attributes = array("name" => "items", "id" => "items", "data-parsley-validate" => "", "class" => "form-horizontal");
                        echo form_open_multipart($path, $attributes);
                        ?>
                      <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="cat_id" class="control-label col-sm-3 required">Ingredient Name<?php if ($disable == "") { ?><?php } ?></label>
                                <div class="col-sm-9">
                                    <?php if ($disable == "") { ?>
                                        <?php if ($formAction == "edit") { ?>
                                            <select class="form-control chosen-select-ingredient" data-parsley-errors-container="#CAT_ID_error" name="cat_id" id="cat_id" required  <?php echo $disable; ?>>
                                                <option value="">
                                                    Ingredient Name
                                                </option>
                                                <?php if (isset($category_data) && count($category_data) > 0) { ?>
                                                    <?php
                                                    foreach ($category_data as $categorys_data) {
                                                        if ($categorys_data['cat_id'] == $editRecord[0]['cat_id']) {
                                                            $selected = 'selected="selected"';
                                                        } else {
                                                            $selected = '';
                                                        }
                                                        ?>
                                                        <option value="<?php echo $categorys_data['cat_id']; ?>" <?php echo $selected; ?> ><?php echo $categorys_data['cat_name']; ?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        <?php } else { ?>
                                            <select class="form-control chosen-select-ingredient" data-parsley-errors-container="#CAT_ID_error" name="cat_id"  id="cat_id" required  <?php echo $disable; ?>>
                                                <option value="">
                                                    Ingredient Name
                                                </option>
                                                <?php if (isset($category_data) && count($category_data) > 0) { ?>
                                                    <?php foreach ($category_data as $categorys_data) { ?>
                                                        <option value="<?php echo $categorys_data['cat_id']; ?>" ><?php echo $categorys_data['cat_name']; ?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <p><?php echo $categoryName; ?></p>
                                    <?php } ?>
                                    <span id="CAT_ID_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="subcat_name" class="control-label col-sm-3 required">Ingredient Type<?php if ($disable == "") { ?><?php } ?></label>
                                <div class="col-sm-9">
                                    <?php if ($disable == "") { ?>
                                        <input class="form-control" name="subcat_name" placeholder="Enter Ingredient Type" type="text" value="<?PHP
                                        if ($formAction == "additems") {
                                            echo set_value('subcat_name');
                                            ?><?php } else { ?><?= !empty($editRecord[0]['subcat_name']) ? $editRecord[0]['subcat_name'] : '' ?><?php } ?>"  required="" <?php echo $disable; ?> />
                                           <?php } else { ?>
                                        <p><?php echo $editRecord[0]['subcat_name']; ?></p>
                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="price" class="control-label col-sm-3 required">Price<?php if ($disable == "") { ?><?php } ?></label>
                                <div class="col-sm-9">
                                    <?php if ($disable == "") { ?>
                                        <input class="form-control" name="price" placeholder="Enter Price" type="text" value="<?PHP
                                        if ($formAction == "additems") {
                                            echo set_value('price');
                                            ?><?php } else { ?><?= !empty($editRecord[0]['price']) ? $editRecord[0]['price'] : '' ?><?php } ?>" data-parsley-pattern="^\d+(\.\d{1,2})?$" maxlength="10" required="" <?php echo $disable; ?> />
                                           <?php } else { ?>
                                        <p><?php echo $editRecord[0]['price']; ?></p>
                                    <?php } ?>

                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="price" class="control-label col-sm-3 required">Packaging<?php if ($disable == "") { ?><?php } ?></label>
                                <div class="col-sm-9">
                                    <?php if ($disable == "") { ?>
                                        <input class="form-control" id='packaging' name="packaging" placeholder="Enter Packaging" type="text" value="<?PHP echo set_value('packaging', (isset($editRecord[0]['packaging']) ? $editRecord[0]['packaging'] : '')) ?>" required="" data-parsley-maxlength="50" data-parsley-maxlength-message ='Max. 50 Characters are allowed.' <?php echo $disable; ?> />
                                    <?php } else { ?>
                                        <p><?php echo $editRecord[0]['packaging']; ?></p>
                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-3 required" for="status">
                                    Status
                                </label>
                                <div class="col-sm-9">
                                    <?php if ($disable == "") { ?>
                                        <select class="chosen-select-status form-control " data-parsley-errors-container="#STATUS_error" placeholder="Items Status"  name="status" id="status" required <?php echo $disable; ?> >
                                            <?php
                                            $options = array(array('s_status' => lang('active')), array('s_status' => lang('inactive')));
                                            if (isset($editRecord[0]['status']) && $editRecord[0]['status'] != "") {
                                                $selected = $editRecord[0]['status'];
                                            } else {
                                                $selected = lang('active');
                                            }
                                            ?>
                                            <?php
                                            foreach ($options as $rows) {
                                                if ($selected == $rows['s_status']) {
                                                    ?>
                                                    <option selected value="<?php echo $rows['s_status']; ?>"><?php echo $rows['s_status']; ?></option>
                                                <?php } else { ?>

                                                    <option value="<?php echo $rows['s_status']; ?>"><?php echo $rows['s_status']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    <?php } elseif ($disable = !"") { ?>
                                        <?php if (isset($editRecord[0]['status']) && $editRecord[0]['status'] == 1) { ?>
                                            <p><?= lang('active') ?></p>
                                        <?php } else { ?>
                                            <p><?= lang('inactive') ?></p>
                                        <?php } ?>

                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="">
                            <div class="clearfix"></div>
                            <div class="col-sm-12 text-center">
                                <div class="bottom-buttons">
                                    <?php if (!isset($readonly)) { ?>
                                        <input name="subcat_id" id="subcat_id" type="hidden" value="<?= !empty($editRecord[0]['subcat_id']) ? $editRecord[0]['subcat_id'] : '' ?>" />
                                        <input type="hidden" id="form_secret" name="form_secret"  value="<?php echo createFormToken(); ?>">
                                        <?php if ($formAction == "additems") { ?>
                                            <input type="submit" class="btn btn-primary" name="submit_btn" id="submit_btn" value="Save" />
                                        <?php } else { ?>
                                            <input type="submit" class="btn btn-primary" name="submit_btn" id="submit_btn" value="Update" />
                                        <?php } ?>
                                        <input type="button" style="display:none" class="btn btn-info remove_btn" name="remove" id="remove_btn" value="Remove" />
                                        <a href="<?php echo base_url() ?>/IngredientType" class="btn btn-default">Cancel</a>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php echo form_close(); ?> </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>