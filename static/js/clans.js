jQuery(document).ready(function($){

    $('#members').select2({
        placeholder: 'Choisir un ou plusieurs membres'
    });;

    $('.add-clan').on('change', '.owner-select', function(){
        $('#members').val($(this).val()).change();
    });

});