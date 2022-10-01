<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Period;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\Classroom;
use App\Models\Student_attendance;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Collection;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class PeriodController extends Controller
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

        $periods = Period::orderByDesc('years')->orderByDesc('semester')->get();
        $classrooms = Classroom::orderByDesc('name')->get();
		
        return view('period.index', compact('page_title','action','periods','classrooms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = 'Daftar Absensi';
        $action = 'create';
		
        return view('period.create', compact('page_title','action'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'years' => 'required',
            'semester' => 'required|unique:periods,semester,NULL,id,years,'.request('years'),
        ],[
            'required'  => 'Harap bagian :attribute di isi.',
            'unique'  => 'Tahun Ajaran Sudah Pernah Dibuat',
        ]);

        $period = Period::create([
            'years' => $request['years'],
            'semester' => $request['semester'],
        ]);

        return redirect()->route('periods.index')->with('toast_success','Tahun Ajaran Berhasil Ditambahkan');
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
        $attendances = Attendance::where('period_id',$id)->groupBy('month')->distinct()->orderByDesc('month')->get('month');
        $classrooms = Classroom::orderByDesc('name')->get();
        $config_month = config('attendance.month');
		
        return view('period.show', compact('page_title','action','period','attendances','config_month','classrooms'));
    }

    public function month($id, $month)
    {
        $page_title = 'Rekap Absensi';
        $action = 'index';
        $config_month = config('attendance.month');
        $config_status = config('attendance.attendance_status');

        $attendances = Attendance::where('period_id',$id)->where('month',$month)->orderByDesc('date')->get();
        $period = Period::find($id);
		
        return view('period.month', compact('page_title','action','attendances','period','month','config_month','config_status'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_title = 'Daftar Absensi';
        $action = 'create';

        $period = Period::find($id);

        return view('period.edit', compact('page_title','action','period'));
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
        $validated = $request->validate([
            'years' => 'required',
            'semester' => 'required|unique:periods,semester,'.$id.',id,years,'.request('years'),
        ],[
            'required'  => 'Harap bagian :attribute di isi.',
            'unique'  => 'Tahun Ajaran Sudah Ada',
        ]);

        $period = Period::find($id);
 
        $period->years = $request->years;
        $period->semester = $request->semester;
        
        $period->save();

        return redirect()->route('periods.index')->with('toast_success','Tahun Ajaran Berhasil Dirubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $period = Period::find($id);
        $period->delete();
        return redirect()->route('periods.index')->with('toast_success','Berhasil Dihapus');
    }

    public function print($id, $classroom_id)
    {
        $classroom = Classroom::find($classroom_id);
        $period = Period::find($id);
        $config_month = config('attendance.month'); 

        $s_attendances = Student_attendance::join('attendances', 'attendances.id','student_attendances.attendance_id')->join('students','students.user_id','student_attendances.student_id')->join('classrooms','students.classroom_id','classrooms.id')->select('attendances.period_id as p_id','attendances.id as id','student_attendances.id as sa_id','student_attendances.status as status','students.name','students.gender','students.nis', 'attendances.date','attendances.month','classrooms.name as classroom_name','classrooms.id as c_id')->where('period_id',$id)->where('classrooms.id',$classroom_id)->groupBy('date','user_id')->orderBy('nis')->get();

        $dates = Attendance::orderBy('date')->where('period_id',$id)->get();
        $months = Attendance::where('period_id',$id)->groupBy('month')->get('month');

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
                                'month' => $s_attendance_2->month,
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

        $pdf = Pdf::loadView('print.index', compact('presence','dates','student_attendances','months','classroom','config_month','period'))->setPaper('a2', 'landscape');
        return $pdf->stream('print_'.$classroom->name.'_'.$period->years.'_'.$period->semester.'.pdf');
    }

    public function printMonth($id,$month,$classroom_id)
    {
       $classroom = Classroom::find($classroom_id);
       $period = Period::find($id);
       $config_month = config('attendance.month'); 

       $s_attendances = Student_attendance::join('attendances', 'attendances.id','student_attendances.attendance_id')->join('students','students.user_id','student_attendances.student_id')->join('classrooms','students.classroom_id','classrooms.id')->select('attendances.period_id as p_id','attendances.id as id','student_attendances.id as sa_id','student_attendances.status as status','students.name','students.gender','students.nis', 'attendances.date','classrooms.name as classroom_name','classrooms.id as c_id')->where('month',$month)->where('period_id',$id)->where('classrooms.id',$classroom_id)->groupBy('date','user_id')->orderBy('nis')->get();

       $dates = Attendance::orderBy('date')->where('period_id',$id)->where('month',$month)->get();

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
}
