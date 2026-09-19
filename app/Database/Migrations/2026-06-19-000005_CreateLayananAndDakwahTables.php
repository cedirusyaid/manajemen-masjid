<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLayananAndDakwahTables extends Migration
{
    public function up()
    {
        // 1. mst_agenda
        $this->forge->addField([
            'id'            => ['type' => 'CHAR', 'constraint' => 36],
            'kegiatan_id'   => ['type' => 'CHAR', 'constraint' => 36, 'null' => true],
            'judul'         => ['type' => 'VARCHAR', 'constraint' => 255],
            'deskripsi'     => ['type' => 'TEXT', 'null' => true],
            'narasumber_id' => ['type' => 'CHAR', 'constraint' => 36, 'null' => true],
            'narasumber'    => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'tanggal'       => ['type' => 'DATE'],
            'waktu'         => ['type' => 'TIME'],
            'lokasi'        => ['type' => 'VARCHAR', 'constraint' => 255, 'default' => 'Masjid'],
            'banner'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('tanggal');
        $this->forge->addKey('kegiatan_id');
        $this->forge->addKey('narasumber_id');
        $this->forge->addForeignKey('kegiatan_id', 'mst_kegiatan', 'id', 'SET NULL', 'SET NULL');
        $this->forge->addForeignKey('narasumber_id', 'mst_personil', 'id', 'SET NULL', 'SET NULL');
        $this->forge->createTable('mst_agenda', true);

        // 2. mst_berita
        $this->forge->addField([
            'id'         => ['type' => 'CHAR', 'constraint' => 36],
            'judul'      => ['type' => 'VARCHAR', 'constraint' => 255],
            'slug'       => ['type' => 'VARCHAR', 'constraint' => 255],
            'isi'        => ['type' => 'LONGTEXT'],
            'gambar'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'penulis_id' => ['type' => 'CHAR', 'constraint' => 36, 'null' => true],
            'status'     => ['type' => 'ENUM', 'constraint' => ['draft', 'published'], 'default' => 'draft', 'null' => true],
            'views'      => ['type' => 'INT', 'constraint' => 11, 'default' => 0, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('slug');
        $this->forge->addKey('status');
        $this->forge->addKey('penulis_id');
        $this->forge->addForeignKey('penulis_id', 'sys_users', 'id', 'SET NULL', 'SET NULL');
        $this->forge->createTable('mst_berita', true);

        // 3. mst_imam_khatib
        $this->forge->addField([
            'id'          => ['type' => 'CHAR', 'constraint' => 36],
            'personil_id' => ['type' => 'CHAR', 'constraint' => 36, 'null' => true],
            'nama'        => ['type' => 'VARCHAR', 'constraint' => 150],
            'gelar'       => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'peran'       => ['type' => 'ENUM', 'constraint' => ['khatib', 'imam', 'muadzin', 'semua']],
            'no_hp'       => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'foto'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'status'      => ['type' => 'ENUM', 'constraint' => ['active', 'inactive'], 'default' => 'active', 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('personil_id');
        $this->forge->addKey('peran');
        $this->forge->addForeignKey('personil_id', 'mst_personil', 'id', 'SET NULL', 'SET NULL');
        $this->forge->createTable('mst_imam_khatib', true);

        // 4. trn_jadwal_jumat
        $this->forge->addField([
            'id'            => ['type' => 'CHAR', 'constraint' => 36],
            'tanggal'       => ['type' => 'DATE'],
            'khatib_id'     => ['type' => 'CHAR', 'constraint' => 36],
            'imam_id'       => ['type' => 'CHAR', 'constraint' => 36],
            'muadzin_id'    => ['type' => 'CHAR', 'constraint' => 36],
            'judul_khotbah' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'keterangan'    => ['type' => 'TEXT', 'null' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('tanggal');
        $this->forge->addKey('khatib_id');
        $this->forge->addKey('imam_id');
        $this->forge->addKey('muadzin_id');
        $this->forge->addForeignKey('khatib_id', 'mst_imam_khatib', 'id');
        $this->forge->addForeignKey('imam_id', 'mst_imam_khatib', 'id');
        $this->forge->addForeignKey('muadzin_id', 'mst_imam_khatib', 'id');
        $this->forge->createTable('trn_jadwal_jumat', true);

        // 5. trn_pendaftaran_tpa
        $this->forge->addField([
            'id'                 => ['type' => 'CHAR', 'constraint' => 36],
            'nama_santri'        => ['type' => 'VARCHAR', 'constraint' => 150],
            'tempat_lahir'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'tanggal_lahir'      => ['type' => 'DATE'],
            'nama_wali'          => ['type' => 'VARCHAR', 'constraint' => 150],
            'no_hp_wali'         => ['type' => 'VARCHAR', 'constraint' => 20],
            'alamat'             => ['type' => 'TEXT'],
            'status_pendaftaran' => ['type' => 'ENUM', 'constraint' => ['pending', 'diterima', 'ditolak'], 'default' => 'pending', 'null' => true],
            'created_at'         => ['type' => 'DATETIME', 'null' => true],
            'updated_at'         => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'         => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('status_pendaftaran');
        $this->forge->createTable('trn_pendaftaran_tpa', true);

        // 6. trn_pengajuan_acara
        $this->forge->addField([
            'id'                 => ['type' => 'CHAR', 'constraint' => 36],
            'nama_pemohon'       => ['type' => 'VARCHAR', 'constraint' => 150],
            'instansi'           => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'nama_acara'         => ['type' => 'VARCHAR', 'constraint' => 255],
            'tanggal_acara'      => ['type' => 'DATE'],
            'waktu_mulai'        => ['type' => 'TIME'],
            'waktu_selesai'      => ['type' => 'TIME'],
            'no_hp'              => ['type' => 'VARCHAR', 'constraint' => 20],
            'surat_permohonan'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'status_persetujuan' => ['type' => 'ENUM', 'constraint' => ['pending', 'disetujui', 'ditolak'], 'default' => 'pending', 'null' => true],
            'catatan_admin'      => ['type' => 'TEXT', 'null' => true],
            'created_at'         => ['type' => 'DATETIME', 'null' => true],
            'updated_at'         => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'         => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('tanggal_acara');
        $this->forge->addKey('status_persetujuan');
        $this->forge->createTable('trn_pengajuan_acara', true);
    }

    public function down()
    {
        $this->forge->dropTable('trn_pengajuan_acara', true);
        $this->forge->dropTable('trn_pendaftaran_tpa', true);
        $this->forge->dropTable('trn_jadwal_jumat', true);
        $this->forge->dropTable('mst_imam_khatib', true);
        $this->forge->dropTable('mst_berita', true);
        $this->forge->dropTable('mst_agenda', true);
    }
}
