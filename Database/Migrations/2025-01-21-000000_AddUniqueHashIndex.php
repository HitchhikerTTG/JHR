
<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUniqueHashIndex extends Migration
{
    public function up()
    {
        // Dodaj unikalny indeks na kolumnę hash w tabeli okna
        $this->forge->addKey('hash', false, true); // trzeci parametr = unique
        $this->forge->processIndexes('okna');
        
        // Alternatywnie, jeśli powyższe nie zadziała:
        $this->db->query('CREATE UNIQUE INDEX IF NOT EXISTS idx_okna_hash_unique ON okna (hash)');
    }

    public function down()
    {
        // Usuń unikalny indeks
        $this->forge->dropKey('okna', 'idx_okna_hash_unique');
    }
}
