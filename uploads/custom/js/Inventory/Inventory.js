$(document).ready(function () {


    $('#sap_purchase_date').datetimepicker({format: 'L'});
    $('#ta_depc_date').datetimepicker({format: 'L'});
    $('#inst_date').datetimepicker({format: 'L'});
    $('#machine_preparation_date').datetimepicker({format: 'L'});

    /*$('#sap_purchase_date').datepicker({
     format: "dd/mm/yyyy"
     });
     
     $('#ta_depc_date').datepicker({
     format: "dd/mm/yyyy"
     });
     
     $('#inst_date').datepicker({
     format: "dd/mm/yyyy"
     });
     
     $('#machine_preparation_date').datepicker({
     format: "dd/mm/yyyy"
     });*/

    $('#inventory_add_edit').parsley();

    if ($("#version").val() != '') {
        getVersionDetails($("#version").val()); // on page load call function for get version data
    }

    $("#version").change(function () {

        var selVersionId = $("#version").val();

        $('#hot_cold, #gen, #machine_abb, #mpr, #bev_type').html('--N/A--'); // default set 

        if (selVersionId != '') {
            getVersionDetails(selVersionId); // on change ajax call for getting version data
        }

    });

});

window.Parsley.addValidator('machine_sr_number', function (value, requirement) {

    var response = false;
    var currentSerialNumber = $("#machine_sr_number").val();

    $.ajax({
        type: "POST",
        url: checkSerialNumberUniqueURL,
        data: {currentSerialNumber: currentSerialNumber, inventory_id: inventory_id},
        async: false,
        success: function (result) {
            //response = result;
            if (result == 1) {
                response = false;
            } else {
                response = true;
            }
        },
        error: function () {
            // alert("Error posting feed.");
            var error_msg = "";
            BootstrapDialog.show(
                    {
                        title: 'Information',
                        message: error_msg,
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
}, 32).addMessage('en', 'machine_sr_number', 'Entered Serial Number is already exist.');

// set version based other fields data
function getVersionDetails(selVersionId) {

    $.ajax({
        type: "POST",
        url: getSelectedVersionDataURL,
        data: {selVersionId: selVersionId}, // <--- THIS IS THE CHANGE
        async: true,
        beforeSend: function () {
            $('#loader').show(); // show loader
        },
        success: function (resultData) {

            var versionObj = $.parseJSON(resultData); // json data

            if (versionObj.statusCode == 'success') {

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
        error: function () {

        }
    });
}

function delete_inventory(inventoryId, row) {

    var delete_meg = "Are You Sure Want to Delete 'Machine Inventory' from list ?";
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
                        label: 'Ok',
                        action: function (dialog) {
                            //window.location.href = deleteInventoryURL + '/' + inventoryId;
                            $.ajax({
                                type: "POST",
                                url: deleteInventoryURL,
                                data: {inventoryId: inventoryId},
                                beforeSend: function () {
                                    $('#loader').show(); // show loader
                                },
                                success: function (data) {
                                    var inventoryObj = $.parseJSON(data);
                                    $('#customMsg').html(inventoryObj.msg); // set html message
                                    row.closest('tr').remove(); // remove current row
                                },
                                complete: function (data) {
                                    $('#loader').hide(); // show loader
                                },
                                error: function (data) {

                                }
                            });
                            dialog.close();
                        }
                    }]
            });
}