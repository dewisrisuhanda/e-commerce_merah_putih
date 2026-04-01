<?php

namespace App\Models;

use CodeIgniter\Model;

class PesananModel extends Model
{
    protected $table         = 'pesanan';
    protected $primaryKey    = 'id_pesanan';
    protected $allowedFields = ['id_user', 'tanggal', 'status', 'total_harga', 'metode_bayar', 'metode_kirim', 'alamat_kirim'];

    public function getByUser($id_user)
    {
        return $this->where('id_user', $id_user)
            ->orderBy('tanggal', 'DESC')
            ->findAll();
    }

    public function getAllWithUser()
    {
        return $this->db->table('pesanan p')
            ->select('p.*, u.nama, u.email, u.alamat')
            ->join('users u', 'u.id_user = p.id_user')
            ->orderBy('p.tanggal', 'DESC')
            ->get()->getResultArray();
    }
}
