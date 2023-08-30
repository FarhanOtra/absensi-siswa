{{-- Extends layout --}}
@extends('layout.default')



{{-- Content --}}
@section('content')
			<div class="container-fluid">
                <div class="page-titles">
					<ol class="breadcrumb">
						<li class="breadcrumb-item active"><a href="javascript:void(0)">Rekap Absensi</a></li>
					</ol>
                </div>
                <!-- row -->
                <div class="row">
					<div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Daftar Rekap Absensi</h4>   
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
                                                <td style="width: 50px">{{$loop->iteration}}</td>
                                                <td>{{$period->year->year_start}}/{{$period->year->year_end}}</td>
                                                <td>{{$period->semester}}</td>
                                                <td style="width: 20px">
													<div class="d-flex">
														<a href="{{ route('recapitulations.show',[$period->id])}}" class="btn btn-info shadow btn-md mr-1"><i class="fa fa-search"></i></a>
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