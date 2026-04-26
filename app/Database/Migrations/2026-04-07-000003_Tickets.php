<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Tickets extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'reporter_name' => ['type' => 'VARCHAR', 'constraint' => 150],
            'reporter_department' => ['type' => 'VARCHAR', 'constraint' => 150], 'null' => true,
            'category_id'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'technician_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'title'         => ['type' => 'VARCHAR', 'constraint' => 255],
            'description'   => ['type' => 'TEXT'],
            'priority'      => ['type' => 'ENUM', 'constraint' => ['low', 'medium', 'high'], 'default' => 'medium'],
            'status'        => ['type' => 'ENUM', 'constraint' => ['open', 'in progress', 'resolved', 'closed'], 'default' => 'open'],
            'resolution_note'  => ['type' => 'TEXT'], 'null' => true,
            'attachment'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        
        $this->forge->addKey('id', true);
        
        $this->forge->addForeignKey('category_id', 'categories', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('technician_id', 'users', 'id', 'CASCADE', 'SET NULL'); 
        
        $this->forge->createTable('tickets');
    }

    public function down()
    {
        $this->forge->dropTable('tickets');
    }
}