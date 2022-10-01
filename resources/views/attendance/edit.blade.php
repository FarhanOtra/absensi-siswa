{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')

			<div class="container-fluid">
                <div class="page-titles">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{Route('attendances.index')}}">Absensi</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Absensi</a></li>
					</ol>
                </div>
                <!-- row -->
                <div class="row">
                    <div class="col-xl-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Edit Absensi</h4>
                            </div>
                                <div class="card-body">
                                    <div class="basic-form">
                                        <form method="post" class="form-valide" action="{{ Route('attendances.update',[$attendance->id]) }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label>Tahun Ajaran</label>
                                                    <select class="form-control" id="sel1" name="period_id">
                                                        @if(isset($attendance->period_id))
                                                        <option selected value="{{$attendance->period_id}}">Tahun {{$attendance->period->years}} - Semester {{$attendance->period->semester}}</option>
                                                        @endif
                                                        @foreach($periods as $period)
                                                        <option value="{{$period->id}}">Tahun {{$period->years}} - Semester {{$period->semester}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('period_id')
                                                        <span class="text-danger"><small>{{$message}}</small></span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p class="mb-1">Tanggal</p>
                                                            <input name="date" class="datepicker-default form-control" dateFormat="yy-mm-dd" id="datepicker" value="{{ Carbon\Carbon::parse($attendance->date)->toFormattedDateString()}}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Jam Masuk</label>
                                                            <div class="input-group clockpicker" data-placement="bottom" data-align="top" data-autoclose="true">
                                                                <input type="text" class="form-control" name="time" value="{{$attendance->time}}"> <span class="input-group-append"><span class="input-group-text"><i class="fa fa-clock-o"></i></span></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @error('date')
                                                        <span class="text-danger"><small>{{$message}}</small></span>
                                                    @enderror
                                                    @error('time')
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