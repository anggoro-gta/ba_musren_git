<?php

namespace App\Models;

use CodeIgniter\Model;

class mstujuanModel extends Model
{
    protected $table = 'ms_tujuan';
    protected $useTimestamps = true;
    protected $allowedFields = ['kode_tujuan', 'tujuan', 'fr_id_visi', 'fr_id_misi'];

    public function gettujuan($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('ms_tujuan');
        $builder->select('id_tujuan, tujuan');
        $array = ['id_tujuan' => $id];
        $builder->where($array);
        $query = $builder->get();

        return $query->getRow();
    }

    public function gettujuanarray($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('ms_tujuan');
        $builder->select('id_tujuan, tujuan');
        $array = ['id_tujuan' => $id];
        $builder->where($array);
        $query = $builder->get();

        return $query->getResultArray();
    }

    public function updatetujuan($id, $tujuan)
    {
        date_default_timezone_set('Asia/Jakarta');
        $updatedate = date("Y-m-d H:i:s");
        $db = \Config\Database::connect();
        $builder = $db->table('ms_tujuan');
        $data = [
            'tujuan'  => $tujuan,
            'updated_at' => $updatedate,
        ];

        $builder->where('id_tujuan', $id);
        $builder->update($data);
    }

    public function deletebyid($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('ms_tujuan');
        $builder->delete(['id_tujuan' => $id]);
    }
}
