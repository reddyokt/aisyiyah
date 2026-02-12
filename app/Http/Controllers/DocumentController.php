<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DocumentController extends Controller
{
    // GET /document
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
                'u.name as created_name',
                'ft.filename as filetype_name',
                'pda.pda_name',
                'pca.pca_name',
            ])
            ->orderByDesc('d.id_doc')
            ->get();

        return view('auth.document.documentindex', compact('documentindex'));
    }

    // GET /document/create
    public function create()
    {
        $filetype = DB::table('filetype')
            ->where('isActive', 'Yes')
            ->whereNull('deleted_at')
            ->orderBy('filename')
            ->get();

        return view('auth.document.createdocument', compact('filetype'));
    }

    // POST /document/create
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'filetype' => ['required'], // kalau mau strict, validasi exists (lihat catatan bawah)
            'uploaded_doc' => ['required', 'file', 'mimes:pdf,jpeg,jpg,png', 'max:10240'], // 10MB
        ]);

        $user = Auth::user();

        // pastikan folder ada
        $dir = public_path('upload/document');
        File::ensureDirectoryExists($dir);

        $file = $request->file('uploaded_doc');
        $ext = strtolower($file->getClientOriginalExtension());

        // filename unik agar tidak ketimpa
        $filename = 'uploaded_doc-' . date('Y-m-d') . '-' . uniqid() . '.' . $ext;

        // simpan file ke public/upload/document
        File::put($dir . DIRECTORY_SEPARATOR . $filename, $file->get());

        // simpan data
        Document::create([
            'docname'      => $request->name,
            'id_filetype'  => $request->filetype,
            'pda_id'       => $user->pda_id,
            'pca_id'       => $user->pca_id ?? null,
            'created_by'   => $user->user_id, // PK user kamu
            'uploaded_doc' => $filename,
        ]);

        return redirect()->route('document.index')
            ->with('succes', 'Alhamdulillah Document berhasil disimpan');
    }

    // DELETE /document/{id}  (soft delete)
    public function destroy($id)
    {
        $doc = Document::where('id_doc', $id)->firstOrFail();

        // OPTIONAL: kalau mau batasi hanya role tertentu, cek di sini pakai session('menu')/role, dll.

        $doc->delete();

        return redirect()->route('document.index')
            ->with('succes', 'Document berhasil dihapus (soft delete).');
    }

    // Legacy: GET /document/delete/{id}
    public function destroyViaGet($id)
    {
        return $this->destroy($id);
    }
}
