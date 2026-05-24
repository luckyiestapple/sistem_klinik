<?php

namespace App\Models;

use CodeIgniter\Model;

class Modeldokter extends Model
{
    protected $table            = 'tb_dokter';
    protected $primaryKey       = 'id_dokter';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_dokter',
        'nama',
        'spesialisasi',
        'alamat',
        'no_telp',
        'email',
        'sip_str',
        'status_aktif',
        'hari_praktek',
        'jam_praktek',
        'foto',
        'foto_updated_at',
    ];

    /**
     * Generate ID Dokter otomatis (D001, D002, ...)
     */
    public function generateID()
    {
        $last = $this->selectMax('id_dokter')->first();
        if (!$last || !$last['id_dokter']) {
            return 'D001';
        }

        $num = (int) substr($last['id_dokter'], 1);
        $next = $num + 1;
        return 'D' . str_pad($next, 3, '0', STR_PAD_LEFT);
    }
}