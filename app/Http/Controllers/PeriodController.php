<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Period;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\Classroom;
use App\Models\Student_attendance;
use App\Models\Student_classroom;
use App\Models\School_year;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Collection;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

class PeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = 'Periode';
        $action = __FUNCTION__;

        $periods = Period::join('school_years','school_years.id','periods.school_year_id')->select('*','periods.id as id')->orderBy('year_start','DESC')->orderBy('semester','DESC')->get();
        return view('period.index', compact('page_title','action','periods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = 'Periode';
        $action = 'create';

        $schoolyears = School_year::all();
		
        return view('period.create', compact('page_title','action','schoolyears'));
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
            'school_year_id' => 'required',
            'semester' => 'required|unique:periods,semester,NULL,id,school_year_id,'.request('school_year_id'),
        ],[
            'required'  => 'Harap bagian :attribute di isi.',
            'unique'  => 'Tahun Ajaran Sudah Pernah Dibuat',
        ]);

        $period = Period::create([
            'school_year_id' => $request['school_year_id'],
            'semester' => $request['semester'],
            'active' => 0,
        ]);  

        return redirect()->route('periods.index')->with('toast_success','Periode Berhasil Ditambahkan');
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
        $page_title = 'Periode';
        $action = 'create';

        $period = Period::find($id);
        $schoolyears = School_year::all();

        return view('period.edit', compact('page_title','action','period','schoolyears'));
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
            'school_year_id' => 'required',
            'semester' => 'required|unique:periods,semester,'.$id.',id,school_year_id,'.request('school_year_id'),
        ],[
            'required'  => 'Harap bagian :attribute di isi.',
            'unique'  => 'Tahun Ajaran Sudah Ada',
        ]);

        $period = Period::find($id);
 
        $period->school_year_id = $request->school_year_id;
        $period->semester = $request->semester;
        if($request->active == 1){
            $active = Period::where('active',1)->update(['active' => 0]);
        }else{
            $first = Period::join('school_years','school_years.id','periods.school_year_id')->select('*','periods.id as id')->orderBy('year_start','DESC')->orderBy('semester','DESC')->where('periods.id','!=',$id)->first();
            $first->active = 1;
            $first->save();
        }
        $period->active = $request->active;
        
        $period->save();

        return redirect()->route('periods.index')->with('toast_success','Periode Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $period = Period::find($id);
        $period->delete();
        return redirect()->route('periods.index')->with('toast_success','Periode Berhasil Dihapus');
    }

}
