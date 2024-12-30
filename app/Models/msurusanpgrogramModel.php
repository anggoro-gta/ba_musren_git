<?php

namespace App\Models;

use CodeIgniter\Model;

class msurusanpgrogramModel extends Model
{
    protected $table = 'ms_urusan_program';
    protected $useTimestamps = true;
    // protected $allowedFields = ['email', 'username'];

    public function getdataurusan($kodeprog)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('ms_urusan_program');
        $builder->select('kode_urusan,nama_urusan,kode_program,nama_program');
        $array = ['kode_program' => $kodeprog];
        $builder->where($array);
        $query = $builder->get();

        return $query->getResultArray();
    }
}
