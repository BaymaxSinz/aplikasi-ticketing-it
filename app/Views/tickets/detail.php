<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Detail Tiket #<?= $ticket['id'] ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row mb-3">
    <div class="col-md-6">
        <h3 class="fw-bold">Detail Tiket #<?= $ticket['id'] ?></h3>
    </div>
    <div class="col-md-6 text-end">
        <a href="<?= base_url('tickets') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-md-8 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white fw-bold">
                Informasi Masalah
            </div>
            <div class="card-body">
                <h4 class="text-primary mb-3"><?= $ticket['title'] ?></h4>
                
                <table class="table table-borderless table-sm mb-4">
                    <tr>
                        <td width="25%" class="text-muted">Pelapor</td>
                        <td>: <span class="fw-bold"><?= $ticket['reporter_name'] ?></span> (<?= $ticket['reporter_department'] ?>)</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Waktu Lapor</td>
                        <td>: <?= date('d M Y, H:i', strtotime($ticket['created_at'])) ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Kategori</td>
                        <td>: <?= $ticket['category_name'] ?></td>
                    </tr>
                </table>

                <h6 class="text-muted border-bottom pb-2">Deskripsi Kronologi:</h6>
                <p class="bg-light p-3 rounded" style="white-space: pre-line;">
                    <?= $ticket['description'] ?>
                </p>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white fw-bold">
                Panel Tindakan
            </div>
            <div class="card-body bg-light">
                <div class="mb-3">
                    <label class="text-muted small d-block">Status Saat Ini</label>
                    <span class="badge bg-dark fs-6 text-uppercase"><?= $ticket['status'] ?></span>
                </div>
                
                <div class="mb-4">
                    <label class="text-muted small d-block">Ditugaskan Kepada</label>
                    <span class="fw-bold fs-6">
                        <?= $ticket['technician_name'] ? $ticket['technician_name'] : '<span class="text-danger">Belum Ditugaskan</span>' ?>
                    </span>
                </div>

                <hr>

                <?php if(!$ticket['technician_id']): ?>
                    <div class="d-grid">
                        <a href="<?= base_url('tickets/take/'.$ticket['id']) ?>" class="btn btn-success btn-lg" onclick="return confirm('Anda yakin ingin mengambil alih penanganan tiket ini?')">
                            <i class="bi bi-person-check-fill"></i> Ambil Tiket Ini
                        </a>
                    </div>
                
                <?php elseif($ticket['technician_id'] == session()->get('id') && $ticket['status'] != 'closed'): ?>
                    <form action="<?= base_url('tickets/update-status') ?>" method="post">
                        <input type="hidden" name="id" value="<?= $ticket['id'] ?>">
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Update Status</label>
                            <select class="form-select" name="status" required>
                                <option value="in progress" <?= ($ticket['status'] == 'in progress') ? 'selected' : '' ?>>In Progress (Sedang Dikerjakan)</option>
                                <option value="resolved" <?= ($ticket['status'] == 'resolved') ? 'selected' : '' ?>>Resolved (Selesai/Ditemukan Solusi)</option>
                                <option value="closed" <?= ($ticket['status'] == 'closed') ? 'selected' : '' ?>>Closed (Tutup Tiket)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Catatan Penyelesaian</label>
                            <textarea class="form-control" name="resolution_note" rows="3" placeholder="Tuliskan solusi yang dilakukan jika sudah selesai..." <?= ($ticket['status'] == 'closed') ? 'readonly' : '' ?>><?= $ticket['resolution_note'] ?></textarea>
                            <small class="text-muted">Wajib diisi jika status diubah ke Selesai/Closed.</small>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                
                <?php else: ?>
                    <div class="alert alert-info">
                        <?php if($ticket['status'] == 'closed'): ?>
                            <strong>Tiket telah ditutup.</strong><br>
                            Catatan Solusi: <br><i><?= $ticket['resolution_note'] ?></i>
                        <?php else: ?>
                            Tiket ini sedang ditangani oleh teknisi lain.
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>