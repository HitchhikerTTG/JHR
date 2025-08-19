<?php

namespace App\Controllers;

class Migrate extends \CodeIgniter\Controller
{
    public function index()
    {
        // Sprawdź połączenie z bazą danych
        try {
            $db = \Config\Database::connect();
            
            // Test połączenia
            $query = $db->query('SELECT 1 as test');
            $result = $query->getRow();
            
            if (!$result) {
                throw new \Exception('Nie można połączyć się z bazą danych');
            }
            
            echo "✅ Połączenie z bazą danych: OK<br>";
            echo "Database: " . $db->database . "<br>";
            echo "Host: " . $db->hostname . "<br><br>";
            
        } catch (\Exception $e) {
            echo "❌ Błąd połączenia z bazą danych: " . $e->getMessage() . "<br>";
            echo "Sprawdź konfigurację w Config/Database.php<br>";
            return;
        }

        // Uruchom migracje
        $migrate = \Config\Services::migrations();
        
        try {
            echo "🔄 Rozpoczynam migrację...<br>";
            
            // Sprawdź które migracje są dostępne
            $files = $migrate->findMigrations();
            echo "Znalezione pliki migracji:<br>";
            foreach ($files as $version => $file) {
                echo "- $version: $file<br>";
            }
            echo "<br>";
            
            // Uruchom migracje
            $migrate->latest();
            
            echo "✅ Migracja wykonana pomyślnie!<br>";
            
            // Sprawdź czy tabele zostały utworzone
            $tables = $db->listTables();
            echo "<br>Tabele w bazie danych:<br>";
            foreach ($tables as $table) {
                echo "- $table<br>";
            }
            
        } catch (\Exception $e) {
            echo "❌ Błąd migracji: " . $e->getMessage() . "<br>";
            echo "Szczegóły błędu:<br>";
            echo "<pre>" . $e->getTraceAsString() . "</pre>";
        }
    }
    
    public function reset()
    {
        $migrate = \Config\Services::migrations();
        
        try {
            echo "🔄 Resetowanie migracji...<br>";
            $migrate->regress(0);
            echo "✅ Migracje zresetowane!<br>";
        } catch (\Exception $e) {
            echo "❌ Błąd resetowania: " . $e->getMessage() . "<br>";
        }
    }
}
    }
}
