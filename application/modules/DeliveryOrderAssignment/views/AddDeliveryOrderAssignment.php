<script>
    var bas_url = '<?php echo base_url(); ?>';
<?php if (isset($edit_record)) { ?>
        var edit_record = '<?php echo $edit_record; ?>';
<?php } ?>

    var getSelectedInventoryDataURL = "<?php echo base_url('DeliveryOrder/getSelectedInventoryData'); ?>";
    var getCustomerDetailsURL = "<?php echo base_url('DeliveryOrder/getCustomerDetails'); ?>";
    var getInvontoryIdbyCustomerDetailsURL = "<?php echo base_url('DeliveryOrder/getInvontoryByCustomerDetails'); ?>";
    var getCustomerLocationsURL = "<?php echo base_url('DeliveryOrder/getPopUpData'); ?>";
</script>
<?php
$formPath = $form_action_path;
?>

<div class="content-wrapper">
    <div class="container">
        <div clas="row">
            <div class="col-md-12 error-list">
                <?= isset($validation) ? $validation : ''; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-head-line">Delivery Order Assignment</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Delivery Order Assignment - <?= !empty($edit_record[0]['delivery_order']) ? $edit_record[0]['delivery_order'] : $deliveryOrderId ?>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" id="deliveryfrm" method="post" action="<?php echo base_url($formPath); ?>" enctype="multipart/form-data" data-parsley-validate>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Customer Information
                                </div>
                                <div class="panel-body">
                                  <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="name">Customer Code</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <span id='cust_code' name='cust_code'><?= !empty($edit_record[0]['cust_code']) ? $edit_record[0]['cust_code'] : $this->lang->line('NA'); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-sm-3 ">Location/Outlet Name</label>
                                            <div class="col-sm-9">
                                                <span id='cust_location' name='cust_location'><?= !empty($edit_record[0]['customer_location']) ? $edit_record[0]['customer_location'] : $this->lang->line('NA'); ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="clearfix"></div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="name">Customer Name</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">                                                   
                                                    <span id='cust_name' name='cust_name'><?= !empty($edit_record[0]['customer_name']) ? $edit_record[0]['customer_name'] : $this->lang->line('NA'); ?></span>
                                                </div>                                                
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-sm-3 ">Email</label>
                                            <div class="col-sm-9">
                                                <span id='cust_email' name='cust_email'><?= !empty($edit_record[0]['email']) ? $edit_record[0]['email'] : $this->lang->line('NA'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-sm-3 ">Contact Number</label>
                                            <div class="col-sm-9">
                                                <span id='contact_number' name='contact_number'><?= !empty($edit_record[0]['contact_number']) ? $edit_record[0]['contact_number'] : $this->lang->line('NA'); ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-sm-3">Serial Number</label>
                                            <div class="col-sm-9">
                                                <span id='machine_serial' name='machine_serial'><?= !empty($edit_record[0]['machine_serial_number']) ? $edit_record[0]['machine_serial_number'] : $this->lang->line('NA'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                            </div>
                            <hr>
                              <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3">Delivery Order Number</label>
                                    <div class="col-sm-9">
                                        <?= !empty($edit_record[0]['delivery_order']) ? $edit_record[0]['delivery_order'] : $deliveryOrderId ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3">Order Date</label>
                                    <div class="col-sm-9">
                                        <div class="input-group date">
                                            <?php
                                            if (!empty($edit_record[0]['order_date']) && $edit_record[0]['order_date'] != '0000-00-00') {
                                                echo date('Y-m-d', strtotime($edit_record[0]['order_date']));
                                            } else {
                                                echo date("Y-m-d");
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3">Contact Person</label>
                                    <div class="col-sm-9">
                                        <span id='contact_name' name='contact_name'>
                                            <?= !empty($edit_record[0]['contact_name']) ? $edit_record[0]['contact_name'] : $this->lang->line('NA'); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3">Caller Name</label>
                                    <div class="col-sm-9">
                                        <?= !empty($edit_record[0]['caller_name']) ? $edit_record[0]['caller_name'] : '' ?>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3">Mobile Number</label>
                                    <div class="col-sm-9">
                                        <span id='mobile_number' name='mobile_number'>
                                            <?= !empty($edit_record[0]['mobile_number']) ? $edit_record[0]['mobile_number'] : $this->lang->line('NA'); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3">Caller  Number</label>
                                    <div class="col-sm-9">
                                        <?= !empty($edit_record[0]['caller_number']) ? $edit_record[0]['caller_number'] : '' ?>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3">LPO (NA if None)</label>
                                    <div class="col-sm-9">
                                        <?= !empty($edit_record[0]['lpo_number']) ? $edit_record[0]['lpo_number'] : '' ?>
                                    </div>
                                </div>
                            </div>


                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3">Sales Representative</label>
                                    <div class="col-sm-9">
                                        <span id='sales_representative' name='sales_representative'>
                                            <?php echo ucfirst($user_info['FIRSTNAME'] . ' ' . $user_info['LASTNAME']); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3">Route</label>
                                    <div class="col-sm-9">
                                        <span id='cust_route' name='cust_route'>
                                            <?= !empty($edit_record[0]['name']) ? $edit_record[0]['name'] : $this->lang->line('NA'); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3">Payment Terms</label>
                                    <div class="col-sm-9">
                                        <?= !empty($edit_record[0]['payment_terms_name']) ? $edit_record[0]['payment_terms_name'] . ' - ' . $edit_record[0]['description'] : $this->lang->line('NA') ?>
                                        <span id="payment_terms"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3">Remarks</label>
                                    <div class="col-sm-9 m-b-15">
                                        <?= !empty($edit_record[0]['remarks']) ? $edit_record[0]['remarks'] : $this->lang->line('NA'); ?>
                                    </div>
                                    <label class="control-label col-sm-3">Priority</label>
                                    <div class="col-sm-9">
                                        <?php if ($edit_record[0]['priority'] == 1) { ?>Priority 1<?php } ?>
                                        <?php if ($edit_record[0]['priority'] == 2) { ?>Priority 2<?php } ?>
                                        <?php if ($edit_record[0]['priority'] == 3) { ?>Priority 3<?php } ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3">Delivery Location</label>
                                    <div class="col-sm-9">
                                        <?= !empty($edit_record[0]['delivery_location']) ? $edit_record[0]['delivery_location'] : '' ?>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3">Order Type</label>
                                    <div class="col-sm-9">
                                        <?= !empty($edit_record[0]['order_type']) ? $edit_record[0]['order_type'] : '' ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3 required">Delivery Date Time</label>
                                    <div class="col-sm-9">
                                        <div class="input-group" id='delivery_date'>
                                            <input type="text"  name='delivery_date' class="form-control" placeholder="MM/DD/YYYY" value="<?php echo set_value('delivery_date', (isset($edit_record[0]['delivery_date'])) ? date('m/d/y H:i', strtotime($edit_record[0]['delivery_date'])) : ''); ?>" required='true' data-parsley-required-message="Please Enter Date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3 required">Zone</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" data-parsley-errors-container="#zone_error" name="zone" required >
                                            <option value="">Selected Zone</option>
                                            <?php
                                            if (!empty($zoneList)) {
                                                foreach ($zoneList as $zoneList_data) {
                                                    ?>
                                                    <option <?php
                                                    if (!empty($edit_record[0]['zone']) && $edit_record[0]['zone'] == $zoneList_data['id']) {
                                                        echo 'selected="selected"';
                                                    }
                                                    ?> value="<?= $zoneList_data["id"] ?>" ><?php echo $zoneList_data["name"]; ?></option>
                                                        <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <?php echo lang('common_no_record_found'); ?>
                                                <?php } ?>

                                        </select>
                                        <span id="zone_error"></span>
                                    </div>

                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3 required">Delivery Status</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" data-parsley-errors-container="#Status_error" name="delivery_status" required >
                                            <option value="">Selected Status</option>

                                            <?php
                                            foreach ($deliveryOrderList as $deliveryOrderData) {
                                                echo "<option value='" . $deliveryOrderData['code_id'] . "' " . set_select('delivery_status', (isset($edit_record[0]['delivery_status']) ? $edit_record[0]['delivery_status'] : ''), $deliveryOrderData['code_id'] == (isset($edit_record[0]['delivery_status']) ? $edit_record[0]['delivery_status'] : '')) . ">" . $deliveryOrderData['code_name'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                        <span id="Status_error"></span>
                                    </div>

                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <hr>
                              <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-condesened">
                                    <thead>
                                        <tr>
                                            <th width="15%">Ingredient</th>
                                            <th>Type</th>
                                            <th width="10%">Quantity</th>
                                            <th width="10%">Price</th>
                                            <th width="10%">Sub Total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="add_items">
                                        <?php
                                        if (!empty($item_details)) {
                                            foreach ($item_details as $row) {
                                                ?>
                                                <tr class="newrow" id="item_edit_<?= $row['do_menu_id'] ?>"><td>
                                                        <?php if (count($category_info) > 0) { ?>
                                                            <?php foreach ($category_info as $categorys_info) { ?>
                                                                <?php
                                                                if (!empty($row['ingredient_id']) && $row['ingredient_id'] == $categorys_info['cat_id']) {
                                                                    echo $categorys_info["cat_name"];
                                                                }
                                                                ?>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </td><td>
                                                        <?php
                                                        $subcategory = getSubcategory($row['ingredient_id']);
                                                        if (count($subcategory) > 0) {
                                                            ?>
                                                            <?php foreach ($subcategory as $subcategorys) { ?>
                                                                <?php
                                                                if (!empty($row['subcat_id']) && $row['subcat_id'] == $subcategorys['subcat_id']) {
                                                                    echo $subcategorys["subcat_name"];
                                                                }
                                                                ?>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </td><td>
                                                        <?= !empty($row['quantity']) ? $row['quantity'] : '' ?>
                                                    </td><td>
                                                        <?= !empty($row['price']) ? $row['price'] : '' ?>
                                                    </td><td>
                                                        <?= !empty($row['sub_total']) ? $row['sub_total'] : '' ?>
                                                    </td>                                            </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                              </div>
                            <div class="text-right">
                                <div class="form-group m-r-0">
                                    <label class="col-sm-12">Bill Amount: &nbsp;<span id="total_item">
                                            <?= !empty($edit_record[0]['total_amount']) ? $edit_record[0]['total_amount'] : '0.00' ?>
                                        </span></label>
                                    <div class="hide">
                                        <input type="hidden" id="delivery_order_id" name="delivery_order_id" value="<?= !empty($edit_record[0]['delivery_order_id']) ? $edit_record[0]['delivery_order_id'] : '' ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <?php if (!empty($edit_record[0]['attachments'])) { ?>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">Attachment</label>
                                        <div  class="col-sm-9 image_part file-uploader" id="dragAndDropFiles">
                                            <label style="display: none;" class="attachments">
                                                <div></div>
                                                <i class="fa fa-cloud-upload"></i>
                                                <div class="clearfix"></div>
                                            </label>

                                            <?php
                                            $arr_list = explode('.', $edit_record[0]['attachments']);
                                            $image_path = $this->config->item('delivery_order_upload_base_url') . 'DeliveryOrder/' . $edit_record[0]['attachments'];
                                            $arr = $arr_list[1];
                                            if (!file_exists($this->config->item('delivery_order_upload_base_url') . $edit_record[0]['attachments'])) {
                                                ?>
                                                <div id="img_<?php echo $edit_record[0]['delivery_order_id']; ?>" class="eachImage"> <a class="delete_file remove_drag_img" style="display: none;">x</a> <span class="preview">
                                                        <?php if ($arr == 'jpg' || $arr == 'jpeg' || $arr == 'png' || $arr == 'gif') { ?>           <img src="<?= $image_path; ?>"  width="75"/>
                                                        <?php } else { ?>
                                                            <div><img src="<?php echo base_url('/uploads/images/icons64/file-64.png'); ?>"/>
                                                                <p class="img_show"><?php echo $arr; ?></p>
                                                            </div>
                                                        <?php } ?>
                                                        <p class="img_name"><?php echo $edit_record[0]['attachments']; ?></p>
                                                        <span class="overlay" style="display: none;"> <span class="updone">100%</span></span>
                                                    </span> </div>
                                            <?php } ?>
                                            <?php ?>
                                            <div id="deletedImagesDiv"></div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <div class="col-sm-12 text-center">
                                <div class="bottom-buttons">
                                    <input type="submit" class="btn btn-primary" name="submit_btn" id="submit_btn" value="<?php echo (!empty($edit_record)) ? 'Update' : 'Save'; ?>"/>

                                    <a href="<?php echo base_url('DeliveryOrderAssignment') ?>" class="btn btn-default">Cancel</a>
                                </div>
                            </div>
                              </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
