<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Period;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\Classroom;
use App\Models\Student_attendance;
use App\Models\School_year;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Collection;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class SchoolYearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = 'Tahun Ajaran';
        $action = __FUNCTION__;

        $schoolyears = School_year::orderBy('year_start','DESC')->get();
		
        return view('schoolyear.index', compact('page_title','action','schoolyears'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = 'Tahun Ajaran';
        $action = 'create';
		
        return view('schoolyear.create', compact('page_title','action'));
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
            'year_start' => 'required_with:year_end|digits:4|unique:school_years,year_start',
            'year_end' => 'required_with:year_start|digits:4|gt:year_start|unique:school_years,year_end',
        ],[
            'required'  => 'Harap bagian :attribute di isi.',
            'required_with'  => 'Harap bagian :attribute di isi.',
            'min'  => 'Format Tahun Salah',
            'digits'  => 'Format Tahun Salah',
            'gt'  => 'Tahun Akhir Harus Lebih Besar dari Tahun Awal',
            'unique'  => 'Tahun Ajaran Sudah Pernah Dibuat',
        ]);

        $school_year = School_year::create([
            'year_start' => $request['year_start'],
            'year_end' => $request['year_end'],
        ]);  

        return redirect()->route('schoolyears.index')->with('toast_success','Tahun Ajaran Berhasil Ditambahkan');
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
        $page_title = 'Tahun Ajaran';
        $action = 'index';
		
        $schoolyear = School_year::find($id);

        return view('schoolyear.edit', compact('page_title','action','schoolyear'));
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
            'year_start' => 'required_with:year_end|digits:4',
            'year_end' => 'required_with:year_start|digits:4|gt:year_start|unique:school_years,year_end,'.$id.',id,year_start,'.request('year_start'),
        ],[
            'required'  => 'Harap bagian :attribute di isi.',
            'required_with'  => 'Harap bagian :attribute di isi.',
            'digits'  => 'Format Tahun Salah',
            'min'  => 'Format Tahun Salah',
            'gt'  => 'Tahun Akhir Harus Lebih Besar dari Tahun Awal',
            'unique'  => 'Tahun Ajaran Sudah Pernah Dibuat',
        ]);

        $school_year = School_year::find($id);
 
        $school_year->year_start = $request->year_start;
        $school_year->year_end = $request->year_end;
        $school_year->save();

        return redirect()->route('schoolyears.index')->with('toast_success','Tahun Ajaran Berhasil Dirubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $schoolyear = School_year::find($id);
        $schoolyear->delete();
        return redirect()->route('schoolyears.index')->with('toast_success','Berhasil Dihapus');
    }
}
