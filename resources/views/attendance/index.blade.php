{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')
			<div class="container-fluid">
                <div class="page-titles">
					<ol class="breadcrumb">
						<li class="breadcrumb-item active"><a href="javascript:void(0)">Daftar Absensi</a></li>
					</ol>
                </div>
                <!-- row -->
                <div class="row">
					<div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Daftar Absensi</h4>
                                <a href="{{ Route('attendances.create') }}">
                                    <button type="button" class="btn btn-rounded btn-primary"><span class="btn-icon-left text-primary"><i class="fa fa-plus color-primary"></i>
                                    </span>Tambah Absensi</button>
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example3" class="display min-w850">
                                    <thead>
                                            <tr>
                                                <th>No. </th>
                                                <th>Tanggal</th>
                                                <th>Jam Masuk</th>
                                                <th>Tahun Ajaran</th>
                                                <th>Semester</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @if(isset($attendances))
                                            @foreach($attendances as $attendance)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$attendance->date}}</td>
                                                <td>{{$attendance->time}}</td>
                                                <td>{{$attendance->period->years}}</td>
                                                <td>{{$attendance->period->semester}}</td>
                                                <td>{!!$config_status[$attendance->status]!!}</td>
                                                <td>
													<div class="d-flex">
                                                        @if($attendance->status == 1)
                                                        <form action="{{ Route('attendances.status.update',[$attendance->id]) }}" method="post">
                                                        @method('PATCH') 
                                                        @csrf
                                                            <button type="submit" class="btn btn-success shadow btn-md mr-1" onclick="return confirm('Yakin ingin menutup Absensi?')"><i class="fa fa-check fa-md"></i></button>
                                                        </form> 
                                                        @endif
														<a href="{{ Route('attendances.show',[$attendance->id]) }}" class="btn btn-info shadow btn-md mr-1"><i class="fa fa-search fa-md"></i></a>
                                                        <form action="{{ Route('attendances.destroy',[$attendance->id]) }}" method="post">
                                                        @method('DELETE') 
                                                        @csrf
                                                            <button type="submit" class="btn btn-danger shadow btn-md mr-1" onclick="return confirm('Yakin ingin menghapus data?')"><i class="fa fa-trash fa-md"></i></button>
                                                        </form> 
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