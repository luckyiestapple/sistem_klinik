<?php

namespace App\Controllers;

use App\Models\Modelresep;
use App\Models\ModelLaporanKas;
require_once FCPATH . '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;
use Dompdf\Options;

class Export extends BaseController
{
    public function excel()
    {
        // Must be logged in and authorized (admin or specific level as needed)
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'))->with('error', 'Silakan login terlebih dahulu.');
        }

        $resepModel = new Modelresep();
        $kasModel = new ModelLaporanKas();

        $dataResep = $resepModel->getResepLengkap();
        $dataKas = $kasModel->getLaporanKas();

        $spreadsheet = new Spreadsheet();

        // Sheet 1: Data Resep & Pasien
        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('Data Resep & Pasien');
        $sheet1->setCellValue('A1', 'ID Resep');
        $sheet1->setCellValue('B1', 'Tanggal');
        $sheet1->setCellValue('C1', 'Nama Pasien');
        $sheet1->setCellValue('D1', 'Nama Dokter');
        $sheet1->setCellValue('E1', 'Status BPJS');
        $sheet1->setCellValue('F1', 'Total Harga');
        $sheet1->setCellValue('G1', 'Status');

        $row = 2;
        foreach ($dataResep as $resep) {
            $sheet1->setCellValue('A' . $row, $resep['id_resep']);
            $sheet1->setCellValue('B' . $row, $resep['tgl_resep']);
            $sheet1->setCellValue('C' . $row, $resep['nama_pasien']);
            $sheet1->setCellValue('D' . $row, $resep['nama_dokter']);
            $sheet1->setCellValue('E' . $row, $resep['status_bpjs']);
            $sheet1->setCellValue('F' . $row, $resep['total_harga']);
            $sheet1->setCellValue('G' . $row, $resep['status']);
            $row++;
        }

        // Sheet 2: Laporan Kas
        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle('Laporan Kas Pemasukan');
        $sheet2->setCellValue('A1', 'Tanggal');
        $sheet2->setCellValue('B1', 'Tipe');
        $sheet2->setCellValue('C1', 'Keterangan');
        $sheet2->setCellValue('D1', 'Nominal');


        $rowKas = 2;
        foreach ($dataKas as $kas) {
            // Include all kas, or just pemasukan? Request: "Laporan Kas Pemasukan"
            if ($kas['tipe'] == 'pemasukan') {
                $sheet2->setCellValue('A' . $rowKas, $kas['tanggal']);
                $sheet2->setCellValue('B' . $rowKas, ucfirst($kas['tipe']));
                $sheet2->setCellValue('C' . $rowKas, $kas['keterangan']);
                $sheet2->setCellValue('D' . $rowKas, $kas['nominal']);

                $rowKas++;
            }
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Export_Klinik_' . date('Ymd_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit();
    }

    public function invoicePdf($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $db = \Config\Database::connect();
        $resep = $db->table('tb_resep r')
            ->select('r.*, p.nama AS nama_pasien, p.jk, p.tgl_lahir, p.no_telp, p.status_bpjs, p.no_bpjs, d.nama AS nama_dokter, d.spesialisasi')
            ->join('tb_pasien p', 'p.id_pasien = r.id_pasien')
            ->join('tb_dokter d', 'd.id_dokter = r.id_dokter')
            ->where('r.id_resep', $id)
            ->get()->getRowArray();

        if (!$resep) {
            return redirect()->to(base_url('resep'))->with('error', 'Resep tidak ditemukan.');
        }

        $detailModel = new \App\Models\Modeldetailresep();
        $detail = $detailModel->getDetailByResep($id);

        $data = [
            'resep' => $resep,
            'detail' => $detail,
            'is_bpjs' => (strtolower($resep['status_bpjs'] ?? '') === 'aktif')
        ];

        $html = view('export/pdf_invoice', $data);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream("Invoice_Pasien_{$id}.pdf", ["Attachment" => 0]); // 0 means preview in browser
        exit();
    }

    public function restockPdf($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $db = \Config\Database::connect();
        $restock = $db->table('tb_restock r')
            ->select('r.*, o.nama_obat, o.satuan, u.username')
            ->join('tb_obat o', 'o.kode_obat = r.kode_obat')
            ->join('tb_user u', 'u.id_user = r.id_user', 'left')
            ->where('r.id_restock', $id)
            ->get()->getRowArray();

        if (!$restock) {
            return redirect()->to(base_url('restock'))->with('error', 'Data Restock tidak ditemukan.');
        }

        $data = [
            'restock' => $restock
        ];

        $html = view('export/pdf_restock', $data);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream("Detail_Restock_{$id}.pdf", ["Attachment" => 0]);
        exit();
    }
}
