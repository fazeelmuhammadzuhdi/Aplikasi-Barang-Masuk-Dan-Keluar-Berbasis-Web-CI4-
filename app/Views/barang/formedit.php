<?= $this->extend('main/layout') ?>

<?= $this->section('judul') ?>
Form Edit Barang
<?= $this->endSection('judul') ?>

<?= $this->section('subjudul') ?>

<button type="button" class="btn btn-sm btn-warning" onclick="location.href=('/barang/index')">
    <i class="fa fa-backward"></i> Kembali
</button>

<?= $this->endSection('subjudul') ?>


<?= $this->section('isi') ?>
<?= form_open_multipart('barang/updatedata') ?>
<?= session()->getFlashdata('error'); ?>
<?= session()->getFlashdata('sukses'); ?>
<div class="form-group row">
    <label for="" class="col-sm-4 col-form-label">Kode Barang</label>
    <div class="col-sm-8">
        <input type="text" class="form-control" id="kodebarang" name="kodebarang" readonly value="<?= $kodebarang; ?>">
    </div>
</div>

<div class="form-group row">
    <label for="" class="col-sm-4 col-form-label">Nama Barang</label>
    <div class="col-sm-8">
        <input type="text" class="form-control" id="namabarang" name="namabarang" value="<?= $namabarang; ?>">
    </div>
</div>

<div class="form-group row">
    <label for="" class="col-sm-4 col-form-label">Pilih Kategori</label>
    <div class="col-sm-4">
        <select name="kategori" id="kategori" class="form-control">
            <?php foreach ($datakategori as $kat) : ?>

            <?php if ($kat['katid1910021'] == $kategori) : ?>

            <option selected value="<?= $kat['katid1910021'] ?>"><?= $kat['katnama1910021'] ?></option>

            <?php else : ?>

            <option value="<?= $kat['katid1910021'] ?>"><?= $kat['katnama1910021'] ?></option>
            <?php endif; ?>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<div class="form-group row">
    <label for="" class="col-sm-4 col-form-label">Pilih Satuan</label>
    <div class="col-sm-4">
        <select name="satuan" id="satuan" class="form-control">
            <option selected value="">=Pilih=</option>
            <?php foreach ($datasatuan as $sat) : ?>

            <?php if ($sat['satid1910021'] == $satuan) : ?>
            <option selected value="<?= $sat['satid1910021'] ?>"><?= $sat['satnama1910021'] ?></option>
            <?php else : ?>
            <option value="<?= $sat['satid1910021'] ?>"><?= $sat['satnama1910021'] ?></option>
            <?php endif; ?>

            <?php endforeach; ?>
        </select>
    </div>
</div>

<div class="form-group row">
    <label for="" class="col-sm-4 col-form-label">Harga</label>
    <div class="col-sm-4">
        <input type="number" class="form-control" id="harga" name="harga" value="<?= $harga; ?>">
    </div>
</div>

<div class="form-group row">
    <label for="" class="col-sm-4 col-form-label">Stok</label>
    <div class="col-sm-4">
        <input type="number" class="form-control" id="stok" name="stok" value="<?= $stok; ?>">
    </div>
</div>

<div class="form-group row">
    <label for="" class="col-sm-4 col-form-label">Gambar yang Sudah Ada</label>
    <div class="col-sm-4">
        <img src="<?= base_url() . '/' . $gambar ?>" class="img-thumbnail" style="width: 50%;" alt="Gambar Barang">
    </div>
</div>

<div class="form-group row">
    <label for="" class="col-sm-4 col-form-label">Upload Gambar (<i>Jika Diganti...</i>)</label>
    <div class="col-sm-4">
        <input type="file" id="gambar" name="gambar">
    </div>
</div>

<div class="form-group row">
    <label for="" class="col-sm-4 col-form-label"></label>
    <div class="col-sm-4">
        <input type="submit" value="Simpan" class="btn btn-success">
    </div>
</div>
<?= form_close(); ?>

<?= $this->endSection('isi'); ?>