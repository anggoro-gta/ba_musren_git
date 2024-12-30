<?php

namespace App\Models;

use CodeIgniter\Model;

class mssasarandetailModel extends Model
{
    protected $table = 'ms_sasaran_detail';
    protected $useTimestamps = true;
    protected $allowedFields = ['indikator_sasaran', 'tahun', 'nilai', 'satuan', 'fr_id_sasaran', 'fr_id_periode'];

    public function getdata($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('ms_sasaran_detail');
        $builder->select('id_sasaran_detail, indikator_sasaran, tahun, nilai, satuan');
        $array = ['fr_id_sasaran' => $id];
        $builder->where($array);
        $query = $builder->get();

        return $query->getResultArray();
    }

    public function getindikator($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('ms_sasaran_detail');
        $builder->select('indikator_sasaran, fr_id_sasaran');
        $array = ['fr_id_sasaran' => $id];
        $builder->where($array);
        $builder->distinct();
        $query = $builder->get();

        return $query->getResultArray();
    }

    public function getindikatoredit($id, $indikator)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('ms_sasaran_detail');
        $builder->select('id_sasaran_detail, indikator_sasaran, tahun, nilai, satuan');
        $array =
            [
                'fr_id_sasaran' => $id,
                'indikator_sasaran' => $indikator
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
        $builder = $db->table('ms_sasaran_detail');
        $data = [
            'nilai'  => $value,
            'satuan'  => $satuan,
            'updated_at' => $updatedate,
        ];

        $builder->where('id_sasaran_detail', $id);
        $builder->update($data);
    }
}
