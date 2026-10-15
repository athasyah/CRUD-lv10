<?php

namespace App\Http\Controllers;

use App\Models\Companion;
use App\Models\Trip;
use Illuminate\Http\Request;

class CompanionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companions = Companion::with('trip')->get();
        $trips = Trip::all();
        return view('companions.index', compact('companions', 'trips'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $trips = Trip::all();
        return view('companions.create', compact('trips'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255'
        ]);

        Companion::create($validated);
        return redirect()->route('companions.index')->with('success', 'Pendamping berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Companion $companion)
    {
        return view('companions.show', compact('companion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Companion $companion)
    {
        $trips = Trip::all();
        return view('companions.edit', compact('companion', 'trips'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Companion $companion)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255'
        ]);

        $companion->update($validated);
        return redirect()->route('companions.index')->with('success', 'Pendamping berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Companion $companion)
    {
        $companion->delete();
        return redirect()->route('companions.index')->with('success', 'Pendamping berhasil dihapus');
    }
}
