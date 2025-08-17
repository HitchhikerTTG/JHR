
<?php

namespace App\Models;

use CodeIgniter\Model;

class ZestawCechModel extends Model
{
    protected $table = 'zestaw_cech';
    protected $primaryKey = 'id';
    protected $allowedFields = ['Nazwa_zestawu', 'Opis', 'created_at'];
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';

    public function getZestawy()
    {
        return $this->findAll();
    }

    public function getZestaw($id)
    {
        return $this->find($id);
    }
}
