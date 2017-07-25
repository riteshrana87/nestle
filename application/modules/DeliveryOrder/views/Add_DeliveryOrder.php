<script>
    var baseurl = '<?php echo base_url(); ?>';

<?php if (isset($edit_record)) { ?>
        var edit_record = '<?php echo "edit_record"; ?>';
<?php } ?>
    var getSelectedInventoryDataURL = "<?php echo base_url('DeliveryOrder/getSelectedInventoryData'); ?>";
    var getCustomerDetailsURL = "<?php echo base_url('DeliveryOrder/getCustomerDetails'); ?>";
    var getInvontoryIdbyCustomerDetailsURL = "<?php echo base_url('DeliveryOrder/getInvontoryByCustomerDetails'); ?>";
    var getCustomerLocationsURL = "<?php echo base_url('DeliveryOrder/getPopUpData'); ?>";
    var getLastFiveOrderUrl = "<?php echo base_url('DeliveryOrder/viewLastFiveDeliveryOrderList'); ?>";
</script>
<?php
$formAction = (!empty($edit_record)) ? 'edit_record' : 'add_record';
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
                <h1 class="page-head-line">Delivery Order</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Delivery Order - <?= !empty($edit_record[0]['delivery_order']) ? $edit_record[0]['delivery_order'] : $deliveryOrderId ?>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" id="deliveryfrm" method="post" action="<?php echo base_url($formPath); ?>" enctype="multipart/form-data" data-parsley-validate>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Customer Information
                                </div>
                                <div class="panel-collapse">
                                    <div class="panel-body">
                                        <div class="row">
                                            <?php /* <div class="col-sm-6">
                                              <div class="form-group">
                                              <label class="control-label col-sm-3">Customer Name</label>
                                              <div class="col-sm-9">
                                              <?php echo isset($editCustomerName) ? $editCustomerName : ''; ?>
                                              </div>
                                              </div>
                                              </div> */ ?>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label col-sm-3 required" for="name">Customer Code</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <select class="form-control chosen-select" id='cust_code' name='cust_code' required='true' data-parsley-required-message="Please Select Customer Code" data-parsley-errors-container="#customer_code_error">
                                                                <option value=''>Select Customer Code</option>
                                                                <?php
                                                                foreach ($customerCodeList as $customerCodeData) {
                                                                    echo "<option class='cust_code_class' value='" . $customerCodeData['customer_id'] . "' " . set_select('cust_code', (isset($edit_record[0]['customer_code']) ? $edit_record[0]['customer_code'] : ''), $customerCodeData['customer_id'] == (isset($edit_record[0]['customer_code']) ? $edit_record[0]['customer_code'] : '')) . ">" . $customerCodeData['customer_code'] . "</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                            <div class="input-group-btn">
                                                                <button class="btn btn-default" type="button">
                                                                    <i class="fa fa-user" aria-hidden="true"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <span id="customer_code_error"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label col-sm-3 ">Location/Outlet Name</label>
                                                    <div class="col-sm-9">
                                                        <span id='cust_location' name='cust_location'><?= $this->lang->line('NA'); ?></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="clearfix"></div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label col-sm-3 required" for="name">Customer Name</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <select class="form-control chosen-select-name" id='cust_name' name='cust_name' required='true' data-parsley-required-message="Please Select Customer Name" data-parsley-errors-container="#customer_name_error">
                                                                <option value=''>Select Customer Name</option>
                                                                <?php
                                                                foreach ($customerNameList as $customerNameData) {
                                                                    echo "<option class='cust_name_class' value='" . $customerNameData['customer_name'] . "' " . set_select('cust_name', (isset($edit_record[0]['customer_name']) ? $edit_record[0]['customer_name'] : ''), $customerNameData['customer_name'] == (isset($edit_record[0]['customer_name']) ? $edit_record[0]['customer_name'] : '')) . ">" . $customerNameData['customer_name'] . "</option>";
                                                                }
                                                                ?>

                                                            </select>
                                                            <div class="input-group-btn">
                                                                <button class="btn btn-default" type="button">
                                                                    <i class="fa fa-user" aria-hidden="true"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <span id="customer_name_error"></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label col-sm-3 ">Email</label>
                                                    <div class="col-sm-9">
                                                        <span id='cust_email' name='cust_email'><?= $this->lang->line('NA'); ?></span>
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
                                                    <label class="control-label col-sm-3 required">Serial Number</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <select class="form-control chosen-select-name" id='sr_number_installation' name='sr_number_installation' required='true' data-parsley-required-message="Please Select Serial Number" data-parsley-errors-container="#sr_number_error">
                                                                <option value=''>Select Serial Number</option>
                                                                <?php
                                                                foreach ($InventoryList as $inventoryData) {
                                                                    echo "<option class='sr_number_class' value='" . $inventoryData['inventory_id'] . "' " . set_select('sr_number_installation', (isset($edit_record[0]['sr_number']) ? $edit_record[0]['sr_number'] : ''), $inventoryData['inventory_id'] == (isset($edit_record[0]['sr_number']) ? $edit_record[0]['sr_number'] : '')) . ">" . $inventoryData['machine_serial_number'] . "</option>";
                                                                }
                                                                ?>
                                                                <?php
                                                                ?>
                                                            </select>
                                                            <div class="input-group-btn">
                                                                <button class="btn btn-default" type="button">
                                                                    <i class="fa fa-user" aria-hidden="true"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <span id="sr_number_error"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 required">Delivery Order Number</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" required name="delivery_order" value="<?= !empty($edit_record[0]['delivery_order']) ? $edit_record[0]['delivery_order'] : $deliveryOrderId ?>"  readonly/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 required">Order Date</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" tabindex="10" placeholder="Enter Order Date" required id="order_date" name="order_date" onkeydown="return false" value="<?php
                                            if (!empty($edit_record[0]['order_date']) && $edit_record[0]['order_date'] != '0000-00-00') {
                                                echo date('m/d/Y', strtotime($edit_record[0]['order_date']));
                                            } else {
                                                echo date("m/d/Y");
                                            }
                                            ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 required">Contact Person</label>
                                        <div class="col-sm-9">
                                            <span id='contact_name' name='contact_name'>
                                                <?= !empty($edit_record[0]['contact_name']) ? $edit_record[0]['contact_name'] : $this->lang->line('NA'); ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 required">Caller Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="caller_name" name="caller_name" class="form-control" placeholder="Enter Caller Name" required value="<?PHP
                                            if ($formAction == "add_record") {
                                                echo set_value('contact_person');
                                                ?><?php } else { ?><?= !empty($edit_record[0]['caller_name']) ? $edit_record[0]['caller_name'] : '' ?><?php } ?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 required">Mobile Number</label>
                                        <div class="col-sm-9">
                                            <span id='mobile_number' name='mobile_number'>
                                                <?= !empty($edit_record[0]['mobile_number']) ? $edit_record[0]['mobile_number'] : $this->lang->line('NA'); ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 required">Caller  Number</label>
                                        <div class="col-sm-9">
                                            <input type="text" id='caller_number' name='caller_number' class="form-control" placeholder="Enter Caller Number" value="<?php echo set_value('caller_number', (isset($edit_record[0]['caller_number']) ? $edit_record[0]['caller_number'] : '')) ?>" required='true' data-parsley-required-message="Please Enter Caller Number" data-parsley-maxlength="15" data-parsley-pattern="^[\d\+\-\.\(\)\/\s]*$" data-parsley-trigger="keyup"/>

                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 required">LPO (NA if None)</label>
                                        <div class="col-sm-9">
                                            <input type="text" data-parsley-pattern="^[\d\+\-\.\(\)\/\s]*$" required="" class="form-control" name="lpo_number" placeholder="Enter LPO Number" value="<?PHP
                                            if ($formAction == "add_record") {
                                                echo set_value('lpo_number');
                                                ?><?php } else { ?><?= !empty($edit_record[0]['lpo_number']) ? $edit_record[0]['lpo_number'] : '' ?><?php } ?>">
                                        </div>
                                    </div>
                                </div>


                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 required">Sales Representative</label>
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
                                        <label class="control-label col-sm-3 required">Route</label>
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
                                            <span id="payment_terms" name="payment_terms"><?= $this->lang->line('NA'); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 required">Remarks</label>
                                        <div class="col-sm-9 m-b-15">
                                            <input type="text" id="remarks" name="remarks" class="form-control" placeholder="Remarks" required value="<?= !empty($edit_record[0]['remarks']) ? $edit_record[0]['remarks'] : ''; ?>" />
                                        </div>
                                        <label class="control-label col-sm-3 required">Priority</label>
                                        <div class="col-sm-9">
                                            <select  name="priority" id="priority" class="form-control" required='true' >
                                                <option value=''>Select Priority</option>
                                                <?php
                                                foreach ($priority as $prData) {
                                                    echo "<option value='" . $prData['code_id'] . "' " . set_select('priority', (isset($edit_record[0]['priority']) ? $edit_record[0]['priority'] : ''), $prData['code_id'] == (isset($edit_record[0]['priority']) ? $edit_record[0]['priority'] : '')) . ">" . $prData['code_name'] . "</option>";
                                                }
                                                ?>
                                                <?php
                                               /* foreach ($priority as $priorityKey => $priorityValue) {
                                                    echo "<option value='" . $priorityKey . "' " . set_select('priority', (isset($edit_record[0]['priority']) ? $edit_record[0]['priority'] : ''), $priorityKey == (isset($edit_record[0]['priority']) ? $edit_record[0]['priority'] : '')) . ">" . $priorityValue . "</option>";
                                                }*/
                                                ?>
                                                <?php /* <option <?php if ($edit_record[0]['priority'] == 1) { ?>selected<?php } ?> value="1">Priority 1</option>
                                                  <option <?php if ($edit_record[0]['priority'] == 2) { ?>selected<?php } ?> value="2">Priority 2</option>
                                                  <option <?php if ($edit_record[0]['priority'] == 3) { ?>selected<?php } ?> value="3">Priority 3</option> */ ?>
                                            </select>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 required">Delivery Location</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" required name="delivery_location"  rows="4" id="location" placeholder="Enter Delivery Location"><?PHP
                                                if ($formAction == "add_record") {
                                                    echo set_value('delivery_location');
                                                    ?><?php } else { ?><?= !empty($edit_record[0]['delivery_location']) ? $edit_record[0]['delivery_location'] : '' ?><?php } ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 required">Order Type</label>
                                        <div class="col-sm-9">
                                            <select  name="order_type" id="order_type" class="form-control" required='true'>
                                                <option value=''>Select Order Type</option>
                                                <?php
                                                foreach ($orderType as $orderTypeKey => $orderTypeValue) {
                                                    echo "<option value='" . $orderTypeKey . "' " . set_select('order_type', (isset($edit_record[0]['order_type']) ? $edit_record[0]['order_type'] : ''), $orderTypeKey == (isset($edit_record[0]['order_type']) ? $edit_record[0]['order_type'] : '')) . ">" . $orderTypeValue . "</option>";
                                                }
                                                ?>

                                                <?php /* <option <?php if ($edit_record[0]['order_type'] == 'email') { ?>selected<?php } ?> value="email">Email</option>
                                                  <option <?php if ($edit_record[0]['order_type'] == 'incomming_call') { ?>selected<?php } ?> value="incomming_call">Incoming Call</option>
                                                  <option <?php if ($edit_record[0]['order_type'] == 'outbound_call') { ?>selected<?php } ?> value="outbound_call">Outbound Call</option>
                                                 * 
                                                 */ ?>
                                            </select>
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
                                        <div class="col-sm-9">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3"></label>
                                        <div class="col-sm-9">
                                            <?php if ($formAction != "add_record") { ?>
                                                <a id="viewlastFiveOrder" target="_blank" href="<?php echo base_url($crnt_view . '/DeliveryOrder/viewLastFiveDeliveryOrderList'); ?>">View Last Five Delivery Order List</a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>

                                <hr>
                                <div class="col-sm-12">
                                    <div class="text-left m-b-20">
                                        <button type="button" id="add_new_item" class="btn btn-primary"> Add Ingredient</button>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-condesened">
                                            <thead>
                                                <tr>
                                                    <th width="30%">Ingredient</th>
                                                    <th>Type</th>
                                                    <th width="8%">Quantity</th>
                                                    <th width="11.2%">Price</th>
                                                    <th width="15%">Sub Total</th>
                                                    <th width="5%" class="text-center">Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody id="add_items">
                                                <?php
                                                if (!empty($item_details)) {
                                                    $totle_val = "";
                                                    foreach ($item_details as $row) {
                                                        ?>
                                                        <tr class="newrow" id="item_edit_<?= $row['do_menu_id'] ?>"><td>
                                                                <select required class="form-control" onChange="get_subcategory_data(<?= $row['do_menu_id'] ?>)" name="item_name_<?= $row['do_menu_id'] ?>" id="category_name_edit_<?= $row['do_menu_id'] ?>">
                                                                    <?php if (count($category_info) > 0) { ?>
                                                                        <option value=''> Select Ingredient</option>
                                                                        <?php foreach ($category_info as $categorys_info) { ?>
                                                                            <option <?php
                                                                            if (!empty($row['ingredient_id']) && $row['ingredient_id'] == $categorys_info['cat_id']) {
                                                                                echo 'selected="selected"';
                                                                            }
                                                                            ?> value="<?= $categorys_info["cat_id"] ?>" ><?php echo $categorys_info["cat_name"]; ?></option>
                                                                                <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                </select>
                                                            </td><td>
                                                                <select required name="subcat_name_<?= $row['do_menu_id'] ?>" id="sub_category_edit_<?= $row['do_menu_id'] ?>" onChange="subcategory_all_data_edit(<?= $row['do_menu_id'] ?>)" class="form-control">
                                                                    <option value=''>Select Ingredient Type</option>
                                                                    <?php
                                                                    $subcategory = getSubcategory($row['ingredient_id']);
                                                                    if (count($subcategory) > 0) {
                                                                        ?>
                                                                        <?php foreach ($subcategory as $subcategorys) { ?>
                                                                            <option <?php
                                                                            if (!empty($row['subcat_id']) && $row['subcat_id'] == $subcategorys['subcat_id']) {
                                                                                echo 'selected="selected"';
                                                                            }
                                                                            ?> value="<?= $subcategorys["subcat_id"] ?>" ><?php echo $subcategorys["subcat_name"]; ?></option>
                                                                                <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                </select>
                                                            </td><td>
                                                                <input type="text" maxlength="5" id="qty_edit_<?= $row['do_menu_id'] ?>" name="qty_hours_<?= $row['do_menu_id'] ?>" required='true' data-parsley-required-message="Required" data-parsley-validation-threshold="1" data-parsley-trigger="keyup" data-parsley-type="digits" data-parsley-min="1" onkeypress="return isNumberKey(event)" class="form-control text-right item_cal qty_item" placeholder="" value="<?= !empty($row['quantity']) ? $row['quantity'] : '' ?>">
                                                            </td><td>
                                                                <input type="text" maxlength="10" name="rate_<?= $row['do_menu_id'] ?>" id="sub_category_rate_edit_<?= $row['do_menu_id'] ?>" required='true' data-parsley-required-message="Required" readonly onkeypress="return numericDecimal(event)" class="form-control text-right item_cal rate_item" value="<?= !empty($row['price']) ? $row['price'] : '' ?>">
                                                            </td><td>
                                                                <?php
                                                                if (!empty($row['quantity']) && !empty($row['price'])) {
                                                                    $sub_val = $row['quantity'] * $row['price'];
                                                                    $totle_val += $sub_val;
                                                                }
                                                                ?>
                                                                <input type="text" readonly id="cost_edit_<?= $row['do_menu_id'] ?>" name="cost_<?= $row['do_menu_id'] ?>" onkeydown="return false" class="form-control text-right total_cost" placeholder="" value="<?= !empty($sub_val) ? $sub_val : '' ?>">
                                                            </td><td class="text-center">
                                                                <a class="btn btn-link">
                                                                    <span class="glyphicon glyphicon-trash" onclick="delete_item_row('item_edit_<?= $row['do_menu_id'] ?>');"></span></a>
                                                            </td>
                                                        </tr>

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
                                                <?= !empty($totle_val) ? $totle_val : '0.00' ?>
                                            </span></label>
                                        <div class="hide">
                                            <input type="hidden" name="amount_total" id="amount_total" value="<?= !empty($totle_val) ? $totle_val : '' ?>" />
                                            <input type="hidden" id="delivery_order_id" name="delivery_order_id"
                                                   value="<?= !empty($edit_record[0]['delivery_order_id']) ? $edit_record[0]['delivery_order_id'] : '' ?>">
                                            <input type="hidden" id="delete_item_id" name="delete_item_id" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">Attachment</label>
                                        <div class="col-sm-9 image_part m-b-15 file-uploader">
                                            <label name="attachments" class="attachments">
                                                <i class="fa fa-cloud-upload"></i>
                                                <div class="clearfix"></div>
                                                <input type="file" class="form-control" id='attachments' name='attachments' style="display: none">
                                            </label>

                                            <input type="hidden" name="removeFile" id='removeFile' value='0' />
                                            <div><span class="file_error"></span></div>
                                            <div id="image-holder">

                                                <?php
                                                //pr($edit_record); exit;
                                                if (!empty($edit_record[0]['attachments'])) {

                                                    $ext = pathinfo($edit_record[0]['attachments'], PATHINFO_EXTENSION);

                                                    $attributes = array('jpg', 'jpeg', 'png');
                                                    if (in_array($ext, $attributes)) {
                                                        $iconImg = $this->config->item('delivery_order_upload_base_url') . 'DeliveryOrder/' . $edit_record[0]['delivery_order_id'] . '/' . $edit_record[0]['attachments'];
                                                        //echo $iconImg; exit;
                                                    } else {
                                                        $iconImg = base_url('/uploads/images/icons64/file-64.png');
                                                    }
                                                    ?>
                                                    <img id="dynamic" class="thumb-image" width="75" src="<?php echo $iconImg; ?>" /><?php echo $edit_record[0]['attachments']; ?> <a href="javascript:void(0);" class='delFile' data-id="<?php echo 'delete_' . $edit_record[0]['delivery_order_id'] ?>" > X </a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="modal fade" id="myModal" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Customer Information</h4>
                                            </div>
                                            <div class="modal-body" id='modal-body'>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-ok" data-dismiss="modal">Ok</button>
                                                <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <input type='hidden' name='customer_id' id='customer_id' value="" />

                                <div class="col-sm-12 text-center">
                                    <div class="bottom-buttons">
                                        <input type="hidden" id="cust_selected_id" name="cust_selected_id" value="">
                                        <input type="submit" class="btn btn-primary" name="submit_btn" id="submit_btn" value="<?php echo (!empty($edit_record)) ? 'Update' : 'Save'; ?>" />
                                        <a href="<?php echo base_url('DeliveryOrder') ?>" class="btn btn-default">Cancel</a>
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
