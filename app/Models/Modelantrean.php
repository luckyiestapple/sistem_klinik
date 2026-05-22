<?php

namespace App\Models;

use CodeIgniter\Model;

class Modelantrean extends Model
{
    protected $table            = 'tb_antrean';
    protected $primaryKey       = 'id_antrean';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_pasien',
        'id_dokter',
        'tgl_antrean',
        'nomor_antrean',
        'status',
        'keluhan',
    ];

    public function getAntreanByPasien($id_pasien)
    {
        return $this->db->table('tb_antrean a')
            ->select('a.*, p.nama AS nama_pasien, d.nama AS nama_dokter, d.spesialisasi')
            ->join('tb_pasien p', 'p.id_pasien = a.id_pasien')
            ->join('tb_dokter d', 'd.id_dokter = a.id_dokter')
            ->where('a.id_pasien', $id_pasien)
            ->orderBy('a.tgl_antrean', 'DESC')
            ->get()->getResultArray();
    }

    public function getJadwalMendatang($id_pasien)
    {
        return $this->db->table('tb_antrean a')
            ->select('a.*, p.nama AS nama_pasien, d.nama AS nama_dokter, d.spesialisasi')
            ->join('tb_pasien p', 'p.id_pasien = a.id_pasien')
            ->join('tb_dokter d', 'd.id_dokter = a.id_dokter')
            ->where('a.id_pasien', $id_pasien)
            ->where('a.status', 'menunggu')
            ->where('a.tgl_antrean >=', date('Y-m-d'))
            ->orderBy('a.tgl_antrean', 'ASC')
            ->get()->getRowArray();
    }

    public function generateNomorAntrean($id_dokter, $tanggal)
    {
        $count = $this->where('id_dokter', $id_dokter)
                      ->where('tgl_antrean', $tanggal)
                      ->countAllResults();
        
        $nextNum = $count + 1;
        return 'A' . str_pad($nextNum, 2, '0', STR_PAD_LEFT);
    }
}
