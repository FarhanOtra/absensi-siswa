<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = 'Wali Kelas';
        $action = __FUNCTION__;

        $teachers = Teacher::all();
		
        return view('teacher.index', compact('page_title','action','teachers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = 'Wali Kelas';
        $action = 'create';
		
        return view('teacher.create', compact('page_title','action'));
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
            'email' => 'required|unique:users|email',
            'password' => 'required',
            'nip' => 'required|unique:teachers',
            'name' => 'required',
            'image' => 'image|mimes:jpg,png,jpeg'
        ],
        [
            'required'  => 'Harap bagian :attribute di isi.',
            'unique'    => ':attribute sudah digunakan',
            'image'     => 'File upload harus berupa image',
            'mimes'     => 'Jenis file',
            'size'      => 'ukuran file lebih dari 100 mb',
        ]);

        if($request->file('image')){
            $image = $request->file('image')->store('image/teacher'); 
        }else{
            $image = null;
        };

        $user = User::create([
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'role' => 'teacher',
            'image' => $image,
        ]);

        $teacher = Teacher::create([
            'user_id' =>  $user->id,  
            'nip' => $request['nip'],
            'name' => $request['name'],
        ]);

        if($request->file('image')){
            $request->file('image')->store('image/teacher'); 
        }

        return redirect()->route('teachers.index')->with('toast_success','Guru Berhasil Ditambahkan');
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
        $page_title = 'Wali Kelas';
        $action = 'create';

        $teacher = Teacher::where('user_id',$id)->first();
		
        return view('teacher.edit', compact('page_title','action','teacher'));
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
            'email' => 'required|email|unique:users,email,'.$id,
            'nip' => 'required|unique:teachers,nip,'.$id.',user_id',
            'name' => 'required',
            'image' => 'image|mimes:jpg,png,jpeg'
        ],
        [
            'required'  => 'Harap bagian :attribute di isi.',
            'unique'    => ':attribute sudah digunakan',
            'image'     => 'File upload harus berupa image',
            'mimes'     => 'Jenis file',
        ]);

        if($request->file('image')){
            $image = $request->file('image')->store('image/teacher'); 
        }else{
            $image = $request->imageNow;
        };

        $user = User::find($id);
 
        $user->email = $request->email;
        $user->image = $image;
        
        $user->save();

        Teacher::where('user_id', $id)->update([
            'nip' => $request->nip,
            'name' => $request->name,
        ]);

        if($request->file('image')){
            $request->file('image')->store('image/teacher'); 
            Storage::delete($request->imageNow);
        }

        return redirect()->route('teachers.index')->with('toast_success','Data Guru Berhasil Diubah');
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
        return redirect()->route('teachers.index')->with('toast_success','Berhasil Dihapus');
    }
}
