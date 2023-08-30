{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')
			<div class="container-fluid">
                <div class="page-titles">
					<ol class="breadcrumb">
						<li class="breadcrumb-item "><a href="{{Route('schoolyears.index')}}">Tahun Ajaran</a></li>
						<li class="breadcrumb-item "><a href="{{Route('classrooms.year',[$classroom->school_year_id])}}">Daftar Kelas</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0)">Detail Kelas</a></li>
					</ol>
                </div>
                <!-- row -->
                <div class="row">
					<div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title-lg">Detail Kelas</h3>
                                @can('admin')
                                <div>
                                    <form action="{{ Route('classrooms.destroy',[$classroom->id]) }}" method="post">
                                    <a href="{{ Route('classrooms.edit',[$classroom->id]) }}">
                                        <button type="button" class="btn btn-rounded btn-primary"><span class="btn-icon-left text-primary"><i class="fa fa-pencil color-primary"></i>
                                        </span>Edit</button>
                                    </a>
                                        @method('DELETE') 
                                        @csrf
                                        <button type="submit" class="btn btn-rounded btn-danger" onclick="return confirm('Yakin ingin menghapus data?')"><span class="btn-icon-left text-danger"><i class="fa fa-trash color-danger"></i>
                                        </span>Hapus</button>
                                    </form>
                                </div>
                                @endcan
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-2 col-lg-6 col-sm-6">
                                        <div class="widget-stat card bg-primary">
                                            <div class="card-body p-4">
                                                <div class="media">
                                                    <span class="mr-3">
                                                        <i class="la la-calendar"></i>
                                                    </span>
                                                    <div class="media-body text-white text-right">
                                                        <p class="mb-1">Tahun Ajaran</p>
                                                        <h5 class="text-white">{{$classroom->year->year_start}}/{{$classroom->year->year_end}}</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-6 col-sm-6">
                                        <div class="widget-stat card bg-primary">
                                            <div class="card-body p-4">
                                                <div class="media">
                                                    <span class="mr-3">
                                                        <i class="la la-users"></i>
                                                    </span>
                                                    <div class="media-body text-white text-right">
                                                        <p class="mb-1">Nama Kelas</p>
                                                        <h5 class="text-white">{{$classroom->grade}} {{$classroom->name}}</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-6 col-sm-6">
                                        <div class="widget-stat card bg-success">
                                            <div class="card-body p-4">
                                                <div class="media">
                                                    <span class="mr-3">
                                                    @if(isset($classroom->teacher->user->image))
                                                        <div><img class="rounded-circle" width="80" height="80" src="{{ asset('storage/'. $classroom->teacher->user->image) }}" alt=""></div>
                                                        @else
                                                        <div><img class="rounded-circle" width="80" height="80" src="{{ asset('storage/avatar.png') }}" alt=""></div>
                                                    @endif
                                                    </span>
                                                    <div class="media-body text-white text-right">
                                                        <p class="mb-1">Wali Kelas</p>
                                                        <h5 class="text-white">{{$classroom->teacher->name ?? '-'}}</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-6 col-sm-6">
                                        <div class="widget-stat card bg-info">
                                            <div class="card-body p-4">
                                                <div class="media">
                                                    <span class="mr-3">
                                                        <i class="flaticon-381-user-7"></i>
                                                    </span>
                                                    <div class="media-body text-white text-right">
                                                        <p class="mb-1">Laki Laki</p>
                                                        <h5 class="text-white">{{$l}}</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-6 col-sm-6">
                                        <div class="widget-stat card bg-secondary">
                                            <div class="card-body p-4">
                                                <div class="media">
                                                    <span class="mr-3">
                                                        <i class="flaticon-381-user-6"></i>
                                                    </span>
                                                    <div class="media-body text-white text-right">
                                                        <p class="mb-1">Perempuan</p>
                                                        <h5 class="text-white">{{$p}}</h5>
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
                <div class="row">
					<div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Daftar Siswa</h4>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-rounded btn-primary mb-2" data-toggle="modal" data-target="#exampleModalCenter">
                                <span class="btn-icon-left text-primary">
                                    <i class="fa fa-plus color-primary"></i>
                                </span>Tambah Siswa</button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModalCenter">
                                        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title">TAMBAH SISWA</h3>
                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                                    </button>
                                                </div>
                                                <form method="post" class="form-valide" action="{{ Route('classrooms.addStudent',[$classroom->id]) }}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="table-responsive">
                                                        <table id="example" class="display min-w850 pageLength:5">
                                                            <thead>
                                                                <tr>
                                                                    <th>Pilih</th>
                                                                    <th></th>
                                                                    <th>NIS</th>
                                                                    <th>Nama</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($students_all as $all)
                                                                <tr id="tr_{{$all->user->id}}">
                                                                    <td>
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" class="custom-control-input" name="data[]" value="{{$all->user->id}}" id="customCheckBox{{$all->user->id}}">
                                                                            <label class="custom-control-label" for="customCheckBox{{$all->user->id}}"></label>
                                                                        </div>
                                                                    </td>
                                                                    @if(isset($all->user->image))
                                                                        <td><img class="rounded-circle" width="50" height="50" src="{{ asset('storage/'. $all->user->image) }}" alt=""></td>
                                                                    @else
                                                                        <td><img class="rounded-circle" width="50" height="50" src="{{ asset('storage/avatar.png') }}" alt=""></td>
                                                                    @endif
                                                                    <td>{{$all->nis}}</td>									
                                                                    <td>{{$all->name}}</td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger light" data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Tambah</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                        </form>
                                    </div>
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
                                                <td>
													<div class="d-flex">
                                                        <a href="{{ route('classrooms.destroyStudent',[$student->id])}}" class="btn btn-danger shadow btn-xs sharp" onclick="return confirm('Yakin ingin menghapus data?')"><i class="fa fa-trash"></i></a>        
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