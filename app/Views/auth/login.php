<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pengurus - <?= site_name() ?></title>
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #064e3b; /* Hijau Islami Premium */
            --primary-light: #0f766e;
            --bg-gradient: linear-gradient(135deg, #022c22 0%, #064e3b 50%, #115e59 100%);
            --glass-bg: rgba(255, 255, 255, 0.95);
            --glass-border: rgba(255, 255, 255, 0.2);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-gradient);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: #1f2937;
        }

        .login-card {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 440px;
            padding: 40px 30px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }

        .brand-logo {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 5px;
        }

        .brand-title {
            font-weight: 700;
            color: #111827;
            font-size: 1.5rem;
            letter-spacing: -0.5px;
        }

        .brand-subtitle {
            color: #6b7280;
            font-size: 0.875rem;
            margin-bottom: 30px;
        }

        /* Google Login Button (Di Atas) */
        .btn-google {
            background-color: #ffffff;
            color: #374151;
            border: 1px solid #d1d5db;
            font-weight: 600;
            padding: 12px 20px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            transition: all 0.2s ease;
            text-decoration: none;
            width: 100%;
            font-size: 0.95rem;
        }

        .btn-google:hover {
            background-color: #f9fafb;
            border-color: #9ca3af;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            color: #111827;
        }

        .btn-google img {
            width: 20px;
            height: 20px;
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 25px 0;
            color: #9ca3af;
            font-size: 0.8rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e5e7eb;
        }

        .divider:not(:empty)::before {
            margin-right: .5em;
        }

        .divider:not(:empty)::after {
            margin-left: .5em;
        }

        /* Input Controls */
        .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: #374151;
        }

        .form-control {
            padding: 12px 16px;
            border-radius: 10px;
            border: 1.5px solid #d1d5db;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 4px rgba(15, 118, 110, 0.15);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            border: none;
            padding: 12px 20px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            width: 100%;
        }

        .btn-primary:hover {
            opacity: 0.9;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(6, 78, 59, 0.25);
        }

        .footer-text {
            margin-top: 30px;
            font-size: 0.8rem;
            color: #9ca3af;
            text-align: center;
        }

        .alert {
            border-radius: 10px;
            font-size: 0.875rem;
            border: none;
        }
    </style>
</head>
<body>

    <div class="login-card text-center">
        <!-- Brand Header -->
        <div class="brand-logo">
            <i class="fa-solid fa-mosque"></i>
        </div>
        <h2 class="brand-title"><?= site_name() ?></h2>
        <p class="brand-subtitle">Panel Pengurus & Administrator</p>

        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger text-start d-flex align-items-center gap-2 mb-4" role="alert">
                <i class="fa-solid fa-circle-exclamation"></i>
                <div><?= session()->getFlashdata('error') ?></div>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success text-start d-flex align-items-center gap-2 mb-4" role="alert">
                <i class="fa-solid fa-circle-check"></i>
                <div><?= session()->getFlashdata('success') ?></div>
            </div>
        <?php endif; ?>

        <!-- 1. GOOGLE LOGIN BUTTON (DI ATAS) -->
        <a href="<?= esc($google_login_url) ?>" class="btn-google">
            <img src="https://img.icons8.com/color/16/000000/google-logo.png" alt="Google Logo">
            Masuk dengan Google
        </a>

        <!-- VISUAL DIVIDER -->
        <div class="divider">atau masuk menggunakan</div>

        <!-- 2. NATIVE USERNAME/PASSWORD FORM (DI BAWAH) -->
        <form action="<?= base_url('login/process') ?>" method="post" class="text-start">
            <?= csrf_field() ?>
            
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted border-end-0"><i class="fa-solid fa-user"></i></span>
                    <input type="text" class="form-control border-start-0" id="username" name="username" placeholder="Masukkan username" value="<?= old('username') ?>" required>
                </div>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">Kata Sandi</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted border-end-0"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" class="form-control border-start-0" id="password" name="password" placeholder="Masukkan password" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                Masuk ke Panel <i class="fa-solid fa-arrow-right-to-bracket ms-2"></i>
            </button>
        </form>

        <div class="footer-text">
            &copy; 2026 Pengurus <?= site_name() ?>.
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
