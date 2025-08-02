<?php

namespace App\Http\Controllers;

use App\Models\Pda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class PdaController extends Controller
{
    public function pdaIndex()
    {
        $pdaindex = Pda::leftJoin('regencies', 'regencies.id', '=', 'pda.regencies_id')
            ->whereNull('pda.deleted_at')
            ->select(DB::raw('pda.pda_id, pda.pda_name, regencies.name, pda.address'))
            ->get()->toArray();


        foreach ($pdaindex as $key => $value) {
            $pdaindex[$key]['nomor'] = $key + 1;
        }

        return view('auth.masterdata.pda.pdaindex', compact('pdaindex'));
    }

    public function createPda()
    {
        $regencies = DB::table('regencies')
            ->get()->toArray();

        return view('auth.masterdata.pda.createpda', compact('regencies'));

    }

    public function storeCreatePda(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'regencies' => 'required|integer',
        ]);

        // Cek jika regency sudah punya PDA
        $existingPda = Pda::where('regencies_id', $request->regencies)
            ->whereNull('deleted_at')
            ->first();

        if ($existingPda) {
            return redirect('/pda')->with('error', 'Ooops Gagal!, Sudah ada data PDA untuk Kabupaten/Kota tersebut');
        }

        // Simpan data baru
        Pda::create([
            'pda_name' => $request->name,
            'regencies_id' => $request->regencies,
            'address' => $request->address,
            'created_by' => $request->id,
        ]);

        return redirect('/pda')->with('success', 'Alhamdulillah, data PDA berhasil dibuat');
    }

    public function editPda($id)
    {
        try {
            $pdaId = Crypt::decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'Invalid ID');
        }

        $pda = DB::table('pda')
            ->where('pda_id', $pdaId)
            ->whereNull('deleted_at')
            ->first();

        if (!$pda) {
            abort(404, 'PDA tidak ditemukan');
        }

        $regencies = DB::table('regencies')->get();

        return view('auth.masterdata.pda.editPda', compact('pda', 'regencies'));
    }

    public function updatePda(Request $request, $id)
    {
        try {
            $pdaId = Crypt::decrypt($id);
        } catch (\Exception $e) {
            abort(404, 'Invalid ID');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'regencies' => 'required|integer',
            'address' => 'nullable|string',
        ]);

        DB::table('pda')
            ->where('pda_id', $pdaId)
            ->update([
                'pda_name' => $request->name,
                'regencies_id' => $request->regencies,
                'address' => $request->address,
                'updated_at' => now(),
            ]);

        return redirect()->route('pdaIndex')->with('success', 'PDA berhasil diperbarui');
    }

}
