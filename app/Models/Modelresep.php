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
        'id_rekam_medis',
        'tgl_resep',
        'total_harga',
        'status',
        'catatan',
    ];

    /**
     * Ambil resep lengkap dengan data pasien dan dokter melalui rekam medis.
     */
    public function getResepLengkap()
    {
        return db()->table('tb_resep r')
            ->select('r.*, rm.tgl_periksa, rm.keluhan, p.nama_pasien, d.nama_dokter')
            ->join('tb_rekam_medis rm', 'rm.id_rekam_medis = r.id_rekam_medis')
            ->join('tb_pasien p',       'p.id_pasien = rm.id_pasien')
            ->join('tb_dokter d',       'd.id_dokter = rm.id_dokter')
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
