<?php

namespace App\Http\Controllers;

use App\Models\SatisfactionLevel;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SatisfactionLevelsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $satisfaction_levels = SatisfactionLevel::findAll();

        return Inertia::render('SatisfactionLevels/Index', [
            'satisfaction_levels' => $satisfaction_levels,
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

        SatisfactionLevel::create($data);
        return redirect(route('satisfaction-levels.index'))->with('msg', 'Created satisfaction level.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SatisfactionLevel $satisfaction_level)
    {
        return $satisfaction_level;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SatisfactionLevel $satisfactionLevel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SatisfactionLevel $satisfaction_level)
    {
        $data = $request->validate([
            'name' => ['required', 'min:3'],
        ]);

        $satisfaction_level->update($data);
        return redirect(route('satisfaction-levels.index'))->with('msg', 'Updated satisfaction level.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SatisfactionLevel $satisfaction_level)
    {
        $satisfaction_level->delete();
        return redirect(route('satisfaction-levels.index'))->with('msg', 'Deleted satisfaction level.');
    }
}
