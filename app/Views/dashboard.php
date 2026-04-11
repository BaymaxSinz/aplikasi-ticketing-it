<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>

<?= $this->section('content') ?>

<style>
    .card-stat {
        transition: transform 0.2s ease-in-out;
        border-radius: 12px;
    }
    .card-stat:hover {
        transform: translateY(-5px);
    }
    .icon-background {
        font-size: 3.5rem;
        opacity: 0.15;
        position: absolute;
        right: 20px;
        top: 15px;
    }
    .welcome-banner {
        background: linear-gradient(135deg, #0d6efd 0%, #0043a8 100%);
        border-radius: 15px;
    }
</style>

<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm welcome-banner text-white">
            <div class="card-body p-4 p-md-5">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="fw-bold mb-3">
                            <i class="bi bi-emoji-smile me-2"></i>Selamat Datang, <?= session()->get('name') ?>!
                        </h2>
                        <p class="lead mb-0" style="opacity: 0.9;">
                            Ini adalah sistem Internal IT Log. Gunakan menu di atas untuk mulai mencatat tiket baru atau mengelola laporan masalah.
                        </p>
                    </div>
                    <div class="col-md-4 text-end d-none d-md-block">
                        <i class="bi bi-laptop" style="font-size: 6rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    
    <div class="col-md-4">
        <div class="card border-0 border-start border-primary border-4 shadow-sm card-stat h-100 position-relative overflow-hidden">
            <div class="card-body p-4">
                <div class="text-primary fw-bold text-uppercase mb-1" style="font-size: 0.85rem; letter-spacing: 1px;">
                    Total Semua Tiket
                </div>
                <div class="h1 fw-bold text-dark mb-0">
                    <?= $total_semua ?>
                </div>
                <i class="bi bi-ticket-detailed text-primary icon-background"></i>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 border-start border-warning border-4 shadow-sm card-stat h-100 position-relative overflow-hidden">
            <div class="card-body p-4">
                <div class="text-warning fw-bold text-uppercase mb-1" style="font-size: 0.85rem; letter-spacing: 1px;">
                    Tiket In Progress
                </div>
                <div class="h1 fw-bold text-dark mb-0">
                    <?= $in_progress ?>
                </div>
                <i class="bi bi-tools text-warning icon-background"></i>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 border-start border-success border-4 shadow-sm card-stat h-100 position-relative overflow-hidden">
            <div class="card-body p-4">
                <div class="text-success fw-bold text-uppercase mb-1" style="font-size: 0.85rem; letter-spacing: 1px;">
                    Tiket Selesai
                </div>
                <div class="h1 fw-bold text-dark mb-0">
                    <?= $selesai ?>
                </div>
                <i class="bi bi-check-circle-fill text-success icon-background"></i>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>