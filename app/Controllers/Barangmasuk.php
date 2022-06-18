<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBarang;
use App\Models\ModelTempBarangMasuk;
use App\Models\ModelBarangMasuk;
use App\Models\ModelDetailBarangMasuk;

class Barangmasuk extends BaseController
{
	public function index()
	{
		return view('barangmasuk/forminput');
	}

	function dataTemp()
	{
		if ($this->request->isAJAX()) {
			$faktur = $this->request->getPost('faktur');

			$modelTemp = new ModelTempBarangMasuk();
			$data = [
				'datatemp' => $modelTemp->tampilDataTemp($faktur)
			];

			$json = [
				'data' => view('barangmasuk/datatemp', $data)
			];
			echo json_encode($json);
		} else {
			exit('Maaf tidak bisa dipanggil');
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
					'error' => 'Data Tidak Ditemukan...'
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
	function simpanTemp()
	{
		if ($this->request->isAJAX()) {
			$faktur = $this->request->getPost('faktur');
			$hargajual = $this->request->getPost('hargajual');
			$hargabeli = $this->request->getPost('hargabeli');
			$kodebarang = $this->request->getPost('kodebarang');
			$jumlah = $this->request->getPost('jumlah');

			$modelTempBarang = new ModelTempBarangMasuk();

			$modelTempBarang->insert([
				'detfaktur1910021' => $faktur,
				'detbrgkode1910021' => $kodebarang,
				'dethargamasuk1910021' => $hargabeli,
				'dethargajual1910021' => $hargajual,
				'detjml1910021' => $jumlah,
				'detsubtotal1910021' => intval($jumlah) * intval($hargabeli)

			]);

			$json = [
				'sukses' => 'Item Berhasil DiTambahkan'
			];
			echo json_encode($json);
		} else {
			exit('Maaf tidak bisa dipanggil');
		}
	}
	function hapus()
	{
		if ($this->request->isAJAX()) {
			$id = $this->request->getPost('id');

			$modelTempBarang = new ModelTempBarangMasuk();
			$modelTempBarang->delete($id);

			$json = [
				'sukses' => 'Item Berhasil DiTambahkan'
			];
			echo json_encode($json);
		} else {
			exit('Maaf tidak bisa dipanggil');
		}
	}
	function cariDataBarang()
	{
		if ($this->request->isAJAX()) {
			$json = [
				'data' => view('barangmasuk/modalcaribarang')
			];
			echo json_encode($json);
		} else {
			exit('Maaf tidak bisa dipanggil');
		}
	}
	function detailCariBarang()
	{
		if ($this->request->isAJAX()) {
			$cari = $this->request->getPost('cari');

			$modalBarang = new ModelBarang();

			$data = $modalBarang->tampildata_cari($cari)->get();

			if ($data != null) {
				$json = [
					'data' => view('barangmasuk/detaildatabarang', [
						'tampildata' => $data
					])
				];
				echo json_encode($json);
			}
		} else {
			exit('Maaf tidak bisa dipanggil');
		}
	}
	function selesaiTransaksi()
	{
		if ($this->request->isAJAX()) {
			$faktur = $this->request->getPost('faktur');
			$tglfaktur = $this->request->getPost('tglfaktur');

			$modelTemp = new ModelTempBarangMasuk();
			$dataTemp = $modelTemp->getWhere(['detfaktur1910021' => $faktur]);

			if ($dataTemp->getNumRows() == 0) {
				$json = [
					'error' => 'Maaf, Data Item Untuk Faktur Ini Belum Ada'
				];
			} else {
				// Simpan Ke Tabel Barang Masuk
				$modelBarangMasuk = new ModelBarangMasuk();
				$totalSubtotal = 0;

				foreach ($dataTemp->getResultArray() as $total) :
					$totalSubtotal += intval($total['detsubtotal1910021']);
				endforeach;

				$modelBarangMasuk->insert([
					'faktur1910021' => $faktur,
					'tglfaktur1910021' => $tglfaktur,
					'totalharga1910021' => $totalSubtotal
				]);

				// Simpan Ke Table Detail Barang Masuk
				$modelDetailBarangMasuk = new ModelDetailBarangMasuk();
				foreach ($dataTemp->getResultArray() as $row) :
					$modelDetailBarangMasuk->insert([
						'detfaktur1910021' => $row['detfaktur1910021'],
						'detbrgkode1910021' => $row['detbrgkode1910021'],
						'dethargamasuk1910021' => $row['dethargamasuk1910021'],
						'dethargajual1910021' => $row['dethargajual1910021'],
						'detjml1910021' => $row['detjml1910021'],
						'detsubtotal1910021' => $row['detsubtotal1910021'],
					]);
				endforeach;

				// Hapus Data Yang Ada Di Temp

				$modelTemp->emptyTable();

				$json = [
					'sukses' => 'Transaksi Berhasil Disimpan'
				];
			}

			echo json_encode($json);
		} else {
			exit('Maaf tidak bisa dipanggil');
		}
	}

	public function data()
	{
		$tombolcari = $this->request->getPost('tombolcari');

		if (isset($tombolcari)) {
			$cari = $this->request->getPost('cari');
			session()->set('cari_faktur', $cari);
			return redirect()->to('/barangmasuk/data');
		} else {
			$cari = session()->get('cari_faktur');
		}

		$modelBarangMasuk = new ModelBarangMasuk();

		$totaldata = $cari ? $modelBarangMasuk->tampildata_cari($cari)->countAllResults() : $modelBarangMasuk->countAllResults();

		$databarangmasuk = $cari ? $modelBarangMasuk->tampildata_cari($cari)->paginate(3, 'barangmasuk') : $modelBarangMasuk->paginate(3, 'barangmasuk');

		$nohalaman = $this->request->getVar('page_barangmasuk') ? $this->request->getVar('page_barangmasuk') : 1;

		$data = [
			'tampildata' => $databarangmasuk,
			'pager' => $modelBarangMasuk->pager,
			'nohalaman' => $nohalaman,
			'totaldata' => $totaldata,
			'cari' => $cari
		];

		return view('barangmasuk/viewdata', $data);
	}

	public function detailItem()
	{
		if ($this->request->isAJAX()) {
			$faktur = $this->request->getPost('faktur');

			$modelDetail = new ModelDetailBarangMasuk();


			$data = [
				'tampildatadetail' => $modelDetail->dataDetail($faktur)
			];

			$json = [
				'data' => view('barangmasuk/modaldetailitem', $data)
			];
			echo json_encode($json);
		}
	}

	function edit($faktur)
	{
		$modelBarangMasuk = new ModelBarangMasuk();
		$cekFaktur = $modelBarangMasuk->cekFaktur($faktur);

		if ($cekFaktur->getNumRows() > 0) {
			$row = $cekFaktur->getRowArray();

			$data = [
				'nofaktur' => $row['faktur1910021'],
				'tanggal' => $row['tglfaktur1910021']
			];
			return view('barangmasuk/formedit', $data);
		} else {
			exit('Data Tidak DiTemukan');
		}
	}

	function dataDetail()
	{
		if ($this->request->isAJAX()) {
			$faktur = $this->request->getPost('faktur');

			$modelDetail = new ModelDetailBarangMasuk();
			$data = [
				'datadetail' => $modelDetail->dataDetail($faktur)
			];
			$totalHargaFaktur = number_format($modelDetail->ambilTotalHarga($faktur), 0, ",", ".");
			$json = [
				'data' => view('barangmasuk/datadetail', $data),
				'totalharga' => $totalHargaFaktur

			];
			echo json_encode($json);
		}
	}

	function editItem()
	{
		if ($this->request->isAJAX()) {
			$iddetail = $this->request->getPost('iddetail');

			$modelDetail = new ModelDetailBarangMasuk();
			$ambilData = $modelDetail->ambilDetailBerdasarkanID($iddetail);

			$row = $ambilData->getRowArray();

			$data = [
				'kodebarang' => $row['detbrgkode1910021'],
				'namabarang' => $row['brgnama1910021'],
				'hargajual' => $row['dethargajual1910021'],
				'hargabeli' => $row['dethargamasuk1910021'],
				'jumlah' => $row['detjml1910021']
			];

			$json = [
				'sukses' => $data
			];
			echo json_encode($json);
		}
	}

	function simpanDetail()
	{
		if ($this->request->isAJAX()) {
			$faktur = $this->request->getPost('faktur');
			$hargajual = $this->request->getPost('hargajual');
			$hargabeli = $this->request->getPost('hargabeli');
			$kodebarang = $this->request->getPost('kodebarang');
			$jumlah = $this->request->getPost('jumlah');

			$modelDetail = new ModelDetailBarangMasuk();
			$modelBarangMasuk = new ModelBarangMasuk();

			$modelDetail->insert([
				'detfaktur1910021' => $faktur,
				'detbrgkode1910021' => $kodebarang,
				'dethargamasuk1910021' => $hargabeli,
				'dethargajual1910021' => $hargajual,
				'detjml1910021' => $jumlah,
				'detsubtotal1910021' => intval($jumlah) * intval($hargabeli)

			]);

			$ambilTotalHarga = $modelDetail->ambilTotalHarga($faktur);

			$modelBarangMasuk->update($faktur, [
				'totalharga1910021' => $ambilTotalHarga
			]);

			$json = [
				'sukses' => 'Item Berhasil DiTambahkan'
			];
			echo json_encode($json);
		} else {
			exit('Maaf tidak bisa dipanggil');
		}
	}

	function updateItem()
	{
		if ($this->request->isAJAX()) {
			$faktur = $this->request->getPost('faktur');
			$hargajual = $this->request->getPost('hargajual');
			$hargabeli = $this->request->getPost('hargabeli');
			$jumlah = $this->request->getPost('jumlah');
			$iddetail = $this->request->getPost('iddetail');

			$modelDetail = new ModelDetailBarangMasuk();
			$modelBarangMasuk = new ModelBarangMasuk();

			$modelDetail->update($iddetail, [
				'dethargamasuk1910021' => $hargabeli,
				'dethargajual1910021' => $hargajual,
				'detjml1910021' => $jumlah,
				'detsubtotal1910021' => intval($jumlah) * intval($hargabeli)

			]);

			$ambilTotalHarga = $modelDetail->ambilTotalHarga($faktur);

			$modelBarangMasuk->update($faktur, [
				'totalharga1910021' => $ambilTotalHarga
			]);

			$json = [
				'sukses' => 'Item Berhasil DiUpdate'
			];
			echo json_encode($json);
		}
	}

	function hapusItemDetail()
	{
		if ($this->request->isAJAX()) {
			$id = $this->request->getPost('id');
			$faktur = $this->request->getPost('faktur');

			$modelDetail = new ModelDetailBarangMasuk();
			$modelBarangMasuk = new ModelBarangMasuk();

			$modelDetail->delete($id);

			$ambilTotalHarga = $modelDetail->ambilTotalHarga($faktur);

			$modelBarangMasuk->update($faktur, [
				'totalharga1910021' => $ambilTotalHarga
			]);

			$json = [
				'sukses' => 'Item Berhasil DiTambahkan'
			];
			echo json_encode($json);
		} else {
			exit('Maaf tidak bisa dipanggil');
		}
	}

	public function hapusTransaksi()
	{

		$faktur = $this->request->getPost('faktur');

		$db = \Config\Database::connect();
		$modelBarangMasuk = new ModelBarangMasuk();

		$db->table('detail_barangmasuk1910021')->delete(['detfaktur1910021' => $faktur]);
		$modelBarangMasuk->delete($faktur);

		$json = [
			'sukses' => "Transaksi Dengan Faktur : <strong>$faktur</strong>, Berhasil Di Hapus"
		];

		echo json_encode($json);
	}
}