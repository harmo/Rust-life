<?php if(isset($errors)): ?>
    <div class="alert alert-danger">
        <ul class="list-unstyled">
            <?php foreach($errors as $error): ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif ?>

<?php if(isset($user) && $user): ?>
    <div class="alert alert-success">
        <h4>Vous êtes connecté</h4>
        <p>
            Bienvenue, <?php echo $user->login; ?>
        </p>
    </div>
<?php else: ?>
    <?php if(isset($_GET['lost'])): ?>
        <?php if($_GET['lost'] == 'login'): ?>
            <div class="page-header">
                <h3>Identifiant perdu <small>Un e-mail vous sera envoyé avec votre identifiant.</small></h3>
            </div>
            <form class="form-horizontal" role="form" method="post">
                <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">Adresse e-mail</label>
                    <div class="col-sm-3">
                        <input type="text" name="email" class="form-control" id="email" placeholder="Email">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-3">
                        <button type="submit" class="btn btn-primary">Envoyer</button>
                    </div>
                </div>
            </form>
        <?php endif ?>
        <?php if($_GET['lost'] == 'password'): ?>
            <div class="page-header">
                <h3>Mot de passe perdu <small>Un lien vous sera envoyé par e-mail afin de le réinitialiser.</small></h3>
            </div>
            <form class="form-horizontal" role="form" method="post">
                <div class="form-group">
                    <label for="login" class="col-sm-2 control-label">Identifiant</label>
                    <div class="col-sm-3">
                        <input type="text" name="login" class="form-control" id="login" placeholder="Identifiant">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-3">
                        <button type="submit" class="btn btn-primary">Envoyer</button>
                    </div>
                </div>
            </form>
        <?php endif ?>
    <?php else: ?>
        <div class="page-header">
            <h3>Connexion <small>avec votre identifiant du serveur !</small></h3>
        </div>

        <form class="form-horizontal" role="form" method="post">
            <div class="form-group">
                <label for="login" class="col-sm-2 control-label">Identifiant</label>
                <div class="col-sm-3">
                    <input type="text" name="login" class="form-control" id="login" placeholder="Identifiant">
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="col-sm-2 control-label">Mot de passe</label>
                <div class="col-sm-3">
                    <input type="password" name="password" class="form-control" id="password" placeholder="Mot de passe">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-3">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember_me"> Se souvenir de moi
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group lost-link">
                <div class="col-sm-offset-2">
                    <a href="login?lost=login">Récupérer son identifiant</a>
                </div>
            </div>
            <div class="form-group lost-link">
                <div class="col-sm-offset-2">
                    <a href="login?lost=password">Récupérer son mot de passe</a>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-3">
                    <button name="submit_login" type="submit" class="btn btn-primary">Se connecter</button>
                </div>
            </div>
        </form>
    <?php endif ?>
<?php endif ?>