<div class="page-header">
    <h2>Ajouter un Clan</h2>
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
        <h4>Clan créé avec succès !</h4>
    </div>
<?php else: ?>
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
        <div class="form-group <?php echo (isset($errors) && isset($errors['monney']) ? 'has-error' : '') ?>">
            <label for="monney" class="col-sm-2 control-label">Argent</label>
            <div class="col-sm-3">
                <input type="number" name="monney" class="form-control" id="monney" value="<?php echo isset($_POST['monney']) ? $_POST['monney'] : '0'; ?>">
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
<?php endif ?>
