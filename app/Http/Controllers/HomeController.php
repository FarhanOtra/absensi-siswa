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
use Barryvdh\DomPDF\Facade\Pdf;

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

        $nowDate = carbon::now()->toDateString();
        $attendance = Attendance::where('date',$nowDate)->first();

        if($attendance){
            $period = Period::find($attendance->period_id)->first();

            $students = Student_classroom::join('classrooms','classroom_id','classrooms.id')->where('school_year_id',$period->school_year_id)->count();
        
            $hadir = Student_attendance::where('attendance_id',$attendance->id)->where('status','1')->count();
            $sakit = Student_attendance::where('attendance_id',$attendance->id)->where('status','2')->count();
            $izin = Student_attendance::where('attendance_id',$attendance->id)->where('status','3')->count();
            $absen = Student_attendance::where('attendance_id',$attendance->id)->where('status','4')->count();
            $bolos = Student_attendance::where('attendance_id',$attendance->id)->where('status','5')->count();
        }else{
            $students = 1;
            $hadir = 0;
            $sakit = 0;
            $izin = 0;
            $absen = 0;
            $bolos = 0;
        }

        return view('dashboard.index', compact('page_title','action','attendance','students','hadir','sakit','izin','absen','bolos'));
        
    }

    public function data(){
        $date_now = carbon::now()->toDateString();
        $data = Attendance::join('student_attendances','attendances.id','student_attendances.attendance_id')->join('student_classrooms','student_attendances.student_classroom_id','student_classrooms.id')->join('students','students.user_id','student_classrooms.student_id')->join('users','users.id','students.user_id')->orderBy('student_attendances.time_in','DESC')->orderBy('student_attendances.id','DESC')->select('users.image','students.user_id','students.name','students.nis','student_attendances.status as st_status','student_attendances.time_in')    ->where('date',$date_now)->where('student_attendances.status',1)->limit(8)->get();
        return response()->json([$data]);
    }

    public function stat(){
        $date_now = carbon::now()->toDateString();

        $attendance = Attendance::where('date',$date_now)->first();

        $students = Student::all()->count();
        $hadir = Student_attendance::where('attendance_id', $attendance->id)->where('status','1')->count();
        $sakit = Student_attendance::where('attendance_id', $attendance->id)->where('status','2')->count();
        $izin = Student_attendance::where('attendance_id', $attendance->id)->where('status','3')->count();
        $absen = Student_attendance::where('attendance_id', $attendance->id)->where('status','4')->count();
        $bolos = Student_attendance::where('attendance_id',$attendance->id)->where('status','5')->count();

        return response()->json([
            'jumlah' => $students,
            'hadir' => $hadir,
            'sakit' => $sakit,
            'izin' => $izin,
            'absen' => $absen,
            'bolos' => $bolos,
        ]);
    }

    public function showNotification($id){
        $notification = auth('sanctum')->user()->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();
            return redirect()->route('leaves.show',[$notification->data['leave_id']]);
        }
    }

    public function qrprint($id){
        $attendance = Attendance::find($id);
        $qrcode = base64_encode(QrCode::size(400)->generate($id ?? null));
        $pdf = PDF::loadView('print.qr', compact('qrcode','attendance'));
        return $pdf->stream('print_QR_'.$attendance->date.'.pdf');
    }

    public function lock(){
        session(['locked' => 'true']);
        $page_title = 'Absensi Hari Ini';
        $action = 'index';

        $date_now = carbon::now()->toDateString();
        $students = Student::all()->count();
        if($students==0){
            $students = 1;
        }
        $attendance = Attendance::where('date',$date_now)->first();

        if($attendance){
            $hadir = Student_attendance::where('attendance_id',$attendance->id)->where('status','1')->count();
            $sakit = Student_attendance::where('attendance_id',$attendance->id)->where('status','2')->count();
            $izin = Student_attendance::where('attendance_id',$attendance->id)->where('status','3')->count();
            $absen = Student_attendance::where('attendance_id',$attendance->id)->where('status','4')->count();
            $bolos = Student_attendance::where('attendance_id',$attendance->id)->where('status','5')->count();
        }else{
            $hadir = 0;
            $sakit = 0;
            $izin = 0;
            $absen = 0;
            $bolos = 0;
        }

        return view('dashboard.lock', compact('page_title','action','attendance','students','hadir','sakit','izin','absen','bolos'));
    }
    
    public function unlock(Request $request){
        $password = $request->password;

        $this->validate($request, [
            'password' => 'required',
        ],
        [
            'required'  => 'Silahkan Masukkan Password'
        ]);

        if(\Hash::check($password, \Auth::user()->password)){
            $request->session()->forget('locked');
            return redirect('/');
        }else{
            Alert::error('Password Salah'   );
            return redirect()->back();
        }
    }

    public function sendNotification(Request $request){

        $title = $request->title;
        $body = $request->body;
        $curl = curl_init();
    
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "to":"/topics/absensi",
            "notification": {
                "title": "'.$title.'",
                "body": "'.$body.'",
            }
        }',
        CURLOPT_HTTPHEADER => array(
            'Authorization: key=AAAAUTjqx2Q:APA91bHQTtIXsSFYGMYyrH8xu_kpHUOZITvaHAKD4FM0K5A-nYLK5um7FYxLcv6bJSRxwwzYbCrAQq9cndVjvhasmI3YWcaPctlNw1DhpoqIZTVMzOPUS4D8OM0S7gR0w2Ee9-qfXHVt',
            'Content-Type: application/json'
        ),
        ));
    
        $response = curl_exec($curl);
    
        curl_close($curl);
        echo $response;
    
        return redirect()->back()->with('toast_success','Berhasil Mengirim Informasi');
    }
}
