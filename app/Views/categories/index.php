<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Kelola Kategori<?= $this->endSection() ?>

<?= $this->section('content') ?>

<style>
    /* Kustomisasi Tabel & Modal agar lebih Premium */
    .table-custom th {
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        color: #6c757d;
        border-bottom: 2px solid #edf2f6;
        padding-bottom: 1rem;
    }
    .table-custom td {
        padding: 1rem 0.75rem;
        border-bottom: 1px solid #edf2f6;
        color: #495057;
    }
    .btn-action {
        border-radius: 8px;
        padding: 0.4rem 0.6rem;
        transition: all 0.2s;
    }
    .btn-action:hover {
        transform: translateY(-2px);
    }
    .modal-content {
        border: none;
        border-radius: 15px;
    }
    .modal-header {
        border-bottom: 1px solid #edf2f6;
        padding: 1.5rem 1.5rem 1rem;
    }
    .modal-body, .modal-footer {
        padding: 1.5rem;
    }
    .modal-footer {
        border-top: none;
        padding-top: 0;
    }
    .form-control {
        border-radius: 8px;
        padding: 0.6rem 1rem;
        border: 1px solid #ced4da;
    }
    .form-control:focus {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
    }
</style>

<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h3 class="fw-bold mb-0 text-dark">
            <i class="bi bi-tags text-primary me-2"></i> Kategori Masalah
        </h3>
        <p class="text-muted small mt-1 mb-0">Kelola daftar jenis masalah untuk pelaporan tiket IT.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <button type="button" class="btn btn-primary shadow-sm rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#categoryModal" onclick="clearForm()">
            <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
        </button>
    </div>
</div>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 d-flex align-items-center" role="alert">
        <i class="bi bi-check-circle-fill fs-5 me-3"></i>
        <div><?= session()->getFlashdata('success') ?></div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm" style="border-radius: 15px;">
    <div class="card-body p-0">
        <div class="table-responsive px-4 pb-2">
            <table class="table table-borderless table-hover align-middle table-custom mb-0 mt-3">
                <thead>
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th width="30%">Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach($categories as $c): ?>
                    <tr>
                        <td class="text-center text-muted fw-semibold"><?= $no++ ?></td>
                        <td>
                            <div class="fw-bold text-dark"><?= $c['name'] ?></div>
                        </td>
                        <td>
                            <span class="text-muted" style="font-size: 0.95rem;"><?= $c['description'] ? $c['description'] : '<em>Tidak ada deskripsi</em>' ?></span>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-light text-primary btn-action me-1 shadow-sm" title="Edit Kategori" onclick="editData(<?= $c['id'] ?>, '<?= htmlspecialchars($c['name']) ?>', '<?= htmlspecialchars($c['description']) ?>')" data-bs-toggle="modal" data-bs-target="#categoryModal">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <a href="<?= base_url('categories/delete/'.$c['id']) ?>" class="btn btn-light text-danger btn-action shadow-sm" title="Hapus Kategori" onclick="return confirm('Yakin ingin menghapus kategori ini? Semua tiket yang terkait mungkin akan terpengaruh.')">
                                <i class="bi bi-trash3"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    
                    <?php if(empty($categories)): ?>
                    <tr>
                        <td colspan="4">
                            <div class="text-center py-5">
                                <i class="bi bi-inbox text-muted" style="font-size: 3rem; opacity: 0.5;"></i>
                                <h6 class="mt-3 fw-bold text-muted">Belum ada kategori data</h6>
                                <p class="text-muted small">Klik tombol "Tambah Kategori" di pojok kanan atas untuk memulai.</p>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="categoryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg">
            
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-dark" id="modalTitle">
                    <i class="bi bi-plus-circle text-primary me-2" id="modalIcon"></i> <span id="modalTitleText">Tambah Kategori</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <form action="<?= base_url('categories/save') ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="id" id="categoryId">
                    
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-muted small">NAMA KATEGORI</label>
                        <input type="text" class="form-control" name="name" id="categoryName" placeholder="Misal: Hardware, Software, Jaringan" required>
                    </div>
                    
                    <div class="mb-2">
                        <label class="form-label fw-semibold text-muted small">DESKRIPSI (OPSIONAL)</label>
                        <textarea class="form-control" name="description" id="categoryDesc" rows="3" placeholder="Jelaskan cakupan masalah kategori ini..."></textarea>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-light fw-semibold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-semibold px-4">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function clearForm() {
        document.getElementById('modalTitleText').innerText = 'Tambah Kategori';
        document.getElementById('modalIcon').className = 'bi bi-plus-circle text-primary me-2';
        document.getElementById('categoryId').value = '';
        document.getElementById('categoryName').value = '';
        document.getElementById('categoryDesc').value = '';
    }

    function editData(id, name, desc) {
        document.getElementById('modalTitleText').innerText = 'Edit Kategori';
        document.getElementById('modalIcon').className = 'bi bi-pencil-square text-warning me-2'; // Ganti icon saat edit
        document.getElementById('categoryId').value = id;
        document.getElementById('categoryName').value = name;
        document.getElementById('categoryDesc').value = desc;
    }
</script>
<?= $this->endSection() ?>