

<?php $__env->startSection('title', __('Not Found')); ?>
<?php $__env->startSection('code', '404'); ?>
<?php $__env->startSection('icon'); ?>
    <i class='bx bx-error'></i>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('message', __('Sorry, the page you are looking for could not be found.')); ?>

<?php echo $__env->make('errors::layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\QBit Dev-2\Downloads\projects\e-commerce-laravel\resources\views/errors/404.blade.php ENDPATH**/ ?>