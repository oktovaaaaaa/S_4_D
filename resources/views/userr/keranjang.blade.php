    @extends('layouts.main')
    @include('layouts.navbar')
        <div class="container pt-5 my-5">
            <h1>Keranjang Belanja</h1>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if(count($keranjangItems) > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Menu</th>
                            <th>Jumlah</th>
                            <th>Harga Satuan</th>
                            <th>Total Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($keranjangItems as $item)
                            <tr>
                                <td>{{ $item->menu->nama }}</td>
                                <td>{{ $item->jumlah }}</td>
                                <td>Rp {{ $item->menu->harga }}</td>
                                <td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                                <td>
                                    <form action="{{ route('userr.hapusKeranjang', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus item ini dari keranjang?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <p><strong>Total Belanja: Rp {{ number_format($keranjangItems->sum('total_harga'), 0, ',', '.') }}</strong></p>

                <form action="{{ route('userr.prosesPembayaranKeranjang') }}" method="POST">                @csrf
                    <button type="submit" class="btn btn-primary">Bayar</button>
                </form>
            @else
                <p>Keranjang Anda masih kosong.</p>
            @endif
            <a href="{{ route('userr.menu') }}" class="btn btn-secondary">Kembali ke Menu</a>
        </div>
    @include('layouts.footer')
