@extends('../layouts.main')
@section('content')

    @livewire('tickets-display')

@endsection

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
