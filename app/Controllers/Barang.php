<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBarang;
use App\Models\ModelKategori;
use App\Models\ModelSatuan;
use CodeIgniter\Validation\Validation;

class Barang extends BaseController
{
	public function __construct()
	{
		$this->barang = new ModelBarang();
	}
	public function index()
	{
		$tombolcari = $this->request->getPost('tombolcari');
		if (isset($tombolcari)) {
			$cari = $this->request->getPost('cari');
			session()->set('cari_barang', $cari);
			redirect()->to('barang/index');
		} else {
			$cari = session()->get('cari_barang');
		}

		$totaldata = $cari ? $this->barang->tampildata_cari($cari)->countAllResults() : $this->barang->tampildata()->countAllResults();

		$dataBarang = $cari ? $this->barang->tampildata_cari($cari)->paginate(3, 'barang') : $this->barang->tampildata()->paginate(3, 'barang');

		$nohalaman = $this->request->getVar('page_barang') ? $this->request->getVar('page_barang') : 1;

		$data = [
			'tampildata' => $dataBarang,
			'pager' => $this->barang->pager,
			'nohalaman' => $nohalaman,
			'totaldata' => $totaldata,
			'cari' => $cari
		];
		return view('barang/viewbarang', $data);
	}
	public function tambah()
	{
		$modelkategori = new ModelKategori;
		$modelsatuan = new ModelSatuan;

		$data = [
			'datakategori' => $modelkategori->findAll(),
			'datasatuan' => $modelsatuan->findAll()

		];
		return view('barang/formtambah', $data);
	}
	public function simpandata()
	{
		$kodebarang = $this->request->getVar('kodebarang');
		$namabarang = $this->request->getVar('namabarang');
		$kategori = $this->request->getVar('kategori');
		$satuan = $this->request->getVar('satuan');
		$harga = $this->request->getVar('harga');
		$stok = $this->request->getVar('stok');

		$validation = \config\Services::validation();

		$valid = $this->validate([
			'kodebarang' => [
				'rules' => 'required|is_unique[barang1910021.brgkode1910021]',
				'label' => 'Kode Barang',
				'errors' => [
					'required' => '{field} tidak boleh kosong',
					'is_unique' => '{field} sudah ada'
				]
			],
			'namabarang' => [
				'rules' => 'required',
				'label' => 'Nama Barang',
				'errors' => [
					'required' => '{field} tidak boleh kosong',
					'is_unique' => '{field} sudah ada'
				]
			],
			'kategori' => [
				'rules' => 'required',
				'label' => 'Kategori',
				'errors' => [
					'required' => '{field} tidak boleh kosong',
					'is_unique' => '{field} sudah ada'
				]
			],
			'satuan' => [
				'rules' => 'required',
				'label' => 'Satuan',
				'errors' => [
					'required' => '{field} tidak boleh kosong',
					'is_unique' => '{field} sudah ada'
				]
			],
			'harga' => [
				'rules' => 'required|numeric',
				'label' => 'Harga',
				'errors' => [
					'required' => '{field} tidak boleh kosong',
					'numeric' => '{field} harga hanya bentuk angka'
				]
			],
			'stok' => [
				'rules' => 'required|numeric',
				'label' => 'Stok',
				'errors' => [
					'required' => '{field} tidak boleh kosong',
					'numeric' => '{field} harga hanya bentuk angka'
				]
			],
			'gambar' => [
				'rules' => 'mime_in[gambar,image/png,image/jpg,image/jpeg]|ext_in[gambar,png,jpg,jpeg]',
				'label' => 'Gambar',
			]
		]);

		if (!$valid) {
			$sess_Pesan = [
				'error' => '<div class="alert alert-danger alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h5><i class="icon fas fa-ban"></i> Error!</h5>
				' . $validation->listErrors() . '
					</div>'
			];

			session()->setFlashdata($sess_Pesan);
			return redirect()->to('/barang/tambah');
		} else {
			$gambar = $_FILES['gambar']['name'];

			if ($gambar != NULL) {
				$namaFileGambar = $kodebarang;
				$fileGambar = $this->request->getFile('gambar');
				$fileGambar->move('upload', $namaFileGambar . '.' . $fileGambar->getExtension());

				$pathGambar = 'upload/' . $fileGambar->getName();
			} else {
				$pathGambar = '';
			}

			$this->barang->insert([
				'brgkode1910021' => $kodebarang,
				'brgnama1910021' => $namabarang,
				'brgkatid1910021' => $kategori,
				'brgsatid1910021' => $satuan,
				'brgharga1910021' => $harga,
				'brgstok1910021' => $stok,
				'brggambar1910021' => $pathGambar
			]);

			$pesan_sukses = [
				'sukses' => '<div class="alert alert-success alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h5><i class="icon fas fa-check"></i> Berhasil!</h5>
				Data Barang dengan kode <strong>' . $kodebarang . '</strong> berhasil disimpan
			  </div>'
			];

			session()->setFlashdata($pesan_sukses);
			return redirect()->to('/barang/tambah');
		}
	}
	public function edit($kode)
	{
		$cekData = $this->barang->find($kode);

		if ($cekData) {

			$modelkategori = new Modelkategori();
			$modelsatuan = new Modelsatuan();

			$data = [
				'kodebarang' => $cekData['brgkode1910021'],
				'namabarang' => $cekData['brgnama1910021'],
				'kategori' => $cekData['brgkatid1910021'],
				'satuan' => $cekData['brgsatid1910021'],
				'harga' => $cekData['brgharga1910021'],
				'stok' => $cekData['brgstok1910021'],
				'datakategori' => $modelkategori->findAll(),
				'datasatuan' => $modelsatuan->findAll(),
				'gambar' => $cekData['brggambar1910021']
			];
			return view('barang/formedit', $data);
		} else {
			$pesan_error = [
				'error' => '<div class="alert alert-danger alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h5><i class="icon fas fa-ban"></i> Error !</h5>
				Data Barang Tidak Ditemukan..
			  </div>'
			];

			session()->setFlashdata($pesan_error);
			return redirect()->to('/barang/index');
		}
	}

