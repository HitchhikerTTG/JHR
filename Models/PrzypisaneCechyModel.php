<?php

namespace App\Models;

use CodeIgniter\Model;

class PrzypisaneCechyModel extends Model
{
    protected $table = 'przypisane_cechy';
    protected $allowedFields = ['okno_johariego', 'cecha', 'nadawca', 'created_at'];
    protected $primaryKey = "id";
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = '';

    public function cechyOkna($hashOkna){
        return $this->where(['okno_johariego'=>$hashOkna])->findAll();
    }

    public function nadawcyOkna($hashOkna){
        $this->select('nadawca');
        $this->distinct();
        return $this->where(['okno_johariego'=>$hashOkna])->findAll();        
    }
}