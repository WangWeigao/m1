<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;

class TeacherController extends Controller
{
    public function getTeachers()
    {
        $teachers = User::where('usertype', '>', 1)->paginate(15);
        return view('teachers')->with('teachers', $teachers);
    }
}
