<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;
use Tonysm\RichTextLaravel\Models\Traits\HasRichText;

class Ticket extends Model
{
    use HasFactory;

    public $fillable = [
        'title', 'description', 'author_id', 'handler_id', 'ticket_category_id', 'status'
    ];

    public function author() {
        return $this->belongsTo(User::class);
    }

    public function handler() {
        return $this->belongsTo(User::class);
    }

    public function attachments() {
        return $this->hasMany(TicketAttachment::class);
    }

    public function comments() {
        return $this->hasMany(TicketComment::class);
    }
}
