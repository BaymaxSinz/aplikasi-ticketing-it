<?php

namespace App\Controllers;

use App\Models\TicketModel;
use App\Models\CategoryModel;

use App\Controllers\BaseController;
use App\Database\Migrations\Categories;
use CodeIgniter\HTTP\ResponseInterface;
use PHPUnit\Framework\MockObject\ReturnValueNotConfiguredException;

class Ticket extends BaseController
{

    protected $ticketModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->ticketModel = new TicketModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $builder = $this->ticketModel->builder();
        $builder->select('tickets.*, categories.name as category_name, users.name as technician_name');
        $builder->join('categories', 'categories.id = tickets.category_id');
        $builder->join('users', 'users.id = tickets.technician_id', 'left');
        $builder->orderBy('tickets.created_at', 'DESC');

        $data = [
            'tickets' => $builder->get()->getResultArray()
        ];

        return view('tickets/index', $data);
    }

    public function create()
    {
        $data = [
            'categories' => $this->categoryModel->findAll()
        ];

        return view ('tickets/create', $data);
    }

    public function store()

    {
        $data = [
            'reporter_name'       => $this->request->getPost('reporter_name'),
            'reporter_department' => $this->request->getPost('reporter_department'),
            'category_id'         => $this->request->getPost('category_id'),
            'title'               => $this->request->getPost('title'),
            'description'         => $this->request->getPost('description'),
            'priority'            => $this->request->getPost('priority'),
            'status'              => 'open',
        ];

        $this->ticketModel->insert($data);
        session()->setFlashdata('success', 'Laporan Masalah berhasil dibuat');

        return redirect()->to('/tickets');
    }

    public function edit($id)
    {
        $ticket = $this->ticketModel->find($id);
        if(!$ticket) {
            return redirect()->to('/tickets');
        }

        $data = [
            'ticket'     => $ticket,
            'categories' => $this->categoryModel->findAll()
        ];

        return view('tickets/edit', $data);
    }

    public function update()
    {
        $id = $this->request->getPost('id');
        $data = [
            'reporter_name'       => $this->request->getPost('reporter_name'),
            'reporter_department' => $this->request->getPost('reporter_department'),
            'category_id'         => $this->request->getPost('category_id'),
            'title'               => $this->request->getPost('title'),
            'description'         => $this->request->getPost('description'),
            'priority'            => $this->request->getPost('priority'),
        ];

        $this->ticketModel->update($id, $data);
        session()->setFlashdata('success', 'Tiket Berhasil Di Update');
        return redirect()->to('/tickets');
    }

    public function delete($id)
    {
        if(session()->get('role') != 'admin') {
            return redirect()->to('/dashboard');
        }

        $this->ticketModel->delete($id);
        session()->setFlashdata('success', 'Tiket Berhasil Dihapus');
        return redirect()->to('/tickets');
    }

    public function detail($id)
    {
        $builder = $this->ticketModel->builder();
        $builder->select('tickets.*, categories.name as category_name, users.name as technician_name');
        $builder->join('categories', 'categories.id = tickets.category_id');
        $builder->join('users', 'users.id = tickets.technician_id', 'left');
        $builder->where('tickets.id', $id);

        $ticket = $builder->get()->getRowArray();

        if (!$ticket) {
            return redirect()->to('/tickets');
        }

        $data = [
            'ticket' => $ticket
        ];

        return view('tickets/detail', $data);
    }

    public function take($id)
    {
        $this->ticketModel->update($id, [
            'technician_id' => session()->get('id'),
            'status'        => 'in progress'
        ]);

        session()->setFlashdata('success', 'Tiket Berhasil Di Ambil. Selamat Bekerja');
        return redirect()->to('/tickets/detail/'. $id);
    }

    public function updateStatus()
    {
        $id = $this->request->getPost('id');
        $data = [
            'status'          => $this->request->getPost('status'),
            'resolution_note' => $this->request->getPost('resolution_note')
        ];

        $this->ticketModel->update($id, $data);
        session()->setFlashdata('success', 'Status Tiket Berhasil Diperbarui');
        return redirect()->to('/tickets/detail/' . $id);
    }

    // Fungsi Export ke CSV (Excel)
    public function export()
    {
        // Hanya ambil tiket yang statusnya sudah 'closed' (selesai sempurna)
        $builder = $this->ticketModel->builder();
        $builder->select('tickets.*, categories.name as category_name, users.name as technician_name');
        $builder->join('categories', 'categories.id = tickets.category_id');
        $builder->join('users', 'users.id = tickets.technician_id', 'left');
        $builder->where('tickets.status', 'closed');
        $builder->orderBy('tickets.created_at', 'DESC');
        
        $tickets = $builder->get()->getResultArray();

        // Konfigurasi Header untuk trigger download file
        $filename = 'Laporan_IT_Helpdesk_' . date('Y-m-d') . '.csv';
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv; "); 
        
        // Membuka output memori
        $file = fopen('php://output', 'w');
        
        // Membuat baris Header tabel
        $header = array("ID Tiket", "Tanggal Lapor", "Nama Pelapor", "Departemen", "Kategori Masalah", "Judul", "Teknisi", "Catatan Solusi"); 
        fputcsv($file, $header, ';');
        
        // Melakukan looping data tiket ke dalam baris Excel
        foreach ($tickets as $t){ 
            $line = array(
                '#' . $t['id'], 
                $t['created_at'], 
                $t['reporter_name'], 
                $t['reporter_department'], 
                $t['category_name'], 
                $t['title'], 
                $t['technician_name'], 
                $t['resolution_note']
            ); 
            fputcsv($file, $line, ';'); 
        }
        
        fclose($file); 
        exit; 
    }
}
