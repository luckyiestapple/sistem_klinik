<?php

namespace App\Models;

use CodeIgniter\Model;

class Modelobat extends Model
{
    protected $table            = 'tb_obat';
    protected $primaryKey       = 'id_obat';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'kode_obat',
        'nama_obat',
        'kategori',
        'stok',
        'harga',
    ];

    /**
     * Stok obat yang menipis (di bawah threshold).
     */
    public function getStokRendah(int $threshold = 10)
    {
        return $this->where('stok <', $threshold)->findAll();
    }
}
