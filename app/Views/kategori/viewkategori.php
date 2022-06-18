<?= $this->extend('main/layout') ?>;

<?= $this->section('judul') ?>
Manajemen Data Kategori
<?= $this->endSection('judul') ?>

<?= $this->section('subjudul') ?>


<?= form_button('', '<i class="fa fa-search-plus"></i> Tambah Data', [
    'class' => 'btn btn-primary',
    'onclick' => "location.href=('" . site_url('kategori/formtambah') . "')"
]) ?>

<?= $this->endSection('subjudul') ?>

<?= $this->section('isi') ?>

<?= session()->getFlashdata('sukses'); ?>

<?= form_open('kategori/index') ?>

<div class="input-group">
    <input type="text" class="form-control form-control-lg" placeholder="Masukkan Keyword" name="cari"
        value="<?= $cari; ?>">
    <div class="input-group-append">
        <button type="submit" class="btn btn-lg btn-secondary" id="tombolcari" name="tombolcari">
            <i class="fa fa-search"></i>
        </button>
    </div>
</div>
<br>
<?= form_close() ?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th style="width: 5%">No</th>
            <th>Nama Kategori</th>
            <th style="width: 30%">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $nomor = 1 + (($nohalaman - 1) * 5);
        foreach ($tampildata as $row) :

        ?>

        <tr>
            <td><?= $nomor++; ?></td>
            <td><?= $row['katnama1910021']; ?></td>
            <td>
                <button type="button" class="btn btn-info" title="Edit Data"
                    onclick="edit(<?= $row['katid1910021'] ?>)">
                    <i class="fa fa-edit"></i>
                </button>

                <form method="POST" action="/kategori/hapus/<?= $row['katid1910021'] ?>" style="display: inline;"
                    onsubmit=" return hapus();">
                    <input type="hidden" value="DELETE" name="_method">

                    <button type="submit" class="btn btn-danger" title="Hapus Data">
                        <i class="fa fa-trash-alt"></i>
                    </button>
                </form>

            </td>
        </tr>

        <?php endforeach; ?>
    </tbody>
</table>
<div class="float-center">
    <?= $pager->links('kategori', 'paging'); ?>
</div>
<script>
function edit(id) {
    window.location = ('/kategori/formedit/' + id);
}

function hapus() {
    pesan = confirm('Yakin Data Kategori Di Hapus ?');
    if (pesan) {
        return true;
    } else {
        return false;
    }
}
</script>

<?= $this->endSection('isi') ?>