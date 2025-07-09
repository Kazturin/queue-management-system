@extends('../layouts.main')
@section('content')
    <div class="container m-auto h-full overflow-hidden">
        <div>
            <div class="text-center my-8">
                <img class="w-40 lg:w-56 mx-auto" src="{{ asset('logo.webp') }}" alt="logo">
                <div class="">
                    <div class="text-gray-700 text-4xl font-semibold text-center">
                        Электронды кезек
                    </div>
                    <span class="text-xl">QR-код-ты сканерлеп, кезегіңізді күтіңіз</span>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-5">
                <div class="flex justify-start flex-col border-2 border-sky-600 rounded-md">
                    <div class="p-4 bg-sky-600 text-white font-semibold text-lg uppercase"> Телеграм-бот для помощи абитуриентам </div>
                    <div class="mx-auto my-6">
                        <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->style('dot')->eye('circle')->merge('/public/img/telegram.png')->size(200)->margin(1)->generate('https://t.me/ShakarimAdmissionBot')) !!} ">
                        {{--                            {!! QrCode::size(200)->generate(Request::url(route('ticket-create',$service))); !!}--}}
                    </div>
                    {{--                        <a href="{{ route('ticket-create',['service'=>$service])}}" target="_blank">go</a>--}}
                </div>
                @foreach($services as $service)
                    <div class="flex justify-start flex-col border-2 border-primary-600 rounded-md">
                        <div class="p-4 bg-primary-600 text-white font-semibold text-lg uppercase"> {{$service->name}} </div>
                        <div class="mx-auto my-6">
                            <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->style('dot')->eye('circle')->size(200)->margin(1)->generate(route('ticket-create',$service))) !!} ">
{{--                            {!! QrCode::size(200)->generate(Request::url(route('ticket-create',$service))); !!}--}}
                        </div>
{{--                        <a href="{{ route('ticket-create',['service'=>$service])}}" target="_blank">go</a>--}}
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
