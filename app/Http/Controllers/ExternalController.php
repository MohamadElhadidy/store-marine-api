<?php

namespace App\Http\Controllers;

use App\Models\External;
use Illuminate\Http\Request;
use DB;
use App\Events\Notifications;

class ExternalController extends Controller
{
    public function __construct()
        {
        $this->middleware("auth");
        $this->middleware("canView:external,write", [
        'only' => [
            'create' ,
            'store' ,
            'edit' ,
            'update' ,
            ]
        ]);
        $this->middleware("canView:external,read", [
        'only' => [
            'index' ,
            ]
        ]);
        $this->middleware("canView:external,delete", [
        'only' => [
            'destroy' ,
            ]
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $equipments =  DB::table('equip.equipments')
                ->select('*')
                ->get();
        $employees =  DB::table('hr.data')
                ->select('*')
                ->where([['is_delete',0],['status',0],['drop_out',0]])
                ->get();
        $entries =  DB::table('hr.data')
                ->select('*')
                ->whereIn('department',array(9, 24))
                ->get();

        if(auth()->user()->store ==1){
            $stores =  DB::table('stores')
                ->select('*')
                ->get();
        }else{
            $stores =  DB::table('stores')
                ->select('*')
                ->where('id',  auth()->user()->store )
                ->get();
        }
        
        return view('externals.create',[
            'equipments' =>$equipments,
            'employees' =>$employees,
            'entries' =>$entries,
            'stores' =>$stores
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $validatedData = $request->validate([
            'dates' => ['required', 'date' ,'date_format:Y-m-d'],
            'equipment' => ['required'],
            'workshop' => ['required','max:255'],
            'repairs' => ['required','max:255'],
            'price' => ['required','numeric'],
            'employee' => ['required'],
            'supervisor' => ['required'],
            'entry' => ['required'],
            'store' => ['required'],
            ],
            [
                'dates.date' => '  ادخل التاريخ بشكل صحيح ',
                'dates.required' => '  ادخل     التاريخ   ',

                'equipment.required' => '  ادخل    المُعِدة    ',
                'workshop.required' => '  ادخل  إســـــم الورشة    ',
                'repairs.required' => '  ادخل  الإصلاحات    ',
                'price.required' => '  ادخل    التكلفة    ',
                'price.numeric' => '   ادخل    التكلفة بشكل صحيح   ',
                'employee.required' => '  ادخل   اسم القائم بالعمل    ',
                'supervisor.required' => '  ادخل      اسم  مسئول الصيانة   ',
                'entry.required' => '  ادخل     اسم موظف المخزن   ',
                'store.required' => '  ادخل    المخزن   ',
                
            ]);
            $external = new External;
    
            $external->date =$request->dates;
            $external->equipment = $request->equipment;
            $external->workshop = $request->workshop;
            $external->repairs = $request->repairs;
            $external->price = $request->price;
            $external->employee = $request->employee;
            $external->supervisor = $request->supervisor;
            $external->entry = $request->entry;
            $external->store = $request->store;
            $external->notes = $request->notes;
            $external->save();

            $store = DB::table('stores')->select('*')->where('id' ,$request->store)->first();
            $equipment = DB::table('equip.equipments')->select('*')->where('id' ,$request->equipment)->first();
            $employee = DB::table('hr.data')->select('*')->where('id' ,$request->employee)->first();
            $supervisor = DB::table('hr.data')->select('*')->where('id' ,$request->supervisor)->first();
            $entry = DB::table('hr.data')->select('*')->where('id' ,$request->entry)->first();

            $title = 'تم   إضافة  إذن صيانة خارجية  جديد ';


            $body = 'تم   إضافة  إذن صيانة خارجية  جديد ';$body.= "\r\n /";
            $body .=  ' تاريخ  '.$request->dates;$body.= "\r\n /";
            $body .=  ' اسم المُعِدة    '.$equipment->name;$body.= "\r\n /";
            $body .=  '  إســـــم الورشة   '.$request->workshop;$body.= "\r\n /";
            $body .=  ' الإصلاحات  '.$request->repairs;$body.= "\r\n /";
            $body .=  ' التكلفة  '.$request->price.'  جنيها ';$body.= "\r\n /";
            $body .=  '  اسم القائم بالعمل   '.$employee->name;$body.= "\r\n /";
            $body .=  '  اسم مسئول الصيانة   '.$supervisor->name;$body.= "\r\n /";
            $body .=  '  اسم موظف المخزن   '.$entry->name;$body.= "\r\n /";
            $body .=  '    '.$store->name;$body.= "\r\n /";
            
            
            
            $auth = new AuthController();
            $auth->notify(auth()->user()->id, $request->store, $title, $body, '/externals', 'action');

            event(new Notifications($title));

            $request->session()->flash('NewExternal', $title);
            
            return  back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\External  $external
     * @return \Illuminate\Http\Response
     */
    public function show(External $external)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\External  $external
     * @return \Illuminate\Http\Response
     */
    public function edit(External $external)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\External  $external
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, External $external)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\External  $external
     * @return \Illuminate\Http\Response
     */
    public function destroy(External $external)
    {
        //
    }
}
