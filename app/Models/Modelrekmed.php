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
        'diagnosa',
        'tensi',
        'nadi',
        'suhu',
        'berat_badan',
        'tinggi_badan',
        'pemeriksaan_fisik',
        'tgl_kontrol',
        'id_antrean',
        'resep_obat',
    ];

    /**
     * Ambil rekam medis beserta nama pasien dan dokter.
     */
    public function getRekamMedisLengkap()
    {
        return $this->db->table('tb_rekam_medis rm')
            ->select('rm.*, p.nama AS nama_pasien, d.nama AS nama_dokter, d.spesialisasi')
            ->join('tb_pasien p', 'p.id_pasien = rm.id_pasien')
            ->join('tb_dokter d', 'd.id_dokter = rm.id_dokter')
            ->orderBy('rm.tgl_periksa', 'DESC')
            ->get()->getResultArray();
    }

    /**
     * Ambil rekam medis hari ini untuk dashboard.
     */
    public function getTodayCount()
    {
        return $this->where('DATE(tgl_periksa)', date('Y-m-d'))->countAllResults();
    }

    /**
     * Ambil rekam medis berdasarkan ID Pasien.
     */
    public function getRekamMedisByPasien($id_pasien)
    {
        return $this->db->table('tb_rekam_medis rm')
            ->select('rm.*, p.nama AS nama_pasien, d.nama AS nama_dokter, d.spesialisasi')
            ->join('tb_pasien p', 'p.id_pasien = rm.id_pasien')
            ->join('tb_dokter d', 'd.id_dokter = rm.id_dokter')
            ->where('rm.id_pasien', $id_pasien)
            ->orderBy('rm.tgl_periksa', 'DESC')
            ->get()->getResultArray();
    }
}

