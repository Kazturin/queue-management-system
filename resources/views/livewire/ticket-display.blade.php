<div>
    @if($connection==false)
        <div class="p-2 bg-red-500 text-white">
            Байланыс жоқ
        </div>
    @endif
        <div>
            <button wire:click="requestNotificationPermission">Request Notification Permission</button>
        </div>
        <div
            wire:poll.5000ms.keep-alive
            class="h-screen flex flex-col justify-center items-center {{ $ticket?->operator_id?'bg-green-200':'' }}"
        >
            <div> @error('name'){{ $message }}@enderror </div>
            <div class="flex items-center my-4 border-b pb-4">
                <img class="w-10 h-10 mr-4" src="{{ asset('img/logo.png') }}" alt="logo">
                <div class="text-gray-700 text-2xl text-center">
                    Электронды кезек
                </div>
            </div>
            @if($ticket)
                <div>
                    <div class="text-center border-b p-2">
                        <div class="text-xl">Сіздің талон:</div>
                        <div class="text-5xl font-semibold">{{ $ticket->number }}</div>
                    </div>
                    <div class="text-center p-2">
                        <div class="text-xl">Сіздің алдыңызда:</div>
                        <div class="text-3xl font-semibold">{{ $count }} талон</div>
                    </div>
                    <form method="POST" onsubmit="return confirm('Талонды өшіру?');">
                        @csrf
                        <div class="text-center">
                            <input type="hidden" name="id" value="{{ $ticket->id }}">
                            <button id="delete-btn" onclick="this.closest('form').submit();"
                                    class="bg-red-500 text-white rounded-md my-4 p-2">Кезектен шығу</button>
                        </div>
                    </form>
                    @if($ticket->operator_id)
                        <div class="text-green-500 text-xl font-semibold">
                            Сізді {{ $ticket->operator->number }} - оператор күтіп отыр
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

<script>
    document.addEventListener("DOMContentLoaded", () => {

        Livewire.hook('message.failed', (message, component) => {
            console.log('test');
            Livewire.emit('disconnected');
        })
        // Livewire.hook('message.failed', (message, component) => {
        //     console.log('test');
        //     Livewire.emit('disconnected');
        // })
        //
        // Livewire.hook('element.updated', (el, component) => {
        //     console.log('test');
        // })

    });

    // document.addEventListener("livewire:load", function () {
    //     Livewire.on('showNotification', function (data) {
    //         console.log('data');
    //         if (Notification.permission === 'granted') {
    //             new Notification(data.title, data.options);
    //         }
    //     });
    // });
</script>
