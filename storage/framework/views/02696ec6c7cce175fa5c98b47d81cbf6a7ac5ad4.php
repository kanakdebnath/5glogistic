<form id="upform" style="margin-bottom: 0px; margin-top: 0px; padding-top: 0px; background:none; box-shadow:none;" action="<?php echo e(route('user.upgrade-plan-store')); ?>"  autocomplete="off" method="post">
    <?php echo csrf_field(); ?>
    <input type="hidden" value="<?php echo e($invest->id); ?>" id="invest_id" name="invest_id" >
    <input type="hidden" value="<?php echo e($invest->amount); ?>" id="invest_amount" name="invest_amount" >
   
        <div class="form-group col-md-10">
            <label>Tingkatkan Perangkat</label>
            <select name="plan_id" id="plan_id" required class="form-control">
                <option selected disabled value="">Pilih perangkat</option>
                <?php $__currentLoopData = $managePlans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($item->id); ?>" <?php if($plan->fixed_amount >= $item->fixed_amount): ?> disabled <?php endif; ?>><?php echo e($item->name); ?><small> (<?php echo e($item->fixed_amount); ?>)</small></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
</form><?php /**PATH /home/perhiasanintan/public_html/resources/views/themes/intan/user/upgradeplan.blade.php ENDPATH**/ ?>