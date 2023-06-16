@extends('../layouts.main')
@section('content')
    <div class="container mx-auto">
        <div class="flex items-center justify-center my-8">
            <img class="w-10 h-10 mr-4" src="{{ asset('img/logo.png') }}" alt="logo">
            <div class="">
                <div class="text-gray-700 text-2xl text-center">
                    Электронды кезек
                </div>
                <span>QR-код-ты сканерлеп, кезегіңізді күтіңіз</span>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-4 2xl:grid-cols-5">
            @foreach($services as $service)
                <div class="flex justify-center flex-col border-2 border-primary-500 rounded-md">
                    <div class="p-4 bg-primary-500 text-white font-semibold text-xl"> {{$service->name}} </div>
                    <div class="mx-auto my-6">
                        {!! QrCode::size(200)->style('round')->generate(route('ticket-create',$service)) !!}
                    </div>
                    <a href="{{ route('ticket-create',$service) }}" target="_blank">Go</a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
