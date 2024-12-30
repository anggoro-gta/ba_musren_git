<?php

namespace App\Controllers;

use App\Models\msvisiModel;

class Mastervisi extends BaseController
{
    protected $ms_visi;

    public function __construct()
    {
        $this->ms_visi = new msvisiModel();
    }

    public function index()
    {
        $visigetdb = $this->ms_visi->findAll();
        $countvisi = $this->ms_visi->countAllResults();

        $data = [
            'tittle' => 'GTA CI siDika Master Visi',
            'datavisi' => $visigetdb,
            'totalvisi' => $countvisi
        ];

        return view('datamaster/visi', $data);
    }
}
