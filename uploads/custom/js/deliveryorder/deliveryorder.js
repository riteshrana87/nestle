//Add item html
$(function () {
    //Add more item
    $('#add_new_item').click(function () {
        item_html = add_item_limit();
        $('#add_items').append(item_html);
        $('#from-model').parsley();
    });
    /*end item code*/


    if(typeof (edit_record)=='undefined') {

        //Append first time item

        item_html = add_item_limit();
        $('#add_items').append(item_html);
    }


});

//remove new row
function delete_new_row(del_id)
{
    var delete_meg = "Are you sure want to delete?";
    BootstrapDialog.show(
        {
            title: 'Information',
            message: delete_meg,
            buttons: [{
                label: 'Cancel',
                action: function (dialog) {
                    dialog.close();
                }
            }, {
                label: 'ok',
                action: function (dialog) {
                    $('#' + del_id).remove();
                    //count current item
                    var total_amt = 0;
                    $("#add_items .total_cost").each(function (index) {
                        if ($(this).val() != 0.00 && $(this).val() != '')
                        {
                            total_amt += parseFloat($(this).val());
                        }

                    });
                    $('#total_item').text(total_amt.toFixed(2));
                    $('#amount_total').val(total_amt.toFixed(2));
                    /*$('#confirm-id').on('hidden.bs.modal', function () {
                        $('body').addClass('modal-open');
                    });
                    */
                    dialog.close();
                }

            }]
        });


}


