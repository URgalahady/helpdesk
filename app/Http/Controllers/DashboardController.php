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

            return view('dashboard.admin', compact('stats', 'allTickets'));
        }

        // Mahasiswa / Dosen: statistik tiket milik sendiri
        $stats = Ticket::where('user_id', $user->id)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->all();

        foreach (['pending', 'accepted', 'implemented', 'closed'] as $s) {
            if (!isset($stats[$s])) $stats[$s] = 0;
        }

        $statusNotifications = Ticket::where('user_id', $user->id)
            ->whereIn('status', ['accepted', 'implemented', 'closed'])
            ->whereNull('status_read_at')
            ->orderBy('updated_at', 'desc')
            ->get();

        $view = $user->role === 'dosen' ? 'dashboard.dosen' : 'dashboard.mahasiswa';

        return view($view, compact('stats', 'statusNotifications'));
    }
}
