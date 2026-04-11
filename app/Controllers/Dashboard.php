<?php

namespace App\Controllers;

use App\Models\TicketModel;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Dashboard extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect('/login');
        }

        $ticketModel = new TicketModel();

        $data = [
            // Menghitung tiket yang dibuat khusus hari ini
            'total_semua' => $ticketModel->countAllResults(),
            // Menghitung tiket yang sedang dikerjakan
            'in_progress'    => $ticketModel->where('status', 'in progress')->countAllResults(),
            // Menghitung tiket yang sudah selesai (resolved / closed)
            'selesai'        => $ticketModel->whereIn('status', ['resolved', 'closed'])->countAllResults()
        ];

        return view('dashboard', $data);
    }
}
