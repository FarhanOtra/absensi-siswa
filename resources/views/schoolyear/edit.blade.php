{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')

			<div class="container-fluid">
                <div class="page-titles">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{Route('schoolyears.index')}}">Tahun Ajaran</a></li>
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
                                        <form method="post" class="form-valide" action="{{ Route('schoolyears.update',[$schoolyear->id]) }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label>Tahun Awal</label>
                                                    <input type="text" class="form-control"  name="year_start" placeholder="Tahun" value="{{$schoolyear->year_start}}">
                                                    @error('year_start')
                                                        <span class="text-danger"><small>{{$message}}</small></span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label>Tahun Akhir</label>
                                                    <input type="text" class="form-control"  name="year_end" placeholder="Tahun" value="{{$schoolyear->year_end}}">
                                                    @error('year_end')
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