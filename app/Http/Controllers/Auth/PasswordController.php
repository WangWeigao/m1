<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

use Illuminate\Http\Request;
use App\User;
use Auth;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('guest');
    }

    /**
     * 显示修改密码的表单
     * @method showResetForm
     */
    public function showResetForm()
    {
        $token = csrf_token();
        return view('auth.passwords.reset');
    }

    public function reset(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required|max:255',
            'password' => 'required|max:255|confirmed|different:old_password',
            'password_confirmation' => 'required|max:255'

        ]);
        // // return $request->all();
        $id                    = $request->user()->id;
        $email                 = $request->user()->email;
        $old_password          = $request->old_password;
        $password              = $request->password;
        $password_confirmation = $request->password_confirmation;

        $result = Auth::attempt(['email' => $email, 'password' => $old_password]);
        if($result && ($password === $password_confirmation)) {
            $user = User::find($id);
            $user->password = bcrypt($password);
            $user->save();
            $data['status'] = true;
        }else {
            $data['status'] = false;
        }
        return view('auth.passwords.success')->with('data', $data);
    }
}
