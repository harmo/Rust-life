<div class="page-header">
    <h2>Éditer une permission</h2>
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
        <h4>Permission modifiée avec succès !</h4>
    </div>
<?php else: ?>
    <form class="form-horizontal" role="form" method="post">
        <input type="hidden" name="perm_id" value="<?php echo $permission_to_update->id; ?>">
        <div class="form-group <?php echo (isset($errors) && isset($errors['name']) ? 'has-error' : '') ?>">
            <label for="name" class="col-sm-2 control-label">Nom (sans_espaces)</label>
            <div class="col-sm-3">
                <input type="text" name="name" class="form-control" id="name" value="<?php echo $permission_to_update->slug; ?>">
            </div>
        </div>
        <div class="form-group <?php echo (isset($errors) && isset($errors['desc']) ? 'has-error' : '') ?>">
            <label for="desc" class="col-sm-2 control-label">Description courte</label>
            <div class="col-sm-3">
                <input type="text" name="desc" class="form-control" id="desc" value="<?php echo $permission_to_update->description; ?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-3">
                <button type="submit" name="update_perm" class="btn btn-primary">Mettre à jour</button>
            </div>
        </div>
    </form>
<?php endif ?>
