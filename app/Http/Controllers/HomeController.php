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

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $page_title = 'Absensi Hari Ini';
        $action = 'index';

        $date_now = carbon::now()->toDateString();
        $attendance = Attendance::where('date',$date_now)->first();

        return view('dashboard.index', compact('page_title','action','attendance'));
        
    }

    public function data(){
        $date_now = carbon::now()->toDateString();
        $data = Attendance::join('student_attendances','attendances.id','student_attendances.attendance_id')->join('students','students.user_id','student_attendances.student_id')->join('users','users.id','students.user_id')->orderBy('student_attendances.time_in','DESC')->orderBy('student_attendances.id','DESC')->select('users.image','students.user_id','students.name','students.nis','student_attendances.status as st_status','student_attendances.time_in')->where('date',$date_now)->where('student_attendances.status',1)->limit(6)->get();
        return response()->json([$data]);
    }

    public function stat(){
        $date_now = carbon::now()->toDateString();

        $attendance = Attendance::where('date',$date_now)->select('id')->first();

        $students = Student::all()->count();
        $hadir = Student_attendance::where('attendance_id', $attendance->id)->where('status','1')->count();
        $sakit = Student_attendance::where('attendance_id', $attendance->id)->where('status','2')->count();
        $izin = Student_attendance::where('attendance_id', $attendance->id)->where('status','3')->count();
        $absen = Student_attendance::where('attendance_id', $attendance->id)->where('status','4')->count();

        return response()->json([
            'jumlah' => $students,
            'hadir' => $hadir,
            'sakit' => $sakit,
            'izin' => $izin,
            'absen' => $absen,
        ]);
    }
}
