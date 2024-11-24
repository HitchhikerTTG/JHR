<?php

namespace App\Controllers;

class Okno extends CI_Controller {

	    function __construct() {
        parent::__construct();
        $this->load->model('okno_model');
        }

	public function view($hashOkna=false)
	{
	$szablon = "class=\"landing-page sidebar-collapse\"";
	//tu są rzeczy związane z formularzem
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $szablon ="class=\"landing-page sidebar-collapse\"";
    if ($hashOkna === false){
    	// nie podaliśmy parametru. Trzeba wczytać formularz. 

    	$this->form_validation->set_rules('email', 'Email', 'required');
                // tu jest walidacaja formularza
                if ($this->form_validation->run() == FALSE)
                {
                //tu ściągam dane z modelu // z bazy danych
                $data['cechy'] = $this->okno_model->list_features();
                $data['naglowek'] = 'Tu chce mieć wypisane wszystkie cechy';
                $data['szablon'] = $szablon;
                        $this->load->view('header');
                        $this->load->view('tresc',$data);
                        //$this->load->view('form/cechy',$data );
                        $this->load->view('ococho');
                        $this->load->view('opis_nowe');
                        $this->load->view('formularz_nowe_okno',$data);
                        $this->load->view('footer');
                        
                }
                //a tu jest zapisanie danych w formularzu
                else {
                        $zapisywaneOkno= array();
                        $zapisywaneOkno = array(
                        'imie'=>$this->input->post('imie'),
                        'tytul'=>$this->input->post('tytul'),
                        'email'=>$this->input->post('email'),
                        'szablon'=>"class=\"profile-page sidebar-collapse\"",
                        'hash_autora'=>hash('ripemd160',$this->input->post('email')),
                        'wybrane_cechy'=>$this->input->post('feature_list[]'),
                        'hash_okna'=> hash('ripemd160', $this->input->post('tytul').$this->input->post('email'))

                        );

                        //tu bedizemy zapisywać dane
                        $this->okno_model->zapisz_okno($zapisywaneOkno);
                        
                        //$data=$okno_do_zapisu;

                        //A tu jest wywołanie strony z danymi po sukcesie. Let's find out
                        $this->load->view('header');
                        $this->load->view('tresc',$zapisywaneOkno);
                        $this->load->view('formularz_nowe_okno_sukces', $zapisywaneOkno);
                        $this->load->view('footer');
                        $this->slij_mail($this->input->post('email'),   hash('ripemd160', $this->input->post('tytul').$this->input->post('email')));
                                     
                    }
            } 
            else { // mamy sytuacje w której został przekazany parametr, ale teraz chcielibyśmy miec pewność, czy istnieje okno o takim hashu, czy mamy tylko bełkot.
                    $badaneOkno=array();
                if ($badaneOkno=$this->okno_model->sprawdz_okno($hashOkna)) {
                    //Jeśli mamy takie okno, potrzebujemy je obsłużyć dokładnie tak, jak powyżej
                    $this->form_validation->set_rules('email', 'Email', 'required');

                     if ($this->form_validation->run() == FALSE)
                    {
                    //tu ściągam dane z modelu // z bazy danych

                    $data['nazwaOkno']=$badaneOkno['0']['nazwa'];    
                    $data['hashOkna']=$hashOkna;
                    $data['autor']=$this->okno_model->dej_imie($hashOkna);
                    $data['cechy'] = $this->okno_model->list_features();
                    $data['naglowek'] = 'Tu chce mieć wypisane wszystkie cechy';
                    $data['szablon'] = $szablon;
                        $this->load->view('header');
                        $this->load->view('tresc',$data);
                        $this->load->view('ococho_dla_znajomych', $data);
                        //$this->load->view('form/cechy',$data );
                        $this->load->view('formularz_dodaj_do_okna',$data);
                        $this->load->view('footer');
                }
                //a tu jest zapisanie danych w formularzu
                else
                {
                        $zapisywaneOkno= array();
                        $zapisywaneOkno = array(
                        'hashOkna'=>$hashOkna,
                        'wybrane_cechy'=>$this->input->post('feature_list[]'),
                        'hashNadawcy'=> hash('ripemd160', $this->input->post('email'))
                       

                        );





                        //tu bedizemy zapisywać dane
                        if ($this->okno_model->dodaj_do_okna($zapisywaneOkno) ) {
                        $data['szablon']="class=\"profile-page sidebar-collapse\"";
                        
                        //$data=$okno_do_zapisu;

                        //A tu jest wywołanie strony z danymi po sukcesie. Let's find out
                        $this->load->view('header');
                        $this->load->view('tresc',$data);
                        $this->load->view('dodane_sukces');}
                        $this->load->view('footer');
                }








                }else{
                    $data['komunikatBledu']="Musiałeś popełnić bład przy wczytywaniu parametru. Sprawdź czy podałeś dobry hash okna.";
                    $this->load->view('blad',$data);
                }


            }



	}

