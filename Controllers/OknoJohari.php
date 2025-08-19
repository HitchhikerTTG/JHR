<?php

namespace App\Controllers;
use Config\Services;
use App\Models\CechyModel;
use App\Models\OknoModel;
use App\Models\UzytkownicyModel;
use App\Models\PrzypisaneCechyModel;
use App\Models\RateLimitModel;
use App\Models\SecurityLogModel;

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
    // PODSTAWOWE LOGOWANIE - sprawdź czy funkcja w ogóle się wykonuje
    log_message('error', 'FUNKCJA STWORZOKNO WYWOLANA - metoda: ' . $this->request->getMethod());
    log_message('error', 'REQUEST METHOD w if: ' . ($this->request->getMethod() === 'post' ? 'TRUE' : 'FALSE'));
    log_message('error', 'REQUEST METHOD dokładnie: [' . $this->request->getMethod() . ']');
    log_message('error', 'Wszystkie dane $_POST: ' . print_r($_POST, true));
    log_message('error', 'Wszystkie dane REQUEST: ' . print_r($_REQUEST, true));

    // BEZPIECZEŃSTWO - sprawdź IP i rate limiting
    $ipAddress = $this->request->getIPAddress();
    $userAgent = $this->request->getHeaderLine('User-Agent');

    $cechyModel = model(CechyModel::class);
    $oknoModel = model(OknoModel::class);
    $uzytkownikModel = model(UzytkownicyModel::class);
    $przypisaneCechyModel = model(PrzypisaneCechyModel::class);
    $rateLimitModel = model(RateLimitModel::class);
    $securityLogModel = model(SecurityLogModel::class);

    // Sprawdź czy IP jest zablokowane
    if ($securityLogModel->isBlocked($ipAddress)) {
        log_message('warning', 'Zablokowane IP próbuje utworzyć okno: ' . $ipAddress);
        return view('header')
             . view('error', ['horror' => 'Dostęp tymczasowo ograniczony. Spróbuj ponownie później.'])
             . view('footer');
    }

    $szablon = "class=\"landing-page sidebar-collapse\"";
    $data['szablon'] = $szablon;

    // DEBUG: Sprawdź wszystkie dane POST
    if ($this->request->getMethod() === 'POST') {
        log_message('error', 'TO JEST POST REQUEST!');
        log_message('error', 'Wszystkie dane POST: ' . print_r($_POST, true));
        log_message('debug', 'POST Data: ' . print_r($this->request->getPost(), true));
        log_message('debug', 'Request Method: ' . $this->request->getMethod());

        $featureList = $this->request->getPost('feature_list');
        log_message('debug', 'Feature List: ' . print_r($featureList, true));
        log_message('debug', 'Feature List Count: ' . (is_array($featureList) ? count($featureList) : 'not array'));
        log_message('debug', 'Debug Feature Count: ' . $this->request->getPost('debug_feature_count'));
    }

    // Sprawdź czy to żądanie POST (formularz został wysłany)
    if ($this->request->getMethod() === 'POST') {

        // RATE LIMITING - sprawdź czy użytkownik nie spamuje
        if (!$rateLimitModel->checkRateLimit($ipAddress, 'create_window', 3, 3600)) {
            $remainingTime = $rateLimitModel->getRemainingTime($ipAddress, 'create_window');
            log_message('warning', 'Rate limit exceeded for IP: ' . $ipAddress);

            $this->validator->setError('general', 'Zbyt wiele prób tworzenia okien. Spróbuj ponownie za ' . ceil($remainingTime/60) . ' minut.');

            // Loguj podejrzaną aktywność
            $suspiciousScore = $securityLogModel->calculateSuspiciousScore($ipAddress, $userAgent);
            $securityLogModel->logAction($ipAddress, $userAgent, 'rate_limit_exceeded', null, $suspiciousScore);

            // Wyświetl formularz z błędem
            $data['features'] = $cechyModel->getFeaturesForNewWindows();
            $data['validation'] = $this->validator;
            $data['post_url'] = '#komunikaty';

            return view('header')
                . view('tresc', $data)
                . view('ococho')
                . view('opis_nowe')
                . view('formularzyk', $data)
                . view('footer');
        }
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
            log_message('debug', 'ZAPISYWANIE OKNA - ROZPOCZĘCIE');

            // Dane są poprawne - zapisujemy okno
            $imie = $this->request->getPost('imie');
            $email = $this->request->getPost('email');
            $tytul = $this->request->getPost('tytul');

            // BEZPIECZEŃSTWO - sprawdź czy to nie podejrzana aktywność
            $suspiciousScore = $securityLogModel->calculateSuspiciousScore($ipAddress, $userAgent, $email);

            if ($suspiciousScore >= 5) {
                log_message('warning', 'Podejrzana aktywność przy tworzeniu okna: IP=' . $ipAddress . ', Email=' . $email . ', Score=' . $suspiciousScore);
                $securityLogModel->logAction($ipAddress, $userAgent, 'suspicious_window_creation', hash('ripemd160', $email), $suspiciousScore);

                $this->validator->setError('general', 'Wykryto podejrzaną aktywność. Twoje działanie zostało zarejestrowane.');

                // Wyświetl formularz z błędem
                $data['features'] = $cechyModel->getFeaturesForNewWindows();
                $data['validation'] = $this->validator;
                $data['post_url'] = '#komunikaty';

                return view('header')
                    . view('tresc', $data)
                    . view('ococho')
                    . view('opis_nowe')
                    . view('formularzyk', $data)
                    . view('footer');
            }

            // Loguj normalną aktywność
            $securityLogModel->logAction($ipAddress, $userAgent, 'window_created', hash('ripemd160', $email), $suspiciousScore);

            $hashAutora = hash('ripemd160', $email);
            $hashOkna = hash('ripemd160', $tytul . $email);

            log_message('debug', 'Hash Autora: ' . $hashAutora);
            log_message('debug', 'Hash Okna: ' . $hashOkna);

            // Sprawdź czy użytkownik już istnieje
            $existingUser = $uzytkownikModel->where('email', $email)->first();
            if (!$existingUser) {
                log_message('debug', 'Tworzenie nowego użytkownika');
                $userResult = $uzytkownikModel->save([
                    'email' => $email,
                    'name' => $imie,
                    'user_hash' => $hashAutora
                ]);
                log_message('debug', 'Wynik zapisu użytkownika: ' . ($userResult ? 'SUCCESS' : 'FAILED'));

                if (!$userResult) {
                    $userErrors = $uzytkownikModel->errors();
                    log_message('error', 'Błędy zapisu użytkownika: ' . print_r($userErrors, true));
                    // Można dodać obsługę błędu - np. przekierowanie z komunikatem
                }

                $userId = $uzytkownikModel->getInsertID();
                log_message('debug', 'ID nowego użytkownika: ' . $userId);
            } else {
                $userId = $existingUser['id'];
                log_message('debug', 'Używam istniejącego użytkownika ID: ' . $userId);
            }

            // Zapisz okno
            log_message('debug', 'Zapisywanie okna');
            $oknoData = [
                'nazwa' => $tytul,
                'hash' => $hashOkna,
                'wlasciciel' => $hashAutora,
                'imie_wlasciciela' => $imie,
                'id_zestaw_cech' => 2,
                'kluczyk' => $hashOkna
            ];
            log_message('debug', 'DANE OKNA DO ZAPISU: ' . print_r($oknoData, true));
            log_message('debug', 'Długości pól: nazwa=' . strlen($tytul) . ', hash=' . strlen($hashOkna) . ', wlasciciel=' . strlen($hashAutora) . ', imie=' . strlen($imie));

            $oknoResult = $oknoModel->save($oknoData);
            log_message('debug', 'Wynik zapisu okna: ' . ($oknoResult ? 'SUCCESS' : 'FAILED'));

            if (!$oknoResult) {
                $oknoErrors = $oknoModel->errors();
                log_message('error', 'Błędy zapisu okna: ' . print_r($oknoErrors, true));

                // Dodatkowe informacje o błędzie bazy danych
                $db = \Config\Database::connect();
                if ($db->error()['code'] != 0) {
                    log_message('error', 'Błąd bazy danych: ' . $db->error()['message']);
                }

                // Loguj ostatnie wykonane zapytanie SQL
                log_message('debug', 'Ostatnie zapytanie SQL: ' . $db->getLastQuery());
            }

            // Zapisz wybrane cechy
            log_message('debug', 'Zapisywanie cech - liczba: ' . count($featureList));
            foreach ($featureList as $cechaId) {
                $cechyData = [
                    'okno_johariego' => $hashOkna,
                    'cecha' => $cechaId,
                    'nadawca' => $hashAutora
                ];
                log_message('debug', 'DANE CECHY DO ZAPISU: ' . print_r($cechyData, true));

                $cechyResult = $przypisaneCechyModel->save($cechyData);
                log_message('debug', 'Cecha ' . $cechaId . ' zapisana: ' . ($cechyResult ? 'SUCCESS' : 'FAILED'));

                if (!$cechyResult) {
                    $cechyErrors = $przypisaneCechyModel->errors();
                    log_message('error', 'Błędy zapisu cechy ' . $cechaId . ': ' . print_r($cechyErrors, true));
                }
            }

            log_message('debug', 'ZAPISYWANIE OKNA - KONIEC');

            // Wyślij email z linkami
            $this->wyslijEmailPowitalny($email, $imie, $hashOkna, $hashAutora);

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
        } else {
            // WALIDACJA NIE PRZESZŁA
            log_message('debug', 'WALIDACJA NIEUDANA');
            log_message('debug', 'Błędy walidacji: ' . print_r($this->validator->getErrors(), true));
            log_message('debug', 'Liczba cech: ' . (is_array($featureList) ? count($featureList) : 'nie jest tablicą'));
            log_message('debug', 'validFeatureCount: ' . ($validFeatureCount ? 'true' : 'false'));
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
    // PODSTAWOWE LOGOWANIE
    log_message('error', 'FUNKCJA DODAJDOOKNA WYWOLANA - hash: ' . $hashOkna . ', metoda: ' . $this->request->getMethod());

    // BEZPIECZEŃSTWO
    $ipAddress = $this->request->getIPAddress();
    $userAgent = $this->request->getHeaderLine('User-Agent');

    $oknoModel = model(OknoModel::class);
    $uzytkownikModel = model(UzytkownicyModel::class);
    $PrzypisaneCechyModel = model(PrzypisaneCechyModel::class);
    $cechyModel = model(CechyModel::class);
    $rateLimitModel = model(RateLimitModel::class);
    $securityLogModel = model(SecurityLogModel::class);

    // Sprawdź czy IP jest zablokowane
    if ($securityLogModel->isBlocked($ipAddress)) {
        log_message('warning', 'Zablokowane IP próbuje dodać cechy: ' . $ipAddress);
        return view('header')
             . view('error', ['horror' => 'Dostęp tymczasowo ograniczony. Spróbuj ponownie później.'])
             . view('footer');
    }
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

    // Sprawdź jaki zestaw cech ma to okno
    $zestawCech = $toOkno['id_zestaw_cech'] ?? 1; // domyślnie 1 dla starych okien
    $data['features'] = $cechyModel->listFeatures($zestawCech);
    $data['hashOkna'] = $hashOkna;
    $data['zestaw_cech'] = $zestawCech;
    $szablon ="class=\"landing-page sidebar-collapse\"";
    $data['szablon'] = $szablon;

        $rules = [
            'email' => 'required|valid_email',
            'feature_list' => 'required',
            'feature_list.*' => 'is_natural_no_zero'
        ];
        $errors = [
            'email'=>[
                'required'=>"Email jest wymagany",
                'valid_email'=>'Podaj proszę prawidłowy adres e-mail',
            ],
            'feature_list' => [
                'required' => 'Musisz wybrać dokładnie 8 cech'
            ]
        ];


    if($this->request->getMethod()==='POST'){

        // RATE LIMITING - sprawdź czy użytkownik nie spamuje
        if (!$rateLimitModel->checkRateLimit($ipAddress, 'add_features', 5, 3600)) {
            $remainingTime = $rateLimitModel->getRemainingTime($ipAddress, 'add_features');
            log_message('warning', 'Rate limit exceeded for adding features, IP: ' . $ipAddress);

            $this->validator->setError('general', 'Zbyt wiele prób dodawania cech. Spróbuj ponownie za ' . ceil($remainingTime/60) . ' minut.');
        } else {
        // Dodatkowa walidacja dla liczby cech
        $featureList = $this->request->getPost('feature_list');
        $validFeatureCount = ($featureList && is_array($featureList) && count($featureList) === 8);

        // Sprawdź czy nadawca już nie dodawał cech do tego okna
        $emailHash = hash('ripemd160', $this->request->getPost('email'));
        $existingFeatures = $PrzypisaneCechyModel->where('okno_johariego', $hashOkna)
                                                 ->where('nadawca', $emailHash)
                                                 ->countAllResults();

        $senderAlreadyExists = ($existingFeatures > 0);

        if (!$validFeatureCount) {
            $this->validator->setError('feature_list', 'Musisz wybrać dokładnie 8 cech');
        }

        if ($senderAlreadyExists) {
            $this->validator->setError('email', 'Wedle mojej najlepszej wiedzy, dla tego okna mam już zapisane cechy "podpisane" tym adresem email.');
        }

        if($this->validate($rules,$errors) && $validFeatureCount && !$senderAlreadyExists){
            $data['validation']=$this->validator;

            // BEZPIECZEŃSTWO - sprawdź podejrzaną aktywność
            $email = $this->request->getPost('email');
            $suspiciousScore = $securityLogModel->calculateSuspiciousScore($ipAddress, $userAgent, $email);

            if ($suspiciousScore >= 5) {
                log_message('warning', 'Podejrzana aktywność przy dodawaniu cech: IP=' . $ipAddress . ', Email=' . $email);
                $securityLogModel->logAction($ipAddress, $userAgent, 'suspicious_feature_add', hash('ripemd160', $email), $suspiciousScore);

                $this->validator->setError('general', 'Wykryto podejrzaną aktywność. Twoje działanie zostało zarejestrowane.');

                // Wyświetl formularz z błędem (kontynuuj poniżej z pozostałymi zmiennymi)
                $data['features'] = $cechyModel->listFeatures($zestawCech);
                $data['hashOkna'] = $hashOkna;
                $data['zestaw_cech'] = $zestawCech;
                $data['validation'] = $this->validator;

                return view('header')
                    . view('tresc',$data)
                    . view('ococho_dla_znajomych')
                    . view('formularz_dodaj_do_okna', $data)
                    . view('footer');
            }

            // Loguj normalną aktywność
            $securityLogModel->logAction($ipAddress, $userAgent, 'features_added', hash('ripemd160', $email), $suspiciousScore);

            $wybrane_cechy = $this->request->getPost('feature_list');

        if (is_array($wybrane_cechy) && count($wybrane_cechy) > 0) {
            foreach ($wybrane_cechy as $cecha_do_zapisu) {
                $cechyDataDodaj = [
                    'okno_johariego' => $hashOkna,
                    'cecha' => $cecha_do_zapisu,
                    'nadawca' => hash('ripemd160', $this->request->getPost('email')),
                ];
                log_message('debug', 'DODAJ DO OKNA - DANE CECHY: ' . print_r($cechyDataDodaj, true));

                $result = $PrzypisaneCechyModel->save($cechyDataDodaj);

                if (!$result) {
                    $errors = $PrzypisaneCechyModel->errors();
                    log_message('error', 'Błąd zapisu cechy ' . $cecha_do_zapisu . ': ' . print_r($errors, true));

                    // Dodaj informacje o błędzie bazy danych
                    $db = \Config\Database::connect();
                    if ($db->error()['code'] != 0) {
                        log_message('error', 'Błąd bazy danych w dodajDoOkna: ' . $db->error()['message']);
                    }
                    log_message('debug', 'Ostatnie zapytanie SQL w dodajDoOkna: ' . $db->getLastQuery());
                }
            }
        } else {
            log_message('error', 'Brak wybranych cech lub nieprawidłowy format danych');
        }

        $data['nadawcy']=$PrzypisaneCechyModel->nadawcyOkna($hashOkna);
        $data['nadawca']['nadawca']=hash('ripemd160', $this->request->getPost('email'));

        return view('header')
        . view('dodane_sukces',$data)
        . view('footer');

        } else {
            // WALIDACJA NIE PRZESZŁA
            log_message('debug', 'WALIDACJA DODAJ DO OKNA NIEUDANA');
            log_message('debug', 'Błędy walidacji: ' . print_r($this->validator->getErrors(), true));
            log_message('debug', 'Liczba cech: ' . (is_array($featureList) ? count($featureList) : 'nie jest tablicą'));
            log_message('debug', 'validFeatureCount: ' . ($validFeatureCount ? 'true' : 'false'));
            log_message('debug', 'senderAlreadyExists: ' . ($senderAlreadyExists ? 'true' : 'false'));
        }
        } // Koniec rate limiting check
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

    // Sprawdź zestaw cech okna
    $zestawCech = $oknoModel->getWindowFeatureSet($hashOkna, $hashWlasciciela);

    // Delegacja analizy cech do modelu z uwzględnieniem zestawu cech
    $analizaCech = $oknoModel->analizyCechOkna($hashOkna, $hashWlasciciela, $zestawCech);

    $data['arena'] = $analizaCech['arena'];
    $data['prywatne'] = $analizaCech['prywatne'];
    $data['wskazane'] = $analizaCech['wskazane'];
    $data['pozostale'] = $analizaCech['pozostale'];
    $data['licznik'] = $analizaCech['licznik'];

    // Sprawdź czy okno wymaga tłumaczenia (tylko zestaw cech 1)
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
        log_message('info', 'TEST EMAIL - rozpoczynam wysyłanie do: ' . $adresat);

        try {
            $email = \Config\Services::email();

            $email->setFrom($_ENV['POSTMARK_FROM_EMAIL'] ?? 'okno@johari.pl', 'Okno Johari');
            $email->setTo($adresat);

            $email->setSubject('TEST - Twoje Okno Johari - przydatne linki');

            // Dodaj nagłówek Postmark dla strumienia wiadomości
            $email->setHeader('X-PM-Message-Stream', 'outbound');

            $data = array(
                'url_okna'=> 'https://johari.pl/wyswietlOkno/'.$hashOkna.'/'.hash('ripemd160',$adresat),
                'url_znajomi'=> 'https://johari.pl/okno/'.$hashOkna,
                'url_usun'=> '#',
            );

            $message = view('email/szablon.php',$data);
            $email->setMessage($message);

            log_message('debug', 'Email config check - Host: ' . $email->SMTPHost);

            if ($email->send()) {
                log_message('info', 'TEST EMAIL - sukces wysyłania do: ' . $adresat);
                echo "✅ Email wysłany pomyślnie do: " . $adresat . "<br>";
                echo "Sprawdź logi dla szczegółów.<br>";
            } else {
                log_message('error', 'TEST EMAIL - błąd wysyłania do: ' . $adresat);
                log_message('error', 'Email debugger: ' . $email->printDebugger());
                echo "❌ Błąd wysyłania emaila do: " . $adresat . "<br>";
                echo "Szczegóły błędu w logach.<br>";
                echo "Debug info: <pre>" . $email->printDebugger() . "</pre>";
            }
        } catch (\Exception $e) {
            log_message('error', 'TEST EMAIL - wyjątek: ' . $e->getMessage());
            echo "❌ Wyjątek podczas wysyłania: " . $e->getMessage() . "<br>";
        }
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

    private function wyslijEmailPowitalny($emailAdresat, $imie, $hashOkna, $hashAutora)
    {
        try {
            $email = \Config\Services::email();

            $email->setFrom($_ENV['POSTMARK_FROM_EMAIL'] ?? 'okno@johari.pl', 'Okno Johari');
            $email->setTo($emailAdresat);
            $email->setSubject('Twoje Okno Johari - przydatne linki');

            // Dodaj nagłówek Postmark dla strumienia wiadomości
            $email->setHeader('X-PM-Message-Stream', 'outbound');

            $data = [
                'imie' => $imie,
                'url_okna' => base_url('wyswietlOkno/' . $hashOkna . '/' . $hashAutora),
                'url_znajomi' => base_url('okno/' . $hashOkna),
                'url_usun' => '#',
            ];

            $message = view('email/szablon', $data);
            $email->setMessage($message);

            if ($email->send()) {
                log_message('info', 'Email powitalny wysłany do: ' . $emailAdresat);
            } else {
                log_message('error', 'Błąd wysyłania emaila do: ' . $emailAdresat);
                log_message('error', 'Email debugger: ' . $email->printDebugger());
            }
        } catch (\Exception $e) {
            log_message('error', 'Wyjątek podczas wysyłania emaila: ' . $e->getMessage());
        }
    }
}


?>