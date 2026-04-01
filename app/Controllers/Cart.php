<?php

namespace App\Controllers;

use App\Models\ProdukModel;

class Cart extends BaseController
{
    public function index()
    {
        $keranjang = session()->get('keranjang') ?? [];
        return view('cart/index', ['keranjang' => $keranjang]);
    }

    public function tambah()
    {
        if (! session()->get('id_user')) {
            return redirect()->to('/login')->with('error', 'Login dulu untuk belanja.');
        }

        $id_produk = $this->request->getPost('id_produk');
        $jumlah    = (int) $this->request->getPost('jumlah') ?: 1;

        $model  = new ProdukModel();
        $produk = $model->find($id_produk);

        if (! $produk) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        $keranjang = session()->get('keranjang') ?? [];

        if (isset($keranjang[$id_produk])) {
            $keranjang[$id_produk]['jumlah'] += $jumlah;
        } else {
            $keranjang[$id_produk] = [
                'id_produk'   => $produk['id_produk'],
                'nama_produk' => $produk['nama_produk'],
                'harga'       => $produk['harga'],
                'foto'        => $produk['foto'],
                'jumlah'      => $jumlah,
            ];
        }

        session()->set('keranjang', $keranjang);
        return redirect()->to('/keranjang')->with('success', 'Produk ditambahkan ke keranjang.');
    }

    public function update()
    {
        $id_produk = $this->request->getPost('id_produk');
        $jumlah    = (int) $this->request->getPost('jumlah');
        $keranjang = session()->get('keranjang') ?? [];

        if ($jumlah <= 0) {
            unset($keranjang[$id_produk]);
        } else {
            $keranjang[$id_produk]['jumlah'] = $jumlah;
        }

        session()->set('keranjang', $keranjang);
        return redirect()->to('/keranjang');
    }

    public function hapus()
    {
        $id_produk = $this->request->getPost('id_produk');
        $keranjang = session()->get('keranjang') ?? [];
        unset($keranjang[$id_produk]);
        session()->set('keranjang', $keranjang);
        return redirect()->to('/keranjang')->with('success', 'Produk dihapus dari keranjang.');
    }
}