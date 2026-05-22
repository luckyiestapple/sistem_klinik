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
                        <div class="col-md-8 col-11 box-shadow-2 p-0 my-3">
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

                                            <!-- JKN / BPJS Option -->
                                            <div class="form-group mb-2 ml-1">
                                                <label class="font-weight-bold text-muted d-block">Apakah Anda memiliki Kartu JKN / BPJS Kesehatan?</label>
                                                <div class="d-inline-block custom-control custom-radio mr-3">
                                                    <input type="radio" name="is_bpjs" value="Ya" id="bpjs_ya" class="custom-control-input">
                                                    <label class="custom-control-label font-weight-bold" for="bpjs_ya">Ya</label>
                                                </div>
                                                <div class="d-inline-block custom-control custom-radio">
                                                    <input type="radio" name="is_bpjs" value="Tidak" id="bpjs_tidak" class="custom-control-input" checked>
                                                    <label class="custom-control-label font-weight-bold" for="bpjs_tidak">Tidak</label>
                                                </div>
                                            </div>

                                            <div id="bpjs_fields_container" style="display: none;">
                                                <div class="card border-info mb-2 bg-light" style="border: 1px solid #0d9488; border-radius: 8px; background-color: #f0fdfa !important;">
                                                    <div class="card-body p-2">
                                                        <h6 class="text-teal font-weight-bold mb-2"><i class="ft-shield"></i> Data Kartu JKN / BPJS Kesehatan</h6>
                                                        <div class="row">
                                                            <div class="col-md-6 col-12">
                                                                <fieldset class="form-group position-relative has-icon-left">
                                                                    <input type="text" class="form-control" name="no_bpjs" id="no_bpjs" placeholder="No. Kartu BPJS / NIK">
                                                                    <div class="form-control-position">
                                                                        <i class="la la-credit-card"></i>
                                                                    </div>
                                                                </fieldset>
                                                                <fieldset class="form-group position-relative">
                                                                    <select class="form-control" name="status_bpjs" id="status_bpjs">
                                                                        <option value="aktif" selected>Status BPJS: Aktif</option>
                                                                        <option value="tidak aktif">Status BPJS: Tidak Aktif</option>
                                                                    </select>
                                                                </fieldset>
                                                            </div>
                                                            <div class="col-md-6 col-12">
                                                                <fieldset class="form-group position-relative has-icon-left">
                                                                    <input type="text" class="form-control" name="faskes" id="faskes" placeholder="Faskes Tingkat I (FKTP)">
                                                                    <div class="form-control-position">
                                                                        <i class="la la-hospital-o"></i>
                                                                    </div>
                                                                </fieldset>
                                                                <fieldset class="form-group position-relative">
                                                                    <select class="form-control" name="kelas_rawat" id="kelas_rawat">
                                                                        <option value="" disabled selected>Pilih Kelas Rawat JKN</option>
                                                                        <option value="Kelas I">Kelas I</option>
                                                                        <option value="Kelas II">Kelas II</option>
                                                                        <option value="Kelas III">Kelas III</option>
                                                                    </select>
                                                                </fieldset>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const bpjsYa = document.getElementById('bpjs_ya');
            const bpjsTidak = document.getElementById('bpjs_tidak');
            const bpjsContainer = document.getElementById('bpjs_fields_container');
            const bpjsInputs = bpjsContainer.querySelectorAll('input, select');

            function toggleBpjs() {
                if (bpjsYa.checked) {
                    bpjsContainer.style.display = 'block';
                    bpjsInputs.forEach(input => {
                        if (input.id !== 'status_bpjs' && input.id !== 'faskes') {
                            input.setAttribute('required', 'required');
                        }
                    });
                } else {
                    bpjsContainer.style.display = 'none';
                    bpjsInputs.forEach(input => {
                        input.removeAttribute('required');
                        if (input.tagName === 'SELECT' && input.id !== 'status_bpjs') {
                            input.selectedIndex = 0;
                        } else if (input.id !== 'status_bpjs') {
                            input.value = '';
                        }
                    });
                }
            }

            bpjsYa.addEventListener('change', toggleBpjs);
            bpjsTidak.addEventListener('change', toggleBpjs);
        });
    </script>
</body>
</html>
