{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')

			<div class="container-fluid">
                <div class="page-titles">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{Route('periods.index')}}">Periode</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Periode</a></li>
					</ol>
                </div>
                <!-- row -->
                <div class="row">
                    <div class="col-xl-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Edit Periode</h4>
                            </div>
                                <div class="card-body">
                                    <div class="basic-form">
                                        <form method="post" class="form-valide" action="{{ Route('periods.update',[$period->id]) }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label>Tahun Ajaran</label>
                                                    <select class="form-control" id="sel1" name="school_year_id">
                                                        <option selected value="{{$period->school_year_id}}">{{$period->year->year_start}}/{{$period->year->year_end}}</option>
                                                        @foreach($schoolyears as $schoolyear)
                                                        <option value="{{$schoolyear->id}}">{{$schoolyear->year_start}}/{{$schoolyear->year_end}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('school_year_id')
                                                        <span class="text-danger"><small>{{$message}}</small></span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label>Semester</label>
                                                    <select class="form-control" id="sel1" name="semester">
                                                        <option selected value="{{$period->semester}}">{{$period->semester}}</option>
                                                        <option value="Ganjil">Ganjil</option>
                                                        <option value="Genap">Genap</option>
                                                    </select>
                                                    @error('semester')
                                                        <span class="text-danger"><small>{{$message}}</small></span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label>Set</label>
                                                    <select class="form-control" id="sel1" name="active">
                                                        <option selected value="{{$period->active}}">
                                                        @if($period->active == 1)    
                                                        Aktif
                                                        @else
                                                        Tidak Aktif
                                                        @endif
                                                        </option>
                                                        <option value="1">Aktif</option>
                                                        <option value="0">Tidak Aktif</option>
                                                    </select>
                                                    @error('active')
                                                        <span class="text-danger"><small>{{$message}}</small></span>
                                                    @enderror
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