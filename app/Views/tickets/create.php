<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Buat Tiket Baru<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row mb-3">
    <div class="col-md-12">
        <h3 class="fw-bold">Catat Laporan Baru</h3>
        <p class="text-muted">Isi form ini berdasarkan laporan dari Karyawan.</p>
    </div>
</div>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-body p-4">
        <form action="<?= base_url('tickets/store') ?>" method="post">
            
            <h5 class="mb-3 text-primary border-bottom pb-2">Informasi Pelapor</h5>
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label">Nama Karyawan Pelapor</label>
                    <input type="text" class="form-control" name="reporter_name" placeholder="Misal: Budi Santoso" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Departemen / Divisi</label>
                    <input type="text" class="form-control" name="reporter_department" placeholder="Misal: HRD / Finance" required>
                </div>
            </div>

            <h5 class="mb-3 text-primary border-bottom pb-2">Detail Masalah</h5>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Kategori Masalah</label>
                    <select class="form-select" name="category_id" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php foreach($categories as $c): ?>
                            <option value="<?= $c['id'] ?>"><?= $c['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Prioritas</label>
                    <select class="form-select" name="priority" required>
                        <option value="low">Rendah (Low)</option>
                        <option value="medium" selected>Sedang (Medium)</option>
                        <option value="high">Tinggi (High) / Urgent</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Judul Singkat Masalah</label>
                <input type="text" class="form-control" name="title" placeholder="Misal: Printer lantai 2 tidak bisa ngeprint" required>
            </div>

            <div class="mb-4">
                <label class="form-label">Deskripsi Lengkap / Kronologi</label>
                <textarea class="form-control" name="description" rows="5" placeholder="Jelaskan detail error atau kronologi kejadian..." required></textarea>
            </div>

            <div class="text-end">
                <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary me-2">Batal</a>
                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan Tiket</button>
            </div>

        </form>
    </div>
</div>
<?= $this->endSection() ?>