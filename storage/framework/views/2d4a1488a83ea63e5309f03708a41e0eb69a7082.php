<nav class="navbar-expand bg-light fixed-bottom ">
    <ul class="navbar-nav row m-0">

        <?php

        if (request()->is('/')) {
            $home = 'assets/frontend/images/icons/home.png';
        }else{
            $home = 'assets/frontend/images/icons/deactive-home.png';
        }
            
        ?>


        <li class="col p-0">
            <a class="nav-link d-flex flex-column align-items-center justify-content-center" href="<?php echo e(route('home')); ?>"><img style="width:20px;" src="<?php echo e(asset($home)); ?>" alt="" />
                <p class="<?php echo e((request()->is('/')) ? 'fw-bold' : ''); ?>">Home</p>
            </a>
        </li>
        <li class="col p-0">
            <a class="nav-link d-flex flex-column align-items-center justify-content-center" href="pages/my-invest.html"><img style="width:20px;" src="<?php echo e(asset('assets/frontend/images/icons/invest.png')); ?>" alt="" />
                <p>Invest</p>
            </a>
        </li>
        <li class="col p-0">
            <a class="nav-link d-flex flex-column align-items-center justify-content-center" href="<?php echo e(route('user.referral')); ?>"><img style="width:20px;" src="<?php echo e(asset('assets/frontend/images/icons/team.png')); ?>" alt="" />
                <p>Team</p>
            </a>
        </li>
        <?php

        if (request()->is('user/dashboard')) {
            $mine = 'assets/frontend/images/icons/active-mine.png';
        }else{
            $mine = 'assets/frontend/images/icons/mine.png';
        }
            
        ?>
        <li class="col p-0">
            <a class="nav-link d-flex flex-column align-items-center justify-content-center" href="<?php echo e(route('user.home')); ?>"><img style="width:20px;" src="<?php echo e(asset($mine)); ?>" alt="" />
                <p class="<?php echo e((request()->is('user/dashboard')) ? 'fw-bold' : ''); ?>">Mine</p>
            </a>
        </li>
    </ul>
</nav><?php /**PATH C:\xampp\htdocs\intan\resources\views/themes/5glogistic/inc/bottom-nav.blade.php ENDPATH**/ ?>