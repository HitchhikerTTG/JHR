<?php

namespace App\Models;

use CodeIgniter\Model;

class OknoModel extends Model
{
    protected $table = 'okna';
    protected $allowedFields = ['hash', 'wlasciciel', 'nazwa', 'imie_wlasciciela', 'id_zestaw_cech'];
    protected $primaryKey = "id";
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    private function maskName($nazwa) {
        if (strpos($nazwa, '@') !== false) {
            $parts = explode('@', $nazwa);
            $firstPart = $parts[0];
            if (strlen($firstPart) > 1) {
                $masked = $firstPart[0] . str_repeat('*', strlen($firstPart) - 1);
                return $masked . '@' . $parts[1];
            }
        }
        return $nazwa;
    }

    public function listOkna($wlasciciel=false)
    {
        $builder=$this->db->table('okna o');
        $builder->select('o.*, COUNT(DISTINCT pc.nadawca) as licznik', false);
        $builder->join('przypisane_cechy pc','o.hash=pc.okno_johariego','left');
        $builder->groupBy('o.hash, o.id, o.nazwa, o.wlasciciel');    

        if($wlasciciel !== false){
            $builder->where(['wlasciciel'=>$wlasciciel]);
        }

        // Get latest 5 windows by ID
        $latestBuilder = $this->db->table('okna');
        $latestBuilder->orderBy('id', 'DESC');
        $latestBuilder->limit(5);
        $latest = $latestBuilder->get()->getResultArray();
        
        $results = $builder->get()->getResultArray();
        
        $processed = [
            'single_response' => [],
            'multiple_responses' => [],
            'latest' => $latest
        ];
        
        foreach ($results as $row) {
            $row['nazwa'] = $this->maskName($row['nazwa']);
            $count = (int)($row['licznik'] ?? 0);
            
            if ($count === 1) {
                $processed['single_response'][] = $row;
            } else if ($count > 1) {
                $processed['multiple_responses'][] = $row;
            } else {
                $processed['single_response'][] = $row; // No responses, grouping with single
            }
        }
        
        // Sort multiple responses by count descending
        usort($processed['multiple_responses'], function($a, $b) {
            return $b['licznik'] - $a['licznik'];
        });
        
        return $processed;
    }

    public function daneOkna($wlasciciel, $hashOkna){
        return $this->where(['wlasciciel'=>$wlasciciel,'hash'=>$hashOkna])->first();
    }

    function czyJuzJest($sprawdzany_hash){
        $t = $this->where(['hash'=>$sprawdzany_hash])->countAllResults();
        return ($t > 0);
    }

    public function getStatystyki()
    {
        $total = $this->countAll();
        $builder = $this->db->table('okna o');
        $builder->select('COUNT(*) as count', false);
        $builder->join('(SELECT okno_johariego, COUNT(DISTINCT nadawca) as licznik FROM przypisane_cechy GROUP BY okno_johariego) pc', 'o.hash = pc.okno_johariego', 'left');
        $builder->where('pc.licznik = 1');
        $jednoWypelnienie = $builder->get()->getRow()->count;

        $builder = $this->db->table('okna o');
        $builder->select('COUNT(*) as count', false);
        $builder->join('(SELECT okno_johariego, COUNT(DISTINCT nadawca) as licznik FROM przypisane_cechy GROUP BY okno_johariego) pc', 'o.hash = pc.okno_johariego', 'left');
        $builder->where('pc.licznik > 1');
        $wiecejWypelnien = $builder->get()->getRow()->count;

        $builder = $this->db->table('okna o');
        $builder->select('o.nazwa, COUNT(DISTINCT pc.nadawca) as licznik', false);
        $builder->join('przypisane_cechy pc', 'o.hash = pc.okno_johariego', 'left');
        $builder->groupBy('o.hash, o.nazwa');
        $builder->orderBy('licznik', 'DESC');
        $builder->limit(1);
        $najwiecej = $builder->get()->getRow();

        $builder = $this->db->table('okna o');
        $builder->select('AVG(pc.licznik) as srednia', false);
        $builder->join('(SELECT okno_johariego, COUNT(DISTINCT nadawca) as licznik FROM przypisane_cechy GROUP BY okno_johariego HAVING licznik > 1) pc', 'o.hash = pc.okno_johariego', 'left');
        $srednia = $builder->get()->getRow()->srednia;

        return [
            'total' => $total,
            'jedno_wypelnienie' => $jednoWypelnienie,
            'wiecej_wypelnien' => $wiecejWypelnien,
            'najwiecej' => $najwiecej,
            'srednia' => round($srednia, 2)
        ];
    }

