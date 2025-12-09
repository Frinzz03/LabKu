<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman Laboratorium</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --bg-color: #f8fafc;
            --text-primary: #1e293b;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-primary);
        }

        /* Navbar User */
        .navbar-user {
            background: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        /* Hero Banner */
        .hero-section {
            background: linear-gradient(135deg, #4f46e5 0%, #818cf8 100%);
            border-radius: 20px;
            padding: 3rem 2rem;
            color: white;
            margin-bottom: 2rem;
            box-shadow: 0 10px 25px -5px rgba(79, 70, 229, 0.3);
        }

        /* Search Input */
        .search-input {
            border: none;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            font-size: 1rem;
        }
        .search-input:focus {
            box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.2);
        }

        /* Item Card */
        .item-card {
            border: none;
            border-radius: 16px;
            background: white;
            transition: all 0.3s ease;
            overflow: hidden;
            height: 100%;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .item-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
            background-color: #f1f5f9;
        }

        .badge-status {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 0.5em 1em;
            border-radius: 30px;
            font-weight: 600;
            font-size: 0.75rem;
            backdrop-filter: blur(4px);
        }
        .bg-available { background-color: rgba(220, 252, 231, 0.9); color: #166534; }
        .bg-unavailable { background-color: rgba(254, 226, 226, 0.9); color: #991b1b; }

        .btn-add-cart {
            width: 100%;
            padding: 0.75rem;
            border-radius: 10px;
            font-weight: 600;
            background-color: var(--primary-color);
            border: none;
            color: white;
            transition: all 0.2s;
        }
        .btn-add-cart:hover {
            background-color: var(--primary-hover);
            transform: scale(1.02);
        }
        .btn-add-cart:disabled {
            background-color: #e2e8f0;
            color: #94a3b8;
            cursor: not-allowed;
            transform: none;
        }

        /* Cart Floating Button (Mobile) or Icon */
        .cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-user">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2 fw-bold" href="#">
                <i class="bi bi-hexagon-fill text-primary fs-4"></i>
                <span style="color: var(--text-primary);">Sistem Peminjaman</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-3">
                    <li class="nav-item">
                        <a class="nav-link active fw-semibold" href="#">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-muted" href="#">Riwayat Peminjaman</a>
                    </li>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown">
                            <span class="d-none d-lg-block small fw-bold">Dani Subianto</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg p-2 rounded-3">
                            <li><a class="dropdown-item rounded-2" href="#">Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item rounded-2 text-danger" href="#">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        
        <div class="hero-section">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <h2 class="fw-bold mb-3">Mau pinjam alat apa hari ini?</h2>
                    <p class="mb-4 opacity-75">Cari dan ajukan peminjaman alat laboratorium dengan mudah dan cepat. Pastikan kembalikan tepat waktu ya!</p>
                    
                    <form action="#" method="GET">
                        <div class="position-relative" style="max-width: 500px;">
                            <input type="text" class="form-control search-input" placeholder="Cari mikroskop, gelas ukur, multimeter...">
                            <button class="btn btn-warning position-absolute top-50 end-0 translate-middle-y me-2 rounded-pill px-4 fw-bold text-white shadow-sm" style="padding: 0.6rem;">
                                Cari
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-lg-5 d-none d-lg-block text-center">
                    <i class="bi bi-box-seam" style="font-size: 8rem; color: rgba(255,255,255,0.2);"></i>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2 overflow-auto pb-3 mb-4 no-scrollbar">
            <button class="btn btn-dark rounded-pill px-4">Semua</button>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            
            @forelse($barang as $item)
            <div class="col">
                <div class="item-card position-relative h-100 d-flex flex-column">
                    <div class="badge-status bg-available shadow-sm">
                        <i class="bi bi-check-circle-fill me-1"></i> Tersedia
                    </div>

                    <div class="overflow-hidden">
                        @if($item->foto)
                            <img src="{{ asset('uploads/barang/' . $item->foto) }}" class="card-img-top" alt="{{ $item->nama_barang }}">
                        @else
                            <div class="card-img-top d-flex align-items-center justify-content-center text-muted">
                                <i class="bi bi-image fs-1"></i>
                            </div>
                        @endif
                    </div>

                    <div class="card-body d-flex flex-column p-4">
                        <small class="text-uppercase text-muted fw-bold mb-1" style="font-size: 0.7rem; letter-spacing: 1px;">{{ $item->merek }}</small>
                        <h6 class="card-title fw-bold mb-2 text-truncate" title="{{ $item->nama_barang }}">{{ $item->nama_barang }}</h6>
                        
                        <p class="card-text small text-muted mb-4 flex-grow-1" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ $item->spesifikasi }}
                        </p>

                        <div class="mt-auto">
                            <button class="btn-add-cart shadow-sm d-flex align-items-center justify-content-center gap-2" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalPinjam"
                                    onclick="siapkanPinjam('{{ $item->id_barang }}', '{{ $item->nama_barang }}')">
                                <i class="bi bi-plus-lg"></i> Pinjam Alat
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="mb-3"><i class="bi bi-search fs-1 text-muted"></i></div>
                <h5 class="text-muted">Barang tidak ditemukan</h5>
            </div>
            @endforelse

        </div>
        
        <div class="mt-5 d-flex justify-content-center">
            </div>

    </div>

    <div class="modal fade" id="modalPinjam" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Ajukan Peminjaman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form>
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">BARANG YANG DIPINJAM</label>
                            <input type="text" class="form-control bg-light" id="namaBarangPinjam" readonly>
                            <input type="hidden" id="idBarangPinjam">
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label text-muted small fw-bold">TANGGAL PINJAM</label>
                                <input type="date" class="form-control">
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label text-muted small fw-bold">TANGGAL KEMBALI</label>
                                <input type="date" class="form-control">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-muted small fw-bold">KEPERLUAN</label>
                            <textarea class="form-control" rows="3" placeholder="Contoh: Untuk praktikum Fisika Dasar"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2 rounded-3 fw-bold">Kirim Pengajuan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function siapkanPinjam(id, nama) {
            document.getElementById('idBarangPinjam').value = id;
            document.getElementById('namaBarangPinjam').value = nama;
        }
    </script>
</body>
</html>