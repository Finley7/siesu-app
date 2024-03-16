<?php

namespace App\Http\Requests\TicketComment;

use App\Models\TicketComment;
use Illuminate\Foundation\Http\FormRequest;

class CreateTicketCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', TicketComment::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'body' => 'required'
        ];
    }
}
