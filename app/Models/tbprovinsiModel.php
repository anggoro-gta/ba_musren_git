<?php

namespace App\Models;

use CodeIgniter\Model;

class tbprovinsiModel extends Model
{
    protected $table = 'tb_provinsi';
    protected $useTimestamps = true;
    protected $allowedFields = ['kode_provinsi', 'nama_provinsi'];
}
