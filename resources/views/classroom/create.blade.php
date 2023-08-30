{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')

			<div class="container-fluid">
                <div class="page-titles">
					<ol class="breadcrumb">
						<li class="breadcrumb-item active"><a href="javascript:void(0)">Tambah Kelas</a></li>
					</ol>
                </div>
                <!-- row -->
                <div class="row">
                    <div class="col-xl-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Tambah Kelas</h4>
                            </div>
                                <div class="card-body">
                                    <div class="basic-form">
                                        <form method="post" class="form-valide" action="{{ Route('classrooms.store') }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label>Tingkat</label>
                                                <select class="form-control" id="sel1" name="grade" value="{{old('grade')}}">
                                                    <option value="">Pilih Tingkat</option>
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
                                                    <input type="text" class="form-control"  name="name" placeholder="Nama Kelas" value="{{old('name')}}">
                                                    @error('name')
                                                        <span class="text-danger"><small>{{$message}}</small></span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Guru Wali Kelas</label>
                                                <select class="form-control" id="sel1" name="teacher_id">
                                                    <option selected value="">Pilih Guru Wali Kelas</option>
                                                @forelse($teachers as $teacher)
                                                    <option value="{{$teacher->user_id}}">{{$teacher->name}}</option>
                                                @empty
                                                <option selected value="">Tidak Ada Pilihan Guru</option>
                                                @endforelse
                                                </select>
                                                @error('teacher_id')
                                                    <span class="text-danger"><small>{{$message}}</small></span>
                                                @enderror
                                            </div>
                                            <input type="hidden" name="school_year_id" value="{{$year}}">
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