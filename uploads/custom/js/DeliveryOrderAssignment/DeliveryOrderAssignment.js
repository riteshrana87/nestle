$('.chosen-select').chosen({search_contains: true});
$('.data_code').chosen({search_contains: true});
$('.chosen-select-cat').chosen({search_contains: true});
$('.chosen-select-subcat').chosen({search_contains: true});

$(function () {

    $('.chosen-select').chosen();
    $('#deliveryfrm').parsley();//parsaley validation reload
    $('#delivery_date').datetimepicker();
    //disabled after submit
    $('body').delegate('#submit_btn', 'click', function () {
        if ($('#deliveryfrm').parsley().isValid()) {
            $('input[type="submit"]').prop('disabled', true);
            $('#deliveryfrm').submit();
        }
    });
});
