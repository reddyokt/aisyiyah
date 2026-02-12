<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DocumentController extends Controller
{
    public function index()
    {
        $documentindex = DB::table('document as d')
            ->leftJoin('filetype as ft', 'ft.id_filetype', '=', 'd.id_filetype')
            ->leftJoin('pda as pda', 'pda.pda_id', '=', 'd.pda_id')
            ->leftJoin('pca as pca', 'pca.pca_id', '=', 'd.pca_id')
            ->leftJoin('user as u', 'u.user_id', '=', 'd.created_by')
            ->whereNull('d.deleted_at')
            ->select([
                'd.id_doc',
                'd.pda_id',
                'd.pca_id',
                'd.uploaded_doc',
                'd.docname',
                DB::raw('COALESCE(ft.filename, "-") as filename'),
                DB::raw('COALESCE(u.name, "-") as name'),
                'pda.pda_name',
                'pca.pca_name',
            ])
            ->orderByDesc('d.id_doc')
            ->get();

        return view('auth.document.documentindex', compact('documentindex'));
    }

    public function create()
    {
        $filetype = DB::table('filetype')
            ->where('isActive', 'Yes')
            ->whereNull('deleted_at')
            ->orderBy('filename')
            ->get();

        return view('auth.document.createdocument', compact('filetype'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'filetype' => ['required'],
            'uploaded_doc' => ['required', 'file', 'mimes:pdf,jpeg,jpg,png', 'max:10240'],
        ]);

        $user = Auth::user();

        $dir = public_path('upload/document');
        File::ensureDirectoryExists($dir);

        $file = $request->file('uploaded_doc');
        $ext = strtolower($file->getClientOriginalExtension());
        $filename = 'uploaded_doc-' . date('Y-m-d') . '-' . uniqid() . '.' . $ext;

        File::put($dir . DIRECTORY_SEPARATOR . $filename, $file->get());

        Document::create([
            'docname'      => $request->name,
            'id_filetype'  => $request->filetype,
            'pda_id'       => $user->pda_id,
            'pca_id'       => $user->pca_id ?? null,
            'created_by'   => $user->user_id, // PK tabel user kamu
            'uploaded_doc' => $filename,
        ]);

        return redirect()->route('document.index')->with('succes', 'Alhamdulillah Document berhasil disimpan');
    }

    public function destroy($id)
    {
        $doc = Document::where('id_doc', $id)->firstOrFail();
        $doc->delete(); // Soft delete

        return redirect()->route('document.index')->with('succes', 'Document berhasil dihapus (soft delete)');
    }

    public function destroyViaGet($id)
    {
        return $this->destroy($id);
    }

    // opsional: stub edit/update kalau belum dipakai
    public function edit($id)
    {
        abort(404);
    }
    public function update(Request $request, $id)
    {
        abort(404);
    }
}
