<ol class="breadcrumb">
    <li><a href="/<?php echo BASE_URL ?>admin">Tableau de bord</a></li>
    <li><a href="/<?php echo BASE_URL ?>admin/users">Administration des membres</a></li>
    <li class="active">Débloquer un membre</li>
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
<?php if(isset($success) && $success): ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4>Membre débloqué avec succès</h4>
    </div>
<?php else: ?>
    <div class="wrapper-content">
        <form role="form" method="post">
            <input type="hidden" name="user_id" value="<?php echo $blocked_user->id; ?>">
            <div class="form-group">
                Êtes-vous sûr de vouloir débloquer l'utilisateur <strong><?php echo $blocked_user->login; ?></strong> ?
            </div>
            <div class="form-group">
                <button type="submit" name="confirm" class="btn btn-success">Confirmer</button>
                &nbsp;
                <button type="submit" name="cancel" class="btn btn-danger">Annuler</button>
            </div>
        </form>
    </div>
<?php endif; ?>