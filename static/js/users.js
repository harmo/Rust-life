jQuery(document).ready(function($){

    $('table.user-list-small-device').on('click', '.user-header', function(){
        var user_id = $(this).data('user');
        $(this).next('.user-details').toggle();
    });

});