<?php $__env->startSection('title',trans('Setel Password')); ?>


<?php $__env->startSection('content'); ?>

<!-- ========================= SIGIN SECTION START HERE ====================== -->
<div class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-md-12 profile-inputs">
                <center>
                    <img src="<?php echo e(getFile(config('location.logoIcon.path').'logo.png')); ?>" style="height: 110px;" />
                </center>
                <form action="<?php echo e(route('password.update')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <?php $__errorArgs = ['token'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="col-md-12 px-5">
                        <div class="alert alert-danger" role="alert">
                            <?php echo e(trans($message)); ?>

                        </div>
                    </div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                <div class="form-group has-search mb-3">
                    <input type="hidden" name="token" value="<?php echo e($token); ?>">
                <input type="hidden" name="email" value="<?php echo e($email); ?>">

                    <label for="exampleFormControlInput1" class="form-label"><?php echo app('translator')->get('Kata Sandi Baru'); ?></label>
                    <i class="fa-solid fa-key pro-icon"></i>
                    <input id="password-field" name="password" type="password" class="form-control" placeholder="<?php echo app('translator')->get('Kata Sandi Baru'); ?>">
                    <span toggle="#password-field" class="fa fa-fw fa-eye show-eye-icon toggle-password"></span>
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <small class="text-danger"><?php echo app('translator')->get($message); ?></small>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="form-group has-search mb-3">
                    <label for="exampleFormControlInput1" class="form-label"><?php echo app('translator')->get('Konfirmasi Kata Sandi'); ?></label>
                    <i class="fa-solid fa-key pro-icon"></i>
                    <input name="password_confirmation" id="password-field1" type="password" class="form-control" placeholder="<?php echo app('translator')->get('Konfirmasi Kata Sandi'); ?>">
                    <span toggle="#password-field1" class="fa fa-fw fa-eye show-eye-icon toggle-password"></span>
                    <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <small class="text-danger"><?php echo app('translator')->get($message); ?></small>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <center style="  height: 70px;">
                    <button type="submit" class="btn btn-primary"><?php echo app('translator')->get('Konfirmasi'); ?></button>
                </center>
                <center>
                    <img src="<?php echo e(asset('assets/frontend/intan/img/ojk.png')); ?>" style="height: 30px;" />
                </center>
            </div>
        </div>
    </div>
</div>
<!-- ========================= SIGNIN SECTION END HERE ====================== -->

<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>
<script>
    $(".toggle-password").click(function() {

        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme.'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/perhiasanintan/public_html/resources/views/themes/intan/auth/passwords/reset.blade.php ENDPATH**/ ?>