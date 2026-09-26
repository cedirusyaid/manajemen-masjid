<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRecurringFieldsToAgendaTable extends Migration
{
    public function up()
    {
        $fields = [
            'tipe_jadwal' => [
                'type'       => 'ENUM',
                'constraint' => ['sekali', 'rutin'],
                'default'    => 'sekali',
                'after'      => 'kegiatan_id'
            ],
            'hari_rutin' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
                'after'      => 'tipe_jadwal'
            ],
            'pekan_rutin' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'hari_rutin'
            ]
        ];

        $this->forge->addColumn('mst_agenda', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('mst_agenda', ['tipe_jadwal', 'hari_rutin', 'pekan_rutin']);
    }
}
