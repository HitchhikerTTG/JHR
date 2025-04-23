<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTimestamps extends Migration
{
    public function up()
    {
        // Dodanie kolumn timestamps do tabeli okna
        $this->forge->addColumn('okna', [
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ]
        ]);

        // Dodanie kolumny timestamp do tabeli przypisane_cechy
        $this->forge->addColumn('przypisane_cechy', [
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ]
        ]);
    }

    public function down()
    {
        // Usunięcie kolumn w przypadku cofnięcia migracji
        $this->forge->dropColumn('okna', 'created_at');
        $this->forge->dropColumn('okna', 'updated_at');
        $this->forge->dropColumn('przypisane_cechy', 'created_at');
    }
}
