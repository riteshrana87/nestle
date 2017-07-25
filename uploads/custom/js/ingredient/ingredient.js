/**
 * Created by r.rana on 3/9/2017.
 */
$(document).ready(function () {
    var formAction ="";
    $('#category').parsley();

    $('.chosen-select').chosen();
    $('.chosen-select-salution').chosen();
    $('.chosen-select-status').chosen();
});

function delete_request(CatId){
    var delete_meg ="Are You Sure Want to Delete 'Ingredient Master' from list ?";
    BootstrapDialog.show(
        {
            title: 'Information',
            message: delete_meg,
            buttons: [{
                label: 'Cancel',
                action: function(dialog) {
                    dialog.close();
                }
            }, {
                label: 'ok',
                action: function(dialog) {
                    window.location.href = baseurl +'/IngredientMaster/deletedata/' + CatId;
                    dialog.close();
                }
            }]
        });
}