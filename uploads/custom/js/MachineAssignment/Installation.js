$(document).ready(function () {

    $(document).on('change', '#version_installation', function (evt, params) {
        var selVersionId = $("#version_installation").val();

        $('#hot_cold, #gen, #machine_abb, #mpr, #bev_type').html('--N/A--'); // default set
        $('#assets, #bmb, #tech_status, #sap_purchase_date, #ta_depc_date, #last_pm, #days_till_last_pm').html('--N/A--'); // default set

        getVersionInstallationDetails(selVersionId); // on change ajax call for getting version data
    });

    $(document).on('change', '#sr_number_installation', function (evt, params) {

        var selInvnetoryId = $("#sr_number_installation").val();
        var selVersionId = $("#version_installation").val();
        $('#assets, #bmb, #tech_status, #sap_purchase_date, #ta_depc_date, #last_pm, #days_till_last_pm').html('--N/A--'); // default set

        if (selInvnetoryId != '' && selVersionId != '') {
            getSrNumberInstallationDetails(selInvnetoryId); // on change ajax call for getting version data
        }
    });

});

// set version based other fields data
function getVersionInstallationDetails(selVersionId) {

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
                $('#sr_number_installation').show().html(versionObj.srDrpDwnData);
            } else {
                $('#sr_number_installation').hide();
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
function getSrNumberInstallationDetails(selInvnetoryId) {

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
                $('#tech_status').html(inventoryObj.inventoryData.machine_tech_status);
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
