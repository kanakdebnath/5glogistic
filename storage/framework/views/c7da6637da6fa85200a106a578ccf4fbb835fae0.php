<?php $__env->startSection('title','405'); ?>


<?php $__env->startSection('content'); ?>


<!-- ============ CHANGE PROFILE HEADER START HERE =================== -->
<div class="container-fluid" style="height: 100vh;">
    <div class="row">
        <div class="col-md-12 p-0">
            <div class="header-bgimg">
                <section class="lg:p-12 md:p-5 sm:p-5 xs:p-4 p-4 pb-32 wow fadeInUp" data-wow-delay=".2s" data-wow-offset="300">
                    <div class="flex bg-gray-800 rounded-lg">
                        <div class="flex-1">
                            <div class="col-lg-12 my-5 py-5 text-center">
                                <span class="title display-1 d-block text-white text-2xl mb-8"><?php echo e(trans('405')); ?></span>
                                <div class="sub_title lead mt-4 mb-4 text-white text-xl"><?php echo e(trans("Method Not Allowed")); ?></div>
                                <a class="linear-btn btn-base text-pirategold-400" href="<?php echo e(url('/')); ?>"><?php echo app('translator')->get('Back To Home'); ?></a>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
<!-- ============ CHANGE PROFILE HEADER END HERE =================== -->


<?php $__env->stopSection(); ?>

<?php echo $__env->make($theme.'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/perhiasanintan/public_html/resources/views/themes/intan/errors/405.blade.php ENDPATH**/ ?>