var count = $('#item_cnt').length;
function add_item_limit()
{
   // $('#add_new_item').attr('disabled');
    $('#add_new_item').prop("disabled", true);
 //   sleep(1000);
    var html = '';
    html +='<tr class="newrow" id="item_new_' + count + '"><td>';
    html += '<select data-parsley-errors-container=".cat_' + count + '" class="chosen-select-cat cat_' + count + ' form-control item_cnt" onChange="get_subcategory('+count+')" name="item_name[]" required id="category_name_' + count + '">';
    $.ajax({
        type: "POST",
        url: baseurl + "DeliveryOrder/category_data",
    }).done(function( msg ) {
        $('#category_name_'+ count).html('');
        var result = jQuery.parseJSON( msg );
        $('#category_name_'+ count).html('<option value="">Select Ingredient</option>');
        $(result.category_info).each(function(index, data){
            $('#category_name_' + count ).append('<option value="'+ data.cat_id +'">'+data.cat_name+'</option>');
        });
        count++;
        //$('#add_new_item').prop("disabled", true);

         $('#add_new_item').removeAttr('disabled');
    });
    html += '</select>';
    html +='<span class="cat_' + count + '"></span></td><td>';
    html +='<select data-parsley-errors-container=".subcat_' + count + '" name="subcat_name[]" required id="sub_category_' + count + '" onChange="subcategory_all_data('+count+')" class="chosen-select-subcat form-control subcat_' + count + '"></select>';
    html +='<span class="subcat_' + count + '"></span></td><td>';
    html += '<input type="text" maxlength="5" data-parsley-validation-threshold="1" data-parsley-trigger="keyup" data-parsley-type="digits" id="qty_' + count + '" name="qty_hours[]" required data-parsley-required-message="Required" data-parsley-min="1"  onkeypress="return isNumberKey(event)" class="form-control text-right item_cal qty_item" placeholder="" value="">';
    html +='</td><td>';
    html += '<input type="text" maxlength="10" name="rate[]" id="sub_category_rate_' + count + '" data-parsley-required-message="Required" readonly onkeypress="return numericDecimal(event)" class="form-control text-right item_cal rate_item" placeholder="" value="">';
    html +='</td><td>';
    html += '<input type="text" readonly id="cost_' + count + '" name="cost[]" onkeydown="return false" class="form-control text-right total_cost" placeholder="" value="">';
    html +='</td><td class="text-center">';
    html += '<a class="btn btn-link ">';
    html += '<span class="glyphicon glyphicon-trash" onclick="delete_new_row(\'item_new_' + count + '\');"></span>';
    html += '</a>';
    html +='</td>';
    // $('#category_name_' + count).chosen();
    $('#category_name_' + count).trigger("liszt:updated");

    return html;
}
function sleep(milliseconds) {
    var start = new Date().getTime();
    for (var i = 0; i < 1e7; i++) {
        if ((new Date().getTime() - start) > milliseconds){
            break;
        }
    }
}
//remove new row
function delete_item_row(del_id)
{
    var delete_meg = "Are you sure want to delete?";
    BootstrapDialog.show(
        {
            title: 'Information',
            message: delete_meg,
            buttons: [{
                label: 'Cancel',
                action: function (dialog) {
                    dialog.close();
                }
            }, {
                label: 'ok',
                action: function (dialog) {

                    var del_ids = $('#delete_item_id').val();
                    remove_id = del_id.split('item_edit_');
                    $('#delete_item_id').val(del_ids + remove_id[1] + ',');

                    $('#' + del_id).remove();
                    //count current item
                    var total_amt = 0;
                    $("#add_items .total_cost").each(function (index) {
                        if ($(this).val() != 0.00 && $(this).val() != '')
                        {
                            total_amt += parseFloat($(this).val());
                        }

                    });
                    $('#total_item').text(total_amt.toFixed(2));
                    $('#amount_total').val(total_amt.toFixed(2));
                    /*
                    $('#confirm-id').on('hidden.bs.modal', function () {
                        $('body').addClass('modal-open');
                    });
                    */
                    dialog.close();
                }

            }]
        });
}
//calculation
$('body').delegate('.item_cal', 'keyup', function () {
    dis_id = $(this).parent().parent().attr('id');
    get_row_total(dis_id);
});
//get row wise total
function get_row_total(dis_id)
{
    var qty = '';
    var rate = '';
    var tax = '';
    var discount = '';
    var cost = '';
    var total_cost = 0;
    qty = $('#' + dis_id + ' .qty_item').val();
    rate = $('#' + dis_id + ' .rate_item').val();

    //tax      = $('#'+dis_id+' .tax_item:selected').text();
    tax = $('#' + dis_id + ' .tax_item option:selected').text();
    //discount = $('#' + dis_id + ' .discount_item').val();

    //rate calculation
    if (rate != '')
    {
        total_cost = qty * parseFloat(rate);
        total_rate = qty * parseFloat(rate);

        $('#' + dis_id + ' .total_cost').val(total_cost.toFixed(2));
    }
    //discount
    /*
    if (discount != '')
    {
        var dis_total = parseFloat(total_cost) * parseFloat(discount) / 100;
        var total_cost = parseFloat(total_rate) - parseFloat(dis_total);
        //alert(total_cost);
        $('#' + dis_id + ' .total_cost').val(total_cost.toFixed(2));
    }
    */
    //tax
    /*
    if ($.isNumeric(tax))
    {

        if (total_cost != 0)
        {
            var tax_total = parseFloat(total_cost) * parseFloat(tax) / 100;
            var total_cost = parseFloat(total_cost) + parseFloat(tax_total);
        }
        else
        {
            var total_cost = parseFloat(total_rate) * parseFloat(tax) / 100;
        }

        $('#' + dis_id + ' .total_cost').val(total_cost.toFixed(2));
    }
    */
    var total_amt = 0;
    $("#add_items .total_cost").each(function (index) {
        if ($(this).val() != 0.00 && $(this).val() != '')
        {
            total_amt += parseFloat($(this).val());
        }

    });
    $('#total_item').text(total_amt.toFixed(2));
    $('#amount_total').val(total_amt.toFixed(2));
    //alert(total_amt);

}
//numeric decimal number
function numericDecimal(e) {
    var unicode = e.charCode ? e.charCode : e.keyCode;
    //alert(unicode);
    if (unicode != 8) {
        if (unicode < 9 || unicode > 9 && unicode < 46 || unicode > 57 || unicode == 47) {
            return false;
        }
        else {
            return true;
        }
    }
    else {
        return true;
    }
}

