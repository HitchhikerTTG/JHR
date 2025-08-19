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
    $cechyModel = model(CechyModel::class);
    $oknoModel = model(OknoModel::class);
    $uzytkownikModel = model(UzytkownicyModel::class);
    $przypisaneCechyModel = model(PrzypisaneCechyModel::class);
    
    $szablon = "class=\"landing-page sidebar-collapse\"";
    $data['szablon'] = $szablon;

    // DEBUG: Sprawdź wszystkie dane POST
    if ($this->request->getMethod() === 'post') {
        log_message('debug', 'POST Data: ' . print_r($this->request->getPost(), true));
        log_message('debug', 'Request Method: ' . $this->request->getMethod());
        
        $featureList = $this->request->getPost('feature_list');
        log_message('debug', 'Feature List: ' . print_r($featureList, true));
        log_message('debug', 'Feature List Count: ' . (is_array($featureList) ? count($featureList) : 'not array'));
        log_message('debug', 'Debug Feature Count: ' . $this->request->getPost('debug_feature_count'));
    }

    // Sprawdź czy to żądanie POST (formularz został wysłany)
    if ($this->request->getMethod() === 'post') {
        $rules = [
            'imie' => 'required|min_length[2]',
            'email' => 'required|valid_email',
            'tytul' => 'required|min_length[3]',
            'feature_list' => 'required',
            'feature_list.*' => 'is_natural_no_zero'
        ];

        $errors = [
            'imie' => [
                'required' => 'Imię jest wymagane',
                'min_length' => 'Imię musi mieć co najmniej 2 znaki'
            ],
            'email' => [
                'required' => 'Email jest wymagany',
                'valid_email' => 'Podaj poprawny adres email'
            ],
            'tytul' => [
                'required' => 'Nazwa okna jest wymagana',
                'min_length' => 'Nazwa okna musi mieć co najmniej 3 znaki'
            ],
            'feature_list' => [
                'required' => 'Musisz wybrać dokładnie 8 cech'
            ]
        ];

        // Dodatkowa walidacja dla liczby cech
        $featureList = $this->request->getPost('feature_list');
        $validFeatureCount = ($featureList && is_array($featureList) && count($featureList) === 8);
        
        if (!$validFeatureCount) {
            $this->validator->setError('feature_list', 'Musisz wybrać dokładnie 8 cech');
        }

        if ($this->validate($rules, $errors) && $validFeatureCount) {
            // Dane są poprawne - zapisujemy okno
            $imie = $this->request->getPost('imie');
            $email = $this->request->getPost('email');
            $tytul = $this->request->getPost('tytul');
            
            $hashAutora = hash('ripemd160', $email);
            $hashOkna = hash('ripemd160', $tytul . $email);

            // Sprawdź czy użytkownik już istnieje
            $existingUser = $uzytkownikModel->where('email', $email)->first();
            if (!$existingUser) {
                $uzytkownikModel->save([
                    'imie' => $imie,
                    'email' => $email,
                    'hash' => $hashAutora
                ]);
                $userId = $uzytkownikModel->getInsertID();
            } else {
                $userId = $existingUser['id'];
            }

            // Zapisz okno
            $oknoModel->save([
                'nazwa' => $tytul,
                'hash' => $hashOkna,
                'id_wlasciciela' => $userId,
                'imie_wlasciciela' => $imie
            ]);

            // Zapisz wybrane cechy
            foreach ($featureList as $cechaId) {
                $przypisaneCechyModel->save([
                    'hash_okna' => $hashOkna,
                    'id_cechy' => $cechaId,
                    'hash_nadawcy' => $hashAutora
                ]);
            }

            $zapisywaneOkno = [
                'imie' => $imie,
                'tytul' => $tytul,
                'email' => $email,
                'hash_okna' => $hashOkna,
                'hash_autora' => $hashAutora
            ];

            return view('header')
                . view('formularz_nowe_okno_sukces', $zapisywaneOkno)
                . view('footer');
        }
    }

    // Wyświetl formularz (GET lub błędy walidacji)
    $data['features'] = $cechyModel->getFeaturesForNewWindows();
    $data['validation'] = $this->validator ?? \Config\Services::validation();
    $data['post_url'] = '#komunikaty';

    return view('header')
        . view('tresc', $data)
        . view('ococho')
        . view('opis_nowe')
        . view('formularzyk', $data)
        . view('footer');
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
    $data['features'] = $cechyModel->listFeatures(2); // Tylko zestaw cech 2
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

    $data['okno'] = $oknoModel->daneOkna($hashWlasciciela, $hashOkna);

    if (empty($data['okno'])) {
        $data['horror'] = "Błędnie podane parametry okna - nie mam czego wyświetlić. Jeśli jesteś pewien linku, z którego korzystasz, skontaktuj się ze sprawcą całego zamieszania";
        return view('header')
             . view('error', $data)
             . view('footer');
    }

    // Delegacja analizy cech do modelu
    $analizaCech = $oknoModel->analizyCechOkna($hashOkna, $hashWlasciciela);
    
    $data['arena'] = $analizaCech['arena'];
    $data['prywatne'] = $analizaCech['prywatne'];
    $data['wskazane'] = $analizaCech['wskazane'];
    $data['pozostale'] = $analizaCech['pozostale'];
    $data['licznik'] = $analizaCech['licznik'];

    // Sprawdź czy okno wymaga tłumaczenia (tylko zestaw cech 1)
    $zestawCech = $oknoModel->getWindowFeatureSet($hashOkna, $hashWlasciciela);
    $data['ma_tlumaczenie'] = ($zestawCech == 1);
    $data['hash_okna'] = $hashOkna;
    $data['hash_wlasciciela'] = $hashWlasciciela;

    return view('header')
         . view('wyswietl_okno', $data)
         . view('footer');
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
    public function tlumaczOkno($hashOkna, $hashWlasciciela) {
        // Sprawdź czy żądanie jest AJAX
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Only AJAX requests allowed']);
        }

        $oknoModel = model(\App\Models\OknoModel::class);
        
        // Sprawdź czy okno istnieje i ma stary zestaw cech
        $zestawCech = $oknoModel->getWindowFeatureSet($hashOkna, $hashWlasciciela);
        if ($zestawCech != 1) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'To okno nie wymaga tłumaczenia']);
        }

        // Pobierz analizę cech
        $analizaCech = $oknoModel->analizyCechOkna($hashOkna, $hashWlasciciela);
        
        // Przetłumacz okno
        $translatorModel = model(\App\Models\TranslatorCechModel::class);
        $przetlumaczonaWersja = $translatorModel->translateWindow($analizaCech, 1, 2);
        
        return $this->response->setJSON(['tlumaczenie' => $przetlumaczonaWersja]);
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