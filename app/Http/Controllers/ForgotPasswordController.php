<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\User;
use Reminder;
use Sentinel;

class ForgotPasswordController extends Controller
{
    public function forgot()
    {
        return view('auth.forgot-password');
    }

    public function postForgot(Request $request)
    {
        $user = User::whereEmail($request->email)->first();
        $sentinelUser = Sentinel::findById($user->id);

        if (count($user) == 0)
            return back()->with([
                'success' => 'Reset code was sent to email.'
            ]);

        $reminder = Reminder::exists($sentinelUser) ?: Reminder::create($sentinelUser);
        $this->sendEmail($user, $reminder->code);

        return back()->with([
            'success' => 'Reset code has been sent to your email.'
        ]);
    }

    public function sendEmail($user, $code)
    {
        Mail::send('email.forgot-password', [
                'user' => $user,
                'code' => $code
            ], function ($message) use ($user) {
                $message->to($user->email);

                $message->subject("Hello $user->name, reset your password.");
            });
    }

    public function resetPassword($email, $resetCode)
    {
        $user = User::byEmail($email);
        $sentinelUser = Sentinel::findById($user->id);

        if (count($user) == 0)
            return abort(404);

        if ($reminder = Reminder::exists($sentinelUser)){
            if ($resetCode == $reminder->code)
                return view('auth.reset-password');
            else
                return redirect('/');
        } else {
            return redirect('/');
        }

        // return $user;
    }

    public function postResetPassword(Request $request, $email, $resetCode)
    {
        $this->validate($request, [
                'password' => 'confirmed|required|min:5',
                'password_confirmation' => 'required|min:5'
            ]);

        $user = User::byEmail($email);

        if (count($user) == 0)
            return abort(404);

        $sentinelUser = Sentinel::findById($user->id);

        if ($reminder = Reminder::exists($sentinelUser)){
            if ($resetCode == $reminder->code) {
                Reminder::complete($sentinelUser, $resetCode, $request->password);

                return redirect('/login')->with(['success' => 'Please login with your new password.']);
            }
            else
                return redirect('/');
        } else {
            return redirect('/');
        }
    }
}
