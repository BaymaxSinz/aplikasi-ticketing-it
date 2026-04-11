<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - IT Helpdesk System</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        /* Sedikit kustomisasi CSS agar terlihat lebih premium */
        body {
            background-color: #f4f7f6;
        }
        .login-card {
            border: none;
            border-radius: 15px;
        }
        .login-header {
            border-radius: 15px 15px 0 0 !important;
            padding: 1.5rem;
        }
        .form-control {
            padding: 0.75rem 1rem;
            border-radius: 8px;
        }
        .btn-login {
            padding: 0.75rem;
            border-radius: 8px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-12 col-md-8 col-lg-5">
                
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-primary"><i class="bi bi-headset"></i> IT Helpdesk</h3>
                    <p class="text-muted">Portal Log Internal Tim IT</p>
                </div>

                <div class="card shadow-lg login-card">
                    <div class="card-header bg-primary text-white text-center login-header">
                        <h5 class="mb-0 fw-bold">Silakan Login</h5>
                    </div>
                    
                    <div class="card-body p-4 p-md-5">
                        
                        <?php if(session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <div><?= session()->getFlashdata('error') ?></div>
                        </div>
                        <?php endif; ?>

                        <form action="<?= base_url('login/process') ?>" method="post">
                            <div class="mb-4">
                                <label for="email" class="form-label text-muted fw-semibold">Alamat Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="nama@perusahaan.com" required autofocus>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label for="password" class="form-label text-muted fw-semibold">Kata Sandi</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-lock"></i></span>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan kata sandi" required>
                                </div>
                            </div>

                            <div class="d-grid mt-5">
                                <button type="submit" class="btn btn-primary btn-login shadow-sm">
                                    MASUK KE SISTEM <i class="bi bi-box-arrow-in-right ms-1"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="text-center mt-4 text-muted small">
                    &copy; <?= date('Y') ?> BaymaxSinz Dev. All rights reserved.
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>