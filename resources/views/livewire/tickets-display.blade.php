<div class="grid grid-cols-2 h-full">
    <div class="flex flex-col">
        <div class="flex justify-between items-center px-8 py-4">
            <div class="flex align-center p-5">
                <img src="/img/logo.png" class="w-28" alt="logo">
            </div>
            <div class="text-2xl px-5">
                <img src="/img/logo-text.png" class="w-60" alt="logo-text">
            </div>
        </div>
        <div class="flex flex-col flex-1 items-center justify-center text-gray-100 text-5xl uppercase">

            @if($tickets)
                <div class="text-8xl font-russoOne">
                    {{ $test }}
                    <div class="text-center">
                        <div class="bg-light-blue text-white py-3 px-28 rounded-lg">Талон</div>
                        <div>
                            <div class="text-9xl text-light-blue m-4">{{ $tickets[0]['number'] }}</div>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="bg-light-blue text-white py-3 px-28 rounded-lg">Терезе</div>
                        <div>
                            <div class="text-9xl text-light-blue m-4">{{ $tickets[0]['operator']['number'] }}</div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-strong-blue">
                    ...
                </div>
            @endif
        </div>
    </div>
    <div class="flex-1">
        <table class="h-full min-w-full text-white font-russoOne bg-gray-300">
            <thead class="bg-strong-blue text-white text-5xl">
            <tr class="text-center uppercase text-5xl">
                <th class="border-white border-r-8 py-10 px-5 tracking-widest">
                    Талон
                </th>
                <th class="py-10 px-5 tracking-widest">
                    Терезе
                </th>
            </tr>
            </thead>
            <tbody class="bg-light-blue text-5xl">
            @foreach($tickets as $key => $value)
                <tr class="text-center">
                    <td class="w-1/3 py-3 px-4 border-white border-r-8">{{ $tickets[$key]['number']}}</td>
                    <td class="w-1/3 py-3 px-4">
                        {{ $tickets[$key]['operator']['number']}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@push('scripts')
    @vite('resources/js/pusher.js')
    <script type="module">

        const channel = Echo.channel('public.test.updated');

        var audio = new Audio('/notify.mp3');

        channel.subscribed(()=>{
            console.log('subscribed channel')
        }).listen('.updated',(event)=>{
            console.log('ok');
            Livewire.emit('recordUpdated');
            audio.play();
        });
    </script>

@endpush
