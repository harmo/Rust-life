<ol class="breadcrumb">
    <li><a href="/<?php echo BASE_URL ?>admin">Tableau de bord</a></li>
    <li><a href="/<?php echo BASE_URL ?>admin/users">Administration des membres</a></li>
    <li class="active">Liste des membres</li>
</ol>

<div class="wrapper-content">
    <?php if(empty($users)): ?>
        Aucun membre enregistré.
    <?php else: ?>
        <div class="hidden-xs hidden-sm">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Identifiant</th>
                        <th>E-mail</th>
                        <th>Rang</th>
                        <th>Points</th>
                        <th>Argent</th>
                        <th>Clan</th>
                        <th>Dernière connexion</th>
                        <th>Dernière IP</th>
                        <th>Bloqué</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($users as $user): ?>
                        <tr>
                            <td><?php echo $user->login; ?></td>
                            <td><?php echo $user->email; ?></td>
                            <td><?php echo $user->grade; ?></td>
                            <td><?php echo $user->points; ?></td>
                            <td><?php echo $user->monney; ?></td>
                            <td><?php echo isset($clans[$user->clan]) ? $clans[$user->clan]->name : '-'; ?></td>
                            <td><?php echo $user->datetime; ?></td>
                            <td><?php echo $user->ip; ?></td>
                            <td class="text-center"><span class="glyphicon <?php echo $user->blocked ? 'glyphicon-ok' : '' ?>"></span></td>
                            <td>
                                <a class="action-link" href="update?id=<?php echo $user->id; ?>" title="Éditer <?php echo $user->login ?>"><span class="glyphicon glyphicon-pencil"></span></a>
                                <a class="action-link" href="delete?id=<?php echo $user->id; ?>" title="Supprimer <?php echo $user->login ?>"><span class="glyphicon glyphicon-remove"></span></a>
                                <?php if($user->blocked): ?>
                                    <a class="action-link" href="unblock/<?php echo $user->id; ?>" title="Débloquer <?php echo $user->login ?>"><span class="glyphicon glyphicon-thumbs-up"></span></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="visible-xs visible-sm">
            <table class="table table-striped user-list-small-device">
                <tbody>
                    <?php foreach($users as $user): ?>
                        <tr class="user-header" data-user="<?php echo $user->id; ?>">
                            <th><?php echo $user->login; ?></th>
                            <th colspan="2"><?php echo $user->email; ?></th>
                        </tr>
                        <tr class="user-details" data-user="<?php echo $user->id; ?>">
                            <td colspan="3">
                                <table class="table">
                                    <tr>
                                        <td>Clan :</td>
                                        <td colspan="2"><?php echo isset($clans[$user->clan]) ? $clans[$user->clan]->name : '-'; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Points</td>
                                        <td colspan="2"><?php echo $user->points; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Argent</td>
                                        <td colspan="2"><?php echo $user->monney; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Rang</td>
                                        <td colspan="2"><?php echo $user->grade; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Dernière connexion</td>
                                        <td colspan="2"><?php echo $user->datetime; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Dernière Ip</td>
                                        <td colspan="2"><?php echo $user->ip; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Actions</td>
                                        <td colspan="2">
                                            <a class="action-link" href="update?id=<?php echo $user->id; ?>" title="Éditer <?php echo $user->login ?>"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <a class="action-link" href="delete?id=<?php echo $user->id; ?>" title="Supprimer <?php echo $user->login ?>"><span class="glyphicon glyphicon-remove"></span></a>
                                            <?php if($user->blocked): ?>
                                                <a class="action-link" href="unblock/<?php echo $user->id; ?>" title="Débloquer <?php echo $user->login ?>"><span class="glyphicon glyphicon-thumbs-up"></span></a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>