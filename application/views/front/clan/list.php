<div class="page-header">
    <h3>Clans</h3>
</div>

<?php if(sizeof($clans) == 0): ?>
    <div class="lead">Aucun clan</div>
<?php else: ?>
    <?php if($user->clan == ''): ?>
        <a href="/<?php echo BASE_URL; ?>clans/add/" class="btn btn-default">
            <span class="glyphicon glyphicon-plus"> Créer un clan</span>
        </a>
    <?php endif; ?>
    <table class="table table-striped clans">
        <thead>
            <tr>
                <th>Clan</th>
                <th>Chef</th>
                <th>Membres</th>
                <th>Statut</th>
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
                            <?php include('modes/public.php'); ?>
                        <?php elseif($clan->mode == Clan::$ON_DEMAND): ?>
                            <?php include('modes/on_demand.php'); ?>
                        <?php elseif($clan->mode == Clan::$PRIVATE): ?>
                            <?php include('modes/private.php'); ?>
                        <?php endif; ?>
                    </td>
                </tr>

                <?php if($clan->owner['id'] == $user->id && !empty($clan->requires)): ?>
                    <tr class="require-line">
                        <td colspan="5">
                            <table class="table table-bordered clan_<?php echo $clan->id; ?>">
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