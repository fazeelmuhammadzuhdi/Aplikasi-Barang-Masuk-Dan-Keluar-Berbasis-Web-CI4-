<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelLogin;

class Login extends BaseController
{
	public function index()
	{
		return view('login/index');
	}

	public function cekUser()
	{
		$iduser = $this->request->getPost('iduser');
		$pass = $this->request->getPost('pass');

		$validation = \Config\Services::validation();

		$valid = $this->validate([
			'iduser' => [
				'label' => 'ID USER',
				'rules' => 'required',
				'errors' => [
					'required' => '{field} Tidak Boleh Kosong'
				]
			],
			'pass' => [
				'label' => 'Password',
				'rules' => 'required',
				'errors' => [
					'required' => '{field} Tidak Boleh Kosong'
				]
			]
		]);

		if (!$valid) {
			$sessError = [
				'errIdUser' => $validation->getError('iduser'),
				'errPassword' => $validation->getError('pass')
			];

			session()->setFlashdata($sessError);
			return redirect()->to(site_url('login/index'));
		} else {
			$modelLogin = new ModelLogin();

			$cekUserLogin = $modelLogin->find($iduser);
			if ($cekUserLogin == null) {
				$sessError = [
					'errIdUser' => 'Maaf User Tidak Terdaftar'

				];

				session()->setFlashdata($sessError);
				return redirect()->to(site_url('login/index'));
			} else {
				$passwordUser = $cekUserLogin['userpassword1910021'];

				if (password_verify($pass, $passwordUser)) {
					//Lanjutkan
					$idlevel = $cekUserLogin['userlevelid1910021'];

					$simpan_session = [
						'iduser' => $iduser,
						'namauser' => $cekUserLogin['usernama1910021'],
						'idlevel' => $idlevel
					];
					session()->set($simpan_session);

					return redirect()->to('/main/index');
				} else {
					$sessError = [
						'errPassword' => 'Password Anda Salah'
					];
					session()->setFlashdata($sessError);
					return redirect()->to(site_url('login/index'));
				}
			}
		}
	}

	public function keluar()
	{
		session()->destroy();
		return redirect()->to('/login/index');
	}
}