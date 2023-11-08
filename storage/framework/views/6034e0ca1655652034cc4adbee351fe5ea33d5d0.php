<?php $__env->startSection('title','Halaman Login'); ?>

<?php $__env->startSection('content'); ?>



<!-- ========================= SIGIN SECTION START HERE ====================== -->
<div class="container-fluid">
    <div class="container">
        <div class="row">
            <form action="<?php echo e(route('login')); ?>" method="post">
                <?php echo csrf_field(); ?>
            <div class="col-md-12 profile-inputs">
                <div class="form-group has-search mb-3">
                     <center>
                    <img src="<?php echo e(getFile(config('location.logoIcon.path').'logo.png')); ?>" style="height: 110px;" />
                </center>
                    <label for="exampleFormControlInput1" class="form-label"><?php echo app('translator')->get('Username'); ?></label>
                    <i class="fa-solid fa-user pro-icon"></i>
                    <input type="text" name="username" class="form-control" placeholder="<?php echo app('translator')->get('Username'); ?>">

                    <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <small class="text-danger"><?php echo app('translator')->get($message); ?></small>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <?php $__errorArgs = ['email'];
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
                    <label for="exampleFormControlInput1" class="form-label">Password :</label>
                    <i class="fa-solid fa-key pro-icon"></i>
                    <input id="password-field" type="password" name="password" class="form-control" placeholder="******">
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
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                        <?php echo app('translator')->get('Remember Me'); ?>
                    </label>
                    <span><a href="<?php echo e(route('password.request')); ?>"><?php echo app('translator')->get("Forgot password?"); ?></a> </span>
                </div>
                <center style="  height: 70px;">
                    <button type="submit" class="btn btn-primary">Login</button>
                </center>
               
                <p>Belum Bergabung ?<a href="<?php echo e(route('register')); ?>"><span> Daftar</span></a></p>
                 <center>
                    <img src="<?php echo e(asset('assets/frontend/intan/img/ojk.png')); ?>" style="height: 30px;" />
                </center>
            </div>
        </form>
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

<?php echo $__env->make($theme.'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\intan\resources\views/themes/intan/auth/login.blade.php ENDPATH**/ ?>