<ol class="breadcrumb">
    <li><a href="/<?php echo BASE_URL ?>admin">Tableau de bord</a></li>
    <li><a href="/<?php echo BASE_URL ?>admin/grades">Administration des rangs</a></li>
    <li class="active">Supprimer un rang</li>
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
        <h4>Rang supprimé avec succès</h4>
    </div>
<?php else: ?>
    <form role="form" method="post">
        <input type="hidden" name="grade_id" value="<?php echo $grade->id; ?>">
        <div class="form-group">
            Êtes-vous sûr de vouloir supprimer le rang <strong><?php echo $grade->name; ?></strong> ?
        </div>
        <div class="form-group">
            <button type="submit" name="confirm" class="btn btn-success">Confirmer</button>
            &nbsp;
            <button type="submit" name="cancel" class="btn btn-danger">Annuler</button>
        </div>
    </form>
<?php endif ?>