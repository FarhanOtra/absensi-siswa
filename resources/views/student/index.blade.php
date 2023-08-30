{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')
			<div class="container-fluid">
                <div class="page-titles">
					<ol class="breadcrumb">
						<li class="breadcrumb-item active"><a href="javascript:void(0)">Siswa</a></li>
					</ol>
                </div>
                <!-- row -->
                <div class="row">
					<div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Daftar Siswa</h4>    
                                @can('admin')
                                <a href="{{ Route('students.create') }}">
                                    <button type="button" class="btn btn-rounded btn-primary"><span class="btn-icon-left text-primary"><i class="fa fa-plus color-primary"></i>
                                    </span>Tambah</button>
                                </a>
                                @endcan
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example3" class="display min-w850">
                                    <thead>
                                            <tr>
                                                <th></th>
                                                <th>NIS</th>
                                                <th>Nama</th>
                                                <th>Jenis Kelamin</th>
                                                <th>Email</th>
                                                <th>No. Telepon Orangtua</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($students as $student)
                                            <tr>
                                                @if(isset($student->user->image))
                                                    <td><img class="rounded-circle" width="50" height="50" src="{{ asset('storage/'. $student->user->image) }}" alt=""></td>
                                                @else
                                                    <td><img class="rounded-circle" width="50" height="50" src="{{ asset('storage/avatar.png') }}" alt=""></td>
                                                @endif
                                                <td>{{$student->nis}}</td>
                                                <td>{{$student->name}}</td>
                                                <td>{{$config_gender[$student->gender]}}</td>
                                                <td>{{$student->user->email}}</td>
                                                <td>{{$student->parent_number}}</td>
                                                <td>
													<div class="d-flex">
														<a href="{{ route('students.edit',[$student->user->id])}}" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
														@can('admin')
                                                        <a href="{{ route('students.destroy',[$student->user->id])}}" class="btn btn-danger shadow btn-xs sharp" onclick="return confirm('Yakin ingin menghapus data?')"><i class="fa fa-trash"></i></a>
                                                        @endcan
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