<?php

namespace App\Http\Controllers;

use App\Models\Kader;
use App\Models\KaderEdu;
use App\Models\KaderFile;
use App\Models\KaderOrgExt;
use App\Models\KaderOrgInt;
use App\Models\KaderTraining;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;

class KaderController extends Controller
{
    public function kaderindex()
    {
        // $kaderindex = Kader::
        //             Join('ranting','ranting.ranting_id', '=' , 'kader_info.ranting_id')
        //             ->Join('pca','pca.pca_id', '=' , 'ranting.pca_id')
        //             ->Join('pda','pda.pda_id', '=' , 'pca.pda_id')
        //             ->Join('pekerjaan','pekerjaan.id_pekerjaan', '=' , 'kader_info.pekerjaan_id')
        //             ->Join('edu_kader','edu_kader.kader_id', '=' , 'kader_info.kader_id')
        //             ->Join('kader_file','kader_file.kader_id', '=' , 'kader_info.kader_id')
        //             ->Join('orgext_kader','orgext_kader.kader_id', '=' , 'kader_info.kader_id')
        //             ->Join('orgint_kader','orgint_kader.kader_id', '=' , 'kader_info.kader_id')
        //             ->Join('training_kader','training_kader.kader_id', '=' , 'kader_info.kader_id')
        //             ->whereNull('kader_info.deleted_at')
        //             ->select(DB::raw('kader_info.kader_id as kader_id, kader_info.kader_name as kader_name,
        //                             kader_info.kader_email as kader_email, kader_info.kader_phone as kader_phone,
        //                             kader_info.gender as gender, kader_info.marital as marital, kader_info.anak as anak,
        //                             kader_info.nba as nba, kader_info.nbm as nbm, ranting.ranting_name as ranting_name,
        //                             pca.pca_name as pca_name, pda.pda_name as pda_name, edu_kader.jenjang as jenjang,
        //                             edu_kader.eduyear as eduyear, kader_file.filepp as pp, kader_file.filenbma as nbma,
        //                             orgext_kader.orgextname as orgextname, orgext_kader.orgextjabatan as orgextjabatan,
        //                             orgext_kader.orgextstart as orgextstart, orgext_kader.orgextend as orgextend,
        //                             orgint_kader.orggrade as orggrade, orgint_kader.orgintjabatan as orgintjabatan,
        //                             orgint_kader.orgintstart as orgintstart, orgint_kader.orgintend as orgintend,
        //                             training_kader.trainingtype as trainingtype, training_kader.trainingname as trainingname'))
        //             ->get();

        $kaderindex = Kader::Join('pekerjaan', 'pekerjaan.id_pekerjaan', '=', 'kader_info.pekerjaan_id')
            ->leftJoin('ranting', 'ranting.ranting_id', '=', 'kader_info.ranting_id')
            ->leftJoin('pca', 'pca.pca_id', '=', 'ranting.pca_id')
            ->leftJoin('pda', 'pda.pda_id', '=', 'pca.pda_id')
            ->leftJoin('kader_file', 'kader_file.kader_id', '=', 'kader_info.kader_id')
            ->whereNull('kader_info.deleted_at')
            ->select(DB::raw('kader_info.kader_id as kader_id, kader_info.kader_name as kader_name,
                                    kader_info.kader_email as kader_email, kader_info.kader_phone as kader_phone,
                                    kader_info.gender as gender, kader_info.marital as marital, kader_info.anak as anak,
                                    kader_info.nba as nba, kader_info.nbm as nbm, ranting.ranting_name as ranting_name,
                                    pca.pca_name as pca_name, pda.pda_name as pda_name, kader_file.filepp as pp, kader_file.filenbma as nbma '))
            ->get();

        // dd($kaderindex);

        return view('auth.masterdata.kader.kaderindex', compact('kaderindex'));
    }

    public function createkader()
    {
        $ranting = DB::table('ranting')
            ->whereNull('ranting.deleted_at')
            ->get()->toArray();

        $pekerjaan = DB::table('pekerjaan')
            ->get()->toArray();

        return view('auth.masterdata.kader.createkader', compact('ranting', 'pekerjaan'));
    }

    public function storekader(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        // $dataImage = $request->file('image');
        $req = $request->all();
        // dd($req);


        if ($request->file('profile_picture')) {

            $extension = $request->file('profile_picture')->getClientOriginalExtension();
            $pp = 'pp' . '-' . $request->kader_name . '.' . $extension;
            $dataImage = $request->file('profile_picture')->get();
            File::put(public_path('upload/kader/profile_picture/' . $pp), $dataImage);
        }
        if ($request->file('nbma')) {

            $extension = $request->file('nbma')->getClientOriginalExtension();
            $nbma = 'nbma' . '-' . $request->kader_name . '.' . $extension;
            $dataImage = $request->file('nbma')->get();
            File::put(public_path('upload/kader/nbma/' . $nbma), $dataImage);
        }

        $kader_info = new Kader;
        $kader_info->kader_name = $req['kader_name'];
        $kader_info->kader_email = $req['email'];
        $kader_info->kader_phone = str_replace('-', '', $req['phone']);
        $kader_info->ranting_id = $req['ranting'];
        $kader_info->gender = $req['gender'];
        $kader_info->marital = $req['marital'];
        $kader_info->address = $req['address'];
        $kader_info->anak = $req['anak'];
        $kader_info->pekerjaan_id = $req['pekerjaan'];
        $kader_info->nbm = $req['nbm'];
        $kader_info->nba = $req['nba'];
        $kader_info->save();

        $kader_file = new KaderFile;
        $kader_file->kader_id = $kader_info->kader_id;
        $kader_file->filepp = $pp;
        $kader_file->filenbma = $nbma;
        $kader_file->save();

        // foreach ($req['jenjang'] as $jenjang) {
        // $kader_edu = new KaderEdu;
        // $kader_edu->kader_id = $kader_info->kader_id;
        // $kader_edu->jenjang = $jenjang;
        // // $kader_edu->jenjang = $req['jenjang'];
        // $kader_edu->eduyear= $req['eduyear'];
        // $kader_edu->save();
        // }
        foreach ($req['jenjang'] as $key => $jenjang) {
            $kader_edu = [
                'kader_id' => $kader_info->kader_id,
                'jenjang' => $jenjang,
                'eduyear' => $req['eduyear'][$key],
            ];
            KaderEdu::create($kader_edu);
        }

        // foreach ($req['trainingtype'] as $trainingtype) {
        // $kader_training = new KaderTraining();
        // $kader_training->kader_id = $kader_info->kader_id;
        // $kader_training->trainingtype = $trainingtype;
        // // $kader_training->trainingtype = $req['trainingtype'];
        // $kader_training->trainingname= $req['trainingname'];
        // $kader_training->save();
        // }

        foreach ($req['trainingtype'] as $key => $trainingtype) {
            $kader_training = [
                'kader_id' => $kader_info->kader_id,
                'trainingtype' => $trainingtype,
                'trainingname' => $req['trainingname'][$key],
            ];
            KaderTraining::create($kader_training);
        }

        // foreach ($req['orggrade'] as $orggrade) {
        // $kader_orgint = new KaderOrgInt();
        // $kader_orgint->kader_id = $kader_info->kader_id;
        // $kader_orgint->orggrade = $orggrade;
        // // $kader_orgint->orggrade = $req['orggrade'];
        // $kader_orgint->orgintjabatan= $req['orgintjabatan'];
        // $kader_orgint->orgintstart= $req['orgintstart'];
        // $kader_orgint->orgintend= $req['orgintend'];
        // $kader_orgint->save();
        // }

        foreach ($req['orggrade'] as $key => $orggrade) {
            $kader_orgint = [
                'kader_id' => $kader_info->kader_id,
                'orggrade' => $orggrade,
                'orgintjabatan' => $req['orgintjabatan'][$key],
                'orgintstart' => $req['orgintstart'][$key],
                'orgintend' => $req['orgintend'][$key],
            ];
            KaderOrgInt::create($kader_orgint);
        }

        foreach ($req['orgextname'] as $key => $orgextname) {
            $kader_orgext = [
                'kader_id' => $kader_info->kader_id,
                'orgextname' => $orgextname,
                'orgextjabatan' => $req['orgextjabatan'][$key],
                'orgextstart' => $req['orgextstart'][$key],
                'orgextend' => $req['orgextend'][$key]
            ];
            KaderOrgExt::create($kader_orgext);
        }

        // foreach ($req['orgextname'] as $orgextname) {
        // $kader_orgext = new KaderOrgExt();
        // $kader_orgext->kader_id = $kader_info->kader_id;
        // $kader_orgext->orgextname= $orgextname;
        // // $kader_orgext->orgextname= $req['orgextname'];
        // $kader_orgext->orgextjabatan= $req['orgextjabatan'];
        // $kader_orgext->orgextstart= $req['orgextstart'];
        // $kader_orgext->orgextend= $req['orgextend'];
        // $kader_orgext->save();
        // }

        return redirect('/dashboard')->with('success', 'Alhamdulillah Akun berhasil dibuat');
    }

    public function kaderdetail($id)
    {
        $kaderindex = Kader::Join('pekerjaan', 'pekerjaan.id_pekerjaan', '=', 'kader_info.pekerjaan_id')
            ->leftJoin('ranting', 'ranting.ranting_id', '=', 'kader_info.ranting_id')
            ->leftJoin('pca', 'pca.pca_id', '=', 'ranting.pca_id')
            ->leftJoin('pda', 'pda.pda_id', '=', 'pca.pda_id')
            ->leftJoin('kader_file', 'kader_file.kader_id', '=', 'kader_info.kader_id')
            ->whereNull('kader_info.deleted_at')
            ->where('kader_info.kader_id', $id)
            ->select(DB::raw('kader_info.kader_id as kader_id, kader_info.kader_name as kader_name,
                                    kader_info.kader_email as kader_email, kader_info.kader_phone as kader_phone,
                                    kader_info.gender as gender, kader_info.marital as marital, kader_info.anak as anak,
                                    kader_info.nba as nba, kader_info.nbm as nbm, ranting.ranting_name as ranting_name,
                                    pca.pca_name as pca_name, pda.pda_name as pda_name, kader_file.filepp as pp, kader_file.filenbma as nbma '))
            ->get();

        $kader_edu = Kader::leftJoin('edu_kader', 'edu_kader.kader_id', '=', 'kader_info.kader_id')
            ->where('edu_kader.kader_id', $id)
            ->get();
        $kader_training = Kader::leftJoin('training_kader', 'training_kader.kader_id', '=', 'kader_info.kader_id')
            ->where('training_kader.kader_id', $id)
            ->get();
        $kader_orgint = Kader::leftJoin('orgint_kader', 'orgint_kader.kader_id', '=', 'kader_info.kader_id')
            ->where('orgint_kader.kader_id', $id)
            ->get();
        $kader_orgext = Kader::leftJoin('orgext_kader', 'orgext_kader.kader_id', '=', 'kader_info.kader_id')
            ->where('orgext_kader.kader_id', $id)
            ->get();


        return view('auth.masterdata.kader.kaderdetail', compact('kaderindex', 'kader_edu', 'kader_training', 'kader_orgint', 'kader_orgext'));
    }

    public function kaderprint($id)
    {
        $date = Carbon::now()->locale('id');
        $date->settings(['formatFunction' => 'translatedFormat']);
        date_default_timezone_set('Asia/Jakarta');

        $kaders = Kader::where('kader_id', $id)->first();
            $namepdf = str_replace(' ', '_', $kaders->kader_name);

        $kaderindex = Kader::Join('pekerjaan', 'pekerjaan.id_pekerjaan', '=', 'kader_info.pekerjaan_id')
            ->leftJoin('ranting', 'ranting.ranting_id', '=', 'kader_info.ranting_id')
            ->leftJoin('pca', 'pca.pca_id', '=', 'ranting.pca_id')
            ->leftJoin('pda', 'pda.pda_id', '=', 'pca.pda_id')
            ->leftJoin('kader_file', 'kader_file.kader_id', '=', 'kader_info.kader_id')
            ->whereNull('kader_info.deleted_at')
            ->where('kader_info.kader_id', $id)
            ->select(DB::raw('kader_info.kader_id as kader_id, kader_info.kader_name as kader_name,
                                    kader_info.kader_email as kader_email, kader_info.kader_phone as kader_phone,
                                    kader_info.gender as gender, kader_info.marital as marital, kader_info.anak as anak,
                                    kader_info.nba as nba, kader_info.nbm as nbm, ranting.ranting_name as ranting_name,
                                    pca.pca_name as pca_name, pda.pda_name as pda_name, kader_file.filepp as pp, kader_file.filenbma as nbma '))
            ->get();

        $kader_edu = Kader::leftJoin('edu_kader', 'edu_kader.kader_id', '=', 'kader_info.kader_id')
            ->where('edu_kader.kader_id', $id)
            ->get();
        $kader_training = Kader::leftJoin('training_kader', 'training_kader.kader_id', '=', 'kader_info.kader_id')
            ->where('training_kader.kader_id', $id)
            ->get();
        $kader_orgint = Kader::leftJoin('orgint_kader', 'orgint_kader.kader_id', '=', 'kader_info.kader_id')
            ->where('orgint_kader.kader_id', $id)
            ->get();
        $kader_orgext = Kader::leftJoin('orgext_kader', 'orgext_kader.kader_id', '=', 'kader_info.kader_id')
            ->where('orgext_kader.kader_id', $id)
            ->get();


        // dd($namepdf);

        $pdf = Pdf::loadView('auth.masterdata.kader.newprint', compact('kaderindex', 'kader_edu', 'kader_training', 'kader_orgint', 'kader_orgext', 'date'))->setPaper('a4', 'portrait');
        return $pdf->stream('detail'.'-'.$namepdf.'.pdf');
    }

    public function PCAbyPDA($id)
    {
        $pca = DB::table('pca')->where("pda_id", $id)->whereNull('deleted_at')->get()->toArray();
        return response()->json($pca);
    }
}
