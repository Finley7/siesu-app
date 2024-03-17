<x-app-layout>
    <x-slot name="extraAssets">
        <script src="https://cdn.tiny.cloud/1/udr6l895o661kj8pin6lbzikgi4ft58bdjay3eq0lxnf6s9s/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
        <script>
            tinymce.init({
                selector: '#body'
            });
        </script>
    </x-slot>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                #{{ $ticket->id }} {{ $ticket->title }}
            </h2>
            <span class="status-{{ $ticket->status }}">{{ __('ticket.status.' . $ticket->status) }}</span>
        </div>

    </x-slot>

    <div class="py-12 sm:flex justify-center">

        <div class="sm:w-1/2 sm:px-4">
            <a class="text-sm text-blue-500 flex items-center uppercase hover:text-blue-700" href="{{ route('ticket.index') }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18" />
                </svg>
                {{ __('ticket.view.back_to_summary') }}</a>
            <div class="bg-white overflow-hidden shadow-sm rounded shadow mt-3">
                <div class="p-6 text-gray-900">
                    <p class="text-gray-600 text-xs italic pb-3">{{ $ticket->author->name }} {{ __('ticket.view.help.author') }} {{ $ticket->created_at }}</p>
                    {!! $ticket->description !!}
                </div>
            </div>
            @foreach($ticket->comments as $comment)
            <div class="bg-white overflow-hidden shadow-sm rounded mt-3 @if($comment->author->role == 'admin') text-right @endif">
                <div class="p-6 text-gray-900">
                    <p class="text-gray-600 text-xs italic pb-3">{{ $comment->author->name }} {{ __('ticket.view.comment.help.author') }} {{ $comment->created_at->format('d F Y H:i') }}</p>
                    {!! $comment->body !!}
                </div>
            </div>
            @endforeach
            <div class="bg-white overflow-hidden shadow-sm rounded mt-3">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('ticket-comment.create', ['ticket' => $ticket]) }}" method="post">
                        @csrf
                        <x-text-area name="body" id="body" cols="30" rows="10"></x-text-area>
                        <x-input-error :messages="$errors->get('body')" class="mt-2"/>
                        <button class="btn bg-green-500 mt-3 w-full">{{ __('ticket.view.comment.form.save') }}</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="sm:w-1/5 sm:px-4">
            <a class="text-sm text-gray-500" href="{{ route('ticket.index') }}">{{ __('ticket.view.next_ticket') }}</a>
            <div class="bg-white shadow-sm rounded overflow-hidden mb-3 mt-3">
                <div class="p-6 text-gray-900">
                    <div>
                        <div class="flex flex-col mb-2">
                            <h2>{{ __('ticket.view.author') }}</h2>
                            <span class="italic text-sm font-bold">{{ $ticket->author->name }}</span>
                        </div>
                        <div class="flex flex-col mb-2">
                            <h2>{{ __('ticket.view.handler') }}</h2>
                            <span class="italic text-sm font-bold">{{ $ticket->handler->name ?? '-' }}</span>
                        </div>
                        <div class="flex flex-col mb-2">
                            <h2>{{ __('ticket.view.created') }}</h2>
                            <span class="italic text-sm font-bold">{{ $ticket->created_at->format('d F Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @if(Auth::user()->can('manage', \App\Models\Ticket::class))
            <div class="bg-white overflow-hidden shadow-sm rounded mb-3">
                <div class="p-6 text-gray-900">
                    <h2 class="mb-2">{{ __('ticket.view.manage.title') }}</h2>
                    <form action="{{ route('ticket.manage.save', ['ticket' => $ticket]) }}" method="post">
                        @csrf
                        <div class="mt-4">
                            <x-input-label for="status" :value="__('ticket.view.manage.form.label.status')"/>
                            <select name="status" id="status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                                <option value="new">{{ __('ticket.view.manage.form.status.option.new') }}</option>
                                <option value="in_review">{{ __('ticket.view.manage.form.status.option.in_review') }}</option>
                                <option value="in_progress">{{ __('ticket.view.manage.form.status.option.in_progress') }}</option>
                                <option value="to_verify">{{ __('ticket.view.manage.form.status.option.to_verify') }}</option>
                                <option value="done">{{ __('ticket.view.manage.form.status.option.done') }}</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2"/>
                        </div>
                        <div class="mt-4">
                            <x-input-label for="handler_id" :value="__('ticket.view.manage.form.label.handler')"/>
                            <select name="handler_id" id="handler_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                                <option value="">{{ __('ticket.view.manage.form.handler.option.default') }}</option>
                                @foreach($admins as $admin)
                                    <option value="{{ $admin->id }}" @if($admin->id == $ticket->handler?->id) selected @endif>{{ $admin->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('handler_id')" class="mt-2"/>
                        </div>
                        <button class="btn bg-orange-500 mt-3 w-full">{{ __('ticket.view.manage.form.save') }}</button>
                    </form>
                </div>
            </div>
                <div class="px-2 mb-2">
                    <form method="post" action="{{ route('ticket.destroy', ['ticket' => $ticket]) }}">
                        @csrf
                        @method('delete')
                        <button class="text-xs text-gray-500">{{ __('ticket.view.manage.hard-delete') }}</button>
                    </form>
                </div>
            @endif
            <div class="bg-white overflow-hidden shadow-sm rounded shadow">
                <div class="p-6 text-gray-900">
                    <h2 class="mb-2">{{ __('ticket.view.media.title') }}</h2>
                    <ul>
                        @foreach($ticket->attachments as $attachment)
                        <li class="text-sm font-bold p-1">
                            <a class="hover:text-blue-500" target="_blank" href="{{ route('ticket-attachment.view', ['attachment' => $attachment]) }}">{{ $attachment->name }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

