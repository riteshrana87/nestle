function delete_inventory(inventoryId, row) {

    var delete_msg = "Are You Sure Want to Delete 'Machine Inventory' from list ?";
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
                                url: deleteInventoryURL,
                                data: {inventoryId: inventoryId},
                                beforeSend: function () {
                                    $('#loader').show(); // show loader
                                },
                                success: function (data) {
                                    //var inventoryObj = $.parseJSON(data);
                                    //$('#flashMsg').html(inventoryObj.msg); // set html message
                                    //row.closest('tr').remove(); // remove current row
                                    window.location.href = data;
                                },
                                complete: function (data) {
                                    $('#loader').hide(); // show loader
                                },
                                error: function (data) {

                                }
                            });
                            dialog.close();
                        }
                    }]
            });
}