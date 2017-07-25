/**
 * Created by r.rana on 3/9/2017.
 */
$(document).ready(function () {
    var formAction ="";
    $('#items').parsley();
    $('.chosen-select-ingredient').chosen();
    $('.chosen-select').chosen();
});

function delete_request(CatId){
    var delete_meg ="Are You Sure Want to Delete 'Ingredient Type' from list ?";
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
                    window.location.href = baseurl +'/IngredientType/deletedata/' + CatId;
                    dialog.close();
                }
            }]
        });
}