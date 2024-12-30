<?php

namespace App\Controllers;

use App\Models\msmisiModel;

class Mastermisi extends BaseController
{
    protected $ms_misi;

    public function __construct()
    {
        $this->ms_misi = new msmisiModel();
    }

    public function index()
    {
        $misigetdb = $this->ms_misi->findAll();
        $countmisi = $this->ms_misi->countAllResults();

        $data = [
            'tittle' => 'GTA CI siDika Master Misi',
            'datamisi' => $misigetdb,
            'jumlahmisi' => $countmisi
        ];

        return view('datamaster/misi', $data);
    }

    public function editdatamisi($id)
    {
        session();
        $data = [
            'tittle' => 'GTA CI siDika Edit Misi',
            'validation' => \Config\Services::validation(),
            'datamisi' => $this->ms_misi->getmisi($id)
        ];

        //jika indek tidak ada dalam database
        if (empty($data['datamisi'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tersebut : ' . $id . ' Tidak ada dalam database');
        }

        return view('datamaster/misiedit', $data);
    }

    public function update()
    {
        date_default_timezone_set('Asia/Jakarta');
        $misilama = $this->request->getVar('misilama');
        $id = $this->request->getVar('id');
        $misibaru = $this->request->getVar('misi');

        //cek misi
        if ($misilama == $misibaru) {
            $rule_misi = 'required';
        } else {
            $rule_misi = 'required|is_unique[ms_misi.misi]';
        }

        // validation data update
        if (!$this->validate([
            'misi' => [
                'rules' => $rule_misi,
                'errors' => [
                    'required' => 'misi tidak boleh kosong',
                    'is_unique' => 'misi sudah ada dalam database cari misi lain.'
                ]
            ]
        ])) {
            // $validation = \Config\Services::validation();
            // return redirect()->to('komik/edit/' . $this->request->getVar('slug'))->withInput()->with('validation', $validation);
            return redirect()->to('mastermisi/' . $this->request->getVar('id'))->withInput();
        }

        // update data misi pada db
        $this->ms_misi->updatemisi($id, $misibaru);

        session()->setFlashdata('pesan', 'merubahmisi');

        return redirect()->to('/mastermisi');
    }
}
