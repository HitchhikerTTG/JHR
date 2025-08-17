<?php

namespace App\Controllers;
use Config\Services;
use App\Models\CechyModel;
use App\Models\OknoModel;
use App\Models\UzytkownicyModel;
use App\Models\PrzypisaneCechyModel;

class OknoJohari extends BaseController
{
    protected $oknoModel;
    protected $session;

    function __construct()
    {

        $this->session = \Config\Services::session();
        $this->session->start();
        $this->oknoModel = new \App\Models\OknoModel();


    }

  public function stworzOkno()
  {
    $oknoModel = model(OknoModel::class);
    $uzytkownikModel = model(UzytkownicyModel::class);
    $PrzypisaneCechyModel = model(PrzypisaneCechyModel::class);
    $szablon ="class=\"landing-page sidebar-collapse\"";
    $data['szablon'] = $szablon;
    $cechyModel = model('CechyModel');
    $data['features'] = $cechyModel->listFeatures();

    $data['validation']=Services::validation();
    $rules=[
        'imie'=>'required|min_length[3]|max_length[255]',
        'email'=>'required|valid_email',
        'tytul'=>'required|min_length[5]|max_length[255]|oknoCheck[{email}]',

    ];
    $errors=[
        'imie'=>[
                'required'=>"Potrzebuję wiedzieć, jak się do Ciebie zwracać",
                'min_length'=>'Takie krótkie imię? Ej... co najmiej trzy litery daj',
                ],
        'email'=>[
                'required'=>"Potrzebuję wiedzieć, jak mogę do Ciebie napisać",
                'valid_email'=>'Najlepsze są te maile, na które da się wysłać maila...',
                ],
        'tytul'=>[
                'required'=>"Przyda się do identyfikowania okna",
                'min_length'=>'Za krótka nazwa. Poproszę o co najmiej 5 liter',
                'oknoCheck'=>'Wedle mojej najlepszej wiedzy, masz już okno o takiej nazwie',
                ]                                
    ];

       // $session = session();


        //$session->setFlashdata('validator', $this->validate($rules,$errors));
        //if ($this->validate($rules,$errors)){
        //    $session->setFlashdata('check', 'yes yes yes');
        //} else {
        //    $session->setFlashdata('check', 'no no no');
        //}

        //Spróbujmy to przepisać :)
        //Zamiast łączyć warunki, rozbierzmy je na dwa scenariusze

        if($this->request->getMethod()==='post') { // Jeśli mamy formularz do sprawdzenia
            if ($this->validate($rules, $errors)){ // kiedy udało się go dobrze sprawdzić
               if (!$uzytkownikModel->czyJuzJest($this->request->getPost('email'))){

            $uzytkownikModel ->save([
            //'name' => $this->request->getPost('imie'),
            'email' => $this->request->getPost('email'),
            'user_hash' =>hash('ripemd160', $this->request->getPost('email')),
        ]);

        }

        //Scenariusz, którego w tym momencie nie mam opracowanego to sytuacja w ktorej użytkownik chce stworzyć okno o takiej samej nazwie. 
        //Czyli wracamy do pytania, co czyni okno unikalnym?




        $oknoModel->save([
        'hash'=>hash('ripemd160', $this->request->getPost('tytul').$this->request->getPost('email')),
        'wlasciciel'=>  hash('ripemd160', $this->request->getPost('email')),
        'nazwa'=>$this->request->getPost('tytul'),
        'imie_wlasciciela' => $this->request->getPost('imie'),
        'id_zestaw_cech' => 2, // Nowe okna używają zestawu 2
        ]);
        $emailTworcy=$this->request->getPost('email');
        $hashOkna=hash('ripemd160', $this->request->getPost('tytul').$this->request->getPost('email'));

        $wybrane_cechy = $this->request->getPost('feature_list[]');  

        foreach ($wybrane_cechy as $cecha_do_zapisu) {
            $PrzypisaneCechyModel ->save ([
                'okno_johariego'=>hash('ripemd160', $this->request->getPost('tytul').$this->request->getPost('email')),
                'cecha'=> $cecha_do_zapisu,
                'nadawca' => hash('ripemd160', $this->request->getPost('email')),

            ]);

        }

             $zapisywaneOkno= array();
                        $zapisywaneOkno = array(
                        'imie'=>$this->request->getPost('imie'),
                        'tytul'=>$this->request->getPost('tytul'),
                        'email'=>$this->request->getPost('email'),
                        'szablon'=>"class=\"profile-page sidebar-collapse\"",
                       'hash_autora'=>hash('ripemd160',$this->request->getPost('email')),
                        'hash_okna'=> hash('ripemd160', $this->request->getPost('tytul').$this->request->getPost('email')),
                    );
            $this->slijMaila($emailTworcy,$hashOkna);
        return view('header')
        . view('formularz_nowe_okno_sukces',$zapisywaneOkno)
        . view('footer');

            } else { // kiedy sprawdzenie wykazało błędy
                $data['validation']=$this->validator;
                $data['post_url']='#komunikaty';
                return view('header')
                            . view ('tresc',$data)
                            . view ('ococho')
                            . view('opis_nowe')
                            . view ('formularzyk', $data)
                            . view ('footer');
            }
        }




/*

    if($this->request->getMethod()==='post'&&$this->validate($rules,$errors)){

        // zacznijmy od sprawdzenia, czy mamy takiego użytkownika w bazie. Jeśli mamy - chill, jeśli nie mamy, zapisujemy
        $data['validation']=$this->validator;

        if (!$uzytkownikModel->czyJuzJest($this->request->getPost('email'))){

            $uzytkownikModel ->save([
            //'name' => $this->request->getPost('imie'),
            'email' => $this->request->getPost('email'),
            'user_hash' =>hash('ripemd160', $this->request->getPost('email')),
        ]);

        }

        //Scenariusz, którego w tym momencie nie mam opracowanego to sytuacja w ktorej użytkownik chce stworzyć okno o takiej samej nazwie. 
        //Czyli wracamy do pytania, co czyni okno unikalnym?




        $oknoModel->save([
        'hash'=>hash('ripemd160', $this->request->getPost('tytul').$this->request->getPost('email')),
        'wlasciciel'=>  hash('ripemd160', $this->request->getPost('email')),
        'nazwa'=>$this->request->getPost('tytul'),
        'imie_wlasciciela' => $this->request->getPost('imie'),
        ]);
        $emailTworcy=$this->request->getPost('email');
        $hashOkna=hash('ripemd160', $this->request->getPost('tytul').$this->request->getPost('email'));

        $wybrane_cechy = $this->request->getPost('feature_list[]');  

        foreach ($wybrane_cechy as $cecha_do_zapisu) {
            $PrzypisaneCechyModel ->save ([
                'okno_johariego'=>hash('ripemd160', $this->request->getPost('tytul').$this->request->getPost('email')),
                'cecha'=> $cecha_do_zapisu,
                'nadawca' => hash('ripemd160', $this->request->getPost('email')),

            ]);

        }

             $zapisywaneOkno= array();
                        $zapisywaneOkno = array(
                        'imie'=>$this->request->getPost('imie'),
                        'tytul'=>$this->request->getPost('tytul'),
                        'email'=>$this->request->getPost('email'),
                        'szablon'=>"class=\"profile-page sidebar-collapse\"",
                       'hash_autora'=>hash('ripemd160',$this->request->getPost('email')),
                        'hash_okna'=> hash('ripemd160', $this->request->getPost('tytul').$this->request->getPost('email')),
                    );
            $this->slijMaila($emailTworcy,$hashOkna);
        return view('header')
        . view('formularz_nowe_okno_sukces',$zapisywaneOkno)
        . view('footer');
    }*/


    return view('header')
    . view ('tresc',$data)
    . view ('ococho')
    . view('opis_nowe')
    . view ('formularzyk', $data)
    . view ('footer');
  }

