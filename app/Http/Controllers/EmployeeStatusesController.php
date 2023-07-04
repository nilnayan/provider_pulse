<?php

namespace App\Http\Controllers;

use App\Models\EmployeeStatus;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmployeeStatusesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employee_statuses = EmployeeStatus::findAll();
        return Inertia::render('EmployeeStatuses/Index', [
            'employee_statuses' => $employee_statuses,
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

        EmployeeStatus::create($data);
        return redirect(route('employee-statuses.index'))->with('msg', 'Created employee status.');
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeStatus $employeeStatus)
    {
        return $employeeStatus;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeStatus $employeeStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmployeeStatus $employeeStatus)
    {
        $data = $request->validate([
            'name' => ['required', 'min:3'],
        ]);

        $employeeStatus->update($data);
        return redirect(route('employee-statuses.index'))->with('msg', 'Updated employee status.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeStatus $employeeStatus)
    {
        $employeeStatus->delete();
        return redirect(route('employee-statuses.index'))->with('msg', 'Deleted employee status.');
    }
}
