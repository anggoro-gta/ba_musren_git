<?php

namespace App\Models;

use CodeIgniter\Model;

class msvisiModel extends Model
{
    protected $table = 'ms_visi';
    protected $useTimestamps = true;
    protected $allowedFields = ['visi'];

    public function getvisiarray($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('ms_visi');
        $builder->select('id_visi, visi');
        $array = ['id_visi' => $id];
        $builder->where($array);
        $query = $builder->get();

        return $query->getResultArray();
    }
}
