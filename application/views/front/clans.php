<div class="page-header">
    <h3>Clans</h3>
</div>

<?php if(sizeof($clans) == 0): ?>
    <div class="lead">Aucun clan</div>
<?php else: ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Clan</th>
                <th>Chef</th>
                <th>Membres</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($clans as $clan): ?>
                <tr>
                    <td><?php echo $clan->name; ?></td>
                    <td><?php echo $clan->owner['identifiant']; ?></td>
                    <td>
                        <ul class="list-unstyled">
                            <?php foreach($clan->members as $member): ?>
                                <li><?php echo $member; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </td>
                    <td>
                        <?php if($clan->mode == 2): ?>

                        <?php elseif($clan->mode == 3): ?>
                            on demand
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>