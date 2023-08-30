<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\School_year;
use App\Models\Holiday;
use App\Models\Holiday_group;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DB;

class HolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function year($id)
    {
        $page_title = 'Hari Libur';
        $action = 'index';

        $year = School_year::find($id);
        $holidays = Holiday_group::join('holidays','holidays.holiday_group_id','holiday_groups.id')->groupBy('holiday_groups.id')->select('holiday_groups.id as id','holiday_groups.name as name', DB::raw('MAX(holidays.date) as end_date'), DB::raw('MIN(holidays.date) as start_date'))->where('school_year_id',$id)->get();
   
        return view('holiday.year', compact('page_title','action','holidays','year'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $page_title = 'Hari Libur';
        $action = 'create';

        $schoolyear = School_year::find($id);
		
        return view('holiday.create', compact('page_title','action','schoolyear'));
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
            'daterange' => 'required',
        ],[
            'required'  => 'Harap bagian :attribute di isi.'
        ]);

        $dates = explode(' - ', $request->daterange);
        $start_date = Carbon::parse($dates[0])->toDateString('d-M-Y');
        $end_date = Carbon::parse($dates[1])->toDateString('d-M-Y');
        
        if($start_date == $end_date){
            $group = Holiday_group::create([
                'name' => $request['name'],
            ]); 
            if($group->id){
                Holiday::create([
                    'school_year_id' => $request['school_year_id'],
                    'holiday_group_id' => $group->id,
                    'date' => $start_date,
                ]);
            } 
        }else{
            $group = Holiday_group::create([
                'name' => $request['name'],
            ]); 
            if($group->id){
                $dates = CarbonPeriod::create($start_date, $end_date);
                foreach($dates as $date){
                    Holiday::create([
                        'school_year_id' => $request['school_year_id'],
                        'holiday_group_id' => $group->id,
                        'date' => $date,
                    ]);
                }
            } 
        }

        return redirect()->route('holidays.year',[$request->school_year_id])->with('toast_success','Hari Libur Berhasil Ditambahkan');;
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $group = Holiday_group::find($id);
        $group->delete();
        return redirect()->back()->with('toast_success','Berhasil Dihapus');
    }
}