  public function dodajDoOkna($hashOkna=false){
    // co zrobić, kiedy nie mam takiego okna - komunikat o błędzie - nie ma takiego okna i np. stwórz własne

    $oknoModel = model(OknoModel::class);
    $uzytkownikModel = model(UzytkownicyModel::class);
    $PrzypisaneCechyModel = model(PrzypisaneCechyModel::class);
    $cechyModel = model(CechyModel::class);
    $toOkno = $oknoModel->where('hash', $hashOkna)->first();

    if ($toOkno['imie_wlasciciela']){
       $data['ImieWlasciciela']=$toOkno['imie_wlasciciela'];
    } else {
       $data['ImieWlasciciela']="Bezimienny";

    }



    if (isset($wynikZaptanieOkno)){
        $data['ImieWlasciciela']=$wynikZaptanieOkno->imie_wlasciciela;
    }

    $data['validation']=Services::validation();
    $data['features'] = $cechyModel->listFeatures();
    $data['hashOkna'] = $hashOkna;
    $szablon ="class=\"landing-page sidebar-collapse\"";
    $data['szablon'] = $szablon;

        $rules = [
            'email' => 'required|valid_email|sprawdzNadawce[{okno}]',
        ];
        $errors = [
            'email'=>[
                'required'=>"Email jest wymagany",
                'valid_email'=>'Podaj proszę prawidłowy adres e-mail',
                'sprawdzNadawce'=>'Wedle mojej najlepszej wiedzy, dla tego okna mam już zapisane cechy "podpisane" tym adresem email.',

            ]
        ];


    if($this->request->getMethod()==='post'&&$this->validate($rules,$errors)){
         $data['validation']=$this->validator;

        //Sprawdź, czy dla danego okna $hashokna są juz zapisane cechy od tego 

        $wybrane_cechy = $this->request->getPost('feature_list[]');  

        foreach ($wybrane_cechy as $cecha_do_zapisu) {
            $PrzypisaneCechyModel ->save ([
                'okno_johariego'=>$hashOkna,
                'cecha'=> $cecha_do_zapisu,
                'nadawca' => hash('ripemd160', $this->request->getPost('email')),

            ]);

        }

        $data['nadawcy']=$PrzypisaneCechyModel->nadawcyOkna($hashOkna);
        $data['nadawca']['nadawca']=hash('ripemd160', $this->request->getPost('email'));

        return view('header')
        . view('dodane_sukces',$data)
        . view('footer');

    }



        return view('header')
    . view ('tresc',$data)
    . view('ococho_dla_znajomych')
    . view ('formularz_dodaj_do_okna', $data)
    . view ('footer');
  }


