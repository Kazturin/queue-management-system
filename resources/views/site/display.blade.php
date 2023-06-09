@extends('../layouts.main')
@section('content')
 <div class="text-gray-700 text-2xl text-center my-10">
     Электронный очередь
 </div>
<table>
    <tr>
        <th>Талон</th>
        <th>Оператор</th>
    </tr>
    @foreach($tickets as $ticket)
        <tr>
            <th>{{ $ticket['number'] }}</th>
            <th>{{ $ticket['operator']['number'] }}</th>
        </tr>
    @endforeach
</table>
@endsection
@vite('resources/js/ticket-updated-listener.js')
{{--@push('script')--}}
{{--    <script>--}}
{{--        const channel = Echo.channel('public.test.1');--}}

{{--        channel.subscribed(()=>{--}}
{{--            console.log('subscribed')--}}
{{--        }).listen('.test',(event)=>{--}}
{{--            console.log(event);--}}
{{--            console.log('ok');--}}
{{--        });--}}
{{--    </script>--}}

{{--@endpush--}}
