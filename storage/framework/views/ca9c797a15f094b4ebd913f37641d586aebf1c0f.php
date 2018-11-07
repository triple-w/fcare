<head>
    <meta charset="UTF-8">
    <title><?php echo $__env->yieldContent('title'); ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta id="csrf-token" value="<?php echo e(csrf_token()); ?>" />
    <meta id="url-public" value="<?php echo e(asset('')); ?>" />
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(asset('/webroot/img/favicon/apple-touch-icon.png')); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(asset('/webroot/img/favicon/favicon.ico')); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(asset('/webroot/img/favicon/favicon.ico')); ?>">
    <link rel="manifest" href="<?php echo e(asset('/webroot/img/favicon/site.webmanifest')); ?>">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    <!-- HTML5 shim and Respond.js for < IE9 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
        google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
        active: function() {
            sessionStorage.fonts = true;
        }
        });
    </script>

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <?php echo HTML::style('assets/vendors/base/vendors.bundle.css'); ?>

    <?php echo HTML::style('assets/demo/demo5/base/style.bundle.css'); ?>

    
    <!-- /global stylesheets -->
    <?php echo HTML::styleLocal('webroot/css/main.css'); ?>

    <?php echo HTML::styleLocal('webroot/themes/clean-ui/fonts.css'); ?>

    <?php echo HTML::styleLocal('webroot/themes/clean-ui/select2.css'); ?>

    <?php echo HTML::styleLocal('webroot/themes/clean-ui/datatables-responsive.css'); ?>

    <!--<?php echo HTML::styleLocal('webroot/themes/clean-ui/select2.min.css'); ?>-->

    <?php echo $__env->yieldContent('styles'); ?>

    <?php echo $__env->make('layouts.elements.scripts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php echo $__env->yieldContent('scripts'); ?>

</head>
