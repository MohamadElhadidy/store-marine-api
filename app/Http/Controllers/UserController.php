<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Store;
use App\Models\Section;
use App\Models\Role;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\AuthController;
use App\Events\Notifications;
use DB;

class UserController extends Controller
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
        if(auth()->user()->type == 'admin'){
            return view('users.create');
        }
        return view('dashboard');
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
            'name' => ['required','max:255', 'unique:users'],
            'username' => ['required', 'max:255' , 'unique:users'],
            'password' => ['required'],
            ],
            [
                'username.unique' => ' اسم المستخدم   موجود  ',
                'username.required' => '  ادخل اسم المستخدم    ',

                'name.unique' => ' الاسم    موجود  ',
                'name.required' => ' ادخل الاسم',

                'password.required' => ' ادخل كلمة السر',
            ]);
            $user = new User;
            if($request->file != null ){
                $fileName = time().'_'.$request->file->getClientOriginalName();
                $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');
                $user->image ='/storage/' .$filePath;
            }


            $user->name =$request->name;
            $user->username = $request->username;
            $user->password = Hash::make($request->password);
            $user->type = 'user';
            $user->store = '2';
            $user->save();

            $title = 'تم إنشاء حساب بنجاح';
            $body =  '  تم انشاء حساب جديد  الاسم  '.$request->name;$body.= "\r\n /";
            $body .=  'اسم المستخدم  '.$request->username;$body.= "\r\n /";

            $request->session()->flash('newAccount', $title);
            
            $auth = new AuthController();
            $auth->notify(auth()->user()->id,1, $title, $body, '/users', 'action');

            event(new Notifications($title));

            return  back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        if($user != null){  
            if(auth()->user()->id != $id  AND auth()->user()->type != 'admin' ){
                $id = auth()->user()->id;
                $user = User::find($id);
            }
        }else{
            $id = auth()->user()->id;
            $user = User::find($id);
        }
        $stores = Store::all();
        $sections = Section::all();
        $roles = DB::table('roles')
                ->select('*')
                ->where('user_id' ,$id)
                ->groupBy('section_id')
                ->get();
        foreach ($roles as $role) {
            $section = Section::find($role->section_id);
            $roles2 = DB::table('roles')
                ->select('*')
                ->where('section_id' ,$role->section_id)
                ->where('user_id' ,$id)
                ->get();
                $actions = '';
                foreach ($roles2 as $role2) {
                    $actions .= $role2->action.' || ';
                }
            $role->section_id = $section->name_ar;
            $role->action = $actions;
        }
        return view('users.profile',[
            'user' => $user,
            'sections' => $sections,
            'roles' => $roles,
            'stores' => $stores
        ]);
    
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
        $user = User::find($id);
        $body = '';
        $validatedData = $request->validate([
            'name' => ['required','max:255', 'unique:users,name,'.$id],
            'username' => ['required', 'max:255' , 'unique:users,username,'.$id],
            ],
            [
                'username.unique' => ' اسم المستخدم   موجود  ',
                'username.required' => '  ادخل اسم المستخدم    ',

                'name.unique' => ' الاسم    موجود  ',
                'name.required' => ' ادخل الاسم',
            ]
        );
            if($request->file != null ){
                $fileName = time().'_'.$request->file->getClientOriginalName();
                $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');
                $user->image ='/storage/' .$filePath;
                $body .=   ' تم تغيير الصورة الشخصية  '; $body.= "\r\n /"; 
            }
            if(!empty($request->password)) {
                $user->password = Hash::make($request->password);
                $body .= '  تم تغيير  الرقم السري  ';$body.= "\r\n /"; 
            }

            if($user->name != $request->name){
                    $body .=  '  تم تغيير الاسم من '.$user->name. ' الى '.$request->name;
                    $body.= "\r\n /";
            }   
            if($user->username != $request->username) {
                $body .=  '  تم تغيير اسم المستخدم من ' . $user->username. ' الى '.$request->username;
                $body.= "\r\n /";
            }
            $user->name = $request->name;
            $user->username = $request->username;


            if(isset($request->store)) $user->store = $request->store;
            if(isset($request->section) AND isset($request->action)){
                $check = Role::where([['section_id', $request->section],['user_id', $id],['action', $request->action]])->first();
                
                if($check == null ){
                    $role = new Role;
                    $role->user_id =$id;
                    $role->section_id = $request->section;
                    $role->action = $request->action;
                    $role->save();
                }else{
                    $check->delete();
                }
            } 
        
            
            
            $user->save();
            $stores = Store::all();
            $title = 'تم تعديل الحساب بنجاح';


            $request->session()->flash('profile', $title);
            $auth = new AuthController();

            if($body != null)$auth->notify(auth()->user()->id,1, $title, $body, '/users', 'action');

            event(new Notifications($title));

            $sections = Section::all();
            $roles = DB::table('roles')
                ->select('*')
                ->where('user_id' ,$id)
                ->groupBy('section_id')
                ->get();
        foreach ($roles as $role) {
            $section = Section::find($role->section_id);
            $roles2 = DB::table('roles')
                ->select('*')
                ->where('section_id' ,$role->section_id)
                ->where('user_id' ,$id)
                ->get();
                $actions = '';
                foreach ($roles2 as $role2) {
                    $actions .= $role2->action.' || ';
                }
            $role->section_id = $section->name_ar;
            $role->action = $actions;
        }
        return  back()->with([
                'user' => $user,
                'sections' => $sections,
                'roles' => $roles,
                'stores' => $stores
            ]);
        
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
