<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Admin: statistik semua tiket
            $stats = Ticket::select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->pluck('total', 'status')
                ->all();

            // Semua tiket beserta relasi user untuk ditampilkan di tabel
            $allTickets = Ticket::with('user')->orderBy('created_at', 'desc')->get();

        } else {
            // Mahasiswa / Dosen: statistik tiket milik sendiri
            $stats = Ticket::where('user_id', $user->id)
                ->select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->pluck('total', 'status')
                ->all();

            $allTickets = collect(); // tidak dipakai di view non-admin
        }

        // Pastikan semua status terdefinisi
        foreach (['pending', 'accepted', 'implemented', 'closed'] as $s) {
            if (!isset($stats[$s])) $stats[$s] = 0;
        }

        // Kembalikan view sesuai role
        switch ($user->role) {
            case 'admin':
                return view('dashboard.admin', compact('stats', 'allTickets'));
            case 'dosen':
                return view('dashboard.dosen', compact('stats'));
            default: // mahasiswa
                return view('dashboard.mahasiswa', compact('stats'));
        }
    }
}
