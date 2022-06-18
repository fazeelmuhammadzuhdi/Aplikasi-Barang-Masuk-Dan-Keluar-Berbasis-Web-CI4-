<table class="table table-sm table-hover table-bordered" style="width: 100%;">
    <thead>
        <tr>

            <th colspan="5"></th>
            <th colspan="2" style="text-align: center;">

                <?php
                $totalHarga = 0;
                foreach ($tampildata->getResultArray() as $row) :
                    $totalHarga += $row['detsubtotal1910021'];
                endforeach;
                ?>
                <h1> <?= number_format($totalHarga, 0, ",", ".") ?> </h1>
                <input type="hidden" id="totalharga" value="<?= $totalHarga; ?>">
            </th>
        </tr>
    </thead>
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Harga Jual</th>
            <th>Jml</th>
            <th>Sub.Total</th>
            <th>#</th>
        </tr>

    </thead>
    <tbody>
        <?php
        $nomor = 1;
        foreach ($tampildata->getResultArray() as $row) :
        ?>
        <tr>
            <td><?= $nomor++; ?></td>
            <td><?= $row['detbrgkode1910021']; ?></td>
            <td><?= $row['brgnama1910021']; ?></td>
            <td style="text-align: right;">
                <?= number_format($row['dethargajual1910021'], 0, ",", ".") ?>
            </td>
            <td style="text-align: right;">
                <?= number_format($row['detjml1910021'], 0, ",", ".") ?>
            </td>
            <td style="text-align: right;">
                <?= number_format($row['detsubtotal1910021'], 0, ",", ".") ?>
            </td>
            <td style="text-align: right;">
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="hapusItem('<?= $row['id'] ?>')">
                    <i class="fa fa-trash-restore-alt"></i>
                </button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<script>
function hapusItem(id) {
    Swal.fire({
        title: 'Hapus Item',
        text: "Yakin Hapus Item Ini",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#015755 ',
        cancelButtonColor: '#620C4D',
        confirmButtonText: 'Ya, Hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "post",
                url: "/barangkeluar/hapusItem",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(response) {
                    if (response.sukses) {
                        Swal.fire('berhasil', response.sukses, 'success');
                        tampilDataTemp();
                        kosong();
                    }
                },
                error: function(xhr, ajakOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });
        }
    })
}
</script>