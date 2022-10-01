{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')
			<div class="container-fluid">
                <div class="page-titles">
					<ol class="breadcrumb">
						<li class="breadcrumb-item active"><a href="javascript:void(0)">Rekap Absensi</a></li>
					</ol>
                </div>
                <!-- row -->
                <div class="row">
					<div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Rekap Absensi</h4>   
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example3" class="display min-w850" width="100%">
                                    <thead>
                                            <tr>
                                                <th>No. </th>
                                                <th>Tahun</th>
                                                <th>Semester</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($periods as $period)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$period->years}}</td>
                                                <td>{{$period->semester}}</td>
                                                <td style="max-width: 20px">
													<div class="d-flex">
														<a href="{{ route('periods.show',[$period->id])}}" class="btn btn-info shadow btn-md mr-1"><i class="fa fa-search"></i></a>
														<button type="button" class="btn btn-success shadow btn-md mr-1" data-toggle="modal" data-target="#classroom-{{$period->month}}"><i class="fa fa-print"></i></button>
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="classroom-{{$period->month}}">
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
                                                                            <div class="table-responsive" cellpadding="0" >
                                                                                <table id="example {{$period->month}}" class="table table-bordered p-3   overflow-auto display min-w850 pageLength:5">
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
                                                                                                <td class="p-1" style="width: 10%">{{$loop->iteration}}</td>
                                                                                                <td class="p-1">{{$classroom->name}}</td>
                                                                                                <td class="text-center p-1" style="width: 15%"><a href="{{ route('periods.print',[$period->id,$classroom->id])}}" class="btn btn-success shadow btn-md mr-1"><i class="fa fa-print"></i></a></td>
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
														<a href="{{ route('periods.edit',[$period->id])}}" class="btn btn-primary shadow btn-md mr-1"><i class="fa fa-pencil"></i></a>
														<form action="{{ route('periods.destroy',[$period->id])}}" method="post">
                                                        @method('DELETE') 
                                                        @csrf
                                                            <button type="submit" class="btn btn-danger shadow btn-md mr-1" onclick="return confirm('Yakin ingin menghapus data?')"><i class="fa fa-trash"></i></button>
                                                        </form>
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