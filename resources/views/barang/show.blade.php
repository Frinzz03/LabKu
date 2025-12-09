<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Barang - {{ $barang->nama_barang }}</title>
    
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

        /* --- Layout Styles (Sama dengan Index & Edit) --- */
        .wrapper { display: flex; width: 100%; align-items: stretch; }
        
        #sidebar {
            min-width: 260px; max-width: 260px;
            background: var(--sidebar-bg); color: var(--sidebar-text);
            min-height: 100vh; transition: all 0.3s;
        }
        #sidebar .sidebar-header { padding: 20px; border-bottom: 1px solid rgba(255,255,255,0.05); }
        #sidebar ul.components { padding: 20px 0; }
        #sidebar ul li a {
            padding: 12px 25px; font-size: 0.95rem; display: flex; align-items: center;
            color: #a5b4fc; text-decoration: none; transition: 0.2s; font-weight: 500;
        }
        #sidebar ul li a:hover { color: #fff; background: rgba(255,255,255,0.05); padding-left: 30px; }
        #sidebar ul li.active > a { color: #fff; background: var(--primary-color); border-left: 4px solid #fff; }
        #sidebar ul li a i { margin-right: 12px; font-size: 1.1rem; }

        #content { width: 100%; min-height: 100vh; display: flex; flex-direction: column; }
        .navbar-custom { background: #fff; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); padding: 1rem 2rem; }

        /* --- Detail Specific Styles --- */
        .card-detail {
            background: white; border-radius: 16px; border: none;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden; height: 100%;
        }
        
        /* Label Typography */
        .detail-label {
            font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em;
            color: #6b7280; font-weight: 600; margin-bottom: 0.25rem; display: block;
        }
        
        /* Value Typography */
        .detail-value {
            font-size: 1.1rem; color: var(--text-primary); font-weight: 500; margin-bottom: 1.5rem;
        }

        /* Image Box */
        .img-display {
            width: 100%; height: 400px; object-fit: contain; 
            background-color: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;
        }
        
        .badge-brand {
            background-color: #eef2ff; color: var(--primary-color); 
            padding: 0.5em 1em; border-radius: 8px; font-weight: 600; font-size: 0.9rem;
            border: 1px solid #e0e7ff;
        }

        .spec-box {
            background-color: #f9fafb; border: 1px solid #e5e7eb;
            padding: 1.5rem; border-radius: 12px; font-size: 0.95rem;
            white-space: pre-line; /* Agar enter di textarea terbaca */
            color: #374151; line-height: 1.7;
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
            <li><a href="#"><i class="bi bi-people"></i> Pengguna Lab</a></li>
        </ul>
    </nav>

    <div id="content">
        <nav class="navbar navbar-expand-lg navbar-custom">
            <div class="container-fluid">
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('barang.index') }}" class="btn btn-light btn-sm rounded-circle shadow-sm" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <h5 class="mb-0 fw-bold text-dark">Detail Barang</h5>
                </div>
                <div class="d-flex align-items-center gap-3 ms-auto">
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-dark text-decoration-none fw-medium">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">A</div>
                            Administrator
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <div class="container-fluid p-4">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-0 text-dark">{{ $barang->nama_barang }}</h4>
                    <p class="text-muted small mb-0">Kode Inventaris: #INV-{{ str_pad($barang->id_barang, 4, '0', STR_PAD_LEFT) }}</p>
                </div>
                <div>
                    <a href="{{ route('barang.edit', $barang->id_barang) }}" class="btn btn-warning text-white fw-bold px-4 shadow-sm">
                        <i class="bi bi-pencil-square me-2"></i> Edit Data
                    </a>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-5">
                    <div class="card-detail p-3 h-100">
                        @if($barang->foto)
                            <img src="{{ asset('uploads/barang/' . $barang->foto) }}" alt="{{ $barang->nama_barang }}" class="img-display">
                        @else
                            <div class="img-display d-flex align-items-center justify-content-center flex-column text-muted">
                                <i class="bi bi-image" style="font-size: 4rem; opacity: 0.3;"></i>
                                <p class="mt-2 small">Tidak ada foto dokumentasi</p>
                            </div>
                        @endif
                        
                        <div class="mt-3 text-center">
                            <small class="text-muted fst-italic">
                                <i class="bi bi-camera me-1"></i> Foto kondisi terakhir barang
                            </small>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="card-detail p-4 h-100">
                        
                        <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom">
                            <h6 class="fw-bold text-primary mb-0">Spesifikasi & Informasi</h6>
                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                                <i class="bi bi-check-circle-fill me-1"></i> Status: Aktif
                            </span>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <span class="detail-label">Nama Aset</span>
                                <div class="detail-value">{{ $barang->nama_barang }}</div>
                            </div>
                            <div class="col-md-6">
                                <span class="detail-label">Merek / Pabrikan</span>
                                <div class="mb-4">
                                    <span class="badge-brand">{{ $barang->merek }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <span class="detail-label">Deskripsi Spesifikasi</span>
                            <div class="spec-box">{{ $barang->spesifikasi }}</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>