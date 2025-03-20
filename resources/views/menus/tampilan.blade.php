{{-- @extends('layouts.mainadmin')

@section('contents')
<div class="d-flex justify-content-center align-items-center vh-15">
    <img src="{{asset('menu.png')}}" class="img-fluid" style="width:200px">
</div>

<div class="d-flex pt-5">
    <div class="d-flex justify-content-between align-items-center w-100">
        <h2 class="fw-semibold fs-4">List Menu</h2>
        <a href="{{ route('menus.create') }}" class="btn btn-primary btn-sm px-3 py-1">Tambah</a>
    </div>
</div>
<br><br><br>

@if (session()->has('success'))
    <x-alert message="{{ session('success') }}" />
@endif

<div class="container mt-4">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach ($menus as $menu)
            <div class="col">
                <div class="card h-100 shadow-sm rounded-4 overflow-hidden">
                    <!-- Gambar dengan aspect ratio 1:1 -->
                    <div class="ratio ratio-1x1">
                        <img src="{{ url('storage/' . $menu->foto) }}" class="card-img-top img-fluid rounded-top-4" alt="Menu Image" style="object-fit: cover;">
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold">{{ $menu->nama }}</h5>
                        <p class="card-text flex-grow-1">{{ $menu->deskripsi }}</p>
                        <p class="text-muted fw-bold fs-5">Rp {{$menu->harga}}</p>
                        <a href="{{ route('menus.edit', $menu) }}" class="btn btn-outline-primary w-100 mt-auto rounded-3">Edit</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-5 d-flex justify-content-center">
        {{ $menus->links() }}
    </div>
</div>
@endsection --}}
{{--
@extends('layouts.mainadmin')

@section('contents')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Daftar Menu</h1>
    <a href="{{ route('menus.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Menu
    </a>
</div>

@if (session()->has('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Menu</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div class="mb-3">
                <input type="text" id="searchInput" class="form-control" placeholder="Cari menu...">
            </div>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>Gambar</th>
                        <th>Harga</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($menus as $menu)
                        <tr>
                            <td>{{ $menu->nama }}</td>
                            <td>{{ $menu->deskripsi }}</td>
                            <td>
                                <img src="{{ url('storage/' . $menu->foto) }}" alt="Menu Image" style="max-width: 100px;">
                            </td>
                            <td>Rp {{$menu->harga}}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('menus.edit', $menu) }}" class="btn btn-sm btn-warning btn-action mr-1">
                                        <i class="fas fa-edit mr-2"></i>Edit
                                    </a>
                                    <form action="{{ route('menus.destroy', $menu) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger btn-action" onclick="return confirm('Apakah Anda yakin ingin menghapus menu ini?')">
                                            <i class="fas fa-trash-alt mr-2"></i>Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3 d-flex justify-content-center">
            {{ $menus->links() }}
        </div>
    </div>
</div>

<script>
    document.getElementById('searchInput').addEventListener('input', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#dataTable tbody tr');

        rows.forEach(row => {
            let text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
</script>
@endsection --}}

@extends('layouts.mainadmin')

@section('contents')
    <div class="d-flex justify-content-center align-items-center vh-15">
        <img src="{{ asset('menu.png') }}" class="img-fluid" style="width:200px">
    </div>

    <div class="d-flex pt-5">
        <div class="d-flex justify-content-between align-items-center w-100">
            <h2 class="fw-semibold fs-4">List Menu</h2>
            <a href="{{ route('menus.create') }}" class="btn btn-primary btn-sm px-3 py-1">Tambah</a>
        </div>
    </div>

    <!-- Form Pencarian -->
    <div class="mt-4">
        <form action="{{-- {{ route('menus.index') }} --}}" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari menu..."
                value="{{-- {{ request('search') }} --}}">
            <button type="submit" class="btn btn-outline-primary">Cari</button>
        </form>
    </div>
    <br><br><br>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Pesan Jika Hasil Pencarian Kosong -->
    @if (isset($menus) && $menus->isEmpty())
        <div class="alert alert-info mt-4">
            Tidak ada menu yang ditemukan "{{ request('search') }}".
        </div>
    @endif

    <!-- Daftar Menu -->
    <div class="container mt-4">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @if (isset($menus))
                @foreach ($menus as $menu)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="card h-100 shadow-sm rounded-4 overflow-hidden">
                            <!-- Gambar dengan aspect ratio 1:1 -->
                            <div class="ratio ratio-1x1">
                                <img src="{{ url('storage/images/' . $menu->foto) }}" class="card-img-top img-fluid rounded-top-4"
                                    alt="Menu Image" style="object-fit: cover;">
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold fs-6">{{ $menu->nama }}</h5>
                                <p class="card-text flex-grow-1 fs-7">{{ $menu->deskripsi }}</p>
                                <p class="text-muted fw-bold fs-6">Rp {{ $menu->harga }}</p>
                                <a href="{{ route('menus.edit', $menu) }}"
                                    class="btn btn-outline-primary w-100 mt-auto rounded-3 fs-7">Edit</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <!-- Pagination -->
        @if (isset($menus) && $menus->hasPages())
            <div class="mt-5 d-flex justify-content-center">
                {{ $menus->links() }}
            </div>
        @endif
    </div>
@endsection
