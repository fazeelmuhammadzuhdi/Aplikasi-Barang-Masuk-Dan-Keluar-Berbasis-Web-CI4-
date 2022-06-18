<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBarangKeluar;
use App\Models\ModelTempBarangKeluar;
use App\Models\ModelBarang;
use App\Models\ModelDataBarang;
use App\Models\ModelDataBarangKeluar;
use App\Models\ModelDetailBarangKeluar;
use App\Models\ModelDetailBarangMasuk;
use App\Models\ModelPelanggan;
use Config\Services;

class Barangkeluar extends BaseController
{
	private function buatFaktur()
	{
		$tanggalSekarang = date('Y-m-d');
		$modelBarangKeluar = new ModelBarangKeluar();

		$hasil = $modelBarangKeluar->noFaktur($tanggalSekarang)->getRowArray();
		$data = $hasil['nofaktur'];

		$lastNoUrut = substr($data, -4);

		$nextNoUrut = intval($lastNoUrut) + 1;

		$noFaktur = date('dmy', strtotime($tanggalSekarang)) . sprintf('%04s', $nextNoUrut);

		return $noFaktur;
	}
	public function buatNoFaktur()
	{
		$tanggalSekarang = $this->request->getPost('tanggal');
		$modelBarangKeluar = new ModelBarangKeluar();

		$hasil = $modelBarangKeluar->noFaktur($tanggalSekarang)->getRowArray();
		$data = $hasil['nofaktur'];

		$lastNoUrut = substr($data, -4);

		$nextNoUrut = intval($lastNoUrut) + 1;

		$noFaktur = date('dmy', strtotime($tanggalSekarang)) . sprintf('%04s', $nextNoUrut);

		$json = [
			'nofaktur' => $noFaktur
		];
		echo json_encode($json);
	}
	public function data()
	{
		return view('barangkeluar/viewdata');
	}

	public function input()
	{
		$data = [
			'nofaktur' => $this->buatFaktur()
		];
		return view('barangkeluar/forminput', $data);
	}

	public function tampilDataTemp()
	{
		if ($this->request->isAJAX()) {
			$nofaktur = $this->request->getPost('nofaktur');

			$modelTempBarangKeluar = new ModelTempBarangKeluar();
			$dataTemp = $modelTempBarangKeluar->tampilDataTemp($nofaktur);
			$data = [
				'tampildata' => $dataTemp
			];

			$json = [
				'data' => view('barangkeluar/datatemp', $data)
			];

			echo json_encode($json);
		}
	}
	function ambilDataBarang()
	{
		if ($this->request->isAJAX()) {
			$kodebarang = $this->request->getPost('kodebarang');

			$modelBarang = new ModelBarang();
			$ambilData = $modelBarang->find($kodebarang);

			if ($ambilData == NULL) {
				$json = [
					'error' => 'Maaaf, Data Barang Tidak Ditemukan...'
				];
			} else {
				$data = [
					'namabarang' => $ambilData['brgnama1910021'],
					'hargajual' => $ambilData['brgharga1910021']
				];

				$json = [
					'sukses' => $data
				];
			}
			echo json_encode($json);
		} else {
			exit('Maaf tidak bisa dipanggil');
		}
	}

	function simpanItem()
	{
		if ($this->request->isAJAX()) {
			$nofaktur = $this->request->getPost('nofaktur');
			$kodebarang = $this->request->getPost('kodebarang');
			$namabarang = $this->request->getPost('namabarang');
			$hargajual = $this->request->getPost('hargajual');
			$jml = $this->request->getPost('jml');

			$modelTempBarangKeluar = new ModelTempBarangKeluar();
			$modelBarang = new ModelBarang();

			$ambilDataBarang = $modelBarang->find($kodebarang);
			$stokBarang = $ambilDataBarang['brgstok1910021'];

			if ($jml > intval($stokBarang)) {
				$json = [
					'error' => 'Stok Tidak Mencukupi'
				];
			} else {
				$modelTempBarangKeluar->insert([
					'detfaktur1910021' => $nofaktur,
					'detbrgkode1910021' => $kodebarang,
					'dethargajual1910021' => $hargajual,
					'detjml1910021' => $jml,
					'detsubtotal1910021' => intval($jml) * intval($hargajual)

				]);

				$json = [
					'sukses' => 'Item Berhasil Ditambahkan'
				];
			}
			echo json_encode($json);
		}
	}

