
<?php $__env->startSection('title',trans('Beranda')); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startPush('style'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/frontend/intan/css/style1.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/frontend/intan/css/home.css')); ?>">
<?php $__env->stopPush(); ?>

 <header class="jewlery-header">
        <div class="container-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                         <div class="banner">
                         <img src="<?php echo e(asset('assets/frontend/images/Profileicon.png')); ?>" style="height:110px"; alt="">
                            <h1><?php echo e(Auth::user()->fullname); ?></h1>
                             <p><?php echo e(Auth::user()->email); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <br>
<center>
                             <img src="<?php echo e(getFile(config('location.logoIcon.path').'logo.png')); ?>" style="height: 110px;" />
                          </center>
<!-- ================== DASHBOARD BUTTON SECTION START HERE ===================== -->
<div class="container">
    <div class="btn-sec">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-2 col-md-4 col-sm-4 col-4">
                <a href="<?php echo e(route('user.paymentmethods.list')); ?>">
                    <button>
                        <img src="<?php echo e(asset('assets/frontend/intan/img/banner-btn-5.jpg')); ?>" alt="">
                        <?php echo app('translator')->get('Payment Methods'); ?>
                    </button>
                </a>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-4 col-4">
                <a href="<?php echo e(route('user.payout.money')); ?>">
                    <button>
                        <img src="<?php echo e(asset('assets/frontend/intan/img/banner-btn-4.jpg')); ?>" alt="">
                        <?php echo app('translator')->get('Withdraw Money'); ?>
                    </button>
                </a>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-4 col-4">
                <a href="<?php echo e(route('user.transaction')); ?>">
                    <button>
                        <img src="<?php echo e(asset('assets/frontend/intan/img/banner-btn-2 .jpg')); ?>" alt="">
                        <?php echo app('translator')->get('Transactions'); ?>
                    </button>
                </a>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-4 col-4">
                <a href="<?php echo e(route('user.profile')); ?>">
                    <button>
                    <img src="<?php echo e(asset('assets/frontend/intan/img/banner-btn-1.jpg')); ?>" alt="">
                    <?php echo app('translator')->get('Profile'); ?>
                </button>
                </a>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-4 col-4">
                <a href="https://play.google.com/store/apps/details?id=com.apps.perhiasanintan">
                <button>
                    <img src="<?php echo e(asset('assets/frontend/intan/img/banner-btn-3.jpg')); ?>" alt="">
                    <?php echo app('translator')->get('Unduh APK'); ?>
                </button>
                </a>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-4 col-4">
                <a href="<?php echo e(asset('assets/upload/company.pdf')); ?>" download>
                <button>
                    <img src="<?php echo e(asset('assets/frontend/intan/img/banner-btn-8.jpg')); ?>" alt="">
                    <?php echo app('translator')->get('Panduan'); ?>
                </button>
                </a>
            </div>
            
            <div class="col-lg-2 col-md-4 col-sm-4 col-4">
                <a href="https://t.me/perhiasanintandiscussion">
                <button>
                    <img src="<?php echo e(asset('assets/frontend/intan/img/banner-btn-9.jpg')); ?>" alt="">
                    <?php echo app('translator')->get('Grup Resmi'); ?>
                </button>
                </a>
            </div>
            
            <div class="col-lg-2 col-md-4 col-sm-4 col-4">
                <button onclick="document.getElementById('logout-form').submit();">
                        <img src="<?php echo e(asset('assets/frontend/intan/img/banner-btn-6.jpg')); ?>" alt="">
                        <?php echo app('translator')->get('Log Out'); ?>

                    <form action="<?php echo e(route('logout')); ?>"  method="post" id="logout-form" style="display: none !important;">
                        <?php echo csrf_field(); ?>
                    </form>
                    
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ================== DASHBOARD BUTTON SECTION END HERE ==================== -->

<!-- ================ DASHBOARD INVESTEMENT SECTION STRAT HERE =============== -->
<div class="container">
    <div class="investment">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4 inves col-sm-12 col-12">
                <center>
                    <a href="<?php echo e(route('user.investments')); ?>">
                        <button><?php echo app('translator')->get('Status Investasi'); ?></button>
                    </a>
                </center>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</div>

<div class="container">
    <div class="withdraw">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4 draw">
                <h1><?php echo app('translator')->get('Saldo Tersedia'); ?></h1>
                <p><?php echo e(trans($basic->currency_symbol)); ?> <?php echo e(number_format($walletBalance)); ?></p>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</div>

<div class="container">
    <div class="profit">
        <div class="row">
            <div class="col-md-6 recently">
                <h1><?php echo app('translator')->get('Total Investasi'); ?></h1>
                <p><?php echo app('translator')->get('Investasi Berjalan'); ?> : <strong><?php echo e(Auth::user()->invests()->count()); ?> <?php echo app('translator')->get('Investasi'); ?></strong></p>
                <h6><?php echo app('translator')->get('Investasi Selesai'); ?> : <span><?php echo e(Auth::user()->invests()->where('status', 0)->count()); ?> <?php echo app('translator')->get('Investasi'); ?></span>
                </h6>
            </div>
            <div class="col-md-6 recently">
                <h1><?php echo app('translator')->get('Keuntungan & Bonus'); ?></h1>
                <p><?php echo app('translator')->get('Total Keuntungan'); ?> : <strong><?php echo e(trans($basic->currency_symbol)); ?> <?php echo e(number_format($totalProfit)); ?></strong></p>
                <h6><?php echo app('translator')->get('Keuntungan Bulanan'); ?> : <span><?php echo e(trans($basic->currency_symbol)); ?> <?php echo e(number_format($totalProfitMonthly)); ?></span>
                </h6>
            </div>
        </div>
    </div>
</div>
<!-- ================ DASHBOARD INVESTEMENT SECTION END HERE =============== -->


<?php $__env->stopSection(); ?>




<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/perhiasanintan/public_html/resources/views/themes/intan/user/dashboard.blade.php ENDPATH**/ ?>