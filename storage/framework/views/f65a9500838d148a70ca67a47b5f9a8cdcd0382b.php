<?php $__env->startSection('title',trans($title)); ?>


<?php $__env->startPush('style'); ?>
<!-- stylesheet -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/frontend/intan/css/withdraw.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/frontend/intan/css/table.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<!-- ============ CHANGE PROFILE HEADER START HERE =================== -->
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
<!-- ============ CHANGE PROFILE HEADER END HERE =================== -->
<!-- =============== BREAD CRUMB SECTION START HERE ================ -->
<div class="container-fluid changePass-breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('user.home')); ?>">Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Penarikan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- =============== BREAD CRUMB SECTION END HERE ================ -->
<!-- ========================= TABS SECTION START HERE ====================== -->
<div class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="tabset">
                    <!-- Tab 1 -->
                    <input type="radio" name="tabset" id="tab1" aria-controls="marzen" checked>
                    <label for="tab1">Formulir Penarikan</label>
                    <!-- Tab 2 -->
                    <input type="radio" name="tabset" id="tab2" aria-controls="rauchbier">
                    <label for="tab2" class="chngePass-tab">Riwayat Penarikan</label>

                    <div class="tab-panels">
        
                        <section id="marzen" class="tab-panel profile-inputs">
                            <form action="<?php echo e(route('user.toppay.moneyRequest')); ?>" enctype="multipart/form-data" autocomplete="off" id="payout" method="post">
                                <?php echo csrf_field(); ?>
                            <input type="hidden" name="gateway" value="<?php echo e($gateway->id); ?>">
                            <input type="hidden" name="wallet_type" value="balance">
                            <h2>Formulir Penarikan</h2>
                            
                            <div class="form-group has-search mb-3">
                                <label for="exampleFormControlInput1" class="form-label"><?php echo app('translator')->get('Nominal Penarikan'); ?> :</label>
                                <i class="fa-solid fa-box pro-icon"></i>
                                <input type="number" name="amount" id="amount" class="form-control" placeholder="Masukkan Nominal">
                                <p>Min. <?php echo e($basic->currency_symbol); ?> <?php echo e(number_format($gateway->minimum_amount, $basic->fraction_number)); ?> - <?php echo e($basic->currency_symbol); ?> <?php echo e(number_format($gateway->maximum_amount, $basic->fraction_number)); ?></p>
                                <?php $__errorArgs = ['amount'];
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
                                <label for="exampleFormControlInput1" class="form-label">Jumlah Diterima :</label>
                                <i class="fa-solid fa-box pro-icon"></i>
                                <input type="number" id="charge" readonly class="form-control" placeholder="Jumlah Diterima">
                                
                            </div>
                            <div class="form-group has-search mb-3">
                                <label for="exampleFormControlInput1" class="form-label"><?php echo app('translator')->get('Akun Bank'); ?> :</label>
                                <i class="fa-solid fa-building-columns pro-icon"></i>

                                <select name="account_id" class="form-control" required>
                                    <option value="" disabled selected><?php echo app('translator')->get('Bank Name'); ?></option>
                                    <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($account->id); ?>"><?php echo e($account->bank->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <p>* Pajak Penarikan Rp <?php echo e(number_format($gateway->fixed_charge)); ?></p>

                                <?php $__errorArgs = ['account_id'];
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
                            <center>
                                <button type="submit" class="btn btn-primary"><?php echo app('translator')->get('Proses'); ?></button>
                                <button id="processing" style="display: none" disabled class="btn form-btn ">Proses</button>
                            </center>
                            </form>
                        </section>
                        <section id="rauchbier" class="tab-panel profile-inputs1">
                            <h2><?php echo app('translator')->get('Riwayat Penarikan'); ?></h2>
                            <!-- table -->
                            <a class="btn btn-primary" onClick="window.location.reload();">Refresh</a>
                            <div class="row referral-table" style="margin-bottom: 90px;">
                                <div class="col-md-12 p-0">
                                    <div class="table-responsive">
                                        <table class="table table-separate">
                                            <thead>
                                                <tr>
                                                   
                                                    <th><?php echo app('translator')->get('Date'); ?></th>
                                                    <th><?php echo app('translator')->get('Amount'); ?></th>
                                                    <th><?php echo app('translator')->get('Bank'); ?></th>
                                                    <th><?php echo app('translator')->get('Status'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__empty_1 = true; $__currentLoopData = $payoutLog; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <?php if($item->status == 1): ?>
                                                <tr>
                                                   
                                                    <td class="withdraw-date"><?php echo e(dateTime($item->created_at, 'd M Y H:i')); ?> WIB </td>
                                                    <td class="withdraw-success text-success"><?php echo app('translator')->get($basic->currency_symbol); ?> <?php echo e(number_format($item->net_amount)); ?> </td>
                                                    <td class="text"><?php echo e($account->bank->name); ?> </td>
                                                    <td class="text-warning pending"><?php echo app('translator')->get('Proses'); ?></td>
                                                </tr>
                                                <?php elseif($item->status == 2): ?>
                                                <tr>
                                                   
                                                    <td class="withdraw-date"><?php echo e(dateTime($item->created_at, ' d M Y H:i')); ?> WIB</td>
                                                    <td class="withdraw-success text-success"><?php echo app('translator')->get($basic->currency_symbol); ?> <?php echo e(number_format($item->net_amount)); ?></td>
                                                    <td class="text"><?php echo e($account->bank->name); ?> </td>
                                                    <td class="withdraw-success text-success"><?php echo app('translator')->get('Sukses'); ?></td>
                                                </tr>
                                                <?php elseif($item->status == 3): ?>
                                                <tr>
                                                    
                                                    <td class="withdraw-date"><?php echo e(dateTime($item->created_at, 'd M Y H:i')); ?> WIB</td>
                                                    <td class="withdraw-success text-success"><?php echo app('translator')->get($basic->currency_symbol); ?> <?php echo e(number_format($item->net_amount)); ?></td>
                                                    <td class="text"><?php echo e($account->bank->name); ?> </td>
                                                    <td class="cancled text-danger"><?php echo app('translator')->get('Gagal'); ?></td>
                                                </tr>
                                                <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <?php endif; ?>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- table -->

                            <div class="container-fluid pagination-sec">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <nav aria-label="Page navigation example">
                                                <?php echo e($payoutLog->onEachSide(0)->links()); ?>

                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $('#amount').on('keyup', function(){
            $('#charge').val(Number(parseInt($(this).val()) - parseInt("<?php echo e($gateway->fixed_charge); ?>") - (parseInt($(this).val()) / 100 * parseInt("<?php echo e($gateway->percent_charge); ?>")) ));
        });
    })
    
    $('form#payout').submit(function(){
            $(this).find(':button[type=submit]').hide();
            $(this).find('#processing').show();
        });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/perhiasanintan/public_html/resources/views/themes/intan/user/payout/money.blade.php ENDPATH**/ ?>