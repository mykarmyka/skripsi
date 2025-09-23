<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Klinik - User</title>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('styles')
</head>
<body class="bg-blue-100 min-h-screen flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow p-5 space-y-4">
        <a href="/" class="d-block mb-4 text-center">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Klinik" style="width: 200px;" >
        </a>

        <nav class="space-y-2">
            <a href="{{ route('user.home') }}" 
                class="block px-3 py-2 rounded hover:bg-blue-200 {{ request()->routeIs('user.home') ? 'bg-blue-200 font-semibold text-blue-800' : '' }}">
                <i class="bi bi-house-door"></i> Home
            </a>

            <a href="{{ route('user.pendaftaran') }}"
                class="block px-3 py-2 rounded hover:bg-blue-200 {{ request()->routeIs('user.pendaftaran') ? 'bg-blue-200 font-semibold text-blue-800' : '' }}">
                <i class="bi bi-clipboard-check"></i> Layanan Umum
            </a>

            <a href="{{ route('user.pendaftaran-persalinan') }}"
                class="block px-3 py-2 rounded hover:bg-blue-200 {{ request()->routeIs('user.pendaftaran-persalinan') ? 'bg-blue-200 font-semibold text-blue-800' : '' }}">
                <i class="bi bi-clipboard-check"></i> Persalinan
            </a>

            <a href="{{ route('user.profil') }}"
                class="block px-3 py-2 rounded hover:bg-blue-200 {{ request()->routeIs('user.profil') ? 'bg-blue-200 font-semibold text-blue-800' : '' }}">
                <i class="bi bi-person"></i> Profil Saya
            </a>

            <a href="#" 
                class="block px-3 py-2 rounded hover:bg-blue-200" data-bs-toggle="modal" data-bs-target="#logoutModal">
                <i class="bi bi-box-arrow-right"></i>Logout
            </a>
            
        </nav>
    </aside>

    <!-- Content -->
    <main class="flex-1 p-10" style="width: 100%">
        @yield('content')
    </main>

    <!-- Modal Konfirmasi Logout -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-3 shadow">
        <div class="modal-header">
            <h5 class="modal-title fw-bold" id="logoutModalLabel">Konfirmasi Logout</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
            Apakah Anda yakin ingin logout?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            
            <!-- Logout form -->
            <form action="{{ route('user.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">Ya, Logout</button>
            </form>
        </div>
        </div>
    </div>
    </div>

    <script>
        const toastEl = document.querySelector('.toast');
        if (toastEl) {
            const bsToast = new bootstrap.Toast(toastEl, { delay: 2000 });
            bsToast.show();
        }
    </script>



</body>
</html>
