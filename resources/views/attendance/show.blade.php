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
                                        @can('admin')
                                        <a href="{{route('attendances.edit',[$attendance->id])}}">
                                            <button type="button" class="btn btn-rounded btn-primary"><span class="btn-icon-left text-primary"><i class="fa fa-pencil color-primary"></i>
                                            </span>Edit</button>
                                        </a>
                                        @endcan
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-12 col-sm-12">
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
                                            <div class="col-xl-3 col-lg-12 col-sm-12">
                                                <div class="widget-stat card bg-primary">
                                                    <div class="card-body p-4">
                                                        <div class="media">
                                                            <span class="mr-3">
                                                                <i class="flaticon-381-clock"></i>
                                                            </span>
                                                            <div class="media-body text-white text-right">
                                                                <p class="mb-1">Jam Masuk</p>
                                                                <h3 class="text-white">{{Carbon\Carbon::parse($attendance->time)->translatedFormat('H:i')}}</h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-12 col-sm-12">
                                                <div class="widget-stat card bg-danger">
                                                    <div class="card-body p-4">
                                                        <div class="media">
                                                            <span class="mr-3">
                                                                <i class="flaticon-381-stopclock"></i>
                                                            </span>
                                                            <div class="media-body text-white text-right">
                                                                <p class="mb-1">Batas Waktu</p>
                                                                <h3 class="text-white">{{Carbon\Carbon::parse($attendance->time_limit)->translatedFormat('H:i')}}</h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-2 col-lg-12 col-sm-12">
                                                <div class="widget-stat card bg-primary">
                                                    <div class="card-body p-4">
                                                        <div class="media">
                                                            <span class="mr-3">
                                                                <i class="flaticon-381-notepad"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-lg-6 col-sm-6">
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
                                            <div class="col-xl-2 col-lg-6 col-sm-6">
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
                                            <div class="col-xl-2 col-lg-6 col-sm-6">
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
                                            <div class="col-xl-2 col-lg-6 col-sm-6">
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
                                            <div class="col-xl-2 col-lg-6 col-sm-6">
                                                <div class="widget-stat card bg-dark">
                                                    <div class="card-body p-4">
                                                        <div class="media">
                                                            <div class="media-body text-white">
                                                                <p class="mb-1">Bolos</p>
                                                                <h3 class="text-white">{{$bolos}}</h3>
                                                                <div class="progress mb-2 bg-primary">
                                                                    <div class="progress-bar progress-animated bg-light" style="width: {{ number_format($bolos / $students * 100,2) }}%"></div>
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
                                        {!! QrCode::size(350)->generate($attendance->id) !!}
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
                                        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Pilih Kelas</button>
                                        <div class="dropdown-menu">
                                            @foreach($class as $c)
                                                <a class="dropdown-item" href="{{route('attendances.class',[$attendance->id,$c->id])}}">{{$c->grade}} {{$c->name}}</a>
                                            @endforeach
                                        </div>
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
                                                        <th>Jam Datang</th>
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
                                                        <td>{{$student_attendance->student_classroom->student->nis}}</td>
                                                        <td>{{$student_attendance->student_classroom->student->name}}</td>
                                                        <td>{{$config_gender[$student_attendance->student_classroom->student->gender]}}</td>
                                                        <td>{{$student_attendance->student_classroom->classroom->grade}} {{$student_attendance->student_classroom->classroom->name}}</td>
                                                        <td>{!!$config_status[$student_attendance->status]!!}</td>
                                                        <td>{{$student_attendance->time_in ? \Carbon\Carbon::parse($student_attendance->time_in)->translatedFormat('H:i') : '-'}}</td>
                                                        <td>
                                                            <div class="d-flex justify-content-center">
                                                                <a href="" class="btn btn-primary shadow btn-md mr-2" aria-hidden="true" data-toggle="modal" data-target="#exampleModal-{{$student_attendance->id}}"><i class="fa fa-pencil"></i></a>
                                                                @foreach($student_attendances as $st)
                                                                <!-- Modal -->
                                                                <div class="modal fade" id="exampleModal-{{$st->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="exampleModalLabel">Edit Status</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <form action="{{route('student-attendances.update',[$st->id])}}" method="post" id="add_form" enctype="multipart/form-data">
                                                                                <div class="modal-body">
                                                                                    @csrf
                                                                                    @method('PATCH')
                                                                                    <div class="content">
                                                                                    <div class="form-group col-md-12">
                                                                                        <label>Status</label>
                                                                                        <select class="form-control" id="sel1" name="status">
                                                                                            <option selected value="{{$st->status}}">
                                                                                            @switch($st->status)
                                                                                                @case(1)
                                                                                                    Hadir
                                                                                                    @break
                                                                                                @case(2)
                                                                                                    Sakit
                                                                                                    @break
                                                                                                @case(3)
                                                                                                    Izin
                                                                                                    @break
                                                                                                @case(4)
                                                                                                    Absen
                                                                                                    @break
                                                                                                @case(5)
                                                                                                    Bolos
                                                                                                    @break
                                                                                                @default
                                                                                                    Hadir
                                                                                            @endswitch
                                                                                            </option>
                                                                                            <option value="1">Hadir</option>
                                                                                            <option value="2">Sakit</option>
                                                                                            <option value="3">Izin</option>
                                                                                            <option value="4">Absen</option>
                                                                                            <option value="5">Bolos</option>
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="form-group col-md-12">
                                                                                        <label>Catatan</label>
                                                                                        <textarea class="form-control" rows="4" name="note">{{$st->note}}</textarea>
                                                                                    </div>
                                                                                    @if($st->modified->role != "student")
                                                                                    <div class="form-group col-md-12">
                                                                                        <Label class="font-italic" >Terakhir Diubah Oleh : {{$st->modified->teacher->name}}</Label>
                                                                                    </div>
                                                                                    @endif
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                                    <button type="submit" class="btn btn-primary">Edit</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endforeach
                                                            </div>
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

                            