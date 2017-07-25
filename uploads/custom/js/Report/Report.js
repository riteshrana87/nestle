$(document).ready(function () {

    // $('#generate_report_form').parsley();  //parsley validation

    $('#start_date').datetimepicker({format: 'L'});
    $('#end_date').datetimepicker({format: 'L'});

    // Type changes 
    $('#report_type').on('change', function (e) {

        $('#report_status_div').hide();

        var reportType = $('#report_type').val();
        var allowStatusType = ['maintenance_report', 'collection_report', 'delivery_report'];

        //alert($.inArray(reportType, allowStatusType));
        $('#common_div').html('');
        $('#report_status').val('');
        $('#report_status').removeAttr('required');
        $('#report_status').removeAttr('data-parsley-required-message');
        if ($.inArray(reportType, allowStatusType) != -1) {

            $('#report_status').attr("required", true);
            $('#report_status').attr("data-parsley-required-message", 'Please Select Report Status');
            $('#report_status_div').show();
            var select = $('#report_status');

            if (reportType === 'delivery_report') {
                var newOptions = {
                    '': 'Select Report Status',
                    'In Progress': 'In Progress',
                    'Successfully delivered': 'Successfully Delivered'
                };
            } else {
                var newOptions = {
                    '': 'Select Report Status',
                    'open': 'Open',
                    'closed': 'Closed'
                };
            }


            $('option', select).remove();
            $.each(newOptions, function (text, key) {
                var option = new Option(key, text);
                select.append($(option));
            });
            //$('#report_status_div').append('<option value="open">Open</option><option value="closed">Closed</option>').show();
        }
    });

    // On Form Submit
    $("#generate_report_form").on('submit', function (e) {

        e.preventDefault();
        var form = $(this);

        form.parsley().validate();

        if (form.parsley().isValid()) {

            $.ajax({
                url: showReportURL,
                data: $(this).serialize(),
                type: 'POST',
                success: function (data) {
                    $('#common_div').html(data);
                },
                error: function (data) {
                    $("#error").show().fadeOut(20000); //===Show Error Message====
                }
            });
        }
    });

    // On clcik generate excel file
    $(document).on('click', '#exportFile', function (evt, params) {

        $.ajax({
            type: 'POST',
            url: generateExcelFileURL,
            data: $("#generate_report_form").serialize(),
        }).done(function (data) {
            window.open(data, '_blank');
        });

    });

});
