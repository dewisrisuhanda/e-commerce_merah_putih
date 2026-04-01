<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProdukModel;

class Products extends BaseController
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
        $r = $this->cekAdmin();
        if ($r) return $r;
        $model  = new ProdukModel();
        $produk = $model->orderBy('id_produk', 'DESC')->findAll();
        return view('admin/produk/index', ['produk' => $produk]);
    }

    public function tambah()
    {
        $r = $this->cekAdmin();
        if ($r) return $r;
        return view('admin/produk/form', ['produk' => null]);
    }

    public function simpan()
    {
        $r = $this->cekAdmin();
        if ($r) return $r;
        $model = new ProdukModel();

        $rules = [
            'nama_produk' => 'required|min_length[3]',
            'harga'       => 'required|numeric',
            'stok'        => 'required|numeric',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model->insert([
            'nama_produk' => $this->request->getPost('nama_produk'),
            'kategori'    => $this->request->getPost('kategori'),
            'harga'       => $this->request->getPost('harga'),
            'stok'        => $this->request->getPost('stok'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'foto'        => $this->request->getPost('foto'),
            'id_penjual'  => session()->get('id_user'),
        ]);

        return redirect()->to(base_url('admin/produk'))->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit($id_produk)
    {
        $r = $this->cekAdmin();
        if ($r) return $r;
        $model  = new ProdukModel();
        $produk = $model->find($id_produk);
        if (!$produk) return redirect()->to(base_url('admin/produk'))->with('error', 'Produk tidak ditemukan.');
        return view('admin/produk/form', ['produk' => $produk]);
    }

    public function update($id_produk)
    {
        $r = $this->cekAdmin();
        if ($r) return $r;
        $model = new ProdukModel();

        $rules = [
            'nama_produk' => 'required|min_length[3]',
            'harga'       => 'required|numeric',
            'stok'        => 'required|numeric',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model->update($id_produk, [
            'nama_produk' => $this->request->getPost('nama_produk'),
            'kategori'    => $this->request->getPost('kategori'),
            'harga'       => $this->request->getPost('harga'),
            'stok'        => $this->request->getPost('stok'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'foto'        => $this->request->getPost('foto'),
        ]);

        return redirect()->to(base_url('admin/produk'))->with('success', 'Produk berhasil diupdate!');
    }

    public function hapus($id_produk)
    {
        $r = $this->cekAdmin();
        if ($r) return $r;
        $model = new ProdukModel();
        $model->delete($id_produk);
        return redirect()->to(base_url('admin/produk'))->with('success', 'Produk berhasil dihapus.');
    }
}
