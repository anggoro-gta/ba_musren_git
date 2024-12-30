<?php

namespace App\Models;

use CodeIgniter\Model;

class mstujuandetailModel extends Model
{
    protected $table = 'ms_tujuan_detail';
    protected $useTimestamps = true;
    protected $allowedFields = ['indikator_tujuan', 'tahun', 'nilai', 'satuan', 'fr_id_tujuan', 'fr_id_periode'];

    public function getdata($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('ms_tujuan_detail');
        $builder->select('id_tujuan_detail, indikator_tujuan, tahun, nilai, satuan');
        $array = ['fr_id_tujuan' => $id];
        $builder->where($array);
        $query = $builder->get();

        return $query->getResultArray();
    }

    public function getindikator($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('ms_tujuan_detail');
        $builder->select('indikator_tujuan, fr_id_tujuan');
        $array = ['fr_id_tujuan' => $id];
        $builder->where($array);
        $builder->distinct();
        $query = $builder->get();

        return $query->getResultArray();
    }

    public function getindikatoredit($id, $indikator)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('ms_tujuan_detail');
        $builder->select('id_tujuan_detail, indikator_tujuan, tahun, nilai, satuan');
        $array =
            [
                'fr_id_tujuan' => $id,
                'indikator_tujuan' => $indikator
            ];
        $builder->where($array);
        $query = $builder->get();

        return $query->getResultArray();
    }

    public function updatedatadetail($id, $value, $satuan)
    {
        date_default_timezone_set('Asia/Jakarta');
        $updatedate = date("Y-m-d H:i:s");
        $db = \Config\Database::connect();
        $builder = $db->table('ms_tujuan_detail');
        $data = [
            'nilai'  => $value,
            'satuan'  => $satuan,
            'updated_at' => $updatedate,
        ];

        $builder->where('id_tujuan_detail', $id);
        $builder->update($data);
    }
}
