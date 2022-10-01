{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')

			<div class="container-fluid">
                <div class="page-titles">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{Route('classrooms.index')}}">Kelas</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Kelas</a></li>
					</ol>
                </div>
                <!-- row -->
                <div class="row">
                    <div class="col-xl-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Edit Kelas</h4>
                            </div>
                                <div class="card-body">
                                    <div class="basic-form">
                                        <form method="post" class="form-valide" action="{{ Route('classrooms.update',[$classroom->id]) }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT') 
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label>Nama Kelas</label>
                                                    <input type="text" class="form-control"  name="name" placeholder="Nama Kelas" value="{{$classroom->name}}">
                                                    @error('name')
                                                        <span class="text-danger"><small>{{$message}}</small></span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Guru Wali Kelas</label>
                                                <select class="form-control" id="sel1" name="teacher_id">
                                                @forelse($teachers as $teacher)
                                                    <option selected value="{{$classroom->teacher->user_id}}">{{$classroom->teacher->name}}</option>
                                                    <option value="{{$teacher->user_id}}">{{$teacher->name}}</option>
                                                @empty
                                                    <option selected value="{{$classroom->teacher->user_id}}">{{$classroom->teacher->name}}</option>
                                                @endforelse
                                                </select>
                                                @error('teacher_id')
                                                    <span class="text-danger"><small>{{$message}}</small></span>
                                                @enderror
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