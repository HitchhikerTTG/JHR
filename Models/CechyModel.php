<?php

namespace App\Models;

use CodeIgniter\Model;

class CechyModel extends Model
{

    protected $table = 'cechy';


    public function listFeatures()
    {

            return $this->findAll();
    }

}