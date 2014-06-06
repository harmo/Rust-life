<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title; ?></title>
    <?php include 'css.tpl.php'; ?>
</head>
<body>
    <?php include 'navbar-admin.tpl.php' ?>

    <div class="container">
        <?php echo $this->content(); ?>
    </div>

    <?php include 'scripts.tpl.php'; ?>
</body>
</html>