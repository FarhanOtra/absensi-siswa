{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')
			<div class="container-fluid">
                <div class="page-titles">
					<ol class="breadcrumb">
						<li class="breadcrumb-item active"><a href="javascript:void(0)">Daftar Kelas</a></li>
					</ol>
                </div>
                <!-- row -->


                <div class="row">
					<div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Daftar Kelas</h4>
                                <a href="{{ Route('classrooms.create') }}">
                                    <button type="button" class="btn btn-rounded btn-primary"><span class="btn-icon-left text-primary"><i class="fa fa-plus color-primary"></i>
                                    </span>Tambah Kelas</button>
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                @forelse($classrooms as $classroom)
                                    <div class="col-xl-3 col-lg-6 col-sm-6" >
                                        <a href="{{ Route('classrooms.show',[$classroom->id]) }}">
                                        <div class="widget-stat card bg-primary">
                                            <div class="card-body  p-4">
                                                <div class="media">
                                                    <span class="mr-3">
                                                        <i class="la la-users"></i>
                                                    </span>
                                                    <div class="media-body text-white text-right">
                                                        <h4 class="text-white">{{$classroom->name}}</h4>
                                                        <p class="mb-1">{{$classroom->teacher->name ?? '-'}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </a>
                                    </div>
                                    @empty
                                    <div class="col-xl-3 col-lg-6 col-sm-6" >
                                        <a href="{{ Route('classrooms.create') }}">
                                        <div class="widget-stat card bg-primary">
                                            <div class="card-body  p-4">
                                                <div class="media">
                                                    <span class="mr-3">
                                                        <i class="la la-plus"></i>
                                                    </span>
                                                    <div class="media-body text-white">
                                                    <h5 class="text-white">Nama Kelas</h5>
                                                        <small>Nama Guru Wali Kelas</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </a>
                                    </div>
                                @endforelse
                                </div>    
                            </div>
                        </div>
                    </div>
				</div>
            </div>
			
@endsection