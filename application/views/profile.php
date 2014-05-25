<div class="page-header">
    <h3>Mon profil</h3>
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
        <h4>Profil modifié avec succès !</h4>
    </div>
<?php endif; ?>
<form class="form-horizontal" role="form" method="post">
    <div class="form-group">
        <label for="login" class="col-sm-4 control-label">Identifiant</label>
        <div class="col-sm-3">
            <input type="text" class="form-control" id="login" value="<?php echo $user->login; ?>" disabled="disabled">
        </div>
    </div>
    <div class="form-group <?php echo (isset($errors) && isset($errors['email']) ? 'has-error' : '') ?>">
        <label for="email" class="col-sm-4 control-label">Adresse e-mail</label>
        <div class="col-sm-3">
            <input type="text" name="email" class="form-control" id="email" value="<?php echo $user->email; ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="monney" class="col-sm-4 control-label">Argent</label>
        <div class="col-sm-3">
            <input type="text" class="form-control" id="monney" value="<?php echo $user->monney; ?>" disabled="disabled">
        </div>
    </div>
    <div class="form-group <?php echo (isset($errors) && isset($errors['password']) ? 'has-error' : '') ?>">
        <label for="password" class="col-sm-4 control-label">Nouveau mot de passe</label>
        <div class="col-sm-3">
            <input type="password" name="password" class="form-control" id="password" autocomplete="off">
        </div>
    </div>
    <div class="form-group <?php echo (isset($errors) && isset($errors['password_confirm']) ? 'has-error' : '') ?>">
        <label for="password_confirm" class="col-sm-4 control-label">Mot de passe (confirmer)</label>
        <div class="col-sm-3">
            <input type="password_confirm" name="password_confirm" class="form-control" id="password_confirm" autocomplete="off">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-3">
            <button type="submit" name="send_profile" class="btn btn-primary">Sauvegarder</button>
        </div>
    </div>
</form>