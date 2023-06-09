<div
    wire:poll.5000ms.keep-alive
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
            <div class="text-center">
                <div class="text-xl">Сіздің талон:</div>
                <div class="text-5xl font-semibold">{{ $ticket->number }}</div>
            </div>
            <div class="text-center">
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
</div>
