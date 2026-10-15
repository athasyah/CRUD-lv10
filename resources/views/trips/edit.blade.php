<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    @extends('layouts.app')
    @section('content')
    <div class="navbarr">
        <center>
             <h2>Edit Trip</h2>
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

            <form action="{{ route('trips.update', $trip->id) }}" method="POST">
                @csrf
                @method('PUT')  <!-- Menggunakan method PUT untuk update -->
            
                <!-- Form fields go here -->
                <div class="my-3">
                    <label for="name" class="form-label">Nama Trip</label>
                    <input type="text" name="name" id="name" class="form-control rounded-3 shadow-sm border-0" value="{{ old('name', $trip->name) }}" >
                </div>
            
                <div class="my-3">
                    <label for="start_date" class="form-label">Tanggal Mulai</label>
                    <input type="date" name="start_date" id="date-picker" class="form-control rounded-3 shadow-sm border-0" value="{{ old('start_date', $trip->start_date) }}" >
                </div>
            
                <div class="my-3" >
                    <label for="end_date" class="form-label">Tanggal Selesai</label>
                    <input type="date" name="end_date" id="date-picker" class="form-control rounded-3 shadow-sm border-0" value="{{ old('end_date', $trip->end_date) }}" >
                </div>
            
                <div class="my-3">
                    <label for="budget" class="form-label">Anggaran</label>
                    <input type="text" name="budget" id="budget" class="form-control rounded-3 shadow-sm border-0" value="{{ old('budget', $trip->budget) }}" >
                </div>
            
                <button type="submit" class="btn btn-info">Simpan</button>
            </form>
        </div>
        <script>
            // Mengambil tanggal hari ini dalam format YYYY-MM-DD
            var today = new Date().toISOString().split('T')[0];
            document.getElementById("start_date").setAttribute('min', today);
        </script>
    @endsection
    </div>

</body>

</html>
