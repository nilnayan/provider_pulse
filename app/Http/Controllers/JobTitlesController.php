<?php

namespace App\Http\Controllers;

use App\Models\JobTitle;
use Illuminate\Http\Request;
use Inertia\Inertia;

class JobTitlesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $job_titles = JobTitle::findAll();
        return Inertia::render('JobTitles/Index', [
            'job_titles' => $job_titles,
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

        JobTitle::create($data);
        return redirect(route('job-titles.index'))->with('msg', 'Created job title.');
    }

    /**
     * Display the specified resource.
     */
    public function show(JobTitle $job_title)
    {
        return $job_title;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobTitle $job_title)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JobTitle $job_title)
    {
        $data = $request->validate([
            'name' => ['required', 'min:3'],
        ]);

        $job_title->update($data);

        return redirect(route('job-titles.index'))->with('msg', 'Updated job title.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobTitle $job_title)
    {
        $job_title->delete();
        return redirect(route('job-titles.index'))->with('msg', 'Deleted job title.');
    }
}
