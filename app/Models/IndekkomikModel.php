<?php

namespace App\Models;

use CodeIgniter\Model;

class IndekkomikModel extends Model
{
    protected $table = 'indek_komik';
    protected $useTimestamps = true;
    protected $allowedFields = ['judul', 'slug', 'penulis', 'penerbit', 'sampul'];

    public function getkomik($slug = false)
    {
        if ($slug == false) {
            return $this->findAll();
        }

        return $this->where(['slug' => $slug])->first();
    }
}