	function hapusItem()
	{
		if ($this->request->isAJAX()) {
			$id = $this->request->getPost('id');

			$modelTempBarangKeluar = new ModelTempBarangKeluar();
			$modelTempBarangKeluar->delete($id);

			$json = [
				'sukses' => 'Item Berhasil Di Hapus'
			];
			echo json_encode($json);
		} else {
			exit('Maaf tidak bisa dipanggil');
		}
	}

	function modalCariBarang()
	{
		if ($this->request->isAJAX()) {
			$json = [
				'data' => view('barangkeluar/modalcaribarang')
			];
			echo json_encode($json);
		} else {
			exit('Maaf tidak bisa dipanggil');
		}
	}

	function listDataBarang()
	{
		$request = Services::request();
		$datamodel = new ModelDataBarang($request);
		if ($request->getMethod(true) == 'POST') {
			$lists = $datamodel->get_datatables();
			$data = [];
			$no = $request->getPost("start");
			foreach ($lists as $list) {
				$no++;
				$row = [];

				$tombolPilih = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"pilih('" . $list->brgkode1910021 . "')\">Pilih</button>";

				$row[] = $no;
				$row[] = $list->brgkode1910021;
				$row[] = $list->brgnama1910021;
				$row[] = number_format($list->brgharga1910021, 0, ",", ".");
				$row[] = number_format($list->brgstok1910021, 0, ",", ".");
				$row[] = $tombolPilih;
				$data[] = $row;
			}
			$output = [
				"draw" => $request->getPost('draw'),
				"recordsTotal" => $datamodel->count_all(),
				"recordsFiltered" => $datamodel->count_filtered(),
				"data" => $data
			];
			echo json_encode($output);
		}
	}

	function modalPembayaran()
	{
		$nofaktur = $this->request->getPost('nofaktur');
		$tglfaktur = $this->request->getPost('tglfaktur');
		$idpelanggan = $this->request->getPost('idpelanggan');
		$totalharga = $this->request->getPost('totalharga');

		$modelTemp = new ModelTempBarangKeluar();
		$cekdata = $modelTemp->tampilDataTemp($nofaktur);

		if ($cekdata->getNumRows() > 0) {
			$data = [
				'nofaktur' => $nofaktur,
				'totalharga' => $totalharga,
				'tglfaktur' => $tglfaktur,
				'idpelanggan' => $idpelanggan
			];

			$json = [
				'data' => view('barangkeluar/modalpembayaran', $data)
			];
		} else {
			$json = [
				'error' => 'Maaf Item Tidak Ada'
			];
		}

		echo json_encode($json);
	}

	function simpanPembayaran()
	{
		if ($this->request->isAJAX()) {
			$nofaktur = $this->request->getPost('nofaktur');
			$tglfaktur = $this->request->getPost('tglfaktur');
			$idpelanggan = $this->request->getPost('idpelanggan');
			$totalbayar = str_replace(".", "", $this->request->getPost('totalbayar'));
			$jumlahuang = str_replace(".", "", $this->request->getPost('jumlahuang'));
			$sisauang = str_replace(".", "", $this->request->getPost('sisauang'));

			$modelBarangKeluar = new ModelBarangKeluar();

			$modelBarangKeluar->insert([
				'faktur1910021' => $nofaktur,
				'tglfaktur1910021' => $tglfaktur,
				'idpel1910021' => $idpelanggan,
				'totalharga1910021' => $totalbayar,
				'jumlahuang1910021' => $jumlahuang,
				'sisauang1910021' => $sisauang
			]);

			$modelTemp = new ModelTempBarangKeluar();
			$dataTemp = $modelTemp->getWhere(['detfaktur1910021' => $nofaktur]);

			$fieldDetail = [];
			foreach ($dataTemp->getResultArray() as $row) {
				$fieldDetail[] = [
					'detfaktur1910021' => $row['detfaktur1910021'],
					'detbrgkode1910021' => $row['detbrgkode1910021'],
					'dethargajual1910021' => $row['dethargajual1910021'],
					'detjml1910021' => $row['detjml1910021'],
					'detsubtotal1910021' => $row['detsubtotal1910021']
				];
			}

			$modelDetail = new ModelDetailBarangKeluar();
			$modelDetail->insertBatch($fieldDetail);

			$modelTemp->hapusData($nofaktur);


			$json = [
				'sukses' => 'Transaksi Berhasil diSimpan',
				'cetakfaktur' => site_url('barangkeluar/cetakfaktur/' . $nofaktur)
			];

			echo json_encode($json);
		}
	}

