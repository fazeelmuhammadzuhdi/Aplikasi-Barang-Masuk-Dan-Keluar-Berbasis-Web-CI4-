<?= $this->extend('main/layout') ?>;

<?= $this->section('judul') ?>
Edit Barang Keluar
<?= $this->endSection('judul') ?>

<?= $this->section('subjudul') ?>

<button type="button" class="btn btn-sm btn-warning" onclick="location.href=('/barangkeluar/data')">
    <i class="fa fa-undo-alt"> </i> Kembali
</button>
<?= $this->endSection('subjudul') ?>

<?= $this->section('isi') ?>

<style>
table#datadetail tbody tr:hover {
    cursor: pointer;
    background-color: red;
    color: #fff;
}
</style>

<table class="table table-sm table-striped table-hover" style="width: 100%;">
    <tr>
        <input type="hidden" id="nofaktur" value="<?= $nofaktur; ?>">
        <td style="width: 20%;">No.Faktur</td>
        <td style="width: 2%;">:</td>
        <td style="width: 20%;"><?= $nofaktur; ?></td>
        <td rowspan="3"
            style="width: 50%; font-weight: bold; color: red; font-size: 25pt; text-align: center; vertical-align: middle;"
            id="lbTotalHarga">
        </td>
    </tr>
    <tr>
        <td style="width: 20%;">Tanggal Faktur</td>
        <td style="width: 2%;">:</td>
        <td style="width: 20%;"><?= date('d-m-Y', strtotime($tanggal)) ?></td>
    </tr>

    <tr>
        <td style="width: 20%;">Pelanggan</td>
        <td style="width: 2%;">:</td>
        <td style="width: 20%;"><?= $namapelanggan ?></td>
    </tr>

</table>

<div class="card">
    <div class="card-header bg-danger">
        Input Barang Keluar
    </div>

    <div class="card-body">
        <div class="form-row">

            <div class="form-group col-md-3">

                <label for="">Kode Barang</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Kode Barang" name="kodebarang" id="kodebarang">
                    <div class="input-group-append">
                        <input type="hidden" id="iddetail">
                        &nbsp;
                        <button class="btn btn-outline-primary" type="button" id="tombolCariBarang">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="form-group col-md-3">
                <label for="">Nama Barang</label>
                <input type="text" class="form-control" name="namabarang" id="namabarang" readonly>
            </div>
            <div class="form-group col-md-2">
                <label for="">Harga Jual (Rp)</label>
                <input type="text" class="form-control" name="hargajual" id="hargajual" readonly>
            </div>

            <div class="form-group col-md-2">
                <label for="">Qty</label>
                <input type="number" class="form-control" name="jml" id="jml" value="1">
            </div>
            <div class="form-group col-md-2">
                <label for="">#</label>
                <div class="input-group">
                    <button type="button" class="btn btn-sm btn-success" title="Simpan Item" id="tombolSimpanItem">
                        <i class="fa fa-save"></i>
                    </button>&nbsp;

                    <button type="button" style="display: none;" class="btn btn-sm btn-primary" title="Edit Item"
                        id="tombolEditItem">
                        <i class="fa fa-edit"></i>
                    </button>&nbsp;

                    <button type="button" style="display: none;" class="btn btn-sm btn-secondary" title="Batalkan"
                        id="tombolBatal">
                        <i class="fa fa-sync-alt"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 tampilDataDetail">

    </div>
</div>
<div class="viewmodal" style="display: none;"></div>
<script>
function ambilDataBarang() {
    let kodebarang = $('#kodebarang').val();
    if (kodebarang.length == 0) {
        Swal.fire('Error', 'Kode Barang Harus Diinputkan', 'error');
        kosong();
    } else {
        $.ajax({
            type: "post",
            url: "/barangkeluar/ambilDataBarang",
            data: {
                kodebarang: kodebarang
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    let data = response.sukses;
                    $('#namabarang').val(data.namabarang);
                    $('#hargajual').val(data.hargajual);

                    $('#jml').focus();
                }

                if (response.error) {
                    Swal.fire('Error', response.error, 'error');
                    kosong();
                }
            },
            error: function(xhr, ajakOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }
}

function ambilTotalHarga() {
    let nofaktur = $('#nofaktur').val();

    $.ajax({
        type: "post",
        url: "/barangkeluar/ambilTotalHarga",
        data: {
            nofaktur: nofaktur
        },
        dataType: "json",
        success: function(response) {
            $('#lbTotalHarga').html(response.totalharga);
        },
        error: function(xhr, ajakOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
        }
    });
}

function kosong() {
    $('#kodebarang').val('');
    $('#namabarang').val('');
    $('#hargajual').val('');
    $('#jml').val('1');
    $('#kodebarang').focus();
}

function tampilDataDetail() {
    let nofaktur = $('#nofaktur').val();

    $.ajax({
        type: "post",
        url: "/barangkeluar/tampilDataDetail",
        data: {
            nofaktur: nofaktur
        },
        dataType: "json",
        beforeSend: function() {
            $('.tampilDataDetail').html("<i class='fa fa-spin fa-spinner'></i>");
        },
        success: function(response) {
            if (response.data) {
                $('.tampilDataDetail').html(response.data);
            }
        },
        error: function(xhr, ajakOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
        }
    });
}

function simpanItem() {
    let nofaktur = $('#nofaktur').val();
    let kodebarang = $('#kodebarang').val();
    let namabarang = $('#namabarang').val();
    let hargajual = $('#hargajual').val();
    let jml = $('#jml').val();

    if (kodebarang.length == 0) {
        Swal.fire('Error', 'Kode Barang Harus Diinputkan', 'error');
    } else {
        $.ajax({
            type: "post",
            url: "/barangkeluar/simpanItemDetail",
            data: {
                nofaktur: nofaktur,
                kodebarang: kodebarang,
                namabarang: namabarang,
                jml: jml,
                hargajual: hargajual
            },
            dataType: "json",
            success: function(response) {
                if (response.error) {
                    Swal.fire('Error', response.error, 'error');
                    kosong();
                }
                if (response.sukses) {
                    Swal.fire('berhasil', response.sukses, 'success');
                    tampilDataDetail();
                    ambilTotalHarga();
                    kosong();
                }
            },
            error: function(xhr, ajakOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }
}


$(document).ready(function() {
    ambilTotalHarga();
    tampilDataDetail();

    $('#tombolSimpanItem').click(function(e) {
        e.preventDefault();
        simpanItem();
    });

    $('#tombolCariBarang').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: "/barangkeluar/modalCariBarang",
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.viewmodal').html(response.data).show();
                    $('#modalcaribarang').modal('show');
                }
            },
            error: function(xhr, ajakOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    });

    $('#tombolEditItem').click(function(e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: "/barangkeluar/editItem",
            data: {
                iddetail: $('#iddetail').val(),
                jml: $('#jml').val()
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    Swal.fire({
                        'icon': 'success',
                        'tittle': 'Berhasil',
                        'text': response.sukses
                    });
                    tampilDataDetail();
                    ambilTotalHarga();
                    kosong();
                    $('#kodebarang').prop('readonly', false);
                    $('#tombolCariBarang').prop('disabled', false);
                    $('#tombolSimpanItem').fadeIn();
                    $('#tombolEditItem').fadeOut();
                    $('#tombolBatal').fadeOut();
                }
            },
            error: function(xhr, ajakOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }

        });
    });
});
</script>

<?= $this->endSection('isi') ?>