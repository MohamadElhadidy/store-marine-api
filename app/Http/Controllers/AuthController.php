<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\User;
use DataTables;
use Carbon\Carbon;

class AuthController extends Controller
{

        public function __construct()
        {
        $this->middleware("canView:notifications,read", [
        'only' => [
            'notifications' ,
            ]
        ]);
    }
    public function login(Request $request)
    {
        $this->validate($request,[
            'username'=> ['required','exists:users,username'],
            'password'=>['required']
        ],
        [
                    'username.exists' => ' اسم المستخدم  غير موجود  ',
                    'username.required' =>  'ادخل اسم المستخدم',

                    'password.required' => 'ادخل  كلمة السر',
            ]);
        
    
        if(!auth()->attempt($request->only('username', 'password'),'on')){
            return back()->withErrors([
            'password' => 'كلمة السر غير صحيحة',
        ])->withInput($request->only('username','password'));
        }

        return redirect('/');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
    public function notify($user_id, $auth, $title, $body, $url, $type)
    {
        $notification = new Notification;

        $notification->user_id =$user_id;
        $notification->auth = $auth;
        $notification->title = $title;
        $notification->body = $body;
        $notification->url = $url;
        $notification->type = $type;
        $notification->save();
    }

    public function notifications()
    {
        return view('notifications');
    }

    public function notificationsData()
    {
            $user = User::find(Auth::user()->id);

            if($user->type == 'admin') {
                $notifications = Notification::all();
            } 
            elseif ($user->type != 'admin' AND $user->store == 1) {
                    $notifications = Notification::where('auth', '!=' ,1)->get();
            } elseif( $user->store == 2 or  $user->store == 3) {
                $notifications = Notification::where('auth', $user->store)->get();
            }

            if(isset($notifications)){
                foreach ($notifications as  $notification) {
                    $notification->user_id   = $notification->user->name;
                }
                return DataTables::of($notifications)->make(true);
            } 
    }
}
