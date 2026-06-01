<?php

namespace App\Models;

use CodeIgniter\Model;

class Modeldetailresep extends Model
{
    protected $table            = 'tb_resepdetail';
    protected $primaryKey       = 'id_detail';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'kode_resep',
        'kode_obat',
        'dosis',
        'jumlah',
        'harga',
    ];

    /**
     * Ambil detail resep beserta nama obat.
     * Subtotal dihitung langsung: jumlah * harga_satuan
     */
    public function getDetailByResep(int $idResep)
    {
        return $this->db->table('tb_resepdetail dr')
            ->select('dr.*, o.nama_obat, o.satuan, o.kode_obat, (dr.jumlah * dr.harga) AS subtotal')
            ->join('tb_obat o', 'o.kode_obat = dr.kode_obat')
            ->where('dr.kode_resep', $idResep)
            ->get()->getResultArray();
    }
}

