{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')

			<div class="container-fluid">
                <div class="page-titles">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{Route('holidays.year',[$schoolyear->id])}}">Hari Libur</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0)">Tambah Hari Libur</a></li>
					</ol>
                </div>
                <!-- row -->
                <div class="row">
                    <div class="col-xl-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Tambah Hari Libur</h4>
                            </div>
                                <div class="card-body">
                                    <div class="basic-form">
                                        <form method="post" class="form-valide" action="{{ Route('holidays.store') }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-row">
                                                <input type="hidden" name="school_year_id" value="{{$schoolyear->id}}">
                                                <div class="form-group col-md-12">
                                                    <label>Nama</label>
                                                    <input type="text" class="form-control" name="name" placeholder="Nama" value="{{old('name')}}">
                                                    @error('name')
                                                        <span class="text-danger"><small>{{$message}}</small></span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <div class="example">
                                                        <p class="mb-1">Tanggal</p>
                                                        <input class="form-control input-daterange-datepicker" type="text" name="daterange" value="{{\Carbon\Carbon::now()}}">
                                                    </div>
                                                    @error('date_range')
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