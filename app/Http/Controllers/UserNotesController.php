<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserNote;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserNotesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(User $user)
    {
        $user_notes = UserNote::findByUser($user, request());

//        dd($user_notes);

        return Inertia::render('UserNotes/Index', [
            'user' => $user,
            'user_notes' => $user_notes,
            'filters' => request()->only(['start_dt', 'end_dt', 'search_term']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(User $user, Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'min:3'],
            'content' => ['required', 'min:3']
        ]);

        $data['user_id'] = $user->id;
        UserNote::create($data);

        return redirect(route('users.notes.index', ['user' => $user]))->with('msg', 'Created note.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user, UserNote $user_note)
    {
        return $user_note;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserNote $userNote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(User $user, UserNote $user_note, Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'min:3'],
            'content' => ['required', 'min:3']
        ]);

        $user_note->update($data);
        return redirect(route('users.notes.index', ['user' => $user]))->with('msg', 'Updated note.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, UserNote $user_note)
    {
        $user_note->delete();
        return redirect(route('users.notes.index', ['user' => $user]))->with('msg', 'Deleted note.');
    }
}
