<?php

namespace App\Http\Controllers;

use App\Models\Aum;
use App\Models\AumImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;


class AumController extends Controller
{
    public function aumIndex()
    {
        $aumindex = DB::table('aum')
            ->leftJoin('bidangusaha', 'bidangusaha.id_bidangusaha', '=', 'aum.id_bidangusaha')
            ->leftJoin('kepemilikan', 'kepemilikan.id_kepemilikan', '=', 'aum.id_kepemilikan')
            ->leftJoin('ranting', 'ranting.ranting_id', '=', 'aum.ranting_id')
            ->leftJoin('pca', 'pca.pca_id', '=', 'aum.pca_id')
            ->leftJoin('pda', 'pda.pda_id', '=', 'aum.pda_id')
            ->whereNull('aum.deleted_at')
            ->select(DB::raw('aum.id_aum, aum.isActive as status, aum.address, aum.aum_name as aum_name,
                                    kepemilikan.name as kepemilikan_name, bidangusaha.name as bidangusaha,
                                    ranting.ranting_name, pca.pca_name, pda.pda_name, aum.ranting_id, aum.pca_id, aum.pda_id'))
            ->get()->toArray();
        return view('auth.aum.aumindex', compact('aumindex'));
    }

    public function createAum()
    {
        $kepemilikan = DB::table('kepemilikan')
            ->whereNull('deleted_at')
            ->get()->toArray();
        $bidangusaha = DB::table('bidangusaha')
            ->where('isActive', 'Yes')
            ->get()->toArray();
        return view('auth.aum.createaum', compact('kepemilikan', 'bidangusaha'));
    }

    public function storeCreateAum(Request $request)
    {
        // dd($request);

        $aum = $request->validate([
            'inlineRadioOptions' => 'required',
            'kepemilikan' => 'required',
            'bidangusaha' => 'required',
            'pda' => 'required',
            'name' => 'required'
        ]);

        date_default_timezone_set('Asia/Jakarta');
        $aum = new Aum;
        $aum->ranting_id = $request->ranting;
        $aum->pca_id = $request->pca;
        $aum->pda_id = $request->pda;
        $aum->id_kepemilikan = $request->kepemilikan;
        $aum->id_bidangusaha = $request->bidangusaha;
        $aum->pengelolaby = $request->inlineRadioOptions;
        $aum->aum_name = $request->name;
        $aum->address = $request->address;
        $aum->created_by = $request->id;
        $aum->save();

        // $images = [];
        if ($request->hasfile('images')) {
            foreach ($request->file('images') as $image) {
                $namafile = str_replace(' ', '_', $request->name);

                $name = $namafile . '_' . time() . rand(1, 50) . '.' . $image->extension();
                // File::put(public_path('upload/aum/'.$name), $dataImage);
                $image->move(public_path('/upload/aum/'), $name);

                $aum_image = new AumImage();
                $aum_image['id_aum'] = $aum->id_aum;
                $aum_image['images'] = str_replace('"', '', $name);
                $aum_image['created_by'] = $request->id;
                $aum_image->save();

            }
        }

        return redirect('/aum')->with('success', 'Alhamdulillah, data AUM berhasil disimpan');
    }

    public function aumDetail($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return view('error.404');
        }

        $aum = DB::table('aum')
            ->where('aum.id_aum', $id)
            ->leftJoin('pda', 'pda.pda_id', '=', 'aum.pda_id')
            ->leftJoin('pca', 'pca.pca_id', '=', 'aum.pca_id')
            ->leftJoin('ranting', 'ranting.ranting_id', '=', 'aum.ranting_id')
            ->leftJoin('bidangusaha', 'bidangusaha.id_bidangusaha', '=', 'aum.id_bidangusaha')
            ->leftJoin('kepemilikan', 'kepemilikan.id_kepemilikan', '=', 'aum.id_kepemilikan')
            ->select(DB::raw('aum.id_aum, aum.aum_name as aum_name, aum.address as address, aum.pengelolaby as pengelola,
                    aum.isActive as status, pda.pda_id as pda_id, pda.pda_name as pda_name,
                    pca.pca_id as pca_id, pca.pca_name as pca_name, ranting.ranting_id as ranting_id, 
                    ranting.ranting_name as ranting_name, bidangusaha.name as bidangusaha, 
                    kepemilikan.name as kepemilikan'))
            ->first();
        $aum_image = DB::table('aum_image')
            ->where('aum_image.id_aum', $id)
            ->whereNull('deleted_at')
            ->get()->toArray();

        return view('auth.aum.aumdetail', compact('aum', 'aum_image'));
    }



    public function aumByRanting()
    {
        $rantings = DB::table('ranting')->get()->toArray();
        return response()->json($rantings);
    }

    public function aumByPca()
    {
        $pcas = DB::table('pca')->get()->toArray();
        return response()->json($pcas);
    }

    public function aumByPda()
    {
        $pdas = DB::table('pda')->get()->toArray();
        return response()->json($pdas);
    }

    public function pcasByrantings($id)
    {
        $pca_id = DB::table('ranting')->where('ranting.ranting_id', $id)->first();
        $pca = $pca_id->pca_id;

        $pcass = DB::table('pca')->where('pca.pca_id', $pca)->get()->toArray();
        return response()->json($pcass);

    }

    public function pdasByrantings($id)
    {
        $pda_id = DB::table('ranting')->where('ranting.ranting_id', $id)->first();
        $pda = $pda_id->pda_id;

        $pdass = DB::table('pda')->where('pda.pda_id', $pda)->get()->toArray();
        return response()->json($pdass);

    }

    public function pdasBypcass($id)
    {
        $pda_id = DB::table('pca')->where('pca.pca_id', $id)->first();
        $pda = $pda_id->pda_id;

        $pdass = DB::table('pda')->where('pda.pda_id', $pda)->get()->toArray();
        return response()->json($pdass);

    }

    public function editAum($id)
    {
        try {
            $aumId = Crypt::decrypt($id);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'ID AUM tidak valid.');
        }

        $aum = DB::table('aum')
            ->where('id_aum', $aumId)
            ->whereNull('deleted_at')
            ->first();

        if (!$aum) {
            return redirect()->back()->with('error', 'Data AUM tidak ditemukan.');
        }

        $images = DB::table('aum_image')
            ->where('id_aum', $aumId)
            ->whereNull('deleted_at')
            ->get();

        $bidangusaha = DB::table('bidangusaha')->where('isActive', 'Yes')->get();
        $kepemilikan = DB::table('kepemilikan')->whereNull('deleted_at')->get();
        $ranting = DB::table('ranting')->whereNull('deleted_at')->get();
        $pca = DB::table('pca')->whereNull('deleted_at')->get();
        $pda = DB::table('pda')->whereNull('deleted_at')->get();

        return view('auth.aum.edit', compact('aum', 'bidangusaha', 'kepemilikan', 'ranting', 'pca', 'pda', 'images'));
    }

    public function updateAum(Request $request, $id)
    {
        try {
            $aumId = Crypt::decrypt($id);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'ID AUM tidak valid.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'bidangusaha' => 'required|integer',
            'kepemilikan' => 'required|integer',
            'inlineRadioOptions' => 'required|string',
            'address' => 'nullable|string',
        ]);

        DB::table('aum')
            ->where('id_aum', $aumId)
            ->update([
                'aum_name' => $request->name,
                'id_bidangusaha' => $request->bidangusaha,
                'id_kepemilikan' => $request->kepemilikan,
                'pengelolaby' => $request->inlineRadioOptions,
                'pda_id' => $request->pda,
                'pca_id' => $request->pca,
                'ranting_id' => $request->ranting_id,
                'address' => $request->address,
                'updated_at' => now(),
            ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $namafile = str_replace(' ', '_', $request->name);
                $name = $namafile . '_' . time() . rand(1, 50) . '.' . $image->getClientOriginalExtension();

                // Pastikan folder ada
                $path = public_path('upload/aum');
                if (!file_exists($path)) {
                    mkdir($path, 0775, true);
                }

                $image->move($path, $name);

                // Simpan dengan Eloquent
                $aum_image = new AumImage();
                $aum_image->id_aum = $aumId;
                $aum_image->images = $name;
                $aum_image->created_by = $request->id;
                $aum_image->save();
            }
        }

        return redirect('/aum')->with('success', 'AUM berhasil diperbarui.');
    }

    public function deleteImage(Request $request)
    {
        $id = $request->id;

        $image = DB::table('aum_image')->where('id_aum_image', $id)->first();

        if (!$image) {
            return response()->json(['success' => false, 'message' => 'Gambar tidak ditemukan.']);
        }

        DB::table('aum_image')
            ->where('id_aum_image', $id)
            ->update(['deleted_at' => now()]);

        // Hapus file fisik
        $path = public_path('upload/aum/' . $image->images);
        if (file_exists($path)) {
            unlink($path);
        }

        return response()->json(['success' => true, 'message' => 'Foto berhasil dihapus.']);
    }

    public function deleteAum($id)
    {
        try {
            $aumId = Crypt::decrypt($id);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'ID AUM tidak valid.');
        }

        DB::table('aum')
            ->where('id_aum', $aumId)
            ->update([
                'deleted_at'=> now(),
            ]);

        return redirect('/aum')->with('error', 'AUM telah didelete.');

    }

}
