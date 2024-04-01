<?php

namespace App\Http\Controllers;


use App\Http\Requests\TicketAttachment\CreateTicketAttachmentRequest;
use App\Models\TicketAttachment;

class TicketAttachmentController extends Controller
{
    public function store(CreateTicketAttachmentRequest $request)
    {
        if(!$request->file('file')->isValid()) {
            abort(400);
        }

        $file = $request->file('file');

        $ta = new TicketAttachment();
        $ta->name = $file->getClientOriginalName();
        $ta->filename = bin2hex(openssl_random_pseudo_bytes(8)) . '_' . $ta->name;
        $ta->size = $file->getSize();
        $ta->temp_id = $request->temp_id;

        if($file->storeAs('attachments', $ta->filename) == null) {
            abort(400);
        }

        $ta->save();
        return response()->json(['success']);
    }

    public function view(TicketAttachment $attachment) {
        $filePath = storage_path('app/attachments/' . $attachment->filename);

        // Check if the file exists
        if (file_exists($filePath)) {
            // Return a response with the file content
            return response()->file($filePath);
        }
        // Return a 404 response if the file does not exist
        abort(404);
    }
}
