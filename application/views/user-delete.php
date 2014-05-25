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
<div class="page-header">
    <h3>Supprimer un utilisateur</h3>
</div>
<?php if(isset($success) && $success): ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4>Membre supprimé avec succès</h4>
    </div>
<?php else: ?>
    <form role="form" method="post">
        <input type="hidden" name="user_id" value="<?php echo $user->id; ?>">
        <div class="form-group">
            Êtes-vous sûr de vouloir supprimer l'utilisateur <strong><?php echo $user->login; ?></strong> ?
        </div>
        <div class="form-group">
            <button type="submit" name="confirm" class="btn btn-success">Confirmer</button>
            &nbsp;
            <button type="submit" name="cancel" class="btn btn-danger">Annuler</button>
        </div>
    </form>
<?php endif ?>