<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserStat;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserStatsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $data = $request->validate(([
            'month' => ['required', 'between:1,12'],
            'num_patients' => ['required', 'int'],
            'comm' => ['required', 'numeric'],
        ]));

        $month = sprintf('%02d', $data['month']);
        $period = date("Y-${month}-01");
        UserStat::create([
            'user_id' => $user->id,
            'period' => $period,
            'num_patients' => $data['num_patients'],
            'comm' => $data['comm'],
        ]);

        return redirect(route('users.stats.index', ['user' => $user]))->with('msg', 'Created stat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(UserStat $user_stat)
    {
        return $user_stat;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserStat $user_stat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(User $user, UserStat $user_stat, Request $request)
    {
        $data = $request->validate(([
            'month' => ['required', 'between:1,12'],
            'num_patients' => ['required', 'int'],
            'comm' => ['required', 'numeric'],
        ]));

        $month = sprintf('%02d', $data['month']);
        $period = date("Y-${month}-01");
        $user_stat->update([
            'user_id' => $user->id,
            'period' => $period,
            'num_patients' => $data['num_patients'],
            'comm' => $data['comm'],
        ]);

        return redirect(route('users.stats.index', ['user' => $user]))->with('msg', 'Updated stat.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, UserStat $user_stat)
    {
        $user_stat->delete();
        return redirect(route('users.stats.index', ['user' => $user]))->with('msg', 'Deleted stat.');
    }
}
