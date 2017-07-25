$(document).ready(function () {

    getBothList($('zone_list').val()); // on page load call function for loading Listbox

    $("#zone_assignment").on('submit', function (e) {

        //$('#zone_assignment').parsley();
        var form = $(this);
        form.parsley().validate();
        if (form.parsley().isValid()) {

            /* set Hidden Value */
            var listBoxData1 = new Array();
            var listBoxData2 = new Array();

            $('#lstBox1 option').each(function () {
                listBoxData1.push(this.value);
            });

            $('#lstBox2 option').each(function () {
                listBoxData2.push(this.value);
            });

            $('#selectBox1').val(listBoxData1);
            $('#selectBox2').val(listBoxData2);

            //getBothList($('#zone_list').val());
            
            return true;
        }

        return false;
    });

    $('#zone_list').on('change', function () {

        var selectdZoneId = $('#zone_list').val();

        getBothList(selectdZoneId); //call function for loading Listbox

    });

    $('#btnLeft').click(function () {
        moveItems('#lstBox2', '#lstBox1');
    });

    $('#btnRight').on('click', function () {
        moveItems('#lstBox1', '#lstBox2');
    });

    $('#btnAllLeft').on('click', function () {
        moveAllItems('#lstBox2', '#lstBox1');
    });

    $('#btnAllRight').on('click', function () {
        moveAllItems('#lstBox1', '#lstBox2');
    });

});

function moveItems(origin, dest) {
    $(origin).find(':selected').appendTo(dest);
}

function moveAllItems(origin, dest) {
    $(origin).children().appendTo(dest);
}

// both list box data
function getBothList(selectedZone) {

    $.ajax({
        type: "POST",
        url: getBothSelectBox,
        data: {selectedZone: selectedZone}, // <--- THIS IS THE CHANGE
        async: false,
        beforeSend: function () {
            $('#loader').show(); // show loader
        },
        success: function (resultData) {

            var customerObj = $.parseJSON(resultData); // json data

            $('#lstBox1').html(customerObj.listBox1);
            $('#lstBox2').html(customerObj.listBox2);
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