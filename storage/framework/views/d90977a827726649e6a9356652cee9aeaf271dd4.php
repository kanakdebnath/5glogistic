<?php $__env->startSection('title', trans('Home')); ?>

<?php $__env->startSection('content'); ?>

    <!-- BEGIN: JEWLERY HEADER SECTION -->
    <header class="jewlery-header">
        <div class="container-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <br>
                        <br>
                        <br>
                        <h1><?php echo app('translator')->get('Investasi Perhiasan Pertama di Indonesia'); ?></h1>
                        <br>
                        <p><?php echo app('translator')->get('Resmi legalitas & Diawasi oleh lembaga keuangan yang berlaku'); ?></p>
                        <h1><?php echo app('translator')->get('Lisensi dan Sertifikasi :'); ?></h1>


                        <center>
                       <img src="<?php echo e(asset('assets/frontend/images/SSL secure.png')); ?>" style="height: 30px;"  />
                       <img src="<?php echo e(asset('assets/frontend/images/guaranteed-safe-checkout-5.png')); ?>" style="width: 60px;"style="height: 30px;"  />
                       <img src="<?php echo e(asset('assets/frontend/images/Trustlock.png')); ?>" style="height: 20px;" style="width: 50px;"  />
                       <img src="<?php echo e(asset('assets/frontend/images/Logo DJP.png')); ?>" style="height: 30px;"  />
                       <img src="<?php echo e(asset('assets/frontend/intan/img/ojk.png')); ?>" style="height: 20px;"  /> </center>

                        <center>
                             <img src="<?php echo e(getFile(config('location.logoIcon.path').'logo.png')); ?>" style="height: 90px;" />
                          </center>


                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- END: JEWLERY HEADER SECTION -->

    <section class="installment-plan-section" id="Product-card" style="margin-bottom: 50px;">
        <div class="container-fluid">
            <div class="container">
                <!-- BEGIN: JEWLERY CARD SECTION -->
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h1><?php echo app('translator')->get('PILIHAN INVESTASI'); ?></h1>
                        <p><?php echo app('translator')->get('Klik tombol pembayaran untuk memulai'); ?></p>
                        <ul class="nav nav-pills mb-3" style="gap: 10px;" id="pills-tab" role="tablist">
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="nav-item ms-2" role="presentation">
                                <button class="nav-link <?php if($key == 0): ?> active <?php endif; ?>" id="pills-tab-<?php echo e($key); ?>" data-bs-toggle="pill" data-bs-target="#pills-<?php echo e($key); ?>" type="button" role="tab" aria-controls="pills-<?php echo e($key); ?>" aria-selected="false"><?php echo e($category->name); ?></button>
                            </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>


                        <p></p>
                        <div class="tab-content" id="pills-tabContent">
                            
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="tab-pane fade <?php if($key == 0): ?> show active <?php endif; ?>" id="pills-<?php echo e($key); ?>" role="tabpanel" aria-labelledby="pills-tab-<?php echo e($key); ?>">
                                <!-- BEGIN: SECOND TAB CARDS -->
                                <section class="jewlery-card-section">
                                    <div class="container">
                                        <div class="row">
                                            <?php if(0 < count($category->plans)): ?>
                                            <?php $__currentLoopData = $category->plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=> $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                            $getTime = \App\Models\ManageTime::where('time', $data->schedule)->first();
                                            ?>
                                            <div class="col-md-4 col-sm-6 col-12 p-0">
                                                <div class="ribbon-1">
                                                    <h6>Batas Pembelian</h6>
                                                    <p></p>
                                                    <p><?php echo e($data->max_per_user); ?> x</p>

                                                </div>
                                                <img src="<?php echo e(getFile(config('location.plan.path').$data->image) ? : 0); ?>" alt="">
                                                <h4><?php echo e($data->name); ?></h4>
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <th>Harga :</th>
                                                        <td><?php echo e($data->price); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Durasi :</th>
                                                        <td><?php echo e($data->repeatable); ?> <?php echo app('translator')->get('Days'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Keuntungan</th>
                                                        <td><?php if($data->profit_type == 1): ?>
                                                        <td><?php echo e(getAmount($data->profit)); ?><?php echo e('%'); ?>

                                                         <?php else: ?>
                                                         <?php echo e(trans($basic->currency_symbol)); ?> <?php echo e(number_format($data->profit)); ?>


                                                         <?php endif; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total Penghasilan :</th>
                                                        <td><?php if($data->is_lifetime == 0): ?>
                                                           <?php echo e(trans($basic->currency_symbol)); ?> <?php echo e(number_format($data->profit*$data->repeatable)); ?>

                                                            <?php echo e(($data->profit_type == 1)); ?>

                                                            <?php if($data->is_capital_back == 1): ?>

                                                            <?php endif; ?>
                                                            <?php else: ?>
                                                            <?php echo app('translator')->get('Lifetime Earning'); ?>
                                                            <?php endif; ?></td>
                                                    </tr>
                                                </table>
                                                
                                                <form action="<?php echo e(route('user.toppay.checkout')); ?>" onsubmit="return formSubmit('#submit-<?php echo e($data->id); ?>');" method="post">
                                                    <?php echo csrf_field(); ?>
                                                    <input type="hidden" name="plan_id" value="<?php echo e($data->id); ?>">
                                                    <input type="hidden" name="amount" value="<?php echo e($data->fixed_amount); ?>">
                                                    <input type="hidden" name="balance_type" value="checkout">
                                                    
                                                    <button type="submit" id="submit-<?php echo e($data->id); ?>" class="btn"><?php echo app('translator')->get('Pembayaran'); ?></button>
                                                </form>
                                                
                                                
                                            </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </section>
                                <!-- END: SECOND TAB CARDS -->
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                        </div>
                    </div>
                </div>
                <!-- END: JEWLERY CARD SECTION -->
            </div>
        </div>
    </section>
    <!-- Footer  -->
 

<div id="myModal" class="modal fade show active" role="dialog">
  <div class="modal-dialog" style="margin-top: 70px;">
    
    <!-- Modal content-->
    <div class="modal-content">
     
      <div class="modal-body" style="padding:0px;position:relative;">
           <a href="javascript:void(0)" id="modalCrossButton" data-bs-dismiss="modal"><i class="fa fa-times"></i></a>
        <a href><img src="https://perhiasanintan.com/assets/uploads/img.jpeg" alt="" style="width:100%;"></a>
      </div>
      <!--<div class="modal-footer" style="padding:0px;">-->
      <!--    <div class="cstm">-->
      <!--      <button type="button" id="modalCrossButton" class="btn btn-defualt" style="background: #bd9277; color: #ffffff;"  data-bs-dismiss="modal">Don't show again</button>-->
      <!--    </div>-->
      <!--</div>-->
    </div>

  </div>
</div>


    
    <script type="text/javascript">
            function formSubmit(id)
            {
                $(id).attr('disabled', true).html('Proses');
            }
            
            $(document).ready(function(){
                $(document).on('click','#modalCrossButton',function(){
                   $('#myModal').modal('hide');
                    $('#myModal').hide();
                    
                });
            });
            
            $(document).ready(function() {
              //  Check if modal was already shown today
              if (localStorage.getItem('lastShown') && (Date.now() - localStorage.getItem('lastShown')) < (0 * 0 * 60 * 1000)) {
              //   Modal was already shown within the last 24 hours, do not show it again
                return;
              }
              
             //  Show the modal if it hasn't been shown today
              $('#myModal').modal('show');
              
              // Store the current timestamp in local storage to mark it as shown
              localStorage.setItem('lastShown', Date.now());
            });

            
            
</script>
    
    
    
    
    <?php echo $__env->make('themes.intan.partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make($theme.'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/perhiasanintan/public_html/resources/views/themes/intan/home.blade.php ENDPATH**/ ?>