<div class="page-header">
    <h3>Liste des permissions</h3>
</div>

<div class="lead">
    <?php if(empty($permissions)): ?>
        Aucune permission enregistrée.
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($permissions as $permission): ?>
                    <tr>
                        <td><?php echo $permission->slug; ?></td>

                        <td><?php echo $permission->description; ?></td>
                        <td>
                            <a class="action-link" href="update?id=<?php echo $permission->id; ?>"><span class="glyphicon glyphicon-pencil"></span></a>
                            <a class="action-link" href="delete?id=<?php echo $permission->id; ?>"><span class="glyphicon glyphicon-remove"></span></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
