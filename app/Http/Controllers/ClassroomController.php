<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Classroom;
use App\Models\Student;
use App\Models\School_year;
use App\Models\Student_classroom;
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

        $schoolyears = School_year::orderBy('year_start','DESC')->get();
   
        return view('classroom.index', compact('page_title','action','schoolyears'));
    }

    public function year($id)
    {
        $page_title = 'Kelas';
        $action = 'index';

        $classrooms = Classroom::where('school_year_id',$id)->get();
        $year = School_year::find($id);
   
        return view('classroom.year', compact('page_title','action','classrooms','year'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($year)
    { 
        $page_title = 'Kelas';
        $action = 'create';

        $teacher_id = Classroom::where('school_year_id',$year)->pluck('teacher_id')->all();
        $teachers = Teacher::whereNotIn('user_id', $teacher_id)->get();
		
        return view('classroom.create', compact('page_title','action','teachers','year'));
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
            'name' => 'required',
            'grade' => 'required',
        ],
        [
            'required'  => 'Harap bagian :attribute di isi.',
            'teacher_id.required'  => 'Harap Pilih Guru Wali Kelas.',
            'name.unique'    => ':attribute sudah digunakan',
        ]);

        $classroom = Classroom::create([
            'grade' => $request['grade'],
            'name' => $request['name'],
            'teacher_id' => $request['teacher_id'],
            'school_year_id' => $request['school_year_id'],
        ]);

        return redirect()->route('classrooms.year',[$request['school_year_id']])->with('toast_success','Kelas Berhasil Ditambahkan');
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

        $students = Student::join('student_classrooms','student_id','user_id')->where('classroom_id',$id)->get();

        // dd($students);
        $check = Student_classroom::join('classrooms','classroom_id','classrooms.id')->where('classrooms.school_year_id',$classroom->school_year_id)->pluck('student_id');
        $students_all = Student::whereNotIn('user_id',$check)->get();
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

        $teacher_id = Classroom::where('teacher_id','!=',null)->pluck('teacher_id')->all();
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
            'name' => 'required',
            'grade' => 'required',
        ],
        [
            'required'  => 'Harap bagian :attribute di isi.',
            'teacher_id.required'  => 'Harap Pilih Guru Wali Kelas.',
            'name.unique'    => ':attribute sudah digunakan',   
        ]);

        $classroom = Classroom::find($id);
 
        $classroom->grade = $request->grade;
        $classroom->name = $request->name;
        $classroom->teacher_id = $request->teacher_id;
        
        $classroom->save();

        return redirect()->route('classrooms.show',[$id])->with('toast_success','Berhasil Diubah');
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
        $year = $classroom->school_year_id;
        $classroom->delete();
        return redirect()->route('classrooms.year',[$year])->with('toast_success','Berhasil Dihapus');
    }

    public function addStudent(Request $request, $id)
    {
        $students = Student::whereIn('user_id', $request->data)->get();
        foreach($students as $student){
            Student_classroom::create([
                'student_id' => $student->user_id,
                'classroom_id' => $id,
            ]);
        }
        return back()->with('toast_success','Siswa Berhasil Ditambahkan');
    }

    public function destroyStudent($id)
    {
        Student_classroom::destroy($id);

        return back()->with('toast_success','Siswa Berhasil Dihapus');
    }
}
