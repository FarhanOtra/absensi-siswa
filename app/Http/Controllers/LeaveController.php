<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Classroom;
use App\Models\Leave;
use App\Models\Attendance;
use App\Models\Student_attendance;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use File;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = 'Permohonan';
        $action = __FUNCTION__;
 
        if(Auth()->user()->role == 'admin'){
            $leaves = Leave::join('student_classrooms','student_classrooms.id','leaves.student_classroom_id')->join('students','students.user_id','student_classrooms.student_id')->join('classrooms','classrooms.id','student_classrooms.classroom_id')->select('*','leaves.id as id','students.nis as nis','students.name as name','classrooms.name as classroom_name','classrooms.grade as classroom_grade','leaves.type as type','leaves.status as status')->orderBy('leaves.created_at','DESC')->get();
        };

        if(Auth()->user()->role == 'teacher'){
            $teacher_id = Auth()->user()->id;
            $classroom = Classroom::where('teacher_id', Auth('sanctum')->user()->id)->first();

            if($classroom){
                $leaves = $leaves = Leave::join('student_classrooms','student_classrooms.id','leaves.student_classroom_id')->join('students','students.user_id','student_classrooms.student_id')->join('classrooms','classrooms.id','student_classrooms.classroom_id')->select('*','leaves.id as id','students.nis as nis','students.name as name','classrooms.name as classroom_name','classrooms.grade as classroom_grade','leaves.type as type','leaves.status as status')->where('classrooms.id',$classroom->id)->orderBy('leaves.created_at','DESC')->get();
            }else{
                $leaves = [];
            }
        };

        $config_type = config('attendance.s_attendance_status');
        $config_status = config('attendance.leave_status');

        return view('leave.index', compact('page_title','action','leaves','config_type','config_status'));
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
        $page_title = 'Permohonan';
        $action = 'index';

        $leave = Leave::join('leave_attendances','leave_attendances.leave_id','leaves.id')->join('attendances','attendances.id','leave_attendances.attendance_id')->join('student_classrooms','student_classrooms.id','leaves.student_classroom_id')->join('students','students.user_id','student_classrooms.student_id')->join('classrooms','classrooms.id','student_classrooms.classroom_id')->join('users','users.id','students.user_id')->where('leaves.id',$id)->select('*','leaves.id as id','students.nis as nis','students.name as name','classrooms.name as classroom_name','classrooms.grade as classroom_grade','leaves.type as type','leaves.status as status')->first();

        $dates = Leave::join('leave_attendances','leave_attendances.leave_id','leaves.id')->join('attendances','attendances.id','leave_attendances.attendance_id')->where('leaves.id',$id)->get();
        
        $config_type = config('attendance.s_attendance_status');

        return view('leave.show', compact('page_title','action','leave','dates','config_type'));
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
        $leave = Leave::find($id);
        $leaves = Leave::join('leave_attendances','leave_attendances.leave_id','leaves.id')->join('attendances','attendances.id','leave_attendances.attendance_id')->select('*','leaves.id as id','attendances.id as attendance_id')->get();

        if(isset($leaves)){
            $status = $request->status;
            if($status == 3){
                $leave->status = 3;
                $leave->save();
                Alert::success('Permohonan Berhasil Ditolak');
                return redirect()->route('leaves.index');
            }else if($status == 2){
                foreach($leaves as $l){
                    $student_attendance = Student_attendance::where('student_classroom_id',$l->student_classroom_id)->where('attendance_id',$l->attendance_id)->first();
                    $student_attendance->status = $l->type;
                    $student_attendance->save();
                }
                $leave->status = 2;
                $leave->save();
                Alert::success('Permohonan Berhasil Disetujui');
                return redirect()->route('leaves.index');
            }
        }else{
            
            Alert::error('Absensi Belum Dibuat!', 'Absensi '. \Carbon\Carbon::parse($leave->date)->translatedFormat('l, d F Y') .' belum Dibuat.');
            return redirect()->back();
        }
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
