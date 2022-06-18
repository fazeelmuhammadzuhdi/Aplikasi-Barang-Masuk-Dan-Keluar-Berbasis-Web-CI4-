<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Barang extends Migration
{
	public function up()
    {
        $this->forge->addField([
            'brgkode1910021' => [
                'type' => 'char',
                'constraint' => '10',
            ],
            'brgnama1910021' => [
                'type' => 'varchar',
                'constraint' => '100'
            ],
            'brgkatid1910021' => [
                'type' => 'int',
                'unsigned' => true
            ],
            'brgsatid1910021' => [
                'type' => 'int',
                'unsigned' => true
            ],
            'brgharga1910021' => [
                'type' => 'double',
            ],
            'brggambar1910021' => [
                'type' => 'varchar',
                'constraint' => 200
            ]
        ]);
 
        $this->forge->addPrimaryKey('brgkode1910021');
        $this->forge->addForeignKey('brgkatid1910021', 'kategori1910021', 'katid1910021');
        $this->forge->addForeignKey('brgsatid1910021', 'satuan1910021', 'satid1910021');
 
        $this->forge->createTable('barang1910021');
    }
 
    public function down()
    {
        $this->forge->dropTable('barang1910021');
    }
}
