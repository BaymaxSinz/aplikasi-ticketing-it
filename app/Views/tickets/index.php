<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Daftar Tiket<?= $this->endSection() ?>

<?= $this->section('content') ?>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<style>
    /* DESAIN TABEL PREMIUM & RAPI */
    .table-custom th { 
        font-size: 0.75rem; 
        letter-spacing: 0.8px; 
        text-transform: uppercase; 
        color: #8392a5; 
        border-bottom: 2px solid #edf2f6 !important; 
        padding: 1rem 0.75rem; 
        white-space: nowrap; 
    }
    
    /* Padding diperbesar agar baris bernapas, vertical-align dikembalikan ke middle agar rapi */
    .table-custom td { 
        padding: 1.2rem 0.75rem; 
        border-bottom: 1px solid #edf2f6; 
        color: #495057; 
        vertical-align: middle; 
    }
    
    /* Baris tabel akan memiliki efek abu-abu sangat lembut saat di-hover */
    .table-custom tbody tr:hover {
        background-color: #fcfcfc;
    }

    /* Kustomisasi Teks & Badge */
    .ticket-title-link {
        color: #2b3440;
        text-decoration: none;
        transition: color 0.2s;
    }
    .ticket-title-link:hover {
        color: #0d6efd;
    }
    
    .btn-action { border-radius: 8px; padding: 0.4rem 0.6rem; transition: all 0.2s; border: none; }
    .btn-action:hover { transform: translateY(-3px); box-shadow: 0 4px 8px rgba(0,0,0,0.1) !important; }
    .badge-custom { padding: 0.4rem 0.8rem; border-radius: 6px; font-weight: 600; font-size: 0.7rem; letter-spacing: 0.3px; }
    .badge-tag { padding: 0.3rem 0.5rem; border-radius: 4px; font-weight: 600; font-size: 0.65rem; letter-spacing: 0.5px; }
    
    .avatar-sm { width: 32px; height: 32px; background: linear-gradient(135deg, #0d6efd, #0043a8); color: white; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-weight: bold; font-size: 0.75rem; }
    
    /* Kustomisasi Elemen DataTables */
    .dataTables_wrapper .row { align-items: center; margin-bottom: 1rem; }
    .dataTables_filter input { border-radius: 8px; padding: 0.4rem 1rem; border: 1px solid #ced4da; }
    .dataTables_filter input:focus { border-color: #86b7fe; box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1); outline: none; }
    .dataTables_length select { border-radius: 8px; border: 1px solid #ced4da; padding: 0.3rem 2rem 0.3rem 1rem; }
    .page-item.active .page-link { background-color: #0d6efd; border-color: #0d6efd; border-radius: 6px; }
    .page-link { border-radius: 6px; margin: 0 2px; color: #495057; border: none; }
    .page-link:hover { background-color: #f0f4ff; color: #0d6efd; }
    
    .custom-status-filter {
        border-radius: 8px;
        padding: 0.4rem 2rem 0.4rem 1rem;
        border: 1px solid #ced4da;
        background-color: #ffffff;
        font-weight: 600;
        color: #495057;
        cursor: pointer;
        transition: all 0.2s;
    }
    .custom-status-filter:focus { border-color: #86b7fe; box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1); outline: none; }
</style>

<!-- Header Halaman -->
<div class="row align-items-center mb-3">
    <div class="col-md-5">
        <h3 class="fw-bold mb-0 text-dark">
            <i class="bi bi-inbox text-primary me-2"></i> Daftar Tiket Masuk
        </h3>
        <p class="text-muted small mt-1 mb-0">Pantau, cari, dan kelola laporan masalah IT secara efisien.</p>
    </div>
    <div class="col-md-7 text-md-end mt-3 mt-md-0">
        <a href="<?= base_url('tickets/export' . (!empty($active_type) ? '?type='.$active_type : '')) ?>" class="btn btn-outline-success shadow-sm rounded-pill px-3 me-2 fw-semibold">
            <i class="bi bi-file-earmark-excel me-1"></i> Export Laporan
        </a>
        <a href="<?= base_url('tickets/create') ?>" class="btn btn-primary shadow-sm rounded-pill px-4 fw-semibold">
            <i class="bi bi-plus-lg me-1"></i> Catat Tiket Baru
        </a>
    </div>
</div>

<!-- BARIS FILTER -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
    <div class="d-flex gap-2 flex-wrap">
        <a href="<?= base_url('tickets') ?>" class="btn btn-sm <?= empty($active_type) ? 'btn-dark' : 'btn-outline-secondary bg-white text-muted' ?> rounded-pill px-4 py-2 shadow-sm fw-semibold" style="transition: all 0.2s;">
            Semua Data
        </a>
        <a href="<?= base_url('tickets?type=simrs') ?>" class="btn btn-sm <?= ($active_type == 'simrs') ? 'btn-danger' : 'btn-outline-danger bg-white text-danger' ?> rounded-pill px-4 py-2 shadow-sm fw-semibold" style="transition: all 0.2s;">
            <i class="bi bi-hospital"></i> Khusus SIMRS
        </a>
        <a href="<?= base_url('tickets?type=general') ?>" class="btn btn-sm <?= ($active_type == 'general') ? 'btn-primary' : 'btn-outline-primary bg-white text-primary' ?> rounded-pill px-4 py-2 shadow-sm fw-semibold" style="transition: all 0.2s;">
            <i class="bi bi-pc-display"></i> Khusus IT Umum
        </a>
    </div>
    <div class="d-flex align-items-center">
        <label class="me-2 small text-muted fw-bold text-nowrap"><i class="bi bi-funnel"></i> FILTER STATUS:</label>
        <select id="statusFilter" class="form-select form-select-sm custom-status-filter shadow-sm">
            <option value="">Semua Status</option>
            <option value="Open">Belum Dikerjakan (Open)</option>
            <option value="In Progress">Sedang Dikerjakan (In Progress)</option>
            <option value="Resolved">Menunggu Penutupan (Resolved)</option>
            <option value="Closed">Sudah Selesai (Closed)</option>
        </select>
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
    <div class="card-body p-4">
        <div class="table-responsive pb-2">
            <table id="ticketTable" class="table table-borderless align-middle table-custom mb-0 w-100">
                <thead>
                    <tr>
                        <th width="8%">ID Tiket</th>
                        <th width="12%">Waktu Lapor</th>
                        <th width="12%">Pelapor</th>
                        <th width="33%">Rincian Masalah</th>
                        <th width="8%" class="text-center">Prioritas</th>
                        <th width="10%" class="text-center">Status</th>
                        <th width="10%">Teknisi</th>
                        <th width="7%" class="text-center" data-orderable="false">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($tickets)) : ?>
                        <?php foreach ($tickets as $t) : ?>
                            <tr>
                                <td>
                                    <div class="fw-bold text-primary" style="font-size: 0.95rem;">#<?= $t['id'] ?></div>
                                </td>
                                
                                <td data-order="<?= $t['created_at'] ?>">
                                    <div class="fw-bold text-dark" style="font-size: 0.85rem;"><?= date('d M Y', strtotime($t['created_at'])) ?></div>
                                    <div class="text-muted" style="font-size: 0.75rem;"><i class="bi bi-clock"></i> <?= date('H:i', strtotime($t['created_at'])) ?> WITA</div>
                                </td>

                                <td>
                                    <div class="fw-bold text-dark" style="font-size: 0.9rem;"><?= esc($t['reporter_name']) ?></div>
                                    <div class="text-muted" style="font-size: 0.75rem;"><i class="bi bi-building"></i> <?= esc($t['reporter_department']) ?></div>
                                </td>

                                <!-- KOLOM MASALAH YANG SUDAH DIRAPIKAN -->
                                <td>
                                    <div class="d-flex flex-column justify-content-center">
                                        <!-- Baris Badge (Tipe & Kategori) -->
                                        <div class="mb-2 d-flex align-items-center flex-wrap gap-1">
                                            <?php if ($t['ticket_type'] === 'simrs') : ?>
                                                <span class="badge bg-danger text-white badge-tag shadow-sm"><i class="bi bi-hospital"></i> SIMRS</span>
                                            <?php else : ?>
                                                <span class="badge bg-primary text-white badge-tag shadow-sm"><i class="bi bi-pc-display"></i> IT UMUM</span>
                                            <?php endif; ?>
                                            <span class="badge bg-light text-secondary border badge-tag"><?= esc($t['category_name']) ?></span>
                                        </div>
                                        
                                        <!-- Judul Masalah (Lebih Besar & Bisa Diklik) -->
                                        <a href="<?= base_url('tickets/detail/'.$t['id']) ?>" class="ticket-title-link fw-bold" style="font-size: 0.95rem; line-height: 1.5;">
                                            <?= esc($t['title']) ?>
                                        </a>
                                    </div>
                                </td>

                                <td class="text-center">
                                    <?php if ($t['priority'] === 'high') : ?>
                                        <span class="badge badge-custom bg-danger-subtle text-danger border border-danger-subtle"><i class="bi bi-arrow-up-circle"></i> High</span>
                                    <?php elseif ($t['priority'] === 'medium') : ?>
                                        <span class="badge badge-custom bg-warning-subtle text-dark border border-warning-subtle">Medium</span>
                                    <?php else : ?>
                                        <span class="badge badge-custom bg-info-subtle text-dark border border-info-subtle"><i class="bi bi-arrow-down-circle"></i> Low</span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center">
                                    <?php if ($t['status'] === 'open') : ?>
                                        <span class="badge badge-custom bg-secondary text-uppercase shadow-sm">Open</span>
                                    <?php elseif ($t['status'] === 'in progress') : ?>
                                        <span class="badge badge-custom bg-primary text-uppercase shadow-sm">In Progress</span>
                                    <?php elseif ($t['status'] === 'resolved') : ?>
                                        <span class="badge badge-custom bg-info text-dark text-uppercase shadow-sm">Resolved</span>
                                    <?php else : ?>
                                        <span class="badge badge-custom bg-success text-uppercase shadow-sm">Closed</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php if (!empty($t['technician_name'])) : ?>
                                        <div class="d-flex align-items-center" title="<?= esc($t['technician_name']) ?>">
                                            <div class="avatar-sm shadow-sm flex-shrink-0">
                                                <?= strtoupper(substr($t['technician_name'], 0, 1)) ?>
                                            </div>
                                            <!-- Menyembunyikan nama teknisi jika ruang sempit, cukup tampilkan avatar -->
                                            <span class="fw-semibold text-dark ms-2 d-none d-xl-block" style="font-size: 0.85rem;"><?= esc($t['technician_name']) ?></span>
                                        </div>
                                    <?php else : ?>
                                        <span class="badge bg-light text-danger border fw-normal" style="font-size:0.7rem;"><i class="bi bi-person-x"></i> Kosong</span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center text-nowrap">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="<?= base_url('tickets/detail/'.$t['id']) ?>" class="btn btn-light text-primary btn-action shadow-sm" title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= base_url('tickets/edit/'.$t['id']) ?>" class="btn btn-light text-warning btn-action shadow-sm" title="Edit Laporan">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        var table = $('#ticketTable').DataTable({
            language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json' },
            order: [[1, 'desc']], 
            columnDefs: [{ orderable: false, targets: 7 }], 
            drawCallback: function () {
                $('.dataTables_paginate > .pagination').addClass('pagination-sm');
            }
        });

        $('#statusFilter').on('change', function() {
            table.column(5).search(this.value).draw();
        });
    });
</script>

<?= $this->endSection() ?>