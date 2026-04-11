<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Edit Tiket #<?= $ticket['id'] ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row mb-3">
    <div class="col-md-12">
        <h3 class="fw-bold">Edit Laporan Tiket</h3>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body p-4">
        <form action="<?= base_url('tickets/update') ?>" method="post">
            <input type="hidden" name="id" value="<?= $ticket['id'] ?>">
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Pelapor</label>
                    <input type="text" class="form-control" name="reporter_name" value="<?= $ticket['reporter_name'] ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Departemen</label>
                    <input type="text" class="form-control" name="reporter_department" value="<?= $ticket['reporter_department'] ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Kategori</label>
                    <select class="form-select" name="category_id" required>
                        <?php foreach($categories as $c): ?>
                            <option value="<?= $c['id'] ?>" <?= ($c['id'] == $ticket['category_id']) ? 'selected' : '' ?>><?= $c['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Prioritas</label>
                    <select class="form-select" name="priority" required>
                        <option value="low" <?= ($ticket['priority'] == 'low') ? 'selected' : '' ?>>Low</option>
                        <option value="medium" <?= ($ticket['priority'] == 'medium') ? 'selected' : '' ?>>Medium</option>
                        <option value="high" <?= ($ticket['priority'] == 'high') ? 'selected' : '' ?>>High</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Judul Masalah</label>
                <input type="text" class="form-control" name="title" value="<?= $ticket['title'] ?>" required>
            </div>

            <div class="mb-4">
                <label class="form-label">Deskripsi</label>
                <textarea class="form-control" name="description" rows="5" required><?= $ticket['description'] ?></textarea>
            </div>

            <div class="text-end">
                <a href="<?= base_url('tickets') ?>" class="btn btn-secondary me-2">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>