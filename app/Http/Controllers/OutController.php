<?php

namespace App\Http\Controllers;

use App\Models\Out;
use Illuminate\Http\Request;
use DB;
use App\Events\Notifications;
class OutController extends Controller
{
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

        $recipients =   DB::table('hr.data')
                ->select('*')
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
        
        return view('out.create',[
            'entries' =>$entries,
            'recipients' =>$recipients,
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
        //
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
        //
    }
}
