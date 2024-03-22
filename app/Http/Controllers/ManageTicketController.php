<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ticket\SaveTicketStatusAndHandlerRequest;
use App\Models\Ticket;
use App\Notifications\Ticket\TicketMarkedAsDone;
use App\Notifications\Ticket\TicketStatusUpdate;
use Illuminate\Support\Facades\Auth;

class ManageTicketController extends Controller
{
    public function save(SaveTicketStatusAndHandlerRequest $request, Ticket $ticket) {

        $request = $request->validated();

        if($ticket->status != $request['status'] && $request['status'] != 'done') {
            $ticket->author->notify(new TicketStatusUpdate($ticket));
        }

        $ticket->update($request);

        if($ticket->status == 'done') {
            $ticket->author->notify(new TicketMarkedAsDone($ticket));
        }

        return redirect()->to('/tickets/view/' . $ticket->id)->with('success', __('ticket.manage.save.flash.success'));

    }

    public function done(Ticket $ticket) {

        if(!Auth::user()->can('done', $ticket)) {
            abort(403);
        }

        $ticket->author->notify(new TicketMarkedAsDone($ticket));

        $ticket->update(['status' => 'done']);
        return redirect()->to('/tickets')->with('success', __('ticket.manage.done.flash.success'));

    }
}
