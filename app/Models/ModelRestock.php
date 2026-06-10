<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelRestock extends Model
{
    protected $table            = 'tb_restock';
    protected $primaryKey       = 'id_restock';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'kode_obat',
        'tanggal',
        'keterangan',
        'jumlah',
        'harga_beli',
        'total_biaya',
        'id_user'
    ];

    public function getRestockWithDetails()
    {
        return $this->select('tb_restock.*, tb_obat.nama_obat, tb_obat.satuan, tb_user.username')
                    ->join('tb_obat', 'tb_obat.kode_obat = tb_restock.kode_obat', 'left')
                    ->join('tb_user', 'tb_user.id_user = tb_restock.id_user', 'left')
                    ->orderBy('tb_restock.tanggal', 'DESC')
                    ->findAll();
    }
}
