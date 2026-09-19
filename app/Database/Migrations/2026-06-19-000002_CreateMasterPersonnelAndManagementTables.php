<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMasterPersonnelAndManagementTables extends Migration
{
    public function up()
    {
        // 1. mst_personil
        $this->forge->addField([
            'id'            => ['type' => 'CHAR', 'constraint' => 36],
            'nama'          => ['type' => 'VARCHAR', 'constraint' => 150],
            'nik'           => ['type' => 'VARCHAR', 'constraint' => 16, 'null' => true],
            'no_hp'         => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'email'         => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'jenis_kelamin' => ['type' => 'ENUM', 'constraint' => ['L', 'P'], 'default' => 'L', 'null' => true],
            'alamat'        => ['type' => 'TEXT', 'null' => true],
            'foto'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'tipe_default'  => ['type' => 'SET', 'constraint' => ['jamaah', 'pengurus', 'panitia', 'ustadz', 'petugas'], 'default' => 'jamaah', 'null' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('nama');
        $this->forge->addKey('no_hp');
        $this->forge->createTable('mst_personil', true);

        // 2. mst_rekening
        $this->forge->addField([
            'id'             => ['type' => 'CHAR', 'constraint' => 36],
            'nama_bank'      => ['type' => 'VARCHAR', 'constraint' => 100],
            'nomor_rekening' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'atas_nama'      => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'jenis'          => ['type' => 'ENUM', 'constraint' => ['transfer', 'qris'], 'default' => 'transfer'],
            'logo'           => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'status'         => ['type' => 'ENUM', 'constraint' => ['active', 'inactive'], 'default' => 'active', 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('mst_rekening', true);

        // 3. mst_periode_pengurus
        $this->forge->addField([
            'id'           => ['type' => 'CHAR', 'constraint' => 36],
            'nama_periode' => ['type' => 'VARCHAR', 'constraint' => 100],
            'tahun_mulai'  => ['type' => 'INT', 'constraint' => 4],
            'tahun_selesai'=> ['type' => 'INT', 'constraint' => 4],
            'is_active'    => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('is_active');
        $this->forge->createTable('mst_periode_pengurus', true);

        // 4. trn_jabatan_periode
        $this->forge->addField([
            'id'           => ['type' => 'CHAR', 'constraint' => 36],
            'periode_id'   => ['type' => 'CHAR', 'constraint' => 36],
            'nama_jabatan' => ['type' => 'VARCHAR', 'constraint' => 100],
            'parent_id'    => ['type' => 'CHAR', 'constraint' => 36, 'null' => true],
            'tugas'        => ['type' => 'TEXT', 'null' => true],
            'urutan'       => ['type' => 'INT', 'constraint' => 11, 'default' => 0, 'null' => true],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('periode_id');
        $this->forge->addKey('parent_id');
        $this->forge->addForeignKey('periode_id', 'mst_periode_pengurus', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('trn_jabatan_periode', true);

        // 5. trn_pengurus
        $this->forge->addField([
            'id'                 => ['type' => 'CHAR', 'constraint' => 36],
            'jabatan_periode_id' => ['type' => 'CHAR', 'constraint' => 36],
            'personil_id'        => ['type' => 'CHAR', 'constraint' => 36],
            'created_at'         => ['type' => 'DATETIME', 'null' => true],
            'updated_at'         => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'         => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('jabatan_periode_id');
        $this->forge->addKey('personil_id');
        $this->forge->addForeignKey('jabatan_periode_id', 'trn_jabatan_periode', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('personil_id', 'mst_personil', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('trn_pengurus', true);
    }

    public function down()
    {
        $this->forge->dropTable('trn_pengurus', true);
        $this->forge->dropTable('trn_jabatan_periode', true);
        $this->forge->dropTable('mst_periode_pengurus', true);
        $this->forge->dropTable('mst_rekening', true);
        $this->forge->dropTable('mst_personil', true);
    }
}