function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

function get_subcategory(count) {
    $.ajax({
        type: "POST",
        url: baseurl + "DeliveryOrder/subcategory_data",
        data: { category_val: $('#category_name_'+count+' :selected').val() }
    }).done(function( msg ) {
        $('#sub_category_rate_' + count).val('');
        $('#qty_' + count).val('');
        $('#cost_' + count).val('');

        $('#sub_category_'+ count).html('');
        var result = jQuery.parseJSON( msg );
        $('#sub_category_'+ count).html('<option value="">Select Ingredient Type</option>');
        $(result.subcategory_info).each(function(index, data){
            $('#sub_category_' + count ).append('<option value="'+ data.subcat_id +'">'+data.subcat_name+'</option>');
        });
    });
}
function subcategory_all_data(count) {
    $('#sub_category_rate_' + count).val('');
    $('#qty_' + count).val('');
    //$('#' + count + ' .total_cost').val('');
    $('#cost_' + count).val('')
    $.ajax({
        url: baseurl + "DeliveryOrder/subcategory_all_data",
        type: "post",
        data: { subcategory_val: $('#sub_category_'+count+' :selected').val() },
        dataType: "JSON",
        success: function (data)
        {
            $('#sub_category_rate_' + count).val(data.price);
        }
    });
    get_row_total(count);
}

function customer_data()
{
    var customer_id = $('#customer_code option:selected').val();
    var request_url = '';
    /*if(customer_id!=='')
    {
        $('#deliveryfrm').submit();
    }
    */

    request_url = baseurl+ 'DeliveryOrder/customerData';
    $.ajax({
        type: "POST",
        url: request_url,
        data: {'customer_id': customer_id},
        success: function (html) {
            $("#customer_detail").html(html);
            customer_detail(customer_id);
        }
    });
    return true;
}

function customer_detail()
{
    var customer_id = $('#customer_code option:selected').val();
    var request_url = '';
    request_url = baseurl+ 'DeliveryOrder/customerDetail';
    $.ajax({
        type: "POST",
        url: request_url,
        data: {'customer_id': customer_id},
        dataType: "JSON",
        success: function (data) {
            $("#route_id").val(data.route_id);
        }
    });

    return true;
}

function get_subcategory_data(count) {
    $.ajax({
        type: "POST",
        url: baseurl + "DeliveryOrder/subcategory_data",
        data: { category_val: $('#category_name_edit_'+count+' :selected').val() }
    }).done(function( msg ) {
        $('#qty_edit_' + count).val('');
        $('#sub_category_rate_edit_' + count).val('');
        $('#cost_edit_' + count).val('');

        $('#sub_category_edit_'+ count).html('');
        var result = jQuery.parseJSON( msg );
        console.log(result);
        $('#sub_category_edit_'+ count).html('<option value="">Select Ingredient Type</option>');
        $(result.subcategory_info).each(function(index, data){
            $('#sub_category_edit_' + count ).append('<option value="'+ data.subcat_id +'">'+data.subcat_name+'</option>');
        });
        get_row_total(count);
    });

}


function subcategory_all_data_edit(count) {
    $('#sub_category_rate_edit_' + count).val('');
    $('#qty_edit_' + count).val('');
    $('#cost_edit_' + count).val('');
    $.ajax({
        url: baseurl + "DeliveryOrder/subcategory_all_data",
        type: "post",
        data: { subcategory_val: $('#sub_category_edit_'+count+' :selected').val() },
        dataType: "JSON",
        success: function (data)
        {
            $('#sub_category_rate_edit_' + count).val(data.price);

        }
    });
    get_row_total(count);
}
$('.chosen-select').chosen({search_contains: true});
$('.data_code').chosen({search_contains: true});
$('.chosen-select-cat').chosen({search_contains: true});
$('.chosen-select-subcat').chosen({search_contains: true});

