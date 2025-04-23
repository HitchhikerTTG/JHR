
<?php

namespace App\Controllers;

class Migrate extends \CodeIgniter\Controller
{
    public function index()
    {
        $migrate = \Config\Services::migrations();
        
        try {
            $migrate->latest();
            echo 'Migracja wykonana pomyślnie.';
        } catch (\Exception $e) {
            echo 'Błąd migracji: ' . $e->getMessage();
        }
    }
}
