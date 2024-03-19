<x-app-layout>
    <x-slot name="extraAssets">
        @vite('resources/css/create-ticket.css')
        <script src="https://cdn.tiny.cloud/1/udr6l895o661kj8pin6lbzikgi4ft58bdjay3eq0lxnf6s9s/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
        <script>
            tinymce.init({
                selector: '#description'
            });
        </script>
    </x-slot>

    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('ticket.create.title') }}
            </h2>
        </div>

    </x-slot>

    <div class="py-12 sm:flex justify-center">

        <div class="sm:w-2/5 sm:px-4 md:w-1/2">
            <div class="bg-white overflow-hidden shadow-sm rounded shadow">
                <div class="p-6 text-gray-900">
                    <h2 class="mb-2">{{ __('ticket.create.title') }}</h2>
                        <form method="post" action="{{ route('ticket.store') }}">
                            <input type="hidden" id="temp-ticket-id" name="temp_ticket_id" value="{{ $tempTicketId }}">
                            @csrf
                            <div>
                                <x-input-label for="title" :value="__('ticket.create.form.title')"/>
                                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title"
                                              :value="old('title')" required autofocus autocomplete="title"/>
                                <x-input-error :messages="$errors->get('title')" class="mt-2"/>
                            </div>
                            <div class="mt-4">
                                <x-input-label for="ticket_category_id" :value="__('ticket.create.form.category')"/>
                                <select name="ticket_category_id" id="ticket_category_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                                    <option value="">{{ __('ticket.create.form.select.default') }}</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('category')" class="mt-2"/>
                            </div>
                            <div class="mt-4">
                                <x-input-label for="description" :value="__('ticket.create.form.description')"/>
                                <x-text-area name="description" id="description" cols="30" rows="10"></x-text-area>
                                <x-input-error :messages="$errors->get('description')" class="mt-2"/>
                            </div>
                            <button class="btn bg-green-500 mt-3">{{ __('ticket.create.form.create-button') }}</button>
                        </form>
                </div>
            </div>
        </div>
        <div class="sm:w-1/5 sm:px-4">
            <div class="bg-white overflow-hidden shadow-sm rounded shadow">
                <div class="p-6 text-gray-900">
                    <h2 class="mb-2">{{ __('ticket.create.media.title') }}</h2>
                    <form action="{{ route('ticket-attachment.store') }}" class="dropzone" id="ticket-attachment-dropzone">
                        @csrf
                        <div class="dz-message" data-dz-message>
                            <span>{{ __('ticket.create.media.dropzone.text') }}</span>
                        </div>
                    </form>

                    <div id="fileList" class="file-list">
                        <!-- Uploaded files will be displayed here -->
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>

@vite('resources/js/create-ticket.js')


