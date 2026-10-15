<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Tambah Activity</title>
</head>

<body>
    @extends('layouts.app')

    @section('content')
    <div class="navbarr">
        <center>
             <h2>Tambah Activity</h2>
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

            <form action="{{ route('activities.store') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label for="destination_id" class="form-label">Pilih Destinasi</label>
                    <select name="destination_id" id="destination_id"
                        class="form-select form-select-lg rounded-3 shadow-sm border-0" 
                        >
                        <option value="" {{ old('destination_id') ? '' : 'selected' }} disabled selected>Pilih Destinasi</option>
                        @foreach ($destinations as $destination)
                            <option value="{{ $destination->id }}" {{ old('destination_id') == $destination->id ? 'selected' : '' }}>{{ $destination->name }}</option>
                        @endforeach
                    </select>
                </div>
                <label for="name" class="form-label">Aktifitas</label><br>
                <div class="my-3">
                    <input type="text" name="name" id="name" class="form-control rounded-3 shadow-sm border-0" value="{{ old('name') }}"
                        >
                </div>
                <label for="time" class="form-label">Waktu</label><br>
                <div class="my-3">
                    <input type="datetime-local" name="time" id="time" class="form-control rounded-3 shadow-sm border-0" value="{{ old('time') }}" >
                </div>
                <div class="my-3">
                    <label for="cost" class="form-label">Pengeluaran</label>
                    <input type="number" name="cost" id="cost" class="form-control rounded-3 shadow-sm border-0" value="{{ old('cost') }}"
                        >
                </div>
                <button type="submit" class="btn btn-info">Simpan</button>
            </form>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let destinationSelect = document.getElementById("destination_id");
                let timeInput = document.getElementById("time");

                destinationSelect.addEventListener("change", function() {
                    let selectedDestination = this.value;

                    // Fetch data trip berdasarkan destination_id
                    fetch(`/get-trip-dates/${selectedDestination}`)
                        .then(response => response.json())
                        .then(data => {
                            console.log("Trip Data:", data); // Debugging

                            if (data.start_date && data.end_date) {
                                let minDateTime = data.start_date + "T00:00";
                                let maxDateTime = data.end_date + "T23:59";

                                timeInput.setAttribute("min", minDateTime);
                                timeInput.setAttribute("max", maxDateTime);
                                console.log("Min:", minDateTime, "Max:", maxDateTime); // Debugging
                            }
                        })
                        .catch(error => console.error("Error fetching trip dates:", error));
                });
            });
        </script>
    @endsection
</body>

</html>
