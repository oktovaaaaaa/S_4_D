@extends('layouts.main')
@include('layouts.navbar')
    <div class="container pt-5 my-5">
        <h1>Riwayat Pesanan</h1>

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

        @if(count($riwayatPesanan) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Daftar Menu</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($riwayatPesanan as $pesanan)
                        <tr>
                            <td>{{ $pesanan->created_at }}</td>
                            <td>
                                <ul>
                                    @foreach(json_decode($pesanan->daftar_menu, true) as $menu)
                                        <li>{{ $menu['nama'] }} ({{ $menu['jumlah'] }} x Rp {{ number_format($menu['harga_satuan'], 0, ',', '.') }})</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                            <td>{{ $pesanan->status }}</td>
                            <td>
                                <form action="{{ route('userr.hapusRiwayatPesanan', $pesanan->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Anda belum memiliki riwayat pesanan.</p>
        @endif
        <a href="{{ route('userr.menu') }}" class="btn btn-secondary">Kembali ke Menu</a>
    </div>
@include('layouts.footer')
