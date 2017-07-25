<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script>
    var customerCode = "<?php echo (isset($editCustmerId)) ? $editCustmerId : '' ?>";
    var defaultImg = "<?php echo base_url('/uploads/images/icons64/file-64.png'); ?>";
    var allowedType = "<?php echo ALLOWED_ATTACHMENT_TYPE; ?>";
    var allowedImgType = "<?php echo ALLOWED_IMAGE_ATTACHMENT_TYPE; ?>";
    var allowedMaxFileSize = "<?php echo ALLOWED_MAX_FILE_SIZE; ?>";

    var getSelectedInventoryDataURL = "<?php echo base_url('CollectionOrder/getSelectedInventoryData'); ?>";
    var getCustomerDetailsURL = "<?php echo base_url('CollectionOrder/getCustomerDetails'); ?>";
    var getInvontoryIdbyCustomerDetailsURL = "<?php echo base_url('CollectionOrder/getInvontoryByCustomerDetails'); ?>";
    var getCustomerLocationsURL = "<?php echo base_url('CollectionOrder/getPopUpData'); ?>";

</script>

<?= isset($validation) ? $validation : ''; ?>
<div class="content-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-head-line">Collection Order Form</h1>
            </div>
        </div>
        <?php
        $attributes = array("name" => "co_add_edit", "id" => "co_add_edit", "data-parsley-validate" => "", "class" => "form-horizontal", 'novalidate' => '');
        echo form_open_multipart($form_action_path, $attributes);
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php $collection_order_id = 'CO_' . randomNumber(6) ?>
                        Request for Order Id -  <?= !empty($editCollectionOrderId) ? $editCollectionOrderId : $collection_order_id ?>

                    </div>
                    <div class="panel-body">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Customer Information
                            </div>
                            <div class="panel-body">
                              <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3 required" for="name">Customer Code</label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <select class="form-control chosen-select" id='cust_code' name='cust_code' required='true' data-parsley-required-message="Please Select Customer Code" data-parsley-errors-container="#customer_code_error">
                                                    <option value=''>Select Customer Code</option>
                                                    <?php
                                                    foreach ($customerCodeList as $customerCodeData) {
                                                        echo "<option class='cust_code_class' value='" . $customerCodeData['customer_id'] . "' " . set_select('cust_code', (isset($editCustmerId) ? $editCustmerId : ''), $customerCodeData['customer_id'] == (isset($editCustmerId) ? $editCustmerId : '')) . ">" . $customerCodeData['customer_code'] . "</option>";
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
                                                        echo "<option class='cust_name_class' value='" . $customerNameData['customer_name'] . "' " . set_select('cust_name', (isset($editCustomerNameId) ? $editCustomerNameId : ''), $customerNameData['customer_id'] == (isset($editCustomerNameId) ? $editCustomerNameId : '')) . ">" . $customerNameData['customer_name'] . "</option>";
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
                                                        echo "<option class='sr_number_class' value='" . $inventoryData['inventory_id'] . "' " . set_select('sr_number_installation', (isset($editSrNumberInstallation) ? $editSrNumberInstallation : ''), $inventoryData['inventory_id'] == (isset($editSrNumberInstallation) ? $editSrNumberInstallation : '')) . ">" . $inventoryData['machine_serial_number'] . "</option>";
                                                    }
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
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label col-sm-3">Status</label>
                            <div class="col-sm-9">
                                <select class="form-control" id='status' name='status' required='true' data-parsley-required-message="Please Select Status">
                                    <option value=''>Select Status </option>
                                    <?php
                                    foreach ($coStatusList as $coStatusData) {
                                        echo "<option value='" . $coStatusData['code_id'] . "' " . set_select('status', (isset($editStatus) ? $editStatus : ''), $coStatusData['code_id'] == (isset($editStatus) ? $editStatus : '')) . ">" . $coStatusData['code_name'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label col-sm-3 required">Payment Type</label>
                            <div class="col-sm-9">
                                <select class="form-control" id='payment_terms' name='payment_terms' required='true' data-parsley-required-message="Please Select Payment Type">
                                    <option value=''>Select Payment Type</option>
                                    <?php
                                    foreach ($paymentTermsList as $paymentTermsData) {
                                        echo "<option value='" . $paymentTermsData['id'] . "' " . set_select('payment_terms', (isset($editPaymentTerms) ? $editPaymentTerms : ''), $paymentTermsData['id'] == (isset($editPaymentTerms) ? $editPaymentTerms : '')) . ">" . $paymentTermsData['name'] . ' - ' . $paymentTermsData['description'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label col-sm-3 required">Contact Person</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" placeholder="Enter Contact Person" id='contact_person' name='contact_person' value="<?php echo set_value('contact_person', (isset($editContactPerson) ? $editContactPerson : '')) ?>" required='true' data-parsley-required-message="Please Enter Contact Person" data-parsley-maxlength="100" data-parsley-maxlength-message ='Max. 100 Characters are allowed.' data-parsley-trigger="keyup"/>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label col-sm-3">Sales Representative</label>
                            <div class="col-sm-9">
                                <?php
                                $representative = $this->session->userdata['LOGGED_IN']['FIRSTNAME'] . ' ' . $this->session->userdata['LOGGED_IN']['LASTNAME'];
                                echo ucwords($representative);
                                ?>
                                <?php /* <input type="text" class="form-control" placeholder="Enter Sales Representative" id='sales_representative' name='sales_representative' value="<?php echo set_value('sales_representative', (isset($editSalesRepresantative) ? $editSalesRepresantative : '')) ?>" required='true' data-parsley-required-message="Please Enter Sales Representative" data-parsley-maxlength="100" data-parsley-maxlength-message ='Max. 100 Characters are allowed.' data-parsley-trigger="keyup"/> */ ?>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label col-sm-3 required">Contact Number</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" placeholder="Enter Contact Number" id='contact_number' name='contact_number' value="<?php echo set_value('contact_number', (isset($editContactNumber) ? $editContactNumber : '')) ?>" maxlength="15" required='true' data-parsley-required-message="Please Enter Contact Number" data-parsley-pattern="^[\d\+\-\.\(\)\/\s]*$" data-parsley-pattern-message="Please Enter Valid Contact Number" data-parsley-maxlength="15" data-parsley-maxlength-message ='Max. 15 Characters are allowed.' data-parsley-trigger="keyup"/>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label col-sm-3">Pickup Location</label>
                            <div class="col-sm-9">
                                <?php /* <textarea id='pickup_location' name='pickup_location' class="form-control" placeholder="Enter Pickup Location" required='true' data-parsley-required-message="Please Enter Pickup Location" ><?php echo set_value('pickup_location', (isset($editPickUpLocation) ? $editPickUpLocation : '')) ?></textarea> */ ?>
                                <textarea id='pickup_location' name='pickup_location' class="form-control" placeholder="Enter Pickup Location" ><?php echo set_value('pickup_location', (isset($editPickUpLocation) ? $editPickUpLocation : '')) ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label col-sm-3 required">Collection Date Time</label>
                            <div class="col-sm-9">
                                <div class="input-group" id='collection_datetime'>
                                    <input type="text" class="form-control" placeholder="MM/DD/YYYY HH:MM" name='collection_datetime' value="<?php echo set_value('collection_datetime', (isset($editCollectionDatetime) ? $editCollectionDatetime : '')) ?>" required='true' data-parsley-required-message="Please Enter Collection Datetime" >
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                        

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label col-sm-3 required">Last Due Date Time</label>
                            <div class="col-sm-9">
                                <div class="input-group" id='last_due_datetime'>
                                    <input type="text" class="form-control" placeholder="MM/DD/YYYY HH:MM"  name='last_due_datetime' value="<?php echo set_value('last_due_datetime', (isset($editLastDueDateTime) ? $editLastDueDateTime : '')) ?>" required='true' data-parsley-required-message="Please Enter Last Due Datetime" >
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
                            <label class="control-label col-sm-3">Comments</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" rows="5" id="comment" name='comment' placeholder="Enter Comments"><?php echo set_value('comment', (isset($editComment) ? $editComment : '')) ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label col-sm-3">Route</label>
                            <div class="col-sm-9">
                                <span id='cust_route' name='route'> <?= $this->lang->line('NA'); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <hr/>
                    <div class="col-sm-12">
                        <div class="text-left m-b-20">
                            <a class="btn btn-primary" href="javascript:void(0);" id='add_more_cheque' name='add_more_cheque'>Cheque information</a>
                        </div>
                    </div>
                    <div class="col-md-12">
                    <div class="table-responsive">          
                        <table class="table table-bordered table-condesened" id='tbl_cheque' name='tbl_cheque'>
                            <thead>
                                <tr>
                                    <th width="25%">Reference #</th>
                                    <th width="25%">Invoice #</th>
                                    <th width="25%">P O # (NA if none)</th>
                                    <th width="15%">Amount</th>                                            
                                    <th width="5%">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($editChequeData)) { ?>
                                    <?php echo $editChequeData; ?>
                                <?php } else { ?>
                                    <tr>
                                        <td><input type="text" id='reference' name='reference[]' class="form-control"  value="" /></td>
                                        <td><input type="text" id='invoice' name='invoice[]' class="form-control" value="" /></td>
                                        <td><input type="text" id='po' name='po[]' class="form-control" value="" /></td>
                                        <td><input type="text" id='amount' name='amount[]' class="form-control text-right amount" value="" maxlength="12" data-parsley-pattern="^\d+(\.\d{1,2})?$" data-parsley-pattern-message='Allow upto 2 decimal point. e.g: 4.00' data-parsley-trigger="keyup"/></td>
                                        <td><a href="javascript:void(0);" class="btn btn-link delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
                                    </tr>
                                <?php } ?>

                            </tbody>
                        </table>
                    </div>
                      </div>
                    <div class="text-right">
                        <div class="form-group m-r-0">
                            <label class="col-sm-12">
                                Total Amount Of Collection: &nbsp;<span id="total_amount" name="total_amount">
                                    <?php echo (isset($editTotalAmout)) ? amtRound($editTotalAmout) : ''; ?>
                                </span>
                            </label>
                            <div class="hide">
                                <input type="hidden" name="amount_total" id="amount_total" value="">
                                <input type="hidden" id="delivery_order_id" name="delivery_order_id" value="">
                                <input type="hidden" id="delete_item_id" name="delete_item_id" value="">
                            </div>
                        </div>
                    </div>
                    <!--<div class="pull-right">
                        <div class="form-group m-r-0">
                            <label class="control-label col-sm-3">Total Amount Of Collection</label>
                            <div class="col-sm-9">
                    <?php /* <span name='total_amount' id='total_amount'><?php echo set_value('total_amount', (isset($editTotalAmout) ? $editTotalAmout : '')) ?></span> */ ?>
                                <input type="text" class="form-control" name='total_amount' id='total_amount' value="" readonly >
                            </div>
                        </div>
                    </div>-->
                    <hr/>
                    <div class="clearfix"></div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label col-sm-3">Partial Collection Amount</label>
                            <div class="col-sm-9">
                                <input type="text" onkeypress="return numericDecimal(event)" class="form-control" placeholder="Partial Amount Collection Order" id='partial_collection_amount' name='partial_collection_amount' value="<?php echo set_value('partial_collection_amount', (isset($editPartialCollectionAmount) ? $editPartialCollectionAmount : '')) ?>">

                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label col-sm-3" >Collection Trip Failed</label>
                            <div class="col-sm-9">
                                <label class="radio-inline"><input type="radio" id='collection_trip_failed_yes' name='collection_trip_failed'  value="yes" <?php echo set_radio('collection_trip_failed', 'yes', (isset($editCoTrip) ? (($editCoTrip == 'yes') ? TRUE : FALSE) : TRUE)); ?> >Yes</label>
                                <label class="radio-inline"><input type="radio" id='collection_trip_failed_no' name='collection_trip_failed'  value="no" <?php echo set_radio('collection_trip_failed', 'no', (isset($editCoTrip) ? (($editCoTrip == 'no') ? TRUE : FALSE) : FALSE)); ?>>No</label>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label col-sm-3">Reason for partial or failed collection</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" rows="2" id="reason_of_collection" name='reason_of_collection'  placeholder="Enter reason for partial or failed collection"><?php echo set_value('reason_of_collection', (isset($editReasonOfCollection) ? $editReasonOfCollection : '')) ?></textarea>
                            </div>
                        </div>
                    </div>

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
                                    <?php if (isset($editAttachment)) { ?>
                                        <?php
                                        if (!empty($editAttachment)) {

                                            $ext = pathinfo($editAttachment, PATHINFO_EXTENSION);
                                            $attributes = array('jpg', 'jpeg', 'png');
                                            if (in_array($ext, $attributes)) {
                                                $iconImg = $this->config->item('collection_order_attachment_base_url') . $editCollectionId . '/' . $editAttachment;
                                                //echo $iconImg; exit;
                                            } else {
                                                $iconImg = base_url('/uploads/images/icons64/file-64.png');
                                            }
                                            ?>
                                            <img id="dynamic" class="thumb-image" width="75" src="<?php echo $iconImg; ?>" /><?php echo $editAttachment; ?> <a href="javascript:void(0);" class='delFile' data-id="<?php echo 'delete_' . $editCollectionId ?>" > X </a>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>


                            <label class="control-label col-sm-3">Location Map Attachment</label>
                            <div class="col-sm-9 image_part file-uploader">
                                <label name="location_attachments" class="attachments">
                                    <i class="fa fa-cloud-upload"></i>
                                    <div class="clearfix"></div>
                                    <input type="file" class="form-control" id='location_attachments' name='location_attachments' style="display: none">
                                </label>

                                <input type="hidden" name="removeLocationFile" id='removeLocationFile' value='0' />
                                <div><span class="loc_file_error"></span></div>
                                <div id="location-image-holder">
                                    <?php if (isset($editLocationAttachment)) { ?>
                                        <?php
                                        if (!empty($editLocationAttachment)) {

                                            $ext = pathinfo($editLocationAttachment, PATHINFO_EXTENSION);
                                            $attributes = array('jpg', 'jpeg', 'png');
                                            if (in_array($ext, $attributes)) {
                                                $iconImg = $this->config->item('collection_order_attachment_base_url') . $editCollectionId . '/' . $editLocationAttachment;
                                                //echo $iconImg; exit;
                                            } else {
                                                $iconImg = base_url('/uploads/images/icons64/file-64.png');
                                            }
                                            ?>
                                            <img id="dynamicLocation" class="thumb-image" width="75" src="<?php echo $iconImg; ?>" /><?php echo $editLocationAttachment; ?> <a href="javascript:void(0);" class='locdelFile' data-id="<?php echo 'delete_' . $editCollectionId ?>" > X </a>
                                        <?php } ?>
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

                    <div class="col-sm-12 text-center">
                        <div class="bottom-buttons">

                            <input type="hidden" name="collection_order_id" value="<?php echo set_value('reason_of_collection', (isset($editCollectionOrderId) ? $editCollectionOrderId : $collection_order_id)) ?>" >
                            <input class='btn btn-primary' type='submit' name='add_save' id='add_save' value='<?php echo ($screenType == 'edit') ? 'Update' : 'Save' ?>' />

                            <a href="<?php echo base_url('CollectionOrder') ?>" class="btn btn-default">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
</div>