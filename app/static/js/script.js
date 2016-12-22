$(document).ready(function () {
    $('#add_user_form select[name="role_id"]').change(function () {
        if ($('#add_user_form select[name="role_id"] option:selected').val() == '3') {
            $('#phone-0').parent().closest('div').parent().closest('div').show();
            $('#user_address-0').parent().closest('div').parent().closest('div').show();
            $('#user_post-0').parent().closest('div').parent().closest('div').show();
            $('#user_city-0').parent().closest('div').parent().closest('div').show();
            $('#user_country-0').parent().closest('div').parent().closest('div').show();
        } else {
            $('#phone-0').parent().closest('div').parent().closest('div').hide();
            $('#user_address-0').parent().closest('div').parent().closest('div').hide();
            $('#user_post-0').parent().closest('div').parent().closest('div').hide();
            $('#user_city-0').parent().closest('div').parent().closest('div').hide();
            $('#user_country-0').parent().closest('div').parent().closest('div').hide();
        }
    });
});