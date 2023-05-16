<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class UserFilesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(User $user)
    {
        $user_files = UserFile::findByUser($user, request());

        return Inertia::render('UserFiles/Index', [
            'user' => $user,
            'user_files' => $user_files,
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
        $request->validate([
            'user_file' => 'required|mimes:csv,pdf,txt,xls,xlsx|max:2048',
        ]);

        $file_name = $user->getIdDisplay() . '.' . time() . '.' . $request->user_file->extension();

        $request->user_file->storeAs('user_files', $file_name);

        UserFile::create([
            'user_id' => $user->id,
            'file_name' => $file_name,
            'description' => $request->description,
        ]);

        return redirect(route('users.files.index', ['user' => $user]))->with('msg', 'Saved file.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user, UserFile $user_file)
    {
//        return response()->download(Storage::path('user_files/' . $user_file->file_name));
        return Storage::download('user_files/' . $user_file->file_name);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user, UserFile $user_file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserFile $user_file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, UserFile $user_file)
    {
        $old_path = 'user_files/' . $user_file->file_name;
        Storage::move($old_path, "$old_path.del");

        $user_file->delete();

        return redirect(route('users.files.index', ['user' => $user]))->with('msg', 'Deleted file.');
    }
}
