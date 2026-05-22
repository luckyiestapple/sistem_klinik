<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Modeldokter;
use App\Models\Modelantrean;
use App\Models\UserModel;

class DashboardDokter extends BaseController
{
    protected $db;
    protected $dokterModel;
    protected $antreanModel;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->dokterModel = new Modeldokter();
        $this->antreanModel = new Modelantrean();
    }

    private function authCheck()
    {
        if (!session()->get('logged_in') || session()->get('id_level') != 3) {
            return redirect()->to(base_url('login'))->with('error', 'Akses ditolak. Khusus Dokter.');
        }
        return null;
    }

    public function index()
    {
        if ($r = $this->authCheck()) return $r;

        $idDokter = session()->get('id_referensi');
        $today = date('Y-m-d');

        // Fetch doctor info
        $dokter = $this->dokterModel->find($idDokter);

        // Fetch today's queues
        $antrean = $this->db->table('tb_antrean a')
            ->select('a.*, p.nama AS nama_pasien, p.jk, p.tgl_lahir')
            ->join('tb_pasien p', 'p.id_pasien = a.id_pasien')
            ->where('a.id_dokter', $idDokter)
            ->where('a.tgl_antrean', $today)
            ->orderBy('a.nomor_antrean', 'ASC')
            ->get()->getResultArray();

        // Calculate stats
        $totalToday = count($antrean);
        $completedToday = 0;
        $pendingToday = 0;
        foreach ($antrean as $a) {
            if ($a['status'] === 'selesai') {
                $completedToday++;
            } elseif ($a['status'] === 'menunggu' || $a['status'] === 'dipanggil') {
                $pendingToday++;
            }
        }

        $data = [
            'title'            => 'Dashboard Dokter',
            'dokter'           => $dokter,
            'antrean'          => $antrean,
            'total_today'      => $totalToday,
            'completed_today'  => $completedToday,
            'pending_today'    => $pendingToday,
        ];
        return view('dashboard/dokter', $data);
    }

    public function antrian()
    {
        if ($r = $this->authCheck()) return $r;

        $idDokter = session()->get('id_referensi');
        $tanggal = $this->request->getGet('tanggal') ?? date('Y-m-d');
        $status = $this->request->getGet('status');

        $query = $this->db->table('tb_antrean a')
            ->select('a.*, p.nama AS nama_pasien, p.jk, p.no_telp')
            ->join('tb_pasien p', 'p.id_pasien = a.id_pasien')
            ->where('a.id_dokter', $idDokter);

        if (!empty($tanggal)) {
            $query->where('a.tgl_antrean', $tanggal);
        }
        if (!empty($status)) {
            $query->where('a.status', $status);
        }

        $antreanList = $query->orderBy('a.nomor_antrean', 'ASC')->get()->getResultArray();

        $data = [
            'title'   => 'Antrian Praktik Saya',
            'antrean' => $antreanList,
            'filter'  => [
                'tanggal' => $tanggal,
                'status'  => $status,
            ]
        ];
        return view('dashboard/dokter_antrian', $data);
    }

    public function panggilAntrian($id)
    {
        if ($r = $this->authCheck()) return $r;

        $idDokter = session()->get('id_referensi');
        $antrean = $this->antreanModel->find($id);

        if ($antrean && $antrean['id_dokter'] == $idDokter) {
            $this->antreanModel->update($id, ['status' => 'dipanggil']);
            session()->setFlashdata('success', 'Pasien dipanggil.');
        } else {
            session()->setFlashdata('error', 'Antrian tidak ditemukan.');
        }

        return redirect()->back();
    }

    public function selesaiAntrian($id)
    {
        if ($r = $this->authCheck()) return $r;

        $idDokter = session()->get('id_referensi');
        $antrean = $this->antreanModel->find($id);

        if ($antrean && $antrean['id_dokter'] == $idDokter) {
            // Redirect to Rekam Medis tambah with id_antrean prefilled
            return redirect()->to(base_url('rekam_medis/tambah?id_antrean='.$id));
        } else {
            session()->setFlashdata('error', 'Antrian tidak ditemukan.');
            return redirect()->back();
        }
    }

    public function profil()
    {
        if ($r = $this->authCheck()) return $r;

        $idDokter = session()->get('id_referensi');
        $dokter = $this->dokterModel->find($idDokter);

        $userModel = new UserModel();
        $user = $userModel->where('id_referensi', $idDokter)->where('id_level', 3)->first();

        $data = [
            'title'  => 'Profil Saya',
            'dokter' => $dokter,
            'user'   => $user,
        ];
        return view('dashboard/dokter_profil', $data);
    }

    public function profilUpdate()
    {
        if ($r = $this->authCheck()) return $r;

        $idDokter = session()->get('id_referensi');
        
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            // Update Dokter details
            $dataDokter = [
                'nama'         => $this->request->getPost('nama'),
                'alamat'       => $this->request->getPost('alamat'),
                'no_telp'      => $this->request->getPost('no_telp'),
                'email'        => $this->request->getPost('email'),
                'sip_str'      => $this->request->getPost('sip_str'),
                'hari_praktek' => $this->request->getPost('hari_praktek'),
                'jam_praktek'  => $this->request->getPost('jam_praktek'),
            ];
            $this->dokterModel->update($idDokter, $dataDokter);

            // Update Password if filled
            $password = $this->request->getPost('password');
            if (!empty($password)) {
                $userModel = new UserModel();
                $user = $userModel->where('id_referensi', $idDokter)->where('id_level', 3)->first();
                if ($user) {
                    $userModel->update($user['id_user'], [
                        'password' => password_hash($password, PASSWORD_DEFAULT)
                    ]);
                }
            }

            if ($db->transStatus() === false) {
                $db->transRollback();
                session()->setFlashdata('error', 'Gagal memperbarui profil.');
            } else {
                $db->transCommit();
                session()->setFlashdata('success', 'Profil dan informasi login berhasil diperbarui.');
            }
        } catch (\Exception $e) {
            $db->transRollback();
            session()->setFlashdata('error', 'Error: ' . $e->getMessage());
        }

        return redirect()->to(base_url('dokter/profil'));
    }
}
