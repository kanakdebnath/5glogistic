
    <!--=============== NAVBAR ===============-->
    <nav class="menu">
        <input type="radio" name="menu" id="one" checked>
        <input type="radio" name="menu" id="two">
        <input type="radio" name="menu" id="three">
        <input type="radio" name="menu" id="four">
        <div class="list">
            <div class="link-wrap">
                <label for="one">
                <!-- <i class="material-icons">home</i> -->
                <a href="<?php echo e(route('home')); ?>"><img src="<?php echo e(asset('assets/frontend/intan/img/home.png')); ?>" alt="" /></a>
                <span>Awal</span>
            </label>
            <label for="two">
                <!-- <i class="material-icons">settings</i> -->
                <a href="https://play.google.com/store/apps/details?id=com.apps.perhiasanintan"><img src="<?php echo e(asset('assets/frontend/intan/img/play-store.png')); ?>" alt=""></a>
                <span>Aplikasi</span>
            </label>
                <label for="three">
                <!-- <i class="material-icons">cloud_upload</i> -->
                <a href="<?php echo e(route('user.referral')); ?>"><img src="<?php echo e(asset('assets/frontend/intan/img/add-user.png')); ?>" alt=""></a>
                <span>Referral</span>
            </label>
                <label for="four">
                <!-- <i class="material-icons">settings</i> -->
                <a href="<?php echo e(route('user.home')); ?>"><img src="<?php echo e(asset('assets/frontend/intan/img/dashboard.png')); ?>" alt=""></a>
                <span>Dashboard</span>
            </label>
            </div>
        </div>
    </nav><?php /**PATH C:\xampp\htdocs\intan\resources\views/themes/intan/partials/footer.blade.php ENDPATH**/ ?>