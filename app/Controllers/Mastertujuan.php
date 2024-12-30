<?php

namespace App\Controllers;

use App\Models\msmisiModel;
use App\Models\mstujuandetailModel;
use App\Models\mstujuanModel;
use App\Models\msvisiModel;

class Mastertujuan extends BaseController
{
    protected $ms_visi;
    protected $ms_misi;
    protected $ms_tujuan;
    protected $ms_tujuan_detail;

    public function __construct()
    {
        $this->ms_visi = new msvisiModel();
        $this->ms_misi = new msmisiModel();
        $this->ms_tujuan = new mstujuanModel();
        $this->ms_tujuan_detail = new mstujuandetailModel();
    }

    public function index()
    {
        $visigetdb = $this->ms_visi->findAll();
        $visicount = $this->ms_visi->countAllResults();

        $misigetdb = $this->ms_misi->findAll();
        $misicount = $this->ms_misi->countAllResults();

        $tujuangetdb = $this->ms_tujuan->findAll();
        $tujuancount = $this->ms_tujuan->countAllResults();

        $temp_data = [];
        $temp_dataid = [];
        for ($i = 0; $i < $visicount; $i++) {
            for ($j = 0; $j < $misicount; $j++) {
                $indek = 0;
                for ($k = 0; $k < $tujuancount; $k++) {
                    if ($tujuangetdb[$k]['fr_id_visi'] == $visigetdb[$i]['id_visi'] && $tujuangetdb[$k]['fr_id_misi'] == $misigetdb[$j]['id_misi']) {
                        $temp_data[$visigetdb[$i]['visi']][$misigetdb[$j]['misi']][$indek] = $tujuangetdb[$k]['tujuan'];
                        $temp_dataid[$visigetdb[$i]['visi']][$misigetdb[$j]['misi']][$indek] = $tujuangetdb[$k]['id_tujuan'];
                        $indek = $indek + 1;
                    }
                }
            }
        }

        $data = [
            'tittle' => 'GTA CI siDika Master Tujuan',
            'visidata' => $visigetdb,
            'visihitung' => $visicount,
            'misidata' => $misigetdb,
            'misihitung' => $misicount,
            'datatujuan' => $temp_data,
            'iddatatujuan' => $temp_dataid
        ];

        return view('datamaster/tujuan', $data);
    }

    public function apigetdatatujuan()
    {
        $id = $_POST['id_data'];
        $data = [
            'datadetail' => $this->ms_tujuan_detail->getdata($id),
            'dataindikatortujuan' => $this->ms_tujuan_detail->getindikator($id),
            'datatujuan' => $this->ms_tujuan->gettujuanarray($id)
        ];

        echo json_encode($data);
    }

    public function editdatatujuan($id)
    {
        session();
        $data = [
            'tittle' => 'GTA CI siDika Edit Tujuan',
            'validation' => \Config\Services::validation(),
            'datatujuan' => $this->ms_tujuan->gettujuan($id)
        ];

        //jika indek tidak ada dalam database
        if (empty($data['datatujuan'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tersebut : ' . $id . ' Tidak ada dalam database');
        }

        return view('datamaster/tujuanedit', $data);
    }

    public function update()
    {
        date_default_timezone_set('Asia/Jakarta');
        $tujuanlama = $this->request->getVar('tujuanlama');
        $id = $this->request->getVar('id');
        $tujuanbaru = $this->request->getVar('tujuan');

        //cek tujuan
        if ($tujuanlama == $this->request->getVar('tujuan')) {
            $rule_tujuan = 'required';
        } else {
            $rule_tujuan = 'required|is_unique[ms_tujuan.tujuan]';
        }

        // validation data update
        if (!$this->validate([
            'tujuan' => [
                'rules' => $rule_tujuan,
                'errors' => [
                    'required' => 'tujuan tidak boleh kosong',
                    'is_unique' => 'tujuan sudah ada dalam database cari tujuan lain.'
                ]
            ]
        ])) {
            // $validation = \Config\Services::validation();
            // return redirect()->to('komik/edit/' . $this->request->getVar('slug'))->withInput()->with('validation', $validation);
            return redirect()->to('mastertujuan/' . $this->request->getVar('id'))->withInput();
        }

        // update data tujuan pada db
        $this->ms_tujuan->updatetujuan($id, $tujuanbaru);

        session()->setFlashdata('pesan', 'merubahtujuan');

        return redirect()->to('/mastertujuan');
    }

    public function tujuandetail()
    {
        $id = $this->request->getVar('id');
        $indikator = $this->request->getVar('indikator_tujuan');
        $tujuan_get = $this->request->getVar('tujuan');

        $indikator_edit = $this->ms_tujuan_detail->getindikatoredit($id, $indikator);

        $data = [
            'tittle' => 'GTA CI siDika Tujuan Detail',
            'id' => $id,
            'indikator' => $indikator,
            'indikator_edit' => $indikator_edit,
            'tujuan_get' => $tujuan_get
        ];

        return view('datamaster/tujuandetail', $data);
    }

    public function savedetail()
    {
        $id = $this->request->getVar('id');
        $indikator = $this->request->getVar('indikator');

        $indikator_edit = $this->ms_tujuan_detail->getindikatoredit($id, $indikator);
        $hitung_indikator_edit = count($indikator_edit);

        for ($i = 0; $i < $hitung_indikator_edit; $i++) {
            $id_get = $this->request->getVar('id' . $indikator_edit[$i]['tahun']);
            $value_get = $this->request->getVar('indikator' . $indikator_edit[$i]['tahun']);
            $satuan_get = $this->request->getVar('satuan' . $indikator_edit[$i]['tahun']);

            $temp_id = (int)$id_get;

            $this->ms_tujuan_detail->updatedatadetail($temp_id, $value_get, $satuan_get);
        }

        session()->setFlashdata('pesan', 'merubah');

        return redirect()->to('/mastertujuan');
    }

    public function delete()
    {
        $id = $this->request->getVar('id_hidden');

        if (empty($this->ms_tujuan_detail->getdata($id))) {
            $this->ms_tujuan->deletebyid($id);
            session()->setFlashdata('pesan', 'hapus');
            return redirect()->to('/mastertujuan');
        } else {
            session()->setFlashdata('pesan', 'gagalhapus');
            return redirect()->to('/mastertujuan');
        }
    }
}
