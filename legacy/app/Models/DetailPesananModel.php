<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailPesananModel extends Model
{
    protected $table         = 'detail_pesanan';
    protected $primaryKey    = 'id_detail';
    protected $allowedFields = ['id_pesanan', 'id_produk', 'jumlah', 'harga'];

    public function getByPesanan($id_pesanan)
    {
        return $this->db->table('detail_pesanan d')
            ->select('d.*, p.nama_produk, p.foto')
            ->join('produk p', 'p.id_produk = d.id_produk')
            ->where('d.id_pesanan', $id_pesanan)
            ->get()->getResultArray();
    }
}
