<?php

namespace App\Models;

use CodeIgniter\Model;

class FormModel extends Model
{
    protected $table = 'testowa';
    protected $allowedFields = ['imie', 'email', 'tytul'];
    protected $primaryKey ="id";


    public function getAll($slug = false)
    {
        if ($slug === false) {
            return $this->findAll();
        }

        return $this->where(['imie' => $slug])->first();
    }
}