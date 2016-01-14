<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;

class UserController extends Controller
{
    public function getUsers()
    {
        $users = User::where('uid', '<', '300')->get();
        return view('home')->with('users', $users);
    }
}
