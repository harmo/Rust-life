<?php if(isset($clan->requires[$user->id])): ?>
    <span class="glyphicon glyphicon-time" title="Demande envoyée"></span>
    &nbsp;
    <a href="/<?php echo BASE_URL; ?>clans/cancel/<?php echo $clan->id; ?>" title="Annuler une demande d'invitation">
        <span class="glyphicon glyphicon-remove"></span></a>

<?php elseif($clan->id != $user->clan): ?>
    <a href="#" class="require-invitation" data-clan="<?php echo $clan->id; ?>" title="Effectuer une demande d'invitation">
        <span class="glyphicon glyphicon-envelope"></span></a>

<?php elseif($clan->owner['id'] == $user->id): ?>
    <?php if(!empty($clan->requires)): ?>
        <a href="#" class="new-requires" data-clan="<?php echo $clan->id; ?>" title="<?php echo sizeof($clan->requires); ?> Nouvelle(s) demande(s)">
            <span class="glyphicon glyphicon-exclamation-sign"></span></a>
    <?php endif; ?>
    <a href="/<?php echo BASE_URL; ?>clans/edit/<?php echo $clan->id; ?>" title="Éditer le clan" class="edit-clan">
        <span class="glyphicon glyphicon-cog"></span></a>
    <a href="/<?php echo BASE_URL; ?>clans/remove/<?php echo $clan->id; ?>" title="Supprimer le clan" class="remove-clan">
        <span class="glyphicon glyphicon-remove"></span></a>

<?php endif; ?>

<?php if($clan->id == $user->clan): ?>
    <?php if($clan->owner['id'] != $user->id): ?>
        <a href="/<?php echo BASE_URL; ?>clans/unjoin/<?php echo $clan->id; ?>" title="Quitter ce clan" class="unjoin-clan">
            <span class="glyphicon glyphicon-log-out"></span></a>
    <?php elseif(sizeof($clan->members) > 1): ?>
        <a href="/#" title="Changer de chef" class="change-owner" data-owner="<?php echo $clan->owner['id']; ?>" data-clan="<?php echo $clan->id; ?>">
            <span class="glyphicon glyphicon-user"></span></a>
    <?php endif; ?>
<?php endif; ?>