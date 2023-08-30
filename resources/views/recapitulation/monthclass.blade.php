{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
    <style>
        .table td,{ padding: 3; }

        table.table-bordered > thead > tr > th{
        border:1px solid black;
        color:black;
        }

        table.table-bordered > tbody > tr > td{
        border:1px solid black;
        color:black;
        }
    </style>
			<div class="container-fluid">
                <div class="page-titles">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{route('recapitulations.index')}}">Rekap Absensi</a></li>
						<li class="breadcrumb-item active"><a href="javascript:void(0)">Rekap Absensi Kelas {{$classroom->grade}} {{$classroom->name}}</a></li>
					</ol>
                </div>
                <div class="row text-center">
                    <div class="col-3 text-left">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ7TNhgmSw0kaQEukVlcqZPh2xyyVeKzluOgRd-bq3tYQ&s" width="100" height="100">
                    </div>
                    <!-- Header Kop -->
                    <div class="col-6">
                            <h3><b>REKAPITULASI ABSENSI SISWA</b></h3>
                            <h4><b>SMK NEGERI 7 PADANG</b></h4>
                            <h4><b>TAHUN AJARAN {{$period->year->year_start}}/{{$period->year->year_end}}</b></h4>
                    </div>
                    <div class="col-3 text-right">
                        <a href="{{ Route('students.create') }}">
                            <a href="{{ route('recapitulations.print.month',[$period->id,$month,$classroom->id])}}"><button type="button" class="btn btn-rounded btn-success"><span class="btn-icon-left text-success"><i class="fa fa-print color-success"></i></span>Print</button></a>
                        </a>
                    </div>
                </div>
                <br>
                <div class="row">
                <div class="col-12">
                    <table class="text-dark">
                    <tr>
                        <td>Kelas</td><td>&nbsp:  {{$classroom->grade}} {{$classroom->name}}</td>
                    </tr>
                    <tr>
                        <td>Wali Kelas</td><td>&nbsp: {{$classroom->teacher->name ?? "-"}}</td>
                    </tr>
                    <tr>
                        <td>Semester</td><td>&nbsp: {{$period->semester}}</td>
                    </tr>
                    <tr>
                        <td>Bulan</td><td>&nbsp: {{$config_month[$month]}}</td>
                    </tr>
                    </table>
                </div>
                </div>
                <br>
                <!-- row -->
                <div class="row">
      <div class="col-12">
      <table class="table table-bordered pr-4" width="100%" cellpadding = "0">
        <thead>
          <tr>
            <th scope="col" rowspan="2" class="align-middle text-center" style="width : 1%">No.</th>
            <th scope="col" rowspan="2" class="align-middle text-center" style="width: 2%">NIS</th>
            <th scope="col" rowspan="2" class="align-middle text-center">Nama</th>
            <th scope="col" rowspan="2" class="align-middle text-center" style="width : 2%">L/P</th>
            <th scope="col" colspan="{{$dates->count()}}" class="align-middle text-center">{{$config_month[$month]}}</th>
            <th scope="col" colspan="5" class="align-middle text-center">Keterangan</th>
          </tr>
          <tr class="text-center">
            @foreach($dates as $date)
            <th scope="col" style="width : 2%"><a href="{{route('attendances.class',[$date->id,$classroom->id])}}" class="text-primary">{{\Carbon\Carbon::parse($date->date)->format('d')}}</a></th>
            @endforeach
            <th class="bg-success" scope="col" style="width : 2%">H</th>
            <th class="bg-info" scope="col" style="width : 2%">S</th>
            <th class="bg-warning" scope="col" style="width : 2%">I</th>
            <th class="bg-danger" scope="col" style="width : 2%">A</th>
            <th class="bg-dark" scope="col" style="width : 2%">B</th>
          </tr>
        </thead>
        <tbody> 
          @foreach($presence as $p)
          <tr class="text-center">
            <td>{{$loop->iteration}}</td>
            <td>{{$p['nis']}}</td>
            <td class="text-left">{{$p['name']}}</td>
            <td>{{$p['gender']}}</td>
            @php
              $h=0;
              $s=0;
              $i=0;
              $a=0;
              $b=0;
            @endphp
            @foreach($dates as $date)
              @php
              $j=0;
              @endphp
              @foreach($p['desc'] as $q)
                @if($date->date == $q['date'])
                  @php
                  $j++;
                  @endphp
                  @foreach($student_attendances as $student_attendance)
                    @if($student_attendance->id == $q['id'])
                      @if($q['status'] != null)
                      @switch($q['status'])
                        @case(1)
                          <td>H</td>
                          @php 
                          $h++
                          @endphp
                        @break
                        @case(2)
                          <td>S</td>
                          @php
                          $s++;
                          @endphp
                        @break
                        @case(3)
                          <td>I</td>
                          @php
                          $i++;
                          @endphp
                        @break
                        @case(4)
                          <td>A</td>
                          @php
                          $a++;
                          @endphp
                        @break
                        @case(5)
                          <td>B</td>
                          @php
                          $b++;
                          @endphp
                        @break
                      @endswitch
                      @endif
                    @endif
                  @endforeach
                @endif
              @endforeach
              @if($j==0)
                <td class="bg-dark"> </td>
                @php
                @endphp
              @endif
            @endforeach
            <td class="bg-success">{{$h}}</td>
            <td class="bg-info">{{$s}}</td>
            <td class="bg-warning">{{$i}}</td>
            <td class="bg-danger">{{$a}}</td>
            <td class="bg-dark">{{$b}}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
      </div>
    </div>  
    </div>
@endsection