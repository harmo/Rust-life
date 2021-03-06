<div class="page-header">
    <h3>Éditer mon clan</h3>
</div>

<?php if(isset($errors)): ?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <ul class="list-unstyled">
            <?php foreach($errors as $error): ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif ?>

<?php if(isset($success)): ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4>Clan édité avec succès ! <small><a href="/<?php echo BASE_URL ?>clans/">Retour</a></small></h4>
    </div>
<?php else: ?>
    <form class="form-horizontal edit-clan" role="form" method="post">
        <input type="hidden" name="owner" value="<?php echo $user->id ?>">

        <div class="form-group <?php echo (isset($errors) && isset($errors['name']) ? 'has-error' : '') ?>">
            <label for="name" class="col-sm-2 control-label">Nom du clan</label>
            <div class="col-sm-3">
                <input type="text" name="name" class="form-control" id="name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : $clan->name; ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="mode" class="col-sm-2 control-label">Mode</label>
            <div class="col-sm-3">
                <select name="mode" id="mode" class="form-control mode-select">
                    <?php foreach($clan_modes as $id => $mode): ?>
                        <?php if((isset($_POST['mode']) && in_array($id, $_POST['mode'])) || (!isset($_POST['mode']) && $clan->mode == $id)): ?>
                            <option value="<?php echo $id; ?>" selected="selected"><?php echo $mode; ?></option>
                        <?php else: ?>
                            <option value="<?php echo $id; ?>"><?php echo $mode; ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="grades" class="col-sm-2 control-label">Rangs</label>
            <div class="col-sm-10">
                <a href="#" class="btn btn-default grade-create-link" data-clan-id="<?php echo $clan->id; ?>">Ajouter un rang</a>
                <table class="table table-striped clan-grades">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Permissions</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(sizeof($clan->grades) > 0): ?>
                            <?php foreach($clan->grades as $id_clan_grade => $grade): ?>
                                <tr class="clan-grade" data-id-clan-grade="<?php echo $id_clan_grade; ?>" data-id-grade="<?php echo $grade['id']; ?>">
                                    <td class="name"><?php echo $grade['name']; ?></td>
                                    <td class="description"><?php echo $grade['description']; ?></td>
                                    <td class="permissions">
                                        <ul>
                                            <?php foreach($grade['permissions'] as $id_perm => $perm): ?>
                                                <li data-id-perm="<?php echo $id_perm; ?>"><?php echo $perm->description; ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </td>
                                    <td class="grade-actions">
                                        <?php if($grade['deletable']): ?>
                                            <a href="#" class="edit-grade" title="Éditer"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <a href="#" class="delete-grade" title="Supprimer" data-clan-id="<?php echo $clan->id; ?>"><span class="glyphicon glyphicon-remove"></span></a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr class="edit-grade-line">
                                    <td colspan="4">
                                        <h3>Éditer un rang</h3>
                                        <form class="form-horizontal" role="form" method="post">
                                            <input type="hidden" name="grade_id" value="<?php echo $grade['id']; ?>">
                                            <div class="form-group">
                                                <label for="name" class="col-sm-3 control-label">Nom</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="name" class="form-control" id="name" value="<?php echo $grade['name']; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="description" class="col-sm-3 control-label">Description</label>
                                                <div class="col-sm-6">
                                                    <textarea name="description" class="form-control" id="description"><?php echo $grade['description']; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="perms" class="col-sm-3 control-label">Permissions</label>
                                                <div class="col-sm-6">
                                                    <select name="perms[]" id="perms" class="perms-select" multiple="multiple">
                                                        <?php foreach($permissions as $permission): ?>
                                                            <option
                                                                value="<?php echo $permission->id; ?>"
                                                                <?php echo isset($grade['permissions'][$permission->id]) ? 'selected="selected"' : ''; ?>
                                                            ><?php echo $permission->description != '' ? $permission->description : $permission->slug ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <button type="submit" name="submit_edit_grade" class="btn btn-success pull-right">valider</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="form-group">
            <label for="members" class="col-sm-2 control-label">Membres</label>
            <div class="col-sm-10">
                <table class="table table-striped clan-members">
                    <thead>
                        <th>Identifiant</th>
                        <th>Grade</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>
                        <?php foreach($clan->members as $id => $member): ?>
                            <tr>
                                <td><?php echo $member['login']; ?></td>
                                <td><?php echo $member['grade']->name; ?></td>
                                <td>
                                    <?php if(has_permission($user, 'clan_promote_member') && $member['grade']->promotable): ?>
                                        <a href="#" class="member-promote-link" data-id-member="<?php echo $id; ?>" data-id-clan="<?php echo $clan->id; ?>" data-id-grade="<?php echo $member['grade']->id; ?>">
                                            <span class="glyphicon glyphicon-arrow-up"></span></a>
                                    <?php endif; ?>

                                    <?php if(has_permission($user, 'clan_demean_member') && $member['grade']->demeanable && $id != $clan->owner['id']): ?>
                                        <a href="#" class="member-demean-link" data-id-member="<?php echo $id; ?>" data-id-clan="<?php echo $clan->id; ?>" data-id-grade="<?php echo $member['grade']->id; ?>">
                                            <span class="glyphicon glyphicon-arrow-down"></span></a>
                                    <?php endif; ?>

                                    <?php if(has_permission($user, 'clan_expulse_member') && $id != $clan->owner['id']): ?>
                                        <a href="#" class="member-remove-link" data-id-member="<?php echo $id; ?>" data-id-clan="<?php echo $clan->id; ?>" data-id-grade="<?php echo $member['grade']->id; ?>">
                                            <span class="glyphicon glyphicon-remove"></span></a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-3">
                <button type="submit" name="edit_clan" class="btn btn-success">Éditer</button>
            </div>
        </div>
    </form>

    <div class="create-grade-template">
        <h3>Créer un rang</h3>
        <form class="form-horizontal" role="form" method="post">
            <div class="form-group">
                <label for="name" class="col-sm-3 control-label">Nom</label>
                <div class="col-sm-9">
                    <input type="text" name="clan_name" class="form-control" id="name">
                </div>
            </div>
            <div class="form-group">
                <label for="description" class="col-sm-3 control-label">Description</label>
                <div class="col-sm-9">
                    <textarea name="description" class="form-control" id="description"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="perms" class="col-sm-3 control-label">Permissions</label>
                <div class="col-sm-9">
                    <select name="perms[]" id="perms" class="perms-select" multiple="multiple">
                        <?php foreach($permissions as $permission): ?>
                            <option value="<?php echo $permission->id; ?>"><?php echo $permission->description != '' ? $permission->description : $permission->slug ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </form>
    </div>
<?php endif ?>
