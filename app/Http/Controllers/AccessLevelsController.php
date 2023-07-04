<?php

namespace App\Http\Controllers;

use App\Models\AccessLevel;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AccessLevelsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $access_levels = AccessLevel::findAll();

        return Inertia::render('AccessLevels/Index', [
            'access_levels' => $access_levels,
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
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'min:3'],
        ]);

        AccessLevel::create($data);
        return redirect(route('access-levels.index'))->with('msg', 'Created access level.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AccessLevel $access_level)
    {
        return $access_level;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AccessLevel $accessLevel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AccessLevel $access_level)
    {
        $data = $request->validate([
            'name' => ['required', 'min:3'],
        ]);

        $access_level->update($data);
        return redirect(route('access-levels.index'))->with('msg', 'Updated access level.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AccessLevel $access_level)
    {
        $access_level->delete();
        return redirect(route('access-levels.index'))->with('msg', 'Deleted access level.');
    }
}
