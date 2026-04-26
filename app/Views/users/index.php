<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Kelola User IT<?= $this->endSection() ?>

<?= $this->section('content') ?>

<style>
    /* Menggunakan CSS Premium yang sama dengan Kategori */
    .table-custom th { font-size: 0.85rem; letter-spacing: 0.5px; text-transform: uppercase; color: #6c757d; border-bottom: 2px solid #edf2f6; padding-bottom: 1rem; }
    .table-custom td { padding: 1rem 0.75rem; border-bottom: 1px solid #edf2f6; color: #495057; vertical-align: middle; }
    .btn-action { border-radius: 8px; padding: 0.4rem 0.6rem; transition: all 0.2s; border: none;}
    .btn-action:hover { transform: translateY(-2px); }
    .avatar-md { width: 40px; height: 40px; background: linear-gradient(135deg, #0d6efd, #0043a8); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1rem; }
    .modal-content { border: none; border-radius: 15px; }
    .modal-header { border-bottom: 1px solid #edf2f6; padding: 1.5rem 1.5rem 1rem; }
    .modal-body, .modal-footer { padding: 1.5rem; }
    .modal-footer { border-top: none; padding-top: 0; }
    .form-control, .form-select { border-radius: 8px; padding: 0.6rem 1rem; border: 1px solid #ced4da; }
</style>

<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h3 class="fw-bold mb-0 text-dark">
            <i class="bi bi-people-fill text-primary me-2"></i> Data Teknisi & Admin
        </h3>
        <p class="text-muted small mt-1 mb-0">Kelola hak akses untuk tim IT yang menggunakan aplikasi ini.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <button type="button" class="btn btn-primary shadow-sm rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#userModal" onclick="clearForm()">
            <i class="bi bi-person-plus-fill me-1"></i> Tambah Anggota IT
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

<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 d-flex align-items-center" role="alert">
        <i class="bi bi-exclamation-triangle-fill fs-5 me-3"></i>
        <div><?= session()->getFlashdata('error') ?></div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm" style="border-radius: 15px;">
    <div class="card-body p-0">
        <div class="table-responsive px-4 pb-2">
            <table class="table table-borderless table-hover align-middle table-custom mb-0 mt-3">
                <thead>
                    <tr>
                        <th width="30%">Profil Anggota IT</th>
                        <th width="25%">Alamat Email</th>
                        <th width="20%">Hak Akses (Role)</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($users as $u): ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-md me-3 shadow-sm">
                                    <?= strtoupper(substr($u['name'], 0, 1)) ?>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark"><?= esc($u['name']) ?></div>
                                    <div class="text-muted" style="font-size: 0.8rem;">ID: #<?= $u['id'] ?></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="text-muted"><i class="bi bi-envelope me-1"></i> <?= esc($u['email']) ?></span>
                        </td>
                        <td>
                            <?php if($u['role'] == 'admin'): ?>
                                <span class="badge bg-dark rounded-pill px-3 py-2 shadow-sm"><i class="bi bi-shield-lock me-1"></i> Administrator</span>
                            <?php else: ?>
                                <span class="badge bg-info text-dark rounded-pill px-3 py-2 shadow-sm"><i class="bi bi-tools me-1"></i> Teknisi IT</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-light text-primary btn-action me-1 shadow-sm" title="Edit Anggota" onclick="editData(<?= $u['id'] ?>, '<?= htmlspecialchars($u['name'], ENT_QUOTES) ?>', '<?= htmlspecialchars($u['email'], ENT_QUOTES) ?>', '<?= $u['role'] ?>')" data-bs-toggle="modal" data-bs-target="#userModal">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <?php if($u['id'] != session()->get('id')): ?>
                                <a href="<?= base_url('users/delete/'.$u['id']) ?>" class="btn btn-light text-danger btn-action shadow-sm" title="Hapus Anggota" onclick="return confirm('Yakin ingin menghapus akses sistem untuk anggota ini?')">
                                    <i class="bi bi-trash3"></i>
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="userModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg">
            
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-dark" id="modalTitle">
                    <i class="bi bi-person-plus-fill text-primary me-2" id="modalIcon"></i> <span id="modalTitleText">Tambah Anggota IT</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <form action="<?= base_url('users/save') ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="id" id="userId">
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted small">NAMA LENGKAP</label>
                        <input type="text" class="form-control" name="name" id="userName" placeholder="Nama teknisi atau admin..." required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted small">ALAMAT EMAIL</label>
                        <input type="email" class="form-control" name="email" id="userEmail" placeholder="email@perusahaan.com" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted small">KATA SANDI (PASSWORD)</label>
                        <input type="password" class="form-control" name="password" id="userPassword" placeholder="Masukkan kata sandi...">
                        <small class="text-danger" id="passwordHelp">Biarkan kosong jika tidak ingin mengubah password saat mode Edit.</small>
                    </div>

                    <div class="mb-2">
                        <label class="form-label fw-semibold text-muted small">HAK AKSES (ROLE)</label>
                        <select class="form-select" name="role" id="userRole" required>
                            <option value="technician">Teknisi IT (Menangani Tiket)</option>
                            <option value="admin">Administrator (Akses Master Data)</option>
                        </select>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-light fw-semibold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-semibold px-4">Simpan Anggota</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function clearForm() {
        document.getElementById('modalTitleText').innerText = 'Tambah Anggota IT';
        document.getElementById('modalIcon').className = 'bi bi-person-plus-fill text-primary me-2';
        document.getElementById('userId').value = '';
        document.getElementById('userName').value = '';
        document.getElementById('userEmail').value = '';
        document.getElementById('userPassword').required = true; // Wajib diisi saat tambah baru
        document.getElementById('passwordHelp').style.display = 'none'; // Sembunyikan teks bantuan
        document.getElementById('userRole').value = 'technician';
    }

    function editData(id, name, email, role) {
        document.getElementById('modalTitleText').innerText = 'Edit Data Anggota';
        document.getElementById('modalIcon').className = 'bi bi-pencil-square text-warning me-2';
        document.getElementById('userId').value = id;
        document.getElementById('userName').value = name;
        document.getElementById('userEmail').value = email;
        document.getElementById('userPassword').required = false; // Tidak wajib diisi saat edit
        document.getElementById('passwordHelp').style.display = 'block'; // Tampilkan teks bantuan
        document.getElementById('userRole').value = role;
    }
</script>
<?= $this->endSection() ?>