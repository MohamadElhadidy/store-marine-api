<?php

namespace App\Http\Controllers;

use App\Models\In;
use Illuminate\Http\Request;
use DB;
use App\Events\Notifications;

class InController extends Controller
{
      public function __construct()
        {
        $this->middleware("auth");
        $this->middleware("canView:in,write", [
        'only' => [
            'create' ,
            'store' ,
            'edit' ,
            'update' ,
            ]
        ]);
        $this->middleware("canView:in,read", [
        'only' => [
            'index' ,
            ]
        ]);
        $this->middleware("canView:in,delete", [
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
    $entries =  DB::table('hr.data')
                ->select('*')
                ->whereIn('department',array(9, 24))
                ->get();

        $suppliers =  DB::table('suppliers')
                ->select('*')
                ->whereIn('store', array(1, auth()->user()->store))
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
        
        return view('in.create',[
            'entries' =>$entries,
            'suppliers' =>$suppliers,
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
            'supplier' => ['required'],
            'entry' => ['required'],
            'item.*' => ['required','max:255'],
            'price.*' => ['required','numeric'],
            'balance.*' => ['required','numeric'],
            'store' => ['required'],
            ],
            [
                'dates.date' => '  ادخل التاريخ بشكل صحيح ',
                'dates.required' => '  ادخل     التاريخ   ',

                'supplier.required' => '  ادخل    المورد    ',
                'entry.required' => '  ادخل     اسم موظف المخزن   ',
                'item.*.required' =>  '  ادخل   الصنف    ',
                'price.*.required' =>  '  ادخل    السعر    ',
                'price.*.numeric' =>  '   ادخل    السعر بشكل صحيح   ',
                'balance.*.required' => '  ادخل    العدد    ',
                'balance.*.numeric' =>  '   ادخل    العدد بشكل صحيح   ',
                'store.required' => '  ادخل    المخزن   ',
                
            ]);
            
            $count = count($request->item);
            $orderNum = 1001;
            $lastOrderNum  =    DB::table('ins')->select('*')->where('is_delete',  0 )->orderBy('id','desc')->first();
            if($lastOrderNum != null) $orderNum = $lastOrderNum->order_num + 1 ;

            for ($i=0; $i < $count; $i++) { 
                $in = new In;
                $in->order_num =$orderNum;
                $in->date =$request->dates;
                $in->supplier = $request->supplier;
                $in->entry = $request->entry;
                $in->item = $request->item[$i];
                $in->price = $request->price[$i];
                $in->balance = $request->balance[$i];
                $in->store = $request->store;
                $in->notes = $request->notes[$i];
                $in->save();
            }
            


            $store = DB::table('stores')->select('*')->where('id' ,$request->store)->first();
            $supplier = DB::table('suppliers')->select('*')->where('id' ,$request->supplier)->first();
            $entry = DB::table('hr.data')->select('*')->where('id' ,$request->entry)->first();

            $title = 'تم   إضافة   إذن دخول صنف جديد      ';


            $body = 'تم   إضافة  إذن دخول صنف  جديد ';$body.= "\r\n /";
            $body .=  ' تاريخ  '.$request->dates;$body.= "\r\n /";
            $body .=  ' اسم المورد    '.$supplier->name;$body.= "\r\n /";
            $body .=  '  اسم موظف المخزن   '.$entry->name;$body.= "\r\n /";
            $body .=  '    '.$store->name;$body.= "\r\n /";

            for ($i=0; $i < $count; $i++) { 
                $item = DB::table('items')->select('*')->where('id' ,$request->item[$i])->first();
                $body .=  ' صنف رقم   '.$i + 1;$body.= "\r\n --";
                $body .=  ' اسم الصنف  '.$item->name;$body.= "\r\n /";
                $body .=  ' عدد '.$request->balance[$i];$body.= "\r\n /";
                $body .=  '  سعر الوحدة '.$request->price[$i];$body.= "\r\n /";
            }
        
            $auth = new AuthController();
            $auth->notify(auth()->user()->id, $request->store, $title, $body, '/in', 'action');

            event(new Notifications($title));

            $request->session()->flash('NewIn', $title);
            
            return  back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\In  $in
     * @return \Illuminate\Http\Response
     */
    public function show(In $in)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\In  $in
     * @return \Illuminate\Http\Response
     */
    public function edit(In $in)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\In  $in
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, In $in)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\In  $in
     * @return \Illuminate\Http\Response
     */
    public function destroy(In $in)
    {
        //
    }
}
