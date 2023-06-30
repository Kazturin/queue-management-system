@extends('../layouts.main')
@section('content')
    <div class="container mx-auto mt-8">
        <div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                @foreach($services as $service)
                    <div>
                        <button  onclick="savePdf({{ $service->id }},`{{ $service->name }}`)" class="btn btn-info d-block ml-2 text-right ml-16">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16"> <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/> <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/> </svg>
                        </button>
                        <div id="{{'qr'. $service->id}}">
                            <div class="flex flex-col max-w-sm border-2 border-primary-600 mx-auto rounded-md">

                                <div class="p-4 bg-primary-600 text-white font-semibold text-lg uppercase"> {{$service->name}} </div>
                                <div class="mx-auto my-6 p-8">
                                    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->style('dot')->eye('circle')->merge('/public/img/logo.png')->size(400)->gradient(255, 0, 0, 0, 0, 255, 'diagonal')->margin(1)->generate(route('ticket-create',$service))) !!} ">
                                </div>
                                {{--                            <a href="{{ route('ticket-create',$service) }}" target="_blank">Go</a>--}}

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('headScript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>
{{--    <script src="/js/js-pdf.js"></script>--}}
    <script src="/js/html2canvas.min.js"></script>
    <script src="/js/jspdf-html2canvas.min.js"></script>
    <script>
            function savePdf(id,name){
                console.log(document.querySelector("#qr2"));
                    html2canvas(document.getElementById("qr"+id),{
                        scale: 4,
                        allowTaint: true,
                        useCORS: true,
                        scrollY: -window.scrollY,
                    }).then(function (canvas) {
                        console.log('test');
                        const image = canvas.toDataURL('image/jpeg', 1.0);
                        const doc = new jsPDF('p', 'px', 'a4');
                        const pageWidth = doc.internal.pageSize.getWidth();
                        const pageHeight = doc.internal.pageSize.getHeight();

                        const widthRatio = pageWidth / canvas.width;
                        const heightRatio = pageHeight / canvas.height;
                        const ratio = widthRatio > heightRatio ? heightRatio : widthRatio;

                        const canvasWidth = canvas.width * ratio;
                        const canvasHeight = canvas.height * ratio;

                        const marginX = (pageWidth - canvasWidth) / 2;
                        const marginY = (pageHeight - canvasHeight) / 2;

                        doc.addImage(image, 'JPEG', 0, marginY, canvasWidth, canvasHeight);
                        //doc.output('dataurlnewwindow');
                        doc.save('QR '+name+`.pdf`);
                    });
        }

    </script>
@endpush