//
// $('#creation_date').datetimepicker({
//     format: "yyyy-mm-dd"
// });
//
// $('#delivery_date').datetimepicker({
//     format: "yyyy-mm-dd"});

$('#creation_date').datetimepicker({format: 'L'});
$('#delivery_date').datetimepicker();


$(function () {

    $('.chosen-select').chosen();
    $('#deliveryfrm').parsley();//parsaley validation reload
    //disabled after submit
    $('body').delegate('#submit_btn', 'click', function () {
        if ($('#deliveryfrm').parsley().isValid()) {
            $('input[type="submit"]').prop('disabled', true);
            $('#deliveryfrm').submit();
        }
    });
});

function delete_request(CoId){
    var delete_meg ="Are You Sure Want to Delete Delivery Order This from list ?";
    BootstrapDialog.show(
        {
            title: 'Information',
            message: delete_meg,
            buttons: [{
                label: 'Cancel',
                action: function(dialog) {
                    dialog.close();
                }
            }, {
                label: 'ok',
                action: function(dialog) {
                    window.location.href = baseurl +'/DeliveryOrder/deletedata/' + CoId;
                    dialog.close();
                }
            }]
        });
}



//new code

$(document).ready(function () {

    $('#deliveryfrm').parsley();

    $('.chosen-select').chosen({search_contains: true});
    $('.chosen-select-name').chosen({search_contains: true});

    var selectedCustomerCode = $('#cust_code option:selected').val();  // get selecetd customer code
    updateCustomerInfo(selectedCustomerCode, 'code');

    // On click customer code field
    $(document).on('click', '.cust_code_class', function (evt, params) {
        //var selectedCustomerCode = $(this).text();  // get selecetd customer code
        var selectedCustomerCode = $('#cust_code').find('option:selected').val();  // get selecetd customer code
        updateCustomerInfo(selectedCustomerCode, 'code');
    });

    // On click customer name field
    $(document).on('click', '.cust_name_class', function (evt, params) {
        var selectedCustomerName = $(this).text();  // get selecetd customer code
        if (selectedCustomerName != '') {
            getLocationsPopUp(selectedCustomerName); // Open Pop Up
        }

    });

    $(document).on('click', '.sr_number_class', function (evt, params) {
        //var selectedSrNumber = $('#sr_number_installation option:selected').val();//$(this).text();  // get selecetd customer code
        //updateInventoryInfo(selectedSrNumber);
        var selectedSerialNumber = $('#machine_sr_number').find('option:selected').val();  // get selecetd customer code

        updateCustomerInfo(selectedSerialNumber, 'sr_number');
    });

    $('#myModal').on('hidden.bs.modal', function (e) {
        var selectedCustomerId = $('input[name=customer_radio]:radio:checked').val();
        updateCustomerInfo(selectedCustomerId, 'name'); // Update Customer Info data
        $('#customer_id').val(selectedCustomerId); // set current location select
        //getSrNumberDetails(selectedCustomerId);
    });

});

// pop up open for
function getLocationsPopUp(selectedCustomerName) {

    $.ajax({
        type: "POST",
        url: getCustomerLocationsURL,
        data: {selectedCustomerName: selectedCustomerName},
        async: false,
        beforeSend: function () {
            //$('#cust_name, #cust_number, #cust_location, #cust_sr_number, #route').html('--N/A--');
            $('#loader').show(); // show loader
        },
        success: function (resultData) {
            $('#modal-body').html(resultData);
            $('#myModal').modal('show');
        },
        complete: function (data) {
            $('#loader').hide(); // show loader
        },
        error: function (xhr, status, error) {
            var err = JSON.parse(xhr.responseText);
            console.log(err.Message);
        }
    });
}

