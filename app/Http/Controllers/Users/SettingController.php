<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Auth;
use Session;

class SettingController extends Controller
{
    public function index()
    {
        return view('user.profile');
    }

    public function update(UpdateUserRequest $request)
    {
        $user = Auth::User()->Update([
            'name'  => $request->name,
            'email' => $request->email
        ]);

        if ($user)
        {
            $message = 'Your Profile Update success!';
            $type = 'success';
        }else{
            $message = 'your Profile update failed !';
            $type = 'alert-danger';
        }

        Session::flash('message', $message);
        Session::flash('alert-type', $type);

        return redirect()->route('home');
    }
}
