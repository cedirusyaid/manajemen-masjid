<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKegiatanAndPanitiaTables extends Migration
{
    public function up()
    {
        // 1. mst_kegiatan
        $this->forge->addField([
            'id'              => ['type' => 'CHAR', 'constraint' => 36],
            'nama_kegiatan'   => ['type' => 'VARCHAR', 'constraint' => 255],
            'tanggal_mulai'   => ['type' => 'DATE'],
            'tanggal_selesai' => ['type' => 'DATE', 'null' => true],
            'deskripsi'       => ['type' => 'TEXT', 'null' => true],
            'status'          => ['type' => 'ENUM', 'constraint' => ['rencana', 'berjalan', 'selesai', 'dibatalkan'], 'default' => 'rencana', 'null' => true],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('tanggal_mulai');
        $this->forge->addKey('status');
        $this->forge->createTable('mst_kegiatan', true);

        // 2. trn_jabatan_kegiatan
        $this->forge->addField([
            'id'           => ['type' => 'CHAR', 'constraint' => 36],
            'kegiatan_id'  => ['type' => 'CHAR', 'constraint' => 36],
            'nama_jabatan' => ['type' => 'VARCHAR', 'constraint' => 100],
            'parent_id'    => ['type' => 'CHAR', 'constraint' => 36, 'null' => true],
            'tugas'        => ['type' => 'TEXT', 'null' => true],
            'urutan'       => ['type' => 'INT', 'constraint' => 11, 'default' => 0, 'null' => true],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('kegiatan_id');
        $this->forge->addKey('parent_id');
        $this->forge->addForeignKey('kegiatan_id', 'mst_kegiatan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('trn_jabatan_kegiatan', true);

        // 3. trn_panitia
        $this->forge->addField([
            'id'                  => ['type' => 'CHAR', 'constraint' => 36],
            'jabatan_kegiatan_id' => ['type' => 'CHAR', 'constraint' => 36],
            'personil_id'         => ['type' => 'CHAR', 'constraint' => 36],
            'created_at'          => ['type' => 'DATETIME', 'null' => true],
            'updated_at'          => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'          => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('jabatan_kegiatan_id');
        $this->forge->addKey('personil_id');
        $this->forge->addForeignKey('jabatan_kegiatan_id', 'trn_jabatan_kegiatan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('personil_id', 'mst_personil', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('trn_panitia', true);

        // 4. mst_kelompok_kegiatan
        $this->forge->addField([
            'id'            => ['type' => 'CHAR', 'constraint' => 36],
            'kegiatan_id'   => ['type' => 'CHAR', 'constraint' => 36],
            'nama_kelompok' => ['type' => 'VARCHAR', 'constraint' => 255],
            'keterangan'    => ['type' => 'TEXT', 'null' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('kegiatan_id');
        $this->forge->addForeignKey('kegiatan_id', 'mst_kegiatan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('mst_kelompok_kegiatan', true);

        // 5. trn_anggota_kelompok
        $this->forge->addField([
            'id'          => ['type' => 'CHAR', 'constraint' => 36],
            'kelompok_id' => ['type' => 'CHAR', 'constraint' => 36],
            'personil_id' => ['type' => 'CHAR', 'constraint' => 36],
            'peran'       => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('kelompok_id');
        $this->forge->addKey('personil_id');
        $this->forge->addForeignKey('kelompok_id', 'mst_kelompok_kegiatan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('personil_id', 'mst_personil', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('trn_anggota_kelompok', true);
    }

    public function down()
    {
        $this->forge->dropTable('trn_anggota_kelompok', true);
        $this->forge->dropTable('mst_kelompok_kegiatan', true);
        $this->forge->dropTable('trn_panitia', true);
        $this->forge->dropTable('trn_jabatan_kegiatan', true);
        $this->forge->dropTable('mst_kegiatan', true);
    }
}
