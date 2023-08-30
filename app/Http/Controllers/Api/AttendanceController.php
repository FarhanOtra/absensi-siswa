<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Student_attendance;
use App\Models\Student_classroom;
use App\Models\Student;
use App\Models\Classroom;
use App\Models\Leave;
use App\Models\Leave_attendance;
use App\Models\Period;
use App\Models\Attendance;
use App\Models\Holiday;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Notification;
use DB;
use App\Notifications\NewLeaveNotification;

class AttendanceController extends Controller
{
    public function getAttendance($id){

        $user_id =auth('sanctum')->user()->id;
        $activePeriod = Period::where('active',1)->first();
        $student_classroom = Student_classroom::join('classrooms','classrooms.id','student_classrooms.classroom_id')->join('school_years','school_years.id','classrooms.school_year_id')->where('classrooms.school_year_id',$activePeriod->school_year_id)->where('student_classrooms.student_id',$user_id)->select('*','student_classrooms.id as id')->first();
        if(!$student_classroom){
            return response()->json(['success' => true,'message' => 'Siswa Tidak Terdaftar pada Tahun Ajaran Sekarang'],400);
        }
        
        $now = Carbon::now()->toTimeString();
        $nowDate = Carbon::now()->toDateString();

        $checkAttendance = Attendance::find($id);

        if($checkAttendance->date == $nowDate){
            if($checkAttendance->time_limit < $now){
                return response()->json(['success' => true,'message' => 'Sudah Melewati Batas Waktu'],400);
            }else{
                //Check Attendance
                $check = Student_attendance::where('attendance_id',$id)->where('student_classroom_id',$student_classroom->id)->where('status','!=',4)->first();

                if(isset($check)){
                    return response()->json(['success' => true,'message' => 'Sudah Absensi'],400);
                }else{
                    $time = Carbon::now()->toTimeString();
                    Student_attendance::where('attendance_id',$id)->where('student_classroom_id',$student_classroom->id)->update([
                        'time_in' => $time,
                        'status' => 1,
                    ]);
                    return response()->json(['success' => true,'message' => 'Absensi Berhasil'],200);
                } 
            }
        }else{
            return response()->json(['success' => true,'message' => 'Absensi Sudah Ditutup'],400);
        }
    }

    public function home(){
        $user_id =auth('sanctum')->user()->id;

        $now = Carbon::now()->toDateString();
        $attendance_today = Attendance::where('date',$now)->first();
        if($attendance_today!=null){
            $id = $attendance_today->id;
            $time = Carbon::parse($attendance_today->time)->translatedFormat('H:i');
        }else{
            $id = null;
            $time = null;
        }

        if($id!=null){
            $sattendance = Student_attendance::join('attendances', 'attendances.id','student_attendances.attendance_id')->join('student_classrooms','student_classrooms.id','student_attendances.student_classroom_id')->join('students','student_classrooms.student_id','students.user_id')->join('classrooms','student_classrooms.classroom_id','classrooms.id')->select('student_attendances.id as id','student_classrooms.id as student_classroom_id','student_attendances.status as status','student_attendances.time_in as time_in')->where('attendances.id',$id)->where('student_classrooms.student_id',$user_id)->first();
        }

        if(isset($sattendance)){
            if($sattendance->status!=1){
                $time_in = null;
            }else{
                if($sattendance->time_in!=null){
                    $time_in = Carbon::parse($sattendance->time_in)->translatedFormat('H:i');
                }else{
                    $time_in = null;
                }
            }
            $status = $sattendance->status;
        }else{
            $time_in= null;
            $status = null;
        }

        $activePeriod = Period::where('active',1)->first();
        $nowDate = Carbon::now()->toDateString();
        $student_classroom = Student_classroom::join('classrooms','classrooms.id','student_classrooms.classroom_id')->where('student_id',$user_id)->where('classrooms.school_year_id',$activePeriod->school_year_id)->select('*','student_classrooms.id as id')->first();
        $holidays = Holiday::join('holiday_groups','holidays.holiday_group_id','holiday_groups.id')->where('school_year_id',$activePeriod->school_year_id)->pluck('date');

        $hadir = Student_attendance::join('student_classrooms','student_classrooms.id','student_attendances.student_classroom_id')->join('attendances','attendances.id','attendance_id')->where('period_id',$activePeriod->id)->where('student_classroom_id',$student_classroom->id)->whereNotIn('date',$holidays)->where('attendances.date','<=',$nowDate)->where('student_attendances.status',1)->count();
        $sakit = Student_attendance::join('student_classrooms','student_classrooms.id','student_attendances.student_classroom_id')->join('attendances','attendances.id','attendance_id')->where('period_id',$activePeriod->id)->where('student_classroom_id',$student_classroom->id)->whereNotIn('date',$holidays)->where('attendances.date','<=',$nowDate)->where('student_attendances.status',2)->count();
        $izin = Student_attendance::join('student_classrooms','student_classrooms.id','student_attendances.student_classroom_id')->join('attendances','attendances.id','attendance_id')->where('period_id',$activePeriod->id)->where('student_classroom_id',$student_classroom->id)->whereNotIn('date',$holidays)->where('attendances.date','<=',$nowDate)->where('student_attendances.status',3)->count();
        $absen = Student_attendance::join('student_classrooms','student_classrooms.id','student_attendances.student_classroom_id')->join('attendances','attendances.id','attendance_id')->where('period_id',$activePeriod->id)->where('student_classroom_id',$student_classroom->id)->whereNotIn('date',$holidays)->where('attendances.date','<=',$nowDate)->where('student_attendances.status',4)->count();
        $bolos = Student_attendance::join('student_classrooms','student_classrooms.id','student_attendances.student_classroom_id')->join('attendances','attendances.id','attendance_id')->where('period_id',$activePeriod->id)->where('student_classroom_id',$student_classroom->id)->whereNotIn('date',$holidays)->where('attendances.date','<=',$nowDate)->where('student_attendances.status',5)->count();

        return response()->json([
            'success' => true,
            'attendance' => [
                'id' => $id,
                'time' => $time,
                'time_in' => $time_in,
                'status' => $status
            ],
            'rekap' => [
                'years' => $activePeriod->year->year_start.'/'.$activePeriod->year->year_end,
                'semester' => $activePeriod->semester,
                'hadir' => $hadir,
                'sakit' => $sakit,
                'izin' => $izin,
                'absen' => $absen,
                'bolos' => $bolos
            ],
            'message' => 'Berhasil'
        ],200);
    }

