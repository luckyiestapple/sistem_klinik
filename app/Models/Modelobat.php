<?php

namespace App\Models;

use CodeIgniter\Model;

class Modelobat extends Model
{
    protected $table            = 'tb_obat';
    protected $primaryKey       = 'kode_obat';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'kode_obat',
        'nama_obat',
        'stok',
        'harga',
        'satuan',
        'tgl_expired',
        'stok_minimum',
        'kandungan',
    ];

    /**
     * Stok obat yang menipis (di bawah threshold).
     */
    public function getStokRendah(int $threshold = 10)
    {
        return $this->where('stok <', $threshold)->findAll();
    }

    public function reduceStock($kode_obat, $jumlah)
    {
        $db = \Config\Database::connect();
        $db->query("UPDATE tb_obat SET stok = stok - ? WHERE kode_obat = ?", [$jumlah, $kode_obat]);
    }

    public function addStock($kode_obat, $jumlah)
    {
        $db = \Config\Database::connect();
        $db->query("UPDATE tb_obat SET stok = stok + ? WHERE kode_obat = ?", [$jumlah, $kode_obat]);
    }
}
