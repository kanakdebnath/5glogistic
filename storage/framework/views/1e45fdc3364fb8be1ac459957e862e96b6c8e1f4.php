<?php $__env->startSection('title',trans('Ubah Profil')); ?>
<?php $__env->startSection('content'); ?>
<?php $__env->startPush('style'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/frontend/intan/css/changeProfile.css')); ?>">
<?php $__env->stopPush(); ?>


<!-- BEGIN: JEWLERY HEADER SECTION -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 p-0">
            <div class="header-bgimg">
                <center>
                    <img src="<?php echo e(getFile(config('location.logoIcon.path').'logo.png')); ?>" style="height: 110px;" />
                </center>
            </div>
        </div>
    </div>
</div>
<!-- END: JEWLERY HEADER SECTION -->


<!-- =============== BREAD CRUMB SECTION START HERE ================ -->
<div class="container-fluid changePass-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('user.home')); ?>">Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Ubah Profil & Password</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- =============== BREAD CRUMB SECTION END HERE ================ -->
<!-- ========================= TABS SECTION START HERE ====================== -->
<div class="container-fluid" style="margin-bottom: 90px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="tabset">
                    <!-- Tab 1 -->
                    <input type="radio" name="tabset" id="tab1" aria-controls="marzen" checked>
                    <label for="tab1">Ubah Profil</label>
                    <!-- Tab 2 -->
                    <input type="radio" name="tabset" id="tab2" aria-controls="rauchbier">
                    <label for="tab2" class="chngePass-tab">Ubah Password</label>

                    <div class="tab-panels">
                        <section id="marzen" class="tab-panel profile-inputs">
                            <form class="register-form" method="post" action="<?php echo e(route('user.updateInformation')); ?>">
                                <?php echo method_field('put'); ?>
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="language_id" value="1">
                            <h2><?php echo app('translator')->get('Ubah Profil'); ?></h2>
                             <div class="form-group has-search mb-3">
                                <label for="exampleFormControlInput1" class="form-label"><?php echo app('translator')->get('Username'); ?> :</label>
                                <i class="fa-solid fa-user pro-icon"></i>
                                <input type="text" style="background-color: #cccccc;" name="username" class="form-control" id="username" placeholder="<?php echo app('translator')->get('Username'); ?>" value="<?php echo e(old('username')?: $user->username); ?>" disabled>
                            </div>
                            <?php if($errors->has('username')): ?>
                                    <span class="text-danger"><?php echo app('translator')->get($errors->first('username')); ?> </span>
                                <?php endif; ?>
                            <div class="form-group has-search mb-3">
                                <label for="exampleFormControlInput1" class="form-label"><?php echo app('translator')->get('Email'); ?>:</label>
                                <i class="fa-solid fa-envelope pro-icon"></i>
                                <input type="email" style="background-color: #cccccc;" name="email" class="form-control" id="email" placeholder="<?php echo app('translator')->get('Email Address'); ?>" value="<?php echo e(old('email')?: $user->email); ?>" disabled>
                            </div>
                            <?php if($errors->has('email')): ?>
                                    <span class="text-danger"><?php echo app('translator')->get($errors->first('email')); ?> </span>
                                <?php endif; ?>
                            <div class="form-group has-search mb-3">
                                <label for="exampleFormControlInput1" class="form-label"><?php echo app('translator')->get('First Name'); ?> :</label>
                                <i class="fa-solid fa-user pro-icon"></i>
                                <input type="text" name="firstname" class="form-control" placeholder="<?php echo app('translator')->get('First Name'); ?>" value="<?php echo e(old('firstname')?: $user->firstname); ?>" required>
                            </div>
                            <?php if($errors->has('firstname')): ?>
                                    <span class="text-danger"><?php echo app('translator')->get($errors->first('firstname')); ?> </span>
                                <?php endif; ?>
                            <div class="form-group has-search mb-3">
                                <label for="exampleFormControlInput1" class="form-label"><?php echo app('translator')->get('Last Name'); ?> :</label>
                                <i class="fa-solid fa-user pro-icon"></i>
                                <input type="text" name="lastname" class="form-control" id="lastname" placeholder="<?php echo app('translator')->get('Last Name'); ?>" value="<?php echo e(old('lastname')?: $user->lastname); ?>" required>
                            </div>
                            <?php if($errors->has('lastname')): ?>
                                    <span class="text-danger"><?php echo app('translator')->get($errors->first('lastname')); ?> </span>
                                <?php endif; ?>
                            <div class="form-group has-search mb-3">
                                <label for="exampleFormControlInput1" class="form-label"><?php echo app('translator')->get('Nomor HP'); ?> :</label>
                                <i class="fa-solid fa-phone pro-icon"></i>
                                <input type="text" class="form-control" id="phone" style="background-color: #cccccc;" placeholder="Phone Number" value="<?php echo e(old('phone')?: $user->phone); ?>" readonly>
                            </div>
                            <?php if($errors->has('phone')): ?>
                            <span class="text-danger"><?php echo app('translator')->get($errors->first('phone')); ?> </span>
                        <?php endif; ?>
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label"><?php echo app('translator')->get('Address'); ?> :</label>
                                <textarea name="address" class="form-control textarea-sec" id="address" cols="30" rows="3"><?php echo e(old('address')?: $user->address); ?></textarea>
                            </div>
                            <?php if($errors->has('address')): ?>
                                    <span class="text-danger"><?php echo app('translator')->get($errors->first('address')); ?></span>
                                <?php endif; ?>
                            <center>
                                <button type="submit" class="btn btn-primary"><?php echo app('translator')->get('Update Profile'); ?></button>
                            </center>
                        </form>
                        </section>
                        <section id="rauchbier" class="tab-panel profile-inputs">
                            <form class="register-form" method="post" action="<?php echo e(route('user.updatePassword')); ?>">
                                <?php echo csrf_field(); ?>

                            <h2><?php echo app('translator')->get('Change Password'); ?></h2>
                            <div class="form-group has-search mb-3">
                                <label for="exampleFormControlInput1" class="form-label"><?php echo app('translator')->get('Current Password'); ?> :</label>
                                <i class="fa-solid fa-key pro-icon"></i>
                                <input type="password" name="current_password" class="form-control" id="old-password" placeholder="<?php echo app('translator')->get('Current Password'); ?>" required>
                            </div>
                            <?php if($errors->has('current_password')): ?>
                                    <span class="text-danger"><?php echo app('translator')->get($errors->first('current_password')); ?> </span>
                                <?php endif; ?>
                            <div class="form-group has-search mb-3">
                                <label for="exampleFormControlInput1" class="form-label"><?php echo app('translator')->get('New Password'); ?> :</label>
                                <i class="fa-solid fa-key pro-icon"></i>
                                <input type="password" name="password" class="form-control" id="password-field" placeholder="<?php echo app('translator')->get('New Password'); ?>" required>
                                <span toggle="#password-field" class="fa fa-fw fa-eye show-eye-icon toggle-password"></span>
                            </div>
                            <?php if($errors->has('password')): ?>
                            <span class="text-danger"><?php echo app('translator')->get($errors->first('password')); ?> </span>
                        <?php endif; ?>
                            <div class="form-group has-search mb-3">
                                <label for="exampleFormControlInput1" class="form-label"><?php echo app('translator')->get('Confirm Password'); ?> :</label>
                                <i class="fa-solid fa-key pro-icon"></i>
                                <input type="password" name="password_confirmation" class="form-control" id="password-field1" placeholder="<?php echo app('translator')->get('Confirm Password'); ?>" required>
                                <span toggle="#password-field1" class="fa fa-fw fa-eye show-eye-icon toggle-password"></span>
                            </div>
                            <?php if($errors->has('password_confirmation')): ?>
                                    <span class="text-danger"><?php echo app('translator')->get($errors->first('password_confirmation')); ?> </span>
                                <?php endif; ?>
                            <center>
                                <button type="submit" class="btn btn-primary"><?php echo app('translator')->get('Ubah Password'); ?></button>
                            </center>
                        </form>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ========================= TABS SECTION END HERE ====================== -->
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
<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/perhiasanintan/public_html/resources/views/themes/intan/user/profile/myprofile.blade.php ENDPATH**/ ?>