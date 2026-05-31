<?php

namespace App\Controllers;

use App\Models\Modelpasien;
use App\Models\Modeldokter;
use App\Models\Modelrekmed;
use App\Models\Modelresep;
use App\Models\Modeldetailresep;
use App\Models\Modelantrean;
use App\Models\UserModel;

class DashboardPasien extends BaseController
{
    private function checkAuth()
    {
        if (!session()->get('logged_in') || session()->get('id_level') != 2) {
            return false;
        }
        return true;
    }

    public function index()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('login'))->with('error', 'Akses ditolak.');
        }

        $id_pasien = session()->get('id_referensi');
        
        $pasienModel = new Modelpasien();
        $antreanModel = new Modelantrean();
        $resepModel = new Modelresep();
        $rekmedModel = new Modelrekmed();

        $pasien = $pasienModel->find($id_pasien);
        $antreanMendatang = $antreanModel->getJadwalMendatang($id_pasien);
        $resepList = $resepModel->where('id_pasien', $id_pasien)->orderBy('tgl_resep', 'DESC')->findAll(2);
        
        // Fetch resep details if any
        $detailResepModel = new Modeldetailresep();
        foreach ($resepList as &$resep) {
            $resep['details'] = $detailResepModel->getDetailByResep($resep['id_resep']);
        }

        // Fetch latest health readings (dummy but can be made dynamic from latest rekmed)
        $latestRekmed = $rekmedModel->where('id_pasien', $id_pasien)->orderBy('tgl_periksa', 'DESC')->first();

        $data = [
            'title'            => 'Dashboard Pasien',
            'pasien'           => $pasien,
            'antrean'          => $antreanMendatang,
            'resepList'        => $resepList,
            'latest_rekmed'    => $latestRekmed
        ];

        return view('dashboard/pasien', $data);
    }


    public function antrian()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('login'))->with('error', 'Akses ditolak.');
        }

        $id_pasien = session()->get('id_referensi');
        $dokterModel = new Modeldokter();
        $antreanModel = new Modelantrean();

        // Get distinct spesialisasi
        $db = \Config\Database::connect();
        $spesialisasi = $db->table('tb_dokter')->select('spesialisasi')->distinct()->get()->getResultArray();
        
        // Get all doctors
        $dokter = $dokterModel->findAll();
        
        // Get queue history
        $riwayatAntrean = $antreanModel->getAntreanByPasien($id_pasien);

        $data = [
            'title'          => 'Ambil Antrian',
            'spesialisasi'   => $spesialisasi,
            'dokter'         => $dokter,
            'riwayatAntrean' => $riwayatAntrean
        ];

        return view('dashboard/antrian', $data);
    }

    public function simpanAntrian()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('login'))->with('error', 'Akses ditolak.');
        }

        $id_pasien   = session()->get('id_referensi');
        $id_dokter   = $this->request->getPost('id_dokter');
        $tgl_antrean = $this->request->getPost('tgl_antrean');
        $keluhan     = $this->request->getPost('keluhan');

        if (empty($id_dokter) || empty($tgl_antrean)) {
            return redirect()->to(base_url('antrian'))->with('error', 'Semua kolom wajib diisi.');
        }

        $antreanModel = new Modelantrean();

        // Validasi 1 antrian aktif per tanggal/dokter/pasien
        $existing = $antreanModel->where('id_pasien', $id_pasien)
                                ->where('id_dokter', $id_dokter)
                                ->where('tgl_antrean', $tgl_antrean)
                                ->whereIn('status', ['menunggu', 'dipanggil'])
                                ->first();

        if ($existing) {
            return redirect()->to(base_url('antrian'))->with('error', 'Anda sudah memiliki antrean aktif (menunggu/dipanggil) untuk dokter ini pada tanggal tersebut.');
        }

        $nomorAntrean = $antreanModel->generateNomorAntrean($id_dokter, $tgl_antrean);

        $antreanModel->insert([
            'id_pasien'     => $id_pasien,
            'id_dokter'     => $id_dokter,
            'tgl_antrean'   => $tgl_antrean,
            'nomor_antrean' => $nomorAntrean,
            'status'        => 'menunggu',
            'keluhan'       => $keluhan,
        ]);

        return redirect()->to(base_url('dashboard_pasien'))->with('success', 'Berhasil mengambil antrean! Nomor antrean Anda: ' . $nomorAntrean);
    }

    public function resep()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('login'))->with('error', 'Akses ditolak.');
        }

        $id_pasien = session()->get('id_referensi');
        $resepModel = new Modelresep();
        $riwayatResep = $resepModel->getResepByPasien($id_pasien);

        $data = [
            'title'        => 'Resep Saya',
            'riwayatResep' => $riwayatResep
        ];

        return view('dashboard/resep', $data);
    }

    public function resepDetail($id)
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('login'))->with('error', 'Akses ditolak.');
        }

        $id_pasien = session()->get('id_referensi');
        $resepModel = new Modelresep();
        $resep = $resepModel->where('id_resep', $id)->where('id_pasien', $id_pasien)->first();

        if (!$resep) {
            return redirect()->to(base_url('resep_pasien'))->with('error', 'Resep tidak ditemukan.');
        }

        // Fetch detail resep beserta nama obat
        $detailModel = new Modeldetailresep();
        $details = $detailModel->getDetailByResep($id);

        // Fetch doctor info
        $dokterModel = new Modeldokter();
        $dokter = $dokterModel->find($resep['id_dokter']);

        $data = [
            'title'   => 'Detail Resep',
            'resep'   => $resep,
            'details' => $details,
            'dokter'  => $dokter
        ];

        return view('dashboard/resep_detail', $data);
    }

    public function rekamMedis()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('login'))->with('error', 'Akses ditolak.');
        }

        $id_pasien = session()->get('id_referensi');
        $rekmedModel = new Modelrekmed();
        $riwayatRekmed = $rekmedModel->getRekamMedisByPasien($id_pasien);

        $data = [
            'title'         => 'Rekam Medis Saya',
            'riwayatRekmed' => $riwayatRekmed
        ];

        return view('dashboard/rekam_medis', $data);
    }

    public function profil()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('login'))->with('error', 'Akses ditolak.');
        }

        $id_pasien = session()->get('id_referensi');
        $pasienModel = new Modelpasien();
        $pasien = $pasienModel->find($id_pasien);

        $userModel = new UserModel();
        $user = $userModel->where('id_referensi', $id_pasien)->where('id_level', 2)->first();

        // Calculate limits for profile picture
        $can_update_foto = true;
        $days_remaining = 0;
        if (!empty($pasien['foto_updated_at'])) {
            $last_update = strtotime($pasien['foto_updated_at']);
            $now = time();
            $seconds_in_30_days = 30 * 24 * 60 * 60;
            $time_passed = $now - $last_update;
            if ($time_passed < $seconds_in_30_days) {
                $can_update_foto = false;
                $days_remaining = ceil(($seconds_in_30_days - $time_passed) / (24 * 60 * 60));
            }
        }

        $data = [
            'title'            => 'Profil Saya',
            'pasien'           => $pasien,
            'user'             => $user,
            'can_update_foto'  => $can_update_foto,
            'days_remaining'   => $days_remaining
        ];
        return view('dashboard/profil', $data);
    }

    public function updateFoto()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('login'))->with('error', 'Akses ditolak.');
        }

        $id_pasien = session()->get('id_referensi');
        $pasienModel = new Modelpasien();
        $pasien = $pasienModel->find($id_pasien);

        if (!$pasien) {
            return redirect()->to(base_url('profil_pasien'))->with('error', 'Pasien tidak ditemukan.');
        }

        // Check constraint (30 days limit)
        if (!empty($pasien['foto_updated_at'])) {
            $last_update = strtotime($pasien['foto_updated_at']);
            $now = time();
            $seconds_in_30_days = 30 * 24 * 60 * 60;
            $time_passed = $now - $last_update;
            if ($time_passed < $seconds_in_30_days) {
                $days_remaining = ceil(($seconds_in_30_days - $time_passed) / (24 * 60 * 60));
                return redirect()->to(base_url('profil_pasien'))->with('error', 'Foto profil hanya dapat diubah sekali dalam 30 hari. Sisa waktu: ' . $days_remaining . ' hari.');
            }
        }

        // Prioritize Cropped Image (Base64)
        $foto_base64 = $this->request->getPost('foto_cropped');
        if (!empty($foto_base64)) {
            if (preg_match('/^data:image\/(\w+);base64,/', $foto_base64, $type)) {
                $data = substr($foto_base64, strpos($foto_base64, ',') + 1);
                $type = strtolower($type[1]); // png, jpeg, etc.
                if (in_array($type, ['jpg', 'jpeg', 'png', 'gif'])) {
                    $data = base64_decode($data);
                    if ($data !== false) {
                        $newName = bin2hex(random_bytes(10)) . '.' . $type;
                        $uploadPath = ROOTPATH . 'public/uploads/profile/';
                        
                        if (!is_dir($uploadPath)) {
                            mkdir($uploadPath, 0777, true);
                        }

                        // Remove old photo if exists
                        if (!empty($pasien['foto'])) {
                            $oldFilePath = $uploadPath . $pasien['foto'];
                            if (file_exists($oldFilePath)) {
                                @unlink($oldFilePath);
                            }
                        }

                        if (file_put_contents($uploadPath . $newName, $data) !== false) {
                            $pasienModel->update($id_pasien, [
                                'foto'            => $newName,
                                'foto_updated_at' => date('Y-m-d H:i:s')
                            ]);
                            return redirect()->to(base_url('profil_pasien'))->with('success', 'Foto profil berhasil diperbarui.');
                        }
                    }
                }
            }
            return redirect()->to(base_url('profil_pasien'))->with('error', 'Format gambar crop tidak valid.');
        }

        // Fallback to standard upload
        $validationRules = [
            'foto' => [
                'rules' => 'uploaded[foto]|max_size[foto,2048]|is_image[foto]|mime_in[foto,image/png,image/jpg,image/jpeg,image/gif]',
                'errors' => [
                    'uploaded' => 'Harap pilih file foto terlebih dahulu.',
                    'max_size' => 'Ukuran foto maksimal adalah 2MB.',
                    'is_image' => 'File harus berupa gambar.',
                    'mime_in'  => 'Format gambar harus berupa PNG, JPG, JPEG, atau GIF.'
                ]
            ]
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->to(base_url('profil_pasien'))->with('error', $this->validator->getError('foto'));
        }

        $file = $this->request->getFile('foto');
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $uploadPath = ROOTPATH . 'public/uploads/profile/';
            
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Remove old photo if exists
            if (!empty($pasien['foto'])) {
                $oldFilePath = $uploadPath . $pasien['foto'];
                if (file_exists($oldFilePath)) {
                    @unlink($oldFilePath);
                }
            }

            if ($file->move($uploadPath, $newName)) {
                $pasienModel->update($id_pasien, [
                    'foto'            => $newName,
                    'foto_updated_at' => date('Y-m-d H:i:s')
                ]);
                return redirect()->to(base_url('profil_pasien'))->with('success', 'Foto profil berhasil diperbarui.');
            }
        }

        return redirect()->to(base_url('profil_pasien'))->with('error', 'Gagal mengunggah foto.');
    }

    public function updateInfo()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('login'))->with('error', 'Akses ditolak.');
        }

        $id_pasien = session()->get('id_referensi');
        $no_telp = $this->request->getPost('no_telp');

        $pasienModel = new Modelpasien();
        $pasien = $pasienModel->find($id_pasien);

        if ($pasien) {
            $pasienModel->update($id_pasien, [
                'no_telp' => $no_telp,
            ]);
            return redirect()->to(base_url('profil_pasien'))->with('success', 'Informasi Nomor Telepon berhasil diperbarui.');
        }

        return redirect()->to(base_url('profil_pasien'))->with('error', 'Data pasien tidak ditemukan.');
    }

    public function updatePassword()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('login'))->with('error', 'Akses ditolak.');
        }

        $id_pasien = session()->get('id_referensi');
        $password = $this->request->getPost('password');
        $confirm_password = $this->request->getPost('confirm_password');

        if (empty($password)) {
            return redirect()->to(base_url('profil_pasien'))->with('error', 'Password baru harus diisi.');
        }

        if (strlen($password) < 6) {
            return redirect()->to(base_url('profil_pasien'))->with('error', 'Password minimal terdiri dari 6 karakter.');
        }

        if ($password !== $confirm_password) {
            return redirect()->to(base_url('profil_pasien'))->with('error', 'Konfirmasi password baru tidak cocok.');
        }

        $userModel = new UserModel();
        $user = $userModel->where('id_referensi', $id_pasien)->where('id_level', 2)->first();

        if ($user) {
            $userModel->update($user['id_user'], [
                'password' => md5($password)
            ]);
            return redirect()->to(base_url('profil_pasien'))->with('success', 'Password berhasil diperbarui.');
        }

        return redirect()->to(base_url('profil_pasien'))->with('error', 'User tidak ditemukan.');
    }
    public function konfirmasiPengambilan($id)
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('login'))->with('error', 'Akses ditolak.');
        }

        $id_pasien = session()->get('id_referensi');
        $resepModel = new Modelresep();
        $resep = $resepModel->where('id_resep', $id)->where('id_pasien', $id_pasien)->first();

        if (!$resep) {
            return redirect()->to(base_url('resep_pasien'))->with('error', 'Resep tidak ditemukan.');
        }

        if (($resep['status'] ?? 'menunggu') !== 'diproses') {
            return redirect()->to(base_url('resep_pasien'))->with('error', 'Resep belum siap diambil. Tunggu konfirmasi Apoteker.');
        }

        $resepModel->update($id, ['status' => 'selesai']);
        return redirect()->to(base_url('resep_pasien'))->with('success', 'Obat berhasil dikonfirmasi pengambilannya!');
    }

    public function rekamMedisDetail($id)
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('login'))->with('error', 'Akses ditolak.');
        }

        $id_pasien = session()->get('id_referensi');
        $db = \Config\Database::connect();

        $rekmed = $db->table('tb_rekam_medis rm')
            ->select('rm.*, p.nama AS nama_pasien, d.nama AS nama_dokter, d.spesialisasi')
            ->join('tb_pasien p', 'p.id_pasien = rm.id_pasien')
            ->join('tb_dokter d', 'd.id_dokter = rm.id_dokter')
            ->where('rm.id_rekam_medis', $id)
            ->where('rm.id_pasien', $id_pasien)
            ->get()->getRowArray();

        if (!$rekmed) {
            return redirect()->to(base_url('rekam_medis_pasien'))->with('error', 'Data rekam medis tidak ditemukan.');
        }

        // Ambil resep terkait rekam medis ini
        $resepModel = new Modelresep();
        $detailResepModel = new Modeldetailresep();
        $resepList = $resepModel->where('id_pasien', $rekmed['id_pasien'])->where('id_dokter', $rekmed['id_dokter'])->orderBy('tgl_resep', 'DESC')->findAll(3);

        $data = [
            'title'    => 'Detail Rekam Medis',
            'rekmed'   => $rekmed,
            'resepList' => $resepList,
        ];
        return view('dashboard/rekam_medis_detail', $data);
    }
}
