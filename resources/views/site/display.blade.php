@extends('../layouts.main')
@section('content')

    @livewire('tickets-display')

@endsection

@push('script')
    <script>

        let animations = [];

        // Livewire.hook('message.received',() => {
        //     console.log('received');
        // })

    </script>

@endpush
