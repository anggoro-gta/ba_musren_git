<?php

namespace App\Models;

use CodeIgniter\Model;

class msprogramopdModel extends Model
{
    protected $table = 'ms_program_opd';
    protected $useTimestamps = true;
    // protected $allowedFields = ['email', 'username'];

    public function getalldata()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('ms_program_opd');
        $builder->select('kode_program,nama_program,nama_opd,pagu');
        $query = $builder->get();

        return $query->getResultArray();
    }
}
