<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLayananJadwalSholatAyatAndUserKegiatanTables extends Migration
{
    public function up()
    {
        // 1. mst_layanan
        $this->forge->addField([
            'id'               => ['type' => 'CHAR', 'constraint' => 36],
            'nama_layanan'     => ['type' => 'VARCHAR', 'constraint' => 150],
            'slug'             => ['type' => 'VARCHAR', 'constraint' => 150],
            'deskripsi'        => ['type' => 'TEXT', 'null' => true],
            'icon'             => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'warna_tema'       => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'primary', 'null' => true],
            'kontak_wa'        => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'pesan_wa_default' => ['type' => 'TEXT', 'null' => true],
            'pj_personil_id'   => ['type' => 'CHAR', 'constraint' => 36, 'null' => true],
            'urutan'           => ['type' => 'INT', 'constraint' => 11, 'default' => 0, 'null' => true],
            'status'           => ['type' => 'ENUM', 'constraint' => ['aktif', 'nonaktif'], 'default' => 'aktif'],
            'created_at'       => ['type' => 'DATETIME', 'null' => true],
            'updated_at'       => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'       => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('slug');
        $this->forge->addKey('status');
        $this->forge->addKey('pj_personil_id');
        $this->forge->addForeignKey('pj_personil_id', 'mst_personil', 'id', 'SET NULL', 'SET NULL');
        $this->forge->createTable('mst_layanan', true);

        // 2. trn_pelayanan
        $this->forge->addField([
            'id'                  => ['type' => 'CHAR', 'constraint' => 36],
            'layanan_id'          => ['type' => 'CHAR', 'constraint' => 36],
            'user_id'             => ['type' => 'CHAR', 'constraint' => 36],
            'tanggal'             => ['type' => 'DATE'],
            'nama_pemohon'        => ['type' => 'VARCHAR', 'constraint' => 150],
            'nik_pemohon'         => ['type' => 'VARCHAR', 'constraint' => 16, 'null' => true],
            'no_hp_pemohon'       => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'alamat_pemohon'      => ['type' => 'TEXT', 'null' => true],
            'rincian_kebutuhan'   => ['type' => 'TEXT'],
            'tindakan_petugas'    => ['type' => 'TEXT', 'null' => true],
            'petugas_personil_id' => ['type' => 'CHAR', 'constraint' => 36, 'null' => true],
            'biaya_infaq'         => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => '0.00'],
            'status_layanan'      => ['type' => 'ENUM', 'constraint' => ['diajukan', 'diproses', 'selesai', 'ditolak'], 'default' => 'diajukan'],
            'lampiran_dokumen'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at'          => ['type' => 'DATETIME', 'null' => true],
            'updated_at'          => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'          => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('layanan_id');
        $this->forge->addKey('user_id');
        $this->forge->addKey('tanggal');
        $this->forge->addKey('status_layanan');
        $this->forge->addKey('petugas_personil_id');
        $this->forge->addForeignKey('layanan_id', 'mst_layanan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'sys_users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('petugas_personil_id', 'mst_personil', 'id', 'SET NULL', 'SET NULL');
        $this->forge->createTable('trn_pelayanan', true);

        // 3. mst_jadwal_sholat
        $this->forge->addField([
            'id'         => ['type' => 'CHAR', 'constraint' => 36],
            'bulan'      => ['type' => 'INT', 'constraint' => 2],
            'tanggal'    => ['type' => 'INT', 'constraint' => 2],
            'imsak'      => ['type' => 'VARCHAR', 'constraint' => 5],
            'subuh'      => ['type' => 'VARCHAR', 'constraint' => 5],
            'terbit'     => ['type' => 'VARCHAR', 'constraint' => 5],
            'dhuha'      => ['type' => 'VARCHAR', 'constraint' => 5],
            'dzuhur'     => ['type' => 'VARCHAR', 'constraint' => 5],
            'ashar'      => ['type' => 'VARCHAR', 'constraint' => 5],
            'maghrib'    => ['type' => 'VARCHAR', 'constraint' => 5],
            'isya'       => ['type' => 'VARCHAR', 'constraint' => 5],
            'keterangan' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('bulan');
        $this->forge->addKey('tanggal');
        $this->forge->createTable('mst_jadwal_sholat', true);

        // 4. mst_ayat_pilihan
        $this->forge->addField([
            'id'         => ['type' => 'CHAR', 'constraint' => 36],
            'surah'      => ['type' => 'VARCHAR', 'constraint' => 100],
            'nomor_ayat' => ['type' => 'VARCHAR', 'constraint' => 50],
            'teks_arab'  => ['type' => 'TEXT'],
            'terjemahan' => ['type' => 'TEXT'],
            'tema'       => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'is_active'  => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'urutan'     => ['type' => 'INT', 'constraint' => 11, 'default' => 0, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('is_active');
        $this->forge->addKey('urutan');
        $this->forge->createTable('mst_ayat_pilihan', true);

        // 5. trn_user_kegiatan
        $this->forge->addField([
            'id'          => ['type' => 'CHAR', 'constraint' => 36],
            'user_id'     => ['type' => 'CHAR', 'constraint' => 36],
            'kegiatan_id' => ['type' => 'CHAR', 'constraint' => 36],
            'peran'       => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'bendahara'],
            'status'      => ['type' => 'ENUM', 'constraint' => ['active', 'inactive'], 'default' => 'active'],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('user_id');
        $this->forge->addKey('kegiatan_id');
        $this->forge->addKey('status');
        $this->forge->addForeignKey('user_id', 'sys_users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('kegiatan_id', 'mst_kegiatan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('trn_user_kegiatan', true);
    }

    public function down()
    {
        $this->forge->dropTable('trn_user_kegiatan', true);
        $this->forge->dropTable('mst_ayat_pilihan', true);
        $this->forge->dropTable('mst_jadwal_sholat', true);
        $this->forge->dropTable('trn_pelayanan', true);
        $this->forge->dropTable('mst_layanan', true);
    }
}
