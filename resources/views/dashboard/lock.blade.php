<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ config('dz.name') }} | @yield('title', $page_title ?? '')</title>

	<meta name="description" content=""/>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon.png') }}">
	
	@if(!empty(config('dz.public.pagelevel.css.'.$action))) 
		@foreach(config('dz.public.pagelevel.css.'.$action) as $style)
				<link href="{{ asset($style) }}" rel="stylesheet" type="text/css"/>
		@endforeach
	@endif	

	{{-- Global Theme Styles (used by all pages) --}}
	@if(!empty(config('dz.public.global.css'))) 
		@foreach(config('dz.public.global.css') as $style)
			<link href="{{ asset($style) }}" rel="stylesheet" type="text/css"/>
		@endforeach
	@endif	

</head>

<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">
        <!--**********************************
            Content body start
        ***********************************-->
        <div class="body">
            <!-- row -->
            <div class="container-fluid">
                <!-- row -->
                <div class="row mt-2">
                    <div class="col-xl-12 col-lg-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"></h4>
                                <div class="nav-header">
                                    <a href="" class="brand-logo">
                                        <img class="logo-abbr" src="{{ asset('images/logo.png') }}" alt="">
                                        <img class="brand-title" src="{{ asset('images/logo-text.png') }}" alt="">
                                    </a>
                                </div>
                                <div class="text-right">
                                    <div class="form-group col-md-12">
                                        <div class="basic-form">
                                            <form method="post" class="form-valide" action="{{ Route('unlock') }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="input-group mb-2">
                                                <input type="password" name="password" class="form-control" placeholder="Password">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="submit">Unlock</button>
                                                </div>
                                            </div>
                                             @error('password')
                                                <span class="text-danger"><small>{{$message}}</small></span>
                                            @enderror
                                            </form>
                                        </div>    
                                    </div>   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>       
                <div class="row">
                    <div class="col-xl-4 col-lg-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Absensi Hari Ini</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="widget-stat card bg-primary">
                                            <div class="card-body p-3">
                                                <div class="media">
                                                    <span class="mr-3">
                                                        <i class="flaticon-381-calendar-1"></i>
                                                    </span>
                                                <div class="media-body text-white text-right">
                                                    <p class="mb-1">Tanggal</p>
                                                    @if(isset($attendance->date))
                                                    <h3 class="text-white">{{Carbon\Carbon::parse($attendance->date)->translatedFormat('l, d F Y')}}</h3>
                                                    @else
                                                    <h3 class="text-white">Belum Ada Absensi Hari Ini</h3>
                                                    @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-12 col-sm-12">
                                        <div class="widget-stat card bg-primary">
                                             <div class="card-body p-3">
                                                <div class="media">
                                                    <span class="mr-3">
                                                        <i class="flaticon-381-clock"></i>
                                                    </span>
                                                    <div class="media-body text-white text-right">
                                                        <p class="mb-1">Jam Masuk</p>
                                                        @if(isset($attendance->time))
                                                        <h3 class="text-white">{{Carbon\Carbon::parse($attendance->time)->translatedFormat('H:i')}}</h3>
                                                        @else
                                                        <h3 class="text-white">-</h3>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-12 col-sm-12">
                                        <div class="widget-stat card bg-danger">
                                             <div class="card-body p-3">
                                                <div class="media">
                                                    <span class="mr-3">
                                                        <i class="flaticon-381-stopclock"></i>
                                                    </span>
                                                    <div class="media-body text-white text-right">
                                                        <p class="mb-1">Batas Waktu</p>
                                                        @if(isset($attendance->time_limit))
                                                        <h3 class="text-white">{{Carbon\Carbon::parse($attendance->time_limit)->translatedFormat('H:i')}}</h3>
                                                        @else
                                                        <h3 class="text-white">-</h3>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                <h4 class="card-title">Status Kehadiran</h4>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="text-success">HADIR</h6>
                                            <span id="hadir"></span>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar bg-success" style="width: {{ number_format($hadir / $students * 100,2) }}%"></div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-4">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="text-warning">SAKIT</h6>
                                            <span id="sakit"></span>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar bg-warning" style="width: {{ number_format($sakit / $students * 100,2) }}%"></div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-4">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="text-info">IZIN</h6>
                                            <span id="izin"></span>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar bg-info" style="width: {{ number_format($izin / $students * 100,2) }}%"></div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-4">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="text-danger">BELUM DATANG</h6>
                                            <span id="absen"></span>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar bg-danger" style="width: {{ number_format($absen / $students * 100,2) }}%"></div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-4">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="text-black">BOLOS</h6>
                                            <span id="bolos"></span>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar bg-dark" style="width: {{ number_format($bolos / $students * 100,2) }}%"></div>
                                        </div>
                                    </div>    
                                </div>
                            </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-12 col-sm-12">
                        <div class="col-xl-12 col-lg-12 col-sm-12">
                            <div class="card h-auto">
                                <div class="card-header">
                                    <h4 class="card-title">QR Code</h4> 
                                </div>
                                <div class="card-body">
                                    <div class="col-12 text-center p-5">
									@if(isset($attendance))
                                    {!! QrCode::size(350)->generate($attendance->id ?? null); !!}
									@endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(isset($attendance))
                        <div class="col-xl-12 col-lg-12 col-sm-12">
                            <div class="card h-auto">
                                <div class="card-header">
                                    <h4 class="card-title text-center">Presensi </h4>
                                </div>
                                <div class="card-body">
                                    <div class="col-12">
                                        <div class="form-group col-md-12">
                                            <div class="basic-form">
                                                <form method="post" class="form-valide" action="{{ Route('student-attendances.store') }}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="input-group mb-3">
                                                    <input type="number" name="nis" class="form-control" placeholder="NIS">
                                                    <input type="hidden" name="id" value="{{$attendance->id}}">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-success" type="submit">Hadir</button>
                                                    </div>
                                                </div>
                                                @error('nis')
                                                    <span class="text-danger"><small>{{$message}}</small></span>
                                                @enderror
                                                </form>
                                            </div>    
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Kehadiran Terakhir</h4>
                            </div>
                            <div class="card-body">
                                <div id="DZ_W_Todo1" class="widget-media dz-scroll">
                                    <ul class="timeline" id="last-student"></ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script src="https://code.jquery.com/jquery-3.6.1.slim.js" integrity="sha256-tXm+sa1uzsbFnbXt8GJqsgi2Tw+m4BLGDof6eUPjbtk=" crossorigin="anonymous"></script>
            <script>
                $(document).ready(function () {
                var lastId = 0; //Set id to 0 so you will get all records on page load.
                var request = function () {
                    $.ajax({
                        type: 'get',
                        url: "{{ route('data') }}",
                        data: { id: lastId }, //Add request data
                        dataType: 'json',
                        success: function (data) {        
                            $("#last-student").empty();
                            $.each(data, function () {
                                $.each(this, function (index, value) {
                                    console.log(value);
                                    lastId = value.user_id; //Change lastId when we get responce from ajax
                                    if(value['image']==null){
                                        value['image'] = 'avatar.png';
                                    };
                                    $('#last-student').append(
                                        '<li>' +
                                        '<div class="timeline-panel">' +
                                        '<div class="media mr-2">' +
                                        '<img alt="image" width="50" src="/storage/'+value['image']+'">' +
                                        '</div>' +
                                        '<div class="media-body">' +
                                        '<h5 class="mb-1">' + value['name'] + '<small class="text-muted"> ' + value['nis'] + '</small></h5>' +
                                        '<small class="d-block">'+ value['time_in'] +'</small>' +
                                        '</div>' +
                                        '</div>' +
                                        '</li>'
                                    );
                                });
                            });
                        }, error: function () {
                            console.log(data);
                        }
                    });
                    };
                setInterval(request, 1000);
                });
            </script>
            <script>
                $(document).ready(function () {
                var lastId = 0; //Set id to 0 so you will get all records on page load.
                var request = function () {
                    $.ajax({
                        type: 'get',
                        url: "{{ route('stat') }}",
                        data: { id: lastId }, //Add request data
                        dataType: 'json',
                        success: function (data) {        
                            $("#hadir").html(data.hadir);
                            $("#sakit").html(data.sakit);
                            $("#izin").html(data.izin);
                            $("#absen").html(data.absen);
                            $("#bolos").html(data.bolos);
                        }, error: function () {
                            console.log(data);
                        }
                    });
                    };
                setInterval(request, 1000);
                });
            </script>
            @include('sweetalert::alert')
        </div>
        <!--**********************************
            Content body end
        ***********************************-->


        <!--**********************************
            Footer start
        ***********************************-->
        
		@include('elements.footer')
		
        <!--**********************************
            Footer end
        ***********************************-->

		<!--**********************************
           Support ticket button start
        ***********************************-->

        <!--**********************************
           Support ticket button end
        ***********************************-->


    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
	@include('elements.footer-scripts')
</body>
</html>

                            