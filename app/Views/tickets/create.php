<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Buat Tiket Baru<?= $this->endSection() ?>

<?= $this->section('content') ?>

<style>
    .card-form { border: none; border-radius: 15px; }
    .form-section-title { font-size: 1.1rem; font-weight: 700; color: #2c3e50; margin-bottom: 1.5rem; display: flex; align-items: center; }
    .form-section-title i { background-color: #f0f4ff; color: #0d6efd; padding: 0.5rem; border-radius: 8px; margin-right: 0.8rem; }
    .form-label-custom { font-size: 0.8rem; font-weight: 600; letter-spacing: 0.5px; text-transform: uppercase; color: #6c757d; }
    .form-control, .form-select { border-radius: 8px; padding: 0.7rem 1rem; border: 1px solid #ced4da; background-color: #fcfcfc; transition: all 0.2s; }
    .form-control:focus, .form-select:focus { background-color: #ffffff; box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1); border-color: #86b7fe; }
    .form-control::placeholder { color: #adb5bd; font-size: 0.9rem; }
    hr.custom-divider { border-color: #edf2f6; margin: 2.5rem 0; }
    
    /* Style Pilihan Tipe Tiket */
    .type-select-card {
        border: 2px solid #edf2f6;
        border-radius: 12px;
        padding: 1rem;
        cursor: pointer;
        transition: all 0.2s;
        background-color: #fcfcfc;
    }
    .type-select-card:hover { border-color: #86b7fe; }
    .btn-check:checked + .type-select-card-general {
        border-color: #0d6efd;
        background-color: #f0f4ff;
    }
    .btn-check:checked + .type-select-card-simrs {
        border-color: #dc3545;
        background-color: #fff5f5;
    }
</style>

<div class="row align-items-center mb-4">
    <div class="col-md-8">
        <h3 class="fw-bold mb-0 text-dark">
            <i class="bi bi-pencil-square text-primary me-2"></i> Catat Laporan Baru
        </h3>
        <p class="text-muted small mt-1 mb-0">Isi formulir di bawah ini berdasarkan keluhan yang Anda terima.</p>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <a href="<?= base_url('tickets') ?>" class="btn btn-light shadow-sm fw-semibold rounded-pill px-4">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
        </a>
    </div>
</div>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 d-flex align-items-center" role="alert">
        <i class="bi bi-check-circle-fill fs-5 me-3"></i>
        <div><?= session()->getFlashdata('success') ?></div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm card-form mb-5">
    <div class="card-body p-4 p-md-5">
        <form action="<?= base_url('tickets/store') ?>" method="post">
            
            <!-- Pilihan Tipe Tiket -->
            <div class="form-section-title">
                <i class="bi bi-layers"></i> Tipe Layanan / Sistem
            </div>

            <div class="row mb-4">
                <div class="col-md-6 mb-3 mb-md-0">
                    <input type="radio" class="btn-check" name="ticket_type" id="typeGeneral" value="general" checked>
                    <label class="type-select-card type-select-card-general d-flex align-items-center w-100" for="typeGeneral">
                        <div class="bg-primary text-white rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="bi bi-pc-display fs-5"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark">IT Umum</div>
                            <div class="text-muted small">Hardware, Jaringan, Printer, OS, PC Layanan</div>
                        </div>
                    </label>
                </div>
                
                <div class="col-md-6">
                    <input type="radio" class="btn-check" name="ticket_type" id="typeSimrs" value="simrs">
                    <label class="type-select-card type-select-card-simrs d-flex align-items-center w-100" for="typeSimrs">
                        <div class="bg-danger text-white rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="bi bi-hospital fs-5"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark">SIMRS</div>
                            <div class="text-muted small">Bridging BPJS, Error Poliklinik, Database, Web RS</div>
                        </div>
                    </label>
                </div>
            </div>

            <hr class="custom-divider">

            <!-- SEGMEN 1: Informasi Pelapor -->
            <div class="form-section-title">
                <i class="bi bi-person-badge"></i> Informasi Pelapor
            </div>
            
            <div class="row mb-4">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label class="form-label form-label-custom">NAMA KARYAWAN PELAPOR</label>
                    <input type="text" class="form-control" name="reporter_name" placeholder="Misal: Dr. Andi / Nurse Rina" required autofocus>
                </div>
                <div class="col-md-6">
                    <label class="form-label form-label-custom">DEPARTEMEN / RUANGAN / POLI</label>
                    <input type="text" class="form-control" name="reporter_department" placeholder="Misal: Poli Anak, Rekam Medis, Farmasi" required>
                </div>
            </div>

            <hr class="custom-divider">

            <!-- SEGMEN 2: Detail Masalah -->
            <div class="form-section-title">
                <i class="bi bi-tools"></i> Detail Masalah
            </div>
            
            <div class="row mb-4">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label class="form-label form-label-custom">KATEGORI MASALAH</label>
                    <select class="form-select" name="category_id" required>
                        <option value="" disabled selected>-- Pilih Kategori --</option>
                        <?php foreach($categories as $c): ?>
                            <option value="<?= $c['id'] ?>"><?= esc($c['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label form-label-custom">TINGKAT PRIORITAS</label>
                    <select class="form-select" name="priority" required>
                        <option value="low">Rendah (Low) - Tidak Mengganggu Pelayanan</option>
                        <option value="medium" selected>Sedang (Medium) - Pelayanan Terhambat</option>
                        <option value="high">Tinggi (High) - Pelayanan Macet / Urgent</option>
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label form-label-custom">JUDUL SINGKAT MASALAH</label>
                <input type="text" class="form-control" name="title" placeholder="Misal: Gagal bridging V-Claim SEP / Printer kasir mati" required>
            </div>

            <div class="mb-5">
                <label class="form-label form-label-custom">DESKRIPSI LENGKAP / KRONOLOGI</label>
                <textarea class="form-control" name="description" rows="5" placeholder="Jelaskan detail error atau kronologi kejadian..." required></textarea>
            </div>

            <div class="d-flex justify-content-end align-items-center bg-light p-3 rounded-3 border">
                <a href="<?= base_url('tickets') ?>" class="btn btn-link text-muted text-decoration-none me-3 fw-semibold">Batal</a>
                <button type="submit" class="btn btn-primary px-4 fw-semibold shadow-sm">
                    <i class="bi bi-send me-1"></i> Simpan Laporan
                </button>
            </div>

        </form>
    </div>
</div>
<?= $this->endSection() ?>