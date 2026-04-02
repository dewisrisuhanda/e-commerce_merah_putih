<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProdukModel;
use App\Models\PesananModel;
use App\Models\UsersModel;

class Dashboard extends BaseController
{
    private function cekAdmin()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to(base_url('/'))->with('error', 'Akses ditolak.');
        }
        return null;
    }

    public function index()
    {
        $redirect = $this->cekAdmin();
        if ($redirect) return $redirect;

        $db           = \Config\Database::connect();
        $produkModel  = new ProdukModel();
        $pesananModel = new PesananModel();
        $usersModel   = new UsersModel();

        $revenue = $db->query("SELECT COALESCE(SUM(total_harga),0) as total FROM pesanan WHERE status = 'selesai'")->getRow();
        $pending = $db->query("SELECT COUNT(*) as total FROM pesanan WHERE status = 'pending'")->getRow();

        // Hitung jumlah produk per kategori
        $rows = $db->query("SELECT kategori, COUNT(*) as total FROM produk WHERE kategori IS NOT NULL GROUP BY kategori")->getResultArray();
        $kat_counts = [];
        foreach ($rows as $row) {
            $kat_counts[$row['kategori']] = $row['total'];
        }

        $data = [
            'total_produk'    => $produkModel->countAll(),
            'total_pesanan'   => $pesananModel->countAll(),
            'total_user'      => $usersModel->where('role', 'pembeli')->countAllResults(),
            'total_revenue'   => $revenue->total ?? 0,
            'total_pending'   => $pending->total ?? 0,
            'pesanan_terbaru' => $pesananModel->getAllWithUser(),
            'produk_terlaris' => $produkModel->orderBy('stok', 'ASC')->limit(5)->findAll(),
            'kat_counts'      => $kat_counts,
        ];

        return view('admin/dashboard', $data);
    }
}
