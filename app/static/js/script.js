function updateFields(){
    if ($('#add_user_form select[name="role_id"] option:selected').val() == '3') {
        $('#add_user_form #phone-0').parent().closest('div').parent().closest('div').show();
        $('#add_user_form #user_address-0').parent().closest('div').parent().closest('div').show();
        $('#add_user_form #user_post-0').parent().closest('div').parent().closest('div').show();
        $('#add_user_form #user_city-0').parent().closest('div').parent().closest('div').show();
        $('#add_user_form #user_country-0').parent().closest('div').parent().closest('div').show();
    } else {
        $('#add_user_form #phone-0').parent().closest('div').parent().closest('div').hide();
        $('#add_user_form #user_address-0').parent().closest('div').parent().closest('div').hide();
        $('#add_user_form #user_post-0').parent().closest('div').parent().closest('div').hide();
        $('#add_user_form #user_city-0').parent().closest('div').parent().closest('div').hide();
        $('#add_user_form #user_country-0').parent().closest('div').parent().closest('div').hide();
    }
}
$(document).ready(updateFields());
$(document).ready(function () {
    $('#add_user_form select[name="role_id"]').change(updateFields);
});