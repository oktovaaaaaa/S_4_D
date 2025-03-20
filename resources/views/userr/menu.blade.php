@include('layouts.main')

<div class="container">
    @include('layouts.navbar')

    <div class="row pt-5 my-5">
        @foreach ($menus as $menu)
        <div class="col-lg-4 mb-4 pt-5 my-5" data-menu-id="{{ $menu->id }}">
            <div class="card shadow-lg border-0" style="width: 18rem;">
                <a href="#" data-bs-toggle="modal" data-bs-target="#menuModal{{ $menu->id }}">
                    <div class="d-flex justify-content-center align-items-center p-3">
                        <img src="{{ url('storage/images/' . $menu->foto) }}" class="img-fluid w-100" alt="{{ $menu->nama }}" style="height: 200px; object-fit: cover; border-radius: 10%;">
                    </div>
                </a>
                <div class="card-body text-center">
                    <h5 class="card-title">{{ $menu->nama }}</h5>
                    <p class="card-text">{{ $menu->deskripsi }}</p>
                    <p class="card-text fw-bold text-primary">Rp {{ $menu->harga}}</p>

                    <!-- Form dimulai di sini -->
                    <form action="{{ route('userr.prosesPembayaran') }}" method="POST">
                        @csrf
                        <input type="hidden" name="menu_id" value="{{ $menu->id }}"> <!-- Input hidden untuk menu_id -->
                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <div class="input-group">
                                <button class="btn btn-outline-secondary kurangCard" type="button" data-menu-id="{{ $menu->id }}">-</button>
                                <input type="number" name="jumlah" id="jumlahCard{{ $menu->id }}" class="form-control jumlah-input jumlahCard" value="1" min="1">
                                <button class="btn btn-outline-secondary tambahCard" type="button" data-menu-id="{{ $menu->id }}">+</button>
                            </div>
                        </div>

                        <p>Total Harga: <span id="totalHarga{{ $menu->id }}">Rp {{ $menu->harga }}</span></p>
                        <button type="submit" class="btn btn-primary">Pesan</button>
                    </form>
                    <!-- Form berakhir di sini -->

                </div>
            </div>
        </div>

        <!-- Modal Detail Menu -->
        <div class="modal fade" id="menuModal{{ $menu->id }}" tabindex="-1" aria-labelledby="menuModalLabel{{ $menu->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="menuModalLabel{{ $menu->id }}">{{ $menu->nama }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" data-harga="{{ str_replace(['Rp', '.'], '', $menu->harga) }}">
                        <img src="{{ url('storage/images/' . $menu->foto) }}" class="img-fluid mb-3" alt="{{ $menu->nama }}">
                        <p>{{ $menu->deskripsi }}</p>
                        <p class="fw-bold">Harga: Rp {{ $menu->harga }}</p>

                        <form action="{{ route('userr.tambahKeranjang', $menu->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="jumlah" class="form-label">Jumlah</label>
                                <div class="input-group">
                                    <button class="btn btn-outline-secondary kurangModal" type="button" data-menu-id="{{ $menu->id }}">-</button>
                                    <input type="number" name="jumlah" id="jumlahModal{{ $menu->id }}" class="form-control jumlah-input jumlahModal" value="1" min="1">
                                    <button class="btn btn-outline-secondary tambahModal" type="button" data-menu-id="{{ $menu->id }}">+</button>
                                </div>
                            </div>
                            <p>Total Harga: <span id="totalHargaModal{{ $menu->id }}">Rp {{ $menu->harga }}</span></p>
                            <button type="submit" class="btn btn-primary">Tambah ke Keranjang</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @include('layouts.footer')
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fungsi untuk update total harga
    function updateTotalHarga(menuId) {
        // Ambil elemen card
        const card = document.querySelector(`.col-lg-4[data-menu-id="${menuId}"]`);

        //Ambil harga awal dari card
        const hargaAwal = card.querySelector('.card-text.fw-bold.text-primary').innerText;
        const hargaSatuan = parseFloat(hargaAwal.replace(/[^0-9]/g, ''));

        // Update Quantity card
        const jumlahCard = parseInt(card.querySelector(`#jumlahCard${menuId}`).value);
        const totalHargaCard = hargaSatuan * jumlahCard;

        // Update total harga di card
        card.querySelector(`#totalHarga${menuId}`).innerText = 'Rp ' + totalHargaCard.toLocaleString('id-ID');

        //Ambil harga dari modal
        const modalBody = document.querySelector(`#menuModal${menuId} .modal-body`);
        const hargaAwalModal = modalBody.dataset.harga;

        // Update Quantity Modal
        const jumlahModal = parseInt(modalBody.querySelector(`#jumlahModal${menuId}`).value);
        const totalHargaModal = hargaSatuan * jumlahModal;

        //Update total harga di modal
        modalBody.querySelector(`#totalHargaModal${menuId}`).innerText = 'Rp ' + totalHargaModal.toLocaleString('id-ID');

    }

    // Event listener untuk tombol tambah di card
    document.querySelectorAll('.tambahCard').forEach(button => {
        button.addEventListener('click', function() {
            const menuId = this.dataset.menuId;
            let jumlahInputCard = document.querySelector(`.col-lg-4[data-menu-id="${menuId}"] #jumlahCard${menuId}`);
            let jumlahInputModal = document.querySelector(`#menuModal${menuId} .modal-body #jumlahModal${menuId}`);

            jumlahInputCard.value = parseInt(jumlahInputCard.value) + 1;
            jumlahInputModal.value = parseInt(jumlahInputModal.value) + 1;

            updateTotalHarga(menuId);
        });
    });

    // Event listener untuk tombol kurang di card
    document.querySelectorAll('.kurangCard').forEach(button => {
        button.addEventListener('click', function() {
            const menuId = this.dataset.menuId;

            let jumlahInputCard = document.querySelector(`.col-lg-4[data-menu-id="${menuId}"] #jumlahCard${menuId}`);
            let jumlahInputModal = document.querySelector(`#menuModal${menuId} .modal-body #jumlahModal${menuId}`);

            let currentValue = parseInt(jumlahInputCard.value);
            if (currentValue > 1) {
                jumlahInputCard.value = currentValue - 1;
                jumlahInputModal.value = currentValue - 1;
                updateTotalHarga(menuId);
            }
        });
    });

    // Event listener untuk tombol tambah di modal
    document.querySelectorAll('.tambahModal').forEach(button => {
        button.addEventListener('click', function() {
            const menuId = this.dataset.menuId;
            let jumlahInputCard = document.querySelector(`.col-lg-4[data-menu-id="${menuId}"] #jumlahCard${menuId}`);
            let jumlahInputModal = document.querySelector(`#menuModal${menuId} .modal-body #jumlahModal${menuId}`);

            jumlahInputCard.value = parseInt(jumlahInputCard.value) + 1;
            jumlahInputModal.value = parseInt(jumlahInputModal.value) + 1;
            updateTotalHarga(menuId);
        });
    });

    // Event listener untuk tombol kurang di modal
    document.querySelectorAll('.kurangModal').forEach(button => {
        button.addEventListener('click', function() {
            const menuId = this.dataset.menuId;
             let jumlahInputCard = document.querySelector(`.col-lg-4[data-menu-id="${menuId}"] #jumlahCard${menuId}`);
            let jumlahInputModal = document.querySelector(`#menuModal${menuId} .modal-body #jumlahModal${menuId}`);
            let currentValue = parseInt(jumlahInputModal.value);
            if (currentValue > 1) {
                jumlahInputCard.value = currentValue - 1;
                jumlahInputModal.value = currentValue - 1;
                updateTotalHarga(menuId);
            }
        });
    });

    // Inisialisasi total harga saat modal ditampilkan
    const menuModals = document.querySelectorAll('.modal');
    menuModals.forEach(modal => {
        modal.addEventListener('shown.bs.modal', function() {
            const menuId = this.id.replace('menuModal', '');
            updateTotalHarga(menuId); // Panggil fungsi updateTotalHarga
        });
    });
});
</script>
