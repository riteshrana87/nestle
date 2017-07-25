function delete_feedback(feedBackId, row) {

    var delete_msg = "Are You Sure Want to Delete 'Feedback' from list ?";
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
                            //window.location.href = deleteInventoryURL + '/' + inventoryId;
                            $.ajax({
                                type: "POST",
                                url: deleteFeedBackURL,
                                data: {feedBackId: feedBackId},
                                beforeSend: function () {
                                    $('#loader').show(); // show loader
                                },
                                success: function (data) {
                                    /* var inventoryObj = $.parseJSON(data);
                                     
                                     $('#flashMsg').html(inventoryObj.msg); // set html message
                                     
                                     row.closest('tr').remove(); // remove current row
                                     */
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