<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tonysm\RichTextLaravel\Attachables\Attachable;

class TicketAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
          'ticket_id', 'ticket_comment_id', 'name', 'filename', 'size', 'status', 'temp_id'
    ];


}
