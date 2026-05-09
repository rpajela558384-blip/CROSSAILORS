<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Notifications\TicketReplied;
use App\Notifications\TicketStatusChanged;
use Illuminate\Http\Request;

class TicketManageController extends Controller
{
    public function index(Request $request)
    {
        $query = Ticket::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $tickets = $query->paginate(10);
        return view('officer.tickets.index', compact('tickets'));
    }

    public function show(Ticket $ticket)
    {
        $ticket->load(['replies.user', 'user']);
        return view('officer.tickets.show', compact('ticket'));
    }

    public function reply(Request $request, Ticket $ticket)
    {
        $validated = $request->validate(['message' => 'required|string|max:5000']);

        $reply = $ticket->replies()->create([
            'user_id' => auth()->id(),
            'message' => $validated['message'],
        ]);

        $ticket->user->notify(new TicketReplied($ticket, $reply));

        return back()->with('success', 'Reply sent.');
    }

    public function updateStatus(Request $request, Ticket $ticket)
    {
        $request->validate(['status' => 'required|in:open,in_progress,resolved']);

        $oldStatus = $ticket->status;
        $ticket->update(['status' => $request->status]);

        $ticket->user->notify(new TicketStatusChanged($ticket, $oldStatus, $request->status));

        return back()->with('success', 'Ticket status updated.');
    }
}
