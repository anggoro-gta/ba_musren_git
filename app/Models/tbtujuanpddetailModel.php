<?php

namespace App\Models;

use CodeIgniter\Model;

class tbtujuanpddetailModel extends Model
{
    protected $table = 'tb_tujuanpd_detail';
    protected $useTimestamps = true;
    protected $allowedFields = ['indikator_tujuanpd', 'tahun', 'nilai', 'satuan', 'fr_id_tujuanpd', 'fr_id_periode'];

    public function getdatadetail($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tb_tujuanpd_detail');
        $builder->select('id_tujuanpd_detail, indikator_tujuanpd, tahun, nilai, satuan');
        $array = ['fr_id_tujuanpd' => $id];
        $builder->where($array);
        $query = $builder->get();

        return $query->getResultArray();
    }

    public function getdatadetaildistinct($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tb_tujuanpd_detail');
        $builder->select('indikator_tujuanpd, fr_id_tujuanpd');
        $array = ['fr_id_tujuanpd' => $id];
        $builder->where($array);
        $builder->distinct();
        $query = $builder->get();

        return $query->getResultArray();
    }

    public function getdatadetailedit($id, $indikator)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tb_tujuanpd_detail');
        $builder->select('id_tujuanpd_detail, indikator_tujuanpd, tahun, nilai, satuan');
        $array =
            [
                'fr_id_tujuanpd' => $id,
                'indikator_tujuanpd' => $indikator
            ];
        $builder->where($array);
        $query = $builder->get();

        return $query->getResultArray();
    }

    public function saveindikatortujuanpd($indikator, $tahun, $nilai, $satuan, $fr_id_tujuanpd)
    {
        date_default_timezone_set('Asia/Jakarta');
        $dateformat = date("Y-m-d H:i:s");
        $fr_id_periode = 1;
        $db = \Config\Database::connect();
        $builder = $db->table('tb_tujuanpd_detail');
        $data = [
            'indikator_tujuanpd'  => $indikator,
            'tahun'  => $tahun,
            'nilai' => $nilai,
            'satuan'  => $satuan,
            'fr_id_tujuanpd' => $fr_id_tujuanpd,
            'fr_id_periode' => $fr_id_periode,
            'created_at' => $dateformat,
            'updated_at' => $dateformat,
        ];
        $builder->insert($data);
    }

    public function updatetujuanpddetail($id, $value, $satuan, $indikator)
    {
        date_default_timezone_set('Asia/Jakarta');
        $updatedate = date("Y-m-d H:i:s");
        $fr_id_periode = 1;
        $db = \Config\Database::connect();
        $builder = $db->table('tb_tujuanpd_detail');
        $data = [
            'indikator_tujuanpd' => $indikator,
            'nilai'  => $value,
            'satuan'  => $satuan,
            'fr_id_periode' => $fr_id_periode,
            'updated_at' => $updatedate,
        ];

        $builder->where('id_tujuanpd_detail', $id);
        $builder->update($data);
    }

    public function deletetujuanpdbyindikatorandid($id, $indikator)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tb_tujuanpd_detail');
        $builder->delete(['fr_id_tujuanpd' => $id, 'indikator_tujuanpd' => $indikator]);
    }

    public function cetak_getdetaildatatujuanpd($where_clause)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tb_tujuanpd_detail');
        $builder->select('id_tujuanpd_detail, indikator_tujuanpd, tahun, nilai, satuan, fr_id_tujuanpd');
        $where = $where_clause;
        $builder->where($where);
        $query = $builder->get();

        return $query->getResultArray();
    }

    public function cetak_getdetaildatatujuanpd_distinc($where_clause)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tb_tujuanpd_detail');
        $builder->select('indikator_tujuanpd, fr_id_tujuanpd');
        $where = $where_clause;
        $builder->where($where);
        $builder->distinct();
        $query = $builder->get();

        return $query->getResultArray();
    }
}
