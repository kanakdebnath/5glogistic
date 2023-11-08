<?php $__env->startSection('title',trans('Lupa Password')); ?>

<?php $__env->startSection('content'); ?>

<!-- ========================= SIGIN SECTION START HERE ====================== -->
<div class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-md-12 profile-inputs">
                <center>
                    <img src="<?php echo e(getFile(config('location.logoIcon.path').'logo.png')); ?>" style="height: 110px;" />
                </center>
                <form action="<?php echo e(route('password.email')); ?>" id="form" method="post">
                    <?php echo csrf_field(); ?>
                <div class="form-group has-search mb-3">
                    <label for="exampleFormControlInput1" class="form-label"><?php echo app('translator')->get('Email Address'); ?></label>
                    <i class="fa-solid fa-envelope pro-icon"></i>
                    <input type="email" name="email" value="<?php echo e(old('email')); ?>" class="form-control" placeholder="<?php echo app('translator')->get('Masukkan Email Anda'); ?>" required>
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
                <center style="  height: 70px;">
                    <button type="submit" class="btn btn-primary" id="send_link" <?php if(session()->has('success')): ?> disabled <?php endif; ?> ><?php echo app('translator')->get('Setel Ulang Kata Sandi'); ?></button>
                    <small id="timer_div"></small>
                </center>
                 <center>
                    <img src="<?php echo e(asset('assets/frontend/intan/img/ojk.png')); ?>" style="height: 30px;" />
                </center>
            </form>
            </div>
        </div>
    </div>
</div>
<!-- ========================= SIGNIN SECTION END HERE ====================== -->

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    $(document).ready(function(){
        $('#form').on('submit', function(){
            $("#send_link").attr('disabled',true);
            $("#send_link").html('<div class="spinner-border spinner-border-sm" role="status"><span class="sr-only"></span></div>');
        });
    });
</script>

<?php if(session()->has('success')): ?>
    <script>
          var timeLeft = 60;
          var elem = document.getElementById("send_link");
          var timerId = setInterval(countdown, 1000);
        function countdown() {
            if (timeLeft == 0) {
              clearTimeout(timerId);
              $("#send_link").html("<?php echo app('translator')->get('Setel Ulang Kata Sandi'); ?>");
              $("#send_link").attr('disabled',false);
            } else {
              elem.innerHTML = timeLeft;
              timeLeft--;
            }
        }
    </script>
<?php endif; ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme.'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/perhiasanintan/public_html/resources/views/themes/intan/auth/passwords/email.blade.php ENDPATH**/ ?>