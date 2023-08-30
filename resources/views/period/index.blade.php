{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')
			<div class="container-fluid">
                <div class="page-titles">
					<ol class="breadcrumb">
						<li class="breadcrumb-item active"><a href="javascript:void(0)">Periode</a></li>
					</ol>
                </div>
                <!-- row -->
                <div class="row">
					<div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Daftar Periode</h4>   
                                <a href="{{ Route('periods.create') }}">
                                    <button type="button" class="btn btn-rounded btn-primary"><span class="btn-icon-left text-primary"><i class="fa fa-plus color-primary"></i>
                                    </span>Tambah</button>
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example3" class="display min-w850" width="100%">
                                    <thead>
                                            <tr>
                                                <th>No. </th>
                                                <th>Tahun Ajaran</th>
                                                <th>Semester</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($periods as $period)
                                            <tr>
                                                @if($period->active==1)
                                                    <td style="max-width: 10px"><span class="badge badge-rounded badge-success">{{$loop->iteration}} Active</span></td>
                                                @else
                                                    <td>{{$loop->iteration}}</td>
                                                @endif
                                                <td>{{$period->year->year_start}}/{{$period->year->year_end}}</td>
                                                <td>{{$period->semester}}</td>
                                                <td style="max-width: 20px">
													<div class="d-flex">  
                                                        @can('admin')
														<a href="{{ route('periods.edit',[$period->id])}}" class="btn btn-primary shadow btn-md mr-1"><i class="fa fa-pencil"></i></a>
														<form action="{{ route('periods.destroy',[$period->id])}}" method="post">
                                                            @method('DELETE') 
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger shadow btn-md mr-1" onclick="return confirm('Yakin ingin menghapus data?')"><i class="fa fa-trash"></i></button>
                                                        </form>
                                                        @endcan
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