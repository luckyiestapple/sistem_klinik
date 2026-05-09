<?php

namespace App\Models;

use CodeIgniter\Model;

class Modelresep extends Model
{
    protected $table            = 'tb_resep';
    protected $primaryKey       = 'id_resep';
    protected $useAutoIncrement = true;     // kode resep auto increment
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_pasien',
        'id_dokter',
        'tgl_resep',
        'total_harga',
    ];

    /**
     * Ambil resep lengkap dengan data pasien dan dokter melalui rekam medis.
     */
    public function getResepLengkap()
    {
        return $this->db->table('tb_resep r')
            ->select('r.*, p.nama AS nama_pasien, d.nama AS nama_dokter')
            ->join('tb_pasien p', 'p.id_pasien = r.id_pasien')
            ->join('tb_dokter d', 'd.id_dokter = r.id_dokter')
            ->orderBy('r.tgl_resep', 'DESC')
            ->get()->getResultArray();
    }

    /**
     * Hitung resep dengan status menunggu (untuk dashboard apoteker).
     */
    public function getMenungguCount()
    {
        return $this->where('status', 'menunggu')->countAllResults();
    }
}

