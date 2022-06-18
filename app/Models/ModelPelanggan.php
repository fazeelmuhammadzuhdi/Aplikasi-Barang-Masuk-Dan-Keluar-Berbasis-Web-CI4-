<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPelanggan extends Model
{
	protected $table                = 'pelanggan1910021';
	protected $primaryKey           = 'pelid1910021';
	protected $allowedFields        = [
		'pelnama1910021', 'peltelp1910021'
	];

	public function ambilDataTerakhir()
	{
		return $this->table('pelanggan1910021')->limit(1)->orderBy('pelid1910021', 'DESC')->get();
	}
}