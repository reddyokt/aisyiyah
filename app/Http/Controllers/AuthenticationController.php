<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\UserSetting;
use Illuminate\Support\Facades\App;
use SebastianBergmann\Type\NullType;

class AuthenticationController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect()->intended('/dashboard');
        } else {
            return view('authentication.login');
        }
    }


    public function postLogin(Request $request){

        // dd($request);
        date_default_timezone_set('Asia/Jakarta');
        $username = $request->username;
        $password = $request->password;

        $data = DB::table('user')->where('user.username', $username)
            ->whereNull('user.delete_at')
            ->where('user.isActive','Y')
            ->first();

        $login = Auth::attempt(['username' => $username, 'password' => $password]);

        if($data!=null){ //apakah user tersebut ada atau tidak
            if(Hash::check($password, $data->password)){
                // define user settings
                $userSetting = UserSetting::where(
                    'user_id',$data->user_id
                )->whereNull('deleted_at')
                ->first();

                //get role name
                $dataRole = DB::table('user_role')
                    ->join('user','user.user_id','=','user_role.user_id')
                    ->join('roles','roles.id','=','user_role.role_id')
                    ->where('user.user_id','=',$data->user_id)
                    ->select(DB::raw('roles.role_name, roles.CODE, roles.id'))
                    ->first();

                $menu = array();

                $dataMenu = DB::table('menu')
                    ->join('role_menu','role_menu.menu_id','=','menu.menu_id')
                    ->where('role_menu.role_id',$dataRole->id)
                    ->whereNull('menu.deleted_at')
                    ->select(DB::raw('menu.code'))
                    ->get()->toArray();
                foreach($dataMenu as $key=>$value){
                    $menu[$key] = $value->code;
                }

                //put all data needed in session
                Session::put('user_id', $data->user_id);
                Session::put('name', $data->name);
                Session::put('email', $data->email);
                Session::put('menu', $menu);
                Session::put('roles', $dataRole);
                Session::put('pda_id', $data->pda_id);
                Session::put('id_majelis', $data->id_majelis);
                // Session::put('role_other', $role_other_data);
                Session::put('role_id', $dataRole->id);
                Session::put('role_name', $dataRole->role_name);
                Session::put('role_code', $dataRole->CODE);
                Session::put('picture', $data->profile_picture);
                Session::put('username', $data->username);
                Session::put('password', $data->password);
                // Session::put('settings', $userSetting->default_settings);
                Session::put('login', TRUE);
                // Session::put('dpc_id', $data->dpc_id);
                // Session::put('dpd_id', $data->dpd_id);

                // dd(Session::get('menu'));

                $arrsetting = explode('|', $userSetting->default_settings);
                \App::setlocale($arrsetting[count($arrsetting)-1]);
                Session::put('locale', $arrsetting[count($arrsetting)-1]);

                //redirect to main page
                return redirect('dashboard');
            }else{
                return redirect('/login')->with('error','Password atau Username, Salah!');
            }
        }else{
            return redirect('/login')->with('error','Password atau Username, Salah!');
        }
    }


    public function verifiedAccount($token){
        $user = User::where('token_verified', $token)->first();
        if($user !== null){
            $user->isActive = 'Y';
            $user->updated_at = date('Y-m-d H:i:s');
            $user->updated_by = $user->username;
            $user->save();

            return redirect('login');
        } else {
            return redirect('login')->with('alert','Gagal melakukan verifikasi akun!');
        }
    }
}
