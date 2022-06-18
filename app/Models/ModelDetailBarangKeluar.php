<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelDetailBarangKeluar extends Model
{
	protected $table                = 'detail_barangkeluar1910021';
	protected $primaryKey           = 'id';
	protected $allowedFields        = [
		'detfaktur1910021', 'detbrgkode1910021', 'dethargajual1910021', 'detjml1910021', 'detsubtotal1910021'
	];

	public function tampilDataTemp($nofaktur)
	{
		return $this->table('detail_barangkeluar1910021')->join('barang1910021', 'detbrgkode1910021=brgkode1910021')
			->join('satuan1910021', 'brgsatid1910021 = satid1910021')
			->where(['detfaktur1910021' => $nofaktur])->get();
	}

	function ambilTotalHarga($nofaktur)
	{
		$query = $this->table('detail_barangkeluar1910021')->getWhere([
			'detfaktur1910021' => $nofaktur
		]);
		$totalHarga = 0;
		foreach ($query->getResultArray() as $r) :
			$totalHarga += $r['detsubtotal1910021'];
		endforeach;

		return $totalHarga;
	}

	public function laporanperperiode($tglawal, $tglakhir)
	{

		return $this->table('detailbarangkeluar1910021')->join('barangkeluar1910021', 'faktur1910021=detfaktur1910021')->join('barang1910021', 'detbrgkode1910021=brgkode1910021')->join('kategori1910021', 'katid1910021=brgkatid1910021')->join('pelanggan1910021', 'idpel1910021=pelid1910021')
			->where('tglfaktur1910021>=', $tglawal)->where('tglfaktur1910021<=', $tglakhir)->get();
	}
}