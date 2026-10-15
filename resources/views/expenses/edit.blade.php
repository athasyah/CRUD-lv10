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
             <h2>Edit Expense</h2>
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

            <form action="{{ route('expenses.update', $expense->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="activity_id" class="form-label">Pilih Destinasi</label>
                    <select name="activity_id" id="activity_id" style="background-color: white"
                        class="form-select form-select-lg rounded-3 shadow-sm border-0" >
                        <option value="" disabled>Pilih Aktivitas</option>
                        @foreach ($activities as $activity)
                            <option value="{{ $activity->id }}" data-destination="{{ $activity->destination->name }}"
                                {{ old('activity_id', $expense->activity_id) == $activity->id ? 'selected' : '' }}>
                                {{ $activity->destination->name }}
                            </option>
                        @endforeach
                    </select>

                </div>
                <label for="amount" class="form-label">Deskripsi</label><br>
                <div class="my-3">

                    <textarea name="description" rows="5" cols="50" placeholder=""
                        class="form-control rounded-3 shadow-sm border-0" >{{ old('description', $expense->description ?? '') }}</textarea>
                    {{-- <input type="text" name="description" id="description" class="form-control rounded-3 shadow-sm border-0" value="{{ old('description',$expense->description) }}" > --}}
                </div>
                <div class="my-3">
                    <label for="amount" class="form-label">Jumlah Pengeluaran</label>
                    <input type="number" name="amount" id="amount" class="form-control rounded-3 shadow-sm border-0"
                        value="{{ old('amount', $expense->amount) }}" >
                </div>
                <button type="submit" class="btn btn-info">Simpan</button>
            </form>
        </div>
    @endsection
</body>

</html>
