<?php

namespace App\Controllers;

use App\Models\msmisiModel;
use App\Models\mstujuanModel;
use App\Models\mssasaranModel;
use App\Models\mssasarandetailModel;

class Mastersasaran extends BaseController
{
    protected $ms_misi;
    protected $ms_tujuan;
    protected $ms_sasaran;
    protected $ms_sasaran_detail;

    public function __construct()
    {
        $this->ms_misi = new msmisiModel();
        $this->ms_tujuan = new mstujuanModel();
        $this->ms_sasaran = new mssasaranModel();
        $this->ms_sasaran_detail = new mssasarandetailModel;
    }

    public function index()
    {
        $misigetdb = $this->ms_misi->findAll();
        $misicount = $this->ms_misi->countAllResults();

        $tujuangetdb = $this->ms_tujuan->findAll();
        $tujuancount = $this->ms_tujuan->countAllResults();

        $sasarangetdb = $this->ms_sasaran->findAll();
        $sasarancount = $this->ms_sasaran->countAllResults();

        $temp_data = [];
        $temp_data_id = [];
        for ($i = 0; $i < $misicount; $i++) {
            for ($j = 0; $j < $tujuancount; $j++) {
                $indek = 0;
                for ($k = 0; $k < $sasarancount; $k++) {
                    if ($sasarangetdb[$k]['fr_id_misi'] == $misigetdb[$i]['id_misi'] && $sasarangetdb[$k]['fr_id_tujuan'] == $tujuangetdb[$j]['id_tujuan']) {
                        $temp_data[$misigetdb[$i]['misi']][$tujuangetdb[$j]['tujuan']][$indek] = $sasarangetdb[$k]['sasaran'];
                        $temp_data_id[$misigetdb[$i]['misi']][$tujuangetdb[$j]['tujuan']][$indek] = $sasarangetdb[$k]['id_sasaran'];
                        $indek = $indek + 1;
                    }
                }
            }
        }

        $temp_data_tujuan = [];
        for ($i = 0; $i < $misicount; $i++) {
            $indek = 0;
            for ($j = 0; $j < $tujuancount; $j++) {
                if ($tujuangetdb[$j]['fr_id_misi'] == $misigetdb[$i]['id_misi']) {
                    $temp_data_tujuan[$misigetdb[$i]['misi']][$indek] = $tujuangetdb[$j]['tujuan'];
                    $indek = $indek + 1;
                }
            }
        }

        $data = [
            'tittle' => 'GTA CI siDika Master Sasaran',
            'misidata' => $misigetdb,
            'misihitung' => $misicount,
            'datatujuan' => $temp_data_tujuan,
            'datasasaran' => $temp_data,
            'iddatasasaran' => $temp_data_id
        ];

        return view('datamaster/sasaran', $data);
    }

    public function apigetdatasasaran()
    {
        $id = $_POST['id_data'];
        $data = [
            'datadetail' => $this->ms_sasaran_detail->getdata($id),
            'dataindikatorsasaran' => $this->ms_sasaran_detail->getindikator($id),
            'datasasaran' => $this->ms_sasaran->getsasaranarray($id)
        ];

        echo json_encode($data);
    }

    public function editdatasasaran($id)
    {
        session();
        $data = [
            'tittle' => 'GTA CI siDika Edit Sasaran',
            'validation' => \Config\Services::validation(),
            'datasasaran' => $this->ms_sasaran->getsasaran($id)
        ];

        //jika indek tidak ada dalam database
        if (empty($data['datasasaran'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tersebut : ' . $id . ' Tidak ada dalam database');
        }

        return view('datamaster/sasaranedit', $data);
    }

    public function update()
    {
        date_default_timezone_set('Asia/Jakarta');
        $sasaranlama = $this->request->getVar('sasaranlama');
        $id = $this->request->getVar('id');
        $sasaranbaru = $this->request->getVar('sasaran');

        //cek sasaran
        if ($sasaranlama == $sasaranbaru) {
            $rule_sasaran = 'required';
        } else {
            $rule_sasaran = 'required|is_unique[ms_sasaran.sasaran]';
        }

        // validation data update
        if (!$this->validate([
            'sasaran' => [
                'rules' => $rule_sasaran,
                'errors' => [
                    'required' => 'sasaran tidak boleh kosong',
                    'is_unique' => 'sasaran sudah ada dalam database cari sasaran lain.'
                ]
            ]
        ])) {
            // $validation = \Config\Services::validation();
            // return redirect()->to('komik/edit/' . $this->request->getVar('slug'))->withInput()->with('validation', $validation);
            return redirect()->to('mastersasaran/' . $this->request->getVar('id'))->withInput();
        }

        // update data sasaran pada db
        $this->ms_sasaran->updatesasaran($id, $sasaranbaru);

        session()->setFlashdata('pesan', 'merubahsasaran');

        return redirect()->to('/mastersasaran');
    }

    public function sasarandetail()
    {
        $id = $this->request->getVar('id');
        $indikator = $this->request->getVar('indikator_sasaran');
        $sasaran_get = $this->request->getVar('sasaran');

        $indikator_edit = $this->ms_sasaran_detail->getindikatoredit($id, $indikator);

        $data = [
            'tittle' => 'GTA CI siDika Sasaran Detail',
            'id' => $id,
            'indikator' => $indikator,
            'indikator_edit' => $indikator_edit,
            'sasaranget' => $sasaran_get
        ];

        return view('datamaster/sasarandetail', $data);
    }

    public function savedetail()
    {
        $id = $this->request->getVar('id');
        $indikator = $this->request->getVar('indikator');

        $indikator_edit = $this->ms_sasaran_detail->getindikatoredit($id, $indikator);
        $hitung_indikator_edit = count($indikator_edit);

        for ($i = 0; $i < $hitung_indikator_edit; $i++) {
            $id_get = $this->request->getVar('id' . $indikator_edit[$i]['tahun']);
            $value_get = $this->request->getVar('indikator' . $indikator_edit[$i]['tahun']);
            $satuan_get = $this->request->getVar('satuan' . $indikator_edit[$i]['tahun']);

            $temp_id = (int)$id_get;

            $this->ms_sasaran_detail->updatedatadetail($temp_id, $value_get, $satuan_get);
        }

        session()->setFlashdata('pesan', 'merubahdetailsasaran');

        return redirect()->to('/mastersasaran');
    }

    public function delete()
    {
        $id = $this->request->getVar('id_hidden');

        if (empty($this->ms_sasaran_detail->getdata($id))) {
            $this->ms_sasaran->deletebyid($id);
            session()->setFlashdata('pesan', 'hapus');
            return redirect()->to('/mastersasaran');
        } else {
            session()->setFlashdata('pesan', 'gagalhapus');
            return redirect()->to('/mastersasaran');
        }
    }
}