	public function cetakfaktur($faktur)
	{
		$modelBarangKeluar = new ModelBarangKeluar();
		$modelDetail = new ModelDetailBarangKeluar();
		$modelPelanggan = new ModelPelanggan();

		$cekData = $modelBarangKeluar->find($faktur);
		$dataPelanggan = $modelPelanggan->find($cekData['idpel1910021']);

		$namaPelanggan = ($dataPelanggan != null) ? $dataPelanggan['pelnama1910021'] : '-';

		if ($cekData != null) {
			$data = [
				'faktur' => $faktur,
				'tanggal' => $cekData['tglfaktur1910021'],
				'namapelanggan' => $namaPelanggan,
				'detailbarang' => $modelDetail->tampilDataTemp($faktur),
				'jumlahuang' => $cekData['jumlahuang1910021'],
				'sisauang' => $cekData['sisauang1910021']
			];
			return view('barangkeluar/cetakfaktur', $data);
		} else {
			return redirect()->to(site_url('barangkeluar/input'));
		}
	}

	public function listData()
	{
		$tglawal = $this->request->getPost('tglawal');
		$tglakhir = $this->request->getPost('tglakhir');

		$request = Services::request();
		$datamodel = new ModelDataBarangKeluar($request);
		if ($request->getMethod(true) == 'POST') {
			$lists = $datamodel->get_datatables($tglawal, $tglakhir);
			$data = [];
			$no = $request->getPost("start");
			foreach ($lists as $list) {
				$no++;
				$row = [];

				$tombolCetak = "<button type=\"button\" class=\"btn btn-sm btn-primary\" onclick=\"cetak('" . $list->faktur1910021 . "')\"><i class=\"fa fa-print\"></i></button>";

				$tombolHapus = "<button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"hapus('" . $list->faktur1910021 . "')\"><i class=\"fa fa-trash-alt\"></i></button>";

				$tombolEdit = "<button type=\"button\" class=\"btn btn-sm btn-warning\" onclick=\"edit('" . $list->faktur1910021 . "')\"><i class=\"fa fa-edit\"></i></button>";

				$row[] = $no;
				$row[] = $list->faktur1910021;
				$row[] = $list->tglfaktur1910021;
				$row[] = $list->pelnama1910021;
				$row[] = number_format($list->totalharga1910021, 0, ",", ".");
				$row[] = $tombolCetak . " " . $tombolHapus . ". $tombolEdit";
				$data[] = $row;
			}
			$output = [
				"draw" => $request->getPost('draw'),
				"recordsTotal" => $datamodel->count_all($tglawal, $tglakhir),
				"recordsFiltered" => $datamodel->count_filtered($tglawal, $tglakhir),
				"data" => $data
			];
			echo json_encode($output);
		}
	}

	function hapusTransaksi()
	{
		if ($this->request->isAJAX()) {
			$faktur = $this->request->getPost('faktur');

			$modelBarangKeluar = new ModelBarangKeluar();

			$db = \Config\Database::connect();

			$db->table('detail_barangkeluar1910021')->delete(['detfaktur1910021' => $faktur]);
			$modelBarangKeluar->delete(['faktur1910021' => $faktur]);

			$json = [
				'sukses' => 'Transaksi Berhasil Di Hapus'
			];
			echo json_encode($json);
		}
	}

	public function edit($faktur)
	{
		$modelBarangKeluar = new ModelBarangKeluar();
		$modelPelanggan = new ModelPelanggan();
		$rowData = $modelBarangKeluar->find($faktur);
		$rowPelanggan = $modelPelanggan->find($rowData['idpel1910021']);

		$data = [
			'nofaktur' => $faktur,
			'tanggal' => $rowData['tglfaktur1910021'],
			'namapelanggan' => $rowPelanggan['pelnama1910021'],
		];

		return view('barangkeluar/formedit', $data);
	}

