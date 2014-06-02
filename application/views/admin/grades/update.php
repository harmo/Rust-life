<ol class="breadcrumb">
    <li><a href="/<?php echo BASE_URL ?>admin">Tableau de bord</a></li>
    <li><a href="/<?php echo BASE_URL ?>admin/grades">Administration des rangs</a></li>
    <li class="active">Éditer un rang</li>
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

<?php if(isset($success)): ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4>Rang modifié avec succès !</h4>
    </div>
<?php else: ?>
    <form class="form-horizontal" role="form" method="post">
        <input type="hidden" name="grade_id" value="<?php echo $grade_to_update->id; ?>">
        <div class="form-group <?php echo (isset($errors) && isset($errors['name']) ? 'has-error' : '') ?>">
            <label for="name" class="col-sm-2 control-label">Nom du rang</label>
            <div class="col-sm-3">
                <input type="text" name="name" class="form-control" id="name" value="<?php echo $grade_to_update->name; ?>">
            </div>
        </div>
        <div class="form-group <?php echo (isset($errors) && isset($errors['perms']) ? 'has-error' : '') ?>">
            <label for="perms" class="col-sm-2 control-label">Permissions</label>
            <div class="col-sm-3">
                <select name="perms[]" id="perms" class="perms-select" multiple="multiple">
                    <?php foreach($permissions as $permission): ?>
                        <?php if(in_array($permission->id, $grade_to_update->permissions)): ?>
                            <?php echo '<option value="'.$permission->id.'" selected="selected">'.$permission->slug.'</option>'; ?>
                        <?php else: ?>
                            <?php echo '<option value="'.$permission->id.'">'.$permission->slug.'</option>'; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-3">
                <button type="submit" name="update_grade" class="btn btn-primary">Mettre à jour</button>
            </div>
        </div>
    </form>
<?php endif ?>
