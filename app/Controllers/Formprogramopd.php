<?php

namespace App\Controllers;

use App\Models\msprogramopdModel;
use App\Models\msurusanpgrogramModel;

class Formprogramopd extends BaseController
{
    // protected $users;   
    protected $dataprogram;
    protected $dataurusan;

    public function __construct()
    {
        $this->dataprogram = new msprogramopdModel();
        $this->dataurusan = new msurusanpgrogramModel();
    }

    public function index()
    {
        $arrayresult = [];

        $kode_user_skpd = user()->kode_user;
        $get_data_program = $this->dataprogram->getalldata();
        $count_get_data_program = count($get_data_program);

        for ($i = 0; $i < $count_get_data_program; $i++) {
            $get_data_urusan = $this->dataurusan->getdataurusan($get_data_program[$i]['kode_program']);
            $arrayresult[$i]['kode_urusan'] = $get_data_urusan[0]['kode_urusan'];
            $arrayresult[$i]['nama_urusan'] = $get_data_urusan[0]['nama_urusan'];
            $arrayresult[$i]['kode_program'] = $get_data_program[$i]['kode_program'];
            $arrayresult[$i]['nama_program'] = $get_data_program[$i]['nama_program'];
            $arrayresult[$i]['opd'] = $get_data_program[$i]['nama_opd'];
            $arrayresult[$i]['pagu'] = $get_data_program[$i]['pagu'];
        }

        $data = [
            'tittle' => 'Program dan urusan OPD',
            'datautama' => $arrayresult
        ];

        return view('entry/programopd', $data);
    }
}
