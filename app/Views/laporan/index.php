<?= $this->extend('main/layout') ?>;

<?= $this->section('judul') ?>
Cetak Laporan
<?= $this->endSection('judul') ?>

<?= $this->section('subjudul') ?>

Silahkan Pilih Laporan Yang Ingin Di Cetak

<?= $this->endSection('subjudul') ?>


<?= $this->section('isi') ?>


<div class="row">
    <div class="col-lg-3">
        <button type="button" style="padding: 20px 20px;" class="btn btn-block btn-lg btn-success"
            onclick="window.location=('/laporan/cetak-barang-masuk')">
            <i class="fa fa-file text-danger"></i> LAPORAN BARANG MASUK
        </button>
    </div>
    <div class="col-lg-3">
        <button type="button" style="padding: 20px 20px;" class="btn btn-block btn-lg btn-primary"
            onclick="window.location=('/laporan/cetak-barang-keluar')">
            <i class="fa fa-file text-danger"></i> LAPORAN BARANG KELUAR
        </button>
    </div>
    <div class="col-lg-3">
        <button type="button" style="padding: 20px 20px;" class="btn btn-block btn-lg btn-primary"
            onclick="window.location=('/laporan/cetak-detail-barang-masuk')">
            <i class="fa fa-file text-danger"></i> LAPORAN DETAIL BARANG MASUK
        </button>
    </div>
    <div class="col-lg-3">
        <button type="button" style="padding: 20px 20px;" class="btn btn-block btn-lg btn-primary"
            onclick="window.location=('/laporan/cetak-detail-barang-keluar')">
            <i class="fa fa-file text-danger"></i> LAPORAN DETAIL BARANG KELUAR
        </button>
    </div>
</div>

<?= $this->endSection('isi') ?>