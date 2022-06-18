<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Satuan extends Migration
{
	public function up()
    {
        $this->forge->addField([
            'satid1910021' => [
                'type' => 'int',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'satnama1910021' => [
                'type' => 'varchar',
                'constraint' => '50'
            ]
        ]);
        $this->forge->addKey('satid1910021');
        $this->forge->createTable('satuan1910021');
    }
 
    public function down()
    {
        $this->forge->dropTable('satuan1910021');
    }
}
