<?php

use App\Http\Controllers\ManageTicketController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketAttachmentController;
use App\Http\Controllers\TicketCommentController;
use App\Http\Controllers\TicketController;
use App\Models\Ticket;
use App\Models\TicketAttachment;
use App\Models\TicketComment;
use Illuminate\Support\Facades\Route;

Route::get('/', static function () {
    return redirect()->to('/login');
});

Route::get('/dashboard', static function () {
    return redirect()->to('/tickets');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(static function () {
    Route::get('/profile', static function (\Illuminate\Http\Request $request) : \Illuminate\View\View {
        return (new \App\Http\Controllers\ProfileController())->edit($request);
    })->name('profile.edit');
    Route::patch('/profile', static function (\App\Http\Requests\ProfileUpdateRequest $request) : \Illuminate\Http\RedirectResponse {
        return (new \App\Http\Controllers\ProfileController())->update($request);
    })->name('profile.update');
    Route::delete('/profile', static function (\Illuminate\Http\Request $request) : \Illuminate\Http\RedirectResponse {
        return (new \App\Http\Controllers\ProfileController())->destroy($request);
    })->name('profile.destroy');
    Route::get('/tickets', static function () {
        return (new \App\Http\Controllers\TicketController())->index();
    })->name('ticket.index');
    Route::get('/tickets/view/{ticket}', static function (\App\Models\Ticket $ticket) {
        return (new \App\Http\Controllers\TicketController())->show($ticket);
    })->name('ticket.view');
    Route::get('/tickets/create', static function () {
        return (new \App\Http\Controllers\TicketController())->create();
    })->name('ticket.create')->can('create', Ticket::class);
    Route::post('/tickets/create', static function (\App\Http\Requests\Ticket\CreateTicketRequest $request) {
        return (new \App\Http\Controllers\TicketController())->store($request);
    })->name('ticket.store')->can('create', Ticket::class);
    Route::delete('/tickets/delete/{ticket}', static function (\App\Models\Ticket $ticket) {
        return (new \App\Http\Controllers\TicketController())->destroy($ticket);
    })->name('ticket.destroy');
    Route::post('/tickets/{ticket}/manage/save', static function (\App\Http\Requests\Ticket\SaveTicketStatusAndHandlerRequest $request, \App\Models\Ticket $ticket) {
        return (new \App\Http\Controllers\ManageTicketController())->save($request, $ticket);
    })->name('ticket.manage.save')->can('manage', Ticket::class);
    Route::get('/tickets/{ticket}/manage/mark-as-done', static function (\App\Models\Ticket $ticket) {
        return (new \App\Http\Controllers\ManageTicketController())->done($ticket);
    })->name('ticket.manage.mark-as-done');
    Route::post('/ticket-attachment/upload', static function (\App\Http\Requests\TicketAttachment\CreateTicketAttachmentRequest $request) {
        return (new \App\Http\Controllers\TicketAttachmentController())->store($request);
    })->name('ticket-attachment.store')->can('create', TicketAttachment::class);
    Route::get('/ticket-attachment/view/{attachment}', static function (\App\Models\TicketAttachment $attachment) {
        return (new \App\Http\Controllers\TicketAttachmentController())->view($attachment);
    })->name('ticket-attachment.view')->can('view', TicketAttachment::class);
    Route::post('/tickets/{ticket}/ticket-comment/create', static function (\App\Http\Requests\TicketComment\CreateTicketCommentRequest $request, \App\Models\Ticket $ticket) {
        return (new \App\Http\Controllers\TicketCommentController())->store($request, $ticket);
    })->name('ticket-comment.create')->can('create', TicketComment::class);
});

require __DIR__.'/auth.php';
