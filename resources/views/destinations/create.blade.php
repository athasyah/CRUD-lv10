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
             <h2>Tambah Destination</h2>
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

            <form action="{{ route('destinations.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="trip_id" class="form-label">Pilih Trip</label>
                    <select name="trip_id" id="trip_id" class="form-select form-select-lg rounded-3 shadow-sm border-0" style="background-color: white" >
                        <option value="Pilih Trip" disabled selected>Pilih Trip</option>
                        @foreach ($trips as $trip)
                            <option value="{{ $trip->id }}">{{ $trip->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="my-3">
                    <label for="name" class="form-label">Nama Destinasi</label>
                    <input type="text" name="name" id="name" class="form-control rounded-3 shadow-sm border-0" value="{{ old('name') }}"
                        >
                </div>
                <div class="my-3">
                    <label for="country" class="form-label">Negara</label>
                    <input type="text" name="country" id="country" class="form-control rounded-3 shadow-sm border-0" value="{{ old('country') }}"
                        >
                </div>
                <button type="submit" class="btn btn-info">Simpan</button>
            </form>
        </div>
    @endsection
</body>

</html>
