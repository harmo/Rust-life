<ol class="breadcrumb">
    <li><a href="/<?php echo BASE_URL ?>admin">Tableau de bord</a></li>
    <li><a href="/<?php echo BASE_URL ?>admin/clans">Administration des clans</a></li>
    <li class="active">Ajouter un clan</li>
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
        <h4>Clan créé avec succès !</h4>
    </div>
<?php else: ?>
    <div class="wrapper-content">
        <form class="form-horizontal add-clan" role="form" method="post">
            <div class="form-group <?php echo (isset($errors) && isset($errors['name']) ? 'has-error' : '') ?>">
                <label for="name" class="col-sm-2 control-label">Nom du clan</label>
                <div class="col-sm-3">
                    <input type="text" name="name" class="form-control" id="name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="mode" class="col-sm-2 control-label">Mode</label>
                <div class="col-sm-3">
                    <select name="mode" id="mode" class="form-control mode-select">
                        <?php foreach($modes as $id => $mode): ?>
                            <?php echo '<option value="'.$id.'"'.(isset($_POST['mode']) && in_array($id, $_POST['mode']) ? 'selected="selected"' : '').'>'.$mode.'</option>'; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group <?php echo (isset($errors) && isset($errors['money']) ? 'has-error' : '') ?>">
                <label for="money" class="col-sm-2 control-label">Argent</label>
                <div class="col-sm-3">
                    <input type="number" name="money" class="form-control" id="money" value="<?php echo isset($_POST['money']) ? $_POST['money'] : '0'; ?>">
                </div>
            </div>
            <div class="form-group <?php echo (isset($errors) && isset($errors['owner']) ? 'has-error' : '') ?>">
                <label for="owner" class="col-sm-2 control-label">Chef</label>
                <div class="col-sm-3">
                    <select name="owner" id="owner" class="form-control owner-select">
                        <option value="">-- Choisir --</option>
                        <?php foreach($users as $id => $user): ?>
                            <?php echo '<option value="'.$id.'"'.(isset($_POST['owner']) && in_array($id, $_POST['owner']) ? 'selected="selected"' : '').'>'.$user->login.'</option>'; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group <?php echo (isset($errors) && isset($errors['members']) ? 'has-error' : '') ?>">
                <label for="members" class="col-sm-2 control-label">Membres</label>
                <div class="col-sm-3">
                    <select name="members[]" id="members" class="members-select" multiple="multiple">
                        <?php foreach($users as $id => $user): ?>
                            <?php echo '<option value="'.$id.'"'.(isset($_POST['members']) && in_array($id, $_POST['members']) ? 'selected="selected"' : '').'>'.$user->login.'</option>'; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-3">
                    <button type="submit" name="add_clan" class="btn btn-primary">Ajouter</button>
                </div>
            </div>
        </form>
    </div>
<?php endif ?>
