<ul class="nav nav-tabs">
    <li class="active"><a href="#commands" data-toggle="tab">Commandes</a></li>
    <li><a href="#destruct" data-toggle="tab">Destruction</a></li>
    <li><a href="#vip" data-toggle="tab">VIP</a></li>
    <li><a href="#rules" data-toggle="tab">Règlement</a></li>
    <li><a href="#contact" data-toggle="tab">Contact</a></li>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="commands">
        <div class="well">
            <p><strong>/auto</strong> → Permet de se connecter automatiquement à son compte</p>
            <p><strong>/clan</strong> → Permet de gérer un clan</p>
            <p><strong>/maison</strong> → Permet de définir l’emplacement de son domicile afin de se téléporter</p>
            <p><strong>/boost</strong> → Permet de limiter les performances graphiques pour ne plus laguer</p>
            <p><strong>/acheter</strong> → Permet d’ouvrir le magasin afin d’acheter différents objet</p>
            <p><strong>/location</strong> → Permet de voir sa position en X, Y et Z</p>
            <p><strong>/lieu</strong> → Permet de voir le nom du lieu ou l’on se trouve</p>
            <p><strong>/balance</strong> → Permet de voir son argent</p>
            <p><strong>/payer</strong> → Permet de payer quelqu’un</p>
            <p><strong>/destruction</strong> → Permet d’activer et de désactiver la destruction pour ses propres objets</p>
            <p><strong>/joueurs</strong> → Permet de voir les joueurs en ligne</p>
            <p><strong>/ping</strong> → Permet de voir son ping</p>
        </div>
    </div>

    <div class="tab-pane" id="destruct">
        <br>
        <div class="panel-group" id="accordion">
            <?php
            $destruction = array(
                'Shotgun' => array(
                    'WoodDoor'      => 50,
                    'MetalDoor'     => 20,
                    'Campfire'      => 1,
                    'WoodBox'       => 3,
                    'WoodBoxLarge'  => 77,
                    'Repairbench'   => 3,
                    'Workbench'     => 4,
                    'WoodShelter'   => 44
                ),
                'Picke Axe' => array(
                    'WoodDoor'      => 300,
                    'Campfire'      => 2,
                    'WoodBox'       => 7,
                    'WoodBoxLarge'  => 15,
                    'Repairbench'   => 4,
                    'Workbench'     => 4,
                    'WoodShelter'   => 80,
                    'WoodPillar'    => 400,
                    'WoodStairs'    => 200,
                    'WoodRamp'      => 200,
                    'WoodWall'      => 600,
                ),
                'Hatchet' => array(
                    'Campfire'      => 5,
                    'WoodBox'       => 15,
                    'WoodBoxLarge'  => 30,
                    'Repairbench'   => 8,
                    'Workbench'     => 8,
                    'WoodShelter'   => 160,
                    'WoodPillar'    => 500,
                    'WoodDoor'      => 400,
                    'WoodStairs'    => 300,
                    'WoodRamp'      => 300,
                    'WoodWall'      => 800
                ),
                'StoneHatchet' => array(
                    'Campfire'      => 10,
                    'WoodBox'       => 30,
                    'WoodBoxLarge'  => 60,
                    'Repairbench'   => 16,
                    'Workbench'     => 16,
                    'WoodShelter'   => 320,
                    'WoodPillar'    => 600,
                    'WoodDoor'      => 400,
                    'WoodStairs'    => 500,
                    'WoodRamp'      => 400,
                    'WoodWall'      => 1000
                ),
                'C4' => array(
                    'Campfire'      => 1,
                    'WoodBox'       => 1,
                    'WoodBoxLarge'  => 1,
                    'Repairbench'   => 1,
                    'Workbench'     => 1,
                    'WoodShelter'   => 2,
                    'WoodenDoor'    => 2,
                    'WoodStairs'    => 2,
                    'WoodRamp'      => 2,
                    'WoodPillar'    => 18,
                    'WoodWall'      => 18,
                    'WoodDoorway'   => 18,
                    'WoodWindows'   => 18,
                    'WoodCeiling'   => 25,
                    'SpikeWall'     => 1,
                    'LargeSpikeWall'=> 1,
                    'MetalDoor'     => 3
                ),
            );
            ?>
            <?php foreach($destruction as $weapon => $items): ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo str_replace(' ', '', $weapon); ?>">
                                [<?php echo $weapon; ?>]
                            </a>
                        </h4>
                    </div>
                    <div id="<?php echo str_replace(' ', '', $weapon); ?>" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table table-condensed table-striped">
                                <thead>
                                    <tr>
                                        <th>Objet à détruire</th>
                                        <th>Coups nécessaires</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($items as $item => $hit): ?>
                                        <tr>
                                            <td><?php echo $item; ?></td>
                                            <td><?php echo $hit; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="tab-pane" id="vip">

    </div>

    <div class="tab-pane" id="rules">
        <div class="well">
            <h4>Le règlement du serveur doit obligatoirement être lu et accepté par toute personne se connectant au serveur !</h4>
            <ul>
                <li>Le flood est interdit</li>
                <li>Les insultes en tous genres (sexiste, racisme, homophobie...) sont strictement interdites</li>
                <li>Aucun caractère pornographique ne sera toléré</li>
                <li>Respectez les autres membres (politesse, respect, fairplay)</li>
                <li>La publicité est interdite et fera immédiatement l'objet d'un bannissement définitif</li>
                <li>évitez de faire circuler vos coordonnées personnelles (téléphone, adresse, mots de passe)</li>
                <li>Toutes tentative de triche fera immédiatement l'objet d'un bannissement définitif</li>
            </ul>
            <p>Si un utilisateur n'applique pas ce règlement, il risque d'être sanctionné (avertissement, expulsion, bannissement).</p>
        </div>
    </div>

    <div class="tab-pane" id="contact">
        <div class="well">
            <p class="lead">Vous avez un problème ou une question ?</p>

            <p>Contactez Kim !</p>
            <p><a href="#" onclick="alert('Adresse e-mail : \n\n kimblood@outlook.fr'); return false;">→ Email</a></p>
            <br>

            <p>Contactez BlackEagle !</p>
            <p><a href="https://www.facebook.com/pheonix225?ref=tn_tnmn">→ Facebook</a></p>
            <p><a href="#" onclick="alert('Adresse e-mail : \n\n ordredutemple@hotmail.com'); return false;">→ Email</a></p>
        </div>
    </div>
</div>