    public function getHistory(){

        $user_id =auth('sanctum')->user()->id;

        $nowDate = Carbon::now()->toDateString();
        $activePeriod = Period::where('active',1)->first();
        $period = null;
        if($activePeriod){
            $periods = Period::join('school_years','school_years.id','periods.school_year_id')->where('periods.id',$activePeriod->id)->first();
            $period = "Tahun Ajaran ".$periods->year_start."/".$periods->year_end." Semester ".$periods->semester;
        }
        $holidays = Holiday::join('holiday_groups','holidays.holiday_group_id','holiday_groups.id')->where('school_year_id',$activePeriod->school_year_id)->pluck('date');
        $student_classroom = Student_classroom::join('classrooms','classrooms.id','student_classrooms.classroom_id')->join('school_years','school_years.id','classrooms.school_year_id')->where('classrooms.school_year_id',$activePeriod->school_year_id)->where('student_classrooms.student_id',$user_id)->first();
        
        if($student_classroom){
            $history = Student_attendance::join('student_classrooms','student_classrooms.id','student_attendances.student_classroom_id')->join('attendances','attendances.id','student_attendances.attendance_id')->where('student_classrooms.student_id',$user_id)->where('period_id',$activePeriod->id)->whereNotIn('date',$holidays)->where('attendances.date','<=',$nowDate)->select('attendances.id as id','student_attendances.status as status', 'student_attendances.time_in', 'attendances.date')->orderBy('date','DESC')->get();
            $time = Carbon::now()->toTimeString();
            if($history){
                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil',
                    'period' => $period,
                    'history' => $history,
                ],200);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'History Tidak Ditemukan!',
                ], 404);
            } 
        }
    }

    public function getRequest(){

        $user_id =auth('sanctum')->user()->id;

        $activePeriod = Period::where('active',1)->first();
        $period = null;
        if($activePeriod){
            $periods = Period::join('school_years','school_years.id','periods.school_year_id')->where('periods.id',$activePeriod->id)->first();
            $period = "Tahun Ajaran ".$periods->year_start."/".$periods->year_end." Semester ".$periods->semester;
        }

        $student_classroom = Student_classroom::join('classrooms','classrooms.id','student_classrooms.classroom_id')->join('school_years','school_years.id','classrooms.school_year_id')->where('classrooms.school_year_id',$activePeriod->school_year_id)->select('*','student_classrooms.id as id')->where('student_classrooms.student_id',$user_id)->first();
        $leaves = Leave::join('student_classrooms','student_classrooms.id','leaves.student_classroom_id')->join('leave_attendances','leave_attendances.leave_id','leaves.id')->join('attendances','attendances.id','leave_attendances.attendance_id')->select('leaves.id','type','title','desc','leaves.status','leaves.created_at as date', DB::raw('MAX(attendances.date) as end_date'), DB::raw('MIN(attendances.date) as start_date'))->where('leaves.student_classroom_id',$student_classroom->id)->where('attendances.period_id',$activePeriod->id)->groupBy('leaves.student_classroom_id')->groupBy('leaves.id')->orderBy('leaves.created_at','DESC')->get();
        if($leaves){
            return response()->json([
                'success' => true,
                'message' => 'Berhasil',
                'period' => $period,
                'request' => $leaves,
            ],200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Request Tidak Ditemukan!',
            ], 404);
        } 
    }

    public function postLeave(Request $request){

        $user_id =auth('sanctum')->user()->id;
        $activePeriod = Period::where('active',1)->first();
        $student_classroom = Student_classroom::join('classrooms','classrooms.id','student_classrooms.classroom_id')->join('school_years','school_years.id','classrooms.school_year_id')->where('classrooms.school_year_id',$activePeriod->school_year_id)->where('student_classrooms.student_id',$user_id)->select('*','student_classrooms.id as id')->first();
        if(!$student_classroom){
            return response()->json([
                'success' => false,
                'message' => "Siswa Tidak Terdaftar pada Tahun Ajaran Sekarang",
            ], 401);
        }

        $dates = explode(' - ', $request->date);
        $start_date = Carbon::createFromFormat('d/m/Y',$dates[0])->format('Y-m-d');
        $end_date = Carbon::createFromFormat('d/m/Y',$dates[1])->format('Y-m-d');
        
        $dates = CarbonPeriod::create($start_date, $end_date);

        foreach($dates as $date){
            $weekend = Carbon::parse($date);
            if($weekend->isWeekend()){
                return response()->json([
                    'success' => false,
                    'message' => "Hari Sabtu dan Minggu Libur",
                ], 401); 
            }
            $check = Holiday::join('holiday_groups','holiday_groups.id','holidays.holiday_group_id')->where('date',$date)->count();
            if($check > 0){
                return response()->json([
                    'success' => false,
                    'message' => \Carbon\Carbon::parse($date)->translatedFormat('l, d M Y')." Merupakan Hari Libur",
                ], 401);
            }
        }

        $file = $request->file('file')->store('file/leave'); 

        $leave = Leave::create([
            'student_classroom_id' => $student_classroom->id,
            'date_start' => $start_date,
            'date_end' => $end_date,
            'type' => $request->type,
            'title' => $request->title,
            'desc' => $request->desc,
            'attachment' => $file,
            'status' => 1,
        ]);

        foreach($dates as $date){
            $attendance = Attendance::where('date',$date)->first();
            if(!$attendance){
                $attendance = Attendance::create([
                    'date' => $date,
                    'period_id' => $activePeriod->id,
                    'time' => '07:30',
                    'time_limit'=>'08:30',
                ]);

                $students = Student_classroom::join('classrooms','classroom_id','classrooms.id')->where('school_year_id',$activePeriod->school_year_id)->select('*','student_classrooms.id as id')->get();
                foreach($students as $student){
                    $student_attendances = Student_attendance::create([
                        'attendance_id' => $attendance->id,
                        'student_classroom_id' => $student->id,
                        'status' => 4,
                        'modified_by' => $student->student->user_id,
                    ]);
                };
            }
            $Leave_attendance = Leave_attendance::create([
                'attendance_id' => $attendance->id,
                'leave_id' => $leave->id,
            ]);
        }

        if($leave){
            $teacher = User::join('teachers','teachers.user_id','users.id')->join('classrooms','teachers.user_id','classrooms.teacher_id')->where('role','teacher')->where('classrooms.id',$student_classroom->classroom->id)->select('users.id as id')->first();
            $teacher->notify(new NewLeaveNotification($student_classroom,$leave));
            $admin = User::where('role','admin')->first();
            $admin->notify(new NewLeaveNotification($student_classroom,$leave));

            return response()->json([
                'success' => true,
                'message' => 'Berhasil'
            ],200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Gagal'
            ], 401);
        }   
    }
}
