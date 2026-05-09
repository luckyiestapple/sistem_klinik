<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Sistem Informasi Klinik</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700%7CQuicksand:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/css/vendors.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/css/bootstrap-extended.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/css/colors.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/css/components.css') ?>">
    <style>
        .hero { min-height: 100vh; display: flex; align-items: center; background: linear-gradient(135deg, #1E88E5 0%, #0D47A1 100%); color: white; text-align: center; position: relative;}
        .hero-title { font-weight: 700; font-size: 3.5rem; margin-bottom: 20px; color: #fff; letter-spacing:-1px;}
        .hero-subtitle { font-size: 1.25rem; font-weight: 300; margin-bottom: 40px; color: #e3f2fd; max-width:600px; margin-left:auto; margin-right:auto;}
        .btn-custom { border-radius: 50px; font-weight:600; padding: 10px 25px; font-size: 1rem; box-shadow: 0 4px 15px rgba(0,0,0,0.2); transition: all 0.3s; background-color:#FFCA28; color:#3E2723; border:none;}
        .btn-custom:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.3); background-color:#FFE082;}
        .top-nav { position: absolute; top: 20px; right: 30px; }
    </style>
</head>
<body class="vertical-layout vertical-menu 1-column blank-page blank-page" data-open="click" data-menu="vertical-menu" data-col="1-column">
    <div class="app-content content">
        <div class="content-wrapper p-0 m-0">
            <div class="hero">
                <div class="top-nav">
                    <a href="<?= base_url('login') ?>" class="btn btn-custom"><i class="ft-user"></i> Akses Dashboard (Login)</a>
                </div>
                <div class="container">
                    <img src="<?= base_url('app-assets/images/logo/logo-light.png') ?>" alt="Logo" style="max-height:80px; margin-bottom: 30px;" onerror="this.style.display='none'">
                    <h1 class="hero-title">Sistem Klinik Terpadu</h1>
                    <p class="hero-subtitle">Membantu masyarakat mendapatkan pelayanan kesehatan yang prima dan terintegrasi secara digital dengan satu pintu pendaftaran dan rekam medis.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
