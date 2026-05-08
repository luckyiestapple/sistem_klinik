<?php

namespace App\Models;

use CodeIgniter\Model;

class Modelrekmed extends Model
{
    protected $table            = 'tb_rekam_medis';
    protected $primaryKey       = 'id_rekam_medis';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_pasien',
        'id_dokter',
        'tgl_periksa',
        'keluhan',
        'diagnosa'
    ];

    /**
     * Ambil rekam medis beserta nama pasien dan dokter.
     */
    public function getRekamMedisLengkap()
    {
        return db()->table('tb_rekam_medis rm')
            ->select('rm.*, p.nama_pasien, d.nama_dokter, d.spesialisasi')
            ->join('tb_pasien p', 'p.id_pasien = rm.id_pasien')
            ->join('tb_dokter d', 'd.id_dokter = rm.id_dokter')
            ->orderBy('rm.tanggal_periksa', 'DESC')
            ->get()->getResultArray();
    }

    /**
     * Ambil rekam medis hari ini untuk dashboard.
     */
    public function getTodayCount()
    {
        return $this->where('DATE(tanggal_periksa)', date('Y-m-d'))->countAllResults();
    }
}
