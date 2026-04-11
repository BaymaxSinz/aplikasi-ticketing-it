<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="p-5 mb-4 bg-white border rounded-3 shadow-sm">
            <h2>Selamat Datang, <?= session()->get('name') ?>!</h2>
            <p class="lead">Ini adalah sistem Internal IT Log untuk mencatat dan mengelola laporan masalah IT.</p>
            <hr class="my-4">
            <p>Gunakan menu di atas untuk mulai mencatat tiket baru atau melihat laporan.</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card text-white bg-primary mb-3 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Total Semua Tiket</h5>
                <p class="card-text fs-2 fw-bold"><?= $total_semua ?></p> </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-warning mb-3 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Tiket In Progress</h5>
                <p class="card-text fs-2 fw-bold"><?= $in_progress ?></p> </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-success mb-3 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Tiket Selesai</h5>
                <p class="card-text fs-2 fw-bold"><?= $selesai ?></p> </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>