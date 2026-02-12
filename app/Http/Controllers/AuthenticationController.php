<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard.index');
        }

        return view('authentication.login');
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $username = $request->username;
        $password = $request->password;

        // Ambil user valid (aktif & belum dihapus)
        $user = User::query()
            ->where('username', $username)
            ->whereNull('delete_at')        // kalau sebenarnya deleted_at, ganti ya
            ->where('isActive', 'Y')
            ->first();

        if (!$user || !Hash::check($password, $user->password)) {
            return back()->with('error', 'Password atau Username, Salah!');
        }

        // Login via guard Laravel (ini yang bikin middleware auth berfungsi)
        Auth::login($user);
        $request->session()->regenerate();

        // settings (handle null)
        $userSetting = UserSetting::where('user_id', $user->user_id)
            ->whereNull('deleted_at')
            ->first();

        // role
        $dataRole = DB::table('user_role')
            ->join('user', 'user.user_id', '=', 'user_role.user_id')
            ->join('roles', 'roles.id', '=', 'user_role.role_id')
            ->where('user.user_id', $user->user_id)
            ->select('roles.role_name', 'roles.CODE', 'roles.id')
            ->first();

        // menu
        $menu = [];
        if ($dataRole) {
            $dataMenu = DB::table('menu')
                ->join('role_menu', 'role_menu.menu_id', '=', 'menu.menu_id')
                ->where('role_menu.role_id', $dataRole->id)
                ->whereNull('menu.deleted_at')
                ->select('menu.code')
                ->get();

            foreach ($dataMenu as $i => $m) {
                $menu[$i] = $m->code;
            }
        }

        // session data (yang memang dibutuhkan app)
        session([
            'user_id'   => $user->user_id,
            'name'      => $user->name,
            'email'     => $user->email,
            'username'  => $user->username,
            'picture'   => $user->profile_picture,

            'pda_id'    => $user->pda_id,
            'id_majelis' => $user->id_majelis,

            'menu'      => $menu,
            'roles'     => $dataRole,
            'role_id'   => $dataRole->id ?? null,
            'role_name' => $dataRole->role_name ?? null,
            'role_code' => $dataRole->CODE ?? null,
        ]);

        // locale setting (jangan sampai fatal kalau null)
        if ($userSetting && $userSetting->default_settings) {
            $arrsetting = explode('|', $userSetting->default_settings);
            $locale = $arrsetting[count($arrsetting) - 1] ?? null;

            if ($locale) {
                app()->setLocale($locale);
                session(['locale' => $locale]);
            }
        }

        // redirect intended: kalau user ke /document/create, dia balik ke sana setelah login
        return redirect()->intended(route('dashboard.index'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function verifiedAccount($token)
    {
        $user = User::where('token_verified', $token)->first();

        if (!$user) {
            return redirect()->route('login')->with('alert', 'Gagal melakukan verifikasi akun!');
        }

        $user->isActive = 'Y';
        $user->updated_at = now();
        $user->updated_by = $user->username;
        $user->save();

        return redirect()->route('login');
    }
}
