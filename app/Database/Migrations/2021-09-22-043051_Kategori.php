<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kategori extends Migration
{
	public function up()
    {
        $this->forge->addField([
            'katid1910021' => [
                'type' => 'int',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'katnama1910021' => [
                'type' => 'varchar',
                'constraint' => '50'
            ]
        ]);
        $this->forge->addKey('katid1910021');
        $this->forge->createTable('kategori1910021');
    }
 
    public function down()
    {
        $this->forge->dropTable('kategori1910021');
    }
}
