<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Keranjang;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Penting untuk user authentication

class UserController extends Controller
{
    public function daftarMenu()
    {
        $menus = Menu::all();
        return view('userr.menu', compact('menus'));
    }

    public function tampilDetailMenu(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);
        return view('userr.detail_menu', compact('menu'));
    }

    public function tambahKeKeranjang(Request $request, $menuId)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        $menu = Menu::findOrFail($menuId);
        $jumlah = $request->input('jumlah');
        $hargaSatuan = str_replace(['Rp', '.'], '', $menu->harga);
        $hargaSatuan = (int)preg_replace('/[^0-9]/', '', $hargaSatuan);
        $totalHarga = $hargaSatuan * $jumlah;

        Keranjang::create([
            'user_id' => Auth::id(),
            'menu_id' => $menuId,
            'jumlah' => $jumlah,
            'total_harga' => $totalHarga,
        ]);

        return redirect()->route('userr.keranjang')->with('success', 'Menu berhasil ditambahkan ke keranjang!');
    }
    public function lihatKeranjang()
    {
        $keranjangItems = Keranjang::where('user_id', Auth::id())->get();
        return view('userr.keranjang', compact('keranjangItems'));
    }

    public function hapusDariKeranjang($id)
    {
        $keranjangItem = Keranjang::findOrFail($id);

        // Pastikan hanya user yang punya item yang bisa menghapus
        if ($keranjangItem->user_id != Auth::id()) {
            return redirect()->route('userr.keranjang')->with('error', 'Anda tidak memiliki izin untuk menghapus item ini.');
        }

        $keranjangItem->delete();
        return redirect()->route('userr.keranjang')->with('success', 'Item berhasil dihapus dari keranjang.');
    }
    public function prosesPembayaran(Request $request)
    {
        // Validasi request
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        // Ambil data dari request
        $menuId = $request->input('menu_id');
        $jumlah = $request->input('jumlah');

        // Ambil data menu dari database
        $menu = Menu::findOrFail($menuId);
        $hargaSatuan = str_replace(['Rp', '.'], '', $menu->harga);
        $hargaSatuan = (int)preg_replace('/[^0-9]/', '', $hargaSatuan);
        $totalHarga = $hargaSatuan * $jumlah;

        // Buat daftar menu yang dipesan
        $daftarMenu = [
            [
                'nama' => $menu->nama,
                'jumlah' => $jumlah,
                'harga_satuan' => $hargaSatuan,
            ]
        ];

        // Simpan data pesanan ke tabel 'pesanans'
        Pesanan::create([
            'user_id' => Auth::id(),
            'daftar_menu' => json_encode($daftarMenu), // Simpan daftar menu sebagai JSON
            'total_harga' => $totalHarga,
            'status' => 'pending', // Atau 'dibayar', tergantung alur Midtrans
        ]);

        return redirect()->route('userr.riwayatPesanan')->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
    }
    public function prosesPembayaranKeranjang()
    {
        // Logika untuk memproses pembayaran menggunakan Midtrans
        // (Kode Midtrans akan ditambahkan di bawah)

        // Setelah pembayaran berhasil:
        $keranjangItems = Keranjang::where('user_id', Auth::id())->get();
        $totalHarga = $keranjangItems->sum('total_harga');

        // Menyimpan data pesanan ke tabel 'pesanans'
        $daftarMenu = [];
        foreach ($keranjangItems as $item) {
            //Ambil harga satuan dari database Menu
            $menu = Menu::findOrfail($item->menu_id);
            $hargaSatuan = str_replace(['Rp', '.'], '', $menu->harga);
            $hargaSatuan = (int)preg_replace('/[^0-9]/', '', $hargaSatuan);

            $daftarMenu[] = [
                'nama' => $item->menu->nama,
                'jumlah' => $item->jumlah,
                'harga_satuan' => $hargaSatuan, // Harga satuan yang sudah dikonversi
            ];
        }

        Pesanan::create([
            'user_id' => Auth::id(),
            'daftar_menu' => json_encode($daftarMenu), // Simpan daftar menu sebagai JSON
            'total_harga' => $totalHarga,
            'status' => 'pending', // Atau 'dibayar', tergantung alur Midtrans
        ]);

        // Kosongkan keranjang setelah pesanan dibuat
        Keranjang::where('user_id', Auth::id())->delete();

        return redirect()->route('userr.riwayatPesanan')->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
    }
    public function lihatRiwayatPesanan()
    {
        $riwayatPesanan = Pesanan::where('user_id', Auth::id())->get();
        return view('userr.riwayat_pesanan', compact('riwayatPesanan'));
    }

    public function hapusRiwayatPesanan($id)
    {
        $pesanan = Pesanan::findOrFail($id);

        // Pastikan hanya user yang punya pesanan yang bisa menghapus
        if ($pesanan->user_id != Auth::id()) {
            return redirect()->route('userr.riwayatPesanan')->with('error', 'Anda tidak memiliki izin untuk menghapus pesanan ini.');
        }

        $pesanan->delete();
        return redirect()->route('userr.riwayatPesanan')->with('success', 'Pesanan berhasil dihapus.');
    }
}
