<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ticket\CreateTicketRequest;
use App\Models\Ticket;
use App\Models\TicketAttachment;
use App\Models\TicketCategory;
use App\Models\User;
use App\Notifications\Ticket\TicketCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('ticket/index', [
            'tickets' => Ticket::whereNot('status', 'done')->orderBy('created_at', 'desc')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tempTicketId = bin2hex(openssl_random_pseudo_bytes(8));
        return view('ticket/create', [
            'categories' => TicketCategory::all(),
            'tempTicketId' => $tempTicketId
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTicketRequest $request)
    {
        $request = $request->validated();
        $request['author_id'] = Auth::user()->id;

        $ticket = Ticket::create($request);

        $attachments = TicketAttachment::where('temp_id', $request['temp_ticket_id'])
            ->where('status', 'new')
            ->get();

        foreach($attachments as $attachment) {
            $attachment->ticket_id = $ticket->id;
            $attachment->status = 'complete';
            $attachment->save();
        }

        Notification::send(User::where('role', 'admin')->get(), new TicketCreated($ticket));

        return redirect()->to('tickets/view/' . $ticket->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        return view('ticket/view', [
            'ticket' => $ticket,
            'users' => User::all(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        if(!Auth::user()->can('delete', $ticket)) {
            abort(403);
        }

        $ticket->delete();
        return redirect()->to('/tickets')->with('success', __('ticket.flash.deleted'));
    }
}
