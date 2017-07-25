$(document).ready(function () {

    $(document).on('change', '#version_replacement', function (evt, params) {

        var selVersionId = $("#version_replacement").val();
        var selCustomerId = $('#customer_id').val();

        $('#hot_cold, #gen, #machine_abb, #mpr, #bev_type').html('--N/A--'); // default set
        $('#assets, #bmb, #tech_status, #sap_purchase_date, #ta_depc_date, #last_pm, #days_till_last_pm').html('--N/A--'); // default set

        getVersionDetailsReplacement(selVersionId, selCustomerId); // on change ajax call for getting version data
    });

    $(document).on('change', '#sr_number_replacement', function (evt, params) {

        var selInvnetoryId = $("#sr_number_replacement").val();
        var selVersionId = $("#version_replacement").val();
        $('#assets, #bmb, #tech_status, #sap_purchase_date, #ta_depc_date, #last_pm, #days_till_last_pm').html('--N/A--'); // default set

        if (selVersionId != '') {
            getSrNumberDetailsReplacement(selInvnetoryId, selVersionId); // on change ajax call for getting version data
        }
    });

    $(document).on('change', '#version_assign', function (evt, params) {
        var selVersionId = $("#version_assign").val();

        $('#hot_cold_assign, #gen_assign, #machine_abb_assign, #mpr_assign, #bev_type_assign').html('--N/A--'); // default set
        $('#assets_assign, #bmb_assign, #tech_status_assign, #sap_purchase_date_assign, #ta_depc_date_assign, #last_pm_assign, #days_till_last_pm_assign').html('--N/A--'); // default set

        getVersionDetailsAssign(selVersionId); // on change ajax call for getting version data
    });

    $(document).on('change', '#sr_number_assign', function (evt, params) {


        var selInvnetoryId = $("#sr_number_assign").val();
        var selVersionId = $("#version_assign").val();
        $('#assets_assign, #bmb_assign, #tech_status_assign, #sap_purchase_date_assign, #ta_depc_date_assign, #last_pm_assign, #days_till_last_pm_assign').html('--N/A--'); // default set

        if (selVersionId != '') {
            getSrNumberAssign(selInvnetoryId); // on change ajax call for getting version data
        }
    });

});

// set version based other fields data
function getVersionDetailsReplacement(selVersionId, selCustomerId) {

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

            //$('#sr_number_replacement').html(versionObj.srDrpDwnData);
            
            if (versionObj.srDrpDwnData != '') {
                $('#no_sr_numberSpanReplace').hide();
                $('#sr_number_replacement').show().html(versionObj.srDrpDwnData);
            } else {
                $('#sr_number_replacement').hide();
                $('#no_sr_numberSpanReplace').show().html('<div>No Machine (Serial Number) Available</div>');
            }

            if (versionObj != '') {

                $('#hot_cold_replacement').html(versionObj.versionData.hot_cold_name);
                $('#gen_replacement').html(versionObj.versionData.gen_name);
                $('#machine_abb_replacement').html(versionObj.versionData.machine_abb_name);
                $('#mpr_replacement').html(versionObj.versionData.machine_mpr_name);
                $('#bev_type_replacement').html(versionObj.versionData.bev_type_name);
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
function getSrNumberDetailsReplacement(selInvnetoryId, selVersionId) {

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

                $('#assets_replacement').html(inventoryObj.inventoryData.asset);
                $('#bmb_replacement').html(inventoryObj.inventoryData.bmb);
                $('#tech_status_replacement').html(inventoryObj.inventoryData.technial_status);
                $('#sap_purchase_date_replacement').html(inventoryObj.inventoryData.sap_purchase_date);
                $('#ta_depc_date_replacement').html(inventoryObj.inventoryData.ta_depc_date);
                $('#last_pm_replacement').html('--N/A--');
                $('#days_till_last_pm_replacement').html('--N/A--');

                $('#installation_date_replacement').html(inventoryObj.inventoryData.installation_date);
                $('#zone_replacement').html(inventoryObj.inventoryData.zone_name);
                $('#machine_installed_location_replacement').html(inventoryObj.inventoryData.machine_installed_location);
                $('#serving_size_replacement').html(inventoryObj.inventoryData.serving_size_name);

                if (inventoryObj.inventoryData.machine_picture != '') {
                    $('#machine_picture_replacement').html('<img width="100" height="100"  src=" ' + machinePicturePath + inventoryObj.inventoryData.customer_machine_information_id + '/' + inventoryObj.inventoryData.machine_picture + '" />');
                } else {
                    $('#machine_picture_replacement').html('--N/A--');
                }

                if (inventoryObj.inventoryData.machine_menu_file != '') {
                    $('#machine_menu_file_replacement').html('<a href="' + machinePicturePath + inventoryObj.inventoryData.customer_machine_information_id + '/Menu/' + inventoryObj.inventoryData.machine_menu_file + '" download > ' + inventoryObj.inventoryData.machine_menu_file + '</a>');
                } else {
                    $('#machine_menu_file_replacement').html('--N/A--');
                }

                $('#special_note_replacement').html(inventoryObj.inventoryData.machine_comment);
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
function getVersionDetailsAssign(selVersionId) {

    $.ajax({
        type: "POST",
        url: getSelectedVersionDataURL,
        data: {selVersionId: selVersionId},
        async: false,
        beforeSend: function () {
            $('#loader').show(); // show loader
        },
        success: function (resultData) {

            var versionObj = $.parseJSON(resultData); // json data

            if (versionObj.srDrpDwnData != '') {
                $('#no_sr_numberSpan').hide();
                $('#sr_number_assign').show().html(versionObj.srDrpDwnData);
            } else {
                $('#sr_number_assign').hide();
                $('#no_sr_numberSpan').show().html('<div>No Machine (Serial Number) Available</div>');
            }

            if (versionObj != '') {

                $('#hot_cold_assign').html(versionObj.versionData.hot_cold_name);
                $('#gen_assign').html(versionObj.versionData.gen_name);
                $('#machine_abb_assign').html(versionObj.versionData.machine_abb_name);
                $('#mpr_assign').html(versionObj.versionData.machine_mpr_name);
                $('#bev_type_assign').html(versionObj.versionData.bev_type_name);
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
function getSrNumberAssign(selInvnetoryId) {

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

                $('#assets_assign').html(inventoryObj.inventoryData.asset);
                $('#bmb_assign').html(inventoryObj.inventoryData.bmb);
                $('#tech_status_assign').html(inventoryObj.inventoryData.technial_status);
                $('#sap_purchase_date_assign').html(inventoryObj.inventoryData.sap_purchase_date);
                $('#ta_depc_date_assign').html(inventoryObj.inventoryData.ta_depc_date);
                $('#last_pm_assign').html('--N/A--');
                $('#days_till_last_pm_assign').html('--N/A--');
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