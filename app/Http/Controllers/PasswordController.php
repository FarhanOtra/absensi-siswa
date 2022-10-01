<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use App\Rules\MatchOldPassword;

class PasswordController extends Controller
{
    public function index($id)
    {
        $page_title = 'Reset Password';
        $action = 'index';
        $user_id = $id;
		
        return view('auth.passwords.reset', compact('page_title','action','user_id'));
    }

    public function resetPassword(Request $request)
    {
		$validated = $request->validate([
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
        ],[
            'required' => 'Harap bagian :attribute di isi.',
            'min' => 'Password Minimal 8 Karakter',
            'same' => 'Konfirmasi Password Tidak Cocok'
        ]);

        $user = User::find($request->id);
        $user->forceFill([
            'password' => Hash::make($request['password']),
        ])->save();

        if($user->role == 'student'){
            return redirect()->route('students.index')->with('toast_success','Berhasil Reset Password');
        };
        
        if($user->role == 'teacher'){
            return redirect()->route('teachers.index')->with('toast_success','Berhasil Reset Password');
        };
    }
    
    public function edit()
    {
        $page_title = 'Change Password';
        $action = 'index';
		
        return view('auth.passwords.change', compact('page_title','action'));
    }

    public function changePassword(Request $request)
    {
        $id = Auth::user()->id;
		$user = User::find($id);

        $validated = $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
        ],[
            'required' => 'Harap bagian :attribute di isi.',
            'min' => 'Password Minimal 8 Karakter',
            'same' => 'Konfirmasi Password Tidak Cocok'
        ]);

        $user->forceFill([
            'password' => Hash::make($request['password']),
        ])->save();

        return redirect()->route('index')->with('toast_success','Berhasil Reset Password');
    }
}
