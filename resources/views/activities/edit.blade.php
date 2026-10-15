<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>
@extends('layouts.app')
    
    @section('content')
    <div class="navbarr">
        <center>
             <h2>Edit Activity</h2> 
        </center>
       
    </div>
<div class="container">
    

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('activities.update', $activity->id) }}" method="POST">
        @csrf
        @method('PUT') 
        <div class="mb-4">
            <label for="destination_id" class="form-label">Pilih Destinasi</label>
            <select name="destination_id" id="destination_id" class="form-select form-select-lg rounded-3 shadow-sm border-0" style="background-color: white" >
                <option value="" disabled>Pilih Destinasi</option>
                @foreach ($destinations as $destination)
                <option value="{{ $destination->id }}">{{ $destination->name }}</option>
            @endforeach
            </select>
        </div>
        <div class="my-3">
            <label for="name" class="form-label">Aktifitas</label>
            <input type="text" name="name" id="name" class="form-control rounded-3 shadow-sm border-0" value="{{ old('name',$activity->name) }}" >
        </div>
        <div class="my-3">
            <label for="time" class="form-label">waktu</label>
            <input type="datetime-local" name="time" id="time" class="form-control rounded-3 shadow-sm border-0" value="{{ old('time',$activity->time) }}" >
        </div>
        <div class="my-3">
            <label for="cost" class="form-label">Pengeluaran</label>
            <input type="number" name="cost" id="cost" class="form-control rounded-3 shadow-sm border-0"value="{{ old('cost',$activity->cost) }}" >
        </div>
        <button type="submit" class="btn btn-info">Simpan</button>
    </form>
</div>
<script>
    // Mengambil tanggal hari ini dalam format YYYY-MM-DD
    var today = new Date().toISOString().split('T')[0];
    document.getElementById("start_date").setAttribute('min', today);
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let destinationSelect = document.getElementById("destination_id");
        let timeInput = document.getElementById("time");

        destinationSelect.addEventListener("change", function () {
            let selectedDestination = this.value;

            // Fetch data trip berdasarkan destination_id
            fetch(`/get-trip-dates/${selectedDestination}`)
                .then(response => response.json())
                .then(data => {
                    if (data.start_date && data.end_date) {
                        // Atur batas tanggal input
                        timeInput.setAttribute("min", data.start_date);
                        timeInput.setAttribute("max", data.end_date);
                    }
                })
                .catch(error => console.error("Error fetching trip dates:", error));
        });
    });
</script>
@endsection
</body>
</html>

