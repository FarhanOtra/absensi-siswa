<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Classroom;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $page_title = 'Siswa';
        $action = __FUNCTION__;

        if(Auth()->user()->role == 'admin'){
            $students = Student::all();
        };

        if(Auth()->user()->role == 'teacher'){
            $teacher_id = Auth()->user()->id;
            $classroom_id = Classroom::where('teacher_id',$teacher_id)->first('id');
            $students = Student::where('classroom_id',$classroom_id->id)->get();
        };

        $config_gender = config('attendance.gender');
        return view('student.index', compact('page_title','action','students','config_gender'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = 'Siswa';
        $action = 'create';

        $classrooms = Classroom::all();
		
        return view('student.create', compact('page_title','action','classrooms'));
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
            'username' => 'required|unique:users',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:8',
            'nis' => 'required|unique:students',
            'name' => 'required',
            'gender' => 'required',
            'image' => 'image|mimes:jpg,png,jpeg'
        ],
        [
            'required'  => 'Harap bagian :attribute di isi.',
            'min'  => 'Password Harus Lebih dari 8 Karakter',
            'unique'    => ':attribute sudah digunakan',
            'image'     => 'File upload harus berupa image',
            'mimes'     => 'Jenis file Salah',
        ]);

        if($request->file('image')){
            $image = $request->file('image')->store('image/teacher'); 
        }else{
            $image = null;
        };

        if($request->classroom_id){
            $classrooms_id = $request->classroom_id;
        }else{
            $classrooms_id = null;
        };

        $user = User::create([
            'username' => $request['username'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'role' => 'student',
            'image' => $image,
        ]);

        $student = Student::create([
            'user_id' =>  $user->id,  
            'nis' => $request['nis'],
            'name' => $request['name'],
            'gender' => $request['gender'],
            'classroom_id' => $request['classroom_id'],
            'image' => $image,
        ]);

        if($request->file('image')){
            $request->file('image')->store('image/student'); 
        }

        return redirect()->route('students.index')->with('toast_success','Siswa Berhasil Ditambahkan');
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
        $page_title = 'Siswa';
        $action = 'create';

        $student = Student::where('user_id',$id)->first();
		$classrooms = Classroom::all();

        return view('student.edit', compact('page_title','action','student','classrooms'));
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
            'username' => 'required|unique:users,username,'.$id,
            'email' => 'required|email|unique:users,email,'.$id,
            'nis' => 'required|unique:students,nis,'.$id.',user_id',
            'name' => 'required',
            'gender' => 'required',
            'image' => 'image|mimes:jpg,png,jpeg'
        ],
        [
            'required'  => 'Harap bagian :attribute di isi.',
            'unique'    => ':attribute sudah digunakan',
            'image'     => 'File upload harus berupa image',
            'mimes'     => 'Jenis file',
        ]);

        if($request->file('image')){
            $image = $request->file('image')->store('image/student'); 
        }else{
            $image = $request->imageNow;
        };

        $user = User::find($id);
 
        $user->username = $request->username;
        $user->email = $request->email;
        $user->image = $image;
        
        $user->save();

        Student::where('user_id', $id)->update([
            'nis' => $request->nis,
            'name' => $request->name,
            'gender' => $request->gender,
            'classroom_id' => $request->classroom_id,
        ]);

        if($request->file('image')){
            $request->file('image')->store('image/student'); 
            Storage::delete($request->imageNow);
        }

        return redirect()->route('students.index')->with('toast_success','Berhasil Dirubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        Storage::delete($user->image);
        return redirect()->route('students.index')->with('toast_success','Berhasil Dihapus');
    }
}
