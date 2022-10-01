{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')
			<div class="container-fluid">
                <div class="page-titles">
					<ol class="breadcrumb">
						<li class="breadcrumb-item active"><a href="javascript:void(0)">Perizinan</a></li>
					</ol>
                </div>
                <!-- row -->
                <div class="row">
					<div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Daftar Perizinan</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example3" class="display min-w850">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>NIS</th>
                                                <th>Nama</th>
                                                <th>Kelas</th>
                                                <th>Keterangan</th>
                                                <th>Jenis</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($permissions as $permission)
                                            <tr>
                                                <td>{{$permission->attendance->date}}</td>
                                                <td>{{$permission->student->nis}}</td>
                                                <td>{{$permission->student->name}}</td>
                                                <td>{{$permission->student->classroom->name}}</td>
                                                <td>{{$permission->desc}}</td>
                                                <td>{{$permission->type}}</td>
                                                <td>{{$permission->status}}</td>
                                                <td>Action</td>
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