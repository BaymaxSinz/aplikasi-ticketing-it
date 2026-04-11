<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\BaseController;

class Auth extends BaseController
{
    public function index()
    {
        // Jika sudah login, tendang ke dashboard
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard'); 
        }

        return view('auth/login');
    }

    public function process()
    {
        $session = session();
        $model = new UserModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $model->where('email', $email)->first();

        if ($user) {
            $pass_match = password_verify($password, $user['password']);
            
            if ($pass_match) {
                $ses_data = [
                    'id'        => $user['id'],
                    'name'      => $user['name'],
                    'email'     => $user['email'],
                    'role'      => $user['role'],
                    'logged_in' => TRUE
                ];

                $session->set($ses_data);
                // PERBAIKAN: Gunakan ->to()
                return redirect()->to('/dashboard'); 
            } else {
                $session->setFlashdata('error', 'Password yang anda masukkan salah!');
                // PERBAIKAN: Gunakan ->to()
                return redirect()->to('/login'); 
            }
        } else {
            // PERBAIKAN: Tambahkan response jika email tidak terdaftar
            $session->setFlashdata('error', 'Email tidak ditemukan!');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        session()->destroy();
        // PERBAIKAN: Gunakan ->to()
        return redirect()->to('/login'); 
    }
}