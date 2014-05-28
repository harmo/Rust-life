<div class="page-header">
    <h2>Ajouter un Rang</h2>
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
        <h4>Rang créé avec succès !</h4>
    </div>
<?php else: ?>
    <form class="form-horizontal" role="form" method="post">
        <div class="form-group <?php echo (isset($errors) && isset($errors['name']) ? 'has-error' : '') ?>">
            <label for="name" class="col-sm-2 control-label">Nom du rang</label>
            <div class="col-sm-3">
                <input type="text" name="name" class="form-control" id="name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>">
            </div>
        </div>
        <div class="form-group <?php echo (isset($errors) && isset($errors['perms']) ? 'has-error' : '') ?>">
            <label for="perms" class="col-sm-2 control-label">Permissions</label>
            <div class="col-sm-3">
                <?php if(sizeof($permissions) == 0): ?>
                    <a href="/<?php echo BASE_URL; ?>admin/permissions/add">Ajouter une permission</a>
                <?php else: ?>
                    <select name="perms[]" id="perms" class="perms-select" multiple="multiple">
                        <?php foreach($permissions as $permission): ?>
                            <?php echo '<option value="'.$permission->id.'"'.(isset($_POST['perms']) && in_array($permission->id, $_POST['perms']) ? 'selected="selected"' : '').'>'.$permission->slug.'</option>'; ?>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-3">
                <button type="submit" name="add_grade" class="btn btn-primary">Ajouter</button>
            </div>
        </div>
    </form>
<?php endif ?>
