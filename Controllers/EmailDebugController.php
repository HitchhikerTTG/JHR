<?php

namespace App\Controllers;

use Config\Services;

class EmailDebugController extends BaseController
{
    public function debugEmail($adresat = 'wit@nirski.com', $hashOkna = '35e1ae5e03a8cd91ffaebae43b7b402638bfa992')
    {
        echo "<h1>🔍 Debug procesu wysyłania emaila</h1>";
        echo "<style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            .step { background: #f5f5f5; padding: 15px; margin: 10px 0; border-left: 4px solid #007bff; }
            .success { border-left-color: #28a745; background: #d4edda; }
            .error { border-left-color: #dc3545; background: #f8d7da; }
            .warning { border-left-color: #ffc107; background: #fff3cd; }
            pre { background: #f8f9fa; padding: 10px; border-radius: 4px; overflow-x: auto; }
            .code { font-family: monospace; background: #e9ecef; padding: 2px 4px; border-radius: 3px; }
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

        // KROK 2: Sprawdzenie konfiguracji Email
        echo "<div class='step'>";
        echo "<h2>⚙️ KROK 2: Konfiguracja obiektu Email</h2>";
        
        try {
            $emailConfig = new \Config\Email();
            echo "✅ Obiekt konfiguracji Email utworzony<br>";
            echo "📋 Protocol: " . ($emailConfig->protocol ?? 'BRAK') . "<br>";
            echo "📋 SMTP Host: " . ($emailConfig->SMTPHost ?? 'BRAK') . "<br>";
            echo "📋 SMTP Port: " . ($emailConfig->SMTPPort ?? 'BRAK') . "<br>";
            echo "📋 SMTP Crypto: " . ($emailConfig->SMTPCrypto ?? 'BRAK') . "<br>";
        } catch (\Exception $e) {
            echo "❌ Błąd konfiguracji Email: " . $e->getMessage() . "<br>";
        }
        echo "</div>";

        // KROK 3: Inicjalizacja usługi email
        echo "<div class='step'>";
        echo "<h2>🚀 KROK 3: Inicjalizacja usługi email</h2>";
        
        try {
            $email = Services::email();
            echo "✅ Usługa email zainicjalizowana<br>";
            
            // Sprawdź właściwości obiektu email
            $reflection = new \ReflectionClass($email);
            echo "📋 Klasa: " . $reflection->getName() . "<br>";
        } catch (\Exception $e) {
            echo "❌ Błąd inicjalizacji: " . $e->getMessage() . "<br>";
            return;
        }
        echo "</div>";

        // KROK 4: Ustawienie nadawcy
        echo "<div class='step'>";
        echo "<h2>👤 KROK 4: Ustawienie nadawcy</h2>";
        
        $fromEmail = $_ENV['POSTMARK_FROM_EMAIL'] ?? 'okno@johari.pl';
        $fromName = 'Okno Johari';
        
        try {
            $email->setFrom($fromEmail, $fromName);
            echo "✅ Nadawca ustawiony: {$fromName} &lt;{$fromEmail}&gt;<br>";
        } catch (\Exception $e) {
            echo "❌ Błąd ustawiania nadawcy: " . $e->getMessage() . "<br>";
        }
        echo "</div>";

        // KROK 5: Ustawienie odbiorcy
        echo "<div class='step'>";
        echo "<h2>📧 KROK 5: Ustawienie odbiorcy</h2>";
        
        try {
            $email->setTo($adresat);
            echo "✅ Odbiorca ustawiony: {$adresat}<br>";
        } catch (\Exception $e) {
            echo "❌ Błąd ustawiania odbiorcy: " . $e->getMessage() . "<br>";
        }
        echo "</div>";

        // KROK 6: Ustawienie tematu
        echo "<div class='step'>";
        echo "<h2>📝 KROK 6: Ustawienie tematu</h2>";
        
        $subject = 'DEBUG - Twoje Okno Johari - przydatne linki';
        try {
            $email->setSubject($subject);
            echo "✅ Temat ustawiony: {$subject}<br>";
        } catch (\Exception $e) {
            echo "❌ Błąd ustawiania tematu: " . $e->getMessage() . "<br>";
        }
        echo "</div>";

        // KROK 7: Ustawienie nagłówków
        echo "<div class='step'>";
        echo "<h2>🏷️ KROK 7: Ustawienie nagłówków</h2>";
        
        try {
            $email->setHeader('X-PM-Message-Stream', 'outbound');
            echo "✅ Nagłówek Postmark ustawiony: X-PM-Message-Stream: outbound<br>";
        } catch (\Exception $e) {
            echo "❌ Błąd ustawiania nagłówków: " . $e->getMessage() . "<br>";
        }
        echo "</div>";

        // KROK 8: Przygotowanie danych dla szablonu
        echo "<div class='step'>";
        echo "<h2>📄 KROK 8: Przygotowanie danych dla szablonu</h2>";
        
        $hashAutora = hash('ripemd160', $adresat);
        $data = [
            'imie' => 'Tester',
            'url_okna' => base_url('wyswietlOkno/' . $hashOkna . '/' . $hashAutora),
            'url_znajomi' => base_url('okno/' . $hashOkna),
            'url_usun' => '#',
        ];
        
        echo "✅ Dane przygotowane:<br>";
        echo "<pre>" . print_r($data, true) . "</pre>";
        echo "</div>";

        // KROK 9: Renderowanie szablonu
        echo "<div class='step'>";
        echo "<h2>🎨 KROK 9: Renderowanie szablonu email</h2>";
        
        try {
            $message = view('email/szablon', $data);
            echo "✅ Szablon wyrenderowany pomyślnie<br>";
            echo "📏 Długość wiadomości: " . strlen($message) . " znaków<br>";
            
            // Pokaż fragment wiadomości
            $preview = substr(strip_tags($message), 0, 200) . '...';
            echo "👀 Podgląd treści: <em>{$preview}</em><br>";
        } catch (\Exception $e) {
            echo "❌ Błąd renderowania szablonu: " . $e->getMessage() . "<br>";
            return;
        }
        echo "</div>";

        // KROK 10: Ustawienie wiadomości
        echo "<div class='step'>";
        echo "<h2>💌 KROK 10: Ustawienie treści wiadomości</h2>";
        
        try {
            $email->setMessage($message);
            echo "✅ Treść wiadomości ustawiona<br>";
        } catch (\Exception $e) {
            echo "❌ Błąd ustawiania treści: " . $e->getMessage() . "<br>";
        }
        echo "</div>";

        // KROK 11: Test połączenia SMTP (jeśli używane)
        echo "<div class='step'>";
        echo "<h2>🔌 KROK 11: Sprawdzenie połączenia SMTP</h2>";
        
        $smtpHost = env('email.SMTPHost');
        $smtpPort = env('email.SMTPPort');
        
        if ($smtpHost && $smtpPort) {
            $connection = @fsockopen($smtpHost, $smtpPort, $errno, $errstr, 5);
            if ($connection) {
                echo "✅ Połączenie z {$smtpHost}:{$smtpPort} - OK<br>";
                fclose($connection);
            } else {
                echo "❌ Nie można połączyć z {$smtpHost}:{$smtpPort} - {$errstr}<br>";
            }
        } else {
            echo "ℹ️ Brak konfiguracji SMTP lub używany jest inny protokół<br>";
        }
        echo "</div>";

        // KROK 12: Próba wysłania (z opcją test/rzeczywiste)
        echo "<div class='step'>";
        echo "<h2>📤 KROK 12: Wysyłanie emaila</h2>";
        
        $sendReal = $this->request->getGet('send') === 'true';
        
        if (!$sendReal) {
            echo "<div class='warning'>";
            echo "⚠️ TRYB TESTOWY - email NIE zostanie wysłany<br>";
            echo "🔗 <a href='" . current_url() . "?send=true'>Kliknij tutaj aby RZECZYWIŚCIE wysłać email</a><br>";
            echo "</div>";
        } else {
            try {
                log_message('info', 'DEBUG EMAIL - próba wysłania do: ' . $adresat);
                
                if ($email->send()) {
                    echo "<div class='success'>";
                    echo "✅ Email został wysłany pomyślnie!<br>";
                    echo "📧 Adresat: {$adresat}<br>";
                    log_message('info', 'DEBUG EMAIL - sukces wysyłania do: ' . $adresat);
                    echo "</div>";
                } else {
                    echo "<div class='error'>";
                    echo "❌ Błąd wysyłania emaila<br>";
                    echo "🔍 Debug info:<br>";
                    echo "<pre>" . $email->printDebugger() . "</pre>";
                    log_message('error', 'DEBUG EMAIL - błąd wysyłania do: ' . $adresat);
                    log_message('error', 'DEBUG EMAIL - debugger: ' . $email->printDebugger());
                    echo "</div>";
                }
            } catch (\Exception $e) {
                echo "<div class='error'>";
                echo "❌ Wyjątek podczas wysyłania: " . $e->getMessage() . "<br>";
                echo "📋 Ślad: <pre>" . $e->getTraceAsString() . "</pre>";
                log_message('error', 'DEBUG EMAIL - wyjątek: ' . $e->getMessage());
                echo "</div>";
            }
        }
        echo "</div>";

        // KROK 13: Sprawdzenie logów
        echo "<div class='step'>";
        echo "<h2>📋 KROK 13: Ostatnie wpisy w logach</h2>";
        
        $logPath = WRITEPATH . 'logs/log-' . date('Y-m-d') . '.php';
        if (file_exists($logPath)) {
            $logContent = file_get_contents($logPath);
            $lines = explode("\n", $logContent);
            $emailLines = array_filter($lines, function($line) {
                return strpos($line, 'EMAIL') !== false || strpos($line, 'email') !== false;
            });
            
            if (!empty($emailLines)) {
                echo "📄 Ostatnie wpisy związane z emailem:<br>";
                echo "<pre>" . implode("\n", array_slice($emailLines, -10)) . "</pre>";
            } else {
                echo "ℹ️ Brak wpisów związanych z emailem w dzisiejszych logach<br>";
            }
        } else {
            echo "⚠️ Plik logów nie istnieje: {$logPath}<br>";
        }
        echo "</div>";

        echo "<div class='step success'>";
        echo "<h2>🎯 PODSUMOWANIE</h2>";
        echo "Proces debugowania zakończony. Sprawdź powyższe kroki aby zidentyfikować ewentualne problemy.<br>";
        echo "🔗 <a href='" . base_url('emailDebug/debugEmail/' . urlencode($adresat) . '/' . $hashOkna) . "'>Uruchom ponownie</a><br>";
        echo "</div>";
    }

    public function quickTest($adresat = 'test@example.com')
    {
        echo "<h1>⚡ Szybki test wysyłania emaila</h1>";
        
        try {
            $email = Services::email();
            $email->setFrom($_ENV['POSTMARK_FROM_EMAIL'] ?? 'okno@johari.pl', 'Test Johari');
            $email->setTo($adresat);
            $email->setSubject('Test email z Johari.pl');
            $email->setHeader('X-PM-Message-Stream', 'outbound');
            $email->setMessage('<h1>Test Email</h1><p>To jest testowy email z systemu Johari.pl</p><p>Czas: ' . date('Y-m-d H:i:s') . '</p>');

            if ($email->send()) {
                echo "✅ Email wysłany pomyślnie do: {$adresat}<br>";
            } else {
                echo "❌ Błąd wysyłania emaila:<br>";
                echo "<pre>" . $email->printDebugger() . "</pre>";
            }
        } catch (\Exception $e) {
            echo "❌ Wyjątek: " . $e->getMessage() . "<br>";
        }
        
        echo "<br><a href='" . base_url('emailDebug/debugEmail/' . urlencode($adresat)) . "'>Pełny debug</a>";
    }
}
