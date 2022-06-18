<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBarangKeluar;
use App\Models\ModelBarangMasuk;
use App\Models\ModelDetailBarangMasuk;
use App\Models\ModelDetailBarangKeluar;

class Laporan extends BaseController
{
    public function index()
    {
        return view('laporan/index');
    }

    public function cetak_barang_masuk()
    {
        return view('laporan/viewbarangmasuk');
    }

    public function cetak_barang_masuk_periode()
    {
        $tglawal = $this->request->getPost('tglawal');
        $tglakhir = $this->request->getPost('tglakhir');

        $modelBarangMasuk = new ModelBarangMasuk();

        $dataLaporan = $modelBarangMasuk->laporanPerPeriode($tglawal, $tglakhir);

        $data = [
            'datalaporan' => $dataLaporan,
            'tglawal' => $tglawal,
            'tglakhir' => $tglakhir
        ];

        return view('laporan/cetakLaporanBarangMasuk', $data);
    }

    public function cetak_barang_keluar()
    {
        return view('laporan/viewbarangkeluar');
    }

    public function cetak_barang_keluar_periode()
    {
        $tglawal = $this->request->getPost('tglawal');
        $tglakhir = $this->request->getPost('tglakhir');

        $ModelBarangKeluar = new ModelBarangKeluar();

        $dataLaporan = $ModelBarangKeluar->laporanPerPeriode($tglawal, $tglakhir);

        $data = [
            'datalaporan' => $dataLaporan,
            'tglawal' => $tglawal,
            'tglakhir' => $tglakhir
        ];

        return view('laporan/cetakLaporanBarangKeluar', $data);
    }

    public function cetak_detail_barang_masuk()
    {
        return view('laporan/viewdetailbarangmasuk');
    }

    public function cetak_detail_barang_masuk_periode()
    {
        $tglawal = $this->request->getPost('tglawal');

        $tglakhir = $this->request->getPost('tglakhir');




        $modeldetail = new Modeldetailbarangmasuk();

        $datalaporan = $modeldetail->laporanperperiode($tglawal, $tglakhir);


        $data = [

            'datalaporan' => $datalaporan,

            'tglawal' => $tglawal,

            'tglakhir' => $tglakhir


        ];

        return view('laporan/cetakDetailLaporanBarangMasuk', $data);
    }

    public function cetak_detail_barang_keluar()
    {
        return view('laporan/viewdetailbarangkeluar');
    }

    public function cetak_detail_barang_keluar_periode()
    {


        $tglawal = $this->request->getPost('tglawal');

        $tglakhir = $this->request->getPost('tglakhir');

        $ModelDetailBarangKeluar = new ModelDetailBarangKeluar();

        $datalaporan = $ModelDetailBarangKeluar->laporanperperiode($tglawal, $tglakhir);

        $data = [



            'datalaporan' => $datalaporan,

            'tglawal' => $tglawal,

            'tglakhir' => $tglakhir
        ];

        return view('laporan/cetakDetailLaporanBarangKeluar', $data);
    }

    public function tampilGrafikBarangMasuk()
    {
        $bulan = $this->request->getPost('bulan');

        $db = \Config\Database::connect();

        $query = $db->query("SELECT tglfaktur1910021 AS tgl, totalharga1910021 FROM barangmasuk1910021 WHERE DATE_FORMAT(tglfaktur1910021,'%Y-%m') = '$bulan' ORDER BY tglfaktur1910021 ASC")->getResult();

        $data = [
            'grafik' => $query
        ];

        $json = [
            'data' => view('laporan/grafikbarangmasuk', $data)
        ];

        echo json_encode($json);
    }
}