<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destination;
use App\Models\Activity;
use App\Models\Trip;

class ActivitiesController extends Controller
{
    public function index()
    {
        $activities = Activity::with('destination')->get(); // Ambil semua data aktivitas
        $destinations = Destination::all(); // Ambil semua destinasi

        return view('activities.index', compact('activities', 'destinations'));
    }
    public function create()
    {
        $destinations = Destination::all();
        return view('activities.create', compact('destinations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'destination_id' => 'required|exists:destinations,id',
            'name' => 'required|string|max:255',
            'time' => 'required|date',
            'cost' => 'required|numeric|min:1000'
        ]);


        // Ambil Destination yang dipilih
        $destination = Destination::findOrFail($request->destination_id);

        // Ambil Trip yang berhubungan dengan Destination ini
        $trip = $destination->trip; // Pastikan relasi trip() ada di model Destination

        // Hitung total biaya Activity yang sudah ada dalam Trip ini
        $totalActivityCost = Activity::whereHas('destination', function ($query) use ($trip) {
            $query->where('trip_id', $trip->id);
        })->sum('cost');

        // Tambahkan biaya activity yang baru diinputkan
        $newTotalCost = $totalActivityCost + $request->cost;

        $existingActivity = Activity::whereHas('destination', function ($query) use ($destination) {
            $query->where('destination_id', $destination->id);
        })->exists();

        if ($existingActivity) {
            return redirect()->back()->withErrors(['destination_id' => 'Destinasi ini sudah memiliki Aktivitas!'])->withInput();
        }

        // Cek apakah total biaya activity melebihi budget trip
        if ($newTotalCost > $trip->budget) {
            return redirect()->back()->withErrors(['cost' => 'Total biaya aktivitas melebihi anggaran trip!'])->withInput();
        }

        // Pastikan tanggal activity dalam rentang tanggal Trip
        if ($request->time < $trip->start_date || $request->time > $trip->end_date) {
            return redirect()->back()->withErrors([
                'time' => 'Tanggal aktivitas harus dalam rentang Trip (' . $trip->start_date . ' - ' . $trip->end_date . ')'
            ])->withInput();
        }

        $activity = new Activity();
        $activity->name = $validated['name'];
        $activity->time = $validated['time'];
        $activity->cost = $validated['cost'];
        $activity->destination_id = $validated['destination_id'];
        $activity->save();
        return redirect()->route('activities.index')->with('success', 'Destinasi berhasil ditambahkan');
    }

    public function show($id)
    {
        $activity = Activity::findOrFail($id);
        return response()->json($activity);
    }
    public function edit(Activity $activity)
    {

        $destinations = Destination::all();
        return view('activities.edit', compact('destinations', 'activity'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'time' => 'required|date',
            'cost' => 'required|numeric|min:1000'
        ]);

        // Ambil Destination yang dipilih
        $destination = Destination::findOrFail($request->destination_id);

        // Ambil Trip yang berhubungan dengan Destination ini
        $trip = $destination->trip; // Pastikan relasi trip() ada di model Destination

        // Hitung total biaya Activity yang sudah ada dalam Trip ini
        $totalActivityCost = Activity::whereHas('destination', function ($query) use ($trip) {
            $query->where('trip_id', $trip->id);
        })->sum('cost');

        // Tambahkan biaya activity yang baru diinputkan
        $newTotalCost = $totalActivityCost + $request->cost;

        // Cek apakah total biaya activity melebihi budget trip
        if ($newTotalCost > $trip->budget) {
            return redirect()->back()->withErrors(['cost' => 'Total biaya aktivitas melebihi anggaran trip!'])->withInput();
        }

        // Pastikan tanggal activity dalam rentang tanggal Trip
        if ($request->time < $trip->start_date || $request->time > $trip->end_date) {
            return redirect()->back()->withErrors(['time' => 'Tanggal aktivitas harus dalam rentang Trip (' . $trip->start_date . ' - ' . $trip->end_date . ')'])->withInput();
        }


        $activity = Activity::findOrFail($id);
        $activity->update($request->all());

        return redirect()->route('activities.index')->with('succes', 'Destinasi berhasil diperbarui');
    }

    public function destroy(Activity $activity)
    {

        $activity->delete();
        return redirect()->route('activities.index')->with('succes', "Destinasi berhasil dihapus");
    }
    public function getTripDates($destination_id)
    {
        $destination = Destination::findOrFail($destination_id);

        // Ambil trip berdasarkan destination
        $trip = $destination->trip; // Asumsi: destination punya trip

        // Pastikan trip ditemukan dan memiliki tanggal mulai dan selesai
        if (!$trip) {
            return response()->json(['error' => 'Trip tidak ditemukan'], 404);
        }

        // Kirim tanggal dalam format Y-m-d
        return response()->json([
            'start_date' => $trip->start_date->format('Y-m-d'),
            'end_date' => $trip->end_date->format('Y-m-d')
        ]);
    }
}
