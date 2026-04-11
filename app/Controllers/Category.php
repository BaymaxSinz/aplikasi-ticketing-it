<?php

namespace App\Controllers;

use App\Models\CategoryModel;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Category extends BaseController
{

    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        if (session()->get('role') != 'admin') {
            return redirect()->to('/dashboard');
        }

        $data = [
            'categories' => $this->categoryModel->findAll()
        ];

        return view('categories/index', $data);
    }

    public function save()
    {
        $id = $this->request->getPost('id');
        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description')
        ];

        if ($id) {
            $this->categoryModel->update($id, $data);
            session()->setFlashdata('success', 'Kategori Berhasil Diperbarui');
        } else {
            $this->categoryModel->insert($data);
            session()->setFlashdata('success', 'Kategori Berhasil Ditambahkan');
        }

        return redirect()->to('/categories');
    }

    public function delete($id)
    {
        $this->categoryModel->delete($id);
        session()->setFlashdata('success', 'Kategori Berhasil Dihapus');
        return redirect()->to('/categories');
    }
}
