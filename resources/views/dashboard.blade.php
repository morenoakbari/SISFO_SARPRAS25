<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-blue-100 text-slate-800 flex">

    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Content -->
    <main class="flex-1 p-6 md:p-10">
        <!-- Welcome Section -->
        <section class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-blue-800">Selamat Datang, {{ Auth::user()->name }} 👋</h1>
            <p class="mt-2 text-slate-600 text-base md:text-lg">Silakan pilih menu di sebelah kiri untuk memulai pengelolaan data.</p>
        </section>

        <!-- Dashboard Info Cards -->
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <!-- Card for Users -->
            <div class="relative bg-white border border-blue-100 rounded-2xl shadow-md hover:shadow-xl transition p-6 flex flex-col gap-2 overflow-hidden">
                <div class="absolute right-4 top-4 opacity-10 text-blue-700 pointer-events-none select-none">
                    <!-- User Icon -->
                    <svg class="w-16 h-16" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m10-6.13A4 4 0 1112 7a4 4 0 016 3.87z" />
                    </svg>
                </div>
                <div class="text-4xl font-bold text-blue-900">{{ $users->count() }}</div>
                <div class="text-lg font-medium text-blue-600">Users</div>
            </div>

            <!-- Card for Categories -->
            <div class="relative bg-white border border-blue-100 rounded-2xl shadow-md hover:shadow-xl transition p-6 flex flex-col gap-2 overflow-hidden">
                <div class="absolute right-4 top-4 opacity-10 text-blue-700 pointer-events-none select-none">
                    <!-- Category Icon -->
                    <svg class="w-16 h-16" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                </div>
                <div class="text-4xl font-bold text-blue-900">{{ $kategoris->count() }}</div>
                <div class="text-lg font-medium text-blue-600">Kategori</div>
            </div>

            <!-- Card for Items (Barang) -->
            <div class="relative bg-white border border-blue-100 rounded-2xl shadow-md hover:shadow-xl transition p-6 flex flex-col gap-2 overflow-hidden">
                <div class="absolute right-4 top-4 opacity-10 text-blue-700 pointer-events-none select-none">
                    <!-- Box/Barang Icon -->
                    <svg class="w-16 h-16" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M3 12h18M3 17h18" />
                    </svg>
                </div>
                <div class="text-4xl font-bold text-blue-900">{{ $barangs->count() }}</div>
                <div class="text-lg font-medium text-blue-600">Barang</div>
            </div>

        </section>

        <!-- Statistik Section -->
        <section class="mb-8">
            <h2 class="text-2xl font-semibold mb-2 text-blue-700">Statistik</h2>
            <p class="text-slate-600 mb-4">Berikut adalah statistik pengguna dan barang.</p>
        </section>

        <!-- Placeholder Content -->
        <section class="bg-white border border-blue-100 rounded-xl shadow p-6">
            <h2 class="text-xl font-semibold mb-2 text-blue-700">Infooo</h2>
            <p class="text-slate-600">Gatau ini mau diisi apa, hhee</p>
        </section>
    </main>

</body>

</html>