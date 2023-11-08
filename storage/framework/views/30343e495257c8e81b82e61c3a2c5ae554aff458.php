<?php $__env->startSection('title',trans('Investments').': '.$user->username ); ?>
<?php $__env->startSection('content'); ?>
    <script>
        "use strict"
        function getCountDown(elementId, seconds) {
            var times = seconds;
            var x = setInterval(function () {
                var distance = times * 1000;
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                document.getElementById(elementId).innerHTML = days + "d: " + hours + "h " + minutes + "m " + seconds + "s ";
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById(elementId).innerHTML = "COMPLETE";
                }
                times--;
            }, 1000);
        }
    </script>



    <div class="page-header card card-primary m-0 m-md-4 my-4 m-md-0 p-5 shadow">
        <div class="row justify-content-between">
            <div class="col-md-12">
                <form action="<?php echo e(route('admin.investments.search')); ?>" method="get">
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" name="user_name" value="<?php echo e(@request()->user_name); ?>" class="form-control get-username"
                                       placeholder="<?php echo app('translator')->get('Username'); ?>">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="date" class="form-control" name="datetrx" id="datepicker"/>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <button type="submit" class="btn btn-block btn-primary"><i class="fas fa-search"></i> <?php echo app('translator')->get('Search'); ?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>





    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            <table class="categories-show-table table table-hover table-striped table-bordered">
                <thead class="thead-dark">
                <tr>
                    <th><?php echo app('translator')->get('SL'); ?></th>
                    <th><?php echo app('translator')->get('Username'); ?></th>
                    <th><?php echo app('translator')->get('Plan'); ?></th>
                    <th ><?php echo app('translator')->get('Return Interest'); ?></th>
                    <th><?php echo app('translator')->get('Received Amount'); ?></th>
                    <th><?php echo app('translator')->get('Upcoming Payment'); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $investments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $invest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td data-label="<?php echo app('translator')->get('SL'); ?>">
                            <?php echo e(loopIndex($investments) + $key); ?>

                        </td>

                        <td data-label="<?php echo app('translator')->get('Username'); ?>">
                            <a href="<?php echo e(route('admin.user-edit',$invest->user_id)); ?>" target="_blank">
                                <?php echo app('translator')->get(optional($invest->user)->username); ?>
                            </a>
                        </td>
                        <td data-label="<?php echo app('translator')->get('Plan'); ?>">
                            <?php echo e(trans(optional($invest->plan)->name)); ?>

                            <br> <?php echo e(getAmount($invest->amount).' '.trans($basic->currency)); ?>

                        </td>

                        <td data-label="<?php echo app('translator')->get('Return Interest'); ?>" class="text-capitalize">
                            <?php echo e(getAmount($invest->profit)); ?> <?php echo e(trans($basic->currency)); ?>

                            <?php echo e(($invest->period == '-1') ? trans('For Lifetime') : 'per '. trans($invest->point_in_text)); ?>


                            <br>
                            <?php echo e(($invest->capital_status == '1') ? '+ '.trans('Capital') :''); ?>

                        </td>
                        <td data-label="<?php echo app('translator')->get('Received Amount'); ?>">
                            <?php echo e($invest->recurring_time); ?> x <?php echo e($invest->profit); ?> =  <?php echo e(getAmount($invest->recurring_time*$invest->profit)); ?> <?php echo e(trans($basic->currency)); ?>

                        </td>

                        <td data-label="<?php echo app('translator')->get('Upcoming Payment'); ?>">
                            <?php if($invest->status == 1): ?>
                                <p id="counter<?php echo e($invest->id); ?>" class="mb-2"></p>
                                <script>getCountDown("counter<?php echo e($invest->id); ?>", <?php echo e(\Carbon\Carbon::parse($invest->afterward)->diffInSeconds()); ?>);</script>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped bg-danger" role="progressbar"  style="width: <?php echo e($invest->nextPayment); ?>"  aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?php echo e($invest->nextPayment); ?></div>
                                </div>
                            <?php else: ?>
                                <span class="badge badge-success"><?php echo app('translator')->get('Completed'); ?></span>
                            <?php endif; ?>

                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td class="text-center text-danger" colspan="8"><?php echo app('translator')->get('No Data Found'); ?></td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
            <?php echo e($investments->links('partials.pagination')); ?>

        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/perhiasanintan/public_html/resources/views/admin/users/investments.blade.php ENDPATH**/ ?>