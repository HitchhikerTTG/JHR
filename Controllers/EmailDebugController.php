<?php
#gdyż kochamy zostawiać pustą linię
namespace App\Controllers;

use Config\Services;

class EmailDebugController extends BaseController
{
    public function debugEmail($adresat = 'test@blackhole.postmarkapp.com', $hashOkna = '35e1ae5e03a8cd91ffaebae43b7b402638bfa992')
    {
        echo "<h1>🔍 Debug procesu wysyłania emaila</h1>";
        echo "<style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            .step { background: #f5f5f5; padding: 15px; margin: 10px 0; border-left: 4px solid #007bff; }
            .success { border-left-color: #28a745; background: #d4edda; }
            .error { border-left-color: #dc3545; background: #f8d7da; }
            .warning { border-left-color: #ffc107; background: #fff3cd; }
            .info { border-left-color: #17a2b8; background: #d1ecf1; }
            pre { background: #f8f9fa; padding: 10px; border-radius: 4px; overflow-x: auto; }
            .code { font-family: monospace; background: #e9ecef; padding: 2px 4px; border-radius: 3px; }
            button { padding: 10px 20px; margin: 5px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; }
            button:hover { background: #0056b3; }
        </style>";

        // KROK 1: Sprawdzenie zmiennych środowiskowych
        echo "<div class='step'>";
        echo "<h2>🔧 KROK 1: Sprawdzenie konfiguracji środowiskowej</h2>";
        
        $envVars = [
            'POSTMARK_SERVER_TOKEN' => $_ENV['POSTMARK_SERVER_TOKEN'] ?? null,
            'POSTMARK_FROM_EMAIL' => $_ENV['POSTMARK_FROM_EMAIL'] ?? null,
            'email.SMTPHost' => env('email.SMTPHost'),
            'email.SMTPPort' => env('email.SMTPPort'),
            'email.SMTPUser' => env('email.SMTPUser'),
            'email.SMTPPass' => env('email.SMTPPass'),
            'email.protocol' => env('email.protocol', 'smtp'),
        ];

        foreach ($envVars as $key => $value) {
            if ($value) {
                if (strpos($key, 'Pass') !== false || strpos($key, 'TOKEN') !== false) {
                    $masked = substr($value, 0, 4) . '...' . substr($value, -4);
                    echo "✅ <span class='code'>{$key}</span>: {$masked} (długość: " . strlen($value) . ")<br>";
                } else {
                    echo "✅ <span class='code'>{$key}</span>: {$value}<br>";
                }
            } else {
                echo "❌ <span class='code'>{$key}</span>: BRAK<br>";
            }
        }
        echo "</div>";

        // KROK 2: Test połączenia z API Postmark
        echo "<div class='step'>";
        echo "<h2>🌐 KROK 2: Test połączenia z API Postmark</h2>";
        
        $postmarkToken = $_ENV['POSTMARK_SERVER_TOKEN'] ?? null;
        if ($postmarkToken) {
            $this->testPostmarkAPI($postmarkToken);
        } else {
            echo "❌ Brak tokenu Postmark - nie można przetestować API<br>";
        }
        echo "</div>";

        // KROK 3: Sprawdzenie konfiguracji Email
        echo "<div class='step'>";
        echo "<h2>⚙️ KROK 3: Konfiguracja obiektu Email</h2>";
        
        try {
            $emailConfig = new \Config\Email();
            echo "✅ Obiekt konfiguracji Email utworzony<br>";
            echo "📋 Protocol: " . ($emailConfig->protocol ?? 'BRAK') . "<br>";
            echo "📋 SMTP Host: " . ($emailConfig->SMTPHost ?? 'BRAK') . "<br>";
            echo "📋 SMTP Port: " . ($emailConfig->SMTPPort ?? 'BRAK') . "<br>";
            echo "📋 SMTP Crypto: " . ($emailConfig->SMTPCrypto ?? 'BRAK') . "<br>";
            echo "📋 SMTP User: " . ($emailConfig->SMTPUser ? $this->maskString($emailConfig->SMTPUser) : 'BRAK') . "<br>";
            echo "📋 From Email: " . ($emailConfig->fromEmail ?? 'BRAK') . "<br>";
            echo "📋 From Name: " . ($emailConfig->fromName ?? 'BRAK') . "<br>";
        } catch (\Exception $e) {
            echo "❌ Błąd konfiguracji Email: " . $e->getMessage() . "<br>";
        }
        echo "</div>";

        // KROK 4: Inicjalizacja usługi email
        echo "<div class='step'>";
        echo "<h2>🚀 KROK 4: Inicjalizacja usługi email</h2>";
        
        try {
            $email = Services::email();
            echo "✅ Usługa email zainicjalizowana<br>";
            
            $reflection = new \ReflectionClass($email);
            echo "📋 Klasa: " . $reflection->getName() . "<br>";
        } catch (\Exception $e) {
            echo "❌ Błąd inicjalizacji: " . $e->getMessage() . "<br>";
            return;
        }
        echo "</div>";

        // KROK 5: Ustawienie parametrów email
        echo "<div class='step'>";
        echo "<h2>📧 KROK 5: Konfiguracja wiadomości</h2>";
        
        $fromEmail = $_ENV['POSTMARK_FROM_EMAIL'] ?? 'johari@testujac.pl';
        $fromName = '[DEBUG] Okno Johari';
        $subject = 'DEBUG - Test wysyłania z ' . date('Y-m-d H:i:s');
        
        try {
            $email->setFrom($fromEmail, $fromName);
            echo "✅ Nadawca: {$fromName} &lt;{$fromEmail}&gt;<br>";
            
            $email->setTo($adresat);
            echo "✅ Odbiorca: {$adresat}<br>";
            
            $email->setSubject($subject);
            echo "✅ Temat: {$subject}<br>";
            
            // Ustawienia specyficzne dla Postmark
            $email->setHeader('X-PM-Message-Stream', 'outbound');
            echo "✅ Postmark Stream: outbound<br>";
            
            // Dodaj tag dla łatwiejszego śledzenia
            $email->setHeader('X-PM-Tag', 'debug-test');
            echo "✅ Postmark Tag: debug-test<br>";
            
        } catch (\Exception $e) {
            echo "❌ Błąd konfiguracji: " . $e->getMessage() . "<br>";
        }
        echo "</div>";

        // KROK 6: Przygotowanie treści
        echo "<div class='step'>";
        echo "<h2>📄 KROK 6: Przygotowanie treści wiadomości</h2>";
        
        $hashAutora = hash('ripemd160', $adresat);
        $data = [
            'imie' => 'DEBUG Tester',
            'url_okna' => base_url('wyswietlOkno/' . $hashOkna . '/' . $hashAutora),
            'url_znajomi' => base_url('okno/' . $hashOkna),
            'url_usun' => '#',
        ];
        
        try {
            $message = view('email/szablon', $data);
            $email->setMessage($message);
            echo "✅ Treść wiadomości przygotowana (długość: " . strlen($message) . " znaków)<br>";
            
            $preview = substr(strip_tags($message), 0, 150) . '...';
            echo "👀 Podgląd: <em>{$preview}</em><br>";
        } catch (\Exception $e) {
            echo "❌ Błąd treści: " . $e->getMessage() . "<br>";
            return;
        }
        echo "</div>";

        // KROK 7: Test połączenia SMTP
        echo "<div class='step'>";
        echo "<h2>🔌 KROK 7: Test połączenia SMTP</h2>";
        
        $smtpHost = env('email.SMTPHost', 'smtp.postmarkapp.com');
        $smtpPort = env('email.SMTPPort', 587);
        
        $connection = @fsockopen($smtpHost, $smtpPort, $errno, $errstr, 10);
        if ($connection) {
            echo "✅ Połączenie z {$smtpHost}:{$smtpPort} - OK<br>";
            fclose($connection);
        } else {
            echo "❌ Nie można połączyć z {$smtpHost}:{$smtpPort} - {$errstr} (kod: {$errno})<br>";
        }
        echo "</div>";

        // KROK 7.5: Sprawdzenie finalnej konfiguracji przed wysłaniem
        echo "<div class='step info'>";
        echo "<h2>🔍 KROK 7.5: Finalna konfiguracja przed wysłaniem</h2>";
        
        // Debug konfiguracji email obiektu
        $reflection = new \ReflectionClass($email);
        $properties = $reflection->getProperties();
        
        echo "<strong>Konfiguracja obiektu Email:</strong><br>";
        foreach ($properties as $property) {
            $property->setAccessible(true);
            $value = $property->getValue($email);
            if ($value !== null && !is_object($value) && !is_array($value)) {
                if (strpos($property->getName(), 'pass') !== false || strpos($property->getName(), 'Pass') !== false) {
                    $value = $this->maskString($value);
                }
                echo "📋 {$property->getName()}: {$value}<br>";
            }
        }
        
        // Porównaj konfigurację obiektu vs zmienne środowiskowe
        echo "<br><strong>Porównanie konfiguracji:</strong><br>";
        $emailConfig = new \Config\Email();
        
        $comparison = [
            'SMTP Host' => [
                'Obiekt Config' => $emailConfig->SMTPHost ?? 'BRAK',
                'env()' => env('email.SMTPHost') ?? 'BRAK'
            ],
            'SMTP Port' => [
                'Obiekt Config' => $emailConfig->SMTPPort ?? 'BRAK',
                'env()' => env('email.SMTPPort') ?? 'BRAK'
            ],
            'SMTP User' => [
                'Obiekt Config' => $emailConfig->SMTPUser ? $this->maskString($emailConfig->SMTPUser) : 'BRAK',
                'env()' => env('email.SMTPUser') ? $this->maskString(env('email.SMTPUser')) : 'BRAK'
            ],
            'From Email' => [
                'Obiekt Config' => $emailConfig->fromEmail ?? 'BRAK',
                'env()' => env('email.fromEmail') ?? 'BRAK'
            ]
        ];
        
        foreach ($comparison as $field => $values) {
            echo "📋 <strong>{$field}:</strong><br>";
            echo "&nbsp;&nbsp;Config: {$values['Obiekt Config']}<br>";
            echo "&nbsp;&nbsp;env(): {$values['env()']}<br>";
            if ($values['Obiekt Config'] !== $values['env()']) {
                echo "&nbsp;&nbsp;⚠️ RÓŻNICA!<br>";
            }
            echo "<br>";
        }
        
        // Sprawdź czy wszystkie wymagane dane są ustawione (używaj konfiguracji obiektu)
        echo "<strong>Walidacja wymaganych pól (z obiektu Config):</strong><br>";
        $required = [
            'From Email' => $fromEmail,
            'SMTP Host' => $emailConfig->SMTPHost,
            'SMTP User' => $emailConfig->SMTPUser,
            'SMTP Pass' => $emailConfig->SMTPPass ? '***SET***' : 'MISSING'
        ];
        
        foreach ($required as $field => $value) {
            if ($value && $value !== 'MISSING') {
                echo "✅ {$field}: OK<br>";
            } else {
                echo "❌ {$field}: BRAK!<br>";
            }
        }
        echo "</div>";

        // KROK 8: Wysyłanie (z opcją test/rzeczywiste)
        echo "<div class='step'>";
        echo "<h2>📤 KROK 8: Wysyłanie emaila</h2>";
        
        $sendReal = $this->request->getGet('send') === 'true';
        
        if (!$sendReal) {
            echo "<div class='warning'>";
            echo "⚠️ TRYB TESTOWY - email NIE zostanie wysłany<br>";
            echo "<button onclick=\"window.location.href='" . current_url() . "?send=true'\">🚀 WYŚLIJ RZECZYWIŚCIE</button><br>";
            echo "</div>";
        } else {
            $startTime = microtime(true);
            
            try {
                // Dodatkowy log przed wysłaniem
                log_message('info', 'DEBUG EMAIL START - adresat: ' . $adresat . ', fromEmail: ' . $fromEmail);
                
                // Sprawdź debugger PRZED wysłaniem
                echo "<strong>Pre-send debugger:</strong><br>";
                echo "<pre>" . htmlspecialchars($email->printDebugger()) . "</pre>";
                
                if ($email->send()) {
                    $duration = round((microtime(true) - $startTime) * 1000, 2);
                    echo "<div class='success'>";
                    echo "✅ Email wysłany pomyślnie!<br>";
                    echo "📧 Adresat: {$adresat}<br>";
                    echo "📧 Nadawca: {$fromEmail}<br>";
                    echo "⏱️ Czas wysyłania: {$duration}ms<br>";
                    echo "</div>";
                    
                    // Post-send debugger
                    echo "<strong>Post-send debugger:</strong><br>";
                    echo "<pre>" . htmlspecialchars($email->printDebugger()) . "</pre>";
                    
                    log_message('info', 'DEBUG EMAIL SUCCESS - adresat: ' . $adresat . ', czas: ' . $duration . 'ms, fromEmail: ' . $fromEmail);
                } else {
                    echo "<div class='error'>";
                    echo "❌ Błąd wysyłania emaila<br>";
                    echo "🔍 Debug info:<br>";
                    echo "<pre>" . htmlspecialchars($email->printDebugger()) . "</pre>";
                    echo "</div>";
                    
                    log_message('error', 'DEBUG EMAIL FAILED - adresat: ' . $adresat . ', fromEmail: ' . $fromEmail);
                    log_message('error', 'DEBUG EMAIL DEBUGGER: ' . $email->printDebugger());
                }
            } catch (\Exception $e) {
                echo "<div class='error'>";
                echo "❌ Wyjątek podczas wysyłania: " . $e->getMessage() . "<br>";
                echo "📋 Ślad: <pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
                echo "</div>";
                
                log_message('error', 'DEBUG EMAIL EXCEPTION: ' . $e->getMessage() . ', fromEmail: ' . $fromEmail);
            }
        }
        echo "</div>";

        // KROK 9: Sprawdzenie Activity w Postmark
        if ($sendReal && $postmarkToken) {
            echo "<div class='step'>";
            echo "<h2>📊 KROK 9: Sprawdzenie Activity w Postmark</h2>";
            $this->checkPostmarkActivity($postmarkToken);
            echo "</div>";
        }

        // KROK 10: Sprawdzenie logów
        echo "<div class='step'>";
        echo "<h2>📋 KROK 10: Ostatnie wpisy w logach</h2>";
        $this->showRecentEmailLogs();
        echo "</div>";

        // PODSUMOWANIE
        echo "<div class='step info'>";
        echo "<h2>🎯 PODSUMOWANIE i REKOMENDACJE</h2>";
        echo "<strong>Dla problemu z kolejkowaniem w Postmark sprawdź:</strong><br>";
        echo "1. 🔍 <a href='https://account.postmarkapp.com/servers' target='_blank'>Activity w panelu Postmark</a><br>";
        echo "2. 📊 Rate limiting - Basic plan ma limit 100 emaili/godzinę<br>";
        echo "3. 🏷️ Message Stream - czy 'outbound' istnieje w twoim serwerze<br>";
        echo "4. 📧 Czy adres nadawcy jest zweryfikowany<br>";
        echo "5. 🚫 Czy nie masz aktywnych suppressions<br><br>";
        
        echo "<button onclick=\"window.location.href='" . base_url('emailDebug/debugEmail/' . urlencode($adresat) . '/' . $hashOkna) . "'\">🔄 Uruchom ponownie</button> ";
        echo "<button onclick=\"window.location.href='" . base_url('emailDebug/postmarkStatus') . "'\">📊 Sprawdź status Postmark</button><br>";
        echo "</div>";
    }

    public function postmarkStatus()
    {
        echo "<h1>📊 Status serwera Postmark</h1>";
        
        $postmarkToken = $_ENV['POSTMARK_SERVER_TOKEN'] ?? null;
        if (!$postmarkToken) {
            echo "❌ Brak tokenu Postmark";
            return;
        }

        // Sprawdź informacje o serwerze
        $this->getPostmarkServerInfo($postmarkToken);
        
        // Sprawdź ostatnie wiadomości
        $this->getRecentPostmarkMessages($postmarkToken);
    }

    private function testPostmarkAPI($token)
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.postmarkapp.com/server',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'X-Postmark-Server-Token: ' . $token
            ],
        ]);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $error = curl_error($curl);
        curl_close($curl);

        if ($error) {
            echo "❌ Błąd połączenia z API: {$error}<br>";
        } elseif ($httpCode === 200) {
            echo "✅ Połączenie z API Postmark - OK<br>";
            $data = json_decode($response, true);
            if ($data) {
                echo "📋 Serwer: " . ($data['Name'] ?? 'N/A') . "<br>";
                echo "📋 ID: " . ($data['ID'] ?? 'N/A') . "<br>";
            }
        } else {
            echo "❌ API zwróciło kod: {$httpCode}<br>";
            echo "📋 Odpowiedź: " . htmlspecialchars($response) . "<br>";
        }
    }

    private function getPostmarkServerInfo($token)
    {
        echo "<h2>🖥️ Informacje o serwerze</h2>";
        
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.postmarkapp.com/server',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'X-Postmark-Server-Token: ' . $token
            ],
        ]);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($httpCode === 200) {
            $data = json_decode($response, true);
            echo "<pre>" . json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "</pre>";
        } else {
            echo "❌ Nie można pobrać informacji o serwerze (kod: {$httpCode})<br>";
        }
    }

