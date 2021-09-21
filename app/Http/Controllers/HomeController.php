<?php

namespace App\Http\Controllers;

use App\Consument;
use App\User;
use Illuminate\Http\Request;

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
    public function index()
    {
        $user_id = auth()->id();
        if (auth()->user()->role_id == 1) {
            $booking = Consument::where('status_konsumen', 'like', '%booking%')->count();
            $follow = Consument::where('status_konsumen', 'like', '%follow%')->count();
            $reject = Consument::where('status_konsumen', 'like', '%reject%')->count();
            $all = Consument::count();
            $kon = Consument::with('user')->get();
        } else {
            $booking = Consument::where('user_id', $user_id)->where('status_konsumen', 'like', '%booking%')->count();
            $follow = Consument::where('user_id', $user_id)->where('status_konsumen', 'like', '%follow%')->count();
            $reject = Consument::where('user_id', $user_id)->where('status_konsumen', 'like', '%reject%')->count();
            $all = Consument::where('user_id', $user_id)->count();
            $kon = "";
        }

        $widget = [
            'booking' => $booking,
            'reject' => $reject,
            'follow' => $follow,
            'all' => $all,
            'kon' => $kon,
        ];

        return view('home', compact('widget'));
    }

    public function store(Request $request)
    {
        $kon = new Consument();
        $kon->name = $request->name;
        $kon->handphone = $request->handphone;
        $kon->status_konsumen = $request->task;
        $kon->user_id = auth()->id();
        $kon->save();

        return redirect()->route('member.konsumen');
    }
}
