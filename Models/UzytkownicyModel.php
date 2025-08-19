<?php

namespace App\Models;

use CodeIgniter\Model;

class UzytkownicyModel extends Model
{

    protected $table = 'uzytkownicy';
    protected $allowedFields = ['name', 'email', 'user_hash']; // Używamy rzeczywistych nazw kolumn
    protected $primaryKey ="id";

    function czyJuzJest($sprawdzany_email){


    $t = $this->where(['email'=>$sprawdzany_email])->countAllResults();

    return ($t > 0);

    }

}