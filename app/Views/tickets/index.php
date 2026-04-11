<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Daftar Tiket<?= $this->endSection() ?>

<?= $this->section('content') ?>

<style>
    /* Kustomisasi Tabel & UI Premium */
    .table-custom th {
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        color: #6c757d;
        border-bottom: 2px solid #edf2f6;
        padding-bottom: 1rem;
        white-space: nowrap;
    }
    .table-custom td {
        padding: 1rem 0.75rem;
        border-bottom: 1px solid #edf2f6;
        color: #495057;
        vertical-align: middle;
    }
    .btn-action {
        border-radius: 8px;
        padding: 0.4rem 0.6rem;
        transition: all 0.2s;
        border: none;
    }
    .btn-action:hover {
        transform: translateY(-2px);
    }
    .badge-custom {
        padding: 0.4rem 0.8rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.75rem;
        letter-spacing: 0.3px;
    }
    /* Avatar Kecil untuk Teknisi */
    .avatar-sm {
        width: 28px;
        height: 28px;
        background: linear-gradient(135deg, #0d6efd, #0043a8);
        color: white;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 0.7rem;
    }
</style>

<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h3 class="fw-bold mb-0 text-dark">
            <i class="bi bi-inbox text-primary me-2"></i> Daftar Tiket Masuk
        </h3>
        <p class="text-muted small mt-1 mb-0">Pantau dan kelola semua laporan masalah IT di sini.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <a href="<?= base_url('tickets/export') ?>" class="btn btn-outline-success shadow-sm rounded-pill px-3 me-2 fw-semibold">
            <i class="bi bi-file-earmark-excel me-1"></i> Export Laporan
        </a>
        <a href="<?= base_url('tickets/create') ?>" class="btn btn-primary shadow-sm rounded-pill px-4 fw-semibold">
            <i class="bi bi-plus-lg me-1"></i> Catat Tiket Baru
        </a>
    </div>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 d-flex align-items-center" role="alert">
        <i class="bi bi-check-circle-fill fs-5 me-3"></i>
        <div><?= session()->getFlashdata('success') ?></div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm" style="border-radius: 15px;">
    <div class="card-body p-0">
        <div class="table-responsive px-4 pb-3">
            <table class="table table-borderless table-hover align-middle table-custom mb-0 mt-3">
                <thead>
                    <tr>
                        <th width="5%">ID</th>
                        <th width="12%">Waktu Lapor</th>
                        <th width="15%">Pelapor</th>
                        <th width="20%">Judul Masalah</th>
                        <th width="8%" class="text-center">Prioritas</th>
                        <th width="10%" class="text-center">Status</th>
                        <th width="15%">Ditangani Oleh</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($tickets)) : ?>
                        <?php foreach ($tickets as $t) : ?>
                            <tr>
                                <td>
                                    <span class="fw-bold text-primary bg-light p-1 rounded px-2">#<?= $t['id'] ?></span>
                                </td>

                                <td>
                                    <div class="fw-bold text-dark" style="font-size: 0.9rem;"><?= date('d M Y', strtotime($t['created_at'])) ?></div>
                                    <div class="text-muted" style="font-size: 0.8rem;"><i class="bi bi-clock"></i> <?= date('H:i', strtotime($t['created_at'])) ?></div>
                                </td>

                                <td>
                                    <div class="fw-bold text-dark" style="font-size: 0.95rem;"><?= esc($t['reporter_name']) ?></div>
                                    <div class="text-muted" style="font-size: 0.8rem;"><?= esc($t['reporter_department']) ?></div>
                                </td>

                                <td>
                                    <div class="fw-bold text-dark text-truncate" style="max-width: 200px;" title="<?= esc($t['title']) ?>">
                                        <?= esc($t['title']) ?>
                                    </div>
                                    <span class="text-muted" style="font-size: 0.8rem;"><i class="bi bi-tag"></i> <?= esc($t['category_name']) ?></span>
                                </td>

                                <td class="text-center">
                                    <?php if ($t['priority'] === 'high') : ?>
                                        <span class="badge badge-custom bg-danger"><i class="bi bi-arrow-up-circle"></i> High</span>
                                    <?php elseif ($t['priority'] === 'medium') : ?>
                                        <span class="badge badge-custom bg-warning text-dark">Medium</span>
                                    <?php else : ?>
                                        <span class="badge badge-custom bg-info text-dark"><i class="bi bi-arrow-down-circle"></i> Low</span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center">
                                    <?php if ($t['status'] === 'open') : ?>
                                        <span class="badge badge-custom bg-secondary text-uppercase">Open</span>
                                    <?php elseif ($t['status'] === 'in progress') : ?>
                                        <span class="badge badge-custom bg-primary text-uppercase">In Progress</span>
                                    <?php elseif ($t['status'] === 'resolved') : ?>
                                        <span class="badge badge-custom bg-info text-dark text-uppercase">Resolved</span>
                                    <?php else : ?>
                                        <span class="badge badge-custom bg-success text-uppercase">Closed</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php if (!empty($t['technician_name'])) : ?>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-2 shadow-sm">
                                                <?= strtoupper(substr($t['technician_name'], 0, 1)) ?>
                                            </div>
                                            <span class="fw-semibold text-dark" style="font-size: 0.9rem;"><?= esc($t['technician_name']) ?></span>
                                        </div>
                                    <?php else : ?>
                                        <span class="badge bg-light text-danger border fw-normal"><i class="bi bi-person-x"></i> Belum ada</span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center">
                                    <a href="<?= base_url('tickets/detail/'.$t['id']) ?>" class="btn btn-light text-primary btn-action shadow-sm" title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="<?= base_url('tickets/edit/'.$t['id']) ?>" class="btn btn-light text-warning btn-action shadow-sm mx-1" title="Edit Laporan">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <?php if(session()->get('role') == 'admin'): ?>
                                    <a href="<?= base_url('tickets/delete/'.$t['id']) ?>" class="btn btn-light text-danger btn-action shadow-sm" title="Hapus Tiket" onclick="return confirm('Yakin ingin menghapus tiket ini secara permanen?')">
                                        <i class="bi bi-trash3"></i>
                                    </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="8">
                                <div class="text-center py-5">
                                    <i class="bi bi-check2-circle text-success" style="font-size: 3rem; opacity: 0.5;"></i>
                                    <h6 class="mt-3 fw-bold text-muted">Hore! Tidak ada masalah IT.</h6>
                                    <p class="text-muted small">Semua tiket telah terselesaikan atau belum ada laporan baru yang masuk.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>