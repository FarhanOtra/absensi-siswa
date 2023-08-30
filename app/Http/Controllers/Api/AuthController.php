<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Student;
use App\Models\Period;
use App\Models\Student_classroom;
 
class AuthController extends Controller
{
    
    public function login(Request $request){
        $this->validate($request, [
            'nis' => 'required',
            'password' => 'required'
        ],[
            'required'  => 'Harap bagian :attribute di isi.'
        ]);

        $nis = $request->input('nis');
        $password = $request->input('password');

        $user = User::join('students','user_id','id')->where('nis', $nis)->first();
        if (!$user) {
            return response()->json(['message' => 'Login failed'], 401);
        }

        if ($user->role !== 'student') {
            return response()->json(['message' => 'Login failed'], 401);
        }

        $isValidPassword = Hash::check($password, $user->password);
        if (!$isValidPassword) {
            return response()->json(['message' => 'Login failed'], 401);
        }

        $token = $user->createToken('token')->plainTextToken;

        $period = Period::where('active',1)->first();
        $student_classroom = Student_classroom::join('classrooms','classrooms.id','student_classrooms.classroom_id')->where('student_id',$user->id)->where('classrooms.school_year_id',$period->school_year_id)->select('classrooms.name as name','classrooms.grade as grade')->first();
        
        if($student_classroom){
            $classroom_name = $student_classroom->grade." ".$student_classroom->name;
        }else{
            $classroom_name = "Tidak Ada Kelas";
        }

        $student = Student::where('user_id',$user->id)->first();

        return response()->json([
            'message' => 'success',
            'data' => [
                'name' => $student->name,
                'classroom' => $classroom_name,
                'nis' => $student->nis,
                'image' => $student->user->image,
            ],
            'token' => $token,
        ],200);
    }

    public function changePassword(Request $request)
    {
        $user_id =auth('sanctum')->user()->id;

        $this->validate($request, [
            'oldPassword' => 'required',
            'newPassword' => 'required|min:8',
            'confirmPassword' => 'required|min:8'
        ]);

        $user = User::find($user_id);

        if($user) {
        $isValidPassword = Hash::check($request->oldPassword, $user->password);
            if (!$isValidPassword) {
                return response()->json(['message' => 'Password Lama Salah'], 401);
            }else{
                if($request->newPassword==$request->confirmPassword){
                    $user->password = Hash::make($request->newPassword) ;
                    $user->save();
                    return response()->json([
                        'success'   => true,
                        'message'   => 'Berhasil Merubah Password'
                    ], 200);
                }else{
                    return response()->json(['message' => 'Password Baru Tidak Sama'], 401);
                }
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User Tidak Ditemukan!',
            ], 404);
        }
    }

    public function logout()
    {
        $user =auth('sanctum')->user();
        $user->currentAccessToken()->delete();

        return [
            'success' => true,
            'message' => 'Tokens Delete'
        ];
    }
}
