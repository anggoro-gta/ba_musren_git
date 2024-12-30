<?php

namespace App\Models;

use CodeIgniter\Model;

class tbsasaranpdModel extends Model
{
    protected $table = 'tb_sasaranpd';
    protected $useTimestamps = true;
    protected $allowedFields = ['fr_kode_user', 'fr_id_tujuanpd', 'sasaranpd'];

    public function getfridtujuanpd($kode_user)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tb_sasaranpd');
        $builder->select('fr_id_tujuanpd');
        $array = ['fr_kode_user' => $kode_user];
        $builder->where($array);
        $builder->distinct();
        $query = $builder->get();

        return $query->getResultArray();
    }

    public function getsasaranpd($kode_user)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tb_sasaranpd');
        $builder->select('id_sasaranpd, fr_kode_user, fr_id_tujuanpd, sasaranpd');
        $array = ['fr_kode_user' => $kode_user];
        $builder->where($array);
        $query = $builder->get();

        return $query->getResultArray();
    }

    public function savesasaranpd($kode_skpd, $id_tujuanpd, $sasaranpd)
    {
        date_default_timezone_set('Asia/Jakarta');
        $dateformat = date("Y-m-d H:i:s");
        $db = \Config\Database::connect();
        $builder = $db->table('tb_sasaranpd');
        $data = [
            'fr_kode_user'  => $kode_skpd,
            'fr_id_tujuanpd'  => $id_tujuanpd,
            'sasaranpd' => $sasaranpd,
            'created_at' => $dateformat,
            'updated_at' => $dateformat,
        ];
        $builder->insert($data);
    }

    public function getsasaranpdbyidandkodeskpd($id, $kode_user)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tb_sasaranpd');
        $builder->select('id_sasaranpd, fr_kode_user, fr_id_tujuanpd, sasaranpd');
        $array = ['id_sasaranpd' => $id, 'fr_kode_user' => $kode_user];
        $builder->where($array);
        $query = $builder->get();

        return $query->getResultArray();
    }

    public function updatesasaranpd($id_sasaranpd, $sasranpd, $id_tujuanpd)
    {
        date_default_timezone_set('Asia/Jakarta');
        $updatedate = date("Y-m-d H:i:s");
        $db = \Config\Database::connect();
        $builder = $db->table('tb_sasaranpd');
        $data = [
            'fr_id_tujuanpd'  => $id_tujuanpd,
            'sasaranpd' => $sasranpd,
            'updated_at' => $updatedate,
        ];

        $builder->where('id_sasaranpd', $id_sasaranpd);
        $builder->update($data);
    }

    public function deletesasaranpdbyid($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tb_sasaranpd');
        $builder->delete(['id_sasaranpd' => $id]);
    }

    public function getfridtujuanpd_distinc($kode_user)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tb_sasaranpd');
        $builder->select('fr_id_tujuanpd');
        $array = ['fr_kode_user' => $kode_user];
        $builder->where($array);
        $builder->distinct();
        $query = $builder->get();

        return $query->getResultArray();
    }
}
