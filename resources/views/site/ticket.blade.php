@extends('../layouts.main')
@section('content')
{{--    <livewire:ticket-display />--}}
    @livewire('ticket-display', ['ticket_key' => $key])
@endsection
{{--@vite('resources/js/ticket-created-listener.js')--}}

