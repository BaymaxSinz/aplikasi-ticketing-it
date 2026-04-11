<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        //
        $data = [
            [
                'name'       => 'superadmin',
                'email'      => 'admin@gmail.com',
                'password'   => password_hash('password123', PASSWORD_BCRYPT),
                'role'       => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'       => 'Budi Teknisi',
                'email'      => 'teknisi@gmail.com',
                'password'   => password_hash('password123', PASSWORD_BCRYPT),
                'role'       => 'teknisi',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];

        // Memasukkan data ke tabel users
        $this->db->table('users')->insertBatch($data);
    }
    
}
