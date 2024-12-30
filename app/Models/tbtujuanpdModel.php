<?php

namespace App\Models;

use CodeIgniter\Model;

class tbtujuanpdModel extends Model
{
    protected $table = 'tb_tujuanpd';
    protected $useTimestamps = true;
    protected $allowedFields = ['fr_id_visi', 'fr_id_misi', 'tujuanpd'];

    public function savetujuanpd($fr_id_visi, $fr_id_misi, $kode_user, $tujuanpd)
    {
        date_default_timezone_set('Asia/Jakarta');
        $dateformat = date("Y-m-d H:i:s");
        $db = \Config\Database::connect();
        $builder = $db->table('tb_tujuanpd');
        $data = [
            'fr_id_visi'  => $fr_id_visi,
            'fr_id_misi'  => $fr_id_misi,
            'fr_kode_user' => $kode_user,
            'tujuanpd'  => $tujuanpd,
            'created_at' => $dateformat,
            'updated_at' => $dateformat,
        ];
        $builder->insert($data);
    }

    // public function saveindikatortujuanpd($indikator, $tahun, $nilai, $satuan, $fr_id_tujuanpd)
    // {
    //     date_default_timezone_set('Asia/Jakarta');
    //     $dateformat = date("Y-m-d H:i:s");
    //     $db = \Config\Database::connect();
    //     $builder = $db->table('tb_tujuanpd_detail');
    //     $data = [
    //         'indikator_tujuanpd'  => $indikator,
    //         'tahun'  => $tahun,
    //         'nilai' => $nilai,
    //         'satuan'  => $satuan,
    //         'fr_id_tujuanpd' => $fr_id_tujuanpd,
    //         'created_at' => $dateformat,
    //         'updated_at' => $dateformat,
    //     ];
    //     $builder->insert($data);
    // }

    public function gettujuanpd($kode_user)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tb_tujuanpd');
        $builder->select('id_tujuanpd, fr_id_visi, fr_id_misi, fr_kode_user, tujuanpd');
        $array = ['fr_kode_user' => $kode_user];
        $builder->where($array);
        $query = $builder->get();

        return $query->getResultArray();
    }

    public function gettujuanpdbyid($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tb_tujuanpd');
        $builder->select('id_tujuanpd, tujuanpd');
        $array = ['id_tujuanpd' => $id];
        $builder->where($array);
        $query = $builder->get();

        return $query->getResultArray();
    }

    public function gettujuanpd_where($where_clause)
    {

        $db = \Config\Database::connect();
        $builder = $db->table('tb_tujuanpd');
        $builder->select('id_tujuanpd, fr_id_visi, fr_id_misi, fr_kode_user, tujuanpd');
        $where = $where_clause;
        $builder->where($where);
        // $builder->distinct();
        $query = $builder->get();

        return $query->getResultArray();
    }

    public function gettujuanpdbyidandkodeskpd($id, $kode_user)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tb_tujuanpd');
        $builder->select('id_tujuanpd, fr_id_visi, fr_id_misi, fr_kode_user, tujuanpd');
        $array = ['id_tujuanpd' => $id, 'fr_kode_user' => $kode_user];
        $builder->where($array);
        $query = $builder->get();

        return $query->getResultArray();
    }

    public function getfridmisi_distinc($kode_user)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tb_tujuanpd');
        $builder->select('fr_id_misi');
        $array = ['fr_kode_user' => $kode_user];
        $builder->where($array);
        $builder->distinct();
        $query = $builder->get();

        return $query->getResultArray();
    }

    public function getfridmisi($where_clause)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tb_tujuanpd');
        $builder->select('fr_id_misi');
        $where = $where_clause;
        $builder->where($where);
        // $builder->distinct();
        $query = $builder->get();

        return $query->getResultArray();
    }

    public function updatetujuanpd($id_tujuanpd, $id_visi, $id_misi, $tujuanpd)
    {
        date_default_timezone_set('Asia/Jakarta');
        $updatedate = date("Y-m-d H:i:s");
        $db = \Config\Database::connect();
        $builder = $db->table('tb_tujuanpd');
        $data = [
            'fr_id_visi'  => $id_visi,
            'fr_id_misi' => $id_misi,
            'tujuanpd' => $tujuanpd,
            'updated_at' => $updatedate,
        ];

        $builder->where('id_tujuanpd', $id_tujuanpd);
        $builder->update($data);
    }

    public function deletetujuanpdbyid($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tb_tujuanpd');
        $builder->delete(['id_tujuanpd' => $id]);
    }

    //API untuk controller Entrysasaranpd
    public function apigettujuanpdterm($kode_user, $term)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tb_tujuanpd');
        $builder->select('id_tujuanpd, tujuanpd');
        $array = ['fr_kode_user' => $kode_user];
        $builder->where($array);
        $builder->like('tujuanpd', $term);
        $query = $builder->get();

        return $query->getResultArray();
    }

    public function apigettujuanpdnoterm($kode_user)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tb_tujuanpd');
        $builder->select('id_tujuanpd, tujuanpd');
        $array = ['fr_kode_user' => $kode_user];
        $builder->where($array);
        $query = $builder->get();

        return $query->getResultArray();
    }
    //END - API untuk controller Entrysasaranpd
}
