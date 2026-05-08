<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Klinik</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('app-assets/images/ico/favicon.ico') ?>">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/css/vendors.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('app-assets/css/app.css') ?>">
    <style>
        body {
            background: linear-gradient(135deg, #1a73e8 0%, #0d47a1 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Open Sans', sans-serif;
        }
        .login-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 40px 35px;
            width: 100%;
            max-width: 420px;
        }
        .login-logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-logo h2 {
            color: #1a73e8;
            font-weight: 700;
            margin-bottom: 4px;
        }
        .login-logo p {
            color: #888;
            font-size: 13px;
        }
        .form-group label {
            font-weight: 600;
            color: #444;
            font-size: 13px;
        }
        .form-control {
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 10px 14px;
            font-size: 14px;
            transition: border-color 0.2s;
        }
        .form-control:focus {
            border-color: #1a73e8;
            box-shadow: 0 0 0 3px rgba(26,115,232,0.15);
        }
        .btn-login {
            background: linear-gradient(135deg, #1a73e8, #0d47a1);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 12px;
            width: 100%;
            font-size: 15px;
            font-weight: 600;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: opacity 0.2s;
        }
        .btn-login:hover {
            opacity: 0.9;
        }
        .alert-danger {
            border-radius: 8px;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-logo">
            <h2>🏥 Sistem Klinik</h2>
            <p>Silakan login untuk melanjutkan</p>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <i class="ft-alert-circle"></i> <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('login') ?>" method="POST">
            <?= csrf_field() ?>
            <div class="form-group mb-3">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username"
                       placeholder="Masukkan username" required autofocus>
            </div>
            <div class="form-group mb-4">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password"
                       placeholder="Masukkan password" required>
            </div>
            <button type="submit" class="btn-login">Login</button>
        </form>
    </div>
</body>
</html>
