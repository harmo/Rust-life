<ol class="breadcrumb">
    <li><a href="/<?php echo BASE_URL ?>admin">Tableau de bord</a></li>
    <li><a href="/<?php echo BASE_URL ?>admin/grades">Administration des rangs</a></li>
    <li class="active">Liste des rangs</li>
</ol>
<div class="wrapper-content">
    <?php if(empty($grades)): ?>
        Aucun rang enregistré.
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Type</th>
                    <th>Permissions</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($grades as $grade): ?>
                    <tr>
                        <td><?php echo $grade->name; ?></td>
                        <td><?php echo $grade_types[$grade->type]; ?></td>
                        <td>
                            <ul>
                                <?php foreach($grade->permissions as $perm): ?>
                                    <li><?php echo '('.$perm['slug'].') '.$perm['description']; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <td>
                            <a class="action-link" href="update/<?php echo $grade->id; ?>"><span class="glyphicon glyphicon-pencil"></span></a>
                            <a class="action-link" href="delete/<?php echo $grade->id; ?>"><span class="glyphicon glyphicon-remove"></span></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
