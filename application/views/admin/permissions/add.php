<ol class="breadcrumb">
    <li><a href="/<?php echo BASE_URL ?>admin">Tableau de bord</a></li>
    <li><a href="/<?php echo BASE_URL ?>admin/permissions">Administration des permissions</a></li>
    <li><a href="/<?php echo BASE_URL ?>admin/permissions/list">Liste des permissions</a></li>
    <li class="active">Ajouter une permission</li>
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
        <h4>Permission créée avec succès !</h4>
    </div>
<?php else: ?>
    <div class="wrapper-content">
        <form class="form-horizontal" role="form" method="post">
            <div class="form-group <?php echo (isset($errors) && isset($errors['name']) ? 'has-error' : '') ?>">
                <label for="name" class="col-sm-2 control-label">Nom (sans_espaces)</label>
                <div class="col-sm-3">
                    <input type="text" name="name" class="form-control" id="name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>">
                </div>
            </div>
            <div class="form-group <?php echo (isset($errors) && isset($errors['desc']) ? 'has-error' : '') ?>">
                <label for="desc" class="col-sm-2 control-label">Description courte</label>
                <div class="col-sm-3">
                    <input type="text" name="desc" class="form-control" id="desc" value="<?php echo isset($_POST['desc']) ? $_POST['desc'] : ''; ?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-3">
                    <button type="submit" name="add_perm" class="btn btn-primary">Ajouter</button>
                </div>
            </div>
        </form>
    </div>
<?php endif ?>
