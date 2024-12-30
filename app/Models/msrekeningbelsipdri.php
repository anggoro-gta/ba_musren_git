<?php

namespace App\Models;

use CodeIgniter\Model;

class msrekeningbelsipdri extends Model
{
    protected $table = 'ms_urusan_program';
    protected $useTimestamps = true;
    // protected $allowedFields = ['kode_sasaran', 'sasaran', 'fr_id_visi', 'fr_id_misi', 'fr_id_tujuan'];

    public function insertdatamastersipdri($data)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('ms_urusan_program');
        $builder->insertBatch($data);
    }
}
