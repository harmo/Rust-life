<div class="page-header">
    <h2>Ajouter un membre</h2>
</div>

<?php if(isset($errors)): ?>
    <div class="alert alert-danger">
        <ul class="list-unstyled">
            <?php foreach($errors as $error): ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif ?>

<?php if(isset($success)): ?>
    <div class="alert alert-success">
        <h4>Utilisateur créé avec succès !</h4>
        <p>
            Son mot de passe est le suivant, merci de lui faire parvenir : <pre><?php echo $success['user_password']; ?></pre>
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
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-3">
                <button type="submit" name="add_user" class="btn btn-primary">Ajouter</button>
            </div>
        </div>
    </form>
<?php endif ?>
