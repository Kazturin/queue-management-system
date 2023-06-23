<div>

{{--        <div>--}}
{{--            <button wire:click="requestPermission">Request Notification Permission</button>--}}
{{--        </div>--}}
        <div
           {{ $ticket->operator_id==null? 'wire:poll.5000ms.keep-alive':''}}
            class="h-screen flex flex-col justify-center items-center {{ $ticket?->operator_id?'bg-green-200':'' }}"
        >
            <div class="flex items-center my-4 border-b pb-4">
                <img class="w-10 h-10 mr-4" src="{{ asset('img/logo.png') }}" alt="logo">
                <div class="text-gray-700 text-2xl text-center">
                    Электронды кезек
                </div>
            </div>
            @if($ticket)
                <div>
                    <div class="text-center border-b p-2">
                        <div class="text-xl mb-2">Сіздің талон:</div>
                        <div class="text-5xl font-semibold">{{ $ticket->number }}</div>
                        <div>
                            {{ $ticket->service->name }}
                        </div>
                    </div>
                    <div class="text-center p-2">
                        <div class="text-xl">Сіздің алдыңызда:</div>
                        <div class="text-3xl font-semibold">{{ $count }} талон</div>
                    </div>
                    @if($ticket->operator_id==null)
                    <form method="POST" onsubmit="return confirm('Талонды өшіру?');">
                        @csrf
                        <div class="text-center">
                            <input type="hidden" name="id" value="{{ $ticket->id }}">
                            <button id="delete-btn" onclick="this.closest('form').submit();"
                                    class="bg-red-500 text-white rounded-md my-4 p-2">Кезектен шығу</button>
                        </div>
                    </form>
                    @else
                        <div wire:init="checkTicketStatus" class="text-green-500 text-xl font-semibold">
                            Сізді {{ $ticket->operator->number }} - үстелге шақырды
                        </div>
                    @endif
                </div>
            @else
                <div class="text-center text-2xl">
                    Талон өшірілді немесе табылмады ...
                </div>
            @endif
            <div class="text-center">
                {{ $ticket->created_at }}
            </div>
        </div>

</div>
@push('scripts')
<script>
    if ('serviceWorker' in navigator) {

        navigator.serviceWorker
            .register('/sw.js')
    }

    Notification.requestPermission();

    // document.addEventListener("DOMContentLoaded", () => {
    //    // Livewire.emit('disconnectedd');
    //    // console.log('test 1')
    //     Livewire.hook('message.failed', (message, component) => {
    //         console.log('failed');
    //         Livewire.emit('disconnectedd');
    //     })
    //
    //     // Livewire.hook('element.updated', (el, component) => {
    //     //     console.log('test');
    //     // })
    //
    // });

    document.addEventListener("showNotification", function (e) {
console.log('test');
            if (Notification.permission === 'granted') {
               navigator.serviceWorker.ready.then(function(registration) {
                   registration.showNotification(e.detail.title, e.detail.options);
               });
            }
    });
</script>
@endpush