        public function pobierz_cechy($slug = NULL)
                {
                $data['cechy'] = $this->okno_model->list_features($slug);
                }
                
        public function policz_wystąpienia($tabela, $wartosc) //tej funkcji chcę do estetyki.  
                { 
                $licznik = 0; 
                //print_r($tabela);
                foreach ($tabela as $key => $value) 
                        { 
                        if ($value['cecha'] == $wartosc) { 
                            $licznik++; 
                        } 
                } 
    
                return $licznik; 
                }

        public function wyswietlOkno_old($hashOkna, $autorOkna){
                        $this->load->helper(array('url'));

                        $okno = array();
                        $zbiorCech=array();
                        $pozostale = array();
                        $arena = array();
                        $prywatne = array();
                        $nieznane = array();

                        if ($okno = $this->okno_model->wczytaj_okno($hashOkna)){
                        
                        $zbiorCech= $this->okno_model->list_features2();
                        
                        foreach ($zbiorCech as $cecha) {
                        $pozostale[] = $cecha['cecha_pl'];                                
                        }


                        //wypełniamy zbiory. 
                        //Te które zna autor
                        foreach ($okno as $i=>$cecha) {

                        
                         if ($cecha['nadawca']==$autorOkna) {
                            $prywatne[]=$cecha['cecha'];    
                         }

                         else {
                        $nieznane[]=$cecha['cecha'];
                         }  
                        }



                        //operacje na  tabelach

                        //Krok 1, wyrzucić z ukrytych cech, cechy autora i cechy kolegów

        foreach ($prywatne as $value){
                unset($pozostale[$value]);
        }

        foreach ($nieznane as $value){
                unset($pozostale[$value]);
        }


//Krok 2, jeśli cechaAutora występuje wśród cechKolegów, przenieś do Areny, wyrzuć z cech kolegów i autora;

$arena = array_intersect($prywatne, $nieznane);
$prywatne = array_diff($prywatne, $arena);
$nieznane = array_diff($nieznane, $arena);

$prywatneCechy=array();
$arenaCech=array();
$nieznaneCechy=array();


foreach ($prywatne as $index){
        $prywatneCechy[]=$zbiorCech[$index]['cecha_pl'];
}

foreach ($arena as $index){

        $arenaCech[]=$zbiorCech[$index]['cecha_pl']." (".$this->policz_wystąpienia($okno,$index).");";

}

foreach ($nieznane as $index){
        $nieznaneCechy[]=$zbiorCech[$index]['cecha_pl'];
}

//zebranie w tabelę. Zobaczymy, czy się uda;-)
$przekazOkno = array();
$przekazOkno['tytul'] = $this->okno_model->dej_tytul($hashOkna);
$przekazOkno['hash']=$hashOkna;
$przekazOkno['prywatne']=$prywatneCechy;
$przekazOkno['arena']=$arenaCech;
$przekazOkno['nieznane']=$nieznaneCechy;
$przekazOkno['pozostale']=$pozostale;
$przekazOkno['szablon']="class=\"profile-page sidebar-collapse\"";

                        //echo "Po całej masie dziwnych operacji <br>";
                        $this->load->view('header');
                        $this->load->view('tresc',$przekazOkno);
                        $this->load->view('wyswietl_okno',$przekazOkno);
                        $this->load->view('footer');       


                        }



                        else {
                                echo "się porobiło źle";
                        }
                }



