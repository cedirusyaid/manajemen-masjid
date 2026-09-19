<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKeuanganAndMaterialTables extends Migration
{
    public function up()
    {
        // 1. trn_keuangan
        $this->forge->addField([
            'id'                => ['type' => 'CHAR', 'constraint' => 36],
            'kegiatan_id'       => ['type' => 'CHAR', 'constraint' => 36, 'null' => true],
            'rekening_id'       => ['type' => 'CHAR', 'constraint' => 36, 'null' => true],
            'tanggal'           => ['type' => 'DATE'],
            'kategori'          => ['type' => 'ENUM', 'constraint' => ['operasional', 'pembangunan', 'zis', 'sosial']],
            'tipe'              => ['type' => 'ENUM', 'constraint' => ['masuk', 'keluar']],
            'nominal'           => ['type' => 'DECIMAL', 'constraint' => '15,2'],
            'nama_donatur'      => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'metode_pembayaran' => ['type' => 'ENUM', 'constraint' => ['tunai', 'transfer_bank', 'qris'], 'default' => 'transfer_bank', 'null' => true],
            'keterangan'        => ['type' => 'VARCHAR', 'constraint' => 255],
            'penanggung_jawab'  => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'bukti_transaksi'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at'        => ['type' => 'DATETIME', 'null' => true],
            'updated_at'        => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'        => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('tanggal');
        $this->forge->addKey('tipe');
        $this->forge->addKey('kegiatan_id');
        $this->forge->addKey('rekening_id');
        $this->forge->addForeignKey('kegiatan_id', 'mst_kegiatan', 'id', 'SET NULL', 'SET NULL');
        $this->forge->addForeignKey('rekening_id', 'mst_rekening', 'id', 'SET NULL', 'SET NULL');
        $this->forge->createTable('trn_keuangan', true);

        // 2. trn_bantuan_material
        $this->forge->addField([
            'id'                   => ['type' => 'CHAR', 'constraint' => 36],
            'kegiatan_id'          => ['type' => 'CHAR', 'constraint' => 36],
            'tanggal'              => ['type' => 'DATE'],
            'nama_donatur'         => ['type' => 'VARCHAR', 'constraint' => 150, 'default' => 'Hamba Allah'],
            'uraian_material'      => ['type' => 'VARCHAR', 'constraint' => 255],
            'kategori_material'    => ['type' => 'ENUM', 'constraint' => ['material_konstruksi', 'inventaris_elektronik', 'perlengkapan_ibadah', 'lainnya'], 'default' => 'material_konstruksi'],
            'volume'               => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'satuan'               => ['type' => 'VARCHAR', 'constraint' => 50],
            'harga_satuan'         => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => '0.00'],
            'total_nilai'          => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => '0.00'],
            'penerima_personil_id' => ['type' => 'CHAR', 'constraint' => 36, 'null' => true],
            'keterangan'           => ['type' => 'TEXT', 'null' => true],
            'bukti_foto'           => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at'           => ['type' => 'DATETIME', 'null' => true],
            'updated_at'           => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'           => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('kegiatan_id');
        $this->forge->addKey('tanggal');
        $this->forge->addForeignKey('kegiatan_id', 'mst_kegiatan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('trn_bantuan_material', true);

        // 3. trn_zis
        $this->forge->addField([
            'id'                => ['type' => 'CHAR', 'constraint' => 36],
            'nama_donatur'      => ['type' => 'VARCHAR', 'constraint' => 150, 'default' => 'Hamba Allah', 'null' => true],
            'nominal'           => ['type' => 'DECIMAL', 'constraint' => '15,2'],
            'jenis'             => ['type' => 'ENUM', 'constraint' => ['zakat_fitrah', 'zakat_maal', 'infaq', 'sedekah', 'wakaf']],
            'metode_pembayaran' => ['type' => 'ENUM', 'constraint' => ['qris', 'transfer_bank', 'tunai']],
            'bukti_transfer'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'status_verifikasi' => ['type' => 'ENUM', 'constraint' => ['pending', 'verified', 'rejected'], 'default' => 'pending', 'null' => true],
            'keterangan'        => ['type' => 'TEXT', 'null' => true],
            'created_at'        => ['type' => 'DATETIME', 'null' => true],
            'updated_at'        => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'        => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('status_verifikasi');
        $this->forge->addKey('jenis');
        $this->forge->createTable('trn_zis', true);
    }

    public function down()
    {
        $this->forge->dropTable('trn_zis', true);
        $this->forge->dropTable('trn_bantuan_material', true);
        $this->forge->dropTable('trn_keuangan', true);
    }
}
