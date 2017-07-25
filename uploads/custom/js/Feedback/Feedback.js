$(document).ready(function () {
    $('#feedback_date').datetimepicker({format: 'L'});
    $('#ticket_date').datetimepicker({format: 'L'});
    $('.chosen-select').chosen({search_contains: true});

    // On click custome name
    $(document).on('click', '.cust_name_class', function (evt, params) {

        var selectedCustomerName = $(this).text();
        var selectedCustomerNameValue = $('#customer_name').find('option:selected').val();  // get selecetd customer code
        
        if (selectedCustomerNameValue != '') {
            getLocationsPopUp(selectedCustomerName); // Open Pop Up
        }
    });
    
    //on close popup
    $('#myModal').on('hidden.bs.modal', function (e) {

        var selectedLocationCustomerId = $('input[name=customer_radio]:radio:checked').val();
        $('#customer_id').val(selectedLocationCustomerId); // set customer id based on the location select

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
