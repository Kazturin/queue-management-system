<div class="h-full">
    <audio class="hidden" src="/notify.mp3" id="audio"></audio>
    @if($connection==false)
        <div class="p-2 bg-red-500 text-white">
            Байланыс жоқ
        </div>
    @endif
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
                    <div class="text-7xl font-russoOne">
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
                <thead class="bg-strong-blue text-white text-4xl">
                <tr class="text-center uppercase text-5xl">
                    <th class="border-white border-r-8 py-6 px-5 tracking-widest">
                        Талон
                    </th>
                    <th class="py-6 px-5 tracking-widest">
                        Терезе
                    </th>
                </tr>
                </thead>
                <tbody class="bg-light-blue text-5xl">
                @if(count($tickets)>0)
                    @foreach(array_splice($tickets, 1 ) as $value)
                        <tr animate-move wire:key="{{ $value['id'] }}" class="text-center">
                            <td class="w-1/3 py-3 px-4 border-white border-r-8">{{ $value['number']}}</td>
                            <td class="w-1/3 py-3 px-4">
                                {{ $value['operator']['number']}}
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
    @vite('resources/js/pusher.js')
    <script type="module">

        const channel = Echo.channel('public.test.updated');

      //  var audio = new Audio('/notify.mp3');
      //  audio.muted = true;
        var audio = document.getElementById("audio");
        channel.subscribed(()=>{
            console.log('subscribed channel')
            Livewire.emit('connected');
          console.log(t);
        }).listen('.updated',(event)=>{
            Livewire.emit('recordUpdated');
            audio.play();
        });

        Echo.connector.pusher.connection.bind('error', () => {
            console.log('error');
            Livewire.emit('disconnected');
        });

        let animations =[];

        Livewire.hook('message.received',() => {
            let list = Array.from(document.querySelectorAll('[animate-move]'));

            animations = list.map(item => {
              let oldTop = item.getBoundingClientRect().top;

              return () => {
                  let newTop = item.getBoundingClientRect().top;

                  item.animate([
                      { transform: `translateY(${oldTop - newTop}px)` },
                      { transform: 'translateX(0px)'}
                  ], { duration: 1000, easing: 'ease'})
              }
            });
            list.forEach(item => {
                item.getAnimations().forEach(animation => animation.finish())
            })
        })

        Livewire.hook('message.processed', ()=>{
            while (animations.length){
                animations.shift()()
            }
        })
    </script>

@endpush
