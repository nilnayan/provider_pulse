<?php

namespace App\Http\Controllers;

use App\Models\AccessLevel;
use App\Models\Department;
use App\Models\EmployeeStatus;
use App\Models\JobTitle;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Queue\Jobs\Job;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::query()
            ->when(request()->input('search_term'), function($query, $search_term) {
                $query->where(function($q) use ($search_term) {
                    $q->where('first_name', 'like', "%$search_term%")
                        ->orWhere('last_name', 'like', "%$search_term%")
                        ->orWhere('email', 'like', "%{$search_term}%");
                });
            })
            ->with(['accessLevel', 'department', 'employeeStatus', 'jobTitle'])
            ->orderBy('first_name')
            ->paginate(User::$per_page)
            ->withQueryString();

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

        return Inertia::render('Users/Create', [
            'user' => $user,
            'access_levels' => $access_levels,
            'departments' => $departments,
            'employee_statuses' => $employee_statuses,
            'job_titles' => $job_titles,
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

        return Inertia::render('Users/Edit', [
            'user' => $user,
            'access_levels' => $access_levels,
            'departments' => $departments,
            'employee_statuses' => $employee_statuses,
            'job_titles' => $job_titles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        User::create($this->_validate($request));
        return redirect(route('users.index', $user));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    protected function _validate(Request $request): array
    {
        $access_level_ids = implode(',', AccessLevel::all()->pluck('id')->toArray());
        $department_ids = implode(',', Department::all()->pluck('id')->toArray());
        $job_title_ids = implode(',', JobTitle::all()->pluck('id')->toArray());
        $status_ids = implode(',', EmployeeStatus::all()->pluck('id')->toArray());

        return $request->validate([
            'first_name' => ['required', 'min:2'],
            'last_name' => ['required', 'min:2'],
            'email' => ['required', 'email', Rule::unique('users')],
            'password' => ['required', 'min:3'],
            'phone' => ['nullable', 'min:7'],
            'access_level_id' => ['nullable', "in:$access_level_ids"],
            'department_id' => ['nullable', "in:$department_ids"],
            'job_title_id' => ['nullable', "in:$job_title_ids"],
            'status_id' => ['nullable', "in:$status_ids"],
            'start_dt' => ['nullable', 'date'],
            'next_review_dt' => ['nullable', 'date'],
        ]);
    }
}
