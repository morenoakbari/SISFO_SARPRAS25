<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Laporan Barang</title>
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
    @include('partials.sidebar')

    <main class="flex-1 max-w-7xl mx-auto p-6 md:p-10">
        <div class="mb-8 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Laporan Barang</h1>
                <p class="mt-1 text-gray-500">Data keseluruhan barang beserta kategori dan stok</p>
            </div>
        </div>

        <a href="{{ route('laporan.barang.export') }}"
            class="inline-flex items-center bg-red-900 hover:bg-red-600 text-white text-sm font-semibold px-4 py-2 rounded shadow">
            <i class="fas fa-file-excel mr-2"></i> Export Excel
        </a>

        @if(count($barangs) > 0)
        <div class="mt-6 bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="p-4 border-b flex items-center justify-between">
                <h2 class="font-semibold text-gray-700">Semua Barang</h2>
                <div class="bg-gray-100 text-sm font-medium text-gray-700 px-3 py-1 rounded-full">
                    Total: <span class="text-indigo-600">{{ count($barangs) }}</span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 text-left text-gray-500 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-4">No</th>
                            <th class="px-6 py-4">Nama Barang</th>
                            <th class="px-6 py-4">Stok</th>
                            <th class="px-6 py-4">Kategori</th>
                            <th class="px-6 py-4">Foto</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($barangs as $index => $barang)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm whitespace-nowrap">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $barang->nama }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap">{{ $barang->stok }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center text-xs font-medium bg-blue-100 text-blue-800 px-3 py-1 rounded-full">
                                    <i class="fas fa-tag mr-1.5"></i> {{ $barang->kategori->nama }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($barang->foto)
                                <img src="{{ asset('storage/' . $barang->foto) }}" alt="Foto"
                                    class="w-12 h-12 rounded object-cover shadow">
                                @else
                                <span class="text-sm italic text-gray-400">Tidak ada</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-3 bg-gray-50 border-t text-xs text-gray-500">
                Menampilkan {{ count($barangs) }} dari {{ count($barangs) }} barang
            </div>
        </div>
        @else
        <div class="mt-6 bg-white rounded-lg shadow-sm p-12 text-center">
            <div class="mb-4 text-gray-400">
                <i class="fas fa-box-open text-5xl"></i>
            </div>
            <h3 class="mb-1 text-lg font-medium text-gray-900">Belum ada data barang</h3>
            <p class="text-gray-500">Barang akan muncul setelah ditambahkan</p>
        </div>
        @endif
    </main>
</body>

</html>