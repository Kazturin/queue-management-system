<x-filament::page>
    <div class="flex">
        <button {{ $this->invitation ? 'disabled' : null }} wire:click="getTicket" class="p-4 bg-primary-600 rounded-md text-2xl  text-white mr-4 shadow-md disabled:cursor-not-allowed">
            Шақыру
        </button>
        @if($this->ticket)
            <div class="flex">
                <div class="p-4 border-2 border-primary-700 bg-white rounded-md text-2xl text-primary-700 mr-4 shadow-md text-center leading-normal">
                    <div>Қазіргі талон</div>
                    <div>{{ $this->ticket->number }}</div>
                </div>
                <button wire:click="closeTicket" class="p-4 bg-red-500 rounded-md text-2xl text-white mr-4 shadow-md disabled:bg-sky-300">
                    Аяқтау
                </button>
            </div>
        @endif
    </div>

    <div>
        <div class="w-full overflow-hidden rounded-lg shadow-lg border-t mb-4">
            <div class="w-full overflow-x-auto mt-4">

                <table class="w-full whitespace-no-wrap">
                    <thead>
                    <tr
                        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                    >
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Номер</th>
                        <th class="px-4 py-3">Услуга</th>
                        <th class="px-4 py-3">Дата</th>
                    </tr>
                    </thead>
                    <tbody
                        class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                    >
                    @foreach($this->tickets as $item)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 text-sm">
                                {{$loop->index+1}}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{$item['number']}}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{$item->service->name}}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{$item['created_at']}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <div>
        Шақырылған талондар саны: {{ $ticketsCount }}
    </div>

    @push('scripts')
        @vite('resources/js/pusher.js')
        <script type="module">

            const channel = Echo.channel('public.ticket.created');
            channel.subscribed(()=>{
                console.log('subscribed channel')
            }).listen('.ticketCreated',(event)=>{
                console.log('ok');
                Livewire.emit('recordUpdated');
            });
        </script>

    @endpush

</x-filament::page>
