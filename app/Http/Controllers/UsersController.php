<?php

namespace App\Http\Controllers;

use App\Models\AccessLevel;
use App\Models\Department;
use App\Models\EmployeeStatus;
use App\Models\JobTitle;
use App\Models\SatisfactionLevel;
use App\Models\User;
use App\Models\UserNote;
use Illuminate\Http\Request;
use Illuminate\Queue\Jobs\Job;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::findAll(request());

        return Inertia::render('Users/Index', [
            'users' => $users,
            'filters' => request()->only(['search_term'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = new User();

        $access_levels = AccessLevel::getOptions();
        $departments = Department::getOptions();
        $employee_statuses = EmployeeStatus::getOptions();
        $job_titles = JobTitle::getOptions();
        $satisfaction_levels = SatisfactionLevel::getOptions();

        return Inertia::render('Users/Create', [
            'user' => $user,
            'access_levels' => $access_levels,
            'departments' => $departments,
            'employee_statuses' => $employee_statuses,
            'job_titles' => $job_titles,
            'satisfaction_levels' => $satisfaction_levels,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        User::create($this->_validate($request));
        return redirect('/users');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user_notes = $user->userNotes()->orderBy('updated_at', 'desc')->limit(3)->get();
        $user_files = $user->userFiles()->orderBy('updated_at', 'desc')->limit(3)->get();
        $user_stats = $user->userStats()->orderBy('period', 'desc')->get();

        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[$i] = date('F', mktime(0, 0, 0, $i, 1));
        }

        return Inertia::render('Users/Show', [
            'user' => $user,
            'access_level' => $user->accessLevel,
            'department' => $user->department,
            'job_title' => $user->jobTitle,
            'employee_status' => $user->employeeStatus,
            'months' => $months,
            'satisfaction_level' => $user->satisfactionLevel,
            'user_files' => $user_files,
            'user_notes' => $user_notes,
            'user_stats' => $user_stats,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $access_levels = AccessLevel::getOptions();
        $departments = Department::getOptions();
        $employee_statuses = EmployeeStatus::getOptions();
        $job_titles = JobTitle::getOptions();
        $satisfaction_levels = SatisfactionLevel::getOptions();

        $photo_url = $user->photo ? Storage::url('user_files/' . $user->photo) : null;

        return Inertia::render('Users/Edit', [
            'user' => $user,
            'access_levels' => $access_levels,
            'departments' => $departments,
            'employee_statuses' => $employee_statuses,
            'job_titles' => $job_titles,
            'photo_url' => $photo_url,
            'satisfaction_levels' => $satisfaction_levels,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(User $user, Request $request)
    {
        $data = $this->_validate($request, $user->id);
        if ($request->input('photo_action') == 'add') {
            $photo_f_name = $user->getIdDisplay() . '.avatar.' . $request->photo->extension();
            $data['photo'] = $photo_f_name;
            $request->photo->storeAs('user_files', $photo_f_name);

        } else if ($request->input('photo_action') == 'del') {
            $data['photo'] = null;
        }

        $user->update($data);
        return redirect(route('users.index', $user))->with('msg', 'Updated user.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    protected function _validate(Request $request, $user_id = null): array
    {
        $access_level_ids = implode(',', AccessLevel::all()->pluck('id')->toArray());
        $department_ids = implode(',', Department::all()->pluck('id')->toArray());
        $job_title_ids = implode(',', JobTitle::all()->pluck('id')->toArray());
        $status_ids = implode(',', EmployeeStatus::all()->pluck('id')->toArray());

        return $request->validate([
            'first_name' => ['required', 'min:2'],
            'last_name' => ['required', 'min:2'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user_id)],
            'password' => ['required', 'min:3'],
            'phone' => ['nullable', 'min:7'],
            'access_level_id' => ['nullable', "in:$access_level_ids"],
            'department_id' => ['nullable', "in:$department_ids"],
            'job_title_id' => ['nullable', "in:$job_title_ids"],
            'status_id' => ['nullable', "in:$status_ids"],
            'start_dt' => ['nullable', 'date'],
            'next_review_dt' => ['nullable', 'date'],
            'photo' => ['file', 'mimes:gif,jpg,jpeg,png']
        ]);
    }
}
