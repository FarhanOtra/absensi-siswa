{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')
			<div class="container-fluid">
                <div class="page-titles">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{route('periods.index')}}">Rekap Absensi</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0)">Rekap Absensi Bulanan</a></li>
					</ol>
                </div>
                <!-- row -->
                <div class="row">
					<div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Rekap Absensi Tahun Ajaran {{$period->years}} Semester {{$period->semester}}</h4>
                                @can('admin')
                                <a href="{{ Route('attendances.create') }}">
                                    <button type="button" class="btn btn-rounded btn-primary"><span class="btn-icon-left text-primary"><i class="fa fa-plus color-primary"></i>
                                    </span>Tambah Absensi</button>
                                </a>
                                @endcan
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example3" class="display min-w850" width="100%">
                                    <thead>
                                            <tr>
                                                <th style="width: 10%">No. </th>
                                                <th>Bulan</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @if(isset($attendances))
                                            @foreach($attendances as $attendance)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$config_month[$attendance->month]}}</td>
                                                <td style="width: 15%">
													<div class="d-flex">
														<a href="{{ Route('periods.month',[$period->id, $attendance->month]) }}" class="btn btn-info shadow btn-md mr-1"><i class="fa fa-search"></i></a>
                                                        <button type="button" class="btn btn-success shadow btn-md mr-1" data-toggle="modal" data-target="#classroom-{{$attendance->month}}"><i class="fa fa-print"></i>  
													</div>												
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="classroom-{{$attendance->month}}">
                                                        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h3 class="modal-title">Print Rekap Absensi Per Kelas</h3>
                                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form method="post" class="form-valide" action="" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="table-responsive">
                                                                        <table id="example {{$attendance->month}}" class="table table-bordered overflow-auto display min-w850 pageLength:5">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>No</th>
                                                                                    <th>Kelas</th>
                                                                                    <th class="text-center">Action</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @if(isset($classrooms))
                                                                                    @foreach($classrooms as $classroom)
                                                                                    <tr>
                                                                                        <td style="width: 10%">{{$loop->iteration}}</td>
                                                                                        <td>{{$classroom->name}}</td>
                                                                                        <td class="text-center" style="width: 15%"><a href="{{ route('periods.print.month',[$period->id,$attendance->month,$classroom->id])}}" class="btn btn-success shadow btn-md mr-1"><i class="fa fa-print"></i></a></td>
                                                                                    </tr>
                                                                                    @endforeach
                                                                                @endif
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
												</td>												
                                            </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
            </div>
			
@endsection