<div class="page-header">
    <h2>Création de compte</h2>
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
        <h4>Compte créé avec succès</h4>
        <p>
            Connectez-vous automatiquement en cliquant sur ce <a class="btn btn-success" href="/<?php echo BASE_URL; ?>">bouton</a>
        </p>
    </div>
<?php else: ?>
    <form class="form-horizontal" role="form" method="post">
        <div class="form-group <?php echo (isset($errors) && isset($errors['login']) ? 'has-error' : '') ?>">
            <label for="login" class="col-sm-2 control-label">Identifiant</label>
            <div class="col-sm-3">
                <input type="text" name="login" class="form-control" id="login" value="<?php echo isset($_POST['login']) ? $_POST['login'] : ''; ?>">
            </div>
        </div>
        <div class="form-group <?php echo (isset($errors) && isset($errors['email']) ? 'has-error' : '') ?>">
            <label for="email" class="col-sm-2 control-label">Adresse e-mail</label>
            <div class="col-sm-3">
                <input type="text" name="email" class="form-control" id="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
            </div>
        </div>
        <div class="form-group <?php echo (isset($errors) && isset($errors['password']) ? 'has-error' : '') ?>">
            <label for="password" class="col-sm-2 control-label">Mot de passe</label>
            <div class="col-sm-3">
                <input type="password" name="password" class="form-control" id="password">
            </div>
        </div>
        <div class="form-group <?php echo (isset($errors) && isset($errors['password_confirm']) ? 'has-error' : '') ?>">
            <label for="password_confirm" class="col-sm-2 control-label">Mot de passe (confirmation)</label>
            <div class="col-sm-3">
                <input type="password" name="password_confirm" class="form-control" id="password_confirm">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-3">
                <button type="submit" name="send_register" class="btn btn-primary">S'enregistrer</button>
            </div>
        </div>
    </form>
<?php endif ?>
