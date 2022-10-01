<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        .gambar-kiri
        {
            width:130px;
            float:left;
            position:absolute;
            margin-left: 100px;  
        }

        .table td,{ padding: 3; }

        table.table-bordered > thead > tr > th{
        border:1px solid black;
        }

        table.table-bordered > tbody > tr > td{
        border:1px solid black;
        }
    </style>
    <title>Rekapitulasi Absensi {{$period->years}}</title>
  </head>
  <body style="margin: 0.2in 0.5in 0.2in 0.5in;">
    <div>
      <div>
          <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ7TNhgmSw0kaQEukVlcqZPh2xyyVeKzluOgRd-bq3tYQ&s" class="gambar-kiri">
      </div>
      <!-- Header Kop -->
      <div class="text-center" style="margin-left: -200px">
              <h3><b>REKAPITULASI ABSENSI SISWA</b></h3>
              <h4><b>SMK NEGERI 7 PADANG</b></h4>
              <h4><b>TAHUN AJARAN {{$period->years}}</b></h4>
      </div>
    </div>
    <div>
      <br>
      <hr style="border-top: 1px solid black;">
    </div>
    <div class="row">
      <div class="col-12">
        <table>
          <tr>
            <td>Kelas</td><td>:  {{$classroom->name}}</td>
          </tr>
          <tr>
            <td>Wali Kelas</td><td>: {{$classroom->teacher->name}}</td>
          </tr>
          <tr>
            <td>Semester</td><td>: {{$period->semester}}</td>
          </tr>
        </table>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-12">
      <table class="table table-bordered pr-4" width="100%" cellpadding = "0">
        <thead>
          <tr>
            <th scope="col" rowspan="2" class="align-middle text-center" style="width : 1%">No.</th>
            <th scope="col" rowspan="2" class="align-middle text-center" style="width: 10%">NIS</th>
            <th scope="col" rowspan="2" class="align-middle text-center">Nama</th>
            <th scope="col" rowspan="2" class="align-middle text-center" style="width : 2%">L/P</th>
            <th scope="col" colspan="{{$dates->count()}}" class="align-middle text-center">{{$config_month[$month]}}</th>
            <th scope="col" colspan="4" class="align-middle text-center">Keterangan</th>
          </tr>
          <tr class="text-center">
            @foreach($dates as $date)
            <th scope="col" style="width : 2%">{{\Carbon\Carbon::parse($date->date)->format('d')}}</th>
            @endforeach
            <th class="bg-success" scope="col" style="width : 2%">H</th>
            <th class="bg-info" scope="col" style="width : 2%">S</th>
            <th class="bg-warning" scope="col" style="width : 2%">I</th>
            <th class="bg-danger" scope="col" style="width : 2%">A</th>
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
                      @endswitch
                      @endif
                    @endif
                  @endforeach
                @endif
              @endforeach
              @if($j==0)
                <td>A</td>
                @php
                $a++
                @endphp
              @endif
            @endforeach
            <td class="bg-success">{{$h}}</td>
            <td class="bg-info">{{$s}}</td>
            <td class="bg-warning">{{$i}}</td>
            <td class="bg-danger">{{$a}}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
      </div>
    </div>  
  
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>