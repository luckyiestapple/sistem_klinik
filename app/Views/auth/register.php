<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Daftar Pasien - Sistem Klinik</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700%7CQuicksand:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/css/vendors.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/css/bootstrap-extended.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/css/colors.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/css/components.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/css/pages/login-register.css') ?>">
    <style>
        .bg-custom-image {
            background-image: url('<?= base_url('app-assets/images/backgrounds/bg-2.jpg') ?>');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
    </style>
</head>
<body class="vertical-layout vertical-menu 1-column bg-custom-image blank-page">
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">
                <section class="flexbox-container">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="col-md-6 col-10 box-shadow-2 p-0 my-3">
                            <div class="card border-grey border-lighten-3 px-1 py-1 m-0">
                                <div class="card-header border-0 pb-0">
                                    <div class="text-left mb-1">
                                        <a href="<?= base_url('login') ?>" class="btn btn-sm btn-warning font-weight-bold" style="border-radius:20px; color:#fff !important;">
                                            <i class="ft-arrow-left"></i> Kembali ke Login
                                        </a>
                                    </div>
                                    <div class="card-title text-center">
                                        <h3 class="mt-1 font-weight-bold text-info">Sistem Klinik Terpadu</h3>
                                    </div>
                                    <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
                                        <span>Daftar Pasien Baru</span>
                                    </h6>
                                </div>
                                <div class="card-content">
                                    <?php if(session()->getFlashdata('error')): ?>
                                    <div class="alert alert-danger mx-2">
                                        <?= session()->getFlashdata('error') ?>
                                    </div>
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <form class="form-horizontal" action="<?= base_url('register') ?>" method="POST" novalidate>
                                            <?= csrf_field() ?>
                                            
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <fieldset class="form-group position-relative has-icon-left">
                                                        <input type="text" class="form-control" name="nama" placeholder="Nama Lengkap" required>
                                                        <div class="form-control-position">
                                                            <i class="ft-user"></i>
                                                        </div>
                                                    </fieldset>
                                                    <fieldset class="form-group position-relative">
                                                        <select class="form-control" name="jk" required>
                                                            <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                                            <option value="Laki-laki">Laki-laki</option>
                                                            <option value="Perempuan">Perempuan</option>
                                                        </select>
                                                    </fieldset>
                                                    <fieldset class="form-group position-relative has-icon-left">
                                                        <input type="date" class="form-control" name="tgl_lahir" placeholder="Tanggal Lahir" required>
                                                        <div class="form-control-position">
                                                            <i class="la la-calendar"></i>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-6">
                                                    <fieldset class="form-group position-relative has-icon-left">
                                                        <input type="text" class="form-control" name="no_telp" placeholder="No. Telepon" required>
                                                        <div class="form-control-position">
                                                            <i class="la la-phone"></i>
                                                        </div>
                                                    </fieldset>
                                                    <fieldset class="form-group position-relative has-icon-left">
                                                        <input type="text" class="form-control" name="username" placeholder="Username" required>
                                                        <div class="form-control-position">
                                                            <i class="ft-user-check"></i>
                                                        </div>
                                                    </fieldset>
                                                    <fieldset class="form-group position-relative has-icon-left">
                                                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                                                        <div class="form-control-position">
                                                            <i class="la la-key"></i>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>

                                            <fieldset class="form-group position-relative has-icon-left">
                                                <textarea class="form-control" name="alamat" placeholder="Alamat Lengkap" rows="3" required></textarea>
                                                <div class="form-control-position">
                                                    <i class="la la-map-marker"></i>
                                                </div>
                                            </fieldset>
                                            
                                            <button type="submit" class="btn btn-outline-info btn-block"><i class="ft-user-plus"></i> Daftar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    
    <script src="<?= base_url('app-assets/vendors/js/vendors.min.js') ?>"></script>
    <script src="<?= base_url('app-assets/js/core/app.js') ?>"></script>
</body>
</html>
