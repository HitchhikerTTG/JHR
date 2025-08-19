<?php

namespace App\Models;

use CodeIgniter\Model;

class UzytkownicyModel extends Model
{

    protected $table = 'uzytkownicy';
    protected $allowedFields = ['email', 'hash']; // Usuńmy 'imie' jeśli kolumna nie istnieje
    protected $primaryKey ="id";

    function czyJuzJest($sprawdzany_email){


    $t = $this->where(['email'=>$sprawdzany_email])->countAllResults();
    
    return ($t > 0);

    }

}