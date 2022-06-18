<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelDetailBarangMasuk extends Model
{
	protected $table                = 'detail_barangmasuk1910021';
	protected $primaryKey           = 'iddetail1910021';
	protected $allowedFields        = [
		'iddetail1910021', 'detfaktur1910021', 'detbrgkode1910021', 'dethargamasuk1910021', 'dethargajual1910021', 'detjml1910021', 'detsubtotal1910021'
	];

	public function dataDetail($faktur)
	{
		return $this->table('detail_barangmasuk1910021')->join('barang1910021', 'brgkode1910021=detbrgkode1910021')->where('detfaktur1910021', $faktur)->get();
	}

	public function ambilTotalHarga($faktur)
	{
		$query = $this->table('detail_barangmasuk1910021')->getWhere([
			'detfaktur1910021' => $faktur
		]);
		$totalHarga = 0;
		foreach ($query->getResultArray() as $r) :
			$totalHarga += $r['detsubtotal1910021'];
		endforeach;

		return $totalHarga;
	}

	public function ambilDetailBerdasarkanID($iddetail)
	{
		return $this->table('detail_barangmasuk1910021')->join('barang1910021', 'brgkode1910021=detbrgkode1910021')->where('iddetail1910021', $iddetail)->get();
	}

	public function laporanperperiode($tglawal, $tglakhir)
	{
		return $this->table('detailbarangmasuk1910021')->join('barangmasuk1910021', 'faktur1910021=detfaktur1910021')->join('barang1910021', 'detbrgkode1910021=brgkode1910021')
			->join('kategori1910021', 'katid1910021=brgkatid1910021')
			->where('tglfaktur1910021>=', $tglawal)->where('tglfaktur1910021<=', $tglakhir)->get();
	}
}