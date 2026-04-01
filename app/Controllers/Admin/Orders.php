<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PesananModel;
use App\Models\DetailPesananModel;

class Orders extends BaseController
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
        $r = $this->cekAdmin(); if ($r) return $r;
        $model   = new PesananModel();
        $pesanan = $model->getAllWithUser();
        return view('admin/pesanan/index', ['pesanan' => $pesanan]);
    }

    public function detail($id_pesanan)
    {
        $r = $this->cekAdmin(); if ($r) return $r;
        $pesananModel = new PesananModel();
        $detailModel  = new DetailPesananModel();
        $pesanan = $pesananModel->find($id_pesanan);
        $detail  = $detailModel->getByPesanan($id_pesanan);
        return view('admin/pesanan/detail', [
            'pesanan' => $pesanan,
            'detail'  => $detail,
        ]);
    }

    public function updateStatus()
    {
        $r = $this->cekAdmin(); if ($r) return $r;
        $model      = new PesananModel();
        $id_pesanan = $this->request->getPost('id_pesanan');
        $status     = $this->request->getPost('status');
        $model->update($id_pesanan, ['status' => $status]);
        return redirect()->back()->with('success', 'Status pesanan diperbarui.');
    }
}