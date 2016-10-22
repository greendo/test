<?php

namespace App\Http\Controllers;

use App\Referal;
use App\ReferalBack;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $active_link = null;

        $userId = Auth::id();
        $referals = new Referal();
        $ref = $referals::where('inviter_id', '=', $userId)->first();
        if (!is_null($ref))
            $active_link = url('/register') . '?iid=' . $userId . '&link=' . $ref->link_two;

        $invited_users = DB::table('users')->where('inviter_id', $userId)->get();

        $inviter_id = DB::table('users')->where('id', $userId)->get()->first()->inviter_id;
        $inviter = DB::table('users')->where('id', $inviter_id)->get()->first();

        if($inviter == null)
            $inviter = false;

        return view('home', [
            'invited_users' => $invited_users,
            'active_link' => $active_link,
            'inviter' => $inviter
        ]);
    }

    private function rndlnk() {
        return substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1).substr(md5(time()),1);
    }

    public function createLink()
    {
        if ($userId = Auth::id()) {
            $referals = new Referal();
            $ref = $referals::where('inviter_id', '=', $userId)->first();

            if(!is_null($ref)) {
                DB::table('referal')->where('inviter_id', $userId)->update([
                    'link_one' => $ref->link_two,
                    'time_one' => $ref->time_two,
                    'link_two' => $this->rndlnk(),
                    'time_two' => time()
                ]);
            }
            else {
                DB::table('referal')->insert([
                    'inviter_id' => $userId,
                    'link_two' => $this->rndlnk(),
                    'time_two' => time()
                ]);
            }

            return Redirect::to('home');
        } else
            return view('errors.403');
    }
}
