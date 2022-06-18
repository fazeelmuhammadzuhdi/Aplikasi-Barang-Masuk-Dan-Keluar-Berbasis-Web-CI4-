<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBarangKeluar extends Model
{

	protected $table                = 'barangkeluar1910021';
	protected $primaryKey           = 'faktur1910021';
	protected $allowedFields        = [
		'faktur1910021', 'tglfaktur1910021', 'idpel1910021', 'totalharga1910021', 'jumlahuang1910021', 'sisauang1910021'
	];

	public function noFaktur($tanggalSekarang)
	{
		return $this->table('barangkeluar1910021')->select('max(faktur1910021) as nofaktur')->where('tglfaktur1910021', $tanggalSekarang)->get();
	}

	public function laporanPerPeriode($tglawal, $tglakhir)
	{
		return $this->table('barangkeluar1910021')->where('tglfaktur1910021 >=', $tglawal)->where('tglfaktur1910021 <=', $tglakhir)->get();
	}
}