$(document).ready(function () {

    $('#customer_machine_assign').parsley();

    $('.chosen-select').chosen({search_contains: true});
    $('.chosen-select-name').chosen({search_contains: true});


    // On click customer code field
    $(document).on('click', '.cust_code_class', function (evt, params) {
        //var selectedCustomerCode = $(this).text();  // get selecetd customer code
        var selectedCustomerCode = $('#cust_code').find('option:selected').val();  // get selecetd customer code
        updateCustomerInfo(selectedCustomerCode, 'code');
        $('#customer_id').val(selectedCustomerCode); // set current location select
        machine_assignment_type(); // Load Page
    });

    // On click customer name field
    $(document).on('click', '.cust_name_class', function (evt, params) {

        var selectedCustomerName = $(this).text();  // get selecetd customer code
        var selectedCustomerNameValue = $('#cust_name').find('option:selected').val();  // get selecetd customer code

        if (selectedCustomerNameValue != '') {
            getLocationsPopUp(selectedCustomerName); // Open Pop Up
        } else {
            updateCustomerInfo(selectedCustomerNameValue, 'name'); // Update Customer Info data
        }

    });

    $('#myModal').on('hidden.bs.modal', function (e) {
        var selectedCustomerId = $('input[name=customer_radio]:radio:checked').val();

        updateCustomerInfo(selectedCustomerId, 'name'); // Update Customer Info data
        $('#customer_id').val(selectedCustomerId); // set current location select
        machine_assignment_type(); // Load Page
    });


    machine_assignment_type(); // Call On load page
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
                    $('#cust_name').val(customerObj.customer_name);
                    $("#cust_name").trigger("chosen:updated");
                }

                $('#cust_number').html(customerObj.customer_mobile_number);
                $('#cust_location').html(customerObj.customer_location);
                $('#cust_email').html(customerObj.customer_email);
                $('#cust_route').html(customerObj.customer_route_name);
            } else {

                $('#cust_code').val('');
                $("#cust_code").trigger("chosen:updated");
                $('#cust_name').val('');
                $("#cust_name").trigger("chosen:updated");
                $('#machine_sr_number').val('');
                $("#machine_sr_number").trigger("chosen:updated");
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

//load Page based on type selected
function machine_assignment_type()
{
    var assignment_type = $('#assignment_type').val();
    var customer_name = $('#cust_name').val();
    var customer_code = $('#cust_code').val();

    if (customer_name == '' && customer_code == '') {
        $("#assignment_detail").html('Note : Please Select Customer Name and Customer Code');
        return false;
    }

    getMachineHtml(assignment_type); //call function
}

function getMachineHtml(assignment_type) {

    var request_url = baseurl + 'MachineAssignment/assignmentData';

    $.ajax({
        type: "POST",
        url: request_url,
        data: {'assignment_type': assignment_type, customerId: $('#customer_id').val()},
        success: function (html) {
            $("#assignment_detail").html(html);

        }
    });
    return true;
}

// Delete Assigned Machine
function delete_assign_machine(assigned_customer_id, assigned_machine_id, row) {

    var delete_msg = "Are You Sure Want to remove Assigned machine from Customer ?";
    
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
                            $.ajax({
                                type: "POST",
                                url: deleteAssignMachineURL,
                                data: {customer_assigned_machine_Id: assigned_customer_id, assigned_machine_id: assigned_machine_id},
                                beforeSend: function () {
                                    $('#loader').show(); // show loader
                                },
                                success: function (data) {
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