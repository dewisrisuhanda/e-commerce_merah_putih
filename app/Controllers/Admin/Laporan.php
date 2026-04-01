<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProdukModel;
use App\Models\PesananModel;

class Laporan extends BaseController
{
    private function cekAdmin()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to(base_url('/'))->with('error', 'Akses ditolak.');
        }
        return null;
    }

    public function penjualan()
    {
        $r = $this->cekAdmin();
        if ($r) return $r;

        $db      = \Config\Database::connect();
        $revenue = $db->query("SELECT COALESCE(SUM(total_harga),0) as total FROM pesanan WHERE status='selesai'")->getRow();
        $terjual = $db->query("SELECT COALESCE(SUM(jumlah),0) as total FROM detail_pesanan")->getRow();
        $rows    = $db->query("SELECT kategori, COUNT(*) as total FROM produk WHERE kategori IS NOT NULL GROUP BY kategori")->getResultArray();

        $kat_counts = [];
        foreach ($rows as $row) {
            $kat_counts[$row['kategori']] = $row['total'];
        }

        return view('admin/laporan/penjualan', [
            'total_revenue' => $revenue->total ?? 0,
            'total_terjual' => $terjual->total ?? 0,
            'total_pesanan' => (new PesananModel())->where('status', 'selesai')->countAllResults(),
            'produk_list'   => (new ProdukModel())->orderBy('stok', 'ASC')->findAll(),
            'kat_counts'    => $kat_counts,
        ]);
    }

    public function keuangan()
    {
        $r = $this->cekAdmin();
        if ($r) return $r;

        $db    = \Config\Database::connect();
        $masuk = $db->query("SELECT COALESCE(SUM(total_harga),0) as total FROM pesanan WHERE status='selesai'")->getRow();
        $pend  = $db->query("SELECT COUNT(*) as total FROM pesanan WHERE status='pending'")->getRow();
        $batal = $db->query("SELECT COUNT(*) as total FROM pesanan WHERE status='dibatalkan'")->getRow();

        return view('admin/laporan/keuangan', [
            'total_masuk'   => $masuk->total ?? 0,
            'total_pending' => $pend->total ?? 0,
            'total_batal'   => $batal->total ?? 0,
            'pesanan_list'  => (new PesananModel())->getAllWithUser(),
        ]);
    }
}
