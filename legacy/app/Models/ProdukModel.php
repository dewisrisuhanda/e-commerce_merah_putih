<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table         = 'produk';
    protected $primaryKey    = 'id_produk';
    protected $allowedFields = ['nama_produk', 'kategori', 'harga', 'stok', 'foto', 'deskripsi', 'id_penjual'];

    public function getAllAktif()
    {
        return $this->where('stok >', 0)->orderBy('kategori', 'ASC')->findAll();
    }

    public function getByKategori($keyword)
    {
        return $this->like('nama_produk', $keyword)->findAll();
    }
}
