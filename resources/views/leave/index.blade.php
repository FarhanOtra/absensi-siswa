{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')
			<div class="container-fluid">
                <div class="page-titles">
					<ol class="breadcrumb">
						<li class="breadcrumb-item active"><a href="javascript:void(0)">Permohonan</a></li>
					</ol>
                </div>
                <!-- row -->
                <div class="row">
					<div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Daftar Permohonan</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example3" class="display min-w850" width="100%">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Dikirim Tanggal</th>
                                                <th>NIS</th>
                                                <th>Nama</th>
                                                <th>Kelas</th>
                                                <th>Jenis</th>
                                                <th>Dari Tanggal</th>
                                                <th>Sampai Tanggal</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($leaves as $leave)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{Carbon\Carbon::parse($leave->created_at)->translatedFormat('l, d F Y')}}</td>
                                                <td>{{$leave->nis}}</td>
                                                <td>{{$leave->name}}</td>
                                                <td>{{$leave->classroom_grade}} {{$leave->classroom_name}}</td>
                                                <td>{!!$config_type[$leave->type]!!}</td>
                                                <td>{{Carbon\Carbon::parse($leave->date_start)->translatedFormat('d F Y')}}</td>
                                                <td>{{Carbon\Carbon::parse($leave->date_end)->translatedFormat('d F Y')}}</td>
                                                <td>{!!$config_status[$leave->status]!!}</td>
                                                <td>
													<div class="d-flex">
														<a href="{{ route('leaves.show',[$leave->id])}}" class="btn btn-info shadow btn-md mr-1"><i class="fa fa-search"></i></a>
													</div>												
												</td>	
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
            </div>
			
@endsection