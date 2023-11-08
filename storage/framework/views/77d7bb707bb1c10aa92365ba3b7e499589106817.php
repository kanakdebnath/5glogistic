<?php $__env->startSection('title','Status Investasi'); ?>


<?php $__env->startPush('style'); ?>
<!-- stylesheet -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/frontend/intan/css/investment.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/frontend/intan/css/model.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/frontend/intan/css/withdraw.css')); ?>">

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

<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo e(route('user.home')); ?>">Beranda</a></li>
        <li class="breadcrumb-item active" aria-current="page">Status Investasi</li>
    </ol>
</nav>
<!-- =============== BREAD CRUMB SECTION END HERE ================ -->

    <!-- ================ INVESTMENT SECTION START HERE ===================== -->
    <div class="container">
        <div class="row">
            <div class="inves">
                <div class="col-md-12">
                    <h1>Status Investasi</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- ================ INVESTMENT SECTION END HERE ===================== -->

    <!-- ================= CARD SECTION START HERE ================== -->
    <div class="container">
        <div class="card-sec">
            <div class="row">

                <?php $__empty_1 = true; $__currentLoopData = $investments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $invest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                        $plan = App\Models\ManagePlan::find($invest->plan_id)
                        ?>


                <div class="col-md-6">
                    <div class="card-sec-1">
                        <center> <img src="<?php echo e(getFile(config('location.plan.path').$plan->image) ? : 0); ?>" alt=""></center>
                        <h1><?php echo e(trans(optional($invest->plan)->name)); ?></h1>
                        <p><?php echo app('translator')->get('Price'); ?> : <span><?php echo e(trans($basic->currency_symbol)); ?> <?php echo e(number_format($plan->fixed_amount)); ?></span></p>
                        <p><?php echo app('translator')->get('Profit'); ?> : <span><?php echo e(trans($basic->currency_symbol)); ?> <?php echo e(number_format($invest->profit)); ?></span></p>

                        <?php
                            $expired_on = Carbon\Carbon::parse($invest->created_at)->addDays($invest->maturity);
                            $expiry_date = Carbon\Carbon::parse($invest->created_at)->addDays($invest->maturity)->format('d M Y');
                            $today_date  = Carbon\Carbon::now();
                            // $diff_day = Carbon\Carbon::now()->diffInDays($expiry_date);
                        ?>


                        <p><?php echo app('translator')->get('Status'); ?> : 
                            <?php if($today_date->isBefore($expired_on)): ?>
                            <span class="text-success"><?php echo app('translator')->get('AKTIF'); ?></span>
                            <?php else: ?>
                            <span class="text-danger"><?php echo app('translator')->get('SELESAI'); ?></span>
                            <?php endif; ?>
                        </p>
                        <p><?php echo app('translator')->get('Tanggal Selesai'); ?> : <span><?php echo e($expiry_date); ?></span></p>

                        <p class='pb-2 text-center'>
                            <?php if($invest->recurring_time >= $invest->maturity && $invest->maturity != '-1'): ?>
                               <?php if($invest->status != 0): ?>
                               <?php if($plan->category->capital_back == 1): ?>
                               <a href="#" data-val='<?php echo e($invest->amount); ?>' data-id='<?php echo e($invest->id); ?>' class="confirm-btn btn btn-sm bg-info text-white" data-bs-toggle="modal" data-bs-target="#confirmModal">Tarik Modal</a>
                               <?php endif; ?>
                               <a href="#" data-id='<?php echo e($invest->id); ?>' data-url='<?php echo e(route('user.upgrade-plan')); ?>' class="upgrade-btn btn btn-sm bg-danger text-white">Upgrade</a>
                               <?php else: ?>
                               <hr>
                               <p class="text-danger text-center">Investasi telah selesai</p>
                               <?php endif; ?>
                           <?php endif; ?>
                        </p>

                    </div>
                </div>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>

    <!-- ================= CARD SECTION END HERE ================== -->


<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content main-modal">
        <h3 class="modal-heding"><?php echo app('translator')->get('Attention!'); ?></h3>
        <p class="model-text">Konfirmasi penarikan modal ?</p>

            <form  style="margin-bottom: 0px; margin-top: 0px; padding-top: 0px;"   autocomplete="off" method="post">
                <input type="hidden" id="invest_id" name="invest_id" value="">
                <input type="hidden" id="price" name="price" value="">
            </form>

        <div class="modal-footer d-flex justify-content-center">
            <button type="button" class="cancel-btn" data-bs-dismiss="modal"><?php echo app('translator')->get('Batal'); ?></button>
            <button type="button" onClick="captialBack($(this))" class="confir-btn" id="captialBackButton" ><span id="confirmButon"><?php echo app('translator')->get('Konfirmasi'); ?></span></button>
        </div>
        </div>
    </div>
</div>




<div class="modal fade" id="upgradeModal" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content main-modal">
        <h3 class="modal-heding"><?php echo app('translator')->get('Attention!'); ?></h3>
        <p class="model-text">Pilih perangkat yang ingin di upgrade</p>

        <div class="table">
            <div class="details-data">

            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="cancel-btn" data-bs-dismiss="modal"><?php echo app('translator')->get('Batal'); ?></button>
            <button type="button" onclick="upform.submit();" class="confir-btn"><?php echo app('translator')->get('Konfirmasi'); ?></button>
        </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>



<?php $__env->startPush('scripts'); ?>
<script>
    function captialBack(elm){
        var invest_id = $("#invest_id").val();
        var price = $("#price").val();
        $.ajax({
            type : "POST",
            url  : "<?php echo e(route('user.capitalback')); ?>",
            data : {
                '_token' : "<?php echo e(csrf_token()); ?>",
                'invest_id' : invest_id,
                'price' : price,
            },
            beforeSend : function(res){
                var spinner = '<div class="spinner-border" role="status"><span class="sr-only"></span></div>';
                $("#confirmButon").html(spinner);
                $("#captialBackButton").attr('disabled',true);
            },
            success : function(res){
                var data = "<?php echo app('translator')->get('Konfirmasi'); ?>";
                $("#confirmButon").html(data);
                if(res.success == true){
                    $("#confirmModal").modal('hide');
                    window.location.href = '<?php echo e(route("user.home")); ?>';
                }
            },
            error   : function(res){
                $("#confirmButon").html(spinner);
            $("#captialBackButton").attr('disabled',false);
             $("#confirmModal").modal('hide');
            }
        });
    }
    $(document).ready(function(){
        $('.confirm-btn').on('click', function(){
            $('#price').val($(this).attr("data-val"));
            $('#invest_id').val($(this).attr("data-id"));
        });
    })

    $(document).ready(function(){
        $('.upgrade-btn').on('click', function(){
            var id = $(this).data('id');
            var url = $(this).data('url');
            $('#upgradeModal').modal('show');

            $.ajax({
              type: "POST",
              url: url,
              data: {
                "_token": "<?php echo e(csrf_token()); ?>",
                "id": id
              },
              success: function (data) {
                    $('.details-data').html(data);

                  }
          });

        });
    })
</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make($theme.'layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/perhiasanintan/public_html/resources/views/themes/intan/user/investments.blade.php ENDPATH**/ ?>