        public function wyswietlOkno($hashOkna, $autorOkna){
                        $this->load->helper(array('url'));

                        $okno = array();
                        $zbiorCech=array();
                        $pozostale = array();
                        $arena = array();
                        $prywatne = array();
                        $nieznane = array();

                        if ($okno = $this->okno_model->wczytaj_okno($hashOkna)){
                        
                        $zbiorCech= $this->okno_model->list_features();
                        
                        foreach ($zbiorCech as $key=>$value) {
                        $pozostale[] = $key;
                        }


                        //wypełniamy zbiory. 
                        //Te które zna autor
                        foreach ($okno as $i=>$cecha) {

                        
                         if ($cecha['nadawca']==$autorOkna) {
                            $prywatne[]=$cecha['cecha'];    
                         }

                         else {
                        $nieznane[]=$cecha['cecha'];
                         }  
                        }



                        //operacje na  tabelach

                        //Krok 1, wyrzucić z ukrytych cech, cechy autora i cechy kolegów

        foreach ($prywatne as $value){
                unset($pozostale[$value]);
        }

        foreach ($nieznane as $value){
                unset($pozostale[$value]);
        }


//Krok 2, jeśli cechaAutora występuje wśród cechKolegów, przenieś do Areny, wyrzuć z cech kolegów i autora;

$arena = array_intersect($prywatne, $nieznane);
$prywatne = array_diff($prywatne, $arena);
$nieznane = array_diff($nieznane, $arena);

$prywatneCechy=array();
$arenaCech=array();
$nieznaneCechy=array();

$odwroconyZbior = array();
$odwroconyZbior = array_flip($zbiorCech);

foreach ($prywatne as $index){
        $prywatneCechy[]=$odwroconyZbior[$index];
}

foreach ($arena as $index){

        $arenaCech[]=$odwroconyZbior[$index]." (".$this->policz_wystąpienia($okno,$index).");";

}

foreach ($nieznane as $index){
        $nieznaneCechy[]=$odwroconyZbior[$index];
}

//zebranie w tabelę. Zobaczymy, czy się uda;-)
$przekazOkno = array();
$przekazOkno['tytul'] = $this->okno_model->dej_tytul($hashOkna);
$przekazOkno['hash']=$hashOkna;
$przekazOkno['prywatne']=$prywatneCechy;
$przekazOkno['arena']=$arenaCech;
$przekazOkno['nieznane']=$nieznaneCechy;
$przekazOkno['pozostale']=$pozostale;
$przekazOkno['szablon']="class=\"profile-page sidebar-collapse\"";

                        //echo "Po całej masie dziwnych operacji <br>";
                        $this->load->view('header');
                        $this->load->view('tresc',$przekazOkno);
                        $this->load->view('wyswietl_okno',$przekazOkno);
                        $this->load->view('footer');       


                        }



                        else {
                                echo "się porobiło źle";
                        }
                }







        //Chce mieć możliwość podglądniecia wszystkich okien;
                public function wszystkie_okna(){
                $this->load->helper(array('url'));
                $data['okna'] = array();
                $data['szablon']="class=\"profile-page sidebar-collapse\"";

                if ( $data['okna'] = $this->okno_model->listuj_okna() ) {
                $this->load->view('header');
                $this->load->view('tresc',$data);
                $this->load->view('lista_okien', $data);
                $this->load->view('footer');
                } else {
                        echo "nie udało sie wczytać listy okien";
                }
                


                }

public function beta(){
    $data['szablon']="class=\"profile-page sidebar-collapse\"";
    $this->load->helper(array('url'));
    $this->load->view('header');
    $this->load->view('tresc',$data );
    $this->load->view('dev');
    $this->load->view('footer');
}

public function slij_mail($adresat, $hashOkna){


        $this->load->library('email');
        $this->email->set_mailtype("html");
        $this->email->from('do-not-reply@nirski.com', 'Okno Johari');
        $this->email->to($adresat);
        $this->email->subject('Twoje Okno Johari - przydatne linki');

        $data = array(
            'url_okna'=> 'https://nirski.com/johari/index.php/okno/wyswietlOkno/'.$hashOkna.'/'.hash('ripemd160',$adresat),
            'url_znajomi'=> 'https://nirski.com/johari/index.php/okno/view/'.$hashOkna,
            'url_usun'=> '#',

        );

$message = $this->load->view('email/szablon.php',$data,TRUE);
//echo $message;
$this->email->message($message); 


$this->email->send();


    }

public function testowa(){
    $data['cechy'] = $this->okno_model->list_features2();
    $nowadata=array();

//    print_r($data['cechy']);
    foreach ($data['cechy'] as $cecha) {
 //       echo $cecha['cecha_pl']."=>".$cecha['id']."<br>";
        $nowadata[$cecha['cecha_pl']]=$cecha['id'];
    }
    ksort($nowadata);
    
    print_r($data['cechy']);

    print_r($nowadata);

}



}
