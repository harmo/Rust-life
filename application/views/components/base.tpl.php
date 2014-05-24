<!DOCTYPE html>
<html>
<head>
    <title><?php echo $title; ?></title>
    <?php include 'css.tpl.php'; ?>
</head>
<body>

    <div class="header">
        HEADER
    </div>

    <div class="wrapper-content">
        <?php echo $this->content(); ?>
    </div>

    <div class="footer">
        FOOTER
    </div>

    <?php include 'scripts.tpl.php'; ?>
</body>
</html>