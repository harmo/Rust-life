<ol class="breadcrumb">
    <li><a href="/<?php echo BASE_URL ?>admin">Tableau de bord</a></li>
    <li><a href="/<?php echo BASE_URL ?>admin/clans">Administration des clans</a></li>
    <li class="active">Liste des clans</li>
</ol>

<div class="wrapper-content">
    <?php if(empty($clans)): ?>
        Aucun clan enregistré.<br>
        <a class="btn btn-default" href="/<?php echo BASE_URL; ?>admin/clans/add">Ajouter</a>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Mode</th>
                    <th>Argent</th>
                    <th>Chef</th>
                    <th>Membres</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($clans as $clan): ?>
                    <tr>
                        <td><?php echo $clan->name; ?></td>
                        <td><?php echo $modes[$clan->mode]; ?></td>
                        <td><?php echo $clan->money; ?></td>
                        <td><?php echo property_exists($clan, 'owner') ? $clan->owner['identifiant'] : 'Erreur, chef manquant !'; ?></td>
                        <td>
                            <ul class="list-unstyled">
                                <?php foreach($clan->members as $member): ?>
                                    <li><?php echo $member; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </td>
                        <td>
                            <a class="action-link" href="update?id=<?php echo $clan->id; ?>"><span class="glyphicon glyphicon-pencil"></span></a>
                            <a class="action-link" href="delete?id=<?php echo $clan->id; ?>"><span class="glyphicon glyphicon-remove"></span></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
