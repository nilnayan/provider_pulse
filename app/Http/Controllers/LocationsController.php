<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class LocationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $states = [null => null] + State::all()->sortBy('name')->pluck('name', 'id')->toArray();
        $locations = Location::findAll();

        return Inertia::render('Locations/Index', [
            'states' => $states,
            'locations' => $locations,
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
        $data = $this->_validate($request);
        Location::create($data);

        return redirect(route('locations.index'))->with('msg', 'Created location.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Location $location)
    {
        return $location;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Location $location)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Location $location)
    {
        $data = $this->_validate($request, $location->id);
        $location->update($data);

        return redirect(route('locations.index'))->with('msg', 'Updated location.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location)
    {
        $this->delete();
        return redirect(route('locations.index'))->with('msg', 'Deleted location.');
    }

    protected function _validate(Request $request, $location_id = null)
    {
        return $request->validate([
            'name' => ['required', 'min:3', Rule::unique('locations')->ignore($location_id)],
            'addr1' => ['nullable', 'min:3'],
            'addr2' => ['nullable', 'min:3'],
            'city' => ['nullable', 'min:3'],
            'state' => ['nullable', 'exists:states,id'],
            'phone' => ['nullable', 'min:10'],
            'email' => ['nullable', 'email']
        ]);
    }
}
