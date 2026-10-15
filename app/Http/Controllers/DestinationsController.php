<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Trip;
use Illuminate\Http\Request;

class DestinationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $destinations = Destination::with('trip')->get();
        $trips = Trip::all();
        return view('destinations\index', compact('destinations', 'trips'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $trips = Trip::all();
        return view('destinations.create', compact('trips'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'trip_id' => 'required|exists:trips,id'
        ]);
        $destination = new Destination();
        $destination->name = $validated['name'];
        $destination->country = $validated['country'];
        $destination->trip_id = $validated['trip_id'];

        $destination->save();

        return redirect()->route('destinations.index')->with('succes', 'Destinasi berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Destination $destination)
    {
        return view('destinations.show', compact('destinations'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Destination $destination)
    {

        $trips = Trip::all();
        return view('destinations.edit', compact('destination', 'trips'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Destination $destination)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'trip_id' => 'required|exists:trips,id'
        ]);

        $destination->update($request->all());
        return redirect()->route('destinations.index')->with('succes', 'Destinasi berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Destination $destination)
    {
        $destination->delete();
        return redirect()->route('destinations.index')->with('success', "Destinasi berhasil dihapus");
    }
}
