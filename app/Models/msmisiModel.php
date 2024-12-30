<?php

namespace App\Models;

use CodeIgniter\Model;

class msmisiModel extends Model
{
    protected $table = 'ms_misi';
    protected $useTimestamps = true;
    protected $allowedFields = ['misi', 'fr_id_visi'];

    public function getmisi($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('ms_misi');
        $builder->select('id_misi, misi');
        $array = ['id_misi' => $id];
        $builder->where($array);
        $query = $builder->get();

        return $query->getRow();
    }

    public function getmisiarray($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('ms_misi');
        $builder->select('id_misi, misi');
        $array = ['id_misi' => $id];
        $builder->where($array);
        $query = $builder->get();

        return $query->getResultArray();
    }

    public function updatemisi($id, $misi)
    {
        date_default_timezone_set('Asia/Jakarta');
        $updatedate = date("Y-m-d H:i:s");
        $db = \Config\Database::connect();
        $builder = $db->table('ms_misi');
        $data = [
            'misi'  => $misi,
            'updated_at' => $updatedate,
        ];

        $builder->where('id_misi', $id);
        $builder->update($data);
    }

    public function getapimisi($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('ms_misi');
        $builder->select('id_misi, misi');
        $array = ['fr_id_visi' => $id];
        $builder->where($array);
        $query = $builder->get();

        return $query->getResultArray();
    }

    public function getapimisiterm($id, $words)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('ms_misi');
        $builder->select('id_misi, misi');
        $array = ['fr_id_visi' => $id];
        // $builder->where($array)->like('misi', $words);
        $builder->where($array);
        $builder->like('misi', $words);
        $query = $builder->get();

        return $query->getResultArray();
    }

    public function getmisibyidmisi_operasi_or($where_clause)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('ms_misi');
        $builder->select('id_misi, misi');
        $where = $where_clause;
        $builder->where($where);
        $query = $builder->get();

        return $query->getResultArray();
    }
}
