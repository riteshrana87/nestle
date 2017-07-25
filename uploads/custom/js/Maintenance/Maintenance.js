$(document).ready(function () {

    $('#maintenance_add_edit').parsley();  //parsley validation
    
    $('.chosen-select').chosen({search_contains: true});    

    updateCustomerInfo(customerCodeId, 'code'); // function call for update data 
    //
    // Request Type show/hide on page load
    if ($('#request_type').val() === 'cm') {
        $('#preventive_maintenance_radio').show();
    } else {
        $('#preventive_maintenance_radio').hide();
    }

    // Request Type show/hide on change
    $(document).on("change", "#request_type", function () {
        if ($('#request_type').val() === 'cm') {
            $('#preventive_maintenance_radio').show();
        } else {
            $('#preventive_maintenance_radio').hide();
        }
    });
    
    // On click custome code
    $(document).on('click', '.cust_code_class', function (evt, params) {
        var selectedCustomerCode = $('#cust_code').find('option:selected').val();  // get selecetd customer code
        updateCustomerInfo(selectedCustomerCode, 'code'); // call function for fetching data
    });

    // On click custome name
    $(document).on('click', '.cust_name_class', function (evt, params) {

        var selectedCustomerName = $(this).text();
        var selectedCustomerNameValue = $('#cust_name').find('option:selected').val();  // get selecetd customer code
        //alert(selectedCustomerNameValue);
        if (selectedCustomerNameValue != '') {
            getLocationsPopUp(selectedCustomerName); // Open Pop Up
        } else {
            updateCustomerInfo('', 'name'); // Update Customer Info data
        }
    });

    $(document).on('click', '.sr_number_class', function (evt, params) {
        var selectedSerialNumber = $('#machine_sr_number').find('option:selected').val();  // get selecetd customer code

        updateCustomerInfo(selectedSerialNumber, 'sr_number');

    });

    //on close popup
    $('#myModal').on('hidden.bs.modal', function (e) {

        var selectedLocationCustomerId = $('input[name=customer_radio]:radio:checked').val();

        updateCustomerInfo(selectedLocationCustomerId, 'name'); // Update Customer Info data

        $('#location_id').val(selectedLocationCustomerId); // set current location select

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
function updateCustomerInfo(customerId, searchType) {

    $.ajax({
        type: "POST",
        url: getCustomerDetailsURL,
        data: {selCustomerId: customerId, searchType: searchType},
        async: false,
        beforeSend: function () {
            $('#cust_number, #cust_location, #asset_number, #machine_id').html('--N/A--');
            $('#loader').show(); // show loader
        },
        success: function (resultData) {

            var customerObj = $.parseJSON(resultData); // json data

            if (customerObj != '') {

                //$('#cust_name').html(customerObj.customer_name);
                $('#cust_number').html(customerObj.customer_mobile_number);
                $('#cust_location').html(customerObj.customer_location);
                $('#serial_number').html(customerObj.serial_number);
                $('#asset_number').html(customerObj.asset);
                $('#machine_id').html(customerObj.machine_id);
                $('#location_id').val(customerObj.customer_id);
                $('#assigned_to').val(customerObj.assigned_to);

                if (searchType != 'code') {
                    $('#cust_code').val(customerObj.customer_id);
                    $("#cust_code").trigger("chosen:updated");
                }

                if (searchType != 'name') {
                    $('#cust_name').val(customerObj.customer_name);
                    $("#cust_name").trigger("chosen:updated");
                }

                if (searchType != 'sr_number') {
                    $('#machine_sr_number').val(customerObj.machine_sr_id);
                    $("#machine_sr_number").trigger("chosen:updated");
                }

            } else {
                $('#cust_code').val('');
                $("#cust_code").trigger("chosen:updated");
                $('#cust_name').val('');
                $("#cust_name").trigger("chosen:updated");
                $('#machine_sr_number').val('');
                $("#machine_sr_number").trigger("chosen:updated");
                $('#assigned_to').val('');
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
