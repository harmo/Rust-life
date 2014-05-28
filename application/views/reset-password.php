<div class="page-header">
    <h3>Nouveau mot de passe</h3>
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
        <h3>Mot de passe actualisé <small>Connectez-vous <a href="/<?php echo BASE_URL; ?>login">ici</a></small></h3>
    </div>
<?php else: ?>
    <form class="form-horizontal" role="form" method="post">
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
                <button type="submit" name="send_reset" class="btn btn-primary">Envoyer</button>
            </div>
        </div>
    </form>
<?php endif ?>