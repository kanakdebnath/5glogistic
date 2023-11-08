<?php $__env->startSection('title',trans('Detail Anggota')); ?>

<?php $__env->startSection('content'); ?>

<?php $__env->startPush('style'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/frontend/intan/css/member-detail.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/frontend/intan/css/withdraw.css')); ?>">

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
                            <li class="breadcrumb-item active" aria-current="page">Detail Anggota</li>
                        </ol>
                    </nav>
                    <!-- END: BREADCRUMB -->
                </div>
                <div class="row" id="member-detail-card">
                    <div class="col-md-12">
                        <h1>Level <?php echo e($level); ?></h1>
                        <table>
                            <tr>
                                <th>Total Anggota</th>
                                <td><b><?php echo e($total); ?></b> Anggota</td>
                            </tr>
                            <tr>
                                <th>Berinvestasi</th>
                                <td><b><?php echo e($active); ?></b> Anggota</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="table-heading">Detail Anggota</h1>
                    </div>
                </div>
                <!-- table -->
                <div class="row referral-table">
                    <div class="col-md-12 p-0">
                        <div class="table-responsive">
                            <table class="table table-separate">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nomor HP</th>
                                        <th>Investasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e(++$index); ?></td>
                                        <td><?php echo e(isset($d) ? $d->phone : null); ?></td>
                                        <td class='text-<?php echo e(count(IsActiveUser($d->id)) > 0?'success':'danger'); ?>'style='text-align:center;'><?php echo e(count(IsActiveUser($d->id)) > 0?'Ya':'Tidak'); ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="3" class="text-center">Data Tidak Ditemukan</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                            
                            <!-- ========================= TRANSACTION PAGINATION START HERE ====================== -->
                            <div class="mt-3" style="float:right">
                                <?php echo e($data->onEachSide(0)->links()); ?>

                            </div>
                            <!-- ========================= TRANSACTION PAGINATION END HERE ====================== -->
                            
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
<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/perhiasanintan/public_html/resources/views/themes/intan/user/member-details.blade.php ENDPATH**/ ?>