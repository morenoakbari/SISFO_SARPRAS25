<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f4f8;
        }

        .btn-blue {
            background-color: #3B82F6;
            color: white;
        }

        .btn-blue:hover {
            background-color: #2563EB;
        }

        .input-style {
            background-color: #ffffff;
            border: 1px solid #ddd;
            color: #333;
        }

        .input-style:focus {
            outline-color: #3B82F6;
            border-color: #3B82F6;
        }

        .card {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-tag {
            background-color: #2563EB;
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
        }

        .btn-tag:hover {
            background-color: #1D4ED8;
        }

        .hover-item:hover {
            background-color: #f3f4f6;
        }
    </style>
</head>

<body class="min-h-screen flex text-gray-800">

    <!-- Sidebar dari file dashboard.blade.php untuk konsistensi UI -->
    @include('partials.sidebar')

    <main class="flex-1 p-10">
        <h1 class="text-3xl font-bold text-blue-900 mb-6">📦 Data Barang</h1>

        @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
            {{ session('error') }}
        </div>
        @endif


        {{-- Hanya admin yang bisa lihat dan submit form ini --}}
        @if(Auth::user()->role === 'admin')
        <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data"
            class="mb-6 bg-white p-6 rounded shadow space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" name="nama" placeholder="Nama barang" required class="input-style p-2 rounded w-full">
                <input type="number" name="stok" placeholder="Stok barang" required class="input-style p-2 rounded w-full">
                <select name="kategori_id" required class="input-style p-2 rounded w-full">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                    @endforeach
                </select>
                <input type="file" name="foto" accept="image/*" class="input-style p-2 rounded w-full">
            </div>
            <button type="submit" class="btn-blue w-full py-2 rounded-lg shadow-sm transition hover:shadow-lg">
                Tambah Barang
            </button>
        </form>
        @endif

        <div class="bg-white p-6 rounded shadow border border-blue-100">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-blue-100 text-blue-900">
                        <th class="p-2 border">#</th>
                        <th class="p-2 border">Foto</th>
                        <th class="p-2 border">Nama</th>
                        <th class="p-2 border">Stok</th>
                        <th class="p-2 border">Kategori</th>
                        @if(Auth::user()->role === 'admin')
                        <th class="p-2 border">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($barangs as $index => $barang)
                    <tr class="hover-item">
                        <td class="p-2 border">{{ $index + 1 }}</td>
                        <td class="p-2 border">
                            @if($barang->foto)
                            <img src="{{ asset('storage/' . $barang->foto) }}" class="h-12 w-12 object-cover rounded"
                                alt="Foto">
                            @else
                            <span class="text-gray-400 italic">Kosong</span>
                            @endif
                        </td>
                        <td class="p-2 border">{{ $barang->nama }}</td>
                        <td class="p-2 border">{{ $barang->stok }}</td>
                        <td class="p-2 border">{{ $barang->kategori->nama }}</td>
                        @if(Auth::user()->role === 'admin')
                        <td class="p-2 border space-x-2">
                            <a href="{{ route('barang.edit', $barang) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('barang.destroy', $barang) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline"
                                    onclick="return confirm('Yakin ingin menghapus?')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
    
</body>

</html>