// update customer info based on select code
function updateCustomerInfo(customerCodeName, selType) {
    $.ajax({
        type: "POST",
        url: getCustomerDetailsURL,
        data: {selCustomerCode: customerCodeName, selType: selType},
        async: false,
        beforeSend: function () {
            $('#cust_number, #cust_location, #cust_email, #cust_route, #payment_terms').html('--N/A--');
            $('#loader').show(); // show loader
        },
        success: function (resultData) {
            var customerObj = $.parseJSON(resultData); // json data

            if (customerObj != '') {

                /*if (selType == 'name') {
                    $('#cust_code').val(customerObj.customer_id);
                    $("#cust_code").trigger("chosen:updated");
                }

                if (selType == 'code') {
                    $('#cust_name').val(customerObj.customer_name);
                    $("#cust_name").trigger("chosen:updated");
                }*/

                //getSrNumberDetails(customerObj.customer_id);
                /*if (selType == 'code') {
                 $('#cust_name').val(customerObj.customer_id);
                 $("#cust_code").trigger("chosen:updated");
                 }*/
                
                if (selType != 'code') {
                    $('#cust_code').val(customerObj.customer_id);
                    $("#cust_code").trigger("chosen:updated");
                }

                if (selType != 'name') {
                    $('#cust_name').val(customerObj.customer_name);
                    $("#cust_name").trigger("chosen:updated");
                }

                if (selType != 'sr_number') {
                    $('#sr_number_installation').val(customerObj.machine_sr_id);
                    $("#sr_number_installation").trigger("chosen:updated");
                }
				 
                $('#contact_name').html(customerObj.contact_name);
                $('#contact_number').html(customerObj.contact_number);
                $('#mobile_number').html(customerObj.customer_mobile_number);
                $('#cust_location').html(customerObj.customer_location);
                $('#cust_email').html(customerObj.customer_email);
                $('#cust_route').html(customerObj.customer_route_name);
                $('#cust_selected_id').val(customerObj.customer_id);				
                var hrefd = getLastFiveOrderUrl+'/'+customerObj.customer_id;				
                $("#viewlastFiveOrder").attr("href",hrefd);
                
                $('#payment_terms').html(customerObj.payment_terms);
            }else{
                $('#cust_code').val('');
                $("#cust_code").trigger("chosen:updated");
                $('#cust_name').val('');
                $("#cust_name").trigger("chosen:updated");
                $('#sr_number_installation').val('');
                $("#sr_number_installation").trigger("chosen:updated");
                $('#contact_name').html('');
                $('#contact_number').html('');
                $('#mobile_number').html('');
                $('#cust_location').html('');
                $('#cust_email').html('');
                $('#cust_route').html('');
                $('#cust_selected_id').val('');
                $("#viewlastFiveOrder").attr("href",'');
                $('#payment_terms').html(customerObj.payment_terms);
            }
        },
        complete: function (data) {
            $('#loader').hide(); // show loader
        },
        error: function (xhr, status, error) {
            var err = JSON.parse(xhr.responseText);
            console.log(err.Message);
        }
    });
}



// set version based other fields data
function getSrNumberDetails(selCustomerId) {
    $.ajax({
        type: "POST",
        url: getSelectedInventoryDataURL,
        data: {selCustomerId: selCustomerId},
        async: false,
        beforeSend: function () {
            $('#loader').show(); // show loader
        },
        success: function (resultData) {

            var versionObj = $.parseJSON(resultData); // json data
            $('#sr_number_installation').val(versionObj.srDrpDwnData);
            $("#sr_number_installation").trigger("chosen:updated");

        },
        complete: function (data) {
            $('#loader').hide(); // show loader
        },
        error: function (xhr, status, error) {
            var err = JSON.parse(xhr.responseText);
            console.log(err.Message);
        }
    });
}

