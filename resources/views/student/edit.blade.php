{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')

			<div class="container-fluid">
                <div class="page-titles">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{Route('students.index')}}">Siswa</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Siswa</a></li>
					</ol>
                </div>
                <!-- row -->
                <div class="row">
                    <div class="col-xl-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Edit Siswa</h4>
                                <a href="{{Route('reset.index',[$student->user->id])}}">
                                <button type="button" class="btn btn-sm btn-danger">Reset Password <span class="btn-icon-right"><i class="fa fa-close"></i></span>
                                </button>
                                </a>
                            </div>
                                <div class="card-body">
                                    <div class="basic-form">
                                        <form method="post" class="form-valide" action="{{ Route('students.update',[$student->user->id]) }}" enctype="multipart/form-data">
                                            @method('PUT') 
                                            @csrf
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label>Username</label>
                                                    <input type="text" class="form-control"  name="username" placeholder="Username" value="{{$student->user->username}}">
                                                    @error('username')
                                                        <span class="text-danger"><small>{{$message}}</small></span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label>Email</label>
                                                    <input type="email" class="form-control" name="email" placeholder="Email" value="{{$student->user->email}}">
                                                    @error('email')
                                                        <span class="text-danger"><small>{{$message}}</small></span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label>NIS</label>
                                                    <input type="number" class="form-control" name="nis" placeholder="NIS" value="{{$student->nis}}">
                                                    @error('nis')
                                                        <span class="text-danger"><small>{{$message}}</small></span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label>Nama</label>
                                                    <input type="text" class="form-control" name="name" placeholder="Nama" value="{{$student->name}}">
                                                    @error('name')
                                                        <span class="text-danger"><small>{{$message}}</small></span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label>Jenis Kelamin</label>
                                                    <select class="form-control" id="sel1" name="gender">
                                                    @if(isset($student->gender))
                                                        <option selected value="{{$student->gender}}">
                                                            @if($student->gender == 'P')
                                                            Perempuan
                                                            @else
                                                            Laki Laki
                                                            @endif
                                                        </option>
                                                    @endif
                                                        <option value="L">laki Laki</option>
                                                        <option value="P">Perempuan</option>
                                                    </select>
                                                    @error('gender')
                                                        <span class="text-danger"><small>{{$message}}</small></span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label>Kelas</label>
                                                    <select class="form-control" id="sel1" name="classroom_id">

                                                    @if(isset($student->classroom_id))
                                                        <option selected value="{{$student->classroom_id}}">{{$student->classroom->name}}</option>
                                                    @endif

                                                    @forelse($classrooms as $classroom)
                                                    <option value="{{$classroom->id}}">{{$classroom->name}}</option>
                                                    @empty
                                                    <option selected value="">Tidak Ada Kelas</option>
                                                    @endforelse

                                                    </select>
                                                    @error('classroom_id')
                                                        <span class="text-danger"><small>{{$message}}</small></span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label>Foto</label>
                                                    @if(isset($student->user->image))
                                                    <div><img class="rounded-circle" width="100" height="100" src="{{ asset('storage/'. $student->user->image) }}" alt=""></div>
                                                    @else
                                                    <div><img class="rounded-circle" width="100" height="100" src="{{ asset('storage/avatar.png') }}" alt=""></div>
                                                    @endif
                                                    <br>
                                                    <input class="form-control" type="file" id="formFile" name="image">
                                                    <input type="hidden" name="imageNow" value="{{$student->user->image}}">
                                                </div>
                                            </div>
                                            <br>
                                            <button type="submit" class="btn btn-primary">Edit</button>
                                        </form>
                                    </div>
                                </div>
                        </div>
					</div>
                </div>
            </div>
			
@endsection