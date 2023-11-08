<?php $__env->startPush('head'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/frontend/styles/register.css')); ?>" />
<link href="<?php echo e(captcha_layout_stylesheet_url()); ?>" type="text/css" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <header></header>

    <section class="overflow-hidden">
        <div class="row">
          <button class="col border-0 bg-warning p-3 px-0">
            <a
              class="fs-5 text-decoration-none text-secondary d-block"
              href="<?php echo e(route('login')); ?>"
              ><?php echo app('translator')->get('Login'); ?></a
            >
          </button>
          <button class="col border-0 bg-warning p-3 px-0 position-relative">
            <a
              class="fs-5 fw-bold text-decoration-none text-dark d-block"
              href="#"
              >Register
              <i
                style="bottom: -10px; color: black"
                class="fa-solid fa-diamond position-absolute start-0 end-0"
              ></i>
            </a>
          </button>
        </div>

        <form class="register-form" action="<?php echo e(route('register')); ?>" method="post">
            <?php echo csrf_field(); ?>

  
        <div class="px-3 py-4">

            <p class="text-white mb-1 mt-3"><?php echo app('translator')->get('First Name'); ?></p>
            <div >
                <input id="firstname" name="firstname" 
                class="form-control bg-black input-focus-border border-0 border-bottom rounded-0 text-white padding-right"
                type="password"
                placeholder="<?php echo app('translator')->get('First Name'); ?>"
                />
                <?php $__errorArgs = ['firstname'];
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

            <p class="text-white mb-1 mt-3"><?php echo app('translator')->get('Last Name'); ?></p>
            <div >
                <input id="lastname" name="lastname" 
                class="form-control bg-black input-focus-border border-0 border-bottom rounded-0 text-white padding-right"
                type="password"
                placeholder="<?php echo app('translator')->get('Last Name'); ?>"
                />
                <?php $__errorArgs = ['lastname'];
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

          <p class="text-white mb-1"><?php echo app('translator')->get('Phone number'); ?></p>
          <div class="position-relative">
            <span class="text-white position-absolute" style="bottom: 8px"
              >+92</span
            >
            <input name="phone" id="phone"
              class="form-control bg-black input-focus-border border-0 border-bottom rounded-0 text-white padding-left"
              type="text"
              placeholder="<?php echo app('translator')->get('Enter phone number'); ?>"
            />
            <input type="hidden" name="phone_code" value="+62">
            <input type="hidden" name="country_code" value="+62">

            <?php $__errorArgs = ['phone'];
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
          <p class="text-white mb-1 mt-3"><?php echo app('translator')->get('Kata Sandi'); ?></p>
          <div class="position-relative">
            <span class="text-white position-absolute end-0" style="bottom: 8px"
              ><i class="fa-regular fa-eye-slash text-secondary"></i
            ></span>
            <input name="password"
              class="form-control bg-black input-focus-border border-0 border-bottom rounded-0 text-white padding-right"
              type="password"
              placeholder="<?php echo app('translator')->get('Kata Sandi'); ?>"
            />
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


          <p class="text-white mb-1 mt-3"><?php echo app('translator')->get('Konfirmasi Kata Sandi'); ?></p>
          <div class="position-relative">
            <span class="text-white position-absolute end-0" style="bottom: 8px"
              ><i class="fa-regular fa-eye-slash text-secondary"></i
            ></span>
            <input name="password_confirmation"
              class="form-control bg-black input-focus-border border-0 border-bottom rounded-0 text-white padding-right"
              type="password"
              placeholder="<?php echo app('translator')->get('Konfirmasi Kata Sandi'); ?>"
            />
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

          

          <p class="text-white mb-1 mt-3"><?php echo app('translator')->get('Input captcha'); ?></p>
          <div class="position-relative">

            <span  class=" position-absolute end-0" style="bottom: 8px">
                <?php echo captcha_image_html('RegisterCaptcha'); ?>

            </span>
            <input name="captcha"  id="CaptchaCode"
              class="form-control bg-black input-focus-border border-0 border-bottom rounded-0 text-white padding-right"
              type="text"
              placeholder="<?php echo app('translator')->get('Input captcha'); ?>"
            />
          </div>
          <p class="text-white mb-1 mt-3"><?php echo app('translator')->get('Optional'); ?></p>
          <div>
            <input name="sponsor"
              class="form-control bg-black input-focus-border border-0 border-bottom rounded-0 text-white ps-0"
              type="number"
              placeholder="<?php echo app('translator')->get('Invitation code'); ?>"
            />
          </div>
  
          <button class="bg-warning w-100 fs-5 fw-bold text-dark rounded-5 border-0 p-2 my-5">
            <?php echo app('translator')->get('Register'); ?> 
        </button>
        </div>

    </form>


        <div class="row border-top border-secondary pt-1">
            <a href="#" class="text-decoration-none text-white h5 text-center">
              <img src="<?php echo e(asset('assets/frontend/images/icons/file.png')); ?>" width="50" alt="" /><span
                class="ms-2"
                ><?php echo app('translator')->get('Download app'); ?></span
              >
            </a>
          </div>
      </section>


<?php $__env->stopSection(); ?>
<?php $__env->startPush('script'); ?>
<script>
    function showPass() {
      var x = document.getElementById("password");
      if (x.type === "password") {
        x.type = "text";
      } else {
        x.type = "password";
      }
    }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme.'layouts.5glogistic', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\intan\resources\views/themes/5glogistic/auth/register.blade.php ENDPATH**/ ?>