	function ambilTotalHarga()
	{
		if ($this->request->isAJAX()) {
			$nofaktur = $this->request->getPost('nofaktur');

			$modelDetail = new ModelDetailBarangKeluar();

			$totalHarga = $modelDetail->ambilTotalHarga($nofaktur);


			$json = [
				'totalharga' => "Rp. " . number_format($totalHarga, 0, ",", ".")
			];
			echo json_encode($json);
		}
	}

	function tampilDataDetail()
	{
		if ($this->request->isAJAX()) {
			$nofaktur = $this->request->getPost('nofaktur');

			$mdodelDetail = new ModelDetailBarangKeluar();
			$dataTemp = $mdodelDetail->tampilDataTemp($nofaktur);
			$data = [
				'tampildata' => $dataTemp
			];

			$json = [
				'data' => view('barangkeluar/datadetail', $data)
			];

			echo json_encode($json);
		}
	}

	function hapusItemDetail()
	{
		if ($this->request->isAJAX()) {
			$id = $this->request->getPost('id');

			$modelDetail = new ModelDetailBarangKeluar();
			$modelBarangKeluar = new  ModelBarangKeluar();

			$rowData = $modelDetail->find($id);
			$noFaktur = $rowData['detfaktur1910021'];

			$modelDetail->delete($id);

			$totalHarga = $modelDetail->ambilTotalHarga($noFaktur);

			$modelBarangKeluar->update($noFaktur, [
				'totalharga1910021' => $totalHarga
			]);

			$json = [
				'sukses' => 'Item Berhasil Di Hapus'
			];
			echo json_encode($json);
		} else {
			exit('Maaf tidak bisa dipanggil');
		}
	}

	function editItem()
	{
		if ($this->request->isAJAX()) {
			$iddetail = $this->request->getPost('iddetail');
			$jml = $this->request->getPost('jml');

			$modelDetail = new ModelDetailBarangKeluar();
			$modelBarangKeluar = new  ModelBarangKeluar();

			$rowData = $modelDetail->find($iddetail);
			$noFaktur = $rowData['detfaktur1910021'];
			$hargajual = $rowData['dethargajual1910021'];

			$modelDetail->update($iddetail, [
				'detjml1910021' => $jml,
				'detsubtotal1910021' => intval($hargajual) * $jml
			]);

			// Ambil Total Harga
			$totalHarga = $modelDetail->ambilTotalHarga($noFaktur);

			// Update Barang Keluar
			$modelBarangKeluar->update($noFaktur, [
				'totalharga1910021' => $totalHarga
			]);

			$json = [
				'sukses' => 'Item Berhasil Di Update'
			];
			echo json_encode($json);
		}
	}

	function simpanItemDetail()
	{
		if ($this->request->isAJAX()) {
			$nofaktur = $this->request->getPost('nofaktur');
			$kodebarang = $this->request->getPost('kodebarang');
			$hargajual = $this->request->getPost('hargajual');
			$jml = $this->request->getPost('jml');

			$modelTempBarangKeluar = new ModelDetailBarangKeluar();
			$modelBarang = new ModelBarang();

			$ambilDataBarang = $modelBarang->find($kodebarang);
			$stokBarang = $ambilDataBarang['brgstok1910021'];

			if ($jml > intval($stokBarang)) {
				$json = [
					'error' => 'Stok Tidak Mencukupi'
				];
			} else {
				$modelTempBarangKeluar->insert([
					'detfaktur1910021' => $nofaktur,
					'detbrgkode1910021' => $kodebarang,
					'dethargajual1910021' => $hargajual,
					'detjml1910021' => $jml,
					'detsubtotal1910021' => $jml * $hargajual
				]);
				$modelBarangKeluar = new ModelBarangKeluar();
				// Ambil Total Harga
				$totalHarga = $modelTempBarangKeluar->ambilTotalHarga($nofaktur);

				// Update Barang Keluar
				$modelBarangKeluar->update($nofaktur, [
					'totalharga1910021' => $totalHarga
				]);

				$json = [
					'sukses' => 'Item Berhasil Ditambahkan'
				];
			}
			echo json_encode($json);
		}
	}
}