<!-- File: resources/views/dashboard/pengembalian.blade.php -->

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pengembalian</title>
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

    <main class="flex-1 p-6 md:p-10 max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Daftar Pengembalian</h1>
                <p class="text-gray-500 mt-1">Kelola semua pengembalian barang</p>
            </div>
        </div>

        @if (session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow mb-6 flex items-start">
            <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
            <div>
                <p class="font-medium">Berhasil!</p>
                <p>{{ session('success') }}</p>
            </div>
        </div>
        @endif

        @if(count($pengembalian) > 0)
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="p-4 border-b flex justify-between items-center">
                <h2 class="font-semibold text-gray-700">Semua Pengembalian</h2>
                <div class="bg-gray-100 rounded-full py-1 px-3 text-sm font-medium text-gray-700">
                    Total: <span class="text-indigo-600">{{ count($pengembalian) }}</span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 text-left text-gray-500 uppercase text-xs tracking-wider">
                        <tr>
                            <th class="px-6 py-4">No</th>
                            <th class="px-6 py-4">Nama Barang</th>
                            <th class="px-6 py-4">Jumlah</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Peminjam</th>
                            <th class="px-6 py-4">Tanggal Pinjam</th>
                            <th class="px-6 py-4">Tanggal Kembali</th>
                            <th class="px-6 py-4 w-48">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($pengembalian as $key => $peminjaman)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $key + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $peminjaman->barang->nama ?? 'Barang tidak tersedia' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                {{ $peminjaman->jumlah ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($peminjaman->status === 'dikembalikan')
                                <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-800">
                                    <i class="fas fa-check-circle mr-1.5"></i> Sudah Dikembalikan
                                </span>
                                @elseif($peminjaman->status === 'dipinjam')
                                <span class="inline-flex items-center rounded-full bg-yellow-100 px-3 py-1 text-xs font-medium text-yellow-800">
                                    <i class="fas fa-clock mr-1.5"></i> Belum Dikembalikan
                                </span>
                                @elseif($peminjaman->status === 'diterima')
                                <span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-800">
                                    <i class="fas fa-info-circle mr-1.5"></i> Diterima
                                </span>
                                @else
                                <span class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-800">
                                    <i class="fas fa-times-circle mr-1.5"></i> Ditolak
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                {{ $peminjaman->user->name ?? 'User tidak ditemukan' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                {{ $peminjaman->tanggal_pinjam }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                {{ $peminjaman->tanggal_kembali ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if ($peminjaman->status === 'dipinjam')
                                <form action="{{ route('pengembalian.updateStatus', $peminjaman->id) }}" method="POST">
                                    @csrf
                                    <button name="status" value="dikembalikan" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-md flex items-center text-xs font-medium transition-colors">
                                        <i class="fas fa-check mr-1"></i>
                                        Kembalikan
                                    </button>
                                </form>
                                @else
                                <span class="text-gray-400">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="bg-gray-50 px-6 py-3 text-xs text-gray-500 border-t">
                Menampilkan {{ count($pengembalian) }} dari {{ count($pengembalian) }} pengembalian
            </div>
        </div>
        @else
        <div class="bg-white rounded-lg shadow-sm p-12 text-center">
            <div class="text-gray-400 mb-4">
                <i class="fas fa-inbox text-5xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-1">Belum ada pengembalian</h3>
            <p class="text-gray-500">Tidak ada pengembalian barang yang tercatat</p>
        </div>
        @endif
    </main>
</body>

</html>