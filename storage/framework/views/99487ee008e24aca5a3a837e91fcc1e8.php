<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="utf-8">
    <title>Oktatói</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <link href="<?php echo e(asset('img/favicon.ico')); ?>" rel="icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link href="<?php echo e(asset('lib/animate/animate.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('lib/owlcarousel/assets/owl.carousel.min.css')); ?>" rel="stylesheet">

    <link href="<?php echo e(asset('css/bootstrap.min.css')); ?>" rel="stylesheet">

    <link href="<?php echo e(asset('css/style.css')); ?>" rel="stylesheet">
</head>

<body>
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="index.html" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <img style="height: 50px" src="img/Új projekt.png" alt="">
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="welcome" class="nav-item nav-link active">Főoldal</a>
                <a href="rolunk" class="nav-item nav-link">Rólunk</a>
                <a href="kurzusok" class="nav-item nav-link">Kurzusok</a>
                <a href="oktatok" class="nav-item nav-link">Oktatók</a>
                <a href="kapcsolat" class="nav-item nav-link">Kapcsolat</a>
            </div>
            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-danger">Kijelentkezés</button>
            </form>
        </div>
    </nav>

    <div class="container-fluid bg-primary py-5 mb-5 page-header">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown"></h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <div class="profile-container">
                                <?php if(isset($oktato)): ?>
                                    <div class="profile-name">Üdv újra, <?php echo e($oktato->nev); ?>!</div>
                                <?php else: ?>
                                    <div class="profile-name">Üdv újra, <?php echo e(Auth::guard('oktato')->user()->nev ?? 'Vendég'); ?>!</div>
                                <?php endif; ?>
                            </div>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <di class="user-info-container row">
        <div class="user-details col-md">
        <?php
            $oktato = Auth::guard('oktato')->user();
        ?>
        <?php if(isset($oktato)): ?>
            <h2>Felhasználó adatai</h2>
            <p><strong>Név:</strong> <?php echo e($oktato->nev); ?></p>
            <p><strong>Felhasználónév:</strong> <?php echo e($oktato->felhasznalonev); ?></p>
            <p><strong>Email:</strong> <?php echo e($oktato->email); ?></p>
        <?php else: ?>
            <p class="text-center text-danger">Nincs bejelentkezett oktató!</p>
        <?php endif; ?>
        <p><strong>Tanulók listája: </strong></p>
        <div class="diaklista">
        <?php if(isset($diakok) && $diakok->isNotEmpty()): ?>
            <?php $__currentLoopData = $diakok; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $diak): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="filterDiv">
                    <?php echo e($diak->tanulo_nev); ?> - <?php echo e($diak->kurzus_nev); ?> 
                    (Fizetett: <?php echo e($diak->fizetve); ?>)
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <p>Nincs elérhető diák.</p>
        <?php endif; ?>
        </div>
        </div>
        <div class="courses col-md">
        <div class="container">
        <h3>Kurzus létrehozása</h3>
         
        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>
        <form action="<?php echo e(route('kurzus.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div>
                <label>Kurzus neve:</label>
                <input type="text" name="kurzus_nev" required>
            </div>
            <div>
                <label>Helyszín:</label>
                <input type="text" name="helyszin" required>
                <small>Írj "online"-t, ha online képzés!</small>
            </div>
            <div>
                <label>Időpont:</label>
                <input type="datetime-local" name="kepzes_ideje" required>
            </div>
            <div>
                <label>Ár:</label>
                <input type="number" name="dij">
            </div>

            <button type="submit">Létrehozás</button>
        </form>
        </div>
    </div>
        <div class="courses col-md kurzuslista">
            <h3>Kurzusok listája: </h3>
            <ul>
            <?php if(isset($kurzusok) && $kurzusok->isNotEmpty()): ?>
                <?php $__currentLoopData = $kurzusok; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kurzus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($kurzus->kurzus_nev); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <?php endif; ?>
        </div>
    </div>

    <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Gyors linkek</h4>
                    <a class="btn btn-link" href="rolunk">Rólunk</a>
                    <a class="btn btn-link" href="kapcsolat">Kapcsolatfelvétel</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Elérhetőségeink</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>4700, Mátészalka Kölcsey Út 12</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+36 06 12 345 678 9</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@acadelle.com</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social" href="https://www.facebook.com/?locale=hu_HU"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social" href="https://www.youtube.com"><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-outline-light btn-social" href="https://hu.linkedin.com"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Hírlevelünk</h4>
                    <p>Értesítést küldünk minden fontos információról és érdekes újdonságokról</p>
                    <div class="position-relative mx-auto" style="max-width: 400px;">
                        <input class="form-control border-0 w-100 py-3 ps-4 pe-5" type="text" placeholder="email">
                        <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">Feliratkozás</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <script src="js/main.js"></script>
    <script src="js/sajat.js"></script>
</body>

</html><?php /**PATH M:\xampp\htdocs\Acadelle-main\resources\views/oktatoi/oktatoi.blade.php ENDPATH**/ ?>