    public function getWindowFeatureSet($hashOkna, $hashWlasciciela)
    {
        $okno = $this->where(['hash' => $hashOkna, 'wlasciciel' => $hashWlasciciela])->first();
        return $okno ? $okno['id_zestaw_cech'] : 1; // domyślnie zestaw 1 dla starych okien
    }

    public function analizyCechOkna($hashOkna, $hashWlasciciela)
    {
        $przypisaneCechyModel = model(\App\Models\PrzypisaneCechyModel::class);
        $cechyModel = model(\App\Models\CechyModel::class);
        
        $wszystkieZapisaneCechy = $przypisaneCechyModel->cechyOkna($hashOkna);
        $nazwaneCechy = $cechyModel->listFeatures();
        
        // Zliczanie częstotliwości cech
        $cechyWlasciciela = [];
        $cechyInnych = [];
        $czestotliwoscCech = [];
        
        foreach ($wszystkieZapisaneCechy as $zapisanaCecha) {
            $cechaId = $zapisanaCecha['cecha'];
            
            // Zliczamy ogólną częstotliwość
            if (!isset($czestotliwoscCech[$cechaId])) {
                $czestotliwoscCech[$cechaId] = 0;
            }
            $czestotliwoscCech[$cechaId]++;
            
            // Kategoryzujemy według nadawcy
            if ($zapisanaCecha['nadawca'] === $hashWlasciciela) {
                $cechyWlasciciela[] = $cechaId;
            } else {
                $cechyInnych[] = $cechaId;
            }
        }
        
        // Usuwamy duplikaty z kategorii
        $prywatne = array_unique($cechyWlasciciela);
        $wskazane = array_unique($cechyInnych);
        $pozostale = range(1, 139);
        
        // Analiza przecięć i różnic
        $arena = array_intersect($prywatne, $wskazane);
        $prywatne = array_diff($prywatne, $arena);
        $wskazane = array_diff($wskazane, $arena);
        $pozostale = array_diff($pozostale, $arena, $wskazane, $prywatne);
        
        // Konwersja ID na nazwy z częstotliwością
        $arena = $this->konwertujCechyNaNazwyZCzestotliwoscia($arena, $nazwaneCechy, $czestotliwoscCech);
        $prywatne = $this->konwertujCechyNaNazwyZCzestotliwoscia($prywatne, $nazwaneCechy, $czestotliwoscCech);
        $wskazane = $this->konwertujCechyNaNazwyZCzestotliwoscia($wskazane, $nazwaneCechy, $czestotliwoscCech);
        $pozostale = $this->konwertujCechyNaNazwy($pozostale, $nazwaneCechy);
        
        return [
            'arena' => $arena,
            'prywatne' => $prywatne,
            'wskazane' => $wskazane,
            'pozostale' => $pozostale,
            'licznik' => count($wszystkieZapisaneCechy),
            'czestotliwosc' => $czestotliwoscCech
        ];
    }
    
    private function konwertujCechyNaNazwy($cechy, $nazwaneCechy)
    {
        $wynik = [];
        foreach ($cechy as $cechaID) {
            $wynik[] = [$cechaID, $nazwaneCechy[$cechaID-1]['cecha_pl']];
        }
        
        // Sortowanie alfabetyczne według nazwy
        usort($wynik, function($a, $b) {
            return strcmp($a[1], $b[1]);
        });
        
        return $wynik;
    }
    
    private function konwertujCechyNaNazwyZCzestotliwoscia($cechy, $nazwaneCechy, $czestotliwoscCech)
    {
        $wynik = [];
        foreach ($cechy as $cechaID) {
            $czestotliwosc = $czestotliwoscCech[$cechaID] ?? 1;
            $wynik[] = [
                $cechaID, 
                $nazwaneCechy[$cechaID-1]['cecha_pl'],
                $czestotliwosc
            ];
        }
        
        // Sortowanie według częstotliwości malejąco, potem alfabetycznie według nazwy
        usort($wynik, function($a, $b) {
            if ($a[2] == $b[2]) {
                return strcmp($a[1], $b[1]); // alfabetycznie według nazwy
            }
            return $b[2] - $a[2]; // częstotliwość malejąco
        });
        
        return $wynik;
    }

    

}