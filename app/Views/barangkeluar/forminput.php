<?= $this->extend('main/layout') ?>;

<?= $this->section('judul') ?>
Input Transaksi Barang Keluar
<?= $this->endSection('judul') ?>

<?= $this->section('subjudul') ?>

<button type="button" class="btn btn-sm btn-warning" onclick="location.href=('/barangkeluar/data')">
    <i class="fa fa-undo-alt"> </i> Kembali
</button>

<?= $this->endSection('subjudul') ?>


<?= $this->section('isi') ?>

<div class="form-row">
    <div class="form-group col-lg-4">
        <label for="">No.Faktur</label>
        <input type="text" class="form-control" placeholder="No Faktur" name="nofaktur" value="<?= $nofaktur ?>"
            id="nofaktur" readonly>
    </div>
    <div class="form-group col-lg-4">
        <label for="">Tanggal Faktur</label>
        <input type="date" class="form-control" name="tglfaktur" id="tglfaktur" value="<?= date('Y-m-d') ?>">
    </div>
    <div class="form-group col-lg-4">
        <label for="">Cari Pelanggan</label>
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Nama Pelanggan" name="namapelanggan" id="namapelanggan"
                readonly>
            <input type="hidden" name="idpelanggan" id="idpelanggan">
            <div class="input-group-append">
                <button class="btn btn-outline-primary" type="button" id="tombolCariPelanggan" title="Cari Pelanggan">
                    <i class="fa fa-search-plus"></i>
                </button>
                <button class="btn btn-outline-success" type="button" id="tombolTambahPelanggan"
                    title="Tambah Pelanggan">
                    <i class="fa fa-plus-square"></i>
                </button>
            </div>
        </div>
    </div>
</div>

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

                    <button type="button" class="btn btn-sm btn-primary" title="Selesai Transaksi"
                        id="tombolSelesaiTransaksi"> Selesai Trnsaksi
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 tampilDataTemp">

    </div>
</div>
<div class="viewmodal" style="display: none;"></div>
<script>
function kosong() {
    $('#kodebarang').val('');
    $('#namabarang').val('');
    $('#hargajual').val('');
    $('#jml').val('1');
    $('#kodebarang').focus();
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
            url: "/barangkeluar/simpanItem",
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
                    tampilDataTemp();
                    kosong();
                }
            },
            error: function(xhr, ajakOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }
}

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

function tampilDataTemp() {
    let faktur = $('#nofaktur').val();
    $.ajax({
        type: "post",
        url: "/barangkeluar/tampilDataTemp",
        data: {
            nofaktur: faktur
        },
        dataType: "json",
        beforeSend: function() {
            $('.tampilDataTemp').html("<i class='fa fa-spin fa-spinner'></i>");
        },
        success: function(response) {
            if (response.data) {
                $('.tampilDataTemp').html(response.data);
            }
        },
        error: function(xhr, ajakOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
        }
    });
}

function buatNoFaktur() {
    let tanggal = $('#tglfaktur').val();

    $.ajax({
        type: "post",
        url: "/barangkeluar/buatNoFaktur",
        data: {
            tanggal: tanggal
        },
        dataType: "json",
        success: function(response) {
            $('#nofaktur').val(response.nofaktur);
            tampilDataTemp();
        },
        error: function(xhr, ajakOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
        }
    });
}
$(document).ready(function() {
    tampilDataTemp();
    $('#tglfaktur').change(function(e) {
        buatNoFaktur();
    });

    $('#tombolTambahPelanggan').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: "/pelanggan/formtambah",
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.viewmodal').html(response.data).show();
                    $('#modaltambahpelanggan').modal('show');
                }
            },
            error: function(xhr, ajakOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    });

    $('#tombolCariPelanggan').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: "/pelanggan/modalData",
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.viewmodal').html(response.data).show();
                    $('#modaldatapelanggan').modal('show');
                }
            },
            error: function(xhr, ajakOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    });
    $('#kodebarang').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            ambilDataBarang();
        }
    });

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

    $('#tombolSelesaiTransaksi').click(function(e) {

        e.preventDefault();
        $.ajax({
            type: "post",
            url: "/barangkeluar/modalPembayaran",
            data: {
                nofaktur: $('#nofaktur').val(),
                tglfaktur: $('#tglfaktur').val(),
                idpelanggan: $('#idpelanggan').val(),
                totalharga: $('#totalharga').val(),
            },
            dataType: "json",
            success: function(response) {
                if (response.error) {
                    Swal.fire('Error', response.error, 'error');
                }
                if (response.data) {
                    $('.viewmodal').html(response.data).show();
                    $('#modalpembayaran').modal('show');
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