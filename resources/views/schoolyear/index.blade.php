{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')
			<div class="container-fluid">
                <!-- row -->
                <div class="row">
					<div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Tahun Ajaran</h4>   
                                <a href="{{ Route('schoolyears.create') }}">
                                    <button type="button" class="btn btn-rounded btn-primary"><span class="btn-icon-left text-primary"><i class="fa fa-plus color-primary"></i>
                                    </span>Tambah</button>
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                @forelse($schoolyears as $schoolyear)
                                    <div class="col-xl-12 col-lg-12 mb-3">
                                        <div class="card mb-4 mb-xl-0">
                                            <div class="card-body bg-light border-bottom">
                                                <div class="media profile-bx">
                                                    <div class="media-body align-items-center">
                                                        <h2 class="text-black font-w600">Tahun Ajaran</h2>
                                                        <p class="text-black font-w600 mb-2">{{$schoolyear->year_start}}/{{$schoolyear->year_end}}</p>
                                                        <div class="d-flex">  
                                                        <a href="{{route('classrooms.year',[$schoolyear->id])}}" class="btn btn-md mr-2 btn-info">Daftar Kelas</a>
                                                        <a href="{{route('holidays.year',[$schoolyear->id])}}" class="btn btn-md mr-2 btn-info">Daftar Hari Libur</a>
                                                            <a href="{{ route('schoolyears.edit',[$schoolyear->id])}}" class="btn btn-primary shadow btn-md mr-2"><i class="fa fa-pencil"></i></a>
                                                            <form action="{{ route('schoolyears.destroy',[$schoolyear->id])}}" method="post">
                                                                @method('DELETE') 
                                                                @csrf
                                                                <button type="submit" class="btn btn-danger shadow btn-md mr-1" onclick="return confirm('Yakin ingin menghapus data?')"><i class="fa fa-trash"></i></button>
                                                            </form>
													    </div>	
                                                    </div>
                                                </div>
                                            </div>
                                        </div>  
                                    </div>
                                @empty    
                                    <div class="col-xl-12 col-lg-12 mb-3">
                                            <div class="card mb-4 mb-xl-0">
                                                <div class="card-body bg-light border-bottom">
                                                    <div class="media profile-bx">
                                                        <div class="media-body align-items-center">
                                                            <h2 class="text-black font-w600">Belum Ada Tahun Ajaran</h2>
                                                            <p class="text-black font-w600 mb-2">-/-</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>  
                                        </div>
                                @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
            </div>
@endsection