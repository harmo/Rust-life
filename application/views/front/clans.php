<div class="page-header">
    <h3>Clans</h3>
</div>

<?php if(sizeof($clans) == 0): ?>
    <div class="lead">Aucun clan</div>
<?php else: ?>
    <table class="table table-striped clans">
        <thead>
            <tr>
                <th>Clan</th>
                <th>Chef</th>
                <th>Membres</th>
                <th>Status</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($clans as $clan): ?>
                <tr <?php echo $clan->id == $user->clan ? 'class="my_clan"' : ''; ?>>
                    <td><?php echo $clan->name; ?></td>
                    <td><?php echo $clan->owner['identifiant']; ?></td>
                    <td class="members">
                        <ul class="list-unstyled">
                            <?php foreach($clan->members as $id => $member): ?>
                                <li data-id="<?php echo $id; ?>"><?php echo $member; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </td>
                    <td><?php echo $clan_modes[$clan->mode]; ?></td>
                    <td class="actions text-center">
                        <?php if($clan->mode == Clan::$PUBLIC): ?>

                            <?php if($clan->id == $user->clan): ?>
                                <a href="/<?php echo BASE_URL; ?>clans/unjoin/<?php echo $clan->id; ?>" title="Quitter ce clan" class="unjoin-clan">
                                    <span class="glyphicon glyphicon-log-out"></span>
                                </a>

                            <?php else: ?>
                                <a href="/<?php echo BASE_URL; ?>clans/join/<?php echo $clan->id; ?>" title="Rejoindre ce clan" class="join-clan">
                                    <span class="glyphicon glyphicon-log-in"></span>
                                </a>

                            <?php endif; ?>

                        <?php elseif($clan->mode == Clan::$ON_DEMAND): ?>

                            <?php if(isset($clan->requires[$user->id])): ?>
                                <span class="glyphicon glyphicon-time" title="Demande envoyée"></span>
                                &nbsp;
                                <a href="/<?php echo BASE_URL; ?>clans/cancel/<?php echo $clan->id; ?>" title="Annuler une demande d'invitation">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </a>

                            <?php elseif($clan->id != $user->clan): ?>
                                <a href="#" class="require-invitation" data-clan="<?php echo $clan->id; ?>" title="Effectuer une demande d'invitation">
                                    <span class="glyphicon glyphicon-envelope"></span>
                                </a>

                            <?php elseif($clan->owner['id'] == $user->id): ?>
                                <?php if(!empty($clan->requires)): ?>
                                    <a href="#" class="new-requires" data-clan="<?php echo $clan->id; ?>" title="<?php echo sizeof($clan->requires); ?> Nouvelle(s) demande(s)"><span class="glyphicon glyphicon-exclamation-sign"></span></a>
                                <?php endif; ?>

                            <?php endif; ?>

                            <?php if($clan->id == $user->clan): ?>
                                <?php if($clan->owner['id'] != $user->id): ?>
                                    <a href="/<?php echo BASE_URL; ?>clans/unjoin/<?php echo $clan->id; ?>" title="Quitter ce clan" class="unjoin-clan">
                                        <span class="glyphicon glyphicon-log-out"></span>
                                    </a>
                                <?php elseif(sizeof($clan->members) > 1): ?>
                                    <a href="/#" title="Changer de chef" class="change-owner" data-owner="<?php echo $clan->owner['id']; ?>" data-clan="<?php echo $clan->id; ?>">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </a>
                                <?php endif; ?>
                            <?php endif; ?>

                        <?php elseif($clan->mode == Clan::$PRIVATE): ?>
                            <span class="glyphicon glyphicon-lock" title="Ce clan ne recrute pas"></span>

                        <?php endif; ?>
                    </td>
                </tr>

                <?php if($clan->owner['id'] == $user->id && !empty($clan->requires)): ?>
                    <tr>
                        <td colspan="5">
                            <table class="table table-bordered require-line clan_<?php echo $clan->id; ?>">
                                <tr>
                                    <th class="member">Membre</th>
                                    <th>Message</th>
                                    <th class="actions text-center">Actions</th>
                                </tr>
                                <?php foreach($clan->requires as $require): ?>
                                    <tr class="line" data-id="<?php echo $require['id']; ?>">
                                        <td class="member"><strong><?php echo $require['user']['identifiant']; ?></strong></td>
                                        <td><?php echo $require['message']; ?></td>
                                        <td class="actions text-center">
                                            <a href="#" class="accept-require" title="Accepter"><span class="glyphicon glyphicon-ok-sign"></span></a>
                                            <a href="#" class="refuse-require" title="Refuser"><span class="glyphicon glyphicon-minus-sign"></span></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </td>
                    </tr>
                <?php endif; ?>

            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>