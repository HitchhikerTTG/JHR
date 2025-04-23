<?php

namespace App\Models;

use CodeIgniter\Model;

class OknoModel extends Model
{
    protected $table = 'okna';
    protected $allowedFields = ['hash', 'wlasciciel', 'nazwa', 'imie_wlasciciela', 'created_at', 'updated_at'];
    protected $primaryKey = "id";
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function listOkna($wlasciciel=false)
    {
        $builder=$this->db->table('okna o');
        $builder->select('o.*, COUNT(DISTINCT pc.nadawca) as licznik', false);
        $builder->join('przypisane_cechy pc','o.hash=pc.okno_johariego','left');
        $builder->groupBy('o.hash, o.id, o.nazwa, o.wlasciciel');    

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

}