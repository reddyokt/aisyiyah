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
                    ->leftJoin('user', 'user.user_id', '=' ,'news.created_by')
                    ->leftJoin('newscategory', 'newscategory.id_category', '=' ,'news.id_category')
                    ->leftJoin('user_role', 'user_role.user_id', '=' ,'user.user_id')
                    ->leftJoin('roles', 'roles.id', '=' ,'user_role.role_id' )
                    ->whereNull('news.deleted_at')
                    ->where('news.status', 'published')
                    ->select(DB::raw('news.news_id, news.news_title as news_title, news.slug as slug,
                                    news.news_body as news_body, news.feature_image as feature_image,
                                    news.images as images, user.username as author,
                                    newscategory.category as category,news.status as status, news.created_at as created_at'))
                    ->get()->toArray();
        return view('landing.index', compact('postLanding','landingprop'));
    }

    public function postLanding()
    {
        $postLanding = DB::table('news')
                    ->leftJoin('user', 'user.user_id', '=' ,'news.created_by')
                    ->leftJoin('newscategory', 'newscategory.id_category', '=' ,'news.id_category')
                    ->leftJoin('user_role', 'user_role.user_id', '=' ,'user.user_id')
                    ->leftJoin('roles', 'roles.id', '=' ,'user_role.role_id' )
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
                    ->leftJoin('newscategory', 'newscategory.id_category', '=' ,'news.id_category')
                    ->leftJoin('user', 'user.user_id', '=' , 'news.created_by')
                    ->select(DB::raw('news.news_id as news_id, news.slug as slug, news.news_title as news_title,
                                    news.news_body as news_body, news.feature_image as feature_image,
                                    news.images as images, news.status as status, newscategory.id_category as id_category,
                                    newscategory.category as category, news.created_at as created_at, user.username as author'))
                    ->first();

        $anotherpost = DB::table('news')
                    ->whereNot('news.slug', $slug)
                    ->where('news.status', 'published')
                    ->whereNull('news.deleted_at')
                    ->leftJoin('newscategory', 'newscategory.id_category', '=' ,'news.id_category')
                    ->leftJoin('user', 'user.user_id', '=' , 'news.created_by')
                    ->select(DB::raw('news.news_id as news_id, news.news_title as news_title, news.slug as slug,
                                    news.news_body as news_body, news.feature_image as feature_image,
                                    news.images as images, news.status as status, newscategory.id_category as id_category,
                                    newscategory.category as category, news.created_at as created_at, user.username as author'))
                    ->get()->toArray();

        return view('landing.blogpost',compact('postBlog','anotherpost'));
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

        return redirect()->back()->with('success','Landing Property di update');

    }
}
