<?php

namespace App\Controllers;

use App\Models\TicketModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $ticketModel = new TicketModel();

        // Mengambil rekap jumlah data berdasarkan status
        $data = [
            'total_semua' => $ticketModel->countAllResults(),
            'tiket_open'  => $ticketModel->where('status', 'open')->countAllResults(), // <-- METRIK BARU
            'in_progress' => $ticketModel->where('status', 'in progress')->countAllResults(),
            'selesai'     => $ticketModel->whereIn('status', ['resolved', 'closed'])->countAllResults()
        ];

        return view('dashboard', $data);
    }
}