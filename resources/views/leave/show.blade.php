{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')
			<div class="container-fluid">
                <div class="page-titles">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{route('leaves.index')}}">Permohonan</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0)">Detail</a></li>
					</ol>
                </div>
                <!-- row -->
                <div class="row">
					<div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Detail Perizinan</h4>
                            </div>
                            <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="right-box-padding">
                                                <div class="read-content">
                                                <h5 class="text"> Dikirim : {{Carbon\Carbon::parse($leave->date)->translatedFormat('l, d F Y')}}</h5>
                                                <hr>
                                                    <div class="media pt-3">
                                                        @if($leave->image)
                                                            <img class="mr-2 rounded" width="80" height="80" alt="image" src="{{ asset('storage/'.$leave->student->user->image) }}"> 
                                                        @else
                                                            <img class="mr-2 rounded" width="80" height="80" alt="image" src="{{ asset('storage/avatar.png') }}">
                                                        @endif
														<div class="media-body mr-2">
															<h5 class="text-primary mb-0 mt-1">{{$leave->name}}</h5>
															<p class="mb-0">{{$leave->nis}}</p>
															<h6 class="mb-0">{{$leave->classroom_grade}} {{$leave->classroom_name}}</h6>
														</div>
                                                        @if($leave->status == 1)
														<a href="{{route('leaves.update', [$leave->id])}}" id="acc" class="btn btn-success px-3" onclick="event.preventDefault(); document.getElementById('submit-acc').submit();"><i class="fa fa-check"></i></a>
									    				<a href="{{route('leaves.update', [$leave->id])}}" id="nacc" class="btn btn-danger px-3 ml-2" onclick="event.preventDefault(); document.getElementById('submit-noacc').submit();"><i class="fa fa-times"></i> </a>
                                                        <form id="submit-acc" method="POST" class="hidden">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="2">
                                                        </form>
                                                        <form id="submit-noacc" method="POST" class="hidden">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="3">
                                                        </form>
                                                        @elseif($leave->status == 2)
                                                        <a href="javascript:void(0)" class="btn btn-success px-3 ml-2"><i class="fa fa-check"></i> Disetujui</a>
                                                        @else
                                                        <a href="javascript:void(0)" class="btn btn-danger px-3 ml-2"><i class="fa fa-check"></i> Ditolak</a>
                                                        @endif
                                                    </div>
                                                    <hr>
                                                    <div class="media-body">
                                                        <h4>Keterangan : {!!$config_type[$leave->type]!!}</h4>
                                                        <ul class="list-icons">
                                                        @foreach($dates as $date)
                                                            <li><span class="align-middle mr-2"><i class="fa fa-chevron-right"></i></span>{{Carbon\Carbon::parse($date->date)->translatedFormat('l, d F Y')}}</li>
                                                        @endforeach
                                                        </ul>   
                                                    </div>
                                                    <hr>
                                                    <div class="media mb-2 mt-3">
                                                        <div class="media-body">
                                                            <h3 class="my-1 text-primary">{{$leave->title}}</h3>
                                                        </div>
                                                    </div>
                                                    <div class="read-content-body">
                                                        <p>{{$leave->desc}}</p>
                                                        <hr>
                                                    </div>
                                                    <div class="read-content-attachment">
                                                        <h6><i class="fa fa-download mb-2"></i>Attachment</h6>
                                                        <div class="row attachment">
                                                            <a href="{{ url('/storage/'.$leave->attachment) }}"><button type="button" class="btn btn-rounded btn-success mt-2"><span class="btn-icon-left text-success"><i class="fa fa-search color-success"></i></span>Lihat Lampiran</button></a>
                                                            <!-- <div class="col-6">
                                                                <iframe src="{{ asset('storage/'.$leave->attachment) }}" seamless height="1000" width="100%" frameborder="0" scrolling="auto"></iframe>
                                                            </div>        -->
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
            </div>
			
@endsection