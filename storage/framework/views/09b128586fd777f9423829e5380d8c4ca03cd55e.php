

<?php $__env->startPush('head'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/frontend/styles/main.css')); ?>" />
<style>

    
.detail-page img{
    width: 100%; 
    height: 390px; 
    overflow: hidden; 
    display: flex;
}

.detail-page img{
    display: block;
    width: 100%;
    height: 100%;
}


    .topleft {
      position: absolute;
      top: 25px;
      left: 16px;
      font-size: 18px;
    }
    
    .topleft a{
        width: 50px;
        height: 50px;
        background: white;
        border-radius: 50%;
    }
    
  .box-container {
        position: relative;
        z-index: 2;
        margin-top: -45px;
        border-radius: 19px 19px 0 0;
        overflow: hidden;
        background: -webkit-gradient(linear,left top,left bottom,from(#ffea38),to(#ffd01a));
        background: linear-gradient(180deg,#ffea38,#ffd01a);
        padding-top: 15px;
        padding-bottom: 35px;
    }
  
  </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="topleft">
    <a class="text-dark px-2 py-2" href="../index.html"
      ><i class="fa-solid fa-chevron-left"></i
    ></a>
  </div>


<section class="">
<div class="detail-page">
    <img src="<?php echo e(getFile(config('location.plan.path').$data->image) ? : 0); ?>" alt="">
</div>

</section>


<section class="box-container">

<div class="mb-4 px-1 pb-2">

<div class='px-2'>
    <p class="m-0"><?php echo e($data->name); ?></p>
    <h4 class=""> Price: <?php echo e($data->price); ?> </h4>
    
    <span class="my-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perferendis aliquid ut quibusdam molestiae, est expedita adipisci odit et nihil accusamus.</span>
  </div>
 
  <div class="d-flex justify-content-between fs-6 fw-medium mt-3 px-2">
    <p class="m-0">Product cycle</p>
    <h5 class="m-0"><?php echo e($data->repeatable); ?>Days</h5>
  </div>
  <div class="d-flex justify-content-between fs-6 fw-medium mt-3 px-2">
    <p class="m-0">Total income</p>
    <h5 class="m-0">
        <?php if($data->is_lifetime == 0): ?>
        <?php echo e(trans($basic->currency_symbol)); ?> <?php echo e(number_format($data->profit*$data->repeatable)); ?>

         <?php echo e(($data->profit_type == 1)); ?>

         <?php if($data->is_capital_back == 1): ?>

         <?php endif; ?>
         <?php else: ?>
         <?php echo app('translator')->get('Lifetime Earning'); ?>
         <?php endif; ?>
        </h5>
  </div>
  <div class="d-flex justify-content-between fs-6 fw-medium mt-3 px-2">
    <p class="m-0">Daily income</p>
    <h5 class="m-0">
        <?php if($data->profit_type == 1): ?>
                    <?php echo e(getAmount($data->profit)); ?><?php echo e('%'); ?>

                        <?php else: ?>
                        <?php echo e(trans($basic->currency_symbol)); ?> <?php echo e(number_format($data->profit)); ?>


                        <?php endif; ?>
    </h5>
  </div>
  <div class="d-flex justify-content-between fs-6 fw-medium mt-3 px-2">
    <p class="m-0">Invest limit</p>
    <h5 class="m-0"><?php echo e($data->max_per_user); ?></h5>
  </div>
</div>

<section class=" pb-4 px-2">
<div class="d-grid gap-2 col-8 mx-auto">
  <button class="btn  btn-lg " style="background: #ff3600;color: #fff" type="button">Recharge</button>
</div>
</section>

<h4 class="text-center" >
  <a style="text-decoration: none; color: black" href="#">Recharge balance ></a>
</h4>
</section>

<?php $__env->stopSection(); ?>



<?php echo $__env->make($theme.'layouts.5glogistic', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\intan\resources\views/themes/5glogistic/plan-details.blade.php ENDPATH**/ ?>