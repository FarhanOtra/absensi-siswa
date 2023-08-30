{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')

			<div class="container-fluid"> 
                <div class="page-titles">
					<ol class="breadcrumb">
                        <li class="breadcrumb-item "><a href="{{Route('schoolyears.index')}}">Tahun Ajaran</a></li>
						<li class="breadcrumb-item "><a href="{{Route('classrooms.year',[$classroom->school_year_id])}}">Daftar Kelas</a></li>
						<li class="breadcrumb-item"><a href="{{Route('classrooms.show',[$classroom->id])}}">Kelas</a></li>
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
                                            <div class="form-group">
                                                <label>Tingkat</label>
                                                <select class="form-control" id="sel1" name="grade">
                                                    <option selected value="{{$classroom->grade}}">{{$classroom->grade}}</option>
                                                    <option value="X">X</option>
                                                    <option value="XI">XI</option>
                                                    <option value="XII">XII</option>
                                                </select>
                                                @error('grade')
                                                    <span class="text-danger"><small>{{$message}}</small></span>
                                                @enderror
                                            </div>
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
                                                @if(isset($classroom->teacher->user_id))
                                                    <option selected value="{{$classroom->teacher->user_id}}">{{$classroom->teacher->name}}</option>
                                                @endif
                                                @forelse($teachers as $teacher)
                                                    <option value="{{$teacher->user_id}}">{{$teacher->name}}</option>
                                                @empty
                                                    @if(isset($classroom->teacher))
                                                        <option selected value="{{$classroom->teacher->user_id}}">{{$classroom->teacher->name}}</option>
                                                    @endif
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