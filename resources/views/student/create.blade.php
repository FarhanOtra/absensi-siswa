{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')

			<div class="container-fluid">
                <div class="page-titles">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{Route('students.index')}}">Siswa</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0)">Tambah Siswa</a></li>
					</ol>
                </div>
                <!-- row -->
                <div class="row">
                    <div class="col-xl-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Tambah Siswa</h4>
                            </div>
                                <div class="card-body">
                                    <div class="basic-form">
                                        <form method="post" class="form-valide" action="{{ Route('students.store') }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label>Username</label>
                                                    <input type="text" class="form-control"  name="username" placeholder="Username" value="{{old('username')}}">
                                                    @error('username')
                                                        <span class="text-danger"><small>{{$message}}</small></span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label>Email</label>
                                                    <input type="email" class="form-control" name="email" placeholder="Email" value="{{old('email')}}">
                                                    @error('email')
                                                        <span class="text-danger"><small>{{$message}}</small></span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label>Password</label>
                                                    <input type="password" class="form-control" name="password" placeholder="Password">
                                                    @error('password')
                                                        <span class="text-danger"><small>{{$message}}</small></span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label>NIS</label>
                                                    <input type="number" class="form-control" name="nis" placeholder="NIS" value="{{old('nis')}}">
                                                    @error('nis')
                                                        <span class="text-danger"><small>{{$message}}</small></span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label>Nama</label>
                                                    <input type="text" class="form-control" name="name" placeholder="Nama" value="{{old('name')}}">
                                                    @error('name')
                                                        <span class="text-danger"><small>{{$message}}</small></span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label>Jenis Kelamin</label>
                                                    <select class="form-control" id="sel1" name="gender">
                                                        <option selected value="">Pilih Jenis Kelamin</option>
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
                                                        <option selected value="">Pilih Kelas</option>
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
                                                    <input class="form-control" type="file" id="formFile" name="image">
                                                    @error('image')
                                                        <span class="text-danger"><small>{{$message}}</small></span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <br>
                                            <button type="submit" class="btn btn-primary">Tambah</button>
                                        </form>
                                    </div>
                                </div>
                        </div>
					</div>
                </div>
            </div>
			
@endsection