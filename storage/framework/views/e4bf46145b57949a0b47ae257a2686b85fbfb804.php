<!doctype html>
<html>

    <?php echo $__env->make('layouts.elements.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

</head>

<body class="<?php echo $__env->yieldContent('class_body'); ?>" style="<?php echo $__env->yieldContent('style_body'); ?>">

    <?php echo $__env->yieldContent('content'); ?>

    <?php echo $__env->yieldContent('scripts_after'); ?>
</body>
</html>