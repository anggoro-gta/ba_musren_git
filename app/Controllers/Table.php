<?php

namespace App\Controllers;

use App\Models\tbprovinsiModel;
use App\Models\tbdaerahModel;

class Table extends BaseController
{
    protected $tb_provinsi;
    protected $tb_daerah;

    public function __construct()
    {
        $this->tb_provinsi = new tbprovinsiModel();
        $this->tb_daerah = new tbdaerahModel();
    }

    public function index()
    {
        $provinsigetdb = $this->tb_provinsi->findAll();
        $countprovinsi = $this->tb_provinsi->countAllResults();

        $daerahgetdb = $this->tb_daerah->findAll();
        $countdaerah = $this->tb_daerah->countAllResults();

        $temp_data = [];
        for ($i = 0; $i < $countprovinsi; $i++) {
            $indek = 0;
            for ($p = 0; $p < $countdaerah; $p++) {
                if ($daerahgetdb[$p]['parent_kode_provinsi'] == $provinsigetdb[$i]['kode_provinsi']) {
                    $temp_data[$provinsigetdb[$i]['nama_provinsi']][$indek] = $daerahgetdb[$p]['nama_daerah'];
                    $indek = $indek  + 1;
                }
            }
        }

        $data = [
            'tittle' => 'GTA CI siDika Table',
            'dataprovinsi' => $provinsigetdb,
            'hitungprov' => $countprovinsi,
            'hitungdaerah' => $countdaerah,
            'data' => $temp_data
        ];

        return view('table/tableview', $data);
    }
}
