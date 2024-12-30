<?php

namespace App\Controllers;

use Myth\Auth\Password;
use App\Models\usersModel;

class Home extends BaseController
{
    protected $usersModel;

    public function __construct()
    {
        $this->usersModel = new usersModel();
    }

    public function index()
    {
        $data = [
            'tittle' => 'Home'
        ];

        return view('pages/homenew', $data);
    }

    public function register()
    {
        $data = [
            'tittle' => 'Register'
        ];

        return view('auth/registerview', $data);
    }

    public function gantipassword()
    {
        session();
        $data = [
            'tittle' => 'Ganti Password',
            'validation' => \Config\Services::validation(),
        ];

        return view('pages/gantipassword_view', $data);
    }

    public function updatepassword()
    {
        date_default_timezone_set('Asia/Jakarta');
        $kode_user_skpd = user()->kode_user;

        // validation data update
        if (!$this->validate([
            'password1' => [
                'rules' => 'required|min_length[3]|matches[password2]',
                'errors' => [
                    'required' => 'harus ada isinya',
                    'min_length' => 'telalu pendek tidak boleh kurang dari 3 karakter',
                    'matches' => 'tidak cocok dengan password ke dua'
                ]
            ],
            'password2' => [
                'rules' => 'required|min_length[3]|matches[password1]',
                'errors' => [
                    'required' => 'harus ada isinya',
                    'min_length' => 'telalu pendek tidak boleh kurang dari 3 karakter',
                    'matches' => 'tidak cocok dengan password ke satu'
                ]
            ]
        ])) {
            return redirect()->to('gantipassword')->withInput();
        }

        $password = $this->request->getVar('password1');

        $hash = Password::hash($password);

        $this->usersModel->updatepass($hash, $kode_user_skpd);
        session()->setFlashdata('pesan', 'updatepass');

        return redirect()->to('/');
    }
}
