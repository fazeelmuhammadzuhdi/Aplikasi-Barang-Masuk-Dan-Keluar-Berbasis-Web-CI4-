<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Detail Barang Masuk</title>
</head>

<body onload="window.print();">
    <table style="width: 100%; border-collapse: collapse; text-align: center;" border="1">
        <tr>
            <td>
                <table style="width: 100%;" border="0">
                    <td>
                        <h1>Toko Fazeel</h1>
                    </td>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table style="width: 100%; text-align: center;" border="0">
                    <tr style="text-align: center;">
                        <td>
                            <h3><u> Laporan Detail Barang Masuk</u></h3><br>
                            Periode : <?= $tglawal . " s/ d " . $tglakhir; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <br>
                            <center>
                                <table border="1" celpadding="5"
                                    style="border-collapse: collapse; border: 1px solid #000; text-align: center; width: 80%;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No Faktur</th>
                                            <th>Tanggal</th>
                                            <th>Kategori</th>
                                            <th>Nama Barang</th>
                                            <th>Harga Beli</th>
                                            <th>Harga Jual</th>
                                            <th>Jumlah</th>
                                            <th>Total Harga (Rp)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $nomor = 1;
                                        $totalSeluruh = 0;
                                        foreach ($datalaporan->getResultArray() as $row) :
                                            $totalSeluruh += $row['detsubtotal1910021'];
                                        ?>
                                        <tr>
                                            <td><?= $nomor++; ?></td>
                                            <td><?= $row['faktur1910021'] ?></td>
                                            <td><?= $row['tglfaktur1910021'] ?></td>
                                            <td><?= $row['katnama1910021'] ?></td>
                                            <td><?= $row['brgnama1910021'] ?></td>
                                            <td style="text-align: right;">
                                                <?= number_format($row['dethargamasuk1910021'], 0, ",", ".") ?>
                                            </td>
                                            <td style="text-align: right;">
                                                <?= number_format($row['dethargajual1910021'], 0, ",", ".") ?>
                                            </td>
                                            <td style="text-align: right;">
                                                <?= number_format($row['detjml1910021'], 0, ",", ".") ?>
                                            </td>
                                            <td style="text-align: right;">
                                                <?= number_format($row['detsubtotal1910021'], 0, ",", ".") ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                    </tr>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="8">Total Seluruh Harga</th>
                            <td style="text-align: right;">
                                <?= number_format($totalSeluruh, 0, ",", ".") ?>
                            </td>
                        </tr>
                    </tfoot>
                </table>
                </center>
                <br>
            </td>
        </tr>
    </table>
    </td>
    </tr>
    </table>
</body>

</html>