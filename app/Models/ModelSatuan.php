<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelSatuan extends Model
{
	
	protected $table                = 'satuan1910021';
	protected $primaryKey           = 'satid1910021';	
	protected $allowedFields        = [
		'satid1910021', 'satnama1910021'
	];
	public function cariData($cari)
	{
		return $this->table('satuan1910021')->like('satnama1910021', $cari);
	}
}
