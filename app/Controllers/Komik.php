<?php

namespace App\Controllers;

use App\Models\IndekkomikModel;

class Komik extends BaseController
{
    protected $komikModel;

    public function __construct()
    {
        $this->komikModel = new IndekkomikModel();
    }

    public function index()
    {
        $data = [
            'tittle' => 'Daftar Komik',
            'komik' => $this->komikModel->getkomik()
        ];

        return view('komik/komikindek', $data);
    }

    public function detail($slug)
    {
        $data = [
            'tittle' => 'Detail Komik',
            'komik' => $this->komikModel->getkomik($slug)
        ];

        // jika komik tidak ada di tabel database
        if (empty($data['komik'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Judul Komik ' . $slug . ' Tidak ada dalam database');
        }

        return view('komik/detailkomikindek', $data);
    }

    public function create()
    {
        session();
        $data = [
            'tittle' => 'Form Tambah Data Komik',
            'validation' => \Config\Services::validation()
        ];

        return view('komik/createkomik', $data);
    }

    public function save()
    {
        // validation data input
        if (!$this->validate([
            'judul' => [
                'rules' => 'required|is_unique[indek_komik.judul]',
                'errors' => [
                    'required' => '{field} judul komik harus diisi.',
                    'is_unique' => '{field} komik sudah terdaftar dalam database.'
                ]
            ],
            'sampul' => [
                'rules' => 'uploaded[sampul]|max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Pilih gambar terlebih dahulu',
                    'max_size' => 'ukuran gambar tidak boleh melebihi 1MB',
                    'is_image' => 'yang anda pilih bukan gambar',
                    'mime_in' => 'yang anda pilih bukan gambar'
                ]
            ]
        ])) {
            // $validation = \Config\Services::validation();
            // return redirect()->to('komik/create')->withInput()->with('validation', $validation);
            return redirect()->to('komik/create')->withInput();
        }

        //ambil file gambar sampul
        $filesampul = $this->request->getFile('sampul');
        // generate nama sampul random
        $namasampul = $filesampul->getRandomName();
        //pindahkan file ke folder img
        $filesampul->move('img', $namasampul);

        // ambil nama file sampul
        // $namasampul = $filesampul->getName();

        $slug = url_title($this->request->getVar('judul'), '-', true);

        $this->komikModel->save([
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $namasampul
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');

        return redirect()->to('/komik');
    }

    public function delete($id)
    {
        // cari gambar berdasarkan id
        $komik = $this->komikModel->find($id);

        // hapus gambar
        unlink('img/' . $komik['sampul']);

        $this->komikModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to('/komik');
    }

    public function edit($slug)
    {
        session();
        $data = [
            'tittle' => 'Form Ubah Data Komik',
            'validation' => \Config\Services::validation(),
            'komik' => $this->komikModel->getkomik($slug)
        ];

        return view('komik/editkomik', $data);
    }

    public function update($id)
    {
        $filesampul = $this->request->getFile('sampul'); //ambil file sampul
        $filesampullama = $this->request->getVar('sampullama');
        $komiklama = $this->komikModel->getkomik($this->request->getVar('slug'));

        //cek error file upload untuk rules sampul
        if ($filesampul->getError() == 4) {
            $rulesampul = 'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]';
        } else {
            $rulesampul = 'uploaded[sampul]|max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]';
        }

        // cek judul komik
        if ($komiklama['judul'] == $this->request->getVar('judul')) {
            $rule_judul = 'required';
        } else {
            $rule_judul = 'required|is_unique[indek_komik.judul]';
        }

        // validation data update
        if (!$this->validate([
            'judul' => [
                'rules' => $rule_judul,
                'errors' => [
                    'required' => '{field} judul komik harus diisi.',
                    'is_unique' => 'Jangan merubah judul komik lain yang sudah ada dalam database.'
                ]
            ],
            'sampul' => [
                'rules' => $rulesampul,
                'errors' => [
                    'uploaded' => 'Pilih gambar terlebih dahulu',
                    'max_size' => 'ukuran gambar tidak boleh melebihi 1MB',
                    'is_image' => 'yang anda pilih bukan gambar',
                    'mime_in' => 'yang anda pilih bukan gambar'
                ]
            ]
        ])) {
            // $validation = \Config\Services::validation();
            // return redirect()->to('komik/edit/' . $this->request->getVar('slug'))->withInput()->with('validation', $validation);
            return redirect()->to('komik/edit/' . $this->request->getVar('slug'))->withInput();
        }

        // cek file upload atau tidak
        if ($filesampul->getError() == 4) {
            $filesampulbaru = $filesampullama;
        } else {
            // generate nama sampul random
            $namasampul = $filesampul->getRandomName();
            //pindahkan file ke folder img
            $filesampul->move('img', $namasampul);
            $filesampulbaru = $namasampul;
            // hapus gambar sampul lama
            unlink('img/' . $filesampullama);
        }

        $slug = url_title($this->request->getVar('judul'), '-', true);

        $this->komikModel->save([
            'id' => $id,
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $filesampulbaru
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah.');

        return redirect()->to('/komik');
    }
}
