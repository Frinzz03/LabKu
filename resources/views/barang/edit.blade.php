<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang - LabAdmin</title>
    
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

        /* --- Layout Styles --- */
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

        /* --- Form Styling --- */
        .card-custom {
            background: white; border-radius: 16px; border: none;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden;
        }
        
        .form-label { font-weight: 600; font-size: 0.85rem; color: #4b5563; margin-bottom: 0.5rem; }
        
        .form-control {
            padding: 0.6rem 1rem; border-radius: 8px; border: 1px solid #e5e7eb;
            font-size: 0.95rem; transition: all 0.2s;
        }
        .form-control:focus { border-color: var(--primary-color); box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1); }

        /* Upload Area */
        .img-preview-box {
            width: 100%; height: 250px; border-radius: 12px;
            background-color: #f9fafb; border: 2px dashed #e5e7eb;
            display: flex; align-items: center; justify-content: center;
            overflow: hidden; position: relative; cursor: pointer;
            transition: all 0.2s;
        }
        .img-preview-box:hover { border-color: var(--primary-color); background: #eef2ff; }
        .img-preview-box img { width: 100%; height: 100%; object-fit: cover; }
        
        .upload-btn-overlay {
            position: absolute; bottom: 10px; left: 50%; transform: translateX(-50%);
            background: rgba(0,0,0,0.6); color: white; padding: 5px 15px;
            border-radius: 20px; font-size: 0.8rem; pointer-events: none;
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
                    <h5 class="mb-0 fw-bold text-dark">Edit Barang</h5>
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
            <form action="{{ route('barang.update', $barang->id_barang) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <div class="col-lg-8 col-md-7">
                        <div class="card-custom p-4 h-100">
                            <h6 class="fw-bold mb-4 text-primary">Informasi Barang</h6>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Barang <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nama_barang" value="{{ $barang->nama_barang }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Merek <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="merek" value="{{ $barang->merek }}" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Spesifikasi Lengkap <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="spesifikasi" rows="8" required>{{ $barang->spesifikasi }}</textarea>
                                    <div class="form-text text-end" id="charCount">0 karakter</div>
                                </div>
                            </div>

                            <div class="mt-4 pt-3 border-top d-flex gap-2">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-save me-2"></i>Simpan Perubahan
                                </button>
                                <a href="{{ route('barang.index') }}" class="btn btn-light border px-4">Batal</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-5">
                        <div class="card-custom p-4 h-100">
                            <h6 class="fw-bold mb-4 text-primary">Foto Barang</h6>
                            
                            <input type="file" id="foto" name="foto" accept="image/*" class="d-none" onchange="previewImage(this)">
                            
                            <label for="foto" class="img-preview-box" title="Klik untuk ganti foto">
                                @if($barang->foto)
                                    <img id="preview" src="{{ asset('uploads/barang/' . $barang->foto) }}" alt="Foto Barang">
                                @else
                                    <img id="preview" src="" style="display: none;">
                                    <div id="placeholder" class="text-center">
                                        <i class="bi bi-image fs-1 text-muted"></i>
                                        <p class="text-muted small mb-0 mt-2">Belum ada foto</p>
                                    </div>
                                @endif
                                <div class="upload-btn-overlay">
                                    <i class="bi bi-camera me-1"></i> Ganti Foto
                                </div>
                            </label>

                            <div class="alert alert-light border mt-3 mb-0 p-3">
                                <div class="d-flex gap-2">
                                    <i class="bi bi-info-circle text-primary mt-1"></i>
                                    <div>
                                        <small class="fw-bold d-block">Tips:</small>
                                        <small class="text-muted">Klik gambar di atas untuk mengganti foto. Pastikan pencahayaan foto jelas.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function previewImage(input) {
        const preview = document.getElementById('preview');
        const placeholder = document.getElementById('placeholder');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                if(placeholder) placeholder.style.display = 'none';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    const textarea = document.querySelector('textarea[name="spesifikasi"]');
    const charCount = document.getElementById('charCount');
    if(textarea){
        charCount.textContent = textarea.value.length + ' karakter';
        textarea.addEventListener('input', function() {
            charCount.textContent = this.value.length + ' karakter';
        });
    }
</script>

</body>
</html>