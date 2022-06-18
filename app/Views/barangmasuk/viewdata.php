<?= $this->extend('main/layout') ?>;

<?= $this->section('judul') ?>
Data Transaksi Barang Masuk
<?= $this->endSection('judul') ?>

<?= $this->section('subjudul') ?>

<button type="button" class="btn btn-sm btn-primary" onclick="location.href=('/barangmasuk/index')">
    <i class="fa fa-plus-circle"> </i> Input Transaksi
</button>
<?= $this->endSection('subjudul') ?>

<?= $this->section('isi') ?>
<?= form_open('barangmasuk/data') ?>
<?= "<span class=\"badge badge-success\">Total Data : $totaldata</span>" ?>
<div class="input-group mb-3">
    <input type="text" class="form-control" placeholder="Cari Berdasarkan Faktur.." name="cari" value="<?= $cari ?>"
        autofocus="true">
    <div class="input-group-append">
        <button class="btn btn-outline-primary" type="submit" name="tombolcari">
            <i class="fa fa-search-plus"></i>
        </button>
    </div>
</div>
<?= form_close(); ?>
<table class="table table-sm table-bordered table-hover">
    <thead>
        <tr>
            <th>No</th>
            <th>Faktur</th>
            <th>Tanggal</th>
            <th>Jumlah Item</th>
            <th>Total Harga (Rp)</th>
            <th>#</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $nomor = 1 + (($nohalaman - 1) * 3);
        foreach ($tampildata as $row) :
        ?>

        <tr>
            <td><?= $nomor++; ?></td>
            <td><?= $row['faktur1910021']; ?></td>
            <td><?= date('d-m-Y', strtotime($row['tglfaktur1910021'])); ?></td>
            <td align="center">
                <?php
                    $db = \Config\Database::connect();

                    $jumlahItem = $db->table('detail_barangmasuk1910021')->where('detfaktur1910021', $row['faktur1910021'])->countAllResults();
                    ?>
                <span style="cursor: pointer; font-weight: bold; color: blue;"
                    onclick="detailItem('<?= $row['faktur1910021'] ?>')"><?= $jumlahItem; ?></span>
            </td>
            <td>
                <?= number_format($row['totalharga1910021'], 0, ",", ".") ?>
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-outline-info" title="Edit Transaksi"
                    onclick="edit('<?= sha1($row['faktur1910021']) ?>')">
                    <i class="fa fa-edit"></i>
                </button>
                &nbsp;
                <button type="button" class="btn btn-sm btn-outline-danger" title="Hapus Transaksi"
                    onclick="hapusTransaksi('<?= ($row['faktur1910021']) ?>')">
                    <i class="fa fa-trash-alt"></i>
                </button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div class="viewmodal" style="display: none;"></div>
<div class="float-left mt-4">
    <?= $pager->links('barangmasuk', 'paging') ?>
</div>
<script>
function hapusTransaksi(faktur) {
    Swal.fire({
        title: 'Hapus Transaksi',
        text: "Yakin Menghapus Transaksi Ini",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#FA04A0 ',
        cancelButtonColor: '#015E52',
        confirmButtonText: 'Ya, Hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "post",
                url: "/barangmasuk/hapusTransaksi",
                data: {
                    faktur: faktur
                },
                dataType: "json",
                success: function(response) {
                    if (response.sukses) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.sukses
                        }).then((result) => {
                            window.location.reload();
                        })
                    }
                },
                error: function(xhr, ajakOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });
        }
    })
}

function edit(faktur) {
    window.location.href = ('/barangmasuk/edit/') + faktur;
}

function detailItem(faktur) {
    $.ajax({
        type: "post",
        url: "/barangmasuk/detailItem",
        data: {
            faktur: faktur
        },
        dataType: "json",
        success: function(response) {
            if (response.data) {
                $('.viewmodal').html(response.data).show();
                $('#modalitem').modal('show');
            }
        },
        error: function(xhr, ajakOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
        }
    });
}
</script>
<?= $this->endSection('isi') ?>