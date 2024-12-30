<?php

namespace App\Controllers;

use App\Models\mskecamatanModel;
use App\Models\msmisiModel;
use App\Models\msvisiModel;
use App\Models\tbtujuanpdModel;
use App\Models\tbtujuanpddetailModel;
use App\Models\tbusulanmusrenModel;
use App\Models\usersModel;
use \Dompdf\Dompdf;

class Entryusulanmusren extends BaseController
{
    protected $users;

    protected $datakecamatan;
    protected $tbusulanmusren;    

    protected $dompdf;

    public function __construct()
    {
        $this->users = new usersModel();

        $this->datakecamatan = new mskecamatanModel();
        $this->tbusulanmusren = new tbusulanmusrenModel();      

        $this->dompdf = new Dompdf();
    }

    public function index()
    {
        $id_bidang = user()->kode_user;

        $data_kecamatan = $this->datakecamatan->getkecamatanarray();

        $getlengh_datakecamatan = count($data_kecamatan);

        $arraykec = [];

        for ($i = 0; $i < $getlengh_datakecamatan; $i++) {
            $arraykec[$i]['id'] = $data_kecamatan[$i]['id'];
            $arraykec[$i]['nama_kecamatan'] = $data_kecamatan[$i]['nama_kecamatan'];
            $arraykec[$i]['jumlah_usulan'] = $this->tbusulanmusren->countusulan($id_bidang, $data_kecamatan[$i]['id']);
            if ($this->tbusulanmusren->countvalidasi($id_bidang, $data_kecamatan[$i]['id']) == NULL) {
                $arraykec[$i]['jumlah_validasi'] = 'Belum ada Usulan';
            } else {
                $arraykec[$i]['jumlah_validasi'] = $this->tbusulanmusren->countvalidasi($id_bidang, $data_kecamatan[$i]['id']);
            }
        }

        $data = [
            'tittle' => 'Usulan Musrenbang',
            'datakecamatan' => $arraykec
        ];

        return view('musren/usulanindex', $data);
    }

    public function detailusulan($id){

    }
}
