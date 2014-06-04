<ol class="breadcrumb">
    <li><a href="/<?php echo BASE_URL ?>admin">Tableau de bord</a></li>
    <li><a href="/<?php echo BASE_URL ?>admin/clans">Administration des clans</a></li>
    <li class="active">Éditer un clan</li>
</ol>

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
        <h4>Clan modifié avec succès !</h4>
    </div>
<?php else: ?>
    <div class="wrapper-content">
        <form class="form-horizontal add-clan" role="form" method="post">
            <input type="hidden" name="clan_id" value="<?php echo $clan_to_update->id; ?>">
            <div class="form-group <?php echo (isset($errors) && isset($errors['name']) ? 'has-error' : '') ?>">
                <label for="name" class="col-sm-2 control-label">Nom du clan</label>
                <div class="col-sm-3">
                    <input type="text" name="name" class="form-control" id="name" value="<?php echo $clan_to_update->name; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="mode" class="col-sm-2 control-label">Mode</label>
                <div class="col-sm-3">
                    <select name="mode" id="mode" class="form-control mode-select">
                        <?php foreach($modes as $id => $mode): ?>
                            <?php echo '<option value="'.$id.'"'.($id == $clan_to_update->mode? ' selected="selected"' : '').'>'.$mode.'</option>'; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group <?php echo (isset($errors) && isset($errors['money']) ? 'has-error' : '') ?>">
                <label for="money" class="col-sm-2 control-label">Argent</label>
                <div class="col-sm-3">
                    <input type="number" name="money" class="form-control" id="money" value="<?php echo $clan_to_update->money; ?>">
                </div>
            </div>
            <div class="form-group <?php echo (isset($errors) && isset($errors['owner']) ? 'has-error' : '') ?>">
                <label for="owner" class="col-sm-2 control-label">Chef</label>
                <div class="col-sm-3">
                    <select name="owner" id="owner" class="form-control owner-select">
                        <option value="">-- Choisir --</option>
                        <?php foreach($users as $id => $user): ?>
                            <?php echo '<option value="'.$id.'"'.($id == $clan_to_update->owner['id'] ? 'selected="selected"' : '').'>'.$user->login.'</option>'; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group <?php echo (isset($errors) && isset($errors['members']) ? 'has-error' : '') ?>">
                <label for="members" class="col-sm-2 control-label">Membres</label>
                <div class="col-sm-3">
                    <select name="members[]" id="members" class="members-select" multiple="multiple">
                        <?php foreach($users as $id => $user): ?>
                            <?php echo '<option value="'.$id.'"'.(isset($clan_to_update->members[$id]) ? 'selected="selected"' : '').'>'.$user->login.'</option>'; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-3">
                    <button type="submit" name="update_clan" class="btn btn-primary">Mettre à jour</button>
                </div>
            </div>
        </form>
    </div>
<?php endif ?>
