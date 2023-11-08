<?php $__env->startSection('title',trans('Daftar Bonus')); ?>

<?php $__env->startSection('content'); ?>

<?php $__env->startPush('style'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/frontend/intan/css/bonus_history.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/frontend/intan/css/withdraw.css')); ?>">

<?php $__env->stopPush(); ?>



<!-- BEGIN: JEWLERY HEADER SECTION -->
<header class="jewlery-referral-header">
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
</header>
<!-- END: JEWLERY HEADER SECTION -->
<!-- BEGIN: PROFILE SECTION -->
<section class="referral-table-section">
    <div class="container-fluid">
        <div class="container">
            <div class="col-md-12">
                <div class="row referral-breadcrumb">
                    <!-- BEGIN: BREADCRUMB -->
                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="p-0">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('user.referral')); ?>">Referral</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Daftar Bonus</li>
                        </ol>
                    </nav>
                    <!-- END: BREADCRUMB -->
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="table-heading">Daftar Bonus</h1>
                    </div>
                </div>
                <!-- table -->
                <div class="row referral-table">
                    <div class="col-md-12 p-0">
                        <div class="table-responsive">
                            <table class="table table-separate" style="width:100%">
                                <thead>
                                    <tr>
                                    <th  style="text-align:center;"><?php echo app('translator')->get('Anggota'); ?></th>
                                    <th  style="text-align:center;"><?php echo app('translator')->get('Level'); ?></th>
                                    <th  style="text-align:center;"><?php echo app('translator')->get('Jumlah'); ?></th>
                                    
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="bonus-name" style="text-align:center;"><?php echo e($trx->bonusBy->phone); ?></td>
                                    <td class="bonus-name" style="text-align:center;"><?php echo e($trx->level); ?></td>
                                    <td class="bonus-amount text-success"  style="text-align:center;"><small><?php echo e(trans($basic->currency_symbol)); ?></small><?php echo e(number_format($trx->amount)); ?></td>
                                    
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                
                                    
                                </tbody>
                            </table>
                            <div class="mt-3" style="float:right">
                                <?php echo e($transactions->onEachSide(0)->links()); ?>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- table -->
            </div>
        </div>
    </div>
</section>
<!-- END: PROFILE SECTION -->


<?php $__env->stopSection(); ?>
<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/perhiasanintan/public_html/resources/views/themes/intan/user/bonus-history.blade.php ENDPATH**/ ?>