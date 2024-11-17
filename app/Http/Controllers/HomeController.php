<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product\Category;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $categories = Category::select()->orderBy('id', 'asc')->get();

        return view('home', compact('categories'));
    }

    //about
    public function about()
    {
        return view('pages.about');
    }

    //contact
    public function contact()
    {
        return view('pages.contact');
    }

    //faq
    public function faq()
    {
        return view('pages.faq');
    }

    //terms
    public function terms()
    {
        return view('pages.terms');
    }

    //privacy-policy
    public function privacyPolicy()
    {
        return view('pages.privacy');
    }
}
