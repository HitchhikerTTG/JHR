<?php

namespace App\Models;

use CodeIgniter\Model;

class CechyModel extends Model
{
    protected $table = 'cechy';
    protected $primaryKey = 'id';
    protected $allowedFields = ['cecha_pl', 'cecha_en', 'id_zestaw_cech'];

    public function listFeatures($zestawId = null)
    {
        if ($zestawId !== null) {
            return $this->where('id_zestaw_cech', $zestawId)->findAll();
        }
        return $this->findAll();
    }

    public function getFeaturesForNewWindows()
    {
        // Dla nowych okien używamy zestawu ID 2
        return $this->where('id_zestaw_cech', 2)->findAll();
    }

    public function translateFeatures($fromSetId, $toSetId, $featureIds)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('translator_cech tc');
        $builder->select('tc.to_cecha_id');
        $builder->where('tc.from_cecha_id_set', $fromSetId);
        $builder->where('tc.to_cecha_id_set', $toSetId);
        $builder->whereIn('tc.from_cecha_id', $featureIds);
        
        $results = $builder->get()->getResultArray();
        return array_column($results, 'to_cecha_id');
    }

    public function getFeaturesByIds($ids)
    {
        return $this->whereIn('id', $ids)->findAll();
    }
}