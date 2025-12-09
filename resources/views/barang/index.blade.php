<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Lab Inventory</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #4f46e5;
            --sidebar-bg: #1e1b4b;
            --sidebar-text: #e0e7ff;
            --bg-color: #f3f4f6;
            --text-primary: #111827;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-color);
            overflow-x: hidden;
        }

        /* --- Sidebar & Layout --- */
        .wrapper { 
            display: flex; 
            width: 100%; 
            align-items: stretch; 
        }
        #sidebar {
            min-width: 260px; max-width: 260px;
            background: var(--sidebar-bg); color: var(--sidebar-text);
            min-height: 100vh; transition: all 0.3s;
        }
        #sidebar .sidebar-header { 
            padding: 20px; 
            border-bottom: 1px solid rgba(255,255,255,0.05); 
        }
        #sidebar ul.components { 
            padding: 20px 0; 
        }
        #sidebar ul li a {
            padding: 12px 25px; 
            font-size: 0.95rem; 
            display: flex; 
            align-items: center;
            color: #a5b4fc; 
            text-decoration: none; 
            transition: 0.2s; 
            font-weight: 500;
        }
        #sidebar ul li a:hover { 
            color: #fff; 
            background: rgba(255,255,255,0.05); 
            padding-left: 30px; 
        }
        #sidebar ul li.active > a { 
            color: #fff; 
            background: var(--primary-color); 
            border-left: 4px solid #fff; 
        }
        #sidebar ul li a i { 
            margin-right: 12px; 
            font-size: 1.1rem; 
        }

        /* --- Content & Navbar --- */
        #content { 
            width: 100%; 
            min-height: 100vh; 
            display: flex; 
            flex-direction: column; 
        }
        .navbar-custom { 
            background: #fff; 
            box-shadow: 0 1px 2px 0 
            rgba(0, 0, 0, 0.05); 
            padding: 1rem 2rem; 
        }

        /* --- Cards & Stats --- */
        .card-stat {
            border: none; 
            border-radius: 12px; 
            background: #fff;
            padding: 1.5rem; 
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            transition: transform 0.2s;
        }
        .stat-icon-bg {
            width: 48px; 
            height: 48px; 
            border-radius: 10px;
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-size: 1.4rem;
        }

        /* --- Table Styling --- */
        .table-card {
            background: white; 
            border-radius: 16px;
            border: 1px solid rgba(0,0,0,0.05); 
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        .table-custom thead th {
            background: #f8fafc; 
            color: #64748b; 
            font-weight: 600;
            font-size: 0.75rem; 
            text-transform: uppercase; 
            letter-spacing: 0.05em;
            border-bottom: 1px solid #e2e8f0; 
            padding: 1rem 1.5rem;
        }
        .table-custom tbody td { 
            padding: 1rem 1.5rem; 
            border-bottom: 1px solid #f1f5f9; 
            vertical-align: middle; 
        }
        .product-image-container {
            width: 48px; 
            height: 48px; 
            border-radius: 8px;
            overflow: hidden; 
            background-color: #f1f5f9;
        }
        .product-image { 
            width: 100%; 
            height: 100%; 
            object-fit: cover; 
        }

        /* --- Action Buttons --- */
        .btn-action {
            width: 32px; 
            height: 32px; 
            display: inline-flex;
            align-items: center; 
            justify-content: center; 
            border-radius: 6px;
            border: none; 
            transition: all 0.2s;
        }
        .btn-action:hover { 
            transform: scale(1.1); 
        }
        .bg-view {
            background: #e0f2fe; 
            color: #0284c7; 
        }
        .bg-edit { 
            background: #fef3c7; 
            color: #d97706; 
        }
        .bg-delete { 
            background: #fee2e2; 
            color: #dc2626; 
        }

        .form-control::placeholder {
            font-style: italic;
            color: #adb5bd;
        }

    </style>
</head>
<body>

<div class="wrapper">
    <nav id="sidebar">
        <div class="sidebar-header d-flex align-items-center gap-2">
            <i class="bi bi-hexagon-fill text-primary" style="font-size: 1.5rem;"></i>
            <div>
                <h5 class="mb-0 fw-bold">LabAdmin</h5>
                <small style="font-size: 0.75rem; opacity: 0.7;">System Management</small>
            </div>
        </div>

        <ul class="list-unstyled components">
            <li><a href="#"><i class="bi bi-grid-1x2"></i> Dashboard</a></li>
            <li class="active"><a href="{{ route('barang.index') }}"><i class="bi bi-box-seam"></i> Data Barang</a></li>
            <li><a href="#"><i class="bi bi-arrow-left-right"></i> Peminjaman</a></li>
        </ul>

        <div class="mt-auto p-4 border-top border-secondary border-opacity-25">
            <a href="#" class="d-flex align-items-center text-decoration-none text-light gap-2">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>
    </nav>

    <div id="content">
        <nav class="navbar navbar-expand-lg navbar-custom">
            <div class="container-fluid">
                <h4 class="mb-0 fw-bold text-dark">Manajemen Inventaris</h4>
                <div class="d-flex align-items-center gap-3 ms-auto">
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">A</div>
                            <span class="fw-medium">Administrator</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li><a class="dropdown-item text-danger" href="#">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <div class="container-fluid p-4">
            
            <div class="row g-3 mb-4">
                <div class="col-12">
                    <div class="card-stat d-flex align-items-center gap-3">
                        <div class="stat-icon-bg" style="background: #e0e7ff; color: #4f46e5;">
                            <i class="bi bi-box"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-0">Total Aset Laboratorium</h6>
                            <h4 class="fw-bold mb-0">{{ $barang->count() }} Unit</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-card">
                <div class="p-4 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <h5 class="fw-bold mb-0">Daftar Inventaris</h5>
                        <small class="text-muted">Semua data barang yang terdaftar di sistem</small>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <form action="{{ route('barang.index') }}" method="GET" class="me-2">
                            <div class="input-group input-group-sm" style="width: 200px;">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                                <input type="text" name="search" class="form-control bg-light border-start-0" placeholder="Cari barang..." value="{{ request('search') }}">
                            </div>
                        </form>

                        <button type="button" class="btn btn-primary btn-sm d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalTambahBarang">
                            <i class="bi bi-plus-lg"></i> <span class="d-none d-md-inline">Tambah</span>
                        </button>

                        <button class="btn btn-outline-success btn-sm d-flex align-items-center gap-2">
                            <i class="bi bi-file-earmark-excel"></i> <span class="d-none d-md-inline">Export</span>
                        </button>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-custom mb-0">
                        <thead>
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th style="width: 20%;">Barang</th>
                                <th style="width: 15%;">Merek</th>
                                <th style="width: 35%;">Spesifikasi</th>
                                <th style="width: 10%;">Foto</th> 
                                <th class="text-end" style="width: 15%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($barang as $item)
                            <tr>
                                <td class="text-muted">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $item->nama_barang }}</div>
                                    <small class="text-muted">#INV-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ $item->merek }}</span>
                                </td>
                                <td>
                                    <small class="text-muted" style="line-height: 1.4; display: block;">
                                        {{ Str::limit($item->spesifikasi, 60) }}
                                    </small>
                                </td>
                                <td>
                                    <div class="product-image-container" style="width: 50px; height: 50px;">
                                        @if($item->foto)
                                            <img src="{{ asset('uploads/barang/' . $item->foto) }}" alt="img" class="product-image">
                                        @else
                                            <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted bg-light">
                                                <i class="bi bi-image"></i>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-1">
                                        <a href="{{ route('barang.show', $item->id_barang) }}" class="btn-action bg-view" title="Lihat"><i class="bi bi-eye"></i></a>
                                        <form id="delete-form-{{ $item->id_barang }}" action="{{ route('barang.destroy', $item->id_barang) }}" method="POST" class="d-inline">
                                            @csrf 
                                            @method('DELETE')
                                            <button type="button" class="btn-action bg-delete" title="Hapus" onclick="confirmDelete('{{ $item->id_barang }}')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <div class="mb-2"><i class="bi bi-inbox fs-1"></i></div>
                                    Belum ada data barang
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-3 border-top bg-light">
                    <small class="text-muted">Menampilkan {{ $barang->count() }} data</small>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahBarang" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            
            <div class="modal-header border-bottom-0 pb-0">
                <div>
                    <h5 class="modal-title fw-bold">Tambah Inventaris Baru</h5>
                    <p class="text-muted small mb-0">Isi detail aset laboratorium di bawah ini.</p>
                </div>
            </div>

            <div class="modal-body p-4">
                <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Nama Barang <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama_barang" placeholder="Masukan Nama Barang..." required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Merek <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="merek" placeholder="Masukan Merek Barang..." required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Spesifikasi <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="spesifikasi" rows="3" placeholder="Detail spesifikasi..." required></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Foto Barang</label>
                            <div class="d-flex align-items-center gap-3">
                                <div id="preview-box" class="bg-light rounded border d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; overflow: hidden;">
                                    <i class="bi bi-image text-muted fs-4" id="placeholder-icon"></i>
                                    <img id="modal-preview" src="#" alt="Preview" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                                </div>
                                <div class="flex-grow-1">
                                    <input type="file" class="form-control form-control-sm mb-1" name="foto" accept="image/*" onchange="previewModalImage(this)">
                                    <small class="text-muted" style="font-size: 0.75rem;">Format: JPG, PNG. Maks 2MB.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                        <button type="button" class="btn btn-light btn-sm px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-sm px-4">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div> <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // SweetAlert untuk notifikasi sukses
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000, // Alert menutup otomatis setelah 2 detik
            timerProgressBar: true
        });
    @endif

    // Fungsi Konfirmasi Hapus
    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33', // Warna merah untuk tombol hapus
            cancelButtonColor: '#3085d6', // Warna biru untuk batal
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            // Jika user klik "Ya, Hapus!"
            if (result.isConfirmed) {
                // Cari form berdasarkan ID unik tadi, lalu kirim (submit)
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
    // Preview Gambar di Modal
    function previewModalImage(input) {
        const preview = document.getElementById('modal-preview');
        const icon = document.getElementById('placeholder-icon');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                icon.style.display = 'none';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Jika ada error validasi dari Laravel
    @if (count($errors) > 0)
        var myModal = new bootstrap.Modal(document.getElementById('modalTambahBarang'));
        myModal.show();
    @endif
</script>

</body>
</html>