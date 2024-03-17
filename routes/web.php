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

Route::get('/', function () {
    return redirect()->to('/login');
});

Route::get('/dashboard', function () {
    return redirect()->to('/tickets');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/tickets', [TicketController::class, 'index'])->name('ticket.index');
    Route::get('/tickets/view/{ticket}', [TicketController::class, 'show'])->name('ticket.view');
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('ticket.create')->can('create', Ticket::class);
    Route::post('/tickets/create', [TicketController::class, 'store'])->name('ticket.store')->can('create', Ticket::class);
    Route::delete('/tickets/delete/{ticket}', [TicketController::class, 'destroy'])->name('ticket.destroy');

    Route::post('/tickets/{ticket}/manage/save', [ManageTicketController::class, 'save'])->name('ticket.manage.save')->can('manage', Ticket::class);
    Route::get('/tickets/{ticket}/manage/mark-as-done', [ManageTicketController::class, 'done'])->name('ticket.manage.mark-as-done');

    Route::post('/ticket-attachment/upload', [TicketAttachmentController::class, 'store'])->name('ticket-attachment.store')->can('create', TicketAttachment::class);
    Route::get('/ticket-attachment/view/{attachment}', [TicketAttachmentController::class, 'view'])->name('ticket-attachment.view')->can('view', TicketAttachment::class);

    Route::post('/tickets/{ticket}/ticket-comment/create', [TicketCommentController::class, 'store'])->name('ticket-comment.create')->can('create', TicketComment::class);
});

require __DIR__.'/auth.php';
