<x-filament::page>
    <div class="flex">
        @if($this->testBool)
        <button id="btn" {{ $this->invitation ? 'disabled' : null }} wire:click="getTicket" class="p-4 bg-primary-600 rounded-md text-2xl  text-white mr-4 shadow-md disabled:cursor-not-allowed disabled:bg-primary-300">
            Шақыру
        </button>
        @else
            <div id="btn"  class="py-4 px-8 bg-pink-500 rounded-md text-2xl  text-white mr-4 shadow-md cursor-default">
                Test
            </div>
        @endif
        @if($this->ticket)
            <div class="flex transition-all duration-200 ease-in-out">
                <div class="p-2 border-2 border-primary-700 bg-white rounded-md text-2xl text-primary-700 mr-4 shadow-md text-center leading-normal">
                    <div>Қазіргі талон: {{ $this->ticket->number }} </div>
                </div>
                <button wire:click="closeTicket" class="p-2 bg-red-500 rounded-md text-2xl text-white mr-4 shadow-md disabled:bg-sky-300">
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
                        <th class="px-4 py-3">Талон</th>
                        <th class="px-4 py-3">{{ __('Subject') }}</th>
                        <th class="px-4 py-3">{{ __('Date') }}</th>
                    </tr>
                    </thead>
                    <tbody id="body"
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
        <script src="/js/notification.js"></script>

        @vite(['resources/js/pusher.js'])
        <script type="module">

            window.Notifi.requestPermission();

            var allowIds = @json($allowServicesIds);
            const channel = Echo.private('private.ticket.created');
            const channel2 = Echo.channel('public.test.updated');
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker
                    .register('/sw.js')
            }
            let list = document.getElementById("body");
            let btn = document.getElementById('btn');
            channel.subscribed(()=>{
                console.log('subscribed channel')
            }).listen('.ticketCreated',(event)=>{
                if (allowIds.includes(event.ticket.service_id)){
                    Livewire.emit('recordUpdated');
                }
                if (list.childElementCount===0 && !btn.hasAttribute('disabled')){
                    if (window.Notifi.permission === "granted") {
                         new window.Notifi("Электронды кезек",{ body:"Жаңа талон"});
                    }
                }
            });

            channel2.subscribed(()=>{
                console.log('subscribed channel2')
            }).listen('.updated',(event)=>{
                if (allowIds.includes(event.ticket.service_id)){
                    Livewire.emit('recordUpdated');
                }
            });
        </script>

    @endpush

</x-filament::page>
