<ol class="breadcrumb">
    <li><a href="/<?php echo BASE_URL ?>admin">Tableau de bord</a></li>
    <li><a href="/<?php echo BASE_URL ?>admin/users">Administration des membres</a></li>
    <li class="active">Liste des membres</li>
</ol>

<div class="wrapper-content">
    <?php if(empty($users)): ?>
        Aucun membre enregistré.
    <?php else: ?>
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
                        <td>
                            <a class="action-link" href="update?id=<?php echo $user->id; ?>"><span class="glyphicon glyphicon-pencil"></span></a>
                            <a class="action-link" href="delete?id=<?php echo $user->id; ?>"><span class="glyphicon glyphicon-remove"></span></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>