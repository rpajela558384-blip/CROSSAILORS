<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketReply;
use App\Models\User;
use App\Notifications\NewTicketSubmitted;
use App\Notifications\TicketReplied;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TicketController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $tickets = auth()->user()->tickets()->latest()->paginate(10); 
        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        return view('tickets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject'     => 'required|string|max:255',
            'description' => 'required|string|max:5000',
        ]);

        try {
            $ticket = auth()->user()->tickets()->create($validated);

            $officers = User::whereIn('role', ['officer', 'admin'])->where('is_active', true)->get();
            \Illuminate\Support\Facades\Notification::send($officers, new NewTicketSubmitted($ticket));

            return redirect()->route('tickets.show', $ticket)->with('success', 'Ticket submitted successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to submit ticket: ' . $e->getMessage());
        }
    }

    public function show(Ticket $ticket)
    {
        if (auth()->user()->isStudent() && $ticket->user_id !== auth()->id()) {
            abort(403);
        }

        $ticket->load(['replies.user', 'user']);
        return view('tickets.show', compact('ticket'));
    }

    public function reply(Request $request, Ticket $ticket)
    {
        if (auth()->user()->isStudent() && $ticket->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate(['message' => 'required|string|max:5000']);

        $reply = $ticket->replies()->create([
            'user_id' => auth()->id(),
            'message' => $validated['message'],
        ]);

        // Notify ticket owner if reply is from officer/admin
        if (auth()->user()->isOfficer() && $ticket->user_id !== auth()->id()) {
            $ticket->user->notify(new TicketReplied($ticket, $reply));
        }

        return back()->with('success', 'Reply added.');
    }
}
