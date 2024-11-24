<?php

namespace App\Models;

use CodeIgniter\Model;

class Okno_Model extends Model
{

    protected $table = 'okna';
    protected $allowedFields = ['hash', 'wlasciciel', 'nazwa'];
    protected $primaryKey ="id";
    
    public function listFeatures()
    {

            return $this->findAll();
    }

}