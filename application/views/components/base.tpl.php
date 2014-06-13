<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title; ?></title>
    <?php include 'css.tpl.php'; ?>
</head>
<body <?php echo !DEV ? 'class="prod"' : ''; ?>>
    <?php include 'navbar.tpl.php' ?>

    <div class="wrapper-content container">
        <?php echo $this->content(); ?>
    </div>

    <?php include 'footer.tpl.php' ?>

    <?php include 'scripts.tpl.php'; ?>

    <script type="text/javascript">
        var BASE_URL = '/<?php echo BASE_URL; ?>';
    </script>
</body>
</html>