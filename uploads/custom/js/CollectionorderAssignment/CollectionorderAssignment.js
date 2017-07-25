$(document).ready(function () {

    $('#co_add_edit').parsley();

    $('.chosen-select').chosen({search_contains: true});
    $('.chosen-select-name').chosen({search_contains: true});

    $('.chosen-select').chosen({search_contains: true});
    $('.chosen-select-name').chosen({search_contains: true});

    var selectedCustomerCode = $('#cust_code').val();  // get selecetd customer code
    updateCustomerInfo(selectedCustomerCode, 'code');

    // On click customer code field
    $(document).on('click', '.cust_code_class', function (evt, params) {
        var selectedCustomerCode = $(this).text();  // get selecetd customer code
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
        var selectedSrNumber = $('#sr_number_installation option:selected').val();//$(this).text();  // get selecetd customer code
        updateInventoryInfo(selectedSrNumber);
    });

    $('#myModal').on('hidden.bs.modal', function (e) {
        var selectedCustomerId = $('input[name=customer_radio]:radio:checked').val();
        updateCustomerInfo(selectedCustomerId, 'name'); // Update Customer Info data
        $('#customer_id').val(selectedCustomerId); // set current location select
        getSrNumberDetails(selectedCustomerId);
    });




    /* Delete Add more row */
    $(document).on("click", ".delete", function (e) {

        var currentRow = $(this);
        var delete_msg = "Are You Sure Want to Delete Cheque Information from list ?";

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

                                currentRow.parent().parent().remove(); // remove current deleted row

                                sumTotalAmount(); // update sum total Amount

                                dialog.close();
                            }
                        }]
                });
    });
    /* Delete Add more row */

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

    // for Preview the Attchment
    $("#location_attachments").on('change', function () {
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
                locremovePreviewFile();
                $('.loc_file_error').html(msg);
                return false;
            } else {

                $('.loc_file_error').html('');

                var image_holder = $("#location-image-holder");
                image_holder.empty();

                var reader = new FileReader();

                reader.onload = function (e) {
                    var imgType = ['jpg', 'jpeg', 'png'];
                    if ($.inArray(extn, imgType) != -1) {
                        var img = $('<img id="dynamic" class="thumb-image" width="75" src="' + e.target.result + '" />' + fileInfo.name + '<a href="javascript:void(0);" class="locremovePreviewFile" onclick="locremovePreviewFile();"><i class="fa fa-times" aria-hidden="true"></i></a>');
                    } else {
                        var img = $('<img id="dynamic" class="thumb-image" width="75" src="' + defaultImg + '" />' + fileInfo.name + '<a href="javascript:void(0);" class="locremovePreviewFile" onclick="locremovePreviewFile();"><i class="fa fa-times" aria-hidden="true"></i></a>');
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
    $(".locdelFile").on('click', function () {
        var imageHolderElement = $(this).parent("#location-image-holder");

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
                        $('#removeLocationFile').val('1');
                        dialog.close();
                    }
                }]
            });
    });


});

// remove preview file and file type also
function locremovePreviewFile() {
    $('#location_attachments').val('');
    //$('#image-holder').remove();
    $('#location-image-holder').html('');

}

// remove preview file and file type also
function removePreviewFile() {
    $('#attachments').val('');
    //$('#image-holder').remove();
    $('#image-holder').html('');

}

// Sum total amount
function sumTotalAmount() {
    var sum = 0;
    $(".amount").each(function () {
        sum += +$(this).val();
    });
    $("#total_amount").html(sum.toFixed(2));
}

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
            $('#cust_number, #cust_location, #cust_email, #cust_route').html('--N/A--');
            $('#loader').show(); // show loader
        },
        success: function (resultData) {
            var customerObj = $.parseJSON(resultData); // json data

            if (customerObj != '') {

                if (selType == 'name') {
                    $('#cust_code').val(customerObj.customer_id);
                    $("#cust_code").trigger("chosen:updated");
                }

                if (selType == 'code') {
                    $('#cust_name').val(customerObj.customer_id);
                    $("#cust_name").trigger("chosen:updated");
                }

                getSrNumberDetails(customerObj.customer_id);
                /*if (selType == 'code') {
                 $('#cust_name').val(customerObj.customer_id);
                 $("#cust_code").trigger("chosen:updated");
                 }*/
                $('#contact_name').html(customerObj.contact_name);
                $('#contact_number').html(customerObj.contact_number);
                $('#mobile_number').html(customerObj.customer_mobile_number);
                $('#cust_location').html(customerObj.customer_location);
                $('#cust_email').html(customerObj.customer_email);
                $('#cust_route').html(customerObj.customer_route_name);
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
            $('#cust_number, #cust_location, #cust_email, #cust_route').html('--N/A--');
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


