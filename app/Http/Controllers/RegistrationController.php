<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sentinel;
use Activation;
use Mail;

class RegistrationController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }

    public function postRegister(Request $request)
    {
        // $user = Sentinel::registerAndActivate($request->all());
        $user = Sentinel::register($request->all());
        $activate = Activation::create($user);
        $role = Sentinel::findRoleBySlug('manager');
        $role->users()->attach($user);

        $this->sendEmail($user, $activate->code);

        return redirect('/');
    }

    private function sendEmail($user, $code)
    {
        Mail::send('email.activation', [
                'user' => $user,
                'code' => $code
            ], function($message) use ($user) {
                $message->to($user->email);
                $message->subject("Hallo $user->first_name, aktifkan akun Anda.");
            });
    }
}
