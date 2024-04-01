<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        if($request->query('q')){
            $tickets = Ticket::where(function($q) use($request){
                $q->where('tracking_id',$request->query('q'))
                ->orWhere('subject', 'like', '%'.$request->query('q').'%')
                ->orWhereHas('user', function($query) use($request){
                    $query->where('email', 'like', '%'.$request->query('q').'%')
                    ->orWhere('fullname', 'like', '%'.$request->query('q').'%');
                });
            })->with(['user','messages'])->latest()->paginate(15);
        }
        else{
            $tickets = Ticket::with(['user','messages'])->paginate(15);
        }


        return $this->success('Tickets retrieved!', [
            'tickets' => $tickets
        ]);
    }

    public function reply($ticket_id, Request $request)
    {
        $validated = $request->validate([
            'body' => 'required'
        ]);

        $ticket = Ticket::where('ticket_id', $ticket_id)->first();

        if(!$ticket)
        return $this->notFound('Ticket not found!');

        $ticket->messages()->create([
            'body' => $validated['body']
        ]);

        return $this->success('Message has been sent!');
    }
}
