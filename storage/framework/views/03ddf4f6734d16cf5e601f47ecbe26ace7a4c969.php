<?php $__env->startSection('title',trans('Transaksi')); ?>
<?php $__env->startSection('content'); ?>
<?php $__env->startPush('style'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/frontend/intan/css/transaction.css')); ?>">

<?php $__env->stopPush(); ?>


<!-- ============ TRANSACTION HEADER START HERE =================== -->
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
<!-- ============ TRANSACTION HEADER END HERE =================== -->
<!-- =============== BREAD CRUMB SECTION START HERE ================ -->
<div class="container-fluid transaction-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('user.home')); ?>">Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Transaksi</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- =============== BREAD CRUMB SECTION END HERE ================ -->
<!-- ========================= TRANSACTION SECTION START HERE ====================== -->
<div class="container-fluid">
    <div class="container">
        <div class="row transaction-sec">
            <div class="col-md-12">
                <h1>Transaksi</h1>
                <p>Daftar Transaksi Anda</p>
            </div>
        </div>
        <div class="row">

            <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

            <div class="col-lg-4 col-md-6">
                <div class="transaction-card">
                    <h6><?php echo app('translator')->get($transaction->remarks); ?></h6>
                    <p class="date-line">Date : <span><?php echo e(dateTime($transaction->created_at, 'd M Y H:i')); ?> WIB</span></p>
                    <p class="income-line">Income : <span class="<?php echo e(($transaction->trx_type == "+") ? '': 'expire-income'); ?>" ><?php echo e(($transaction->trx_type == "+") ? '+': '-'); ?> <?php echo e(trans($basic->currency_symbol)); ?> <?php echo e(number_format($transaction->amount)); ?></span></p>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- ========================= TRANSACTION SECTION END HERE ====================== -->
<!-- ========================= TRANSACTION PAGINATION START HERE ====================== -->
<div class="container-fluid pagination-sec">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="Page navigation example">
                    <?php echo e($transactions->onEachSide(0)->links()); ?>

                </nav>
            </div>
        </div>
    </div>
</div>
<!-- ========================= TRANSACTION PAGINATION END HERE ====================== -->

<?php $__env->stopSection(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/perhiasanintan/public_html/resources/views/themes/intan/user/transaction/index.blade.php ENDPATH**/ ?>