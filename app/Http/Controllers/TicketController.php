<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    /**
     * Display a listing of tickets.
     * Admin sees all, mahasiswa sees only their own tickets.
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            $tickets = Ticket::orderBy('created_at', 'desc')->paginate(15);
        } else {
            $tickets = Ticket::where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate(15);
        }
        return view('tickets.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new ticket.
     */
    public function create()
    {
        $role = Auth::user()->role;
        if ($role === 'mahasiswa') {
            return view('tickets.create_mahasiswa');
        }
        if ($role === 'dosen') {
            return view('tickets.create_dosen');
        }
        // admin can use generic create view if needed
        return view('tickets.create');
    }

    /**
     * Store a newly created ticket in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'category'    => 'required|in:academic,technical,administrative',
            'priority'    => 'required|in:low,medium,high',
            'attachment'  => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ], [
            'title.required'       => 'Judul pengaduan wajib diisi.',
            'description.required' => 'Deskripsi pengaduan wajib diisi.',
            'category.required'    => 'Kategori wajib dipilih.',
            'priority.required'    => 'Prioritas wajib dipilih.',
            'attachment.mimes'     => 'File lampiran harus berformat jpg, png, pdf, doc, atau docx.',
            'attachment.max'       => 'Ukuran file maksimal 2MB.',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $data                = $validator->validated();
        $data['user_id']     = Auth::id();
        $data['status']      = 'pending';

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('attachments', 'public');
        }

        Ticket::create($data);

        // Redirect ke dashboard sesuai role dengan pesan sukses
        $role = Auth::user()->role;
        $dashboardRoute = match($role) {
            'mahasiswa' => 'dashboard.mahasiswa',
            'dosen'     => 'dashboard.dosen',
            default     => 'dashboard',
        };

        return redirect()->route($dashboardRoute)
            ->with('success', 'Pengaduan berhasil dikirim! Kami akan segera menindaklanjutinya.');
    }

    /**
     * Display the specified ticket.
     */
    public function show(Ticket $ticket)
    {
        $this->authorizeView($ticket);
        return view('tickets.show', compact('ticket'));
    }

    /**
     * Update the ticket (e.g., change status or edit by admin).
     */
    public function update(Request $request, Ticket $ticket)
    {
        $this->authorizeUpdate($ticket);

        $validator = Validator::make($request->all(), [
            'status' => 'sometimes|in:pending,accepted,implemented,closed',
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'category' => 'sometimes|in:academic,technical,administrative',
            'priority' => 'sometimes|in:low,medium,high',
            'attachment' => 'nullable|file|max:2048',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('attachments');
            $data['attachment'] = $path;
        }

        $ticket->update($data);

        return redirect()->route('tickets.show', $ticket)->with('success', 'Ticket updated.');
    }

    /**
     * Remove the specified ticket (admin only).
     */
    public function destroy(Ticket $ticket)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
        $ticket->delete();
        return redirect()->route('tickets.index')->with('success', 'Ticket deleted.');
    }

    /**
     * Authorization helper for viewing a ticket.
     */
    protected function authorizeView(Ticket $ticket)
    {
        $user = Auth::user();
        if ($user->role !== 'admin' && $ticket->user_id !== $user->id) {
            abort(403);
        }
    }

    /**
     * Authorization helper for updating a ticket.
     */
    protected function authorizeUpdate(Ticket $ticket)
    {
        // Mahasiswa can only edit their own ticket while it is still pending.
        $user = Auth::user();
        if ($user->role === 'mahasiswa') {
            if ($ticket->user_id !== $user->id || $ticket->status !== 'pending') {
                abort(403);
            }
        }
        // Admin can update any field.
    }
}