    private function getRecentPostmarkMessages($token)
    {
        echo "<h2>📨 Ostatnie wiadomości</h2>";
        
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.postmarkapp.com/messages/outbound?count=20',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'X-Postmark-Server-Token: ' . $token
            ],
        ]);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($httpCode === 200) {
            $data = json_decode($response, true);
            if (isset($data['Messages'])) {
                echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
                echo "<tr><th>Data</th><th>Adresat</th><th>Temat</th><th>Status</th><th>Tag</th></tr>";
                foreach ($data['Messages'] as $msg) {
                    echo "<tr>";
                    echo "<td>" . ($msg['ReceivedAt'] ?? 'N/A') . "</td>";
                    echo "<td>" . htmlspecialchars($msg['Recipients'][0] ?? 'N/A') . "</td>";
                    echo "<td>" . htmlspecialchars(substr($msg['Subject'] ?? 'N/A', 0, 50)) . "</td>";
                    echo "<td>" . ($msg['Status'] ?? 'N/A') . "</td>";
                    echo "<td>" . ($msg['Tag'] ?? 'brak') . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        } else {
            echo "❌ Nie można pobrać listy wiadomości (kod: {$httpCode})<br>";
        }
    }

    private function showRecentEmailLogs()
    {
        $logPath = WRITEPATH . 'logs/log-' . date('Y-m-d') . '.php';
        if (file_exists($logPath)) {
            $logContent = file_get_contents($logPath);
            $lines = explode("\n", $logContent);
            $emailLines = array_filter($lines, function($line) {
                return stripos($line, 'email') !== false || stripos($line, 'DEBUG EMAIL') !== false;
            });
            
            if (!empty($emailLines)) {
                echo "📄 Ostatnie wpisy email:<br>";
                echo "<pre>" . htmlspecialchars(implode("\n", array_slice($emailLines, -15))) . "</pre>";
            } else {
                echo "ℹ️ Brak wpisów email w dzisiejszych logach<br>";
            }
        } else {
            echo "⚠️ Brak pliku logów na dziś<br>";
        }
    }

    private function maskString($str)
    {
        if (strlen($str) <= 8) return str_repeat('*', strlen($str));
        return substr($str, 0, 4) . '...' . substr($str, -4);
    }

    public function quickTest($adresat = 'test@blackhole.postmarkapp.com')
    {
        echo "<h1>⚡ Szybki test wysyłania emaila</h1>";
        
        try {
            $email = Services::email();
            $email->setFrom($_ENV['POSTMARK_FROM_EMAIL'] ?? 'okno@johari.pl', 'Quick Test Johari');
            $email->setTo($adresat);
            $email->setSubject('Quick Test - ' . date('Y-m-d H:i:s'));
            $email->setHeader('X-PM-Message-Stream', 'outbound');
            $email->setHeader('X-PM-Tag', 'quick-test');
            $email->setMessage('<h1>Quick Test Email</h1><p>Wysłano: ' . date('Y-m-d H:i:s') . '</p>');

            if ($email->send()) {
                echo "✅ Email wysłany pomyślnie do: {$adresat}<br>";
            } else {
                echo "❌ Błąd wysyłania emaila:<br>";
                echo "<pre>" . htmlspecialchars($email->printDebugger()) . "</pre>";
            }
        } catch (\Exception $e) {
            echo "❌ Wyjątek: " . $e->getMessage() . "<br>";
        }
        
        echo "<br><a href='" . base_url('emailDebug/debugEmail/' . urlencode($adresat)) . "'>🔍 Pełny debug</a> | ";
        echo "<a href='" . base_url('emailDebug/postmarkStatus') . "'>📊 Status Postmark</a>";
    }
}
