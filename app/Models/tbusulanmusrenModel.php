<?php

namespace App\Models;

use CodeIgniter\Model;

class tbusulanmusrenModel extends Model
{
    protected $table = 'tb_usulan_musren';
    protected $useTimestamps = true;
    // protected $allowedFields = ['fr_id_visi', 'fr_id_misi', 'tujuanpd'];

    public function countusulan($idbidang, $idkecamatan)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tb_usulan_musren');

        $builder->selectCount('id_usulan');

        $array = ['id_bidang' => $idbidang, 'id_kecamatan' => $idkecamatan];
        $builder->where($array);
        $query = $builder->get();

        $total = $query->getResultArray();        

        $count = count($total);

        $dataresults = 0;
        for ($i = 0; $i < $count; $i++) {
            $dataresults = $total[$i]['id_usulan'];
        }
        return $dataresults;
    }

    public function countvalidasi($idbidang, $idkecamatan)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tb_usulan_musren');

        $builder->selectSum('count_validasi');

        $array = ['id_bidang' => $idbidang, 'id_kecamatan' => $idkecamatan];
        $builder->where($array);
        $query = $builder->get();

        $total = $query->getResultArray();   
        
        $hasil = $total[0]['count_validasi'];

        // $count = count($total);

        // $dataresults = 0;
        // for ($i = 0; $i < $count; $i++) {
        //     $dataresults = $total[$i]['count_validasi'];
        // }
        return $hasil;
    }
}
