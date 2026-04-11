<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TicketReplies extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'ticket_id'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            // 1. Tambahkan 'null' => true agar kolom ini bisa menerima nilai kosong (NULL)
            'user_id'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true], 
            'message'    => ['type' => 'TEXT'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        
        $this->forge->addKey('id', true);
        
        // 2. Pertahankan CASCADE untuk tiket (jika tiket dihapus, balasan hilang)
        $this->forge->addForeignKey('ticket_id', 'tickets', 'id', 'CASCADE', 'CASCADE');
        
        // 3. Ubah DELETE CASCADE menjadi SET NULL untuk user
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'SET NULL');
        
        $this->forge->createTable('ticket_replies');
    }

    public function down()
    {
        $this->forge->dropTable('ticket_replies');
    }
}