jQuery(document).ready(function($){

    if($('.clan-table').length > 0){
        $('.clan-table').tablesorter({
            headers: {
                5: {sorter: false}
            }
        });
    }

    if($('#members').length > 0){
        $('#members').select2({
            placeholder: 'Choisir un ou plusieurs membres'
        });
    }

    $('.add-clan').on('change', '.owner-select', function(){
        $('#members').val($(this).val()).change();
    });


    $('td.actions').on('click', '.join-clan', function(e){
        if($('.glyphicon-time').length > 0){
            alertify.error('Vous avez déjà une demande en attente.');
            return false;
        }
        else if($('.my_clan').length > 0){
            alertify.error('Vous appartenez déjà à un clan.');
            return false;
        }
        return true
    });

    $('td.actions').on('click', '.require-invitation', function(e){
        e.preventDefault();
        if($('.unjoin-clan').length > 0 || $('.my_clan').length > 0){
            alertify.error('Vous appartenez déjà à un clan.');
        }
        else if($('.glyphicon-time').length > 0){
            alertify.error('Vous avez déjà une demande en attente.');
        }
        else {
            Clan.require($(this).data('clan'));
        }
    });

    $('td.actions').on('click', '.new-requires', function(e){
        e.preventDefault();
        Clan.seeRequires($(this).data('clan'));
    });

    $('td.actions').on('click', '.accept-require', function(e){
        e.preventDefault();
        Clan.acceptRequire($(this).closest('tr'));
    });

    $('td.actions').on('click', '.refuse-require', function(e){
        e.preventDefault();
        Clan.refuseRequire($(this).closest('tr'));
    });

    $('td.actions').on('click', '.change-owner', function(e){
        e.preventDefault();
        Clan.loadChangeOwner($(this));
    });

    $('body').on('click', '.change-owner-user', function(e){
        e.preventDefault();
        $('.alertify-button-ok').click();
        Clan.changeOwner($(this));
    });

    $('.remove-clan').click(function(e){
        e.preventDefault();
        var link = $(this).attr('href');
        alertify.confirm('Voulez-vous supprimer votre clan ?', function(clicked_ok){
            if(clicked_ok){
                window.location.href = link;
            }
        });
    });

    $('.edit-clan').on('click', '.grade-create-link', function(e){
        e.preventDefault();
        Clan.createGrade($(this).data('clan-id'));
    });

    $('.edit-clan').on('click', '.edit-grade', function(e){
        e.preventDefault();
        Clan.editGrade($(this).closest('tr.clan-grade').next('tr.edit-grade-line'));
    });

    $('.edit-clan').on('click', '.delete-grade', function(e){
        e.preventDefault();
        Clan.deleteGrade($(this).closest('tr.clan-grade').data('id-grade'), $(this).data('clan-id'));
    });

    if($('.edit-clan').find('tr.clan-grade').length > 0){
        $('table.clan-grades').show();
    }

});


