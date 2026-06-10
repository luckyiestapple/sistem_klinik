<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Login - Sistem Klinik</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700%7CQuicksand:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/css/vendors.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/forms/icheck/icheck.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/vendors/css/forms/icheck/custom.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/css/bootstrap-extended.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/css/colors.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/css/components.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/css/pages/login-register.css') ?>">
    <style>
        .bg-custom-blue {
            background: linear-gradient(-45deg, #4A00E0, #8E2DE2, #00C9FF, #92FE9D);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .aesthetic-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
        
        .btn-primary-blue {
            background: linear-gradient(45deg, #4A00E0, #00C9FF);
            border: none;
            color: white !important;
            border-radius: 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary-blue:hover {
            box-shadow: 0 8px 20px rgba(74, 0, 224, 0.4);
            transform: translateY(-2px);
            background: linear-gradient(45deg, #00C9FF, #4A00E0);
        }

        .btn-back {
            background-color: rgba(74, 0, 224, 0.1);
            color: #4A00E0 !important;
            border-radius: 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background-color: #4A00E0;
            color: white !important;
        }

        .text-primary-blue {
            color: #4A00E0 !important;
        }
        
        .form-control {
            border-radius: 10px;
        }
        
        .form-control:focus {
            border-color: #00C9FF;
            box-shadow: 0 0 0 0.2rem rgba(0, 201, 255, 0.25);
        }
    </style>
</head>
<body class="vertical-layout vertical-menu 1-column bg-custom-blue blank-page">
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">
                <section class="flexbox-container">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="col-md-4 col-10 box-shadow-2 p-0">
                            <div class="card aesthetic-card px-1 py-1 m-0">
                                <div class="card-header border-0 pb-0">
                                    <div class="text-left mb-1">
                                        <a href="<?= base_url() ?>" class="btn btn-sm btn-back font-weight-bold px-2">
                                            <i class="ft-arrow-left"></i> Kembali ke Awal
                                        </a>
                                    </div>
                                    <div class="card-title text-center">
                                        <h3 class="mt-1 font-weight-bold text-primary-blue">Sistem Klinik Terpadu</h3>
                                    </div>
                                    <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
                                        <span>Silakan Login</span>
                                    </h6>
                                </div>
                                <div class="card-content">
                                    <?php if(session()->getFlashdata('error')): ?>
                                    <div class="alert alert-danger mx-2">
                                        <?= session()->getFlashdata('error') ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php if(session()->getFlashdata('success')): ?>
                                    <div class="alert alert-success mx-2">
                                        <?= session()->getFlashdata('success') ?>
                                    </div>
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <form class="form-horizontal" action="<?= base_url('login') ?>" method="POST">
                                            <?= csrf_field() ?>
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="text" class="form-control" name="username" placeholder="Masukkan Username" required minlength="5" title="Username minimal 5 karakter">
                                                <div class="form-control-position">
                                                    <i class="ft-user"></i>
                                                </div>
                                            </fieldset>
                                            <fieldset class="form-group position-relative has-icon-left mb-1">
                                                <input type="password" id="password" class="form-control" name="password" placeholder="Masukkan Password" required minlength="6" pattern="(?=.*\d)(?=.*[^a-zA-Z0-9]).{6,}" title="Minimal 6 karakter, mengandung angka, dan simbol" style="padding-right: 40px;">
                                                <div class="form-control-position">
                                                    <i class="la la-key"></i>
                                                </div>
                                                <div class="position-absolute text-muted" style="top: 10px; right: 15px; cursor: pointer; z-index: 10;" onclick="const pf = document.getElementById('password'); const icon = this.querySelector('i'); if(pf.type === 'password') { pf.type = 'text'; icon.className = 'la la-eye-slash'; } else { pf.type = 'password'; icon.className = 'la la-eye'; }">
                                                    <i class="la la-eye"></i>
                                                </div>
                                            </fieldset>
                                            <div class="form-group row">
                                                <div class="col-md-6 col-12 text-center text-sm-left">
                                                    <fieldset>
                                                        <input type="checkbox" id="remember-me" class="chk-remember">
                                                        <label for="remember-me"> Ingat Saya</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-6 col-12 text-center text-sm-right">
                                                    <a href="<?= base_url('lupa_password') ?>" class="card-link text-primary-blue">Lupa Password?</a>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary-blue btn-block py-2 mt-1"><i class="ft-unlock"></i> Login</button>
                                            <div class="text-center mt-2">
                                                <p class="mb-0">Belum punya akun? <a href="<?= base_url('register') ?>" class="text-primary-blue font-weight-bold">Daftar Pasien</a></p>
                                            </div>
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
    <script src="<?= base_url('app-assets/vendors/js/forms/validation/jqBootstrapValidation.js') ?>"></script>
    <script src="<?= base_url('app-assets/vendors/js/forms/icheck/icheck.min.js') ?>"></script>
    <script src="<?= base_url('app-assets/js/core/app.js') ?>"></script>
    <script>
        $(document).ready(function(){
            'use strict';
            // Login Register Validation
            if($("form.form-horizontal").attr("novalidate")!=undefined){
                $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
            }
            // Remember checkbox
            if($('.chk-remember').length){
                $('.chk-remember').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                });
            }
        });
    </script>
</body>
</html>