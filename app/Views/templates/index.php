<!DOCTYPE html>
<html class="loading" lang="id" data-textdirection="ltr">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="Sistem Informasi Klinik - Manajemen pasien, dokter, rekam medis, dan resep obat.">
  <title>Sistem Informasi Klinik</title>
  <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('app-assets/images/ico/favicon.ico') ?>">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Quicksand:300,400,500,700" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/css/vendors.css') ?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/css/app.css') ?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/css/core/menu/menu-types/vertical-menu.css') ?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/css/core/colors/palette-gradient.css') ?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/css/pages/hospital.css') ?>">
  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body class="vertical-layout vertical-menu 2-columns menu-expanded fixed-navbar"
      data-open="click" data-menu="vertical-menu" data-col="2-columns">

<!-- ════════════ NAVBAR ════════════ -->
<nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-light bg-info navbar-shadow">
  <div class="navbar-wrapper">
    <div class="navbar-header">
      <ul class="nav navbar-nav flex-row">
        <li class="nav-item mobile-menu d-md-none mr-auto">
          <a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a>
        </li>
        <li class="nav-item">
          <a class="navbar-brand" href="<?= base_url('dashboard') ?>">
            <img class="brand-logo" alt="logo klinik" src="<?= base_url('app-assets/images/logo/logo.png') ?>">
            <h3 class="brand-text">Klinik Polma</h3>
          </a>
        </li>
        <li class="nav-item d-md-none">
          <a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile">
            <i class="la la-ellipsis-v"></i>
          </a>
        </li>
      </ul>
    </div>
    <div class="navbar-container content">
      <div class="collapse navbar-collapse" id="navbar-mobile">
        <ul class="nav navbar-nav mr-auto float-left">
          <li class="nav-item d-none d-md-block">
            <a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu"></i></a>
          </li>
        </ul>
        <ul class="nav navbar-nav float-right">
          <li class="dropdown dropdown-user nav-item">
            <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
              <span class="mr-1">Halo, <span class="user-name text-bold-700"><?= esc(session()->get('username') ?? 'Pengguna') ?></span></span>
              <span class="avatar avatar-online">
                <img src="<?= base_url('app-assets/images/portrait/small/avatar-s-19.png') ?>" alt="avatar"><i></i>
              </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="<?= base_url('logout') ?>"><i class="ft-power"></i> Logout</a>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>

<!-- ════════════ SIDEBAR ════════════ -->
<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
  <div class="main-menu-content">
    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

      <li class="nav-item <?= (uri_string() === 'dashboard') ? 'active' : '' ?>">
        <a href="<?= base_url('dashboard') ?>">
          <i class="la la-home"></i>
          <span class="menu-title">Dashboard</span>
        </a>
      </li>

      <li class="navigation-header">
        <span>Manajemen Klinik</span>
        <i class="la la-ellipsis-h ft-minus"></i>
      </li>

      <li class="nav-item <?= (strpos(uri_string(), 'pasien') === 0) ? 'active' : '' ?>">
        <a href="<?= base_url('pasien') ?>">
          <i class="la la-users"></i>
          <span class="menu-title">Data Pasien</span>
        </a>
      </li>

      <li class="nav-item <?= (strpos(uri_string(), 'dokter') === 0) ? 'active' : '' ?>">
        <a href="<?= base_url('dokter') ?>">
          <i class="la la-user-md"></i>
          <span class="menu-title">Data Dokter</span>
        </a>
      </li>

      <li class="nav-item <?= (strpos(uri_string(), 'rekam_medis') === 0) ? 'active' : '' ?>">
        <a href="<?= base_url('rekam_medis') ?>">
          <i class="la la-stethoscope"></i>
          <span class="menu-title">Rekam Medis</span>
        </a>
      </li>

      <li class="nav-item <?= (strpos(uri_string(), 'resep') === 0) ? 'active' : '' ?>">
        <a href="<?= base_url('resep') ?>">
          <i class="la la-clipboard"></i>
          <span class="menu-title">Resep</span>
        </a>
      </li>

      <li class="nav-item <?= (strpos(uri_string(), 'obat') === 0) ? 'active' : '' ?>">
        <a href="<?= base_url('obat') ?>">
          <i class="la la-medkit"></i>
          <span class="menu-title">Data Obat</span>
        </a>
      </li>

      <li class="navigation-header">
        <span>Akun</span>
        <i class="la la-ellipsis-h ft-minus"></i>
      </li>

      <li class="nav-item">
        <a href="<?= base_url('logout') ?>">
          <i class="la la-sign-out"></i>
          <span class="menu-title">Logout</span>
        </a>
      </li>

    </ul>
  </div>
</div>

<!-- ════════════ CONTENT ════════════ -->
<div class="app-content content">
  <div class="content-wrapper">

    <!-- Flash message -->
    <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show mx-2 mt-2" role="alert">
      <i class="la la-check-circle"></i> <?= session()->getFlashdata('success') ?>
      <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show mx-2 mt-2" role="alert">
      <i class="la la-exclamation-circle"></i> <?= session()->getFlashdata('error') ?>
      <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
    <?php endif; ?>

    <?= $this->rendersection('konten') ?>

  </div>
</div>

<!-- ════════════ FOOTER ════════════ -->
<footer class="footer footer-static footer-light navbar-border navbar-shadow">
  <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2">
    <span class="float-md-left d-block d-md-inline-block">
      &copy; <?= date('Y') ?> <strong>Sistem Informasi Klinik</strong> &mdash; Hak Cipta Dilindungi.
    </span>
  </p>
</footer>

<!-- Scripts -->
<script src="<?= base_url('app-assets/vendors/js/vendors.min.js') ?>"></script>
<script src="<?= base_url('app-assets/vendors/js/charts/chart.min.js') ?>"></script>
<script src="<?= base_url('app-assets/js/core/app-menu.js') ?>"></script>
<script src="<?= base_url('app-assets/js/core/app.js') ?>"></script>
<?= $this->renderSection('scripts') ?>
</body>
</html>
