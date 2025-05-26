<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif'],
                    },
                }
            }
        }
    </script>
</head>

<body class="min-h-screen flex bg-gray-50 font-poppins text-gray-800">
    @include('partials.sidebar')

    <main class="flex-1 p-8">
        <!-- Back link -->
        <a href="{{ route('barang.index') }}" class="text-blue-500 hover:text-blue-700 mb-4 inline-flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>

        <h1 class="text-2xl font-semibold text-blue-900 mb-6">✏️ Edit Barang</h1>

        <div class="bg-white rounded-lg shadow-sm p-6 max-w-md">
            <form action="{{ route('barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mb-5">
                    <label for="nama" class="block text-gray-700 font-medium mb-2">Nama Barang</label>
                    <input
                        type="text"
                        id="nama"
                        name="nama"
                        value="{{ old('nama', $barang->nama) }}"
                        required
                        class="w-full bg-white border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400 focus:outline-none"
                    >
                    @error('nama')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="stok" class="block text-gray-700 font-medium mb-2">Stok Barang</label>
                    <input
                        type="number"
                        id="stok"
                        name="stok"
                        value="{{ old('stok', $barang->stok) }}"
                        required
                        class="w-full bg-white border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400 focus:outline-none"
                    >
                    @error('stok')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="kategori_id" class="block text-gray-700 font-medium mb-2">Kategori</label>
                    <select
                        id="kategori_id"
                        name="kategori_id"
                        required
                        class="w-full bg-white border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400 focus:outline-none"
                    >
                        @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ $kategori->id == $barang->kategori_id ? 'selected' : '' }}>
                            {{ $kategori->nama }}
                        </option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="foto" class="block text-gray-700 font-medium mb-2">Foto (biarkan kosong jika tidak diubah)</label>
                    <input
                        type="file"
                        id="foto"
                        name="foto"
                        class="w-full bg-white border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400 focus:outline-none"
                    >
                    @if($barang->foto)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $barang->foto) }}" class="h-20 rounded" alt="Preview">
                    </div>
                    @endif
                    @error('foto')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex gap-3">
                    <button
                        type="submit"
                        class="flex-1 bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg font-medium transition duration-200"
                    >
                        Simpan Perubahan
                    </button>
                    
                    <a href="{{ route('barang.index') }}" 
                       class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg text-gray-700 text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>