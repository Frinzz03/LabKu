<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang - Admin Dashboard</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #4f46e5;
            --sidebar-bg: #1e1b4b;
            --sidebar-text: #e0e7ff;
            --bg-color: #f3f4f6;
            --card-bg: #ffffff;
            --text-primary: #111827;
            --input-border: #e5e7eb;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-primary);
            overflow-x: hidden;
        }

        /* --- Layout Styles (Sama dengan Dashboard) --- */
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

        /* --- Form Specific Styles --- */
        .form-card {
            background: var(--card-bg);
            border: 1px solid rgba(0,0,0,0.05);
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            padding: 2rem;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.875rem;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border: 1px solid var(--input-border);
            padding: 0.75rem 1rem;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.2s;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }

        /* Custom File Upload */
        .upload-area {
            border: 2px dashed #e5e7eb;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            background-color: #f9fafb;
            position: relative;
        }

        .upload-area:hover {
            border-color: var(--primary-color);
            background-color: #eef2ff;
        }

        .upload-icon { font-size: 2.5rem; color: #9ca3af; margin-bottom: 10px; }
        
        .preview-container {
            display: none; margin-top: 1rem; text-align: center;
        }
        .preview-image {
            max-width: 100%; max-height: 250px;
            border-radius: 8px; border: 1px solid #e5e7eb;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
        }

        /* Buttons */
        .btn-primary-custom {
            background-color: var(--primary-color); border: none;
            padding: 0.75rem 1.5rem; border-radius: 8px;
            font-weight: 500; color: white; transition: all 0.2s;
        }
        .btn-primary-custom:hover { background-color: #4338ca; transform: translateY(-1px); }

        .btn-cancel {
            background: white; border: 1px solid #d1d5db; color: #374151;
            padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 500;
        }
        .btn-cancel:hover { background: #f9fafb; border-color: #9ca3af; }

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
            <li><a href="#"><i class="bi bi-file-earmark-text"></i> Laporan</a></li>
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
                <div class="d-flex align-items-center">
                    <a href="{{ route('barang.index') }}" class="btn btn-sm btn-light me-3 rounded-circle" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <h4 class="mb-0 fw-bold text-dark">Tambah Barang</h4>
                </div>
                <div class="d-flex align-items-center gap-3 ms-auto">
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">A</div>
                            <span class="fw-medium">Administrator</span>
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <div class="container-fluid p-4">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    
                    <div class="form-card">
                        <div class="mb-4">
                            <h5 class="fw-bold text-dark">Informasi Aset</h5>
                            <p class="text-muted small">Lengkapi detail barang laboratorium di bawah ini.</p>
                        </div>

                        <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row g-4 mb-4">
                                <div class="col-md-6">
                                    <label for="nama_barang" class="form-label">Nama Barang <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama_barang" name="nama_barang" placeholder="Contoh: Mikroskop Binokuler" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="merek" class="form-label">Merek / Brand <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="merek" name="merek" placeholder="Contoh: Olympus" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="spesifikasi" class="form-label">Spesifikasi Teknis <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="spesifikasi" name="spesifikasi" rows="5" placeholder="Tuliskan spesifikasi lengkap, nomor seri, kondisi fisik, dll..." required></textarea>
                                <div class="form-text text-end" id="charCount">0 karakter</div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Foto Dokumentasi</label>
                                
                                <input type="file" id="foto" name="foto" accept="image/*" class="d-none" onchange="previewImage(this)">
                                
                                <label for="foto" class="upload-area w-100 d-block" id="uploadPlaceholder">
                                    <i class="bi bi-cloud-arrow-up upload-icon"></i>
                                    <h6 class="fw-bold mb-1">Klik atau Geser Foto ke Sini</h6>
                                    <p class="text-muted small mb-0">Format: JPG, PNG (Maks. 2MB)</p>
                                </label>

                                <div id="imagePreviewContainer" class="preview-container">
                                    <img id="preview" src="#" alt="Preview Foto" class="preview-image mb-3">
                                    <div>
                                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeImage()">
                                            <i class="bi bi-trash me-1"></i> Ganti Foto
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4" style="border-color: #f3f4f6;">

                            <div class="d-flex justify-content-end gap-3">
                                <a href="{{ route('barang.index') }}" class="btn btn-cancel">Batal</a>
                                <button type="submit" class="btn btn-primary-custom">
                                    <i class="bi bi-save me-2"></i> Simpan Data
                                </button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Preview Image Logic
    function previewImage(input) {
        const previewContainer = document.getElementById('imagePreviewContainer');
        const preview = document.getElementById('preview');
        const uploadPlaceholder = document.getElementById('uploadPlaceholder');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.style.display = 'block';
                uploadPlaceholder.style.display = 'none'; // Sembunyikan area upload
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Remove/Reset Image Logic
    function removeImage() {
        const input = document.getElementById('foto');
        const previewContainer = document.getElementById('imagePreviewContainer');
        const uploadPlaceholder = document.getElementById('uploadPlaceholder');

        input.value = ""; // Reset value input
        previewContainer.style.display = 'none';
        uploadPlaceholder.style.display = 'block'; // Munculkan lagi area upload
    }

    // Character Counter
    const textarea = document.getElementById('spesifikasi');
    const charCount = document.getElementById('charCount');
    textarea.addEventListener('input', function() {
        charCount.textContent = this.value.length + ' karakter';
    });
</script>
</body>
</html>