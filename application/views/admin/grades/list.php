<ol class="breadcrumb">
    <li><a href="/<?php echo BASE_URL ?>admin">Tableau de bord</a></li>
    <li><a href="/<?php echo BASE_URL ?>admin/users">Administration des rangs</a></li>
    <li class="active">Liste des rangs</li>
</ol>
<div class="lead">
    <?php if(empty($grades)): ?>
        Aucun rang enregistré.
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Permissions</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($grades as $grade): ?>
                    <tr>
                        <td><?php echo $grade->name; ?></td>
                        <td>
                            <ul>
                                <?php foreach($grade->permissions as $perm): ?>
                                    <li><?php echo $permissions[$perm]->description; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <td>
                            <a class="action-link" href="update?id=<?php echo $grade->id; ?>"><span class="glyphicon glyphicon-pencil"></span></a>
                            <a class="action-link" href="delete?id=<?php echo $grade->id; ?>"><span class="glyphicon glyphicon-remove"></span></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