  public function wszystkieOkna($wlasciciel = false){

    //$oknoModel = model(OknoModel::class);
    //$data['okna'] = $oknoModel->listOkna($wlasciciel);
    $data['okna']=$this->oknoModel->listOkna($wlasciciel);
    $data['statystyki'] = $this->oknoModel->getStatystyki();
    return view ('header')

    . view ('lista_okien',$data)
    . view ('footer');

  }

  public function wyswietlOkno($hashOkna, $hashWlasciciela) {

    $oknoModel = model(\App\Models\OknoModel::class);
    $przypisaneCechyModel = model(\App\Models\PrzypisaneCechyModel::class);
    $cechyModel = model(\App\Models\CechyModel::class);

    // Check if CechyModel was loaded properly
    if (!$cechyModel) {
        $data['horror'] = "Błąd wewnętrzny aplikacji - nie można załadować modelu cech";
        return view('header')
             . view('error', $data)
             . view('footer');
    }

    $nazwaneCechy = $cechyModel->listFeatures();


    $prywatne=[];
    $wskazane=[];
    $pozostale=range(1,139); // To wypełnia tabelkę liczbami od 1 do 139

    $data['okno']=$oknoModel->daneOkna($hashWlasciciela,$hashOkna);

    if (empty($data['okno'])) {
            $data['horror']="Błędnie podane parametry okna - nie mam czego wyświetlić. Jeśli jesteś pewien linku, z którego korzystasz, skontaktuj się ze sprawcą całego zamieszania";
            return    view ('header')
                    . view ('error',$data)
                    . view ('footer');
        }
    else {

    $wszystkieZapisaneCechy = $przypisaneCechyModel->cechyOkna($hashOkna);
    $data['licznik']=count($wszystkieZapisaneCechy);

    foreach ($wszystkieZapisaneCechy as $zapisanaCecha){

        if ($zapisanaCecha['nadawca']===$hashWlasciciela) {
            array_push($prywatne,$zapisanaCecha['cecha']);
            //$arena[]=$zapisanaCecha['cecha']=>$nazwaneCechy['cecha'];
            //array_push($arena, array($zapisanaCecha['cecha'],$nazwaneCechy[$zapisanaCecha['cecha']]['cecha_pl']));
        }
        if ($zapisanaCecha['nadawca']!=$hashWlasciciela){
//            $wskazane[]=$zapisanaCecha['cecha']=>$nazwaneCechy['cecha'];
            array_push($wskazane,$zapisanaCecha['cecha']);
            //array_push($wskazane, array($zapisanaCecha['cecha'],$nazwaneCechy[$zapisanaCecha['cecha']]['cecha_pl']));

        }


    }
            $arena=array_intersect($prywatne, $wskazane);
            $prywatne=array_diff($prywatne, $arena);
            $wskazane=array_diff($wskazane, $arena);
            $pozostale=array_diff($pozostale, $arena, $wskazane, $prywatne);
    foreach ($arena as &$cechaID){
        $cechaID=array($cechaID,$nazwaneCechy[$cechaID-1]['cecha_pl']);        
    }

    foreach ($wskazane as &$cechaID){
        $cechaID=array($cechaID,$nazwaneCechy[$cechaID-1]['cecha_pl']);        
    }

        foreach ($prywatne as &$cechaID){
        $cechaID=array($cechaID,$nazwaneCechy[$cechaID-1]['cecha_pl']);        
    }

        foreach ($pozostale as &$cechaID){
        $cechaID=array($cechaID,$nazwaneCechy[$cechaID-1]['cecha_pl']);        
    }

    $data['arena']=$arena;
    $data['wskazane']=$wskazane;
    $data['prywatne']=$prywatne;
    $data['pozostale']=$pozostale;

    /*echo "Arena:<br>";
    echo "<pre>";
    print_r($arena);
    echo "</pre>";
    echo "Publiczne:<br>";
    echo "<pre>";
    print_r($publiczne);
    echo "</pre>";
    echo "Niewidoczne:<br>";
    echo "<pre>";
    print_r($wskazane);
    echo "</pre>";


    echo "<pre>";
    print_r($data);
    echo "</pre>";
    */

    return view ('header')

    . view ('wyswietl_okno',$data)
    . view ('footer');

}
  }

