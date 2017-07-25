$(document).ready(function () {

    $(document).on('change', '#version_pullout', function (evt, params) {

        var selVersionId = $("#version_pullout").val();
        var selCustomerId = $('#customer_id').val();

        $('#hot_cold, #gen, #machine_abb, #mpr, #bev_type').html('--N/A--'); // default set
        $('#assets, #bmb, #tech_status, #sap_purchase_date, #ta_depc_date, #last_pm, #days_till_last_pm').html('--N/A--'); // default set

        getVersionDetailsPullout(selVersionId, selCustomerId); // on change ajax call for getting version data
    });

    $(document).on('change', '#sr_number_pullout', function (evt, params) {
        var selInvnetoryId = $("#sr_number_pullout").val();
        var selVersionId = $("#version_pullout").val();
        $('#assets, #bmb, #tech_status, #sap_purchase_date, #ta_depc_date, #last_pm, #days_till_last_pm').html('--N/A--'); // default set

        if (selVersionId != '') {
            getSrNumberDetailsPullout(selInvnetoryId, selVersionId); // on change ajax call for getting version data
        }
    });


});

// set version based other fields data
function getVersionDetailsPullout(selVersionId, selCustomerId) {

    $.ajax({
        type: "POST",
        url: getVersionDataPullOut,
        data: {selVersionId: selVersionId, selCustomerId: selCustomerId},
        async: false,
        beforeSend: function () {
            $('#loader').show(); // show loader
        },
        success: function (resultData) {
            var versionObj = $.parseJSON(resultData); // json data

            //$('#sr_number_pullout').html(versionObj.srDrpDwnData);
            
            if (versionObj.srDrpDwnData != '') {
                $('#no_sr_numberSpan').hide();
                $('#sr_number_pullout').show().html(versionObj.srDrpDwnData);
            } else {
                $('#sr_number_pullout').hide();
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
function getSrNumberDetailsPullout(selInvnetoryId, selVersionId) {

    $.ajax({
        type: "POST",
        url: getSelectedSrNumberDataPullOut,
        data: {selVersionId: selVersionId, selInvnetoryId: selInvnetoryId},
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

                $('#installation_date').html(inventoryObj.inventoryData.installation_date);
                $('#zone').html(inventoryObj.inventoryData.zone_name);
                $('#machine_installed_location').html(inventoryObj.inventoryData.machine_installed_location);
                $('#serving_size').html(inventoryObj.inventoryData.serving_size_name);

                if (!isEmpty(inventoryObj.inventoryData.machine_picture)) {
                    $('#machine_picture').html('<img width="100" height="100"  src=" ' + machinePicturePath + inventoryObj.inventoryData.customer_machine_information_id + '/' + inventoryObj.inventoryData.machine_picture + '" />');
                } else {
                    $('#machine_picture').html('--N/A--');
                }
                
                if (!isEmpty(inventoryObj.inventoryData.machine_menu_file)) {
                    $('#machine_menu_file').html('<a href="' + machinePicturePath + inventoryObj.inventoryData.customer_machine_information_id + '/Menu/' + inventoryObj.inventoryData.machine_menu_file + '" download > '+inventoryObj.inventoryData.machine_menu_file+'</a>');
                } else {
                    $('#machine_menu_file').html('--N/A--');
                }
                
                $('#special_note').html(inventoryObj.inventoryData.machine_comment);
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