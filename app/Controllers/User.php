<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class User extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        if(session()->get('role') != 'admin') {
            session()->setFlashdata('error', 'Anda Tidak Memiliki Akses');
            return redirect()->to('/dashboard');
        }

        $data = [
            'users' => $this->userModel->findAll()
        ];

        return view('users/index', $data);
    }

    public function save()
    {
        $id = $this->request->getPost('id');

        $data = [
            'name'  => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'role'  => $this->request->getPost('role')
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        if ($id) {
            $this->userModel->update($id, $data);
            session()->setFlashdata('success', 'Data tim IT berhasil diperbarui!');
        } else {
            $this->userModel->insert($data);
            session()->setFlashdata('success', 'Anggota tim IT baru berhasil ditambahkan!');
        }

        return redirect()->to('/users');
    }

    public function delete($id)
    {
        if ($id == session()->get('id')) {
            session()->setFlashdata('error', 'Anda tidak dapat menghapus akun Anda sendiri saat sedang login!');
            return redirect()->to('/users');
        }

        $this->userModel->delete($id);
        session()->setFlashdata('success', 'Akun tim IT berhasil dihapus!');
        return redirect()->to('/users');
    }
}
