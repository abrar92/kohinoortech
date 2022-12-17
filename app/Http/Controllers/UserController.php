<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{
    function index(){
        return 0;
    }

    function user_list(){
        $data['users'] = User::all();
        return view('users.list',$data);            
    }
}
