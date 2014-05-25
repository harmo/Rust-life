<div class="page-header">
    <h2>Éditer un membre</h2>
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
        <h4>Utilisateur modifié avec succès !</h4>
    </div>
<?php else: ?>
    <form class="form-horizontal" role="form" method="post">
        <input type="hidden" name="user_id" value="<?php echo $user_to_update->id; ?>">
        <div class="form-group <?php echo (isset($errors) && isset($errors['login']) ? 'has-error' : '') ?>">
            <label for="login" class="col-sm-4 control-label">Identifiant</label>
            <div class="col-sm-3">
                <input type="text" name="login" class="form-control" id="login" value="<?php echo $user_to_update->login; ?>">
            </div>
        </div>
        <div class="form-group <?php echo (isset($errors) && isset($errors['email']) ? 'has-error' : '') ?>">
            <label for="email" class="col-sm-4 control-label">Adresse e-mail</label>
            <div class="col-sm-3">
                <input type="text" name="email" class="form-control" id="email" value="<?php echo $user_to_update->email; ?>">
            </div>
        </div>
        <div class="form-group <?php echo (isset($errors) && isset($errors['password']) ? 'has-error' : '') ?>">
            <label for="password" class="col-sm-4 control-label">Mot de passe <br>(laisser vide pour ne pas mettre à jour)</label>
            <div class="col-sm-3">
                <input type="password" name="password" class="form-control" id="password">
            </div>
        </div>
        <div class="form-group <?php echo (isset($errors) && isset($errors['grade']) ? 'has-error' : '') ?>">
            <label for="grade" class="col-sm-4 control-label">Rang</label>
            <div class="col-sm-3">
                <input type="text" name="grade" class="form-control" id="grade" value="<?php echo $user_to_update->grade; ?>">
            </div>
        </div>
        <div class="form-group <?php echo (isset($errors) && isset($errors['points']) ? 'has-error' : '') ?>">
            <label for="points" class="col-sm-4 control-label">Points</label>
            <div class="col-sm-3">
                <input type="text" name="points" class="form-control" id="points" value="<?php echo $user_to_update->points; ?>">
            </div>
        </div>
        <div class="form-group <?php echo (isset($errors) && isset($errors['monney']) ? 'has-error' : '') ?>">
            <label for="monney" class="col-sm-4 control-label">Argent</label>
            <div class="col-sm-3">
                <input type="text" name="monney" class="form-control" id="monney" value="<?php echo $user_to_update->monney; ?>">
            </div>
        </div>
        <div class="form-group <?php echo (isset($errors) && isset($errors['clan']) ? 'has-error' : '') ?>">
            <label for="clan" class="col-sm-4 control-label">Clan</label>
            <div class="col-sm-3">
                <input type="text" name="clan" class="form-control" id="clan" value="<?php echo $user_to_update->clan; ?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-3">
                <button type="submit" name="update_user" class="btn btn-primary">Mettre à jour</button>
            </div>
        </div>
    </form>
<?php endif ?>
