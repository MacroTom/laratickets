<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    use ApiResponse;

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|max:40',
            'body' => 'required'
        ]);

        $user = $request->user();

        $ticket = $user->tickets()->create([
            'subject' => $validated['subject'],
            'ticket_id' => generateUID()
        ]);

        $ticket->messages()->create([
            'body' => $validated['body']
        ]);

        return $this->success('Ticket has been created!');
    }

    public function reply($ticket_id, Request $request)
    {
        $validated = $request->validate([
            'body' => 'required'
        ]);

        $user = $request->user();

        $ticket = $user->tickets()->where('ticket_id', $ticket_id)->first();

        if(!$ticket)
        return $this->notFound('Ticket not found!');

        $ticket->messages()->create([
            'body' => $validated['body']
        ]);

        return $this->success('Message has been sent!');
    }
}
