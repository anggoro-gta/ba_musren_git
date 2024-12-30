<?php

namespace App\Models;

use CodeIgniter\Model;

class tbsasaranpddetailModel extends Model
{
    protected $table = 'tb_sasaranpd_detail';
    protected $useTimestamps = true;
    protected $allowedFields = ['indikator_sasaranpd', 'tahun', 'nilai', 'satuan', 'fr_id_sasaranpd', 'fr_id_periode'];

    public function saveindikatorsasaranpd($indikator, $tahun, $nilai, $satuan, $id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $dateformat = date("Y-m-d H:i:s");
        $fr_id_periode = 1;
        $db = \Config\Database::connect();
        $builder = $db->table('tb_sasaranpd_detail');
        $data = [
            'indikator_sasaranpd'  => $indikator,
            'tahun'  => $tahun,
            'nilai' => $nilai,
            'satuan'  => $satuan,
            'fr_id_sasaranpd' => $id,
            'fr_id_periode' => $fr_id_periode,
            'created_at' => $dateformat,
            'updated_at' => $dateformat,
        ];
        $builder->insert($data);
    }

    public function getdatadetail($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tb_sasaranpd_detail');
        $builder->select('id_sasaranpd_detail, indikator_sasaranpd, tahun, nilai, satuan');
        $array = ['fr_id_sasaranpd' => $id];
        $builder->where($array);
        $query = $builder->get();

        return $query->getResultArray();
    }

    public function getdatadetaildistinct($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tb_sasaranpd_detail');
        $builder->select('indikator_sasaranpd, fr_id_sasaranpd');
        $array = ['fr_id_sasaranpd' => $id];
        $builder->where($array);
        $builder->distinct();
        $query = $builder->get();

        return $query->getResultArray();
    }

    public function getdatadetailedit($id, $indikator)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tb_sasaranpd_detail');
        $builder->select('id_sasaranpd_detail, indikator_sasaranpd, tahun, nilai, satuan');
        $array =
            [
                'fr_id_sasaranpd' => $id,
                'indikator_sasaranpd' => $indikator
            ];
        $builder->where($array);
        $query = $builder->get();

        return $query->getResultArray();
    }

    public function updatesasaranpddetail($id, $value, $satuan, $indikator)
    {
        date_default_timezone_set('Asia/Jakarta');
        $updatedate = date("Y-m-d H:i:s");
        $fr_id_periode = 1;
        $db = \Config\Database::connect();
        $builder = $db->table('tb_sasaranpd_detail');
        $data = [
            'indikator_sasaranpd' => $indikator,
            'nilai'  => $value,
            'satuan'  => $satuan,
            'fr_id_periode' => $fr_id_periode,
            'updated_at' => $updatedate,
        ];

        $builder->where('id_sasaranpd_detail', $id);
        $builder->update($data);
    }

    public function deletesasaranpdbyindikatorandid($id, $indikator)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tb_sasaranpd_detail');
        $builder->delete(['fr_id_sasaranpd' => $id, 'indikator_sasaranpd' => $indikator]);
    }

    public function cetak_getdetaildatasasaranpd($where_clause)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tb_sasaranpd_detail');
        $builder->select('id_sasaranpd_detail, indikator_sasaranpd, tahun, nilai, satuan, fr_id_sasaranpd');
        $where = $where_clause;
        $builder->where($where);
        $query = $builder->get();

        return $query->getResultArray();
    }

    public function cetak_getdetaildatasasaranpd_distinc($where_clause)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tb_sasaranpd_detail');
        $builder->select('indikator_sasaranpd, fr_id_sasaranpd');
        $where = $where_clause;
        $builder->where($where);
        $builder->distinct();
        $query = $builder->get();

        return $query->getResultArray();
    }
}
