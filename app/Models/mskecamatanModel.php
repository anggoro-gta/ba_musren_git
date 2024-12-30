<?php

namespace App\Models;

use CodeIgniter\Model;

class mskecamatanModel extends Model
{
    protected $table = 'ms_kecamatan';
    protected $useTimestamps = true;
    // protected $allowedFields = ['kode_tujuan', 'tujuan', 'fr_id_visi', 'fr_id_misi'];

    public function getkecamatanarray()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('ms_kecamatan');
        $builder->select('*');                
        $query = $builder->get();

        return $query->getResultArray();
    }    
}
