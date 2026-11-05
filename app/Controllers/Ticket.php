<?php

namespace App\Controllers;

use App\Models\TicketModel;
use App\Models\CategoryModel;
use App\Models\UserModel;

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
        // Menangkap parameter 'type' dari URL (contoh: ?type=simrs)
        $type = $this->request->getGet('type'); 

        $builder = $this->ticketModel->builder();
        $builder->select('tickets.*, categories.name as category_name, users.name as technician_name');
        $builder->join('categories', 'categories.id = tickets.category_id');
        $builder->join('users', 'users.id = tickets.technician_id', 'left');
        
        // Logika Filter Tipe Tiket
        if ($type == 'simrs') {
            $builder->where('tickets.ticket_type', 'simrs');
        } elseif ($type == 'general') {
            $builder->where('tickets.ticket_type', 'general');
        }

        $builder->orderBy('tickets.created_at', 'DESC');
        
        $data = [
            'tickets'     => $builder->get()->getResultArray(),
            'active_type' => $type // Mengirim status filter ke View agar tombol tab menyala
        ];
        
        return view('tickets/index', $data);
    }

    public function create()
    {
        $data = [
            'categories' => $this->categoryModel->findAll()
        ];
        return view('tickets/create', $data);
    }

    public function store()
    {
        $this->ticketModel->insert([
            'reporter_name'       => $this->request->getPost('reporter_name'),
            'reporter_department' => $this->request->getPost('reporter_department'),
            'category_id'         => $this->request->getPost('category_id'),
            'ticket_type'         => $this->request->getPost('ticket_type'),
            'title'               => $this->request->getPost('title'),
            'description'         => $this->request->getPost('description'),
            'priority'            => $this->request->getPost('priority'),
            'status'              => 'open'
        ]);

        session()->setFlashdata('success', 'Laporan tiket berhasil dicatat!');
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

        $userModel = new UserModel();

        $data = [
            'ticket'      => $ticket,
            'technicians' => $userModel->findAll() 
        ];
        
        return view('tickets/detail', $data);
    }

    public function edit($id)
    {
        $data = [
            'ticket'     => $this->ticketModel->find($id),
            'categories' => $this->categoryModel->findAll()
        ];
        return view('tickets/edit', $data);
    }

    public function update()
    {
        $id = $this->request->getPost('id');

        $this->ticketModel->update($id, [
            'reporter_name'       => $this->request->getPost('reporter_name'),
            'reporter_department' => $this->request->getPost('reporter_department'),
            'category_id'         => $this->request->getPost('category_id'),
            'ticket_type'         => $this->request->getPost('ticket_type'),
            'title'               => $this->request->getPost('title'),
            'description'         => $this->request->getPost('description'),
            'priority'            => $this->request->getPost('priority')
        ]);

        session()->setFlashdata('success', 'Data tiket berhasil diperbarui!');
        return redirect()->to('/tickets/detail/' . $id);
    }

    public function take($id)
    {
        $this->ticketModel->update($id, [
            'technician_id' => session()->get('id'),
            'status'        => 'in progress'
        ]);

        session()->setFlashdata('success', 'Tiket berhasil diambil alih!');
        return redirect()->to('/tickets/detail/' . $id);
    }

    public function updateStatus()
    {
        $id = $this->request->getPost('id');
        
        $data = [
            'status' => $this->request->getPost('status'),
            'resolution_note' => $this->request->getPost('resolution_note')
        ];

        $this->ticketModel->update($id, $data);

        session()->setFlashdata('success', 'Status penanganan tiket berhasil diupdate!');
        return redirect()->to('/tickets/detail/' . $id);
    }

    public function assign()
    {
        if (session()->get('role') != 'admin') {
            return redirect()->to('/tickets');
        }

        $id = $this->request->getPost('ticket_id');
        
        $data = [
            'technician_id'   => $this->request->getPost('technician_id'),
            'status'          => $this->request->getPost('status'),
            'resolution_note' => $this->request->getPost('resolution_note')
        ];

        $this->ticketModel->update($id, $data);

        session()->setFlashdata('success', 'Super Override berhasil! Data penanganan tiket telah diperbarui.');
        return redirect()->to('/tickets/detail/' . $id);
    }

    public function delete($id)
    {
        if(session()->get('role') != 'admin') return redirect()->to('/tickets');

        $this->ticketModel->delete($id);
        session()->setFlashdata('success', 'Data tiket berhasil dihapus!');
        return redirect()->to('/tickets');
    }

    public function export()
    {
        // Menangkap parameter 'type' agar Excel yang didownload sesuai filter
        $type = $this->request->getGet('type');

        $builder = $this->ticketModel->builder();
        $builder->select('tickets.*, categories.name as category_name, users.name as technician_name');
        $builder->join('categories', 'categories.id = tickets.category_id');
        $builder->join('users', 'users.id = tickets.technician_id', 'left');
        
        // Logika Filter Tipe Tiket
        if ($type == 'simrs') {
            $builder->where('tickets.ticket_type', 'simrs');
        } elseif ($type == 'general') {
            $builder->where('tickets.ticket_type', 'general');
        }
        
        $builder->orderBy('tickets.created_at', 'DESC');
        
        $tickets = $builder->get()->getResultArray();

        // Mengubah nama file Excel secara dinamis berdasarkan filter
        $filterName = 'Semua_Tiket';
        if ($type == 'simrs') $filterName = 'Tiket_SIMRS';
        if ($type == 'general') $filterName = 'Tiket_IT_Umum';

        $filename = 'Laporan_' . $filterName . '_' . date('Y-m-d') . '.csv';
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv; "); 
        
        $file = fopen('php://output', 'w');
        
        $header = array("ID Tiket", "Tipe Tiket", "Tanggal Lapor", "Nama Pelapor", "Departemen", "Kategori Masalah", "Judul", "Status", "Teknisi", "Catatan Solusi"); 
        fputcsv($file, $header, ';');
        
        foreach ($tickets as $t){ 
            $line = array(
                '#' . $t['id'], 
                strtoupper($t['ticket_type']), 
                $t['created_at'], 
                $t['reporter_name'], 
                $t['reporter_department'], 
                $t['category_name'], 
                $t['title'], 
                strtoupper($t['status']), 
                $t['technician_name'] ? $t['technician_name'] : 'Belum Ditugaskan', 
                $t['resolution_note'] ? $t['resolution_note'] : '-'
            ); 
            fputcsv($file, $line, ';'); 
        }
        
        fclose($file); 
        exit; 
    }
}