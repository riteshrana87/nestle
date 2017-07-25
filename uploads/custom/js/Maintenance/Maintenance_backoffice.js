$(document).ready(function () {

    $('#maintenance_add_edit').parsley();
    $('.chosen-select').chosen({search_contains: true});
    
    $('#response_date').datetimepicker({format: 'L'});
    $('#visited_date').datetimepicker({format: 'L'});
});