<ol class="breadcrumb">
    <li><a href="/<?php echo BASE_URL ?>admin">Tableau de bord</a></li>
    <li><a href="/<?php echo BASE_URL ?>admin/clans">Administration des clans</a></li>
    <li class="active">Supprimer un clan</li>
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
        <h4>Clan supprimé avec succès</h4>
    </div>
<?php else: ?>
    <div class="wrapper-content">
        <form role="form" method="post">
            <input type="hidden" name="grade_id" value="<?php echo $clan->id; ?>">
            <div class="form-group">
                Êtes-vous sûr de vouloir supprimer le clan <strong><?php echo $clan->name; ?></strong> ?
            </div>
            <div class="form-group">
                <button type="submit" name="confirm" class="btn btn-success">Confirmer</button>
                &nbsp;
                <button type="submit" name="cancel" class="btn btn-danger">Annuler</button>
            </div>
        </form>
    </div>
<?php endif ?>