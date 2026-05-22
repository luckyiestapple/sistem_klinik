<?php

namespace App\Models;

use CodeIgniter\Model;

class Modelpasien extends Model
{
    protected $table            = 'tb_pasien';
    protected $primaryKey       = 'id_pasien';
    protected $useAutoIncrement = false; // varchar(12)
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_pasien',
        'nama',
        'jk',
        'tgl_lahir',
        'no_telp',
        'alamat',
        'no_bpjs',
        'status_bpjs',
        'faskes',
        'kelas_rawat',
        'gol_darah',
        'alergi_obat',
        'riwayat_penyakit',
        'kontak_darurat_nama',
        'kontak_darurat_telp',
    ];
    protected $useTimestamps = false; // Not in SQL dump

    /**
     * Generate ID Pasien otomatis (PSN-xxx)
     */
    public function generateID()
    {
        $last = $this->selectMax('id_pasien')->first();
        if (!$last || !$last['id_pasien']) {
            return 'P001';
        }

        $num = (int) substr($last['id_pasien'], 1);
        $next = $num + 1;
        return 'P' . str_pad($next, 3, '0', STR_PAD_LEFT);
    }
}
