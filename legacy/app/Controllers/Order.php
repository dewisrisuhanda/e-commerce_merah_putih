<?php

namespace App\Controllers;

use App\Models\PesananModel;
use App\Models\DetailPesananModel;
use App\Models\ProdukModel;

class Order extends BaseController
{
    public function checkout()
    {
        if (! session()->get('id_user')) {
            return redirect()->to('/login');
        }

        $keranjang = session()->get('keranjang') ?? [];
        if (empty($keranjang)) {
            return redirect()->to('/keranjang')->with('error', 'Keranjang masih kosong.');
        }

        return view('order/checkout', ['keranjang' => $keranjang]);
    }

    public function proses()
    {
        if (! session()->get('id_user')) {
            return redirect()->to('/login');
        }

        $keranjang = session()->get('keranjang') ?? [];
        if (empty($keranjang)) {
            return redirect()->to('/');
        }

        $pesananModel = new PesananModel();
        $detailModel  = new DetailPesananModel();
        $produkModel  = new ProdukModel();

        // Hitung total
        $total = 0;
        foreach ($keranjang as $item) {
            $total += $item['harga'] * $item['jumlah'];
        }

        // Simpan pesanan
        $id_pesanan = $pesananModel->insert([
            'id_user'     => session()->get('id_user'),
            'tanggal'     => date('Y-m-d H:i:s'),
            'status'      => 'pending',
            'total_harga' => $total,
        ], true);

        // Simpan detail & kurangi stok
        foreach ($keranjang as $item) {
            $detailModel->insert([
                'id_pesanan' => $id_pesanan,
                'id_produk'  => $item['id_produk'],
                'jumlah'     => $item['jumlah'],
                'harga'      => $item['harga'],
            ]);

            $produk = $produkModel->find($item['id_produk']);
            $produkModel->update($item['id_produk'], [
                'stok' => max(0, $produk['stok'] - $item['jumlah']),
            ]);
        }

        // Kosongkan keranjang
        session()->remove('keranjang');

        return redirect()->to('/pesanan')->with('success', 'Pesanan berhasil dibuat!');
    }

    public function riwayat()
    {
        if (! session()->get('id_user')) {
            return redirect()->to('/login');
        }

        $model   = new PesananModel();
        $pesanan = $model->getByUser(session()->get('id_user'));

        return view('order/riwayat', ['pesanan' => $pesanan]);
    }

    public function detail($id_pesanan)
    {
        if (! session()->get('id_user')) {
            return redirect()->to('/login');
        }

        $pesananModel = new PesananModel();
        $detailModel  = new DetailPesananModel();

        $pesanan = $pesananModel->find($id_pesanan);
        $detail  = $detailModel->getByPesanan($id_pesanan);

        return view('order/detail', [
            'pesanan' => $pesanan,
            'detail'  => $detail,
        ]);
    }
}