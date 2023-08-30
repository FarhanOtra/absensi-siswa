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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Auth;

class StudentAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $validated = $request->validate([
            'nis' => 'required',
        ],
        [
            'required'  => 'Harap bagian :attribute di isi.'
        ]);

        $nowDate = Carbon::now()->toDateString();
        $attendance = Attendance::where('date',$nowDate)->first();
        $period = Period::find($attendance->period_id);
        
        $student_clasroom = $students = Student_classroom::join('students','student_classrooms.student_id','students.user_id')->join('classrooms','classroom_id','classrooms.id')->where('school_year_id',$period->school_year_id)->where('students.nis',$request->nis)->select('student_classrooms.id as id','students.nis as nis','students.name as name')->first();

        if($student_clasroom == null){
            Alert::error('Absensi Gagal', 'NIS Tidak Terdaftar pada Tahun Ajaran Ini.');
            return redirect()->back();
        }else{
            $checktime = Carbon::now()->toTimeString();
            $checkAttendance = Attendance::find($request->id);
            
            if($checkAttendance->time_limit < $checktime){
                Alert::error('Absensi Gagal', 'Sudah Melebihi Batas Waktu Absensi');
                return redirect()->back();
            }else{
                 //Check Attendance
                $check = Student_attendance::where('attendance_id',$request->id)->where('student_classroom_id',$student_clasroom->id)->where('status','!=',4)->first();
    
                if(isset($check)){
                    Alert::error('Absensi Gagal', 'Sudah Absensi Hari Ini.');
                    return redirect()->back();
                }else{
                    $time = Carbon::now()->toTimeString();
                    
                    $student_attendance = Student_attendance::where('attendance_id',$request->id)->where('student_classroom_id',$student_clasroom->id)->first();
                    if(!$student_attendance){
                        Student_attendance::create([
                            'attendance_id' => $request->id,
                            'student_classroom_id' => $student_clasroom->id,
                            'time_in' => $time,
                            'status' => 1,
                        ]); 
                    }else{
                        $student_attendance->time_in = $time;
                        $student_attendance->status = 1;
                        $student_attendance->save();
                    }
                    
                    Alert::success('Absensi Berhasil', $student_clasroom->name.' '.$student_clasroom->nis);
                    return redirect()->back();
                } 
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $user_id = Auth::user()->id;
		$user = User::find($user_id);

        $validated = $request->validate([
            'status' => 'required',
        ],[
            'required'  => 'Harap bagian :attribute di isi.',
        ]);

        $student_attendance = Student_attendance::find($id);
 
        $student_attendance->status = $request->status;
        $student_attendance->modified_by = $user->id;
        $student_attendance->note = $request->note;
        
        $student_attendance->save();

        return redirect()->back()->with('toast_success','Status Absensi Siswa Berhasil Diubah');
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
