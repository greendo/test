<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Referal;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\User;

class RegistersUsers
{

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        $valid_link = true;
        $inviter = null;

        if (Input::except('iid', 'link'))
            $valid_link = false;
        else {
            $iid = Input::get('iid');
            $link = Input::get('link');

            $referals = new Referal();
            $ref = $referals::where('inviter_id', '=', $iid)->first();

            if (!is_null($ref) && $ref->link_two == $link) {
                $user = User::find($iid);
                $inviter = $user->name;
            } elseif (!is_null($ref) && $ref->link_one == $link) {
                if ((time() - $ref->time_one) > 60)
                    $valid_link = false;
                else {
                    $user = User::find($iid);
                    $inviter = $user->name;
                }
            }
            if ($link)
                if ($ref->link_two != $link && $ref->link_one != $link)
                    $valid_link = false;
        }

        if ($valid_link)
            return view('auth.register', [
                'inviter' => $inviter,
                'inviter_id' => $iid
            ]);
        else
            return Redirect::to('link_error');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public
    function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        DB::table('users')->where('name', Input::get('name'))->update(['inviter_id' => Input::get('inviter_id')]);

        $this->guard()->login($user);

        return redirect($this->redirectPath());
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected
    function guard()
    {
        return Auth::guard();
    }
}
