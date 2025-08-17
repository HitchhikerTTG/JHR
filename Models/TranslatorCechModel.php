<?php

namespace App\Models;

use CodeIgniter\Model;

class TranslatorCechModel extends Model
{
    protected $table = 'translator_cech';
    protected $primaryKey = 'id';
    protected $allowedFields = ['from_cecha_id', 'from_cecha_id_set', 'to_cecha_id', 'to_cecha_id_set'];

    public function translateWindow($analizaCech, $fromSetId, $toSetId)
    {
        $cechyModel = model(\App\Models\CechyModel::class);
        $noweCechy = $cechyModel->listFeatures($toSetId);
        
        // Zbierz wszystkie ID cech z analizy
        $oryginalneCechyIds = $this->collectAllFeatureIds($analizaCech);
        
        // Stwórz mapę translacji
        $translationMap = $this->createTranslationMap($oryginalneCechyIds, $fromSetId, $toSetId);
        
        // Przetłumacz kategorie
        return [
            'arena' => $this->translateCategoryWithFrequency($analizaCech['arena'], $translationMap, $noweCechy),
            'prywatne' => $this->translateCategoryWithFrequency($analizaCech['prywatne'], $translationMap, $noweCechy),
            'wskazane' => $this->translateCategoryWithFrequency($analizaCech['wskazane'], $translationMap, $noweCechy),
            'pozostale' => $this->translateCategory($analizaCech['pozostale'], $translationMap, $noweCechy),
            'licznik' => $analizaCech['licznik']
        ];
    }
    
    private function collectAllFeatureIds($analizaCech)
    {
        $ids = [];
        
        foreach (['arena', 'prywatne', 'wskazane', 'pozostale'] as $kategoria) {
            foreach ($analizaCech[$kategoria] as $cecha) {
                $ids[] = $cecha[0];
            }
        }
        
        return array_unique($ids);
    }
    
    private function createTranslationMap($featureIds, $fromSetId, $toSetId)
    {
        $builder = $this->db->table('translator_cech');
        $builder->select('from_cecha_id, to_cecha_id');
        $builder->where('from_cecha_id_set', $fromSetId);
        $builder->where('to_cecha_id_set', $toSetId);
        $builder->whereIn('from_cecha_id', $featureIds);
        
        $results = $builder->get()->getResultArray();
        
        $map = [];
        foreach ($results as $result) {
            $map[$result['from_cecha_id']] = $result['to_cecha_id'];
        }
        
        return $map;
    }
    
    private function translateCategoryWithFrequency($kategoria, $translationMap, $noweCechy)
    {
        $agregowane = []; // [noweId => [nazwa, suma_czestotliwosci]]
        
        foreach ($kategoria as $cecha) {
            $stareId = $cecha[0];
            $czestotliwosc = $cecha[2] ?? 1;
            
            if (isset($translationMap[$stareId])) {
                $noweId = $translationMap[$stareId];
                $nowaNazwa = $this->findFeatureName($noweId, $noweCechy);
                
                if ($nowaNazwa) {
                    if (!isset($agregowane[$noweId])) {
                        $agregowane[$noweId] = [$nowaNazwa, 0];
                    }
                    $agregowane[$noweId][1] += $czestotliwosc;
                }
            }
        }
        
        // Konwersja na format wynikowy
        $wynik = [];
        foreach ($agregowane as $noweId => $dane) {
            $wynik[] = [$noweId, $dane[0], $dane[1]];
        }
        
        return $wynik;
    }
    
    private function translateCategory($kategoria, $translationMap, $noweCechy)
    {
        $unikalne = []; // [noweId => nazwa] - eliminuje duplikaty
        
        foreach ($kategoria as $cecha) {
            $stareId = $cecha[0];
            
            if (isset($translationMap[$stareId])) {
                $noweId = $translationMap[$stareId];
                $nowaNazwa = $this->findFeatureName($noweId, $noweCechy);
                
                if ($nowaNazwa) {
                    $unikalne[$noweId] = $nowaNazwa;
                }
            }
        }
        
        // Konwersja na format wynikowy
        $wynik = [];
        foreach ($unikalne as $noweId => $nazwa) {
            $wynik[] = [$noweId, $nazwa];
        }
        
        return $wynik;
    }
    
    private function findFeatureName($featureId, $features)
    {
        foreach ($features as $feature) {
            if ($feature['id'] == $featureId) {
                return $feature['cecha_pl'];
            }
        }
        return null;
    }
    
    public function canTranslate($fromSetId, $toSetId)
    {
        return $this->where([
            'from_cecha_id_set' => $fromSetId,
            'to_cecha_id_set' => $toSetId
        ])->countAllResults() > 0;
    }
    
    /**
     * Analizuje mapowanie translacji - pokazuje ile źródłowych cech mapuje się na każdą docelową cechę
     */
    public function analyzeTranslationMapping($fromSetId, $toSetId)
    {
        $builder = $this->db->table('translator_cech');
        $builder->select('to_cecha_id, COUNT(*) as source_count');
        $builder->where('from_cecha_id_set', $fromSetId);
        $builder->where('to_cecha_id_set', $toSetId);
        $builder->groupBy('to_cecha_id');
        $builder->orderBy('source_count', 'DESC');
        
        return $builder->get()->getResultArray();
    }
}
