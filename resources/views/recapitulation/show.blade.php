{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')
			<div class="container-fluid">
                <div class="page-titles">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{route('recapitulations.index')}}">Rekap Absensi</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0)">Rekap Absensi Bulanan</a></li>
					</ol>
                </div>
                <!-- row -->
                <div class="row">
					<div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Rekap Absensi Tahun Ajaran {{$period->year->year_start}}/{{$period->year->year_end}} Semester {{$period->semester}}</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example3" class="display min-w850" width="100%">
                                    <thead>
                                            <tr>
                                                <th style="width: 10%">No. </th>
                                                <th>Kelas</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($classrooms as $classroom)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$classroom->grade}} {{$classroom->name}}</td>
                                                <td style="width: 15%">
													<div class="d-flex">
														<a href="{{ route('recapitulations.class.show',[$period->id, $classroom->id]) }}" class="btn btn-info shadow btn-md mr-1"><i class="fa fa-search"></i></a>
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