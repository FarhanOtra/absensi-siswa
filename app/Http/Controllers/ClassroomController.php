<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Classroom;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = 'Kelas';
        $action = __FUNCTION__;

        if(Auth()->user()->role == 'admin'){
            $classrooms = Classroom::all();
        };

        if(Auth()->user()->role == 'teacher'){
            $teacher_id = Auth()->user()->id;
            $classrooms = Classroom::where('teacher_id',$teacher_id)->get();
        };
		
        return view('classroom.index', compact('page_title','action','classrooms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = 'Kelas';
        $action = 'create';

        $teacher_id = Classroom::pluck('teacher_id')->all();
        $teachers = Teacher::whereNotIn('user_id', $teacher_id)->get();
		
        return view('classroom.create', compact('page_title','action','teachers'));
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
            'name' => 'required|unique:classrooms',
            'teacher_id' => 'required|unique:classrooms',
        ],
        [
            'required'  => 'Harap bagian :attribute di isi.',
            'teacher_id.required'  => 'Harap Pilih Guru Wali Kelas.',
            'name.unique'    => ':attribute sudah digunakan',
            'teacher_id.unique'    => 'Guru sudah menjadi Wali Kelas',
        ]);

        $classroom = Classroom::create([
            'name' => $request['name'],
            'teacher_id' => $request['teacher_id'],
        ]);

        return redirect()->route('classrooms.index')->with('toast_success','Kelas Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page_title = 'Kelas';
        $action = 'index';

        $classroom = Classroom::find($id);
        $students_all = Student::where('classroom_id','!=',$id)->orWhere('classroom_id','=',null)->get();
        $students = Student::where('classroom_id',$id)->get();
        $config_gender = config('attendance.gender');
        $l = $students->where('gender','L')->count();
        $p = $students->where('gender','P')->count();
		
        return view('classroom.show', compact('page_title','action','classroom','students_all','students','l','p','config_gender'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_title = 'Kelas';
        $action = 'create';

        $classroom = Classroom::where('id',$id)->first();

        $teacher_id = Classroom::pluck('teacher_id')->all();
        $teachers = Teacher::whereNotIn('user_id', $teacher_id)->get();
		
        return view('classroom.edit', compact('page_title','action','classroom','teachers'));
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
            'name' => 'required|unique:classrooms,name,'.$id,
            'teacher_id' => 'required|unique:classrooms,teacher_id,'.$id,
        ],
        [
            'required'  => 'Harap bagian :attribute di isi.',
            'teacher_id.required'  => 'Harap Pilih Guru Wali Kelas.',
            'name.unique'    => ':attribute sudah digunakan',
            'teacher_id.unique'    => 'Guru sudah menjadi Wali Kelas',
        ]);

        $classroom = Classroom::find($id);
 
        $classroom->name = $request->name;
        $classroom->teacher_id = $request->teacher_id;
        
        $classroom->save();

        return redirect()->route('classrooms.show',[$id])->with('toast_success','Berhasil Dirubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $classroom = Classroom::find($id);
        $classroom->delete();
        return redirect()->route('classrooms.index')->with('toast_success','Berhasil Dihapus');
    }

    public function addStudent(Request $request, $id)
    {
        $student = Student::whereIn('user_id', $request->data)->update(['classroom_id' => $id]);
        return back()->with('toast_success','Berhasil Ditambahkan');
    }

    public function destroyStudent($id)
    {
        $student = Student::where('user_id',$id)->update(['classroom_id' => null]);

        return back()->with('toast_success','Berhasil Dihapus');
    }
}
