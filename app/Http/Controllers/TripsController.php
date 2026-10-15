<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;

class TripsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trips = Trip::all();
        return view('trips\index', compact('trips'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('trips.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:225',
            'start_date' => 'required|date|before_or_equal:end_date' . now()->toDateString(),
            'end_date' => 'required|date|after_or_equal:start_date' . now()->toDateString(),
            'budget' => 'required|integer|min:1000'
        ]);

        // Membuat trip baru
        $trip = new Trip();
        $trip->name = $validated['name'];
        $trip->start_date = $validated['start_date'];
        $trip->end_date = $validated['end_date'];
        $trip->budget = $validated['budget'];

        // Simpan ke database
        $trip->save(); // Pastikan data disimpan ke database

        // Simpan ke database
        return redirect()->route('trips.index')->with('success', 'Trip berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Trip $trip)
    {
        return view('trips.show', compact('trip'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Trip $trip)
    {

        return view('trips.edit', compact('trip'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Trip $trip)
    {

        $request->validate([
            'name' => 'required|string|max:225',
            'start_date' => 'required|before_or_equal:end_date',
            'end_date' => 'required|after_or_equal:start_date',
            'budget' => 'required|integer|min:1000'
        ]);

        $trip->update($request->all());
        return redirect()->route('trips.index')->with('succes', 'Trip berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trip $trip)
    {
        $trip->delete();
        return redirect()->route('trips.index')->with('succes', 'Trip berhasil dihapus.');  
    }
}
