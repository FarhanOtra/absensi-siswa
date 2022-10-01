{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')

			<div class="container-fluid">
                <div class="page-titles">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{Route('periods.index')}}">Tahun Ajaran</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Tahun Ajaran</a></li>
					</ol>
                </div>
                <!-- row -->
                <div class="row">
                    <div class="col-xl-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Edit Tahun Ajaran</h4>
                            </div>
                                <div class="card-body">
                                    <div class="basic-form">
                                        <form method="post" class="form-valide" action="{{ Route('periods.update',[$period->id]) }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label>Tahun</label>
                                                    <input type="text" class="form-control"  name="years" placeholder="Tahun" value="{{$period->years}}">
                                                    @error('years')
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