    public function beta(){
    $data['szablon']="class=\"profile-page sidebar-collapse\"";
    //$this->load->helper(array('url'));
    return view('header') 
    . view('tresc',$data )
    . view('dev')
    . view('footer');

    }

    public function slijMaila($adresat='wit@nirski.com', $hashOkna='35e1ae5e03a8cd91ffaebae43b7b402638bfa992'){
        $email = \Config\Services::email();

        $email->setFrom('okno@johari.pl', 'Okno Johari');
        $email->setTo($adresat);

        $email->setSubject('Twoje Okno Johari - przydatne linki');


//        $this->email->from('techniczny@johari.pl', 'Okno Johari');
//        $this->email->to($adresat);
//        $this->email->subject('Twoje Okno Johari - przydatne linki');

        $data = array(
            'url_okna'=> 'https://johari.pl/wyswietlOkno/'.$hashOkna.'/'.hash('ripemd160',$adresat),
            'url_znajomi'=> 'https://johari.pl/okno/'.$hashOkna,
            'url_usun'=> '#',

        );

$message = view('email/szablon.php',$data);
//echo $message;
        $email->send();


    }
    public function polityka(){
            $data['szablon']="class=\"profile-page sidebar-collapse\"";
            $data['title']="Polityka Prywatności Johari.pl";
        return view('header',$data)
        .view ('tresc', $data)
        .view ('polityka')
        .view ('footer');
    }
}


?>