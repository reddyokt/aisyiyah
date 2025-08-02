<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Carbon;
use App\Models\Detailsurat;

class SuratController extends Controller
{
    public function inbox($id)
    {
        $reader_id = Session::get('user_id');

        // dd($reader_id);


        $inbox = DB::table('surat')
            ->leftJoin('surat_detail', 'surat_detail.id_surat', '=', 'surat.id_surat')
            // ->leftJoin('user', 'user.user_id', '=' ,'user_detail.kepada_id')
            ->leftJoin('user', 'user.user_id', '=', 'surat.created_by')
            ->where('surat_detail.kepada_id', $id)
            ->select(DB::raw('surat.id_surat as id_surat, surat.created_at as created_at, user.name as dari,
                              surat.subject as subject, surat.body as body, surat_detail.kepada_id as untuk,
                              surat_detail.isOpened as isOpened'))
            ->get()->toArray();

        $sent = DB::table('surat')
            ->leftJoin('surat_detail', 'surat_detail.id_surat', '=', 'surat.id_surat')
            ->leftJoin('user', 'user.user_id', '=', 'surat_detail.kepada_id')
            ->where('surat.created_by', $reader_id)
            ->select(DB::raw('surat.id_surat as id_surat, surat.created_at as created_at, user.name as kepada,
                            surat.subject as subject, surat.body as body, surat_detail.kepada_id as untuk,
                            surat_detail.isOpened as isOpened, surat_detail.id_detail as id_detail'))
            ->get()->toArray();

        return view('auth.surat.inbox', compact('inbox', 'sent'));
    }

    public function sent($id)
    {
        $reader_id = Session::get('user_id');

        $inbox = DB::table('surat')
            ->leftJoin('surat_detail', 'surat_detail.id_surat', '=', 'surat.id_surat')
            // ->leftJoin('user', 'user.user_id', '=' ,'user_detail.kepada_id')
            ->leftJoin('user', 'user.user_id', '=', 'surat.created_by')
            ->where('surat_detail.kepada_id', $id)
            ->select(DB::raw('surat.id_surat as id_surat, surat.created_at as created_at, user.name as dari,
                          surat.subject as subject, surat.body as body, surat_detail.kepada_id as untuk,
                          surat_detail.isOpened as isOpened'))
            ->get()->toArray();

        $sent = DB::table('surat')
            ->leftJoin('surat_detail', 'surat_detail.id_surat', '=', 'surat.id_surat')
            ->leftJoin('user', 'user.user_id', '=', 'surat_detail.kepada_id')
            ->leftJoin('user_role', 'user_role.user_id', '=', 'user.user_id')
            ->leftJoin('roles', 'roles.id', '=', 'user_role.role_id')
            ->where('surat_detail.created_by', $id)
            ->select(DB::raw('surat.id_surat as id_surat, surat.created_at as created_at, user.name as kepada,
                            surat.subject as subject, surat.body as body, surat_detail.kepada_id as untuk,
                            surat_detail.isOpened as isOpened, surat_detail.id_detail as id_detail, roles.role_name as role_name'))
            ->get();

        return view('auth.surat.sent', compact('sent', 'inbox'));

    }

    public function createSurat()
    {
        $creatorid = Session::get('user_id');


        // dd($creator);

        $user = DB::table('user')
            ->leftJoin('user_role', 'user_role.user_id', '=', 'user.user_id')
            ->leftJoin('roles', 'roles.id', '=', 'user_role.role_id')
            ->whereNot('user.user_id', $creatorid)
            ->whereNull('user.delete_at')
            ->where('user.isActive', 'Y')
            ->whereNull('user_role.delete_at')
            ->select(DB::raw('user.user_id as user_id, user.name as name, roles.role_name as role_name'))
            ->get()->toArray();
        ;
        return view('auth.surat.createsurat', compact('user'));
    }

    public function storeCreateSurat(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $request->validate([
            'kepada' => 'required|array',
            'kepada.*' => 'exists:user,user_id', // pastikan user_id valid
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'uploaded_file' => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:2048',
        ]);

        $waktu = Carbon::now()->format('YmdHis');
        $usercreator = Session::get('name');
        $creatorid = Session::get('user_id');

        $pp = null;

        if ($request->hasFile('uploaded_file')) {
            $extension = $request->file('uploaded_file')->getClientOriginalExtension();
            $pp = $usercreator . '-' . $waktu . '.' . $extension;
            $dataImage = $request->file('uploaded_file')->get();
            File::put(public_path('upload/attachment/' . $pp), $dataImage);
        }

        $surat = new Surat;
        $surat->subject = $request->subject;
        $surat->body = $request->body;
        $surat->file_uploaded = $pp;
        $surat->created_by = $creatorid;
        $surat->save();

        foreach ((array) $request->kepada as $kepada_id) {
            $detailsurat = new Detailsurat;
            $detailsurat->id_surat = $surat->id_surat;
            $detailsurat->kepada_id = $kepada_id;
            $detailsurat->created_by = $creatorid;
            $detailsurat->save();
        }

        return redirect('/inbox/' . $surat->id_surat)
            ->with('success', 'Alhamdulillah Surat berhasil dikirim');
    }

    public function readInbox($id)
    {
        $reader_id = Session::get('user_id');

        $readinbox = DB::table('surat')
            ->leftJoin('surat_detail', 'surat_detail.id_surat', '=', 'surat.id_surat')
            ->leftJoin('user', 'user.user_id', '=', 'surat.created_by')
            ->leftJoin('user_role', 'user_role.user_id', '=', 'user.user_id')
            ->leftJoin('roles', 'roles.id', '=', 'user_role.role_id')
            ->where('surat.id_surat', $id)
            ->select(DB::raw('surat.id_surat as id_surat, surat.created_at as created_at, user.name as dari,
                          surat.subject as subject, surat.body as body, surat_detail.kepada_id as untuk,
                          surat_detail.isOpened as isOpened, roles.role_name as role_name,
                          surat.file_uploaded as uploaded_file, surat_detail.id_detail as id_detail, user.profile_picture as photo'))
            ->get()->toArray();

        $inbox = DB::table('surat')
            ->leftJoin('surat_detail', 'surat_detail.id_surat', '=', 'surat.id_surat')
            // ->leftJoin('user', 'user.user_id', '=' ,'user_detail.kepada_id')
            ->leftJoin('user', 'user.user_id', '=', 'surat.created_by')
            ->where('surat_detail.id_surat', $id)
            ->select(DB::raw('surat.id_surat as id_surat, surat.created_at as created_at, user.name as dari,
                          surat.subject as subject, surat.body as body, surat_detail.kepada_id as untuk,
                          surat_detail.isOpened as isOpened'))
            ->get()->toArray();

        $sent = DB::table('surat_detail')
            ->leftJoin('surat', 'surat.id_surat', '=', 'surat_detail.id_surat')
            ->leftJoin('user', 'user.user_id', '=', 'surat_detail.kepada_id')
            ->where('surat_detail.created_by', $reader_id)
            ->select(DB::raw('surat.id_surat as id_surat, surat.created_at as created_at, user.name as kepada,
                                surat.subject as subject, surat.body as body, surat_detail.kepada_id as untuk,
                                surat_detail.isOpened as isOpened'))
            ->get();

        return view('auth.surat.readinbox', compact('readinbox', 'inbox', 'sent'));
    }

    public function readSend($id)
    {
        $reader_id = Session::get('user_id');

        $readsend = DB::table('surat_detail')
            ->leftJoin('surat', 'surat.id_surat', '=', 'surat_detail.id_surat')
            ->leftJoin('user', 'user.user_id', '=', 'surat_detail.kepada_id')
            ->leftJoin('user_role', 'user_role.user_id', '=', 'user.user_id')
            ->leftJoin('roles', 'roles.id', '=', 'user_role.role_id')
            ->where('surat_detail.id_detail', $id)
            ->select(DB::raw('surat.id_surat as id_surat, surat.created_at as created_at, user.name as kepada,
                        surat.subject as subject, surat.body as body, surat_detail.kepada_id as untuk,
                        surat_detail.isOpened as isOpened, roles.role_name as role_name,
                        surat.file_uploaded as uploaded_file, surat_detail.id_detail as id_detail, user.profile_picture as photo'))
            ->get()->toArray();

        $inbox = DB::table('surat')
            ->leftJoin('surat_detail', 'surat_detail.id_surat', '=', 'surat.id_surat')
            // ->leftJoin('user', 'user.user_id', '=' ,'user_detail.kepada_id')
            ->leftJoin('user', 'user.user_id', '=', 'surat.created_by')
            ->where('surat_detail.kepada_id', $reader_id)
            ->select(DB::raw('surat.id_surat as id_surat, surat.created_at as created_at, user.name as dari,
                          surat.subject as subject, surat.body as body, surat_detail.kepada_id as untuk,
                          surat_detail.isOpened as isOpened'))
            ->get()->toArray();

        $sent = DB::table('surat_detail')
            ->leftJoin('surat', 'surat.id_surat', '=', 'surat_detail.id_surat')
            ->leftJoin('user', 'user.user_id', '=', 'surat_detail.kepada_id')
            ->where('surat_detail.created_by', $reader_id)
            ->select(DB::raw('surat.id_surat as id_surat, surat.created_at as created_at, user.name as kepada,
                                surat.subject as subject, surat.body as body, surat_detail.kepada_id as untuk,
                                surat_detail.isOpened as isOpened'))
            ->get();

        return view('auth.surat.readsend', compact('readsend', 'inbox', 'sent'));
    }

    public function readSurat($id)
    {
        $surat = DB::table('surat')
            ->join('user as pengirim', 'surat.created_by', '=', 'pengirim.user_id')
            ->select(
                'surat.id_surat',
                'surat.subject',
                'surat.body',
                'surat.file_uploaded',
                'pengirim.name as pengirim_name',
                'surat.created_at'
            )
            ->where('surat.id_surat', $id)
            ->first();

        $penerima = DB::table('surat_detail')
            ->join('user as u', 'surat_detail.kepada_id', '=', 'u.user_id')
            ->select('u.name', 'u.email')
            ->where('surat_detail.id_surat', $id)
            ->get();

        // Tandai surat sudah dibuka
        DB::table('surat_detail')
            ->where('id_surat', $id)
            ->where('kepada_id', Session::get('user_id'))
            ->update(['isOpened' => 'Y']);

        return response()->json([
            'surat' => $surat,
            'penerima' => $penerima
        ]);
    }

}
