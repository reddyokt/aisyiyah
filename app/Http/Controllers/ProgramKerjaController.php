<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use App\Models\ProgramKerja;
use App\Models\ProkerDetail;
use App\Models\ProkerImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProgramKerjaController extends Controller
{
    public function periodeIndex()
    {
        $periodeindex = DB::table('periode')->get()->toArray();

        return view('auth.proker.periodeindex', compact('periodeindex'));
    }

    public function createPeriode()
    {
        return view('auth.proker.createperiode');
    }
    public function storeCreatePeriode(Request $request)
    {
        // dd($request);

        $isActive = DB::table('periode')->where('isActive', 'Yes')->first();
        if ($isActive != Null) {

            return redirect()->back()->with('error', 'Tidak bisa membuat periode baru, Masih ada periode aktif');
        }
        $periode = new Periode;

        $periode->from = \DateTime::createFromFormat('m/d/Y', $request->from);
        $periode->to = \DateTime::createFromFormat('m/d/Y', $request->to);
        $periode->description = $request->description;

        $periode->save();

        return redirect('/periode')->with('success', 'Alhamdulillah Periode berhasil dibuat');
    }

    public function editPeriode($id)
    {
        $editperiode = DB::table('periode')->where('id_periode', $id)->first();
        return view('auth.proker.editperiode', compact('editperiode'));
    }

    public function storeEditPeriode(Request $request, $id)
    {
        $storeEditPeriode = Periode::find($id);
        $storeEditPeriode->from = \DateTime::createFromFormat('m/d/Y', $request->from);
        $storeEditPeriode->to = \DateTime::createFromFormat('m/d/Y', $request->to);
        $storeEditPeriode->description = $request->description;

        $storeEditPeriode->update();

        return redirect('/periode')->with('success', 'Periode telah diedit');
    }

    // public function prokerIndex()
    // {
    //     $role = Session::get('role_code');

    //     if ($role == "SUP" || $role == "PWA1" || $role == "PWA2") {
    //         $prokerindex = DB::table('proker')
    //             ->leftJoin('periode', 'periode.id_periode', '=', 'proker.id_periode')
    //             ->leftJoin('user', 'user.user_id', '=', 'proker.created_by')
    //             ->leftJoin('pda', 'pda.pda_id', '=', 'user.pda_id')
    //             ->whereNull('proker.deleted_at')
    //             ->select(DB::raw('proker.id_proker as id_proker, proker.proker_name as name,
    //         proker.prokerstart as start, proker.prokerend as end, proker.status as status,
    //         proker.anggaran as anggaran, user.name as username, pda.pda_name as pda_name'))
    //             ->get()->toArray();
    //     } elseif ($role == "MDA1" || $role == "MWA1" || $role == "MDA2" || $role == "MWA2") {
    //         $prokerindex = DB::table('proker')
    //             ->leftJoin('periode', 'periode.id_periode', '=', 'proker.id_periode')
    //             ->leftJoin('user', 'user.user_id', '=', 'proker.created_by')
    //             ->leftJoin('pda', 'pda.pda_id', '=', 'user.pda_id')
    //             ->whereNull('proker.deleted_at')
    //             ->where('proker.typeproker', 'majelis')
    //             ->where('proker.pda_id', Session::get('pda_id'))
    //             ->select(DB::raw('proker.id_proker as id_proker, proker.proker_name as name,
    //         proker.prokerstart as start, proker.prokerend as end, proker.status as status,
    //         proker.anggaran as anggaran, user.name as username, pda.pda_name as pda_name'))
    //             ->get()->toArray();
    //     }

    //     return view('auth.proker.prokerindex', compact('prokerindex'));
    // }
    
    public function prokerIndex()
{
    $role = Session::get('role_code');
    $prokerindex = []; // Initialize $prokerindex as an empty array

    if ($role == "SUP" || $role == "PWA1" || $role == "PWA2") {
        $prokerindex = DB::table('proker')
            ->leftJoin('periode', 'periode.id_periode', '=', 'proker.id_periode')
            ->leftJoin('user', 'user.user_id', '=', 'proker.created_by')
            ->leftJoin('pda', 'pda.pda_id', '=', 'user.pda_id')
            ->whereNull('proker.deleted_at')
            ->select(DB::raw('proker.id_proker as id_proker, proker.proker_name as name,
        proker.prokerstart as start, proker.prokerend as end, proker.status as status,
        proker.anggaran as anggaran, user.name as username, pda.pda_name as pda_name'))
            ->get()->toArray();
    } elseif ($role == "MDA1" || $role == "MWA1" || $role == "MDA2" || $role == "MWA2") {
        $prokerindex = DB::table('proker')
            ->leftJoin('periode', 'periode.id_periode', '=', 'proker.id_periode')
            ->leftJoin('user', 'user.user_id', '=', 'proker.created_by')
            ->leftJoin('pda', 'pda.pda_id', '=', 'user.pda_id')
            ->whereNull('proker.deleted_at')
            ->where('proker.typeproker', 'majelis')
            ->where('proker.pda_id', Session::get('pda_id'))
            ->select(DB::raw('proker.id_proker as id_proker, proker.proker_name as name,
        proker.prokerstart as start, proker.prokerend as end, proker.status as status,
        proker.anggaran as anggaran, user.name as username, pda.pda_name as pda_name'))
            ->get()->toArray();
    }

    return view('auth.proker.prokerindex', compact('prokerindex'));
}


    public function createProker()
    {

        $role = Session::get('role_code');
        $id_majelis = Session::get('id_majelis');
        $pda = DB::table('pda')->whereNull('deleted_at')->get()->toArray();
        $periode = DB::table('periode')->where('periode.isActive', 'Yes')->first();
        $majelis = DB::table('majelis')->leftJoin('user', 'user.id_majelis', '=', 'majelis.id_majelis')
            ->where('majelis.id_majelis', Session::get('id_majelis'))
            ->select(DB::raw('majelis.name as name'))->first();

        if ($periode?->id_periode == Null) {
            $noperiode = '1';
            $dateend = '';
            $datestart = '';
        } else {

            $noperiode = '0';
            $datestart = Carbon::parse($periode->from)->locale('id');
            $datestart->settings(['formatFunction' => 'translatedFormat']);

            $dateend = Carbon::parse($periode->to)->locale('id');
            $dateend->settings(['formatFunction' => 'translatedFormat']);
        }
        return view('auth.proker.createproker', compact('noperiode', 'periode', 'datestart', 'dateend', 'role', 'pda', 'majelis', 'id_majelis'));
    }

    public function storeCreateProker(Request $request)
    {
        // dd($request);

        date_default_timezone_set('Asia/Jakarta');

        // $dataImage = $request->file('image');
        $req = $request->all();

        $proker = new ProgramKerja;
        $proker->id_periode = $req['periode'];
        $proker->proker_name = $req['prokername'];
        $proker->prokerstart = \DateTime::createFromFormat('m/d/Y', $req['from']);
        $proker->prokerend = \DateTime::createFromFormat('m/d/Y', $req['to']);
        // $proker->anggaran = $req['anggaran'];
        $proker->anggaran = str_replace(',', '', $req['anggaran']);
        $proker->created_by = Session::get('user_id');
        $proker->description = $req['description'];
        $proker->pda_id = Session::get('pda_id');
        $proker->id_majelis = Session::get('id_majelis');
        $proker->typeproker = $req['typeproker'];
        $proker->pelaksana = $req['pelaksana'];
        $proker->save();


        $proker_detail = new ProkerDetail;
        $proker_detail->id_proker = $proker->id_proker;
        $proker_detail->initial = $req['initial'];
        $proker_detail->note_update = 'Program Kerja' . ' ' . $proker->proker_name . ' ' . 'diajukan';
        $proker_detail->created_by = Session::get('user_id');
        $proker_detail->save();

        return redirect('/proker')->with('success', 'alhamdulillah Program Kerja berhasil disimpan.');
    }

    public function prokerDetail($id)
    {
        $proker = DB::table('proker')
            ->leftJoin('prokerdetail', 'prokerdetail.id_proker', '=', 'proker.id_proker')
            ->leftJoin('pda', 'pda.pda_id', '=', 'proker.pda_id')
            ->where('proker.id_proker', $id)
            ->whereNull('proker.deleted_at')
            ->select(DB::raw('proker.id_proker, proker.proker_name, proker.anggaran, proker.description,
                                        proker.status, proker.prokerstart, proker.prokerend,
                                        prokerdetail.created_at as created_at, pda.pda_name as pda_name'))
            ->first();
        $prokerdetail = DB::table('prokerdetail')
            ->where('prokerdetail.id_proker', $id)
            ->leftJoin('user', 'user.user_id', '=', 'prokerdetail.created_by')
            ->select(DB::raw('prokerdetail.id_prokerdetail, prokerdetail.initial as initial, 
                                        prokerdetail.note_update as note_update, prokerdetail.created_at as created_at, 
                                        user.name as name, prokerdetail.proker_image'))
            ->get()->toArray();

        $prokerimage = DB::table('proker_image')
            ->where('proker_image.id_proker', $id)
            ->get()->toArray();

        return view('auth.proker.prokerdetail', compact('proker', 'prokerdetail', 'prokerimage'));
    }

    public function editProker($id)
    {
        $role = Session::get('role_code');
        $pda = DB::table('pda')->whereNull('deleted_at')->get()->toArray();

        $editproker = DB::table('proker')
            ->leftJoin('periode', 'periode.id_periode', '=', 'proker.id_periode')
            ->leftJoin('user', 'user.user_id', '=', 'proker.created_by')
            ->leftJoin('pda', 'pda.pda_id', '=', 'user.pda_id')
            ->whereNull('proker.deleted_at')
            ->where('proker.id_proker', $id)
            ->select(DB::raw('proker.id_proker as id_proker, proker.proker_name as name,
                proker.description as descr, proker.prokerstart as start, proker.prokerend as end,
                proker.status as status, proker.anggaran as anggaran, user.name as username,
                pda.pda_name as pda_name'))
            ->first();

        return view('auth.proker.editproker', compact('editproker', 'role', 'pda'));
    }

    public function storeEditProker(Request $request, $id)
    {
        $storeeditproker = ProgramKerja::find($id);
        $storeeditproker->update($request->all());

        return redirect('/proker')->with('success', 'Program Kerja telah diedit');
    }

    public function validasiMda(Request $request, $id)
    {
        $validasi = ProgramKerja::find($id);
        $validasi->update(['status' => 'validatedbymda', 'updated_by' => Session::get('user_id')]);

        $proker_detail = new ProkerDetail;
        $proker_detail->id_proker = $validasi->id_proker;
        $proker_detail->initial = 'Update';
        $proker_detail->note_update = 'Program Kerja' . ' ' . $validasi->proker_name . ' ' . 'disetujui oleh Ketua Majelis';
        $proker_detail->created_by = Session::get('user_id');
        $proker_detail->save();

        return redirect()->back()->with('success', 'Program Kerja telah disetujui');
    }

    public function validasiPda(Request $request, $id)
    {
        $validasi = ProgramKerja::find($id);
        $validasi->update(['status' => 'validatedbypda', 'updated_by' => Session::get('user_id')]);

        $proker_detail = new ProkerDetail;
        $proker_detail->id_proker = $validasi->id_proker;
        $proker_detail->initial = 'Update';
        $proker_detail->note_update = 'Program Kerja' . ' ' . $validasi->proker_name . ' ' . 'disetujui oleh Ketua PDA';
        $proker_detail->created_by = Session::get('user_id');
        $proker_detail->save();

        return redirect()->back()->with('success', 'Program Kerja telah disetujui');
    }

    public function validasiPwa(Request $request, $id)
    {
        $validasi = ProgramKerja::find($id);
        $validasi->update(['status' => 'validatedbypwa', 'updated_by' => Session::get('user_id')]);

        $proker_detail = new ProkerDetail;
        $proker_detail->id_proker = $validasi->id_proker;
        $proker_detail->initial = 'Update';
        $proker_detail->note_update = 'Program Kerja' . ' ' . $validasi->proker_name . ' ' . 'disetujui oleh Ketua PWA, Program Kerja Dapat Dilaksanakan.';
        $proker_detail->created_by = Session::get('user_id');
        $proker_detail->save();

        return redirect()->back()->with('success', 'Program Kerja telah disetujui');
    }

    public function updateProker($id)
    {
        $role = Session::get('role_code');
        $pda = DB::table('pda')->whereNull('deleted_at')->get()->toArray();

        $proker = DB::table('proker')
            ->leftJoin('prokerdetail', 'prokerdetail.id_proker', '=', 'proker.id_proker')
            ->leftJoin('pda', 'pda.pda_id', '=', 'proker.pda_id')
            ->where('proker.id_proker', $id)
            ->whereNull('proker.deleted_at')
            ->select(DB::raw('proker.id_proker as id_proker, proker.proker_name, proker.anggaran, proker.description,
                            proker.status, proker.prokerstart, proker.prokerend,
                            prokerdetail.created_at as created_at, pda.pda_name as pda_name'))
            ->first();

        $update = DB::table('proker')
            ->leftJoin('prokerdetail', 'prokerdetail.id_proker', '=', 'proker.id_proker')
            ->leftJoin('pda', 'pda.pda_id', '=', 'proker.pda_id')
            ->where('proker.id_proker', $id)
            ->whereNull('proker.deleted_at')
            ->select(DB::raw('proker.id_proker as id_proker, proker.proker_name, proker.anggaran, proker.description,
                            proker.status, proker.prokerstart, proker.prokerend,
                            prokerdetail.created_at as created_at, pda.pda_name as pda_name'))
            ->first();

        // dd($proker->id_proker);

        $prokerdetail = DB::table('prokerdetail')
            ->where('prokerdetail.id_proker', $id)
            ->leftJoin('user', 'user.user_id', '=', 'prokerdetail.created_by')
            ->select(DB::raw('prokerdetail.id_prokerdetail, prokerdetail.initial as initial, 
                            prokerdetail.note_update as note_update, prokerdetail.created_at as created_at, 
                            user.name as name, prokerdetail.proker_image'))
            ->get()->toArray();

        $prokerimage = DB::table('proker_image')
            ->where('proker_image.id_proker', $id)
            ->get()->toArray();

        return view('auth.proker.updateproker', compact('proker', 'prokerdetail', 'prokerimage', 'role', 'pda', 'update'));
    }

    public function storeUpdate(Request $request, $id)
    {

        // dd($request);
        date_default_timezone_set('Asia/Jakarta');
        $req = $request->all();

        $waktu = Carbon::now()->format('YmdHis');
        $usercreator = Session::get('username');
        $creatorid = Session::get('user_id');

        if ($request->hasfile('images')) {
            foreach ($request->file('images') as $image) {
                $namafile = str_replace(' ', '_', $request->name);

                $name = $namafile . '_' . time() . rand(1, 50) . '.' . $image->extension();
                // File::put(public_path('upload/aum/'.$name), $dataImage);
                $image->move(public_path('/upload/proker/gallery/'), $name);

                $storeupdate = new ProkerImage();
                $storeupdate['id_proker'] = $request->id_proker;
                $storeupdate['images_proker'] = str_replace('"', '', $name);
                $storeupdate['created_by'] = $request->id;
                $storeupdate->save();
            }
        }

        $proker_detail = new ProkerDetail;
        $proker_detail->id_proker = $req['id_proker'];
        $proker_detail->initial = $req['initial'];
        $proker_detail->note_update = $req['description'];
        $proker_detail->created_by = Session::get('user_id');
        $proker_detail->save();

        return redirect()->back()->with('success', 'Program Kerja telah diupdate');
    }

    public function unrealized(Request $request, $id)
    {
        date_default_timezone_set('Asia/Jakarta');

        $unrealizeds = DB::table('proker')
            ->where('proker.id_proker', $id)
            ->leftJoin('user', 'user.user_id', '=', 'proker.created_by')
            ->select(DB::raw('proker.id_proker, user.name as name, proker.created_by as created_by'))
            ->first();

        $unrealized = ProgramKerja::find($id);

        if ($unrealized->created_by != Session::get('user_id')) {
            return redirect()->back()->with('error', 'Anda tidak berhak mengubah status Tidak Terealisasi, 
                                        Yang bisa mengubah adalah ' . $unrealizeds->name);
        }

        $unrealized->update(['status' => 'unrealized', 'updated_by' => Session::get('user_id')]);

        $proker_detail = new ProkerDetail;
        $proker_detail->id_proker = $id;
        $proker_detail->initial = 'Finish';
        $proker_detail->note_update = 'Program Kerja dihentikan dengan status Tidak Terealisasi';
        $proker_detail->created_by = Session::get('user_id');
        $proker_detail->save();

        return redirect()->back()->with('warning', 'Program Kerja telah diubah statusnya menjadi Tidak Terealisasi');
    }

    public function realized(Request $request, $id)
    {
        date_default_timezone_set('Asia/Jakarta');

        $realizeds = DB::table('proker')
            ->where('proker.id_proker', $id)
            ->leftJoin('user', 'user.user_id', '=', 'proker.created_by')
            ->select(DB::raw('proker.id_proker, user.name as name, proker.created_by as created_by'))
            ->first();

        $realized = ProgramKerja::find($id);

        if ($realized->created_by != Session::get('user_id')) {
            return redirect()->back()->with('error', 'Anda tidak berhak mengubah status Terealisasi!, 
                                        Yang bisa mengubah adalah ' . $realizeds->name);
        }

        $realized->update(['status' => 'realized', 'updated_by' => Session::get('user_id')]);

        $proker_detail = new ProkerDetail;
        $proker_detail->id_proker = $id;
        $proker_detail->initial = 'Finish';
        $proker_detail->note_update = 'Program Kerja selesai dengan status Terealisasi';
        $proker_detail->created_by = Session::get('user_id');
        $proker_detail->save();
        return redirect()->back()->with('success', 'Program Kerja telah diubah statusnya menjadi Terealisasi');
    }
}
