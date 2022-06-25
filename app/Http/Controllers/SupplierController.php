<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use DB;
use App\Events\Notifications;

class SupplierController extends Controller
{
      public function __construct()
        {
        $this->middleware("auth");
        $this->middleware("canView:suppliers,write", [
        'only' => [
            'create' ,
            'store' ,
            'edit' ,
            'update' ,
            ]
        ]);
        $this->middleware("canView:suppliers,read", [
        'only' => [
            'index' ,
            ]
        ]);
        $this->middleware("canView:suppliers,delete", [
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
        $supplier =  DB::table('suppliers')
                ->select('*')
                ->orderby('id', 'desc')
                ->first();
        $code  = str_replace("S", "", $supplier->code);
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

        return view('suppliers.create',[
            'code' =>$code,
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
        $supplier = Supplier::where([['name',$request->name],['store','!=',$request->store],['store','!=',1]])->first();
        $store = $request->store;
        
        if($supplier != null){
            $store = 1;
        }else{
        $validatedData = $request->validate([
            'code' => ['required', 'max:255' , 'unique:suppliers'],
            'name' => ['required','max:255', 'unique:suppliers'],
            'store' => ['required'],
            ],
            [
                'code.unique' => '   كـــود المورد   موجود  ',
                'code.required' => '  ادخل    كـــود المورد   ',

                'name.unique' => ' إســـــم المورد    موجود  ',
                'name.required' => ' ادخل إســـــم المورد ',

            
                'store.required' => '  ادخل    المخزن   ',
                
            ]);
            $supplier = new Supplier;
    
            $supplier->code =$request->code;
            $supplier->name = $request->name;
            $supplier->notes = $request->notes;
            }
            $supplier->store = $store;
            $supplier->save();
        
            $store = DB::table('stores')->select('*')->where('id' ,$request->store)->first();

            $title = 'تم   إضافة مورد جديد ';
            $body =  '  تم إضافة مورد جديد  كود  '.$request->code;$body.= "\r\n /";
            $body .=  ' اسم   '.$request->name;$body.= "\r\n /";
            $body .=  '    '.$store->name;$body.= "\r\n /";

            $request->session()->flash('NewSupplier', $title);
            
            $auth = new AuthController();
            $auth->notify(auth()->user()->id, $request->store, $title, $body, '/suppliers', 'action');

            event(new Notifications($title));

            return  back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        //
    }
}
