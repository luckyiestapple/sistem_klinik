<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLaporanKas extends Model
{
    protected $table            = 'v_laporan_kas';
    protected $returnType       = 'array';

    public function getLaporanKas($tipe = null, $tgl_mulai = null, $tgl_akhir = null)
    {
        $builder = $this->builder();
        if ($tipe) {
            $builder->where('tipe', $tipe);
        }
        if ($tgl_mulai && $tgl_akhir) {
            $builder->where("tanggal >=", $tgl_mulai);
            $builder->where("tanggal <=", $tgl_akhir);
        }
        $builder->orderBy('tanggal', 'DESC');
        return $builder->get()->getResultArray();
    }
    
    public function getRingkasan()
    {
        $db = \Config\Database::connect();
        
        $pemasukan = $db->table('v_laporan_kas')->selectSum('nominal')->where('tipe', 'pemasukan')->get()->getRow()->nominal ?? 0;
        $pengeluaran = $db->table('v_laporan_kas')->selectSum('nominal')->where('tipe', 'pengeluaran')->get()->getRow()->nominal ?? 0;
        
        return [
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
            'saldo' => $pemasukan - $pengeluaran
        ];
    }
}
