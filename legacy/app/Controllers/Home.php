<?php

namespace App\Controllers;

use App\Models\ProdukModel;

class Home extends BaseController
{
    public function beranda()
    {
        $model = new ProdukModel();
        // Ambil 4 produk terbaru untuk preview di beranda
        $produkUnggulan = array_slice($model->getAllAktif(), 0, 4);

        return view('home/beranda', [
            'produkUnggulan' => $produkUnggulan,
        ]);
    }

    public function index()
    {
        $model    = new ProdukModel();
        $keyword  = $this->request->getGet('cari');
        $kategori = $this->request->getGet('kategori');

        $semuaProduk = $model->getAllAktif();

        if ($keyword) {
            $semuaProduk = array_filter($semuaProduk, function ($p) use ($keyword) {
                return stripos($p['nama_produk'], $keyword) !== false;
            });
        }

        $allKategori = [];
        foreach ($model->getAllAktif() as $p) {
            if (!empty($p['kategori']) && !in_array($p['kategori'], $allKategori)) {
                $allKategori[] = $p['kategori'];
            }
        }

        if ($kategori && $kategori !== 'Semua') {
            $produkTampil = array_filter($semuaProduk, function ($p) use ($kategori) {
                return $p['kategori'] === $kategori;
            });
        } else {
            $produkTampil = $semuaProduk;
        }

        return view('home/index', [
            'produk'        => array_values($produkTampil),
            'keyword'       => $keyword,
            'kategoriAktif' => $kategori ?: 'Semua',
            'allKategori'   => $allKategori,
        ]);
    }

    public function detail($id_produk)
    {
        $model  = new ProdukModel();
        $produk = $model->find($id_produk);

        if (!$produk) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Produk tidak ditemukan.');
        }

        return view('home/detail', ['produk' => $produk]);
    }
}
