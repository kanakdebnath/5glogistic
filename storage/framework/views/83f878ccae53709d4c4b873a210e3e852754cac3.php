<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php echo $__env->make('partials.seo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->yieldPushContent('css-lib'); ?>

    <!-- BEGIN: COSTOM CSS LINK -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- END: COSTOM CSS LINK -->

    <!-- ================ FONTAWESOME CDN START HERE ==================== -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer"
    />
    <!-- ================ FONTAWESOME CDN END HERE ==================== -->

     <!-- ==================== JQUERY CDN START HERE ======================= -->
     <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
     <!-- ==================== JQUERY CDN END HERE ======================= -->


    <!-- =========== BEGIN: CUSTOM LINKS START HERE =========== -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/frontend/intan/css/navbar.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/frontend/intan/vendor/f3oall-awesome-notifications/style.css')); ?>">
    <!-- =========== END: CUSTOM LINKS END HERE =========== -->
    <?php echo $__env->yieldPushContent('style'); ?>

    <title><?php echo $__env->yieldContent('title'); ?></title>
</head>

<body>

    <?php echo $__env->yieldContent('content'); ?>


    <!--=============== MAIN JS ===============-->



    <?php echo $__env->make('themes.intan.partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- BEGIN: BOOTSTARP JS LINK -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- END: BOOTSTARP JS LINK -->

    <script src="<?php echo e(asset('assets/frontend/intan/vendor/f3oall-awesome-notifications/index.var.js')); ?>"></script>

    <script>
        const options = {
            position: "top-right",
            durations: {
                success: 3000,
                warning: 3000,
                alert: 3000
            },
            labels: {
                success: "Success",
                warning: "Warning",
                alert: "Error"
            }
        };
    </script>
    <?php if(session()->has('success')): ?>
    <script>
        let notifier = new AWN(options);
        notifier.success("<?php echo app('translator')->get(session('success')); ?>");
    </script>
    <?php endif; ?>

    <?php if(session()->has('warning')): ?>
    <script>
        let notifier = new AWN(options);
        notifier.warning("<?php echo app('translator')->get(session('warning')); ?>");
    </script>
    <?php endif; ?>

    <?php if(session()->has('error')): ?>
    <script>
        let notifier = new AWN(options);
        notifier.alert("<?php echo app('translator')->get(session('error')); ?>");
    </script>
    <?php endif; ?>


    <?php echo $__env->yieldPushContent('scripts'); ?>

    
    <?php echo $__env->make('themes.intan.modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    
</body>

</html>






<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Launch demo modal
</button> -->
<?php /**PATH /home/perhiasanintan/public_html/resources/views/themes/intan/layouts/user.blade.php ENDPATH**/ ?>