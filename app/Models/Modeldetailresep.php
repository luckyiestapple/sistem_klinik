<?php

namespace App\Models;

use CodeIgniter\Model;

class Modeldetailresep extends Model
{
    protected $table            = 'tb_detail_resep';
    protected $primaryKey       = 'id_detail';      // auto increment (bukan varchar)
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_resep',
        'id_obat',
        'jumlah',
        'dosis',
        'harga_satuan',
        // subtotal DIHAPUS — dihitung: jumlah * harga_satuan saat query
    ];

    /**
     * Ambil detail resep beserta nama obat.
     * Subtotal dihitung langsung: jumlah * harga_satuan
     */
    public function getDetailByResep(int $idResep)
    {
        return db()->table('tb_detail_resep dr')
            ->select('dr.*, o.nama_obat, o.kode_obat, (dr.jumlah * dr.harga_satuan) AS subtotal')
            ->join('tb_obat o', 'o.id_obat = dr.id_obat')
            ->where('dr.id_resep', $idResep)
            ->get()->getResultArray();
    }
}
