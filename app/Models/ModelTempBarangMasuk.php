<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelTempBarangMasuk extends Model
{
	protected $table                = 'temp_barangmasuk1910021';
	protected $primaryKey           = 'iddetail1910021';
	protected $allowedFields        = [
		'iddetail1910021', 'detfaktur1910021', 'detbrgkode1910021', 'dethargamasuk1910021', 'dethargajual1910021', 'detjml1910021', 'detsubtotal1910021'
	];

	public function tampilDataTemp($faktur)
	{
		return $this->table('temp_barangmasuk1910021')->join('barang1910021', 'brgkode1910021=detbrgkode1910021')->where(['detfaktur1910021' => $faktur])->get();
	}
}