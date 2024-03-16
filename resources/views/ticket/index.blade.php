@php use App\Models\Ticket; @endphp
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('ticket.index.title') }}
            </h2>
            @if(Auth::user()->can('create', Ticket::class))
                <a class="btn bg-green-500"
                   href="{{ route('ticket.create') }}">{{ __('ticket.index.create-button') }}</a>
            @endif
        </div>

    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2>{{ __('ticket.index.title') }}</h2>
                </div>
            </div>

            <div class="bg-white-overflow-hidden shadow-sm sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 mt-3 bg-white sm:rounded-lg">
                    <thead>
                    <tr>
                        <th class="px-6 py-3">#</th>
                        <th class="px-6 py-3">{{ __('ticket.index.table.title') }}</th>
                        <th class="px-6 py-3">{{ __('ticket.index.table.handler') }}</th>
                        <th class="px-6 py-3">{{ __('ticket.index.table.status') }}</th>
                        <th class="px-6 py-3">{{ __('ticket.index.table.date') }}</th>
                        <th class="px-6 py-3">{{ __('ticket.index.table.last_response') }}</th>
                        <th class="px-1 py-3"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tickets as $ticket)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                 @if($ticket->status == 'done')
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                              stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-green-500">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="m4.5 12.75 6 6 9-13.5"/>
                                    </svg>
                                @else
                                    {{ $ticket->id }}
                                @endif
                            </td>
                            <td class="px-6 py-4">{{ $ticket->title }}</td>
                            <td class="px-6 py-4">{{ $ticket->handler->name ?? '-' }}</td>
                            <td class="px-6 py-4"><span
                                    class="status-{{ $ticket->status }}">{{ __('ticket.status.' . $ticket->status) }}</span>
                            </td>
                            <td class="px-6 py-4">{{ $ticket->created_at->format('d-m-Y H:i') }}</td>
                            <td class="px-6 py-4">{{ $ticket->comments->last()?->created_at->format('d-m-Y H:i') ?? '-'}}</td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-1">
                                    @if(Auth::user()->can('manage', Ticket::class))
                                        @if($ticket->status != 'done')
                                            <a class="p-1 bg-green-100 text-green-500 rounded hover:bg-green-200 transition-colors"
                                               href="{{ route('ticket.manage.mark-as-done', ['ticket' => $ticket->id]) }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                     stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="m4.5 12.75 6 6 9-13.5"/>
                                                </svg>
                                            </a>
                                        @endif
                                        <a class="p-1 bg-red-100 text-red-500 rounded hover:bg-red-200 transition-colors"
                                           href="">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                            </svg>
                                        </a>
                                        @endif
                                        <a class="p-1 bg-blue-100 text-blue-500 rounded hover:bg-blue-200 transition-colors"
                                           href="{{ route('ticket.view', ['ticket' => $ticket]) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                            </svg>

                                        </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>


    </div>
</x-app-layout>
