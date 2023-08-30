<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Period;
use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\Student;
use App\Models\Student_attendance;
use App\Models\Student_classroom;
use App\Models\Holiday;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = 'Absensi';
        $action = __FUNCTION__;
        
        $nowDate = Carbon::now()->toDateString();
        $attendances = Attendance::where('date','<=',$nowDate)->orderByDesc('date')->get();
        $config_status = config('attendance.attendance_status');
		
        return view('attendance.index', compact('page_title','action','attendances','config_status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = 'Absensi';
        $action = 'create';

        $period = Period::where('active',1)->first();
		
        return view('attendance.create', compact('page_title','action','period'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response    
     */
    public function store(Request $request)
    {
        $date = Carbon::parse($request->date)->toDateString('Y-m-d');
        $request->merge(['date' => $date]);

        $validated = $request->validate([
            'period_id' => 'required',
            'date' => 'required|unique:attendances,date',
            'time' => 'required', 
            'time_limit' => 'required', 
        ],[ 
            'required'  => 'Harap bagian :attribute di isi.',
            'unique' => 'Absensi dengan Tanggal Tersebut Sudah Pernah Dibuat'
        ]); 

        $check = Carbon::parse($date);
        if($check->isWeekend()){
            $validator = \Validator::make([], []);

            // Add fields and errors
            $validator->errors()->add('date', 'Hari Sabtu dan Minggu Libur');
            throw new \Illuminate\Validation\ValidationException($validator);  
        }

        $period = Period::find($request->period_id);

        $holidays = Holiday::join('holiday_groups','holidays.holiday_group_id','holiday_groups.id')->where('school_year_id',$period->school_year_id)->get();
        foreach($holidays as $holiday){
            if($holiday->date == $date){
                $validator = \Validator::make([], []);

                // Add fields and errors
                $validator->errors()->add('date', $holiday->name);
                throw new \Illuminate\Validation\ValidationException($validator);
            }
        }

        $attendance = Attendance::create([
            'period_id' => $request->period_id,
            'date' => $date,
            'time' => $request['time'],
            'time_limit' => $request['time_limit'],
        ]);

        if($attendance){
            $students = Student_classroom::join('classrooms','classroom_id','classrooms.id')->where('school_year_id',$period->school_year_id)->select('*','student_classrooms.id as id')->get();
            foreach($students as $student){
                $student_attendances = Student_attendance::create([
                    'attendance_id' => $attendance->id,
                    'student_classroom_id' => $student->id,
                    'status' => 4,
                    'modified_by' => $student->student->user_id,
                ]);
            };
        }

        return redirect()->route('attendances.show',[$attendance->id])->with('toast_success','Absensi Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page_title = 'Absensi';
        $action = 'index';
        
        $attendance = Attendance::find($id);
        $date = Carbon::parse($attendance->date)->toDateString('Y-m-d');
        $period = Period::find($attendance->period_id);

        $student_attendances = Student_attendance::where('attendance_id',$id)->orderBy('time_in','DESC')->get();

        $students = Student_classroom::join('classrooms','classroom_id','classrooms.id')->where('school_year_id',$period->school_year_id)->count();
        if($students==0){
            $students = 1;
        }
        $hadir = Student_attendance::where('attendance_id',$id)->where('status','1')->count();
        $sakit = Student_attendance::where('attendance_id',$id)->where('status','2')->count();
        $izin = Student_attendance::where('attendance_id',$id)->where('status','3')->count();
        $absen = Student_attendance::where('attendance_id',$id)->where('status','4')->count();
        $bolos = Student_attendance::where('attendance_id',$id)->where('status','5')->count();

        $config_gender = config('attendance.gender');
        $config_status = config('attendance.s_attendance_status');
        $class = Classroom::where('school_year_id',$period->school_year_id)->get();

        return view('attendance.show', compact('page_title','action','attendance','hadir','sakit','izin','absen','bolos','students','student_attendances','config_gender','config_status','class'));
    }

    public function showClass($id,$classroom)
    {
        $page_title = 'Absensi';
        $action = 'index';
        
        $attendance = Attendance::find($id);
        $date = Carbon::parse($attendance->date)->toDateString('Y-m-d');
        $period = Period::find($attendance->period_id);

        $student_attendances = Student_attendance::join('student_classrooms','student_classrooms.id','student_attendances.student_classroom_id')->join('classrooms','classroom_id','classrooms.id')->where('classrooms.id',$classroom)->where('attendance_id',$id)->select('*','student_attendances.id as id')->orderBy('time_in','DESC')->get();

        $students = Student_classroom::join('classrooms','classroom_id','classrooms.id')->where('classrooms.id',$classroom)->count();
        if($students==0){
            $students = 1;
        }
        $hadir = Student_attendance::join('student_classrooms','student_classrooms.id','student_attendances.student_classroom_id')->join('classrooms','classroom_id','classrooms.id')->where('classrooms.id',$classroom)->where('attendance_id',$id)->where('status','1')->count();
        $sakit = Student_attendance::join('student_classrooms','student_classrooms.id','student_attendances.student_classroom_id')->join('classrooms','classroom_id','classrooms.id')->where('classrooms.id',$classroom)->where('attendance_id',$id)->where('status','2')->count();
        $izin = Student_attendance::join('student_classrooms','student_classrooms.id','student_attendances.student_classroom_id')->join('classrooms','classroom_id','classrooms.id')->where('classrooms.id',$classroom)->where('attendance_id',$id)->where('status','3')->count();
        $absen = Student_attendance::join('student_classrooms','student_classrooms.id','student_attendances.student_classroom_id')->join('classrooms','classroom_id','classrooms.id')->where('classrooms.id',$classroom)->where('attendance_id',$id)->where('status','4')->count();
        $bolos = Student_attendance::join('student_classrooms','student_classrooms.id','student_attendances.student_classroom_id')->join('classrooms','classroom_id','classrooms.id')->where('classrooms.id',$classroom)->where('attendance_id',$id)->where('status','5')->count();

        $config_gender = config('attendance.gender');
        $config_status = config('attendance.s_attendance_status');

        return view('attendance.class', compact('page_title','action','attendance','hadir','sakit','izin','absen','bolos','students','student_attendances','config_gender','config_status'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_title = 'Absensi';
        $action = 'create';

        $periods = Period::all();
        $attendance = Attendance::find($id);

        return view('attendance.edit', compact('page_title','action','periods','attendance'));
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
        $date = Carbon::parse($request->date)->toDateString('d-M-Y');
        $request->merge(['date' => $date]);

        $validated = $request->validate([ 
            'period_id' => 'required',
            'date' => 'required|unique:attendances,date,'.$id,
            'time' => 'required', 
            'time_limit' => 'required', 
        ],[
            'required'  => 'Harap bagian :attribute di isi.',
            'unique' => 'Absensi dengan Tanggal Tersebut Sudah Dibuat'
        ]);

        $date = Carbon::parse($request->date)->toDateString('Y-m-d');
        $period = Period::find($request->period_id);

        $attendance = Attendance::find($id);
 
        $attendance->period_id = $request->period_id;
        $attendance->date = $date;
        $attendance->time = $request->time;
        $attendance->time_limit = $request->time_limit;
        
        $attendance->save();

        return redirect()->route('attendances.show',[$id])->with('toast_success','Absensi Berhasil Diubah');
    }

    // public function statusUpdate($id)
    // {
        
    //     $attendance = Attendance::find($id);

    //     if($attendance->status == 1){
    //         $attendance->status = 2;
    //         $attendance->save();
    
    //         $s_attendances = Student_attendance::where('attendance_id',$id)->pluck('student_id')->all();
    //         $students = Student::whereNotIn('user_id', $s_attendances)->get();
    
    //         foreach($students as $student){
    //             $student_attendances = Student_attendance::create([
    //                 'attendance_id' => $attendance->id,
    //                 'student_id' => $student->user_id,
    //                 'status' => 4,
    //             ]);
    //         };
    //         return redirect()->back()->with('toast_success','Absensi Berhasil Ditutup');
    //     }else{
    //         return redirect()->back()->with('toast_error','Absensi Sudah Ditutup');
    //     }  
    // }

    public function studentStatusUpdate(Request $request, $id)
    {
        
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $attendance = Attendance::find($id);
        $attendance->delete();
        return redirect()->back()->with('toast_success','Berhasil Dihapus');
    }

}
