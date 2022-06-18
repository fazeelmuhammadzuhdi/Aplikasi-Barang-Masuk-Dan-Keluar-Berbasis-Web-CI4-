<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBarang extends Model
{

	protected $table                = 'barang1910021';
	protected $primaryKey           = 'brgkode1910021';
	protected $allowedFields        = [
		'brgkode1910021', 'brgnama1910021', 'brgkatid1910021', 'brgsatid1910021', 'brgharga1910021', 'brggambar1910021', 'brgstok1910021'
	];

	public function tampildata()
	{
		return $this->table('barang1910021')->join('kategori1910021', 'brgkatid1910021=katid1910021')->join('satuan1910021', 'brgsatid1910021=satid1910021');
	}
	public function tampildata_cari($cari)
	{
		return $this->table('barang1910021')->join('kategori1910021', 'brgkatid1910021=katid1910021')->join('satuan1910021', 'brgsatid1910021=satid1910021')->orlike('brgkode1910021', $cari)->orlike('brgnama1910021', $cari)->orlike('katnama1910021', $cari);
	}
}