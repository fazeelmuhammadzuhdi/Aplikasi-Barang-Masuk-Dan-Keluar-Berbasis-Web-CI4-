<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKategori extends Model
{

	protected $table                = 'kategori1910021';
	protected $primaryKey           = 'katid1910021';
	protected $allowedFields        = [
		'katid1910021', 'katnama1910021'
	];

	public function cariData($cari)
	{
		return $this->table('kategori1910021')->like('katnama1910021', $cari);
	}
}