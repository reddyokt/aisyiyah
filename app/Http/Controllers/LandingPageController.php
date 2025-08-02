<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LandingPageController extends Controller
{
    public function index()
    {
        $landingprop = DB::table('landing_page')->where('landing_page.id_landing', '1')->first();

        $postLanding = DB::table('news')
            ->leftJoin('user', 'user.user_id', '=', 'news.created_by')
            ->leftJoin('newscategory', 'newscategory.id_category', '=', 'news.id_category')
            ->leftJoin('user_role', 'user_role.user_id', '=', 'user.user_id')
            ->leftJoin('roles', 'roles.id', '=', 'user_role.role_id')
            ->whereNull('news.deleted_at')
            ->where('news.status', 'published')
            ->select(DB::raw('news.news_id, news.news_title as news_title, news.slug as slug,
                                    news.news_body as news_body, news.feature_image as feature_image,
                                    news.images as images, user.username as author,
                                    newscategory.category as category,news.status as status, news.created_at as created_at'))
            ->get()->toArray();
        return view('landing.index', compact('postLanding', 'landingprop'));
    }

    public function postLanding()
    {
        $postLanding = DB::table('news')
            ->leftJoin('user', 'user.user_id', '=', 'news.created_by')
            ->leftJoin('newscategory', 'newscategory.id_category', '=', 'news.id_category')
            ->leftJoin('user_role', 'user_role.user_id', '=', 'user.user_id')
            ->leftJoin('roles', 'roles.id', '=', 'user_role.role_id')
            ->whereNull('news.deleted_at')
            ->select(DB::raw('news.news_id, news.news_title as news_title,
                                    news.news_body as news_body, news.feature_image as feature_image,
                                    news.images as images, news.created_by as author,
                                    newscategory.category as category,news.status as status, news.created_at as created_at'))
            ->get()->toArray();
        return view('landing.post', compact('postLanding'));
    }

    public function postBlog($slug)
    {
        $postBlog = DB::table('news')
            ->where('news.slug', $slug)
            ->where('news.status', 'published')
            ->whereNull('news.deleted_at')
            ->leftJoin('newscategory', 'newscategory.id_category', '=', 'news.id_category')
            ->leftJoin('user', 'user.user_id', '=', 'news.created_by')
            ->select(DB::raw('news.news_id as news_id, news.slug as slug, news.news_title as news_title,
                                    news.news_body as news_body, news.feature_image as feature_image,
                                    news.images as images, news.status as status, newscategory.id_category as id_category,
                                    newscategory.category as category, news.created_at as created_at, user.username as author'))
            ->first();

        $anotherpost = DB::table('news')
            ->whereNot('news.slug', $slug)
            ->where('news.status', 'published')
            ->whereNull('news.deleted_at')
            ->leftJoin('newscategory', 'newscategory.id_category', '=', 'news.id_category')
            ->leftJoin('user', 'user.user_id', '=', 'news.created_by')
            ->select(DB::raw('news.news_id as news_id, news.news_title as news_title, news.slug as slug,
                                    news.news_body as news_body, news.feature_image as feature_image,
                                    news.images as images, news.status as status, newscategory.id_category as id_category,
                                    newscategory.category as category, news.created_at as created_at, user.username as author'))
            ->get()->toArray();

        return view('landing.blogpost', compact('postBlog', 'anotherpost'));
    }

    public function landingProperty()
    {
        $landing = DB::table('landing_page')->where('landing_page.id_landing', '1')->first();

        return view('landing.landingprop', compact('landing'));
    }

    public function updateProperty(Request $request)
    {
        // dd($request); 

        $update = LandingPage::find(1);
        $update->update($request->all());

        return redirect()->back()->with('success', 'Landing Property di update');

    }

    public function dataPwa()
    {
        return view('landing.dataPWA');
    }

    public function dataPwaNew()
    {
        $data = DB::table('pda')
            ->leftJoin('pca', 'pda.pda_id', '=', 'pca.pda_id')
            ->select('pda.pda_name', 'pda.pda_id', DB::raw('COUNT(pca.pca_id) as total_pca'))
            ->whereNull('pda.deleted_at')
            ->groupBy('pda.pda_id', 'pda.pda_name')
            ->get();

        return view('landing.dataPWANew', compact('data'));
    }

    public function dataDetailPda($id)
    {
        // Data PDA
        $pda = DB::table('pda')
            ->where('pda_id', $id)
            ->whereNull('deleted_at')
            ->first();

        if (!$pda) {
            abort(404, 'Data PDA tidak ditemukan');
        }

        // Data PCA terkait PDA
        $pca = DB::table('pca')
            ->where('pda_id', $id)
            ->whereNull('deleted_at')
            ->select('pca_id', 'district_id', 'pca_name', 'address', 'created_at')
            ->orderBy('pca_name')
            ->get();

        // Data PRA terkait PDA
        $pra = DB::table('ranting')
            ->where('pda_id', $id)
            ->whereNull('deleted_at')
            ->select('ranting_id', 'villages_id', 'ranting_name', 'address', 'created_at')
            ->orderBy('ranting_name')
            ->get();

        // Data AUM terkait PDA
        $aum = DB::table('aum')
            ->leftJoin('kepemilikan', 'aum.id_kepemilikan', '=', 'kepemilikan.id_kepemilikan')
            ->leftJoin('bidangusaha', 'aum.id_bidangusaha', '=', 'bidangusaha.id_bidangusaha')
            ->where('aum.pda_id', $id)
            ->whereNull('aum.deleted_at')
            ->select(
                'aum.id_aum',
                'aum.ranting_id',
                'aum.pca_id',
                'aum.pda_id',
                'aum.aum_name',
                'aum.pengelolaby',
                'aum.address',
                'aum.isActive',
                'aum.created_by',
                'aum.created_at',
                'kepemilikan.name as kepemilikan_name',
                'bidangusaha.name as bidangusaha_name'
            )
            ->orderBy('aum.aum_name')
            ->get();

        return view('landing.detailPda', compact('pda', 'pca', 'aum', 'pra'));
    }

}
