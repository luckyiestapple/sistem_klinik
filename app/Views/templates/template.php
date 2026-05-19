<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title><?= $title ?? 'Sistem Klinik' ?></title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700%7CQuicksand:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/css/vendors.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/css/bootstrap-extended.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/css/colors.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/css/components.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/css/core/menu/menu-types/vertical-menu.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/style.css') ?>">
    <?= $this->renderSection('css') ?>
</head>
<body class="vertical-layout vertical-menu 2-columns" data-open="click" data-menu="vertical-menu" data-col="2-columns">
    <!-- Navbar -->
    <nav class="header-navbar navbar-expand-md navbar navbar-with-menu fixed-top navbar-light navbar-border">
        <div class="navbar-wrapper">
            <div class="navbar-header">
                <ul class="nav navbar-nav flex-row">
                    <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
                    <li class="nav-item">
                        <a class="navbar-brand" href="<?= base_url('dashboard') ?>">
                            <h4 class="brand-text">Sistem Klinik</h4>
                        </a>
                    </li>
                    <li class="nav-item d-md-none"><a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="la la-ellipsis-v"></i></a></li>
                </ul>
            </div>
            <div class="navbar-container content">
                <div class="collapse navbar-collapse" id="navbar-mobile">
                    <ul class="nav navbar-nav mr-auto float-left">
                        <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu"></i></a></li>
                        <li class="nav-item d-none d-md-block"><a class="nav-link nav-link-expand" href="#"><i class="ficon ft-maximize"></i></a></li>
                    </ul>
                    <ul class="nav navbar-nav float-right">
                        <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                            <i class="ft-user"></i> <?= session()->get('username') ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="<?= base_url('logout') ?>">
                                <i class="ft-power"></i> Logout
                            </a>
                        </div>
                    </li>
                </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- Sidebar -->
    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow">
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation">
                <?php if (session()->get('id_level') == 2): // Menu Khusus Pasien ?>
                <li class="nav-item <?= (current_url() == base_url('dashboard_pasien')) ? 'active' : '' ?>">
                    <a href="<?= base_url('dashboard_pasien') ?>">
                        <i class="ft-home"></i><span class="menu-title">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item <?= (current_url() == base_url('profil_pasien')) ? 'active' : '' ?>">
                    <a href="<?= base_url('profil_pasien') ?>">
                        <i class="ft-user"></i><span class="menu-title">Profil Saya</span>
                    </a>
                </li>
                <li class="nav-item <?= (current_url() == base_url('antrian')) ? 'active' : '' ?>">
                    <a href="<?= base_url('antrian') ?>">
                        <i class="ft-calendar"></i><span class="menu-title">Ambil Antrian</span>
                    </a>
                </li>
                <li class="nav-item <?= (current_url() == base_url('resep_pasien')) ? 'active' : '' ?>">
                    <a href="<?= base_url('resep_pasien') ?>">
                        <i class="ft-clipboard"></i><span class="menu-title">Resep Saya</span>
                    </a>
                </li>
                <li class="nav-item <?= (current_url() == base_url('rekam_medis_pasien')) ? 'active' : '' ?>">
                    <a href="<?= base_url('rekam_medis_pasien') ?>">
                        <i class="ft-activity"></i><span class="menu-title">Rekam Medis</span>
                    </a>
                </li>
                <?php else: // Menu Admin / Dokter / Pegawai ?>
                <li class="nav-item <?= (current_url() == base_url('dashboard')) ? 'active' : '' ?>">
                    <a href="<?= base_url('dashboard') ?>">
                        <i class="ft-home"></i><span class="menu-title">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item <?= (current_url() == base_url('pasien')) ? 'active' : '' ?>">
                    <a href="<?= base_url('pasien') ?>">
                        <i class="ft-users"></i><span class="menu-title">Data Pasien</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('dokter') ?>">
                        <i class="ft-user"></i><span class="menu-title">Data Dokter</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('rekam_medis') ?>">
                        <i class="ft-file-text"></i><span class="menu-title">Rekam Medis</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('resep') ?>">
                        <i class="ft-clipboard"></i><span class="menu-title">Resep</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('obat') ?>">
                        <i class="ft-package"></i><span class="menu-title">Data Obat</span>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    <!-- Main Content -->
    <div class="app-content content">
        <div class="content-wrapper">
            <?= $this->renderSection('konten') ?>
        </div>
    </div>
    <script src="<?= base_url('app-assets/vendors/js/vendors.min.js') ?>"></script>
    <script src="<?= base_url('app-assets/js/core/app-menu.js') ?>"></script>
    <script src="<?= base_url('app-assets/js/core/app.js') ?>"></script>
    <?= $this->renderSection('script') ?>
</body>
</html>