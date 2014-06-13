<?php if($clan->owner['id'] != $user->id): ?>

    <?php if($clan->id == $user->clan): ?>
        <a href="/<?php echo BASE_URL; ?>clans/unjoin/<?php echo $clan->id; ?>" title="Quitter ce clan" class="unjoin-clan">
            <span class="glyphicon glyphicon-log-out"></span></a>

    <?php else: ?>
        <a href="/<?php echo BASE_URL; ?>clans/join/<?php echo $clan->id; ?>" title="Rejoindre ce clan" class="join-clan">
            <span class="glyphicon glyphicon-log-in"></span></a>
    <?php endif; ?>

<?php else: ?>

    <?php if(sizeof($clan->members) > 1): ?>
        <a href="/#" title="Changer de chef" class="change-owner" data-owner="<?php echo $clan->owner['id']; ?>" data-clan="<?php echo $clan->id; ?>">
            <span class="glyphicon glyphicon-user"></span></a>
    <?php endif; ?>
    <!--<a href="/<?php echo BASE_URL; ?>clans/edit/<?php echo $clan->id; ?>" title="Éditer le clan" class="edit-clan">
        <span class="glyphicon glyphicon-cog"></span></a>-->
    <a href="/<?php echo BASE_URL; ?>clans/remove/<?php echo $clan->id; ?>" title="Supprimer le clan" class="remove-clan">
        <span class="glyphicon glyphicon-remove"></span></a>
<?php endif; ?>