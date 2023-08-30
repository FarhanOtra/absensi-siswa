<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Period;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\Classroom;
use App\Models\Student_attendance;
use App\Models\Holiday;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Collection;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

class RecapitulationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = 'Rekap Absensi';
        $action = __FUNCTION__;

        $periods = Period::join('school_years','school_years.id','periods.school_year_id')->select('*','periods.id as id')->orderBy('school_years.year_start','DESC')->orderBy('periods.semester','DESC')->get();
		
        return view('recapitulation.index', compact('page_title','action','periods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page_title = 'Rekap Absensi';
        $action = 'index';

        $period = Period::find($id);

        if(Auth()->user()->role == 'admin'){
            $classrooms = Classroom::where('school_year_id',$period->school_year_id)->orderBy('grade')->get();
        };

        if(Auth()->user()->role == 'teacher'){
            $teacher_id = Auth()->user()->id;
            $classrooms = Classroom::where('school_year_id',$period->school_year_id)->where('teacher_id',$teacher_id)->get();
        };
		
        return view('recapitulation.show', compact('page_title','action','period','classrooms'));
    }

    public function showClass($id, $classroom_id)
    {
        $page_title = 'Rekap Absensi';
        $action = 'index';
        
        $classroom = Classroom::find($classroom_id);
        $period = Period::find($id);
        $holidays = Holiday::join('holiday_groups','holidays.holiday_group_id','holiday_groups.id')->where('school_year_id',$period->school_year_id)->pluck('date');
        $config_month = config('attendance.month'); 
        $nowDate = Carbon::now()->toDateString();

        $s_attendances = Student_attendance::join('attendances', 'attendances.id','student_attendances.attendance_id')->join('student_classrooms','student_classrooms.id','student_attendances.student_classroom_id')->join('students','student_classrooms.student_id','students.user_id')->join('classrooms','student_classrooms.classroom_id','classrooms.id')->select('attendances.id as id','student_attendances.id as sa_id','student_attendances.status as status','students.name','students.gender','students.nis', 'attendances.date','classrooms.name as classroom_name','classrooms.id as c_id')->where('period_id',$period->id)->whereNotIn('date',$holidays)->where('classrooms.id',$classroom_id)->groupBy('date','student_classroom_id')->orderBy('name')->get();

        $dates = Attendance::orderBy('date')->where('period_id',$period->id)->where('date', '<=', $nowDate)->whereNotIn('date',$holidays)->get();
        $months = Attendance::where('period_id',$period->id)->where('date', '<=', $nowDate)->whereNotIn('date',$holidays)->select(DB::raw('YEAR(date) year, MONTH(date) month'))->distinct()->orderBy('year')->get();

        $student_attendances = Student_attendance::all();

        $presence = [];
        $students_temp = [];
        $date_temp = [];

        foreach($dates as $date){
            $date_temp[] = ['id' => $date->id, 'date' => $date->date];
        };

        foreach($s_attendances as $s_attendance){
            $temp = null;

            if(!in_array($s_attendance->nis, $students_temp)){
                array_push($students_temp, $s_attendance->nis);
                foreach($s_attendances as $s_attendance_2){
                    if($s_attendance->nis == $s_attendance_2->nis){
                        if($temp == null){
                            $temp['nis'] = $s_attendance_2->nis;
                            $temp['name'] = $s_attendance_2->name;
                            $temp['classroom_name'] = $s_attendance_2->classroom_name;
                            $temp['gender'] = $s_attendance_2->gender;
                            $temp['desc'] = [[
                                'date' => $s_attendance_2->date,
                                'month' => Carbon::parse($s_attendance_2->date)->format('m'),
                                'status' => $s_attendance_2->status,
                                'id' => $s_attendance_2->sa_id
                            ]];
                        }else{
                            array_push($temp['desc'], ['date' => $s_attendance_2->date, 'month' => Carbon::parse($s_attendance_2->date)->format('m'), 'status' => $s_attendance_2->status, 'id' => $s_attendance_2->sa_id]);
                        }
                    }
                }
                array_push($presence, $temp);
            }
        };

        // dd($presence);
        return view('recapitulation.showclass', compact('action','page_title','presence','dates','student_attendances','months','classroom','config_month','period'));
    }

    public function print($id, $classroom_id){
        $classroom = Classroom::find($classroom_id);
        $period = Period::find($id);
        $holidays = Holiday::join('holiday_groups','holidays.holiday_group_id','holiday_groups.id')->where('school_year_id',$period->school_year_id)->pluck('date');
        $config_month = config('attendance.month'); 
        $nowDate = Carbon::now()->toDateString();

        $s_attendances = Student_attendance::join('attendances', 'attendances.id','student_attendances.attendance_id')->join('student_classrooms','student_classrooms.id','student_attendances.student_classroom_id')->join('students','student_classrooms.student_id','students.user_id')->join('classrooms','student_classrooms.classroom_id','classrooms.id')->select('attendances.id as id','student_attendances.id as sa_id','student_attendances.status as status','students.name','students.gender','students.nis', 'attendances.date','classrooms.name as classroom_name','classrooms.id as c_id')->where('period_id',$period->id)->whereNotIn('date',$holidays)->where('classrooms.id',$classroom_id)->groupBy('date','student_classroom_id')->orderBy('name')->get();

        $dates = Attendance::orderBy('date')->where('period_id',$period->id)->where('date', '<=', $nowDate)->whereNotIn('date',$holidays)->get();
        $months = Attendance::where('period_id',$period->id)->where('date', '<=', $nowDate)->whereNotIn('date',$holidays)->select(DB::raw('YEAR(date) year, MONTH(date) month'))->distinct()->orderBy('year')->get();

        $student_attendances = Student_attendance::all();

        $presence = [];
        $students_temp = [];
        $date_temp = [];

        foreach($dates as $date){
            $date_temp[] = ['id' => $date->id, 'date' => $date->date];
        };

        foreach($s_attendances as $s_attendance){
            $temp = null;

            if(!in_array($s_attendance->nis, $students_temp)){
                array_push($students_temp, $s_attendance->nis);
                foreach($s_attendances as $s_attendance_2){
                    if($s_attendance->nis == $s_attendance_2->nis){
                        if($temp == null){
                            $temp['nis'] = $s_attendance_2->nis;
                            $temp['name'] = $s_attendance_2->name;
                            $temp['classroom_name'] = $s_attendance_2->classroom_name;
                            $temp['gender'] = $s_attendance_2->gender;
                            $temp['desc'] = [[
                                'date' => $s_attendance_2->date,
                                'month' => Carbon::parse($s_attendance_2->date)->format('m'),
                                'status' => $s_attendance_2->status,
                                'id' => $s_attendance_2->sa_id
                            ]];
                        }else{
                            array_push($temp['desc'], ['date' => $s_attendance_2->date, 'month' => Carbon::parse($s_attendance_2->date)->format('m'), 'status' => $s_attendance_2->status, 'id' => $s_attendance_2->sa_id]);
                        }
                    }
                }
                array_push($presence, $temp);
            }
        };

        $pdf = Pdf::loadView('print.index', compact('presence','dates','student_attendances','months','classroom','config_month','period'))->setPaper('a2', 'landscape');
        return $pdf->stream('print_'.$classroom->name.'_'.$period->years.'_'.$period->semester.'.pdf');
    }

    public function monthClass($id,$month,$classroom_id)
    {
       $page_title = 'Rekap Absensi';
       $action = 'index';

       $classroom = Classroom::find($classroom_id);
       $period = Period::find($id);
       $holidays = Holiday::join('holiday_groups','holidays.holiday_group_id','holiday_groups.id')->where('school_year_id',$period->school_year_id)->pluck('date');
       $config_month = config('attendance.month'); 
       $nowDate = Carbon::now()->toDateString();

       $s_attendances = Student_attendance::join('attendances', 'attendances.id','student_attendances.attendance_id')->join('student_classrooms','student_classrooms.id','student_attendances.student_classroom_id')->join('students','student_classrooms.student_id','students.user_id')->join('classrooms','student_classrooms.classroom_id','classrooms.id')->select('attendances.id as id','student_attendances.id as sa_id','student_attendances.status as status','students.name','students.gender','students.nis', 'attendances.date','classrooms.name as classroom_name','classrooms.id as c_id')->where('period_id',$period->id)->where('date', '<=', $nowDate)->where('classrooms.id',$classroom_id)->groupBy('date','student_classroom_id')->orderBy('name')->get();

       $dates = Attendance::orderBy('date')->where('period_id',$period->id)->where('date', '<=', $nowDate)->whereNotIn('date',$holidays)->whereMonth('date',$month)->get();

       $student_attendances = Student_attendance::all();

       $presence = [];
       $students_temp = [];
       $date_temp = [];

       foreach($dates as $date){
        $date_temp[] = ['id' => $date->id, 'date' => $date->date];
       };

       foreach($s_attendances as $s_attendance){
        $temp = null;

        if(!in_array($s_attendance->nis, $students_temp)){
            array_push($students_temp, $s_attendance->nis);
            foreach($s_attendances as $s_attendance_2){
                if($s_attendance->nis == $s_attendance_2->nis){
                    if($temp == null){
                        $temp['nis'] = $s_attendance_2->nis;
                        $temp['name'] = $s_attendance_2->name;
                        $temp['classroom_name'] = $s_attendance_2->classroom_name;
                        $temp['gender'] = $s_attendance_2->gender;
                        $temp['desc'] = [[
                            'date' => $s_attendance_2->date,
                            'status' => $s_attendance_2->status,
                            'id' => $s_attendance_2->sa_id
                        ]];
                    }else{
                        array_push($temp['desc'], ['date' => $s_attendance_2->date, 'status' => $s_attendance_2->status, 'id' => $s_attendance_2->sa_id]);
                    }
                }
            }
            array_push($presence, $temp);
        }
       };
        return view('recapitulation.monthclass', compact('action','page_title','presence','dates','student_attendances','month','classroom','config_month','period'));
    }

    public function printMonth($id,$month,$classroom_id)
    {
        $classroom = Classroom::find($classroom_id);
       $period = Period::find($id);
       $holidays = Holiday::join('holiday_groups','holidays.holiday_group_id','holiday_groups.id')->where('school_year_id',$period->school_year_id)->pluck('date');
       $config_month = config('attendance.month'); 
       $nowDate = Carbon::now()->toDateString();

       $s_attendances = Student_attendance::join('attendances', 'attendances.id','student_attendances.attendance_id')->join('student_classrooms','student_classrooms.id','student_attendances.student_classroom_id')->join('students','student_classrooms.student_id','students.user_id')->join('classrooms','student_classrooms.classroom_id','classrooms.id')->select('attendances.id as id','student_attendances.id as sa_id','student_attendances.status as status','students.name','students.gender','students.nis', 'attendances.date','classrooms.name as classroom_name','classrooms.id as c_id')->where('period_id',$period->id)->where('date', '<=', $nowDate)->where('classrooms.id',$classroom_id)->groupBy('date','student_classroom_id')->orderBy('name')->get();

       $dates = Attendance::orderBy('date')->where('period_id',$period->id)->where('date', '<=', $nowDate)->whereNotIn('date',$holidays)->whereMonth('date',$month)->get();

       $student_attendances = Student_attendance::all();

       $presence = [];
       $students_temp = [];
       $date_temp = [];

       foreach($dates as $date){
        $date_temp[] = ['id' => $date->id, 'date' => $date->date];
       };

       foreach($s_attendances as $s_attendance){
        $temp = null;

        if(!in_array($s_attendance->nis, $students_temp)){
            array_push($students_temp, $s_attendance->nis);
            foreach($s_attendances as $s_attendance_2){
                if($s_attendance->nis == $s_attendance_2->nis){
                    if($temp == null){
                        $temp['nis'] = $s_attendance_2->nis;
                        $temp['name'] = $s_attendance_2->name;
                        $temp['classroom_name'] = $s_attendance_2->classroom_name;
                        $temp['gender'] = $s_attendance_2->gender;
                        $temp['desc'] = [[
                            'date' => $s_attendance_2->date,
                            'status' => $s_attendance_2->status,
                            'id' => $s_attendance_2->sa_id
                        ]];
                    }else{
                        array_push($temp['desc'], ['date' => $s_attendance_2->date, 'status' => $s_attendance_2->status, 'id' => $s_attendance_2->sa_id]);
                    }
                }
            }
            array_push($presence, $temp);
        }
       };

        $pdf = Pdf::loadView('print.month', compact('presence','dates','student_attendances','month','classroom','config_month','period'))->setPaper('a2', 'landscape');
        return $pdf->stream('print_'.$classroom->name.'_'.$period->years.'_'.$period->semester.'.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
