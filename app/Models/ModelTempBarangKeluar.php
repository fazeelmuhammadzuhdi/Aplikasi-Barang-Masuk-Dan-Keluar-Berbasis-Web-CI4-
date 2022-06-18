<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelTempBarangKeluar extends Model
{
	protected $table                = 'temp_barangkeluar1910021';
	protected $primaryKey           = 'id';
	protected $allowedFields        = [
		'detfaktur1910021', 'detbrgkode1910021', 'dethargajual1910021', 'detjml1910021', 'detsubtotal1910021'
	];

	public function tampilDataTemp($nofaktur)
	{
		return $this->table('temp_barangkeluar1910021')->join('barang1910021', 'detbrgkode1910021=brgkode1910021')->where(['detfaktur1910021' => $nofaktur])->get();
	}

	public function hapusData($nofaktur)
	{
		$this->table('temp_barangkeluar1910021')->where('detfaktur1910021', $nofaktur);
		return $this->table('temp_barangkeluar1910021')->delete();
	}
}