{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')
			<div class="container-fluid">
                <div class="page-titles">
					<ol class="breadcrumb">
						<li class="breadcrumb-item active"><a href="javascript:void(0)">Daftar Hari Libur</a></li>
					</ol>
                </div>
                <!-- row -->
                <div class="row">
					<div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Daftar Hari Libur Tahun Ajaran {{$year->year_start}}/{{$year->year_end}}</h4>
                                <a href="{{ Route('holidays.create',[$year->id]) }}">
                                    <button type="button" class="btn btn-rounded btn-primary"><span class="btn-icon-left text-primary"><i class="fa fa-plus color-primary"></i>
                                    </span>Tambah</button>
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example3" class="display min-w850">
                                    <thead>
                                            <tr>
                                                <th>No. </th>
                                                <th>Nama</th>
                                                <th>Mulai Tanggal</th>
                                                <th>Sampai Tanggal</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($holidays as $holiday)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$holiday->name}}</td>
                                                <td>{{Carbon\Carbon::parse($holiday->start_date)->translatedFormat('l, d F Y')}}</td>
                                                <td>{{Carbon\Carbon::parse($holiday->end_date)->translatedFormat('l, d F Y')}}</td>
                                                <td>
													<div class="d-flex">
                                                        <form action="{{ Route('holidays.destroy',[$holiday->id]) }}" method="post">
                                                        @method('DELETE') 
                                                        @csrf
                                                            <button type="submit" class="btn btn-danger shadow btn-md mr-1" onclick="return confirm('Yakin ingin menghapus data?')"><i class="fa fa-trash fa-md"></i></button>
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