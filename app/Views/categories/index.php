<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Kelola Kategori<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row mb-3">
    <div class="col-md-6">
        <h3 class="fw-bold">Data Kategori Masalah</h3>
    </div>
    <div class="col-md-6 text-end">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#categoryModal" onclick="clearForm()">
            <i class="bi bi-plus-circle"></i> Tambah Kategori
        </button>
    </div>
</div>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="25%">Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach($categories as $c): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td class="fw-bold"><?= $c['name'] ?></td>
                        <td><?= $c['description'] ?></td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-warning" onclick="editData(<?= $c['id'] ?>, '<?= $c['name'] ?>', '<?= $c['description'] ?>')" data-bs-toggle="modal" data-bs-target="#categoryModal">
                                Edit
                            </button>
                            <a href="<?= base_url('categories/delete/'.$c['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus kategori ini?')">
                                Hapus
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    
                    <?php if(empty($categories)): ?>
                    <tr>
                        <td colspan="4" class="text-center text-muted">Belum ada data kategori</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="categoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalTitle">Tambah Kategori</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('categories/save') ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="id" id="categoryId">
                    
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" name="name" id="categoryName" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="description" id="categoryDesc" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function clearForm() {
        document.getElementById('modalTitle').innerText = 'Tambah Kategori';
        document.getElementById('categoryId').value = '';
        document.getElementById('categoryName').value = '';
        document.getElementById('categoryDesc').value = '';
    }

    function editData(id, name, desc) {
        document.getElementById('modalTitle').innerText = 'Edit Kategori';
        document.getElementById('categoryId').value = id;
        document.getElementById('categoryName').value = name;
        document.getElementById('categoryDesc').value = desc;
    }
</script>
<?= $this->endSection() ?>