{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')

			<div class="container-fluid">
                <div class="page-titles">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{Route('attendances.index')}}">Absensi</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0)">Tambah Absensi</a></li>
					</ol>
                </div>
                <!-- row -->
                <div class="row">
                    <div class="col-xl-8 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Tambah Absensi</h4>
                            </div>
                                <div class="card-body">
                                    <div class="basic-form">
                                        <form method="post" class="form-valide" action="{{ Route('attendances.store') }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-row">
                                            <div class="form-group col-md-12">
                                                    <label>Periode</label>
                                                    <select class="form-control" id="sel1" name="period_id" disabled="disabled">    
                                                        @if($period)
                                                        <option value="{{$period->id}}">Tahun {{$period->year->year_start}}/{{$period->year->year_end}} - Semester {{$period->semester}}</option>
                                                        <input type="hidden" name="period_id" value="{{$period->id}}">
                                                        @else
                                                        <option selected value="">Tidak Ada Periode yang Aktif</option>
                                                        @endif
                                                    </select>
                                                    @error('period_id')
                                                        <span class="text-danger"><small>{{$message}}</small></span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <p class="mb-1">Tanggal</p>
                                                            <input name="date" class="datepicker-default form-control" dateFormat="yy-mm-dd" id="datepicker" value="{{ now()->toFormattedDateString()}}">
                                                            @error('date')
                                                                <span class="text-danger"><small>{{$message}}</small></span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">   
                                                        <div class="col-md-6">
                                                            <label>Jam Masuk</label>
                                                            <div class="input-group clockpicker" data-placement="bottom" data-align="top" data-autoclose="true">
                                                                <input type="text" class="form-control" name="time" value="07:30"> <span class="input-group-append"><span class="input-group-text"><i class="fa fa-clock-o"></i></span></span>
                                                            </div>
                                                            @error('time')
                                                                <span class="text-danger"><small>{{$message}}</small></span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Batas Waktu</label>
                                                            <div class="input-group clockpicker" data-placement="bottom" data-align="top" data-autoclose="true">
                                                                <input type="text" class="form-control" name="time_limit" value="08:30"> <span class="input-group-append"><span class="input-group-text"><i class="fa fa-clock-o"></i></span></span>
                                                            </div>
                                                            @error('time_limit')
                                                                <span class="text-danger"><small>{{$message}}</small></span>
                                                            @enderror
                                                        </div>
                                                    </div>
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