<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Peminjaman</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f4f8;
        }
    </style>
</head>

<body class="min-h-screen flex text-gray-800">

    @include('partials.sidebar')

    <main class="flex-1 p-6 md:p-10 max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Daftar Peminjaman</h1>
                <p class="text-gray-500 mt-1">Kelola semua permintaan peminjaman barang</p>
            </div>
            <a href="{{ route('peminjaman.form') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-5 rounded-lg shadow-sm inline-flex items-center gap-2 transition-colors">
                <i class="fas fa-plus"></i>
                <span>Pinjam Baru</span>
            </a>
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

        @if(count($peminjamans) > 0)
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="p-4 border-b flex justify-between items-center">
                <h2 class="font-semibold text-gray-700">Semua Peminjaman</h2>
                <div class="bg-gray-100 rounded-full py-1 px-3 text-sm font-medium text-gray-700">
                    Total: <span class="text-indigo-600">{{ count($peminjamans) }}</span>
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
                        @foreach($peminjamans as $key => $peminjaman)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                {{ $key + 1 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $peminjaman->barang?->nama ?? 'Barang tidak tersedia' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"> {{-- Tambahan --}}
                                {{ $peminjaman->jumlah ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($peminjaman->status === 'dipinjam' && !$peminjaman->tanggal_kembali)
                                <span class="inline-flex items-center rounded-full bg-yellow-100 px-3 py-1 text-xs font-medium text-yellow-800">
                                    <i class="fas fa-clock mr-1.5"></i> Belum Dikembalikan
                                </span>
                                @elseif($peminjaman->status === 'dikembalikan')
                                <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-800">
                                    <i class="fas fa-check-circle mr-1.5"></i> Sudah Dikembalikan
                                </span>
                                @elseif($peminjaman->status === 'diterima')
                                <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-800">
                                    <i class="fas fa-check-circle mr-1.5"></i> Diterima
                                </span>
                                @else
                                <span class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-800">
                                    <i class="fas fa-times-circle mr-1.5"></i> Ditolak
                                </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center text-sm text-gray-700">
                                    <i class="fas fa-user text-gray-400 mr-2"></i>
                                    {{ $peminjaman->user->name }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center text-sm text-gray-700">
                                    <i class="fas fa-calendar-alt text-gray-400 mr-2"></i>
                                    {{ $peminjaman->tanggal_pinjam }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center text-sm text-gray-700">
                                    <i class="fas fa-calendar-check text-gray-400 mr-2"></i>
                                    {{ $peminjaman->tanggal_kembali ?? '-' }}
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if ($peminjaman->status === 'dipinjam')
                                <form action="{{ route('peminjaman.updateStatus', $peminjaman->id) }}" method="POST" class="flex space-x-2">
                                    @csrf
                                    <button name="status" value="diterima" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-md flex items-center text-xs font-medium transition-colors">
                                        <i class="fas fa-check mr-1"></i>
                                        <span>Terima</span>
                                    </button>
                                    <button onclick="return confirm('Yakin ingin menolak peminjaman ini?')" name="status" value="ditolak" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-md flex items-center text-xs font-medium transition-colors">
                                        <i class="fas fa-times mr-1"></i>
                                        <span>Tolak</span>
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
                Menampilkan {{ count($peminjamans) }} dari {{ count($peminjamans) }} peminjaman
            </div>
        </div>
        @else
        <div class="bg-white rounded-lg shadow-sm p-12 text-center">
            <div class="text-gray-400 mb-4">
                <i class="fas fa-inbox text-5xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-1">Belum ada peminjaman</h3>
            <p class="text-gray-500">Permintaan peminjaman baru akan muncul di sini</p>
        </div>
        @endif
    </main>
</body>

</html>