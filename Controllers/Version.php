
<?php

namespace App\Controllers;

class Version extends BaseController
{
    public function index()
    {
        echo "CodeIgniter Version: " . \CodeIgniter\CodeIgniter::CI_VERSION;
    }
}
