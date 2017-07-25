$(document).ready(function () {

    $('#customer_add_edit').parsley();

    $('#installation_date').datetimepicker({format: 'L'});
    /* End - Set Installetion Date and its validation*/

    getVersionDetails($("#version").val()); // on page load call function for get version data

    $("#version").change(function () {

        var selVersionId = $("#version").val();
        $('#hot_cold, #gen, #machine_abb, #mpr, #bev_type').html('--N/A--'); // default set
        $('#assets, #bmb, #tech_status, #sap_purchase_date, #ta_depc_date, #last_pm, #days_till_last_pm').html('--N/A--'); // default set

        getVersionDetails(selVersionId); // on change ajax call for getting version data

    });

    getSrNumberDetails(cuurentSRNumber); // fetch sr number data on

    $("#sr_number").change(function () {

        var selInvnetoryId = $("#sr_number").val();
        var selVersionId = $("#version").val();
        $('#assets, #bmb, #tech_status, #sap_purchase_date, #ta_depc_date, #last_pm, #days_till_last_pm').html('--N/A--'); // default set

        if (selInvnetoryId != '' && selVersionId != '') {
            getSrNumberDetails(selInvnetoryId); // on change ajax call for getting version data
        }

    });
}
);
// set version based other fields data
function getVersionDetails(selVersionId) {

    $.ajax({
        type: "POST",
        url: getSelectedVersionDataURL,
        data: {selVersionId: selVersionId, cuurentSRNumber: cuurentSRNumber},
        async: false,
        beforeSend: function () {
            $('#loader').show(); // show loader
        },
        success: function (resultData) {

            //var versionObj = $.parseJSON(resultData); // json data

            //$('#sr_number').html(versionObj.srDrpDwnData);

            var versionObj = $.parseJSON(resultData); // json data

            if (versionObj.srDrpDwnData != '') {
                $('#no_sr_numberSpan').hide();
                $('#sr_number').show().html(versionObj.srDrpDwnData);
            } else {
                $('#sr_number').hide();
                $('#no_sr_numberSpan').show().html('<div>No Machine (Serial Number) Available</div>');
            }

            if (versionObj != '') {

                $('#hot_cold').html(versionObj.versionData.hot_cold_name);
                $('#gen').html(versionObj.versionData.gen_name);
                $('#machine_abb').html(versionObj.versionData.machine_abb_name);
                $('#mpr').html(versionObj.versionData.machine_mpr_name);
                $('#bev_type').html(versionObj.versionData.bev_type_name);
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

// set SR number based other fields data
function getSrNumberDetails(selInvnetoryId) {

    $.ajax({
        type: "POST",
        url: getSelectedSrNumberDataURL,
        data: {selInvnetoryId: selInvnetoryId}, // <--- THIS IS THE CHANGE
        async: false,
        beforeSend: function () {
            $('#loader').show(); // show loader
        },
        success: function (resultData) {

            var inventoryObj = $.parseJSON(resultData); // json data

            if (inventoryObj.statusCode == 'success') {

                $('#assets').html(inventoryObj.inventoryData.asset);
                $('#bmb').html(inventoryObj.inventoryData.bmb);
                $('#tech_status').html(inventoryObj.inventoryData.technial_status);
                $('#sap_purchase_date').html(inventoryObj.inventoryData.sap_purchase_date);
                $('#ta_depc_date').html(inventoryObj.inventoryData.ta_depc_date);
                $('#last_pm').html('--N/A--');
                $('#days_till_last_pm').html('--N/A--');
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

//image upload
function showimagepreview(input)
{
    $('.upload_recent').remove();
    var url = bas_url;
    $.each(input.files, function (a, b) {
        var rand = Math.floor((Math.random() * 100000) + 3);
        var arr1 = b.name.split('.');
        var arr = arr1[1].toLowerCase();
        var filerdr = new FileReader();
        var img = b.name;
        filerdr.onload = function (e) {
            $('.eachImage').html('');
            var template = '<div class="eachImage upload_recent" id="' + rand + '">';
            var randtest = 'delete_row("' + rand + '")';
            //template += '<a id="delete_row" class="remove_drag_img" onclick=' + randtest + '>×</a>';
            if (arr == 'jpg' || arr == 'jpeg' || arr == 'png' || arr == 'gif') {
                template += '<span class="preview" id="' + rand + '"><img src="' + e.target.result + '" class="thumb-image"><p class="img_name">' + img + '</p><span class="overlay"><span class="updone"></span></span>' + '<a id="delete_row" class="removePreviewFile" onclick=' + randtest + '><i class="fa fa-times" aria-hidden="true"></i></a>';
            } else {
                template += '<span class="preview" id="' + rand + '"><div><img src="' + url + '/uploads/images/icons64/file-64.png"  class="thumb-image"></div><p class="img_name">' + img + '</p><span class="overlay"><span class="updone"></span></span>' + '<a id="delete_row" class="removePreviewFile" onclick=' + randtest + '><i class="fa fa-times" aria-hidden="true"></i></a>';
            }
            template += '<input type="hidden" name="file_data" value="' + b.name + '">';
            template += '</span>';
            $('#dragAndDropFiles').append(template);
        }
        filerdr.readAsDataURL(b);
    });
    var maximum = input.files[0].size / 1024;
}

$('.delete_file').on('click', function () {
    var divId = ($(this).attr('data-id'));
    var imgName = ($(this).attr('data-name'));
    var dataUrl = $(this).attr('data-href');
    var dataPath = $(this).attr('data-path');
    var str1 = divId.replace(/[^\d.]/g, '');
    var delete_meg = "Are you sure you want to delete this item?";
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
                            $('#deletedImagesDiv').append("<input type='hidden' name='softDeletedImages' value='" + str1 + "'> <input type='hidden' name='softDeletedImagesUrls' value='" + dataPath + '/' + imgName + "'>");

                            $('#' + divId).remove();
                            dialog.close();
                        }

                    }]
            });
});


//image upload
function showmachineimagepreview(input)
{
    $('.machine_upload_recent').remove();
    var url = bas_url;
    $.each(input.files, function (a, b) {
        var rand = Math.floor((Math.random() * 100000) + 3);
        var arr1 = b.name.split('.');
        var arr = arr1[1].toLowerCase();
        var filerdr = new FileReader();
        var img = b.name;
        filerdr.onload = function (e) {
            $('.machine').html('');
            var template = '<div class="machine machine_upload_recent" id="' + rand + '">';
            var randtest = 'machine_delete_row("' + rand + '")';
            //template += '<a id="machine_delete_row" class="remove_drag_img" onclick=' + randtest + '>×</a>';
            if (arr == 'jpg' || arr == 'jpeg' || arr == 'png' || arr == 'gif') {
                template += '<span class="preview" id="' + rand + '"><img src="' + e.target.result + '" class="thumb-image"><p class="img_name">' + img + '</p><span class="overlay"><span class="updone"></span></span>' + '<a id="delete_row" class="removePreviewFile" onclick=' + randtest + '><i class="fa fa-times" aria-hidden="true"></i></a>';
            } else {
                template += '<span class="preview" id="' + rand + '"><div><img src="' + url + '/uploads/images/icons64/file-64.png"  class="thumb-image"></div><p class="img_name">' + img + '</p><span class="overlay"><span class="updone"></span></span>' + '<a id="delete_row" class="removePreviewFile" onclick=' + randtest + '><i class="fa fa-times" aria-hidden="true"></i></a>';
            }
            template += '<input type="hidden" name="file_data" value="' + b.name + '">';
            template += '</span>';
            $('#MachinedragAndDropFiles').append(template);
        }
        filerdr.readAsDataURL(b);
    });
    var maximum = input.files[0].size / 1024;
}

$('.machine_delete_file').on('click', function () {
    var divId = ($(this).attr('data-id'));
    var imgName = ($(this).attr('data-name'));
    var dataUrl = $(this).attr('data-href');
    var dataPath = $(this).attr('data-path');
    var str1 = divId.replace(/[^\d.]/g, '');
    var delete_meg = "Are you sure you want to delete this item?";
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
                            $('#machinedeletedImagesDiv').append("<input type='hidden' name='machinesoftDeletedImages' value='" + str1 + "'> <input type='hidden' name='MachinesoftDeletedImagesUrls' value='" + dataPath + '/' + imgName + "'>");

                            $('#' + divId).remove();
                            dialog.close();
                        }

                    }]
            });
});
function delete_row(rand) {

    jQuery('#' + rand).remove();
    $('#upl').val('');
}

