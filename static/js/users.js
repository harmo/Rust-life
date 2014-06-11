jQuery(document).ready(function($){

    $('.member-table').tablesorter({
        headers: {
            9: {sorter: false}
        }
    });

    $('table.user-list-small-device').on('click', '.user-header', function(){
        var user_id = $(this).data('user');
        $(this).next('.user-details').toggle();
    });

});