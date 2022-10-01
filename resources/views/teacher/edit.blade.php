{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')

			<div class="container-fluid">
                <div class="page-titles">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{Route('teachers.index')}}">Wali Kelas</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Wali Kelas</a></li>
					</ol>
                </div>
                <!-- row -->
                <div class="row">
                    <div class="col-xl-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Edit Wali Kelas</h4>
                                <a href="{{Route('reset.index',[$teacher->user->id])}}">
                                <button type="button" class="btn btn-sm btn-danger">Reset Password <span class="btn-icon-right"><i class="fa fa-close"></i></span>
                                </button>
                                </a>
                            </div>
                                <div class="card-body">
                                    <div class="basic-form">
                                        <form method="post" class="form-valide" action="{{ Route('teachers.update',[$teacher->user->id]) }}" enctype="multipart/form-data">
                                        @method('PUT') 
                                        @csrf
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label>Username</label>
                                                    <input type="text" class="form-control"  name="username" placeholder="Username" value="{{$teacher->user->username}}">
                                                    @error('username')
                                                        <span class="text-danger"><small>{{$message}}</small></span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label>Email</label>
                                                    <input type="email" class="form-control" name="email" placeholder="Email" value="{{$teacher->user->email}}">
                                                    @error('email')
                                                        <span class="text-danger"><small>{{$message}}</small></span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label>NIP</label>
                                                    <input type="number" class="form-control" name="nip" placeholder="NIP" value="{{$teacher->nip}}">
                                                    @error('nip')
                                                        <span class="text-danger"><small>{{$message}}</small></span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label>Nama</label>
                                                    <input type="text" class="form-control" name="name" placeholder="Nama" value="{{$teacher->name}}">
                                                    @error('name')
                                                        <span class="text-danger"><small>{{$message}}</small></span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label>Foto</label>
                                                    @if(isset($teacher->user->image))
                                                    <div><img class="rounded-circle" width="100" height="100" src="{{ asset('storage/'. $teacher->user->image) }}" alt=""></div>
                                                    @else
                                                    <div><img class="rounded-circle" width="100" height="100" src="{{ asset('storage/avatar.png') }}" alt=""></div>
                                                    @endif
                                                    <br>
                                                    <input class="form-control" type="file" id="formFile" name="image">
                                                    <input type="hidden" name="imageNow" value="{{$teacher->user->image}}">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <button type="submit" class="btn btn-primary">Edit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                        </div>
					</div>
                </div>
            </div>
			
@endsection