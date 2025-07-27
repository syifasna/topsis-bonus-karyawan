<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(): View
    {
        return view('user.dashboard');
    }

    public function gate(): View
    {
        return view('gate');
    }

    public function adminHome(): View
    {
        return view('admin.dashboard');
    }

    public function spk(): View
    {
        return view('spk.home');
    }

    public function ownerHome(): View
    {
        return view('owner.dashboard');
    }
}