function machine_delete_row(rand) {

    jQuery('#' + rand).remove();
    $('#upl_machine').val('');
}


window.Parsley.addValidator('code', function (value, requirement) {
    var response = false;
    var form = $(this);
    var customer_code = $("#customer_code").val();

    $.ajax({
        type: "POST",
        url: check_customer_code_url,
        data: {customer_code: customer_code}, // <--- THIS IS THE CHANGE
        async: false,
        success: function (result) {
            if (result == "true") {
                response = true;
            } else {
                response = false;
            }

        },
        error: function () {
            // alert("Error posting feed.");
            var delete_meg = "Error posting feed";
            BootstrapDialog.show(
                    {
                        title: 'Information',
                        message: delete_meg,
                        buttons: [{
                                label: 'ok',
                                action: function (dialog) {
                                    dialog.close();
                                }
                            }]
                    });
        }
    });

    return response;
}, 46)
        .addMessage('en', 'code', 'Entered Customer Code is already exist.');
$('#customer_reset').click(function () {
    $(window).scrollTop(0);
});

// Remove Assign Maschine to the customer
function delete_assigned_machine(assigned_customer_id, assigned_machine_id, row) {

    var delete_msg = "Are You Sure Want to remove Assigned machine from Customer?";
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
                            //window.location.href = deleteInventoryURL + '/' + inventoryId;
                            $.ajax({
                                type: "POST",
                                url: deleteCustomerURL,
                                data: {customer_assigned_machine_Id: assigned_customer_id, assigned_machine_id: assigned_machine_id},
                                beforeSend: function () {
                                    $('#loader').show(); // show loader
                                },
                                success: function (data) {
                                    
                                    /* var inventoryObj = $.parseJSON(data);
                                     
                                     $('#flashMsg').html(inventoryObj.msg); // set html message
                                     
                                     row.closest('tr').remove(); // remove current row
                                     */
                                    window.location.href = data;
                                },
                                complete: function (data) {
                                    $('#loader').hide(); // show loader
                                },
                                error: function (xhr, status, error) {
                                    var err = JSON.parse(xhr.responseText);
                                    console.log(err.Message);
                                }
                            });
                            dialog.close();
                        }
                    }]
            });
}