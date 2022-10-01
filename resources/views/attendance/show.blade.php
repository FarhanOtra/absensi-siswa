{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
			<div class="container-fluid">
                <div class="page-titles">
					<ol class="breadcrumb">
						<li class="breadcrumb-item "><a href="{{Route('attendances.index')}}">Absensi</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0)">Detail Absensi</a></li>
					</ol>
                </div>
                <!-- row -->
                <div class="row">
					<div class="col-xl-8 col-lg-12 col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Detail Absensi</h4>
                                        <a href="{{route('attendances.edit',[$attendance->id])}}">
                                            <button type="button" class="btn btn-rounded btn-primary"><span class="btn-icon-left text-primary"><i class="fa fa-pencil color-primary"></i>
                                            </span>Edit Absensi</button>
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-8 col-lg-12 col-sm-12">
                                                <div class="widget-stat card bg-primary">
                                                    <div class="card-body p-4">
                                                        <div class="media">
                                                            <span class="mr-3">
                                                                <i class="flaticon-381-calendar-1"></i>
                                                            </span>
                                                            <div class="media-body text-white text-right">
                                                                <p class="mb-1">Tanggal</p>
                                                                <h3 class="text-white">{{Carbon\Carbon::parse($attendance->date)->translatedFormat('l, d F Y')}}</h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-12 col-sm-12">
                                                <div class="widget-stat card bg-primary">
                                                    <div class="card-body p-4">
                                                        <div class="media">
                                                            <span class="mr-3">
                                                                <i class="flaticon-381-clock"></i>
                                                            </span>
                                                            <div class="media-body text-white text-right">
                                                                <p class="mb-1">Jam Masuk</p>
                                                                <h3 class="text-white">{{$attendance->time}}</h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-3 col-lg-6 col-sm-6">
                                                <div class="widget-stat card bg-success">
                                                    <div class="card-body p-4">
                                                        <div class="media">
                                                            <div class="media-body text-white">
                                                                <p class="mb-1">Hadir</p>
                                                                <h3 class="text-white">{{$hadir}}</h3>
                                                                <div class="progress mb-2 bg-primary">
                                                                    <div class="progress-bar progress-animated bg-light" style="width: {{ number_format($hadir / $students * 100,2) }}%"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-6 col-sm-6">
                                                <div class="widget-stat card bg-warning">
                                                    <div class="card-body p-4">
                                                        <div class="media">
                                                            <div class="media-body text-white">
                                                                <p class="mb-1">Sakit</p>
                                                                <h3 class="text-white">{{$sakit}}</h3>
                                                                <div class="progress mb-2 bg-primary">
                                                                    <div class="progress-bar progress-animated bg-light" style="width: {{ number_format($sakit / $students * 100,2) }}%"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-6 col-sm-6">
                                                <div class="widget-stat card bg-info">
                                                    <div class="card-body p-4">
                                                        <div class="media">
                                                            <div class="media-body text-white">
                                                                <p class="mb-1">Izin</p>
                                                                <h3 class="text-white">{{$izin}}</h3>
                                                                <div class="progress mb-2 bg-primary">
                                                                    <div class="progress-bar progress-animated bg-light" style="width: {{ number_format($izin / $students * 100,2)}}%"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-6 col-sm-6">
                                                <div class="widget-stat card bg-danger">
                                                    <div class="card-body p-4">
                                                        <div class="media">
                                                            <div class="media-body text-white">
                                                                <p class="mb-1">Absen</p>
                                                                <h3 class="text-white">{{$absen}}</h3>
                                                                <div class="progress mb-2 bg-primary">
                                                                    <div class="progress-bar progress-animated bg-light" style="width: {{ number_format($absen / $students * 100,2) }}%"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>      
                            </div>
                            <div class="col-xl-4 col-lg-12 col-sm-12">
                                <div class="card h-auto">
                                    <div class="card-header">
                                        <h4 class="card-title">QR Code</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="col-12 text-center">
                                        {!! QrCode::size(350)->generate(Route('attendances.store')); !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
				</div>
                <div class="row">
                    <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Daftar Siswa</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="example3" class="display min-w850" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>NIS</th>
                                                        <th>Nama</th>
                                                        <th>Jenis Kelamin</th>
                                                        <th>Kelas</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($student_attendances as $student_attendance)
                                                    <tr>
                                                        @if(isset($student_attendance->student->user->image))
                                                            <td><img class="rounded-circle" width="50" height="50" src="{{ asset('storage/'. $student_attendance->student->user->image) }}" alt=""></td>
                                                        @else
                                                            <td><img class="rounded-circle" width="50" height="50" src="{{ asset('storage/avatar.png') }}" alt=""></td>
                                                        @endif
                                                        <td>{{$student_attendance->student->nis}}</td>
                                                        <td>{{$student_attendance->student->name}}</td>
                                                        <td>{{$config_gender[$student_attendance->student->gender]}}</td>
                                                        <td>{{$student_attendance->student->classroom->name}}</td>
                                                        <td>{!!$config_status[$student_attendance->status]!!}</td>
                                                        <td style="max-width : 50px">
                                                            <form action="{{route('student-attendances.update',[$student_attendance->id])}}" method="POST">
                                                                @csrf
                                                                @method('PATCH')
                                                                <div class="input-group">
                                                                    <select class="" name="status">
                                                                        <option selected></option>
                                                                        <option value="1">Hadir</option>
                                                                        <option value="2">Sakit</option>
                                                                        <option value="3">Izin</option>
                                                                        <option value="4">Absen</option>
                                                                    </select>
                                                                    <div class="input-group-append">
                                                                        <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-pencil"></i></button>
                                                                    </div>
                                                                </div>										
                                                            </form>
                                                        </td>									
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
            </div>
@endsection

                            