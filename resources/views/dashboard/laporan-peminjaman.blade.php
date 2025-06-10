<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Laporan Peminjaman</title>

    <!-- TailwindCSS & Font -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #ffffff;
        }
    </style>
</head>

<body class="min-h-screen flex text-gray-800">

    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Content -->
    <main class="flex-1 p-6 md:p-10 max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Laporan Peminjaman</h1>
                <p class="text-gray-500 mt-1">Data peminjaman yang telah diterima atau ditolak</p>
            </div>
        </div>

        <!-- Export Button -->
        <a href="{{ route('laporan.peminjaman.export') }}"
           class="bg-red-900 hover:bg-red-600 text-white px-4 py-2 rounded text-sm font-semibold shadow">
            <i class="fas fa-file-excel mr-2"></i> Export Excel
        </a>

        @if(count($peminjamans) > 0)
        <!-- Table Wrapper -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden mt-6">
            <div class="p-4 border-b flex justify-between items-center">
                <h2 class="font-semibold text-gray-700">Semua Peminjaman</h2>
                <div class="bg-gray-100 rounded-full py-1 px-3 text-sm font-medium text-gray-700">
                    Total: <span class="text-indigo-600">{{ count($peminjamans) }}</span>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 text-left text-gray-500 uppercase text-xs tracking-wider">
                        <tr>
                            <th class="px-6 py-4">No</th>
                            <th class="px-6 py-4">Nama Peminjam</th>
                            <th class="px-6 py-4">Nama Barang</th>
                            <th class="px-6 py-4">Jumlah</th>
                            <th class="px-6 py-4">Tanggal Pinjam</th>
                            <th class="px-6 py-4">Tanggal Kembali</th>
                            <th class="px-6 py-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($peminjamans as $index => $peminjaman)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                {{ $peminjaman->user->name }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                {{ optional($peminjaman->barang)->nama ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                {{ $peminjaman->jumlah }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                {{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                @if($peminjaman->status == 'diterima')
                                <span class="inline-flex items-center bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-medium">
                                    <i class="fas fa-check-circle mr-1.5"></i> Diterima
                                </span>
                                @elseif($peminjaman->status == 'ditolak')
                                <span class="inline-flex items-center bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-medium">
                                    <i class="fas fa-times-circle mr-1.5"></i> Ditolak
                                </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-6 py-3 text-xs text-gray-500 border-t">
                Menampilkan {{ count($peminjamans) }} dari {{ count($peminjamans) }} peminjaman
            </div>
        </div>
        @else
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow-sm p-12 text-center mt-6">
            <div class="text-gray-400 mb-4">
                <i class="fas fa-folder-open text-5xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-1">Belum ada data peminjaman</h3>
            <p class="text-gray-500">Laporan akan muncul setelah peminjaman diproses</p>
        </div>
        @endif
    </main>
</body>

</html>
