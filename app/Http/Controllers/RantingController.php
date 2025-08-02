<?php

namespace App\Http\Controllers;

use App\Models\Ranting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;

class RantingController extends Controller
{
    public function rantingIndex()
    {
        $role = Session::get('role_code');

        if ($role == "SUP" || $role == "PWA1" || $role == "PWA2") {

            $rantingindex = Ranting::leftJoin('pca', 'pca.pca_id', '=', 'ranting.pca_id')
                ->leftJoin('pda', 'pda.pda_id', '=', 'pca.pda_id')
                ->leftJoin('villages', 'villages.id', '=', 'ranting.villages_id')
                ->whereNull('ranting.deleted_at')
                ->select(DB::raw('ranting.ranting_id, ranting.ranting_name,
                              villages.name, ranting.address as ranting_address, pca.pca_id as pca_id,
                              pca.pca_name as pca_name, pda.pda_name as pda_name, villages.name as villages'))
                ->get()->toArray();

        } else {

            $rantingindex = Ranting::leftJoin('pca', 'pca.pca_id', '=', 'ranting.pca_id')
                ->leftJoin('pda', 'pda.pda_id', '=', 'pca.pda_id')
                ->leftJoin('villages', 'villages.id', '=', 'ranting.villages_id')
                ->whereNull('ranting.deleted_at')
                ->where('pca.pda_id', Session::get('pda_id'))
                ->select(DB::raw('ranting.ranting_id, ranting.ranting_name,
                              villages.name, ranting.address as ranting_address, pca.pca_id as pca_id,
                              pca.pca_name as pca_name, pda.pda_name as pda_name, villages.name as villages'))
                ->get()->toArray();

        }


        foreach ($rantingindex as $key => $value) {
            $rantingindex[$key]['nomor'] = $key + 1;
        }

        return view('auth.masterdata.ranting.rantingindex', compact('rantingindex'));
    }

    public function createRanting()
    {
        $villages = DB::table('villages')
            ->get()->toArray();
        $pca = DB::table('pca')
            ->whereNull('pca.deleted_at')
            ->get()->toArray();

        return view('auth.masterdata.ranting.createranting', compact('villages', 'pca'));

    }

    public function storeCreateRanting(Request $request)
    {
        // dd ($request);

        $storecreateranting = $request->validate([
            'name' => 'required',
            'villages' => 'required',
            'pca' => 'required',
            'pdass' => 'required'
        ]);

        $storecreateranting['ranting_name'] = $request->name;
        $storecreateranting['villages_id'] = $request->villages;
        $storecreateranting['address'] = $request->address;
        $storecreateranting['created_by'] = $request->id;
        $storecreateranting['pca_id'] = $request->pca;
        $storecreateranting['pda_id'] = $request->pdass;

        Ranting::create($storecreateranting);

        return redirect('/ranting')->with('success', 'Alhamdulillah, data Ranting berhasil dibuat');
    }

    public function editRanting($id)
    {
        try {
            $rantingId = Crypt::decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'Invalid ID');
        }

        // Ambil data ranting
        $ranting = DB::table('ranting')
            ->where('ranting_id', $rantingId)
            ->whereNull('deleted_at')
            ->first();

        if (!$ranting) {
            abort(404, 'Ranting tidak ditemukan');
        }

        // Ambil daftar PCA
        $pca = DB::table('pca')
            ->whereNull('deleted_at')
            ->select('pca_id', 'pca_name')
            ->get();

        // Ambil daftar villages
        $villages = DB::table('villages')->get();

        return view('auth.masterdata.ranting.editRanting', compact('ranting', 'pca', 'villages'));
    }

    public function updateRanting(Request $request, $id)
    {
        try {
            $rantingId = Crypt::decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'Invalid ID');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'pca' => 'required|integer',
            'villages' => 'required|integer',
            'address' => 'nullable|string',
        ]);

        // // Cek jika villages sudah digunakan ranting lain
        // $existingRanting = DB::table('ranting')
        //     ->where('villages_id', $request->villages)
        //     ->whereNull('deleted_at')
        //     ->where('ranting_id', '!=', $rantingId)
        //     ->first();

        // if ($existingRanting) {
        //     return redirect()->back()
        //         ->withInput()
        //         ->withErrors(['villages' => 'Ranting untuk kelurahan ini sudah ada.']);
        // }

        DB::table('ranting')
            ->where('ranting_id', $rantingId)
            ->update([
                'ranting_name' => $request->name,
                'pca_id' => $request->pca,
                'villages_id' => $request->villages,
                'address' => $request->address,
                'updated_at' => now(),
            ]);

        return redirect('/ranting')->with('success', 'Data Ranting berhasil diperbarui');
    }

    public function deleteRanting($id)
    {
        try {
            $rantingId = Crypt::decrypt($id);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'ID tidak valid.');
        }

        $childTables = [
            ['table' => 'kader_info', 'column' => 'ranting_id'],
            ['table' => 'aum', 'column' => 'ranting_id'],
        ];

        foreach ($childTables as $child) {
            $exists = DB::table($child['table'])
                ->where($child['column'], $rantingId)
                ->whereNull('deleted_at')
                ->exists();

            if ($exists) {
                return redirect()->back()
                    ->with('error', "Tidak bisa menghapus ranting karena masih digunakan di tabel {$child['table']}.");
            }
        }

        DB::table('ranting')
            ->where('ranting_id', $rantingId)
            ->update([
                'deleted_at' => now(),
            ]);

        return redirect()->back()
            ->with('success', 'Ranting berhasil dihapus.');
    }


}
