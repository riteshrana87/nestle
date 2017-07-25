<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script>
    var customerCode = "<?php echo (isset($editCustmerId)) ? $editCustmerId : '' ?>";
    var defaultImg = "<?php echo base_url('/uploads/images/icons64/file-64.png'); ?>";
    var allowedType = "<?php echo ALLOWED_ATTACHMENT_TYPE; ?>";
    var allowedImgType = "<?php echo ALLOWED_IMAGE_ATTACHMENT_TYPE; ?>";
    var allowedMaxFileSize = "<?php echo ALLOWED_MAX_FILE_SIZE; ?>";

    var getSelectedInventoryDataURL = "<?php echo base_url('CollectionOrderAssignment/getSelectedInventoryData'); ?>";
    var getCustomerDetailsURL = "<?php echo base_url('CollectionOrderAssignment/getCustomerDetails'); ?>";
    var getInvontoryIdbyCustomerDetailsURL = "<?php echo base_url('CollectionOrderAssignment/getInvontoryByCustomerDetails'); ?>";
    var getCustomerLocationsURL = "<?php echo base_url('CollectionOrderAssignment/getPopUpData'); ?>";

</script>

<?= isset($validation) ? $validation : ''; ?>
<div class="content-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-head-line">Collection Order Assignment Form</h1>
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

                        <?php $collection_order_id = randomNumber(8) ?>
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
                                                <?php if (!empty($customerCodeList)) { ?>
                                                    <?php if (count($customerCodeList) > 0) { ?>
                                                        <?php foreach ($customerCodeList as $customerCodeData) { ?>
                                                            <?php
                                                            if (!empty($editCustmerId) && $editCustmerId == $customerCodeData['customer_id']) {
                                                                echo $customerCodeData["customer_code"];
                                                            }
                                                            ?>
                                                        <?php
                                                        }
                                                    }
                                                    ?>
                                                    <?php
                                                } else {
                                                    echo lang('common_no_record_found');
                                                    ?>
<?php } ?>
                                                <input type="hidden" value="<?= !empty($editCustomerCode) ? $editCustomerCode : $this->lang->line('NA'); ?>" name="cust_code" id="cust_code">

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
                                                <?php if (!empty($customerNameList)) { ?>
                                                    <?php if (count($customerNameList) > 0) { ?>
                                                        <?php foreach ($customerNameList as $customerNameData) { ?>
                                                            <?php
                                                            if (!empty($editCustmerName) && $editCustmerName == $customerNameData['customer_id']) {
                                                                echo $customerNameData["customer_name"];
                                                            }
                                                            ?>
                                                        <?php
                                                        }
                                                    }
                                                    ?>
                                                    <?php
                                                } else {
                                                    echo lang('common_no_record_found');
                                                    ?>
<?php } ?>
                                                <input type="hidden" value="<?= !empty($editCustmerName) ? $editCustmerName : $this->lang->line('NA'); ?>" name="cust_name" id="cust_name">
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
                                            <?php if (!empty($InventoryList)) { ?>
                                                <?php if (count($InventoryList) > 0) { ?>
                                                    <?php foreach ($InventoryList as $inventoryData) { ?>
                                                        <?php
                                                        if (!empty($editSrNumber) && $editSrNumber == $inventoryData['inventory_id']) {
                                                            echo $inventoryData["machine_serial_number"];
                                                        }
                                                        ?>
                                                    <?php
                                                    }
                                                }
                                                ?>
                                                <?php
                                            } else {
                                                echo lang('common_no_record_found');
                                                ?>
<?php } ?>

                                        </div>
                                    </div>
                                    <span id="sr_number_error"></span>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-3">Status</label>
                                <div class="col-sm-9">
                                    <?php
                                    foreach ($coStatusList as $coStatusData) {
                                        if (!empty($editStatus) && $editStatus == $coStatusData['code_id']) {
                                            echo $coStatusData['code_name'];
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-3 required">Payment Type</label>
                                <div class="col-sm-9">
                                    <?php
                                    foreach ($paymentTermsList as $paymentTermsData) {
                                        if (!empty($editPaymentTerms) && $editPaymentTerms == $paymentTermsData['id']) {
                                            echo $paymentTermsData['name'];
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-3 required">Contact Person</label>
                                <div class="col-sm-9">
<?php echo set_value('contact_person', (isset($editContactPerson) ? $editContactPerson : '')) ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-3 required">Sales Representative</label>
                                <div class="col-sm-9">
<?php echo set_value('sales_representative', (isset($editSalesRepresantative) ? $editSalesRepresantative : '')) ?>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-3 required">Contact Number</label>
                                <div class="col-sm-9">
<?php echo set_value('contact_number', (isset($editContactNumber) ? $editContactNumber : '')) ?></div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-3">Pickup Location</label>
                                <div class="col-sm-9">
<?php echo set_value('pickup_location', (isset($editPickUpLocation) ? $editPickUpLocation : '')) ?>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-3 required">Collection Date Time</label>
                                <div class="col-sm-9">
                                    <div class="input-group" id='collection_datetime'>
<?php echo set_value('collection_datetime', (isset($editCollectionDatetime) ? $editCollectionDatetime : '')) ?>
                                    </div>
                                </div>
                            </div>
                        </div>                        

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-3 required">Last Due Date Time</label>
                                <div class="col-sm-9">
                                    <div class="input-group" id='last_due_datetime'>
<?php echo set_value('last_due_datetime', (isset($editLastDueDateTime) ? $editLastDueDateTime : '')) ?>

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
                                    <span id='route' name='route'><?= !empty($customerDetails[0]['route_name']) ? $customerDetails[0]['route_name'] : $this->lang->line('NA') ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-sm-3 required">Zone</label>
                                <div class="col-sm-9">
                                    <select class="form-control" data-parsley-errors-container="#ZONE_error" name="zone" required >
                                        <option value="">Selected Zone</option>
                                        <?php
                                        if (!empty($zoneList)) {
                                            foreach ($zoneList as $zoneList_data) {
                                                ?>
                                                <option <?php
                                                    if (!empty($editzone) && $editzone == $zoneList_data['id']) {
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
                                    <span id="ZONE_error"></span>
                                </div>

                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr/>
                        <div class="col-sm-12">
                            <div class="text-left m-b-20">

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
                                    </tr>
                                </thead>
                                <tbody>
<?php if (isset($editChequeData)) { ?>
    <?php echo $editChequeData; ?>
<?php } ?>

                                </tbody>
                            </table>
                        </div>
                      </div>
                        <div class="text-right">
                            <div class="form-group m-r-0">
                                <label class="col-sm-12">
                                    Total Amount Of Collection: &nbsp;<span id="total_amount" name="total_amount">
<?php echo (isset($editTotalAmout)) ? $editTotalAmout : '0.00'; ?>
                                    </span>
                                </label>
                                <div class="hide">
                                    <input type="hidden" id="delivery_order_id" name="delivery_order_id" value="">
                                </div>
                            </div>
                        </div>
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
                                        <?php if (isset($editLocationAttachments)) { ?>
                                            <?php
                                            if (!empty($editLocationAttachments)) {

                                                $ext = pathinfo($editLocationAttachments, PATHINFO_EXTENSION);
                                                $attributes = array('jpg', 'jpeg', 'png');
                                                if (in_array($ext, $attributes)) {
                                                    $iconImg = $this->config->item('collection_order_attachment_base_url') . $editCollectionId . '/' . $editLocationAttachments;
                                                    //echo $iconImg; exit;
                                                } else {
                                                    $iconImg = base_url('/uploads/images/icons64/file-64.png');
                                                }
                                                ?>
                                                <img id="dynamicLocation" class="thumb-image" width="75" src="<?php echo $iconImg; ?>" /><?php echo $editLocationAttachments; ?> <a href="javascript:void(0);" class='locdelFile' data-id="<?php echo 'delete_' . $editCollectionId ?>" > X </a>
    <?php } ?>
<?php } ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-12 text-center">
                            <div class="bottom-buttons">
                                <input class='btn btn-primary' type='submit' name='add_save' id='add_save' value='<?php echo ($screenType == 'edit') ? 'Update' : 'Add' ?>' />

                                <a href="<?php echo base_url('CollectionOrderAssignment') ?>" class="btn btn-default">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php echo form_close(); ?>
    </div>
</div>