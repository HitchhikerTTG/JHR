<?php

namespace App\Models;

use CodeIgniter\Model;

class OknoModel extends Model
{

    protected $table = 'okna';
    protected $allowedFields = ['hash', 'wlasciciel', 'nazwa', 'imie_wlasciciela'];
    protected $primaryKey ="id";
    
    public function listOkna($wlasciciel=false)
    {

    $builder=$this->db->table('okna o');
    $builder->select('o.*, COUNT(DISTINCT pc.nadawca) as licznik', false);
    $builder->join('przypisane_cechy pc','o.hash=pc.okno_johariego','left');
    $builder->groupBy('o.hash, o.id, o.nazwa, o.wlasciciel');    
        
        //Ta funkcja ma zwrócić wszytkie okna, lub okna konkretnego właściciela 
//        if ($wlasciciel===false){
//            return $this->findAll();
//        }

//            return $this->where(['wlasciciel'=>$wlasciciel])->findAll();

    if($wlasciciel !== false){
        $builder->where(['wlasciciel'=>$wlasciciel]);
    }
    return $builder->get()->getResultArray();
    }

    public function daneOkna($wlasciciel, $hashOkna){
        return $this->where(['wlasciciel'=>$wlasciciel,'hash'=>$hashOkna])->first();
    }

    function czyJuzJest($sprawdzany_hash){
    $t = $this->where(['hash'=>$sprawdzany_hash])->countAllResults();
    
    return ($t > 0);

    }


}