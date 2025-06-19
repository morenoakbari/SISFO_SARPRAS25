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
                            <th class="px-6 py-4">Keterangan</th>
                            <th class="px-6 py-4">Foto</th>
                            <th class="px-6 py-4 w-48">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        @foreach($pengembalian as $key => $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $key + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $item->barang->nama ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                {{ $item->jumlah }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($item->status === 'diterima')
                                <span class="bg-green-100 text-green-800 px-3 py-1 text-xs rounded-full">Diterima</span>
                                @elseif($item->status === 'ditolak')
                                <span class="bg-red-100 text-red-800 px-3 py-1 text-xs rounded-full">Ditolak</span>
                                @else
                                <span class="bg-yellow-100 text-yellow-800 px-3 py-1 text-xs rounded-full">Menunggu</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm">
                                {{ $item->user->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                {{ $item->peminjaman->tanggal_pinjam ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                {{ $item->tanggal_kembali }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                {{ $item->keterangan ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @if ($item->foto)
                                <img src="{{ asset('storage/' . $item->foto) }}"
                                    alt="Foto Pengembalian"
                                    class="w-16 h-16 object-cover rounded border">
                                @else
                                <span class="text-gray-400">-</span>
                                @endif

                            </td>
                            <td class="px-6 py-4 text-sm">
                                @if ($item->status === 'menunggu')
                                <form action="{{ route('pengembalian.setuju', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button class="bg-green-600 text-white px-3 py-1 rounded text-xs">Setujui</button>
                                </form>
                                <form action="{{ route('pengembalian.tolak', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button class="bg-red-600 text-white px-3 py-1 rounded text-xs">Tolak</button>
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