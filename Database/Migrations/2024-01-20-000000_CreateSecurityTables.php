
<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSecurityTables extends Migration
{
    public function up()
    {
        // Tabela rate_limits
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'ip_address' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
            ],
            'action_type' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'attempt_count' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'last_attempt' => [
                'type' => 'DATETIME',
            ],
            'blocked_until' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['ip_address', 'action_type']);
        $this->forge->createTable('rate_limits');

        // Tabela security_logs
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'ip_address' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
            ],
            'user_agent' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'action' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'email_hash' => [
                'type' => 'VARCHAR',
                'constraint' => 40,
                'null' => true,
            ],
            'suspicious_score' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'blocked' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('ip_address');
        $this->forge->addKey('email_hash');
        $this->forge->addKey('created_at');
        $this->forge->createTable('security_logs');
    }

    public function down()
    {
        $this->forge->dropTable('rate_limits');
        $this->forge->dropTable('security_logs');
    }
}
