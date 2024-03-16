<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ticket\SaveTicketStatusAndHandlerRequest;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class ManageTicketController extends Controller
{
    public function save(SaveTicketStatusAndHandlerRequest $request, Ticket $ticket) {

        $request = $request->validated();
        $ticket->update($request);

        return redirect()->to('/tickets/view/' . $ticket->id)->with('success', __('ticket.manage.save.flash.success'));

    }

    public function done(Ticket $ticket) {

        if(!Auth::user()->can('done', $ticket)) {
            abort(403);
        }

        $ticket->update(['status' => 'done']);
        return redirect()->to('/tickets')->with('success', __('ticket.manage.done.flash.success'));

    }
}
