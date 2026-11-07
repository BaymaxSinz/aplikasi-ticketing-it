<?php

namespace App\Controllers;

use App\Models\TicketModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $ticketModel = new TicketModel();
        $db = \Config\Database::connect(); // Koneksi ke database murni untuk query kompleks

        // 1. METRIK ANGKA ATAS
        $tiket_open  = $ticketModel->where('status', 'open')->countAllResults();
        $in_progress = $ticketModel->where('status', 'in progress')->countAllResults();
        $selesai     = $ticketModel->whereIn('status', ['resolved', 'closed'])->countAllResults();
        $total_semua = $ticket_open + $in_progress + $selesai;

        // 2. 5 TIKET TERBARU (QUICK ACCESS)
        $builder = $ticketModel->builder();
        $builder->select('tickets.*, categories.name as category_name, users.name as technician_name');
        $builder->join('categories', 'categories.id = tickets.category_id');
        $builder->join('users', 'users.id = tickets.technician_id', 'left');
        $builder->orderBy('tickets.created_at', 'DESC');
        $builder->limit(5); // Ambil 5 teratas saja
        $latest_tickets = $builder->get()->getResultArray();

        // 3. DATA GRAFIK DONUT (SIMRS vs UMUM)
        $simrs_count = $ticketModel->where('ticket_type', 'simrs')->countAllResults();
        $umum_count  = $ticketModel->where('ticket_type', 'general')->countAllResults();

        // 4. DATA LEADERBOARD (Top 5 Ruangan Paling Sering Lapor)
        $top_departments = $db->table('tickets')
                              ->select('reporter_department, COUNT(id) as total_reports')
                              ->groupBy('reporter_department')
                              ->orderBy('total_reports', 'DESC')
                              ->limit(5)
                              ->get()
                              ->getResultArray();

        // Kirim semua data ke View
        $data = [
            'total_semua'     => $total_semua,
            'tiket_open'      => $ticket_open,
            'in_progress'     => $in_progress,
            'selesai'         => $selesai,
            'latest_tickets'  => $latest_tickets,
            'simrs_count'     => $simrs_count,
            'umum_count'      => $umum_count,
            'top_departments' => $top_departments
        ];

        return view('dashboard', $data);
    }
}