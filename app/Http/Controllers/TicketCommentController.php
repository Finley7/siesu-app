<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ticket\SaveTicketStatusAndHandlerRequest;
use App\Http\Requests\TicketComment\CreateTicketCommentRequest;
use App\Models\Ticket;
use App\Models\TicketComment;
use Illuminate\Support\Facades\Auth;

class TicketCommentController extends Controller
{
    public function store(CreateTicketCommentRequest $request, Ticket $ticket) {

        $request = $request->validated();
        $request['author_id'] = Auth::user()->id;
        $request['ticket_id'] = $ticket->id;

        TicketComment::create($request);

        if($ticket->status == 'done') {
            $ticket->update(['status' => 'in_review']);
        }

        return redirect()->to('/tickets/view/' . $ticket->id)->with('success', __('ticket.comment.flash.success'));

    }
}
