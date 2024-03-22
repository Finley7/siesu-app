<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketComment\CreateTicketCommentRequest;
use App\Models\Ticket;
use App\Models\TicketComment;
use App\Notifications\Ticket\TicketCommentCreated;
use Illuminate\Support\Facades\Auth;

class TicketCommentController extends Controller
{
    public function store(CreateTicketCommentRequest $request, Ticket $ticket) {

        $request = $request->validated();
        $request['author_id'] = Auth::user()->id;
        $request['ticket_id'] = $ticket->id;

        $ticketComment = TicketComment::create($request);

        if($ticket->status == 'done') {
            $ticket->update(['status' => 'in_review']);
        }

        $ticket->author->notify((new TicketCommentCreated($ticketComment))->locale('nl'));

        if($ticket->handler != null) {
            $ticket->handler->notify((new TicketCommentCreated($ticketComment))->locale('nl'));
        }

        return redirect()->to('/tickets/view/' . $ticket->id)->with('success', __('ticket.comment.flash.success'));

    }
}
