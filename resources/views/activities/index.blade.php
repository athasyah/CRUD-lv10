<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    @extends ('layouts.app')

    @section('content')
        @if (session('succes'))
            <div class="alert alert-succes">{{ session('success') }}</div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="navbarr">
                        <h6>Activity</h6>
                        <a href="#" class="logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <a href="{{ route('activities.create') }}" class="btn btn-info">Tambah Data</a>
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="align-middle text-center text-sm">
                                            No</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Nama Destinasi</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Aktivitas</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Waktu</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Biaya</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($activities as $activity)
                                        <tr>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <td class="align-middle text-center text-sm">{{ $loop->iteration }}</td>
                                                </div>
                                            </div>
                                            {{-- @foreach ($destinations as $destination) --}}
                                            <td class="text-xs font-weight-bold mb-0">{{ $activity->destination->name }}
                                            </td>
                                            {{-- @endforeach --}}
                                            <td class="text-xs font-weight-bold mb-0">{{ $activity->name }}</td>
                                            <td class="text-xs font-weight-bold mb-0">{{ $activity->time }}</td>
                                            <td class="text-xs font-weight-bold mb-0">{{ $activity->cost }}</td>
                                            <td class="text-xs font-weight-bold mb-0">
                                                {{-- <a href="{{ route('activities.show', $activity) }}"
                                                    class="btn btn-info btn-sm">Detail</a> --}}
                                                <a href="{{ route('activities.edit', $activity) }}"
                                                    class="btn btn-warning">Edit</a>
                                                <form action="{{ route('activities.destroy', $activity) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger"
                                                        onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</body>

</html>
