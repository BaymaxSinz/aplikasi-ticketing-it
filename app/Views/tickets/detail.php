<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Detail Tiket #<?= $ticket['id'] ?><?= $this->endSection() ?>

<?= $this->section('content') ?>

<style>
    /* Kustomisasi Card & UI Premium */
    .card-detail { border: none; border-radius: 15px; }
    .card-header-custom { background-color: transparent; border-bottom: 1px solid #edf2f6; padding: 1.5rem 1.5rem 1rem; font-weight: 700; color: #2c3e50; }
    .meta-box { background-color: #f8f9fa; border: 1px solid #edf2f6; border-radius: 10px; padding: 1rem; height: 100%; }
    .meta-label { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; color: #6c757d; font-weight: 600; margin-bottom: 0.3rem; }
    .meta-value { font-weight: 600; color: #2b3440; font-size: 0.95rem; }
    .desc-box { background-color: #fcfcfc; border-left: 4px solid #0d6efd; border-radius: 0 10px 10px 0; padding: 1.5rem; color: #495057; line-height: 1.7; }
    .badge-status { padding: 0.5rem 1rem; border-radius: 50px; font-weight: 600; letter-spacing: 0.5px; }
    .form-label-custom { font-size: 0.8rem; font-weight: 600; letter-spacing: 0.5px; text-transform: uppercase; color: #6c757d; }
    .form-control, .form-select { border-radius: 8px; padding: 0.6rem 1rem; }
</style>

<div class="row align-items-center mb-4">
    <div class="col-md-8">
        <h3 class="fw-bold mb-0 text-dark d-flex align-items-center">
            <i class="bi bi-ticket-detailed text-primary me-2"></i> 
            Tiket #<?= $ticket['id'] ?>
        </h3>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <a href="<?= base_url('tickets') ?>" class="btn btn-light shadow-sm fw-semibold rounded-pill px-4">
            <i class="bi bi-arrow-left me-1"></i> Kembali
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

<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card shadow-sm card-detail h-100">
            <div class="card-body p-4 p-md-5">
                
                <h4 class="fw-bold text-dark mb-4 pb-3 border-bottom">
                    <?= esc($ticket['title']) ?>
                </h4>
                
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="meta-box">
                            <div class="meta-label"><i class="bi bi-person me-1"></i> Pelapor</div>
                            <div class="meta-value"><?= esc($ticket['reporter_name']) ?></div>
                            <div class="text-muted small"><?= esc($ticket['reporter_department']) ?></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="meta-box">
                            <div class="meta-label"><i class="bi bi-clock me-1"></i> Waktu Lapor</div>
                            <div class="meta-value"><?= date('d M Y', strtotime($ticket['created_at'])) ?></div>
                            <div class="text-muted small"><?= date('H:i', strtotime($ticket['created_at'])) ?> WIB</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="meta-box">
                            <div class="meta-label"><i class="bi bi-tags me-1"></i> Kategori</div>
                            <div class="meta-value text-primary"><?= esc($ticket['category_name']) ?></div>
                        </div>
                    </div>
                </div>

                <h6 class="fw-bold text-dark mt-5 mb-3">
                    <i class="bi bi-justify-left text-muted me-2"></i> Deskripsi & Kronologi Masalah
                </h6>
                <div class="desc-box shadow-sm">
                    <p class="mb-0" style="white-space: pre-line; font-size: 0.95rem;">
                        <?= esc($ticket['description']) ?>
                    </p>
                </div>
                
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-4">
        <div class="card shadow-sm card-detail h-100">
            <div class="card-header card-header-custom">
                <i class="bi bi-lightning-charge text-warning me-2"></i> Panel Penanganan
            </div>
            <div class="card-body p-4 bg-white" style="border-radius: 0 0 15px 15px;">
                
                <div class="mb-4 text-center p-3 bg-light rounded-3 border">
                    <label class="text-muted small d-block mb-2 fw-semibold">STATUS SAAT INI</label>
                    <?php 
                        $statusClass = 'bg-secondary';
                        if($ticket['status'] == 'in progress') $statusClass = 'bg-primary';
                        if($ticket['status'] == 'resolved') $statusClass = 'bg-info text-dark';
                        if($ticket['status'] == 'closed') $statusClass = 'bg-success';
                    ?>
                    <span class="badge <?= $statusClass ?> badge-status text-uppercase fs-6 shadow-sm">
                        <?= $ticket['status'] ?>
                    </span>
                </div>
                
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-end mb-2">
                        <label class="form-label-custom mb-0">DITUGASKAN KEPADA:</label>
                        <?php if(session()->get('role') == 'admin'): ?>
                            <button type="button" class="btn btn-sm btn-outline-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#assignModal" style="font-size: 0.7rem; padding: 0.2rem 0.5rem; border-radius: 6px;" title="Super Override">
                                <i class="bi bi-shield-lock"></i> Ubah
                            </button>
                        <?php endif; ?>
                    </div>
                    
                    <div class="d-flex align-items-center mt-1">
                        <?php if($ticket['technician_name']): ?>
                            <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-2 shadow-sm" style="width: 35px; height: 35px; font-weight: bold;">
                                <?= strtoupper(substr($ticket['technician_name'], 0, 1)) ?>
                            </div>
                            <span class="fw-bold fs-6 text-dark"><?= esc($ticket['technician_name']) ?></span>
                        <?php else: ?>
                            <div class="bg-light text-muted rounded-circle d-flex justify-content-center align-items-center me-2 border" style="width: 35px; height: 35px;">
                                <i class="bi bi-person-x"></i>
                            </div>
                            <span class="text-danger fw-semibold fst-italic">Belum Ditugaskan</span>
                        <?php endif; ?>
                    </div>
                </div>

                <hr class="my-4" style="border-color: #edf2f6;">

                <?php if(!$ticket['technician_id']): ?>
                    <div class="d-grid mt-4">
                        <a href="<?= base_url('tickets/take/'.$ticket['id']) ?>" class="btn btn-success btn-lg shadow-sm rounded-pill fw-bold" onclick="return confirm('Anda yakin ingin mengambil alih penanganan tiket ini?')">
                            <i class="bi bi-person-check-fill me-1"></i> Ambil Tiket Ini
                        </a>
                        <small class="text-center text-muted mt-2">Klik tombol di atas untuk mulai mengerjakan.</small>
                    </div>
                
                <?php elseif($ticket['technician_id'] == session()->get('id') && $ticket['status'] != 'closed'): ?>
                    <form action="<?= base_url('tickets/update-status') ?>" method="post">
                        <input type="hidden" name="id" value="<?= $ticket['id'] ?>">
                        
                        <div class="mb-3">
                            <label class="form-label form-label-custom">UPDATE STATUS</label>
                            <select class="form-select shadow-sm" name="status" required>
                                <option value="in progress" <?= ($ticket['status'] == 'in progress') ? 'selected' : '' ?>>In Progress (Sedang Dikerjakan)</option>
                                <option value="resolved" <?= ($ticket['status'] == 'resolved') ? 'selected' : '' ?>>Resolved (Ditemukan Solusi)</option>
                                <option value="closed" <?= ($ticket['status'] == 'closed') ? 'selected' : '' ?>>Closed (Tutup Tiket)</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label form-label-custom">CATATAN PENYELESAIAN</label>
                            <textarea class="form-control shadow-sm" name="resolution_note" rows="4" placeholder="Tuliskan solusi yang dilakukan agar dapat menjadi dokumentasi..." <?= ($ticket['status'] == 'closed') ? 'readonly' : '' ?>><?= esc($ticket['resolution_note']) ?></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary shadow-sm fw-semibold py-2">
                                <i class="bi bi-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                
                <?php else: ?>
                    <div class="alert <?= ($ticket['status'] == 'closed') ? 'alert-success' : 'alert-info' ?> border-0 shadow-sm mt-3">
                        <?php if($ticket['status'] == 'closed'): ?>
                            <h6 class="fw-bold mb-2"><i class="bi bi-check-all me-1"></i> Tiket Telah Ditutup</h6>
                            <p class="small mb-1 text-muted">Solusi yang diterapkan:</p>
                            <div class="p-2 bg-white rounded border small text-dark" style="font-style: italic;">
                                <?= $ticket['resolution_note'] ? esc($ticket['resolution_note']) : 'Tidak ada catatan.' ?>
                            </div>
                        <?php else: ?>
                            <i class="bi bi-info-circle-fill me-1"></i> Tiket ini sedang ditangani oleh teknisi lain. Anda hanya dapat memantau statusnya.
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<?php if(session()->get('role') == 'admin'): ?>
<div class="modal fade" id="assignModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg card-detail">
            
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold text-dark">
                    <i class="bi bi-shield-lock text-primary me-2"></i> Super Override
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <form action="<?= base_url('tickets/assign') ?>" method="post">
                <div class="modal-body px-4 pt-3">
                    <input type="hidden" name="ticket_id" value="<?= $ticket['id'] ?>">
                    <p class="text-muted small mb-4">Ubah teknisi penanggung jawab atau paksa ubah status tiket ini secara langsung.</p>
                    
                    <div class="mb-3">
                        <label class="form-label form-label-custom">PILIH ANGGOTA IT</label>
                        <select class="form-select shadow-sm" name="technician_id" required>
                            <option value="" disabled selected>-- Pilih Teknisi --</option>
                            <?php foreach($technicians as $tech): ?>
                                <option value="<?= $tech['id'] ?>" <?= ($tech['id'] == $ticket['technician_id']) ? 'selected' : '' ?>>
                                    <?= esc($tech['name']) ?> (<?= ucfirst($tech['role']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label form-label-custom">PAKSA UBAH STATUS</label>
                        <select class="form-select shadow-sm" name="status" required>
                            <option value="open" <?= ($ticket['status'] == 'open') ? 'selected' : '' ?>>Open (Belum Dikerjakan)</option>
                            <option value="in progress" <?= ($ticket['status'] == 'in progress') ? 'selected' : '' ?>>In Progress (Sedang Dikerjakan)</option>
                            <option value="resolved" <?= ($ticket['status'] == 'resolved') ? 'selected' : '' ?>>Resolved (Ditemukan Solusi)</option>
                            <option value="closed" <?= ($ticket['status'] == 'closed') ? 'selected' : '' ?>>Closed (Tutup Tiket)</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label class="form-label form-label-custom">CATATAN PENYELESAIAN</label>
                        <textarea class="form-control shadow-sm" name="resolution_note" rows="3" placeholder="Isi jika status diubah ke Selesai/Closed..."><?= esc($ticket['resolution_note']) ?></textarea>
                    </div>
                </div>
                
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-light fw-semibold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-semibold px-4">Terapkan</button>
                </div>
            </form>
            
        </div>
    </div>
</div>
<?php endif; ?>

<?= $this->endSection() ?>