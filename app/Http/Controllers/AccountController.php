<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRole;
use App\Models\UserSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
Use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class AccountController extends Controller
{
    public function accountIndex()
    {
        $accountindex = User::leftJoin('user_role', 'user_role.user_id', '=', 'user.user_id')
            ->leftJoin('roles', 'roles.id', '=', 'user_role.role_id')
            ->leftJoin('pda', 'pda.pda_id', '=', 'user.pda_id')
            ->whereNull('user.delete_at')
            ->whereNull('user_role.delete_at')
            ->select(DB::raw('user.user_id, phone, user.name, username, roles.role_name as role_name, email, profile_picture , pda.pda_name'))
            ->get()->toArray();


        foreach ($accountindex as $key => $value) {
            $accountindex[$key]['nomor'] = $key + 1;
        }

        return view('auth.masterdata.account.accountindex', compact('accountindex'));
    }

    public function createAccount()
    {

        $roleList = DB::table('roles')
            ->whereNotIn('CODE', ['SUP'])
            ->get()->toArray();
        return view('auth.masterdata.account.createaccount', compact('roleList'));
    }

public function storeAccount(Request $request)
{

    date_default_timezone_set('Asia/Jakarta');

    $eight_random_str = strtolower(Str::random(6));
    $three_random_num = mt_rand(1000, 9999);
    $token_verified =  Str::random(32);

    // dd($eight_random_str);
    
    $checkExist = DB::table('user')
    ->where('email', $request->email)
    ->orWhere('username', $request->username)
    ->whereNull('delete_at')
    ->first();

    if ($checkExist) {
        return back()->with('warning', 'Data dengan Username/Email tersebut sudah ada!');
    } else {
        // Check if there's an active user with role_id = 2
        $existingUser = DB::table('user')
            ->join('user_role', 'user.user_id', '=', 'user_role.user_id')
            ->where('user_role.role_id', 2)
            ->where('user.isActive', 'Y')
            ->whereNull('user.delete_at')
            ->exists();

        if ($existingUser) {
            return back()->with('warning', 'User dengan ROLE Ketua PWA sudah ada dan masih aktif');
        }

        $user = new User;

        // Default profile picture if none uploaded
        $pp = 'default_profile_picture.png';

        if ($request->file('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $pp = $request->username.'.'.$extension;
            $dataImage = $request->file('image')->get();
            File::put(public_path('upload/profile_picture/'.$pp), $dataImage);
        }
        
        $token =  Str::random(32);
        $user->username = $request->username;
        $user->password = Hash::make($eight_random_str);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = str_replace('-', '', $request->phone_number);
        $user->pda_id = $request->pda;
        $user->id_majelis = $request->majelis;
        $user->profile_picture = $pp;
        $user->created_at = date('Y-m-d H:i:s');
        $user->created_by = Session::get('user_id');
        $user->token_verified = $token;
        $user->save();

        $user_role = new UserRole();
        $user_role->user_id = $user->user_id;
        $user_role->role_id = $request->role;
        $user_role->created_at = date('Y-m-d H:i:s');
        $user_role->save();

        $user_settings = new UserSetting();
        $user_settings->user_id = $user->user_id;
        $user_settings->created_at = date('Y-m-d H:i:s');
        $user_settings->created_by = Session::get('username');
        $user_settings->save();

        if (env('BYPASS_NOTIF')) {
            $dataNotif = array(
                'to_name' => $request->name,
                'username' => $request->username,
                'password' => $eight_random_str,
                'url' => url('verified/'.$token)
            );

            $to_name = $request->name;
            $to_email = $request->email;
            $subjectMail = "Verifikasi Akun Aisyiyah PWA DKI Jakarta";

            Mail::send("mail.mailverifiedaccount", $dataNotif, function($message) use ($to_name, $to_email, $subjectMail) {
                $message->to($to_email, $to_name)->subject($subjectMail);
                $message->from(config('mail.from.address'), config('mail.from.name'));
            });
        }

        return redirect('/account')->with('success', 'Alhamdulillah Akun berhasil dibuat');

        return redirect('/account')->with('success', 'Alhamdulillah Akun berhasil dibuat');
    }
    
}

    public function editAccount($id)
    {
        $enc = $id;
        $roleList = DB::table('roles')
            ->whereNotIn('code',['SUP'])
            ->get()->toArray();

        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return view('error.404');
        }
        $data = User::leftJoin('user_role','user_role.user_id','=','user.user_id')
            ->where('user.user_id', $id)
            ->select(DB::raw('user.*, role_id'))
            ->first();

        return view('auth.masterdata.account.editaccount', compact('data','roleList','enc'));
    }

    public function updateAccount(Request $request, $id)
    {


        date_default_timezone_set('Asia/Jakarta');
        $req = $request->all();
        $id = $req['id'];
        $enc = $id;

        $user = User::where('user_id', $id)->first();
        $userRole = UserRole::where('user_id', $id)
            // ->whereNull('delete_at')
            ->first();

        $checkEmail = DB::table('user')
            ->where('email', $req['email'])
            ->where('user_id','<>',$user->user_id)
            ->whereNull('delete_at')
            ->first();

        if($checkEmail != null){
            return back()->with('warning', 'Email tersebut sudah ada');
        }

        $checkUsername = DB::table('user')
            ->Where('username', $req['username'])
            ->where('user_id','<>',$user->user_id)
            ->whereNull('delete_at')
            ->first();

        if($checkUsername){
            return back()->with('warning', 'Username tersebut sudah ada');
        }

        $pp = $req['old_image'];

        if ($request->file('image')) {

            $extension = $request->file('image')->getClientOriginalExtension();
            $pp = $req['username'].'.'.$extension;
            $dataImage = $request->file('image')->get();
            // $user->profile_picture = $request->file('image')->store(public_path('storage/profile_picture'), $pp);
            File::put(public_path('upload/profile_picture/'.$pp), $dataImage);
        }


        $checkUsername = DB::table('user')
            ->where('username', $req['username'])
            ->where('user_id','<>',$user->user_id)
            ->whereNull('delete_at')
            ->first();

        if($checkEmail != null){
            return back()->with('warning', 'Username tersebut sudah ada');
        }

        $user->username = $req['username'];
        $user->name = $req['name'];
        $user->email = $req['email'];
        $user->profile_picture = $pp;
        $user->phone = str_replace('-', '', $req['phone_number']);
        // $user->updated_by = Session::get('username');
        $user->save();

        // // user role
        // if($userRole->role_id != $req['role']){
        //     $userRole->role_id = $req['role'];
        //     // $userRole->updated_at = Session::get('username');
        //     $userRole->save();
        // }

        $user_settings = new UserSetting();
        $user_settings->user_id = $user->user_id;
        $user_settings->created_at = date('Y-m-d H:i:s');
        $user_settings->created_by = Session::get('username');
        $user_settings->save();


        //user Log
        // $userLog = new UserLog;
        // $userLog->user_id = Session::get('user_id');
        // $userLog->role_id = Session::get('role_id');
        // $userLog->action = UserLog::AKSI_UPDATE;
        // $userLog->action_date = date('Y-m-d H:i:s');
        // $userLog->description = 'Memperbarui akun atas nama '.$user->name;
        // $userLog->created_at = date('Y-m-d H:i:s');
        // $userLog->created_by = Session::get('username');
        // $userLog->save();

        return redirect('/account')->with('success', 'Alhamdulillah Akun berhasil di edit');
    }

    public function deleteAccount($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        // try {
            $id = Crypt::decrypt($id);

            $user = User::whereNull('delete_at')->where('user_id', $id)->first();
            $user->delete_at = date('Y-m-d H:i:s');
            $user->save();

            $userRole = UserRole::whereNull('delete_at')->where('user_id', $id)->update([
                'delete_at'=>date('Y-m-d H:i:s')
            ]);

            $userSetting = UserSetting::whereNull('deleted_at')->where('user_id', $id)->first();
            $userSetting->deleted_at = date('Y-m-d H:i:s');
            $userSetting->save();

            //user Log
            // $userLog = new UserLog;
            // $userLog->user_id = Session::get('user_id');
            // $userLog->role_id = Session::get('role_id');
            // $userLog->action = UserLog::AKSI_DELETE;
            // $userLog->action_date = date('Y-m-d H:i:s');
            // $userLog->description = 'Menghapus akun atas nama '.$user->name;
            // $userLog->created_at = date('Y-m-d H:i:s');
            // $userLog->created_by = Session::get('username');
            // $userLog->save();

            return back()->with('warning', 'Data telah didelete!');
            // } catch (DecryptException $e) {
            //     return view('error.404');
            // }

    }

    public function getPDA(){
        $pda = DB::table('pda')->whereNull('deleted_at')->get()->toArray();
        return response()->json($pda);
    }

    public function getPCA(){
        $dpc = DB::table('dpc')->whereNull('deleted_at')->get()->toArray();
        return response()->json($dpc);
    }

    public function getMajelis(){
        $majelis = DB::table('majelis')->where('isActive','Yes')->get()->toArray();
        return response()->json($majelis);
    }

    public function changePassword(Request $request)
    {
        // dd(auth()->user()->password);
        $request->validate([
            'oldpass' => 'required',
            'newpass' => 'min:6|required_with:confnewpass|same:confnewpass',
            'confnewpass' => 'required|min:6'
        ]);

        if($request->newpass != $request->confnewpass){
            return redirect()->back()->with('warning', 'Password Konfirmasi tidak sama');
        }

        if(Hash::check($request->oldpass , auth()->user()->password)) {
            if(!Hash::check($request->newpass , auth()->user()->password)) {
               $user = User::find(auth()->user()->user_id);
               $user->update([
                   'password' => bcrypt($request->newpass)
               ]);
            //    return redirect()->back()->with('success', 'password berhasil diubah, Silahkan login kembali');
                Auth::logout();
                Session::flush();
                return redirect('login')->with('success', 'password berhasil diubah, Silahkan login kembali');
            }        
            return redirect('dashboard/index')->with('warning', 'password lama dan password baru tidak boleh sama');
        }        
        return redirect('dashboard/index')->with('error', 'password lama salah');

    }
}
