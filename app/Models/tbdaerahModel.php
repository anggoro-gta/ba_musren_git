<?php

namespace App\Models;

use CodeIgniter\Model;

class tbdaerahModel extends Model
{
    protected $table = 'tb_daerah';
    protected $useTimestamps = true;
    protected $allowedFields = ['kode_daerah', 'parent_kode_provinsi', 'nama_daerah'];
}