	public function updatedata()
	{
		$kodebarang = $this->request->getVar('kodebarang');
		$namabarang = $this->request->getVar('namabarang');
		$kategori = $this->request->getVar('kategori');
		$satuan = $this->request->getVar('satuan');
		$harga = $this->request->getVar('harga');
		$stok = $this->request->getVar('stok');

		$validation = \Config\Services::validation();

		$valid = $this->validate([
			'namabarang' => [
				'rules' => 'required',
				'label' => 'Nama Barang',
				'errors' => [
					'required' => '{field} tidak boleh kosong',
				]
			],
			'kategori' => [
				'rules' => 'required',
				'label' => 'Kategori',
				'errors' => [
					'required' => '{field} tidak boleh kosong',
				]
			],
			'satuan' => [
				'rules' => 'required',
				'label' => 'satuan',
				'errors' => [
					'required' => '{field} tidak boleh kosong',
				]
			],
			'harga' => [
				'rules' => 'required|numeric',
				'label' => 'Harga',
				'errors' => [
					'required' => '{field} tidak boleh kosong',
					'numeric' => '{field} hanya dalam bentuk angka'
				]
			],
			'stok' => [
				'rules' => 'required|numeric',
				'label' => 'Stok',
				'errors' => [
					'required' => '{field} tidak boleh kosong',
					'numeric' => '{field} hanya dalam bentuk angka'
				]
			],
			'gambar' => [
				'rules' => 'mime_in[gambar,image/png,image/jpg,image/jpeg]|ext_in[gambar,png,jpg,jpeg]',
				'label' => 'Gambar',
			]
		]);

		if (!$valid) {
			$sess_Pesan = [
				'error' => '<div class="alert alert-danger alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h5><i class="icon fas fa-ban"></i> Error!</h5>
				' . $validation->listErrors() . '
			  </div>'
			];

			session()->setFlashdata($sess_Pesan);
			return redirect()->to('/barang/tambah');
		} else {
			$cekData = $this->barang->find($kodebarang);
			$pathGambarLama = $cekData['brggambar1910021'];
			$gambar = $_FILES['gambar']['name'];

			if ($gambar != NULL) {
				($pathGambarLama == '' || $pathGambarLama == null) ? '' : unlink($pathGambarLama);

				$namaFileGambar = $kodebarang;
				$fileGambar = $this->request->getFile('gambar');
				$fileGambar->move('upload', $namaFileGambar . '.' . $fileGambar->getExtension());

				$pathGambar = 'upload/' . $fileGambar->getName();
			} else {
				$pathGambar = $pathGambarLama;
			}

			$this->barang->update($kodebarang, [
				'brgnama1910021' => $namabarang,
				'brgkatid1910021' => $kategori,
				'brgsatid1910021' => $satuan,
				'brgharga1910021' => $harga,
				'brgstok1910021' => $stok,
				'brggambar1910021' => $pathGambar
			]);

			$pesan_sukses = [
				'sukses' => '<div class="alert alert-success alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h5><i class="icon fas fa-check"></i> Berhasil !</h5>
				Data Barang dengan kode <strong>' . $kodebarang . '</strong> berhasil diupdate
			  </div>'
			];

			session()->setFlashdata($pesan_sukses);
			return redirect()->to('/barang/index');
		}
	}

	public function hapus($kode)
	{
		$cekData = $this->barang->find($kode);

		if ($cekData) {

			$pathGambarLama = $cekData['brggambar1910021'];
			unlink($pathGambarLama);

			$this->barang->delete($kode);
			$pesan_sukses = [
				'sukses' => '<div class="alert alert-success alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h5><i class="icon fas fa-check"></i> Berhasil !</h5>
				Data Barang dengan kode <strong>' . $kode . '</strong> berhasil dihapus
			  </div>'
			];

			session()->setFlashdata($pesan_sukses);
			return redirect()->to('/barang/index');
		} else {
			$pesan_error = [
				'error' => '<div class="alert alert-danger alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h5><i class="icon fas fa-ban"></i> Error !</h5>
				Data Barang Tidak Ditemukan..
			  </div>'
			];

			session()->setFlashdata($pesan_error);
			return redirect()->to('/barang/index');
		}
	}
}