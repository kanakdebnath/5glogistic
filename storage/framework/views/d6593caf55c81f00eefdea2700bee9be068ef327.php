<?php $__env->startSection('title','Pendaftaran'); ?>

<?php $__env->startSection('content'); ?>



<!-- ========================= SIGIN SECTION START HERE ====================== -->
<div class="container-fluid">
    <div class="container">
        <div class="row">
            <form class="register-form" action="<?php echo e(route('register')); ?>" method="post">
                <?php echo csrf_field(); ?>
            <div class="col-md-12 profile-inputs">
                 <center>
                    <img src="<?php echo e(getFile(config('location.logoIcon.path').'logo.png')); ?>" style="height: 110px;" />
                </center>
                <div class="form-group has-search mb-3">
                    <label for="exampleFormControlInput1" class="form-label"><?php echo app('translator')->get('Username'); ?></label>
                    <i class="fa-solid fa-user pro-icon"></i>
                    <input name="username" id="username" type="text" class="form-control" placeholder="<?php echo app('translator')->get('Username'); ?>">
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
                </div>
                 <div class="form-group has-search mb-3">
                    <label for="exampleFormControlInput1" class="form-label"><?php echo app('translator')->get('Email'); ?></label>
                    <i class="fa-solid fa-envelope pro-icon"></i>
                    <input type="email" id="email" name="email" class="form-control" placeholder="<?php echo app('translator')->get('Email'); ?>" disabled>
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
                    <label for="exampleFormControlInput1" class="form-label"><?php echo app('translator')->get('First Name'); ?></label>
                    <i class="fa-solid fa-user pro-icon"></i>
                    <input type="text" id="firstname" name="firstname" class="form-control" placeholder="<?php echo app('translator')->get('First Name'); ?>" disabled>
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
                <div class="form-group has-search mb-3">
                    <label for="exampleFormControlInput1" class="form-label"><?php echo app('translator')->get('Last Name'); ?></label>
                    <i class="fa-solid fa-user pro-icon"></i>
                    <input type="text" id="lastname" name="lastname" class="form-control" placeholder="<?php echo app('translator')->get('Last Name'); ?>" disabled>
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
                <div class="form-group has-search mb-3">
                    <label for="exampleFormControlInput1" class="form-label"><?php echo app('translator')->get('Nomor HP'); ?></label>
                    <i class="fa-solid fa-phone pro-icon"></i>
                    <input type="text" name="phone" id="phone" class="form-control" placeholder="<?php echo app('translator')->get('08xxxxxxx'); ?>" disabled>
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
                <div class="form-group has-search mb-3">
                    <label for="exampleFormControlInput1" class="form-label"><?php echo app('translator')->get('Kata Sandi'); ?></label>
                    <i class="fa-solid fa-key pro-icon"></i>
                    <input id="password-field" name="password" type="password" class="form-control" placeholder="<?php echo app('translator')->get('Kata Sandi'); ?>" disabled>
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
                    <label for="exampleFormControlInput1" class="form-label"><?php echo app('translator')->get('Confirm Password'); ?></label>
                    <i class="fa-solid fa-key pro-icon"></i>
                    <input name="password_confirmation" id="password-field1" type="password" class="form-control" placeholder="<?php echo app('translator')->get('Konfirmasi Kata Sandi'); ?>" disabled>
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
                
                <div class="form-group has-search mb-3">
                    <div class="row">
                        <div class="col-8">
                            <label for="exampleFormControlInput1" class="form-label"><?php echo app('translator')->get('Kode OTP'); ?></label>
                            <i class="fa-solid fa-key pro-icon"></i>
                            <input name="verification_code" type="number" id="verificationCode" class="form-control" placeholder="<?php echo app('translator')->get('Kirim Kode'); ?>" disabled>
                            <small class="text-success" id="verificationMsg"></small>        
                        </div>
                        <div class="col-4" style="margin-top:26px;">
                            <button type="button" class="btn btn-primary" onClick="sendCode($(this))" id="send_code" disabled>Kirim Code</button>
                            <small id="timer_div"></small>
                        </div>
                    </div>
                    
                </div>
                
                               <center style="  height: 70px;">
                    <button type="submit" class="btn btn-primary" id="signup" disabled><?php echo app('translator')->get('Sign Up'); ?></button>
                </center>
                <p>Sudah Memiliki Akun ? <a href="<?php echo e(route('login')); ?>"><span> Login</span></a></p>
                 <center>
                    <img src="<?php echo e(asset('assets/frontend/intan/img/ojk.png')); ?>" style="height: 30px;" />
                </center>
                <br>
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
    
    $("#username").keyup(function(){
        $("#email").attr('disabled',false);
    });
    $("#email").keyup(function(){
        $("#firstname").attr('disabled',false);
    });
    $("#firstname").keyup(function(){
        $("#lastname").attr('disabled',false);
    });
    $("#lastname").keyup(function(){
        $("#phone").attr('disabled',false);
    });
    $("#phone").keyup(function(){
        $("#password-field").attr('disabled',false);
    });
    $("#password-field").keyup(function(){
        $("#password-field1").attr('disabled',false);
    });
    $("#password-field1").keyup(function(){
        $("#send_code").attr('disabled',false);
    });
    function sendCode(elm){
        var verificationCode = $("#verificationCode").val();
        var phone = $("#phone").val();
        var email = $("#email").val();
        if(verificationCode == ""){
            $("#verificationCode").attr('disabled',false);
            $("#verificationMsg").html('');
            $("#send_code").attr('disabled',true);
            $.ajax({
                type : "GET",
                url  : "<?php echo e(route('verificationCode')); ?>",
                data : {
                    'phone'  : phone,
                    'email'  : email,
                    'verificationCode' : verificationCode,
                },
                beforeSend : function(res){
                    $("#send_code").html('<div class="spinner-border spinner-border-sm" role="status"><span class="sr-only"></span></div>');
                },
                success : function(res){
                    timer(25);
                    $("#send_code").html('Send Code');
                    if(res.success == true){ 
                        $("#signup").attr('disabled',false);
                        $("#verificationMsg").html('Kode OTP Telah dikirim');
                    }
                    else{
                        $("#signup").attr('disabled',true);
                        $("#verificationMsg").html('Nomor HP Salah');
                    }
                },
                error   : function(res){
                    $("#signup").attr('disabled',false);
                    timer(25);
                    $("#send_code").html('Kirim Code');
                }
                
            });    
        }
        else{
            // $("#verificationMsg").html('Code is required');
        }
        
    }

    function timer(time){
       var timeLeft = 60;
      //   var timeLeft = 10;
      var elem = document.getElementById("send_code");
      var timerId = setInterval(countdown, 1000);
      function countdown() {
        if (timeLeft == 0) {
          clearTimeout(timerId);
          $("#send_code").html('Send Code');
          $("#send_code").attr('disabled',false);
        } else {
          elem.innerHTML = timeLeft;
          timeLeft--;
        }
      }
      
    }
    

  
</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make($theme.'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/perhiasanintan/public_html/resources/views/themes/intan/auth/register.blade.php ENDPATH**/ ?>