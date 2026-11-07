<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Dashboard IT Log<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Custom CSS Dashboard -->
<style>
    .card-stat { transition: transform 0.2s ease-in-out; border-radius: 12px; }
    .card-stat:hover { transform: translateY(-5px); }
    .icon-background { font-size: 3.5rem; opacity: 0.15; position: absolute; right: 20px; top: 15px; }
    
    .welcome-banner-calm { background: linear-gradient(135deg, #0d6efd 0%, #0043a8 100%); border-radius: 15px; }
    .welcome-banner-alert { background: linear-gradient(135deg, #dc3545 0%, #900b17 100%); border-radius: 15px; }
    
    .table-recent td { vertical-align: middle; border-bottom: 1px solid #f0f2f5; padding: 1rem; }
    .list-group-item-custom { border-left: none; border-right: none; border-top: none; padding: 1rem 0; border-bottom: 1px solid #f0f2f5; }
    .list-group-item-custom:last-child { border-bottom: none; }
</style>

<!-- 1. BANNER SELAMAT DATANG CERDAS -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm text-white <?= ($tiket_open > 0) ? 'welcome-banner-alert' : 'welcome-banner-calm' ?>">
            <div class="card-body p-4 p-md-5">
                <div class="row align-items-center">
                    <div class="col-md-9">
                        <h2 class="fw-bold mb-3 d-flex align-items-center">
                            <?php if($tiket_open > 0): ?>
                                <i class="bi bi-exclamation-triangle-fill text-warning me-3 fs-1"></i> Ada <?= $tiket_open ?> Tiket Baru!
                            <?php else: ?>
                                <i class="bi bi-cup-hot-fill text-info me-3 fs-1"></i> Sistem Terkendali.
                            <?php endif; ?>
                        </h2>
                        <p class="lead mb-0" style="opacity: 0.9;">
                            <?php if($tiket_open > 0): ?>
                                Mohon segera periksa tabel tiket masuk. Karyawan sedang menunggu bantuan Anda untuk memastikan kelancaran pelayanan rumah sakit.
                            <?php else: ?>
                                Tidak ada masalah yang mengantre. Hari yang luar biasa! Waktunya menikmati kopi atau menyusun dokumentasi infrastruktur IT.
                            <?php endif; ?>
                        </p>
                    </div>
                    <div class="col-md-3 text-end d-none d-md-block">
                        <i class="bi <?= ($tiket_open > 0) ? 'bi-activity' : 'bi-shield-check' ?>" style="font-size: 6rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 2. BARIS WIDGET STATISTIK -->
<div class="row g-4 mb-4">
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 border-start border-primary border-4 shadow-sm card-stat h-100 position-relative overflow-hidden">
            <div class="card-body p-4">
                <div class="text-primary fw-bold text-uppercase mb-1" style="font-size: 0.75rem; letter-spacing: 1px;">Total Tiket Keseluruhan</div>
                <div class="h1 fw-bold text-dark mb-0"><?= $total_semua ?></div>
                <i class="bi bi-ticket-detailed text-primary icon-background"></i>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 border-start border-secondary border-4 shadow-sm card-stat h-100 position-relative overflow-hidden">
            <div class="card-body p-4">
                <div class="text-secondary fw-bold text-uppercase mb-1" style="font-size: 0.75rem; letter-spacing: 1px;">Belum Dikerjakan (Open)</div>
                <div class="h1 fw-bold text-dark mb-0"><?= $tiket_open ?></div>
                <i class="bi bi-inbox text-secondary icon-background"></i>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 border-start border-warning border-4 shadow-sm card-stat h-100 position-relative overflow-hidden">
            <div class="card-body p-4">
                <div class="text-warning fw-bold text-uppercase mb-1" style="font-size: 0.75rem; letter-spacing: 1px;">Sedang Dikerjakan</div>
                <div class="h1 fw-bold text-dark mb-0"><?= $in_progress ?></div>
                <i class="bi bi-tools text-warning icon-background"></i>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 border-start border-success border-4 shadow-sm card-stat h-100 position-relative overflow-hidden">
            <div class="card-body p-4">
                <div class="text-success fw-bold text-uppercase mb-1" style="font-size: 0.75rem; letter-spacing: 1px;">Telah Selesai</div>
                <div class="h1 fw-bold text-dark mb-0"><?= $selesai ?></div>
                <i class="bi bi-check-circle-fill text-success icon-background"></i>
            </div>
        </div>
    </div>
</div>

<!-- 3. MAIN DASHBOARD CONTENT -->
<div class="row g-4 mb-5">
    
    <!-- KOLOM KIRI (7): 5 TIKET TERBARU -->
    <div class="col-xl-7">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
            <div class="card-header bg-white border-0 pt-4 pb-2 px-4 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-lightning-charge text-warning me-2"></i>5 Aktivitas Terakhir</h5>
                <a href="<?= base_url('tickets') ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">Lihat Semua</a>
            </div>
            <div class="card-body px-4 pb-4 pt-2">
                <?php if(empty($latest_tickets)): ?>
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-3"></i> Belum ada laporan tiket.
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-borderless table-recent mb-0 w-100">
                            <tbody>
                                <?php foreach($latest_tickets as $t): ?>
                                    <tr>
                                        <td width="60%">
                                            <?php if ($t['ticket_type'] === 'simrs'): ?>
                                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-1 px-2 py-1 mb-2 d-inline-block" style="font-size: 0.6rem;">SIMRS</span>
                                            <?php else: ?>
                                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-1 px-2 py-1 mb-2 d-inline-block" style="font-size: 0.6rem;">IT UMUM</span>
                                            <?php endif; ?>
                                            <div class="fw-bold text-dark text-truncate" style="max-width: 250px; font-size: 0.95rem;" title="<?= esc($t['title']) ?>">
                                                <?= esc($t['title']) ?>
                                            </div>
                                            <div class="text-muted small mt-1"><i class="bi bi-person me-1"></i><?= esc($t['reporter_name']) ?> (<?= esc($t['reporter_department']) ?>)</div>
                                        </td>
                                        <td width="25%" class="text-center">
                                            <?php if ($t['status'] === 'open'): ?>
                                                <span class="badge bg-secondary rounded-pill px-3 py-2 w-100 text-uppercase" style="font-size: 0.65rem;">Open</span>
                                            <?php elseif ($t['status'] === 'in progress'): ?>
                                                <span class="badge bg-primary rounded-pill px-3 py-2 w-100 text-uppercase" style="font-size: 0.65rem;">In Progress</span>
                                            <?php elseif ($t['status'] === 'resolved'): ?>
                                                <span class="badge bg-info text-dark rounded-pill px-3 py-2 w-100 text-uppercase" style="font-size: 0.65rem;">Resolved</span>
                                            <?php else: ?>
                                                <span class="badge bg-success rounded-pill px-3 py-2 w-100 text-uppercase" style="font-size: 0.65rem;">Closed</span>
                                            <?php endif; ?>
                                        </td>
                                        <td width="15%" class="text-end">
                                            <a href="<?= base_url('tickets/detail/'.$t['id']) ?>" class="btn btn-sm btn-light text-primary fw-bold px-3 rounded-pill shadow-sm">Buka</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- KOLOM KANAN (5): GRAFIK & LEADERBOARD -->
    <div class="col-xl-5">
        
        <!-- Widget Donut Chart -->
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                <h6 class="fw-bold mb-0 text-dark text-uppercase" style="letter-spacing: 1px;"><i class="bi bi-pie-chart-fill text-primary me-2"></i>Komparasi Area Masalah</h6>
            </div>
            <div class="card-body p-4 d-flex justify-content-center align-items-center" style="min-height: 250px;">
                <?php if($simrs_count == 0 && $umum_count == 0): ?>
                    <span class="text-muted small">Data belum cukup untuk membuat grafik.</span>
                <?php else: ?>
                    <canvas id="ticketDonutChart" style="max-height: 220px;"></canvas>
                <?php endif; ?>
            </div>
        </div>

        <!-- Widget Leaderboard Ruangan -->
        <div class="card border-0 shadow-sm" style="border-radius: 15px;">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                <h6 class="fw-bold mb-0 text-dark text-uppercase" style="letter-spacing: 1px;"><i class="bi bi-trophy-fill text-warning me-2"></i>Top 5 Ruangan Komplain</h6>
            </div>
            <div class="card-body p-4 pt-3">
                <?php if(empty($top_departments)): ?>
                    <div class="text-muted small text-center">Belum ada data pelaporan.</div>
                <?php else: ?>
                    <ul class="list-group">
                        <?php 
                            $medals = ['🥇', '🥈', '🥉'];
                            foreach($top_departments as $index => $dept): 
                        ?>
                            <li class="list-group-item list-group-item-custom d-flex justify-content-between align-items-center">
                                <div class="fw-bold text-dark" style="font-size: 0.9rem;">
                                    <span class="me-2" style="font-size: 1.1rem;"><?= isset($medals[$index]) ? $medals[$index] : '🔹' ?></span> 
                                    <?= esc($dept['reporter_department']) ?>
                                </div>
                                <span class="badge bg-light text-dark border rounded-pill px-3 py-2 fw-bold shadow-sm">
                                    <?= $dept['total_reports'] ?> Laporan
                                </span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<!-- Load Chart.js dari Internet -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        <?php if($simrs_count > 0 || $umum_count > 0): ?>
            const ctx = document.getElementById('ticketDonutChart').getContext('2d');
            const ticketDonutChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['SIMRS (Software & Data)', 'IT UMUM (Hardware & Jaringan)'],
                    datasets: [{
                        data: [<?= $simrs_count ?>, <?= $umum_count ?>],
                        backgroundColor: ['#dc3545', '#0d6efd'], // Merah SIMRS, Biru IT UMUM
                        borderWidth: 0,
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%', // Membuat lubang donat agak besar dan modern
                    plugins: {
                        legend: { 
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                font: { family: "'Inter', sans-serif", size: 11, weight: '600' },
                                usePointStyle: true
                            }
                        }
                    }
                }
            });
        <?php endif; ?>
    });
</script>

<?= $this->endSection() ?>