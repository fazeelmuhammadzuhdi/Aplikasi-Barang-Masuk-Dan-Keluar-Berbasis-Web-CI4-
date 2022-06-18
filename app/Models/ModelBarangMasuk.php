<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBarangMasuk extends Model
{
	protected $table                = 'barangmasuk1910021';
	protected $primaryKey           = 'faktur1910021';
	protected $allowedFields        = [
		'faktur1910021', 'tglfaktur1910021', 'totalharga1910021'
	];

	public function tampildata_cari($cari)
	{
		return $this->table('barangmasuk1910021')->like('faktur1910021', $cari);
	}

	public function cekFaktur($faktur)
	{
		return $this->table('barangmasuk1910021')->getWhere([
			'sha1(faktur1910021)' => $faktur
		]);
	}

	public function laporanPerPeriode($tglawal, $tglakhir)
	{
		return $this->table('barangmasuk1910021')->where('tglfaktur1910021 >=', $tglawal)->where('tglfaktur1910021 <=', $tglakhir)->get();
	}
}