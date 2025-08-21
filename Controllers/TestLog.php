
<?php

namespace App\Controllers;

class TestLog extends BaseController
{
    public function testLogs()
    {
        echo "<h1>🧪 Test systemu logowania</h1>";
        
        // Test 1: Podstawowy log_message
        echo "<h2>Test 1: log_message()</h2>";
        $testMessage = 'TEST LOG MESSAGE - ' . date('Y-m-d H:i:s');
        $result = log_message('debug', $testMessage);
        echo "Rezultat log_message(): " . ($result ? 'TRUE' : 'FALSE') . "<br>";
        
        // Test 2: Bezpośredni zapis do pliku
        echo "<h2>Test 2: Bezpośredni zapis do pliku</h2>";
        $logFile = WRITEPATH . 'logs/manual-test-' . date('Y-m-d') . '.log';
        $logLine = date('Y-m-d H:i:s') . " MANUAL TEST LOG\n";
        $written = file_put_contents($logFile, $logLine, FILE_APPEND | LOCK_EX);
        echo "Bezpośredni zapis: " . ($written ? "OK ($written bajtów)" : 'FAILED') . "<br>";
        
        // Test 3: Sprawdź czy pliki zostały utworzone
        echo "<h2>Test 3: Sprawdzenie plików</h2>";
        $todayLog = WRITEPATH . 'logs/log-' . date('Y-m-d') . '.php';
        echo "Dzisiejszy log CI: " . (file_exists($todayLog) ? 'ISTNIEJE' : 'NIE ISTNIEJE') . "<br>";
        echo "Manual log: " . (file_exists($logFile) ? 'ISTNIEJE' : 'NIE ISTNIEJE') . "<br>";
        
        if (file_exists($logFile)) {
            echo "Zawartość manual log:<br>";
            echo "<pre>" . htmlspecialchars(file_get_contents($logFile)) . "</pre>";
        }
        
        if (file_exists($todayLog)) {
            $content = file_get_contents($todayLog);
            if (strpos($content, $testMessage) !== false) {
                echo "✅ Test message znaleziony w logu CI!<br>";
            } else {
                echo "❌ Test message NIE znaleziony w logu CI<br>";
            }
        }
        
        // Test 4: Sprawdź konfigurację Logger
        echo "<h2>Test 4: Konfiguracja Logger</h2>";
        $loggerConfig = config('Logger');
        echo "Logger threshold: " . $loggerConfig->threshold . "<br>";
        echo "Logger handlers: " . count($loggerConfig->handlers) . "<br>";
        
        // Test 5: Email debug
        echo "<h2>Test 5: Email debug logs</h2>";
        log_message('info', 'EMAIL DEBUG TEST - start');
        log_message('debug', 'EMAIL DEBUG TEST - debug level');
        log_message('error', 'EMAIL DEBUG TEST - error level');
        
        echo "Wysłano 3 test emailowe logi (info, debug, error)<br>";
        
        // Sprawdź czy pojawiły się
        if (file_exists($todayLog)) {
            $content = file_get_contents($todayLog);
            $emailLogs = substr_count($content, 'EMAIL DEBUG TEST');
            echo "Znaleziono $emailLogs email test logów<br>";
        }
        
        echo "<br><a href='" . base_url('testLog/showLogs') . "'>📋 Pokaż zawartość logów</a>";
    }
    
    public function showLogs()
    {
        echo "<h1>📋 Zawartość logów</h1>";
        
        $logDir = WRITEPATH . 'logs/';
        $files = glob($logDir . '*');
        
        if (empty($files)) {
            echo "❌ Brak plików w katalogu logów<br>";
            return;
        }
        
        foreach ($files as $file) {
            if (is_file($file)) {
                echo "<h3>" . basename($file) . " (" . filesize($file) . " B)</h3>";
                $content = file_get_contents($file);
                if (strlen($content) > 5000) {
                    $content = "...\n" . substr($content, -5000);
                }
                echo "<pre style='max-height: 300px; overflow-y: auto; background: #f5f5f5; padding: 10px;'>" . htmlspecialchars($content) . "</pre><hr>";
            }
        }
    }
    
    public function clearLogs()
    {
        $logDir = WRITEPATH . 'logs/';
        $files = glob($logDir . 'log-*.php');
        $files = array_merge($files, glob($logDir . 'manual-*.log'));
        
        $cleared = 0;
        foreach ($files as $file) {
            if (unlink($file)) {
                $cleared++;
            }
        }
        
        echo "🗑️ Usunięto $cleared plików logów<br>";
        echo "<a href='" . base_url('testLog/testLogs') . "'>🔄 Uruchom test ponownie</a>";
    }
}
