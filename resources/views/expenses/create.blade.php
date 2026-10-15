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
             <h2>Tambah Expense</h2>
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

            <form action="{{ route('expenses.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="activity_id" class="form-label">Pilih Destinasi</label>
                    <select name="activity_id" id="activity_id"
                        class="form-select form-select-lg rounded-3 shadow-sm border-0" >
                        <option value="" {{ old('activity_id') ? '' : 'selected' }} disabled selected>Pilih Destinasi</option>
                        @foreach ($activities as $activity)
                            <option value="{{ $activity->id }}" data-destination="{{ $activity->destination->name }}" {{ old('activity_id') == $activity->id ? 'selected' : '' }}>
                                {{ $activity->destination->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="my-3">
                    <label for="amount" class="form-label">Deskripsi</label><br>
                    <textarea name="description" rows="5" cols="50" class="form-control rounded-3 shadow-sm border-0" value=""
                        placeholder="">{{ old('description') }}</textarea>
                </div>
                <div class="my-3">
                    <label for="amount" class="form-label">Jumlah Pengeluaran</label>
                    <input type="number" name="amount" id="amount" class="form-control rounded-3 shadow-sm border-0" value="{{ old('amount') }}"
                        >
                </div>
                <button type="submit" class="btn btn-info">Simpan</button>
            </form>
        </div>
    @endsection
</body>

</html>
