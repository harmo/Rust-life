<!DOCTYPE html>
<html>
<head>
    <title><?php echo $title; ?></title>
    <?php include 'css.tpl.php'; ?>
</head>
<body>
    <?php include 'navbar-admin.tpl.php' ?>

    <div class="wrapper-content container">
        <?php echo $this->content(); ?>
    </div>

    <?php include 'scripts.tpl.php'; ?>
</body>
</html>