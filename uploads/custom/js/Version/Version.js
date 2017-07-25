$(document).ready(function () {
    $('#version_add_edit').parsley();
});

window.Parsley.addValidator('version', function (value, requirement) {

    var response = false;
    var currentVerisonName = $("#version").val();

    $.ajax({
        type: "POST",
        url: checkVersionNameUniqueURL,
        data: {versionName: currentVerisonName, version_id: version_id}, // <--- THIS IS THE CHANGE
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
}, 32).addMessage('en', 'version', 'Entered Vesrion Name is already exist.');

function changeStatus(versionId, versionStatus) {

    var confirm_msg = "Are you sure want to change status ?";
    BootstrapDialog.show(
            {
                title: 'Information',
                message: confirm_msg,
                buttons: [{
                        label: 'Cancel',
                        action: function (dialog) {
                            dialog.close();
                        }
                    }, {
                        label: 'ok',
                        action: function (dialog) {
                            //window.location.href = baseurl + '/Vesrion/deletedata/' + versionId;
                            $.ajax({
                                type: "POST",
                                url: changeStatusURL,
                                data: {version_id: versionId, versionStatus: versionStatus}, // <--- THIS IS THE CHANGE
                                success: function (data) {
                                    var obj = jQuery.parseJSON(data);

                                    if (obj.statusCode == 'success') {
                                        alert(obj.updateStatus);
                                        $('#status_' + versionId).html(obj.updateStatus);
                                    }
                                }
                            });
                            dialog.close();
                        }
                    }]
            });

}

/*function delete_version(versionId) {
 
 var delete_meg = "Are You Sure Want to Delete 'Version' from list ?";
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
 label: 'ok',
 action: function (dialog) {
 //window.location.href = baseurl + '/Vesrion/deletedata/' + versionId;
 $.ajax({
 type: "POST",
 url: deleteVersion,
 data: {version_id: versionId}, // <--- THIS IS THE CHANGE
 success: function (data) {
 alert(data);
 }
 });
 dialog.close();
 }
 }]
 });
 }*/