
{{-- Extends layout --}}
@extends('layout.default')


{{-- Content --}}
@section('content')
			<div class="container-fluid">
                <!-- row -->
                <div class="row">
					<div class="col-xl-8 col-lg-12 col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Absensi Hari Ini</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-8 col-lg-12 col-sm-12">
                                                <div class="widget-stat card bg-primary">
                                                    <div class="card-body p-4">
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
                                            <div class="col-xl-4 col-lg-12 col-sm-12">
                                                <div class="widget-stat card bg-primary">
                                                    <div class="card-body p-4">
                                                        <div class="media">
                                                            <span class="mr-3">
                                                                <i class="flaticon-381-clock"></i>
                                                            </span>
                                                            <div class="media-body text-white text-right">
                                                                <p class="mb-1">Jam</p>
                                                                <h3 class="text-white">{{$attendance->time ?? '-'}}</h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-3 col-lg-6 col-sm-6">
                                                <div class="widget-stat card bg-success">
                                                    <div class="card-body p-4">
                                                        <div class="media">
                                                            <div class="media-body text-white">
                                                                <p class="mb-1">Hadir</p>
                                                                <h3 class="text-white" id="hadir">-</h3>
                                                                <div class="progress mb-2 bg-primary">
                                                                    <div class="progress-bar progress-animated bg-light" style="width: 0%"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-6 col-sm-6">
                                                <div class="widget-stat card bg-warning">
                                                    <div class="card-body p-4">
                                                        <div class="media">
                                                            <div class="media-body text-white">
                                                                <p class="mb-1">Sakit</p>
                                                                <h3 class="text-white" id="sakit">-</h3>
                                                                <div class="progress mb-2 bg-primary">
                                                                    <div class="progress-bar progress-animated bg-light" style="width: 0%"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-6 col-sm-6">
                                                <div class="widget-stat card bg-info">
                                                    <div class="card-body p-4">
                                                        <div class="media">
                                                            <div class="media-body text-white">
                                                                <p class="mb-1">Izin</p>
                                                                <h3 class="text-white" id="izin">-</h3>
                                                                <div class="progress mb-2 bg-primary">
                                                                    <div class="progress-bar progress-animated bg-light" style="width: 0%"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-6 col-sm-6">
                                                <div class="widget-stat card bg-danger">
                                                    <div class="card-body p-4">
                                                        <div class="media">
                                                            <div class="media-body text-white">
                                                                <p class="mb-1">Absen</p>
                                                                <h3 class="text-white" id="absen">-</h3>
                                                                <div class="progress mb-2 bg-primary">
                                                                    <div class="progress-bar progress-animated bg-light" style="width: 0%"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>      
                            </div>
                            <div class="col-xl-4 col-lg-12 col-sm-12">
                                <div class="card h-auto">
                                    <div class="card-header">
                                        <h4 class="card-title">QR Code</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="col-12 text-center">
										@if(isset($attendance))
                                        {!! QrCode::size(350)->generate(Route('attendances.index') ?? null); !!}
										@endif
                                        </div>
                                    </div>
                                </div>
                            </div>
				</div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Kehadiran Terakhir</h4>
                            </div>
                            <div class="card-body">
                                <div class="row" id="last-student"></div> 
                                    <!-- <div class="col-2">
                                        <div class="card-deck">
                                        <div class="bgl-success border border-success media align-items-center p-4">
                                        <div class="text-center">
                                            <div class="profile-photo">
                                                <img src="https://chrev.dexignzone.com/laravel/demo/images/profile/profile.png" width="100" class="img-fluid rounded-circle" alt="">
                                            </div>
                                            <h3 class="mt-2 mb-0">Deangelo Sena</h3>
                                            <p class="text-muted">Senior Manager</p>
                                            <a class="btn btn-success btn-rounded text-white px-5">07:30</a>
                                        </div>
                                        </div>
                                        </div>
                                    </div> -->
                                    
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
                            '<div class="col-xl-2 col-lg-6 col-sm-6">' +
                            '<div class="bgl-success border border-success mb-3 p-3">' +
                            '<div class="text-center">' +
                            '<div class="profile-photo">' +
                            '<img src="/storage/'+value['image']+'" width="100" class="img-fluid rounded-circle" alt="">' +
                            '</div>' +
                            '<h4 class="mt-4 mb-0">' + value['name'] + '</h4>' +
                            '<p class="text-muted">' + value['nis'] + '</p>' +
                            // '<a class="btn btn-success btn-rounded text-white p-2">'+ value['time_in'] +'</a>' +
                            '</div>' +
                            '</div>' +
                            '</div>'
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
            }, error: function () {
                console.log(data);
            }
        });
        };
    setInterval(request, 1000);
    });
</script>
@endsection

                            