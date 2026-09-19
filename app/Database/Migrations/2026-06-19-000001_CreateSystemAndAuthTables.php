<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSystemAndAuthTables extends Migration
{
    public function up()
    {
        // 1. sys_roles
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 50],
            'description' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('sys_roles', true);

        // 2. sys_users
        $this->forge->addField([
            'id'          => ['type' => 'CHAR', 'constraint' => 36],
            'username'    => ['type' => 'VARCHAR', 'constraint' => 100],
            'password'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'email'       => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'google_id'   => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'avatar'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'personil_id' => ['type' => 'CHAR', 'constraint' => 36, 'null' => true],
            'role_id'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'default' => 5],
            'status'      => ['type' => 'ENUM', 'constraint' => ['active', 'inactive', 'pending'], 'default' => 'active'],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('username');
        $this->forge->addKey('email');
        $this->forge->addKey('google_id');
        $this->forge->addKey('role_id');
        $this->forge->createTable('sys_users', true);

        // 3. sys_settings
        $this->forge->addField([
            'key'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'value'      => ['type' => 'TEXT', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('key', true);
        $this->forge->createTable('sys_settings', true);

        // 4. log_activities
        $this->forge->addField([
            'id'         => ['type' => 'BIGINT', 'constraint' => 20, 'unsigned' => true, 'auto_increment' => true],
            'user_id'    => ['type' => 'CHAR', 'constraint' => 36, 'null' => true],
            'action'     => ['type' => 'VARCHAR', 'constraint' => 50],
            'table_name' => ['type' => 'VARCHAR', 'constraint' => 100],
            'record_id'  => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'old_values' => ['type' => 'LONGTEXT', 'null' => true],
            'new_values' => ['type' => 'LONGTEXT', 'null' => true],
            'ip_address' => ['type' => 'VARCHAR', 'constraint' => 45, 'null' => true],
            'user_agent' => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('user_id');
        $this->forge->addKey('action');
        $this->forge->createTable('log_activities', true);

        // 5. log_telegram
        $this->forge->addField([
            'id'           => ['type' => 'BIGINT', 'constraint' => 20, 'unsigned' => true, 'auto_increment' => true],
            'message_type' => ['type' => 'VARCHAR', 'constraint' => 50],
            'payload'      => ['type' => 'TEXT', 'null' => true],
            'status'       => ['type' => 'ENUM', 'constraint' => ['sent', 'failed'], 'default' => 'sent'],
            'response'     => ['type' => 'TEXT', 'null' => true],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('log_telegram', true);
    }

    public function down()
    {
        $this->forge->dropTable('log_telegram', true);
        $this->forge->dropTable('log_activities', true);
        $this->forge->dropTable('sys_settings', true);
        $this->forge->dropTable('sys_users', true);
        $this->forge->dropTable('sys_roles', true);
    }
}
