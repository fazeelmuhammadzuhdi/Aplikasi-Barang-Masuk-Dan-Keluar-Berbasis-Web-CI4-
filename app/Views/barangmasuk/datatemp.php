<table class="table table-sm table-striped table-hover">
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Harga Jual</th>
            <th>Harga Beli</th>
            <th>Jumlah</th>
            <th>Sub Total</th>
            <th>#</th>
        </tr>

    </thead>
    <tbody>
        <?php
        $nomor = 1;
        foreach ($datatemp->getResultArray() as $row) :
        ?>
        <tr>
            <td><?= $nomor++; ?></td>
            <td><?= $row['brgkode1910021']; ?></td>
            <td><?= $row['brgnama1910021']; ?></td>
            <td style="text-align: right;">
                <?= number_format($row['dethargajual1910021'], 0, ",", ".") ?>
            </td>
            <td style="text-align: right;">
                <?= number_format($row['dethargamasuk1910021'], 0, ",", ".") ?>
            </td>
            <td style="text-align: right;">
                <?= number_format($row['detjml1910021'], 0, ",", ".") ?>
            </td>
            <td style="text-align: right;">
                <?= number_format($row['detsubtotal1910021'], 0, ",", ".") ?>
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-outline-danger"
                    onclick="hapusItem('<?= $row['iddetail1910021'] ?>')">
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
        confirmButtonColor: '#04FC1D ',
        cancelButtonColor: '#F0FF00',
        confirmButtonText: 'Ya, Hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "post",
                url: "/barangmasuk/hapus",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(response) {
                    if (response.sukses) {
                        dataTemp();
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses...',
                            text: 'Item Berhasil Di Hapus!',
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
</script>