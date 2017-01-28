<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sentinel;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;

class LoginController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
        try {
            if (Sentinel::authenticate($request->all())) {
                $slug = Sentinel::getUser()->roles()->first()->slug;

                if($slug == 'admin')
                    return redirect('/earnings');
                elseif($slug == 'manager')
                    return redirect('/tasks');

            }else{
                return back()->with(['error' => 'Wrong credentials.']);
            }
        } catch (ThrottlingException $e) {
            $delay = $e->getDelay();

            return back()->with(['error' => "You are banned for $delay seconds."]);
        }catch (NotActivatedException $e) {
            return back()->with(['error' => "Your account not activated yet."]);
        }
    }

    public function logout()
    {
        Sentinel::logout();

        return redirect('/login');
    }

    public function getLogout()
    {
        return back()->with(['error' => 'You are not Allowed to logout from address bar!']);
    }
}
