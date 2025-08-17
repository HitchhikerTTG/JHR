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
<?php

namespace App\Models;

use CodeIgniter\Model;

class CechyModel extends Model
{
    protected $table = 'cechy';
    protected $primaryKey = 'id';
    protected $allowedFields = ['cecha_pl', 'cecha_en'];

    public function listFeatures()
    {
        return $this->findAll();
    }
}
