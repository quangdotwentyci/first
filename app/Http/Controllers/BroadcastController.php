<?php

namespace App\Http\Controllers;

use App\Events\UserCreated;
use App\User;
use Illuminate\Http\Request;

class BroadcastController extends Controller
{
    public function index()
    {
        return view('broad');
    }
    public function create()
    {
        event(new UserCreated(User::orderBy('id','desc')->first()));
    }
}
