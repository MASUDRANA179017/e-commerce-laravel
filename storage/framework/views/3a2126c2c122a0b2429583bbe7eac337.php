

<?php $__env->startSection('title', __('Forbidden')); ?>
<?php $__env->startSection('code', '403'); ?>
<?php $__env->startSection('icon'); ?>
    <i class='bx bx-block'></i>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('message', __($exception->getMessage() ?: 'Sorry, you are forbidden from accessing this page.')); ?>

<?php echo $__env->make('errors::layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\QBit Dev-2\Downloads\projects\e-commerce-laravel\resources\views/errors/403.blade.php ENDPATH**/ ?>