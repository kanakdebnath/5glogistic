<?php $__env->startSection('title',trans('Akun Bank')); ?>
<?php $__env->startSection('content'); ?>
<?php $__env->startPush('style'); ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- stylesheet -->
<link rel="stylesheet" href="<?php echo e(asset('assets/frontend/intan/css/Account.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/frontend/intan/css/change-detail.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/frontend/intan/css/Bank-account.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/frontend/intan/css/model.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/frontend/intan/css/withdraw.css')); ?>">

<?php $__env->stopPush(); ?>



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

<!-- ========== START SECOND ========== -->

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <!-- START BTEADCRUM -->
             <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('user.home')); ?>">Beranda</a></li>
                    <li class="breadcrumb-item active banck-crum" aria-current="page">Akun Bank</li>
                </ol>
            </nav>

            <!-- END BTEADCRUM -->

        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h3 class="Second-heading">Akun Bank</h3>
        </div>
    </div>

    <?php if($accounts->count() < 1): ?>
        <div class="row">
            <div class="col-md-12">
                    <div class="debit-card">
                        <a href="<?php echo e(route('user.paymentmethods.create')); ?>">
                        <img src="<?php echo e(asset('assets/frontend/intan/img/add-bank-account.png')); ?>" alt="">
                        <p class="nbr">ADD YOUR BANK ACCOUNT</p>
                        </a>
                    </div>
            </div>
        </div>
    <?php else: ?>
    <div class="row">
        <?php $__empty_1 = true; $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="col-md-12">
            <div class="debit-card">
                <p class="james" style="margin-bottom: 15px;"><?php echo e($account->account_holder); ?></p>
                <img src="<?php echo e(asset('assets/frontend/intan/bank_logo/'.$account->bank->logo)); ?>" width="100px" style="margin-bottom: 15px;" class="img-fluid rounded-top" alt="">
                <p class="account-no"><?php echo app('translator')->get('Nomor Rekening'); ?></p>
                <p class="nbr"><?php echo e(getTruncatedCCNumber($account->bank_account)); ?></p>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>


     <?php $__empty_1 = true; $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3 class="last-heading">Apakah Ingin Mengganti Data ?</h3>
            <a href="<?php echo e(route('user.paymentmethods.edit',$account->id)); ?>">
                <button class="last-btn" type="text">
                    Ganti Data
                </button>
            </a>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <?php endif; ?>
</div>
<!-- ===== input end ===== -->

<?php
    function getTruncatedCCNumber($ccNum){
        return str_replace(range(0,9), "*", substr($ccNum, 0, -4)) . substr($ccNum, -4);
    }
?>



<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content main-modal">
        <center>
        <img src="<?php echo e(getFile(config('location.logoIcon.path').'logo.png')); ?>" style="height: 70px;" />
        </center>
        <h3 class="modal-heding">PERHATIAN</h3>
        <p class="model-text">Pastikan kembali data berikut sudah benar</p>

        <div class="table">
            <p><span class="left-side-list"><?php echo app('translator')->get('Full Name'); ?> :</span> <span class="right-side-list" id="account_holder"></span></p>
            <p><span class="left-side-list"><?php echo app('translator')->get('Jenis Bank'); ?> :</span> <span class="right-side-list" id="selected_bank"></span></p>
            <p><span class="left-side-list"><?php echo app('translator')->get('Account Number'); ?> :</span> <span class="right-side-list" id="account_number"></span>
            </p>
        </div>

        <div class="modal-footer">
            <button type="button" class="cancel-btn" data-bs-dismiss="modal"><?php echo app('translator')->get('Batal'); ?></button>
        <button type="button" onclick="msform.submit();" class="confir-btn"><?php echo app('translator')->get('Confirm'); ?></button>
        </div>

        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script src="<?php echo e(asset('assets/frontend/js/script.js')); ?>"></script>
<script>
    $(document).ready(function(){
        $('input[name="account_holder"]').on('keyup', function(){
            $('#account_holder').text($(this).val());
        });
        $('select[name="bank_id"]').on('change', function(){
            $('#selected_bank').text($(this).find('option:selected').text());
        });
        $('input[name="bank_account"]').on('keyup', function(){
            $('#account_number').text($(this).val());
        });
    })
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/perhiasanintan/public_html/resources/views/themes/intan/user/account/index.blade.php ENDPATH**/ ?>