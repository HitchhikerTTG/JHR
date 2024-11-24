<?php

namespace App\Models;

use CodeIgniter\Model;

class PrzypisaneCechyModel extends Model
{

    protected $table = 'przypisane_cechy';
    protected $allowedFields = ['okno_johariego', 'cecha', 'nadawca'];
    protected $primaryKey ="id";


    public function cechyOkna($hashOkna){

        return $this->where(['okno_johariego'=>$hashOkna])->findAll();
    }

    public function nadawcyOkna($hashOkna){
        $this->select('nadawca');
        $this->distinct();
        return $this->where(['okno_johariego'=>$hashOkna])->findAll();        
    }


}