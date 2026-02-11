<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use App\Models\User

class UserController extends Controller
{
    //
    public function index(){
        $user= User::all();
        return view('users.index', compact('users'));
    }
}
