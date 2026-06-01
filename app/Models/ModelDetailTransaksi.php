<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelDetailTransaksi extends Model
{
    protected $table            = 'tb_detail_transaksi';
    protected $primaryKey       = 'id_detail';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_transaksi',
        'kode_obat',
        'jumlah',
        'harga_satuan',
        'subtotal'
    ];

    public function getDetailByTransaksi($id_transaksi)
    {
        return $this->select('tb_detail_transaksi.*, tb_obat.nama_obat')
                    ->join('tb_obat', 'tb_obat.kode_obat = tb_detail_transaksi.kode_obat', 'left')
                    ->where('id_transaksi', $id_transaksi)
                    ->findAll();
    }
}
