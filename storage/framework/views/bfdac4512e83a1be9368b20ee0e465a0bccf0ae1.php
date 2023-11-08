<?php $__env->startSection('title','500'); ?>


<?php $__env->startSection('content'); ?>


<!-- ============ CHANGE PROFILE HEADER START HERE =================== -->
<div class="container-fluid" style="height: 100vh;">
    <div class="row">
        <div class="col-md-12 p-0">
            <div class="header-bgimg">
                <div class="col-lg-12 my-5 py-5 text-center">
                    <span class="title display-1 d-block text-white text-2xl mb-8"><?php echo app('translator')->get('Internal Server Error'); ?></span>
                    <div class="sub_title lead mt-4 mb-4 text-white text-xl"><?php echo app('translator')->get("The server encountered an internal error misconfiguration and was unable to complate your request. Please contact the server administrator."); ?></div>
                    <a style="color: #bd9277;" href="<?php echo e(url('/')); ?>"><?php echo app('translator')->get('Back To Home'); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ============ CHANGE PROFILE HEADER END HERE =================== -->


<?php $__env->stopSection(); ?>

<?php echo $__env->make($theme.'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/perhiasanintan/public_html/resources/views/themes/intan/errors/500.blade.php ENDPATH**/ ?>