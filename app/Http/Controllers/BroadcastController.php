<?php

namespace App\Http\Controllers;

use App\Events\UserCreated;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BroadcastController extends Controller
{
    public function index()
    {
        return view('broad')->with(['userId' => Auth::id()]);
    }
    public function create()
    {
        event(new UserCreated(User::orderBy('id','desc')->first()));
    }
}
