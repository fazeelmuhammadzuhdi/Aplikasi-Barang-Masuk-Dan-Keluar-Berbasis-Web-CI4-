<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelDataPelanggan;
use App\Models\ModelPelanggan;
use Config\Services;
use JsonException;

class Pelanggan extends BaseController
{
	public function formtambah()
	{
		$json = [
			'data' => view('pelanggan/modaltambah')
		];
		echo json_encode($json);
	}

	public function simpan()
	{
		$namapelanggan = $this->request->getPost('namapel');
		$telp = $this->request->getPost('telp');

		$validation = \config\Services::validation();

		$valid = $this->validate([
			'namapel' => [
				'rules' => 'required',
				'label' => 'Nama Pelanggan',
				'errors' => [
					'required' => '{field} tidak boleh kosong'
				]
			],
			'telp' => [
				'rules' => 'required|is_unique[pelanggan1910021.peltelp1910021]',
				'label' => 'No. Telp / HP',
				'errors' => [
					'required' => '{field} tidak boleh kosong',
					'is_unique' => '{field} tidak boleh Ada Yang Sama'
				]
			]
		]);

		if (!$valid) {
			$json = [
				'error' => [
					'errNamaPelanggan' => $validation->getError('namapel'),
					'errTelp' => $validation->getError('telp'),
				]
			];
		} else {
			$modelPelanggan = new ModelPelanggan();

			$modelPelanggan->insert([
				'pelnama1910021' => $namapelanggan,
				'peltelp1910021' => $telp
			]);

			$rowData = $modelPelanggan->ambilDataTerakhir()->getRowArray();

			$json = [
				'sukses' => 'Data Pelanggan Berhasil Disimpan, Ambil Data Terakhir ?',
				'namapelanggan' => $rowData['pelnama1910021'],
				'idpelanggan' => $rowData['pelid1910021']
			];
		}

		echo json_encode($json);
	}

	public function modalData()
	{
		if ($this->request->isAJAX()) {
			$json = [
				'data' => view('pelanggan/modaldata')
			];

			echo json_encode($json);
		}
	}

	public function listData()
	{
		$request = Services::request();
		$datamodel = new ModelDataPelanggan($request);
		if ($request->getMethod(true) == 'POST') {
			$lists = $datamodel->get_datatables();
			$data = [];
			$no = $request->getPost("start");
			foreach ($lists as $list) {
				$no++;
				$row = [];

				$tombolPilih = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"pilih('" . $list->pelid1910021 . "','" . $list->pelnama1910021 . "')\">Pilih</button>";

				$tombolHapus = "<button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"hapus('" . $list->pelid1910021 . "','" . $list->pelnama1910021 . "')\">Hapus</button>";

				$row[] = $no;
				$row[] = $list->pelnama1910021;
				$row[] = $list->peltelp1910021;
				$row[] = $tombolPilih . " " . $tombolHapus;
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

	function hapus()
	{
		if ($this->request->isAJAX()) {
			$id = $this->request->getPost('id');

			$modelPelanggan = new ModelPelanggan();

			$modelPelanggan->delete($id);

			$json = [
				'sukses' => 'Data Pelanggan Berhasil Di Hapus'
			];

			echo json_encode($json);
		}
	}
}