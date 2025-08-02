<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function postIndex()
    {

        $role = Session::get('role_code');

        if ($role == "SUP" || $role == "PWA1") {
            $postindex = News::leftJoin('user', 'user.user_id', '=', 'news.created_by')
                ->leftJoin('newscategory', 'newscategory.id_category', '=', 'news.id_category')
                ->leftJoin('user_role', 'user_role.user_id', '=', 'user.user_id')
                ->leftJoin('roles', 'roles.id', '=', 'user_role.role_id')
                ->whereNull('news.deleted_at')
                ->select(DB::raw('news.news_id, news.news_title as news_title,
                            news.news_body as news_body, news.feature_image as feature_image,
                            news.images as images, user.name as author,
                            newscategory.category as category,news.status as status'))
                ->get()->toArray();
        } else {
            $postindex = News::leftJoin('user', 'user.user_id', '=', 'news.created_by')
                ->leftJoin('newscategory', 'newscategory.id_category', '=', 'news.id_category')
                ->leftJoin('user_role', 'user_role.user_id', '=', 'user.user_id')
                ->leftJoin('roles', 'roles.id', '=', 'user_role.role_id')
                ->whereNull('news.deleted_at')
                ->where('news.created_by', Session::get('user_id'))
                ->select(DB::raw('news.news_id, news.news_title as news_title,
                                    news.news_body as news_body, news.feature_image as feature_image,
                                    news.images as images, user.name as author,
                                    newscategory.category as category,news.status as status'))
                ->get()->toArray();
        }

        return view('auth.news.post.postindex', compact('postindex', 'role'));
    }

    public function createPosty()
    {
        $category = DB::table('newscategory')
            ->where('isActive', 'Yes')
            ->whereNull('deleted_at')
            ->get()->toArray();

        return view('auth.news.post.createpost', compact('category'));
    }

    public function storeCreatePost(Request $request)
    {
        // dd($request);

        date_default_timezone_set('Asia/Jakarta');
        $req = $request->all();

        $waktu = Carbon::now()->format('YmdHis');
        $usercreator = Session::get('username');
        $creatorid = Session::get('user_id');
        $pp = null; // Inisialisasi $pp dengan nilai null

        if ($request->file('feature_image')) {

            $extension = $request->file('feature_image')->getClientOriginalExtension();
            $pp = 'feature_image' . '-' . $usercreator . '-' . $waktu . '.' . $extension;
            $dataImage = $request->file('feature_image')->get();
            File::put(public_path('upload/feature_image/' . $pp), $dataImage);
        }

        $storecreatepost = new News();
        $storecreatepost->news_title = $req['title'];
        $storecreatepost->slug = Str::slug($req['title']);
        $storecreatepost->news_body = $req['body'];
        $storecreatepost->id_category = $req['category'];
        $storecreatepost->feature_image = $pp;
        $storecreatepost->created_by = $creatorid;
        $storecreatepost->save();

        return redirect('/post')->with('success', 'Alhamdulillah News berhasil dibuat');
    }

    public function validasiPost($news_id)
    {
        $validasi = News::find($news_id);
        $validasi->update(['status' => 'published', 'updated_by' => Session::get('user_id')]);

        return redirect('/post')->with('success', 'Alhamdulillah News berhasil dipublish');

    }
    public function downPost($news_id)
    {
        $takedown = News::find($news_id);
        $takedown->update(['status' => 'unpublished', 'updated_by' => Session::get('user_id')]);

        return redirect('/post')->with('error', 'News telah di takedown');

    }

    public function editPost($id)
    {
        $enc = $id;
        $newscategory = DB::table('newscategory')
            ->where('isActive', 'Yes')
            ->get()->toArray();

        $editpost = DB::table('news')
            ->where('news.news_id', $id)
            ->whereNull('news.deleted_at')
            ->leftJoin('newscategory', 'newscategory.id_category', '=', 'news.id_category')
            ->leftJoin('user', 'user.user_id', '=', 'news.created_by')
            ->select(DB::raw('news.news_id as news_id, news.news_title as news_title,
                                    news.news_body as news_body, news.feature_image as feature_image,
                                    news.images as images, news.status as status, newscategory.id_category as id_category,
                                    newscategory.category as category'))
            ->first();

        return view('auth.news.post.editpost', compact('editpost', 'newscategory', 'enc'));
    }

    public function previewPost($id)
    {
        $role = Session::get('role_code');

        $preview = DB::table('news')
            ->where('news.news_id', $id)
            ->whereNull('news.deleted_at')
            ->leftJoin('newscategory', 'newscategory.id_category', '=', 'news.id_category')
            ->leftJoin('user', 'user.user_id', '=', 'news.created_by')
            ->leftJoin('user_role', 'user_role.user_id', '=', 'user.user_id')
            ->leftJoin('roles', 'roles.id', '=', 'user_role.role_id')
            ->leftJoin('pda', 'pda.pda_id', '=', 'user.pda_id')
            ->select(DB::raw('news.news_id, newscategory.category as category, news.created_at as created_at,news.news_title as news_title,
                        news.news_body as news_body, news.feature_image as feature_image, news.images as images,
                        news.status as status, user.name as author, roles.role_name as role_name,
                        pda.pda_name as pda_name'))
            ->first();

        return view('auth.news.post.previewpost', compact('preview', 'role'));
    }

    public function storeEditPost(Request $request, $id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $req = $request->all();

        $waktu = Carbon::now()->format('YmdHis');
        $usercreator = Session::get('username');
        $creatorid = Session::get('user_id');
        $pp = null; // Inisialisasi $pp dengan nilai null

        if ($request->file('feature_image')) {
            $extension = $request->file('feature_image')->getClientOriginalExtension();
            $pp = 'feature_image' . '-' . $usercreator . '-' . $waktu . '.' . $extension;
            $dataImage = $request->file('feature_image')->get();
            File::put(public_path('upload/feature_image/' . $pp), $dataImage);
        }

        // Mendapatkan nilai kategori dari permintaan
        $category = $request->input('category');

        // Jika kategori adalah array, ambil nilai pertama
        $id_category = is_array($category) ? $category[0] : $category;

        $updatepost = News::find($id);
        $updatepost->news_title = $req['title'];
        $updatepost->slug = Str::slug($req['title']);
        $updatepost->news_body = $req['body'];
        $updatepost->id_category = $req['category'];

        // Check if there's a new feature image to upload
        if ($pp !== null) {
            // Delete old feature image if exists
            if ($updatepost->feature_image) {
                $oldImagePath = public_path('upload/feature_image/' . $updatepost->feature_image);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }
            $updatepost->feature_image = $pp;
        }

        $updatepost->save();

        return redirect('/post')->with('success', 'News berhasil diupdate');
    }

    public function deletePost($id)
    {
        DB::table('news')
            ->where('news_id', $id)
            ->update([
                'deleted_at' => now(),
            ]);

        return redirect('/post')->with('error', 'Berita telah didelete.');

    }

}