var Clan = {
    require: function(clan_id){
        alertify.confirm('<textarea id="require_message" cols="60" rows="10" style="max-width: 470px;"></textarea>', function(clicked_ok){
            if(clicked_ok){
                message = $('#require_message').val();
                if(message == ''){
                    alertify.error('Le message ne peut pas être vide.');
                }
                else {
                    $.ajax({
                        url: BASE_URL+'clans/require',
                        method: 'post',
                        data: {clan_id: clan_id, message: message},
                        dataType: 'json',
                        success: function(response){
                            if(!response.in_error){
                                alertify.success('Demande envoyée !');
                                window.setTimeout(function(){
                                    window.location.href = BASE_URL+'clans';
                                }, 2000);
                            }
                        }
                    });
                }
            }
        });
    },

    seeRequires: function(clan_id){
        $('table.clan_'+clan_id).closest('tr').toggle();
    },

    acceptRequire: function(require_line){
        require_id = require_line.data('id');
        $.ajax({
            url: BASE_URL+'clans/accept_require',
            method: 'post',
            data: {require_id: require_id},
            dataType: 'json',
            success: function(response){
                if(!response.in_error){
                    member = require_line.find('.member').text();
                    $('tr.my_clan').find('ul.list-unstyled').append('<li>'+member+'</li>');
                    table = require_line.closest('table');
                    require_line.remove();
                    if(table.find('tr.line').length == 0){
                        table.remove();
                        $('tr.my_clan').find('.new-requires').remove();
                    }
                    alertify.success('Membre accepté !');
                }
                else {
                    alertify.error(response.errors);
                }
            }
        });
    },

    refuseRequire: function(require_line){
        require_id = require_line.data('id');
        $.ajax({
            url: BASE_URL+'clans/refuse_require',
            method: 'post',
            data: {require_id: require_id},
            dataType: 'json',
            success: function(response){
                if(!response.in_error){
                    table = require_line.closest('table');
                    require_line.remove();
                    if(table.find('tr.line').length == 0){
                        table.remove();
                        $('tr.my_clan').find('.new-requires').remove();
                    }
                    alertify.success('Membre refusé !');
                }
                else {
                    alertify.error(response.errors);
                }
            }
        });
    },

    loadChangeOwner: function(link){
        var members = {};
        link.closest('tr').find('td.members').find('li').each(function(){
            if($(this).data('id') != link.data('owner')){
                members[$(this).data('id')] = $(this).text();
            }
        });
        html = '<h4 style="color: #000000;">Désignez le nouveau chef :</h4><br>';
        for(id in members){
            html += '<a href="#" class="change-owner-user label label-default"  data-clan="'+link.data('clan')+'" data-id="'+id+'">'+members[id]+'</a>';
        }
        html += '<br><br>';
        alertify.set({labels: {ok: 'Annuler'}});
        alertify.alert(html);
    },
    changeOwner: function(user){
        $.ajax({
            url: BASE_URL+'clans/change_owner',
            method: 'post',
            data: {user: user.data('id'), clan: user.data('clan')},
            dataType: 'json',
            success: function(response){
                if(!response.in_error){
                    alertify.success('Nouveau chef désigné !');
                    window.setTimeout(function(){
                        window.location.href = BASE_URL+'clans';
                    }, 2000);
                }
                else {
                    alertify.error(response.errors);
                }
            }
        })
    },

    createGrade: function(clan_id){
        var template = $('.create-grade-template').clone();
        template.find('form').addClass('create-grade-form');
        alertify.confirm(template.html(), function(clicked_ok){
            if(clicked_ok){
                var name = $('.create-grade-form').find('input[name="clan_name"]').val();
                var description = $('.create-grade-form').find('textarea').val();
                var permissions = $('.create-grade-form').find('select[name="perms[]"]').val();

                errors = [];
                if(name == ''){
                    errors.push('Veuillez indiquer le nom du rang.');
                }
                else if(description == ''){
                    errors.push('Veuillez fournir une description.');
                }
                else if(permissions == null){
                    errors.push('Sélectionnez au moins une permission.');
                }

                if(errors.length > 0){
                    alertify.error(errors.join('<br>'));
                    Clan.createGrade(clan_id);
                }
                else {
                    $.ajax({
                        url: BASE_URL+'clans/add_grade',
                        method: 'post',
                        data: {clan_id: clan_id, name: name, description: description, perms: permissions},
                        dataType: 'json',
                        success: function(response){
                            if(response.in_error){
                                alertify.error(response.message);
                            }
                            else {
                                alertify.success('Rang ajouté avec succès.');
                                window.location.reload();
                            }
                        }
                    });
                }
            }
        });
    },
    editing: null,
    editGrade: function(grade_line){
        if(Clan.editing != null){
            $(Clan.editing).hide();
        }
        grade_line.show();
        Clan.editing = grade_line;
    },
    deleteGrade: function(id_grade, clan_id){
        alertify.confirm('Êtes-vous sûr de vouloir supprimer ce rang ?', function(clicked_ok){
            if(clicked_ok){
                $.ajax({
                    url: BASE_URL+'clans/delete_grade',
                    method: 'post',
                    data: {id_grade: id_grade, clan_id: clan_id},
                    dataType: 'json',
                    success: function(response){
                        if(response.in_error){
                            alertify.error(response.message);
                        }
                        else {
                            line = $('tr.clan-grade[data-id-grade="'+id_grade+'"]');
                            line.next('tr.edit-grade-line').remove();
                            line.remove();
                            alertify.success('Rang supprimé avec succès.');
                        }
                    }
                });
            }
        });
    }
}