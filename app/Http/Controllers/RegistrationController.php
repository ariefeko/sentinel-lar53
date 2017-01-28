<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sentinel;
use Activation;

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
        $role = Sentinel::findRoleBySlug('manager');
        $role->users()->attach($user);

        return redirect('/');
    }
}
