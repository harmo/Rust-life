<div class="page-header">
    <h3>Contactez-nous <small>en cas de besoin</small></h3>
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

<?php if(isset($success) && $success): ?>
    <div class="alert alert-success alert-dismissable">
        <h4>Message envoyé !</h4>
    </div>
<?php else: ?>
    <form role="form" method="post" class="form-horizontal">
        <input type="hidden" name="captcha_defaut" value="<?php echo $rand; ?>">
        <div class="form-group <?php echo isset($errors['firstname']) ? 'has-error' : ''; ?>">
            <label for="firstname" class="col-sm-2 control-label">Prénom</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo isset($_POST['firstname']) ? $_POST['firstname'] : ''; ?>" >
            </div>
        </div>
        <div class="form-group <?php echo isset($errors['lastname']) ? 'has-error' : ''; ?>">
            <label for="lastname" class="col-sm-2 control-label">Nom</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo isset($_POST['lastname']) ? $_POST['lastname'] : ''; ?>">
            </div>
        </div>
        <div class="form-group <?php echo isset($errors['email']) ? 'has-error' : ''; ?>">
            <label for="email" class="col-sm-2 control-label">Adresse e-mail</label>
            <div class="col-sm-5">
                <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
            </div>
        </div>
        <div class="form-group <?php echo isset($errors['message']) ? 'has-error' : ''; ?>">
            <label for="message" class="col-sm-2 control-label">Message</label>
            <div class="col-sm-5">
                <textarea class="form-control" rows="9" name="message" id="message"><?php echo isset($_POST['message']) ? trim($_POST['message']) : ''; ?></textarea>
            </div>
        </div>
        <div class="form-group <?php echo isset($errors['captcha']) ? 'has-error' : ''; ?>">
            <label for="captcha" class="col-sm-2 control-label">Captcha (<?php echo $rand; ?>) </label>
            <div class="col-sm-5">
                <input type="tel" class="form-control" name="captcha" id="captcha" maxlength="4" title="Recopiez le captcha : <?php echo $rand; ?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" name="send_message" class="btn btn-primary">Envoyer</button>
            </div>
        </div>
    </form>
<?php endif; ?>
