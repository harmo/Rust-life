<ol class="breadcrumb">
    <li><a href="/<?php echo BASE_URL ?>admin">Tableau de bord</a></li>
    <li><a href="/<?php echo BASE_URL ?>admin/users">Administration des membres</a></li>
    <li class="active">Liste des membres</li>
</ol>

<div class="well filters">
    <form class="form-inline" role="form" method="post">
        <div class="form-group">
            <label class="control-label" for="search_user">Identifiant ou adresse e-mail</label>
            <input type="text" class="form-control" id="search_user" name="search_user" value="<?php echo (isset($_POST['search_user']) ? $_POST['search_user'] : '') ?>">
        </div>
        <button type="submit" class="btn btn-success">Chercher</button>
        <a href="/<?php echo BASE_URL.'admin/users/list/'; ?>" class="btn btn-warning">Réinitialiser</a>
    </form>
</div>

<?php if(empty($users)): ?>
    <div class="wrapper-content">
        Aucun membre enregistré.
    </div>
<?php else: ?>
    <div class="hidden-xs hidden-sm">
        <table class="table table-striped member-table tablesorter">
            <thead>
                <tr>
                    <th>Identifiant</th>
                    <th>E-mail</th>
                    <th>Rang</th>
                    <th>Points</th>
                    <th>Argent</th>
                    <th>Clan</th>
                    <th>Connexion</th>
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
                        <td><?php echo $grades[$user->site_grade]->name; ?></td>
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

    <?php if(isset($total_pages) && $total_pages > 1): ?>
        <ul class="pagination">
            <?php if($current_page == 1): ?>
                <li class="disabled"><a href="#">&laquo;</a></li>
            <?php else: ?>
                <li><a href="/<?php echo BASE_URL.'admin/users/list/'.($current_page-1) ?>">&laquo;</a></li>
            <?php endif; ?>

            <?php for($page=1; $page<=$total_pages; $page++): ?>
                <li class="<?php echo $page == $current_page ? 'active' : '' ?>">
                    <a href="/<?php echo BASE_URL.'admin/users/list/'.$page ?>"><?php echo $page ?></a>
                </li>
            <?php endfor; ?>

            <?php if($current_page == $total_pages): ?>
                <li class="disabled"><a href="#">&raquo;</a></li>
            <?php else: ?>
                <li><a href="/<?php echo BASE_URL.'admin/users/list/'.($current_page+1) ?>">&raquo;</a></li>
            <?php endif; ?>
        </ul>
    <?php endif; ?>
<?php endif; ?>