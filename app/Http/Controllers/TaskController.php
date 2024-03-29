<?php

namespace App\Http\Controllers;

use App\Events\TaskCreatedEvent;
use App\Notifications\TaskCreatedNotification;
use App\Task;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return Auth::user()->tasks;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $user = Auth::user();
        $task = $user->tasks()->create([
            'content' => rand()
        ]);
        Notification::send($user, new TaskCreatedNotification($user, $task));

        // if want to send to all user
//        Notification::send(User::all(), new TaskCreatedNotification($user, $task));
        $user->unreadNotifications->markAsRead();
//        $user->notify(new TaskCreatedNotification());
        return $task;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $task = Auth::user()->tasks()->create($request->all());
        event((new TaskCreatedEvent($task)));
        return $task;
    }

    /**
     * Display the specified resource.
     *
     * @param Task $task
     * @return Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Task $task
     * @return Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Task $task
     * @return Response
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Task $task
     * @return Response
     */
    public function destroy(Task $task)
    {
        //
    }
}
