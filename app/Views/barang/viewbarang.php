<?= $this->extend('main/layout') ?>

<?= $this->section('judul') ?>
Manajemen Data Barang
<?= $this->endSection('judul') ?>

<?= $this->section('subjudul') ?>

<button type="button" class="btn btn-sm btn-primary" onclick="location.href=('/barang/tambah')">
    <i class="fa fa-plus-circle"></i> Tambah Barang
</button>

<?= $this->endSection('subjudul') ?>


<?= $this->section('isi') ?>
<?= session()->getFlashdata('error'); ?>
<?= session()->getFlashdata('sukses'); ?>
<?= form_open('barang/index') ?>
<div class="input-group mb-3">
    <input type="text" class="form-control" placeholder="Cari Data Berdasarkan Kode, Nama Barang & Kategori" name="cari"
        autofocus value="<?= $cari ?>">
    <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="submit" name="tombolcari">
            <i class="fa fa-search"></i>
        </button>
    </div>
</div>
<?= form_close(); ?>
<span class="badge badge-success">
    <h5>
        <?= "Total Data : $totaldata"; ?>
    </h5>
</span>
<br>
<table class="table table-striped table-bordered" style="width:100%;">
    <thead>
        <tr>
            <th style="width: 5%;">No</th>
            <th>kode Barang</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Satuan</th>
            <th>Harga</th>
            <th>Stok</th>
            <th style="width: 15%;">Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $nomor = 1 + (($nohalaman - 1) * 3);
        foreach ($tampildata as $row) :
        ?>

        <tr>
            <td><?= $nomor++; ?></td>
            <td><?= $row['brgkode1910021']; ?></td>
            <td><?= $row['brgnama1910021']; ?></td>
            <td><?= $row['katnama1910021']; ?></td>
            <td><?= $row['satnama1910021']; ?></td>
            <td><?= number_format($row['brgharga1910021'], 0); ?></td>
            <td><?= number_format($row['brgstok1910021'], 0); ?></td>
            <td>

                <button type="button" class="btn btn-sm btn-info" onclick="edit('<?= $row['brgkode1910021'] ?>')">
                    <i class="fa fa-edit"></i>
                </button>

                <form method="POST" action="/barang/hapus/<?= $row['brgkode1910021'] ?>" style="display:inline;"
                    onsubmit="return hapus();">
                    <input type="hidden" value="DELETE" name="_method">

                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus Data ">
                        <i class="fa fa-trash-alt"></i>
                    </button>
                </form>


            </td>
        </tr>

        <?php endforeach; ?>
    </tbody>
</table>
<div class="float-left mt-4">
    <?= $pager->links('barang', 'paging') ?>
</div>
<script>
function edit(kode) {
    window.location.href = ('/barang/edit/' + kode);
}

function hapus(kode) {
    pesan = confirm('Yakin Data Barang ini Dhapus ?');
    if (pesan) {
        return true;
    } else {
        return false;
    }
}
</script>
<?= $this->endSection('isi') ?>