// update customer info based on select code
function updateInventoryInfo(SrNumber) {
    $.ajax({
        type: "POST",
        url: getInvontoryIdbyCustomerDetailsURL,
        data: {SrNumber: SrNumber},
        async: false,
        beforeSend: function () {
            $('#cust_number, #cust_location, #cust_email, #cust_route, #payment_terms').html('--N/A--');
            $('#loader').show(); // show loader
        },
        success: function (resultData) {
            var customerObj = $.parseJSON(resultData); // json data

            if (customerObj != '') {


                    $('#cust_code').val(customerObj.customer_id);
                    $("#cust_code").trigger("chosen:updated");

                    $('#cust_name').val(customerObj.customer_id);
                    $("#cust_name").trigger("chosen:updated");

                $('#contact_name').html(customerObj.contact_name);
                $('#contact_number').html(customerObj.contact_number);
                $('#mobile_number').html(customerObj.customer_mobile_number);
                $('#cust_location').html(customerObj.customer_location);
                $('#cust_email').html(customerObj.customer_email);
                $('#cust_route').html(customerObj.customer_route_name);
                $('#payment_terms').html(customerObj.payment_terms);
            }
        },
        complete: function (data) {
            $('#loader').hide(); // show loader
        },
        error: function (xhr, status, error) {
            var err = JSON.parse(xhr.responseText);
            console.log(err.Message);
        }
    });
}



 // for Preview the Attchment
    $("#attachments").on('change', function () {
        if (typeof (FileReader) !== "undefined") {

            var fileInfo = this.files[0];
            var validFileData = false;

            // File type allow
            var arrValidateFile = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx', 'xls', 'xlsx'];
            var extn = fileInfo.name.split(".").pop().toLowerCase();
 
            if ($.inArray(extn, arrValidateFile) === -1) {
                validFileData = true;
                var msg = 'Please upload Valid file type.';
            }

            // File size
            if (fileInfo.size > (allowedMaxFileSize * 1024 * 1024) || fileInfo.fileSize > (allowedMaxFileSize * 1024 * 1024)) { // allow less than 8 MB file
                validFileData = true;
                var msg = 'Maximum 8 MB file size is allowed';

            }

            if (validFileData) {
                this.value = null;
                removePreviewFile();
                $('.file_error').html(msg);
                return false;
            } else {
                
                $('.file_error').html('');
                
                var image_holder = $("#image-holder");
                image_holder.empty();

                var reader = new FileReader();

                reader.onload = function (e) {
                    var imgType = ['jpg', 'jpeg', 'png'];
                    if ($.inArray(extn, imgType) != -1) {
                        var img = $('<img id="dynamic" class="thumb-image" width="75" src="' + e.target.result + '" />' + fileInfo.name + '<a href="javascript:void(0);" class="removePreviewFile" onclick="removePreviewFile();"><i class="fa fa-times" aria-hidden="true"></i></a>');
                    } else {
                        var img = $('<img id="dynamic" class="thumb-image" width="75" src="' + defaultImg + '" />' + fileInfo.name + '<a href="javascript:void(0);" class="removePreviewFile" onclick="removePreviewFile();"><i class="fa fa-times" aria-hidden="true"></i></a>');
                    }

                    img.appendTo(image_holder);
                }

                image_holder.show();
                reader.readAsDataURL($(this)[0].files[0]);
            }
        } else {
            alert("This browser does not support FileReader.");
        }
    });


    /* Remove File if file already Exists*/
    $(".delFile").on('click', function () {
        var imageHolderElement = $(this).parent("#image-holder");
            
        var delete_msg = "Are You Sure Want to Delete Attachment from list ?";
        BootstrapDialog.show(
                {
                    title: 'Information',
                    message: delete_msg,
                    buttons: [{
                            label: 'Cancel',
                            action: function (dialog) {
                                dialog.close();
                            }
                        }, {
                            label: 'Ok',
                            action: function (dialog) {
                                imageHolderElement.html('');
                                $('#removeFile').val('1');
                                dialog.close();
                            }
                        }]
                });
    });
    
    
    // remove preview file and file type also
function removePreviewFile() {
    $('#attachments').val('');
    //$('#image-holder').remove();
    $('#image-holder').html('');

}