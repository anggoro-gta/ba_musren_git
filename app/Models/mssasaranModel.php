<?php

namespace App\Models;

use CodeIgniter\Model;

class mssasaranModel extends Model
{
    protected $table = 'ms_sasaran';
    protected $useTimestamps = true;
    protected $allowedFields = ['kode_sasaran', 'sasaran', 'fr_id_visi', 'fr_id_misi', 'fr_id_tujuan'];

    public function getsasaran($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('ms_sasaran');
        $builder->select('id_sasaran, sasaran');
        $array = ['id_sasaran' => $id];
        $builder->where($array);
        $query = $builder->get();

        return $query->getRow();
    }

    public function getsasaranarray($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('ms_sasaran');
        $builder->select('id_sasaran, sasaran');
        $array = ['id_sasaran' => $id];
        $builder->where($array);
        $query = $builder->get();

        return $query->getResultArray();
    }

    public function updatesasaran($id, $sasaran)
    {
        date_default_timezone_set('Asia/Jakarta');
        $updatedate = date("Y-m-d H:i:s");
        $db = \Config\Database::connect();
        $builder = $db->table('ms_sasaran');
        $data = [
            'sasaran'  => $sasaran,
            'updated_at' => $updatedate,
        ];

        $builder->where('id_sasaran', $id);
        $builder->update($data);
    }

    public function deletebyid($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('ms_sasaran');
        $builder->delete(['id_sasaran' => $id]);
    }
}
