<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
    Daftar Tiket
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row mb-3">
    <div class="col-md-6 text-end">
        <a href="<?= base_url('tickets/export') ?>" class="btn btn-success me-2">
            <i class="bi bi-file-earmark-excel"></i> Export Laporan
        </a>
        <a href="<?= base_url('tickets/create') ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Catat Tiket Baru
        </a>
    </div>
</div>

<?php if (session()->getFlashdata('success')) : ?>
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
                        <th>ID</th>
                        <th>Waktu Lapor</th>
                        <th>Pelapor</th>
                        <th>Kategori</th>
                        <th>Judul Masalah</th>
                        <th>Prioritas</th>
                        <th>Status</th>
                        <th>Teknisi</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($tickets)) : ?>
                        <?php foreach ($tickets as $t) : ?>
                            <tr>
                                <td class="fw-bold">#<?= $t['id'] ?></td>

                                <td>
                                    <?= date('d M Y, H:i', strtotime($t['created_at'])) ?>
                                </td>

                                <td>
                                    <?= esc($t['reporter_name']) ?><br>
                                    <small class="text-muted">
                                        <?= esc($t['reporter_department']) ?>
                                    </small>
                                </td>

                                <td><?= esc($t['category_name']) ?></td>

                                <td><?= esc($t['title']) ?></td>

                                <td>
                                    <?php if ($t['priority'] === 'high') : ?>
                                        <span class="badge bg-danger">High</span>
                                    <?php elseif ($t['priority'] === 'medium') : ?>
                                        <span class="badge bg-warning text-dark">Medium</span>
                                    <?php else : ?>
                                        <span class="badge bg-success">Low</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php if ($t['status'] === 'open') : ?>
                                        <span class="badge bg-secondary">Open</span>
                                    <?php elseif ($t['status'] === 'in progress') : ?>
                                        <span class="badge bg-primary">In Progress</span>
                                    <?php elseif ($t['status'] === 'resolved') : ?>
                                        <span class="badge bg-info text-dark">Resolved</span>
                                    <?php else : ?>
                                        <span class="badge bg-success">Closed</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php if (!empty($t['technician_name'])) : ?>
                                        <?= esc($t['technician_name']) ?>
                                    <?php else : ?>
                                        <span class="text-muted fst-italic">
                                            Belum ditugaskan
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center">
                                    <a href="<?= base_url('tickets/detail/'.$t['id']) ?>" class="btn btn-sm btn-info text-white" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="<?= base_url('tickets/edit/'.$t['id']) ?>" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <?php if(session()->get('role') == 'admin'): ?>
                                    <a href="<?= base_url('tickets/delete/'.$t['id']) ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus tiket ini?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                Belum ada tiket yang dicatat.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>

            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>