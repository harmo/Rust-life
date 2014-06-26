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
    <form class="form-horizontal add-clan" role="form" method="post">
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
            <label for="grades" class="col-sm-2 control-label">Grades</label>
            <div class="col-sm-10">

            </div>
        </div>

        <div class="form-group">
            <label for="members" class="col-sm-2 control-label">Membres</label>
            <div class="col-sm-10">
                <table class="table table-striped">
                    <thead>
                        <th>Identifiant</th>
                        <th>Grade</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>
                        <?php foreach($clan->members as $id => $member): ?>
                            <tr>
                                <td><?php echo $member['login']; ?></td>
                                <td><?php echo $member['grade']; ?></td>
                                <td></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!--<select name="members[]" id="members" class="members-select" multiple="multiple">
                    <?php foreach($users as $id => $user): ?>
                        <?php if((isset($_POST['members']) && in_array($id, $_POST['members'])) || (!isset($_POST['members']) && isset($clan->members[$id]) && $clan->owner['id'] != $id)): ?>
                            <option value="<?php echo $id; ?>" selected="selected"><?php echo $user->login; ?></option>
                        <?php elseif($clan->owner['id'] != $id): ?>
                            <option value="<?php echo $id; ?>"><?php echo $user->login; ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>-->

            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-3">
                <button type="submit" name="edit_clan" class="btn btn-primary">Éditer</button>
            </div>
        </div>
    </form>
<?php endif ?>
