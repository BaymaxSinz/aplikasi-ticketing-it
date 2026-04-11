<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> - IT Helpdesk</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        
        body { 
            background-color: #f4f7f6; /* Warna latar belakang abu-abu sangat muda */
            font-family: 'Inter', sans-serif; /* Font modern yang sering dipakai UI/UX Designer */
        }
        
        /* Kustomisasi Navbar */
        .navbar-custom {
            background-color: #ffffff;
            box-shadow: 0 2px 15px rgba(0,0,0,0.04);
            padding: 0.8rem 0;
        }
        .navbar-brand { 
            font-weight: 800; 
            letter-spacing: 0.5px;
            color: #0d6efd !important;
        }
        
        /* Kustomisasi Menu Navigasi */
        .nav-link {
            font-weight: 500;
            color: #555 !important;
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
            margin: 0 0.2rem;
            transition: all 0.3s ease;
        }
        .nav-link:hover, .nav-link:focus {
            color: #0d6efd !important;
            background-color: #f0f4ff;
        }
        
        /* Kustomisasi Profil Kanan */
        .user-profile-badge {
            background-color: #f8f9fa;
            border: 1px solid #edf2f6;
            border-radius: 50px;
            padding: 0.3rem 1rem 0.3rem 0.3rem !important;
        }
        .avatar-circle {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #0d6efd, #0043a8);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.85rem;
        }
        
        .main-content { padding-top: 2rem; padding-bottom: 3rem; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light navbar-custom sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="<?= base_url('dashboard') ?>">
            <i class="bi bi-headset fs-4 me-2"></i> IT HELPDESK
        </a>
        
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 mt-3 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('dashboard') ?>">
                        <i class="bi bi-grid-1x2 me-1"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('tickets') ?>">
                        <i class="bi bi-ticket-detailed me-1"></i> Data Tiket
                    </a>
                </li>
                
                <?php if(session()->get('role') == 'admin'): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-database-gear me-1"></i> Master Data
                    </a>
                    <ul class="dropdown-menu border-0 shadow-sm mt-2 rounded-3">
                        <li><a class="dropdown-item py-2" href="<?= base_url('categories') ?>">Kategori Masalah</a></li>
                        <li><a class="dropdown-item py-2" href="<?= base_url('users') ?>">Data Teknisi/Admin</a></li>
                    </ul>
                </li>
                <?php endif; ?>
            </ul>
            
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link user-profile-badge d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                        <div class="avatar-circle me-2 shadow-sm">
                            <?= strtoupper(substr(session()->get('name'), 0, 1)) ?>
                        </div>
                        <div class="text-start me-2 d-none d-lg-block">
                            <div class="fw-bold lh-1 text-dark" style="font-size: 0.85rem;"><?= session()->get('name') ?></div>
                            <div class="text-muted mt-1" style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                <?= session()->get('role') ?>
                            </div>
                        </div>
                        <i class="bi bi-chevron-down ms-1" style="font-size: 0.7rem;"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm mt-2 rounded-3">
                        <li>
                            <a class="dropdown-item py-2 text-danger fw-semibold d-flex align-items-center" href="<?= base_url('logout') ?>">
                                <i class="bi bi-box-arrow-right me-2"></i> Keluar Sistem
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="container main-content">
    <?= $this->renderSection('content') ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>