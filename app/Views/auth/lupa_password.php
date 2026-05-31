<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Lupa Password - Sistem Klinik</title>
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
        body.blank-page {
            overflow-y: auto !important;
            height: auto !important;
        }
        .flexbox-container {
            min-height: 100vh;
            height: auto !important;
            padding: 2rem 0;
        }
    </style>
</head>
<body class="vertical-layout vertical-menu 1-column bg-custom-image blank-page">
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">
                <section class="flexbox-container">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="col-md-5 col-11 box-shadow-2 p-0 my-3">
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
                                        <span>Atur Ulang Password</span>
                                    </h6>
                                </div>
                                <div class="card-content">
                                    <?php if(session()->getFlashdata('error')): ?>
                                    <div class="alert alert-danger mx-2">
                                        <?= session()->getFlashdata('error') ?>
                                    </div>
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <form class="form-horizontal" action="<?= base_url('lupa_password') ?>" method="POST">
                                            <?= csrf_field() ?>
                                            
                                            <div class="card border-info mb-3 bg-light" style="border: 1px solid #0284c7; border-radius: 8px; background-color: #f0f9ff !important;">
                                                <div class="card-body p-2">
                                                    <h6 class="text-info font-weight-bold mb-2"><i class="ft-shield"></i> Verifikasi Identitas Pasien</h6>
                                                    
                                                    <fieldset class="form-group position-relative has-icon-left">
                                                        <input type="text" class="form-control" name="username" placeholder="Username Anda" required>
                                                        <div class="form-control-position">
                                                            <i class="ft-user"></i>
                                                        </div>
                                                    </fieldset>

                                                    <fieldset class="form-group position-relative has-icon-left">
                                                        <input type="text" class="form-control" name="no_telp" placeholder="No. Telepon Terdaftar" required>
                                                        <div class="form-control-position">
                                                            <i class="la la-phone"></i>
                                                        </div>
                                                    </fieldset>

                                                    <fieldset class="form-group position-relative has-icon-left mb-0">
                                                        <input type="date" class="form-control" name="tgl_lahir" placeholder="Tanggal Lahir" required>
                                                        <div class="form-control-position">
                                                            <i class="la la-calendar"></i>
                                                        </div>
                                                        <small class="text-muted ml-1">Silakan masukkan Tanggal Lahir Anda</small>
                                                    </fieldset>
                                                </div>
                                            </div>

                                            <div class="card border-warning mb-3 bg-light" style="border: 1px solid #d97706; border-radius: 8px; background-color: #fffbeb !important;">
                                                <div class="card-body p-2">
                                                    <h6 class="text-warning font-weight-bold mb-2"><i class="ft-lock"></i> Kredensial Baru</h6>
                                                    
                                                    <fieldset class="form-group position-relative has-icon-left">
                                                        <input type="password" id="password" class="form-control" name="password" placeholder="Password Baru" required minlength="6" pattern="(?=.*\d)(?=.*[^a-zA-Z0-9]).{6,}" title="Minimal 6 karakter, mengandung angka, dan simbol" style="padding-right: 40px;">
                                                        <div class="form-control-position">
                                                            <i class="la la-key"></i>
                                                        </div>
                                                        <div class="position-absolute text-muted" style="top: 10px; right: 15px; cursor: pointer; z-index: 10;" onclick="const pf = document.getElementById('password'); const icon = this.querySelector('i'); if(pf.type === 'password') { pf.type = 'text'; icon.className = 'la la-eye-slash'; } else { pf.type = 'password'; icon.className = 'la la-eye'; }">
                                                            <i class="la la-eye"></i>
                                                        </div>
                                                    </fieldset>

                                                    <fieldset class="form-group position-relative has-icon-left mb-1">
                                                        <input type="password" id="confirm_password" class="form-control" name="confirm_password" placeholder="Konfirmasi Password Baru" required minlength="6" pattern="(?=.*\d)(?=.*[^a-zA-Z0-9]).{6,}" style="padding-right: 40px;">
                                                        <div class="form-control-position">
                                                            <i class="la la-key"></i>
                                                        </div>
                                                        <div class="position-absolute text-muted" style="top: 10px; right: 15px; cursor: pointer; z-index: 10;" onclick="const pf = document.getElementById('confirm_password'); const icon = this.querySelector('i'); if(pf.type === 'password') { pf.type = 'text'; icon.className = 'la la-eye-slash'; } else { pf.type = 'password'; icon.className = 'la la-eye'; }">
                                                            <i class="la la-eye"></i>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>

                                            <button type="submit" class="btn btn-outline-info btn-block"><i class="ft-check"></i> Simpan Password Baru</button>
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
