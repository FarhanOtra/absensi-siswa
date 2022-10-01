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
        $attendances = Attendance::orderByDesc('date')->get();
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

        $periods = Period::orderByDesc('years')->orderByDesc('semester')->get();
		
        return view('attendance.create', compact('page_title','action','periods'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response    
     */
    public function store(Request $request)
    {
        $date = Carbon::parse($request->date)->toDateString('d-M-Y');
        $request->merge(['date' => $date]);

        $validated = $request->validate([
            'period_id' => 'required',
            'date' => 'required|unique:attendances',
            'time' => 'required', 
        ],[
            'required'  => 'Harap bagian :attribute di isi.',
            'unique' => 'Absensi dengan Tanggal Tersebut Sudah Pernah Dibuat'
        ]);

        $date = Carbon::parse($request->date)->toDateString('d-M-Y');
        $month = Carbon::parse($request->date)->translatedFormat('m');

        $attendance = Attendance::create([
            'period_id' => $request['period_id'],
            'date' => $date,
            'month' => $month,
            'time' => $request['time'],
            'status' => 1,
        ]);

        // $students = Student::all();

        // foreach($students as $student){
        //     $student_attendances = Student_attendance::create([
        //         'attendance_id' => $attendance->id,
        //         'student_id' => $student->user_id,
        //     ]);
        // };

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
        $student_attendances = Student_attendance::where('attendance_id',$id)->get();

        $students = Student::all()->count();
        $hadir = Student_attendance::where('attendance_id',$id)->where('status','1')->count();
        $sakit = Student_attendance::where('attendance_id',$id)->where('status','2')->count();
        $izin = Student_attendance::where('attendance_id',$id)->where('status','3')->count();
        $absen = Student_attendance::where('attendance_id',$id)->where('status','4')->count();

        $config_gender = config('attendance.gender');
        $config_status = config('attendance.s_attendance_status');

        return view('attendance.show', compact('page_title','action','attendance','hadir','sakit','izin','absen','students','student_attendances','config_gender','config_status'));
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
        ],[
            'required'  => 'Harap bagian :attribute di isi.',
            'unique' => 'Absensi dengan Tanggal Tersebut Sudah Dibuat'
        ]);

        $date = Carbon::parse($request->date)->toDateString('d-M-Y');
        $month = Carbon::parse($request->date)->translatedFormat('m');

        $attendance = Attendance::find($id);
 
        $attendance->period_id = $request->period_id;
        $attendance->date = $date;
        $attendance->month = $month;
        $attendance->time = $request->time;
        
        $attendance->save();

        return redirect()->route('attendances.show',[$id])->with('toast_success','Absensi Berhasil Dirubah');
    }

    public function statusUpdate($id)
    {
        
        $attendance = Attendance::find($id);

        if($attendance->status == 1){
            $attendance->status = 2;
            $attendance->save();
    
            $s_attendances = Student_attendance::join('attendances', 'attendances.id','student_attendances.attendance_id')->join('students','students.user_id','student_attendances.student_id')->join('classrooms','students.classroom_id','classrooms.id')->select('attendances.id as id','student_attendances.id as sa_id','student_attendances.status as status','students.name','students.nis', 'attendances.date','classrooms.name as classroom_name')->where('month',$id)->groupBy('date','user_id')->orderBy('nis')->get();
            $students = Student::whereNotIn('user_id', $s_attendances)->get();
    
            foreach($students as $student){
                $student_attendances = Student_attendance::create([
                    'attendance_id' => $attendance->id,
                    'student_id' => $student->user_id,
                    'status' => 4,
                ]);
            };
            return redirect()->back()->with('toast_success','Absensi Berhasil Ditutup');
        }else{
            return redirect()->back()->with('toast_error','Absensi Sudah Ditutup');
        }  
    }

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
