<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UsersModel;
use App\Models\ProdukModel;

class Kelola extends BaseController
{
    private function cekAdmin()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to(base_url('/'))->with('error', 'Akses ditolak.');
        }
        return null;
    }

    public function pengguna()
    {
        $r = $this->cekAdmin();
        if ($r) return $r;

        $model = new UsersModel();
        return view('admin/kelola/pengguna', [
            'users' => $model->orderBy('id_user', 'ASC')->findAll()
        ]);
    }

    public function kategori()
    {
        $r = $this->cekAdmin();
        if ($r) return $r;

        $db   = \Config\Database::connect();
        $rows = $db->query("SELECT kategori, COUNT(*) as total FROM produk WHERE kategori IS NOT NULL GROUP BY kategori")->getResultArray();
        $kat_counts = [];
        foreach ($rows as $row) {
            $kat_counts[$row['kategori']] = $row['total'];
        }

        return view('admin/kelola/kategori', ['kat_counts' => $kat_counts]);
    }
}
