<?php

namespace App\Http\Controllers;

use App\Models\Pca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;

class PCAController extends Controller
{
    public function pcaIndex()
    {
        $role = Session::get('role_code');

        if ($role == "SUP" || $role == "PWA1" || $role == "PWA2") {
            $pcaindex = Pca::leftJoin('pda', 'pda.pda_id', '=', 'pca.pda_id')
                ->leftJoin('districts', 'districts.id', '=', 'pca.district_id')
                ->whereNull('pca.deleted_at')
                ->select(DB::raw('pca.pca_id, pca.pca_name, districts.name, pca.address, pda.pda_name as pda_name'))
                ->get()->toArray();
            ;
        } else {
            $pcaindex = Pca::leftJoin('pda', 'pda.pda_id', '=', 'pca.pda_id')
                ->leftJoin('districts', 'districts.id', '=', 'pca.district_id')
                ->whereNull('pca.deleted_at')
                ->where('pca.pda_id', Session::get('pda_id'))
                ->select(DB::raw('pca.pca_id, pca.pca_name, districts.name, pca.address, pda.pda_name as pda_name'))
                ->get()->toArray();
            ;
        }

        // $pcaindex = Pca::leftJoin('pda', 'pda.pda_id', '=', 'pca.pda_id')
        //     ->leftJoin('districts', 'districts.id', '=', 'pca.district_id')
        //     ->whereNull('pca.deleted_at')
        //     ->select(DB::raw('pca.pca_id, pca.pca_name, districts.name, pca.address, pda.pda_name as pda_name'))
        //     ->get()->toArray();


        foreach ($pcaindex as $key => $value) {
            $pcaindex[$key]['nomor'] = $key + 1;
        }

        return view('auth.masterdata.pca.pcaindex', compact('pcaindex'));
    }

    public function createPca()
    {
        $districts = DB::table('districts')
            ->get()->toArray();
        $pda = DB::table('pda')
            ->whereNull('pda.deleted_at')
            ->get()->toArray();

        return view('auth.masterdata.pca.createpca', compact('districts', 'pda'));
    }

    public function storeCreatePca(Request $request)
    {

        $storecreatepca = $request->validate([
            'name' => 'required',
            'districts' => 'required',
            'pda' => 'required',
        ]);

        $storecreatepca['pca_name'] = $request->name;
        $storecreatepca['district_id'] = $request->districts;
        $storecreatepca['address'] = $request->address;
        $storecreatepca['created_by'] = $request->id;
        $storecreatepca['pda_id'] = $request->pda;

        Pca::create($storecreatepca);

        return redirect('/pca')->with('success', 'Alhamdulillah, data PCA berhasil dibuat');
    }

    public function pdaBydistricts($id)
    {
        $pda = DB::table('pda')->where('pda.pda_id', $id)->first();
        $reg_id = $pda->regencies_id;

        $districts = DB::table('districts')->where('districts.regency_id', $reg_id)->get()->toArray();
        return response()->json($districts);


    }

    public function pcaByvillages($id)
    {
        $pca = DB::table('pca')->where('pca.pca_id', $id)->first();
        $vill_id = $pca->district_id;

        $villages = DB::table('villages')->where('villages.district_id', $vill_id)->get()->toArray();
        return response()->json($villages);

    }

    public function pcaBypdass($id)
    {
        $pca = DB::table('pca')->where('pca.pca_id', $id)->first();
        $pda_id = $pca->pda_id;

        $pdass = DB::table('pda')->where('pda.pda_id', $pda_id)->get()->toArray();
        return response()->json($pdass);

    }

    public function editPca($id)
    {
        try {
            $pcaId = Crypt::decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'Invalid ID');
        }

        // Ambil data PCA yang akan diedit
        $pca = DB::table('pca')
            ->where('pca_id', $pcaId)
            ->whereNull('deleted_at')
            ->first();

        if (!$pca) {
            abort(404, 'PCA tidak ditemukan');
        }

        // Ambil daftar PDA untuk dropdown
        $pda = DB::table('pda')
            ->whereNull('deleted_at')
            ->select('pda_id', 'pda_name')
            ->get();

        // Ambil daftar districts
        $districts = DB::table('districts')->get();

        return view('auth.masterdata.pca.editPca', compact('pca', 'pda', 'districts'));
    }

    public function updatePca(Request $request, $id)
    {
        try {
            $pcaId = Crypt::decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'Invalid ID');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'pda' => 'required|integer',
            'districts' => 'required|integer',
            'address' => 'nullable|string',
        ]);

        DB::table('pca')
            ->where('pca_id', $pcaId)
            ->update([
                'pca_name' => $request->name,
                'pda_id' => $request->pda,
                'district_id' => $request->districts,
                'address' => $request->address,
                'updated_at' => now(),
            ]);

        return redirect('/pca')->with('success', 'Data PCA berhasil diperbarui');
    }


}
