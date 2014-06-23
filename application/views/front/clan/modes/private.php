<?php if($clan->owner['id'] == $user->id): ?>
    <a href="/<?php echo BASE_URL; ?>clans/remove/<?php echo $clan->id; ?>" title="Supprimer le clan" class="remove-clan">
        <span class="glyphicon glyphicon-remove"></span></a>
    <a href="/<?php echo BASE_URL; ?>clans/edit/<?php echo $clan->id; ?>" title="Éditer le clan" class="edit-clan">
        <span class="glyphicon glyphicon-cog"></span></a>
<?php else: ?>
    <span class="glyphicon glyphicon-lock" title="Ce clan ne recrute pas"></span>
<?php endif; ?>