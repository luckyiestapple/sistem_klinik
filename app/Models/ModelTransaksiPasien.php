<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelTransaksiPasien extends Model
{
    protected $table            = 'tb_transaksi_pasien';
    protected $primaryKey       = 'id_transaksi';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'nama_pasien',
        'is_bpjs',
        'tanggal',
        'total_biaya',
        'id_user'
    ];

    public function getTransaksiWithDetails()
    {
        return $this->select('tb_transaksi_pasien.*, tb_user.username')
                    ->join('tb_user', 'tb_user.id_user = tb_transaksi_pasien.id_user', 'left')
                    ->orderBy('tb_transaksi_pasien.tanggal', 'DESC')
                    ->findAll();
    }
}
