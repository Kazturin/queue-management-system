@extends('../layouts.main')
@section('content')
    <div class="container m-auto h-full overflow-hidden">
        <div>
            <div class="flex items-center justify-center my-8">
                <img class="w-24 h-24 mr-4" src="{{ asset('img/logo.png') }}" alt="logo">
                <div class="">
                    <div class="text-gray-700 text-4xl font-semibold text-center">
                        Электронды кезек
                    </div>
                    <span class="text-xl">QR-код-ты сканерлеп, кезегіңізді күтіңіз</span>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-5">
                @foreach($services as $service)
                    <div class="flex justify-start flex-col border-2 border-primary-600 rounded-md">
                        <div class="p-4 bg-primary-600 text-white font-semibold text-lg uppercase"> {{$service->name}} </div>
                        <div class="mx-auto my-6">
                            <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->style('dot')->eye('circle')->merge('/public/img/logo.png')->size(200)->gradient(255, 0, 0, 0, 0, 255, 'diagonal')->margin(1)->generate(route('ticket-create',$service))) !!} ">
                        </div>
                             
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
