<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Barang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #ffffff;
        }

        .btn-blue {
            background-color: #991B1B;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-blue:hover {
            background-color: #7F1D1D;
            transform: translateY(-2px);
        }

        .input-style {
            background-color: #ffffff;
            border: 1px solid #ddd;
            color: #333;
            transition: all 0.3s ease;
        }

        .input-style:focus {
            outline: none;
            border-color: #991B1B;
            box-shadow: 0 0 0 3px rgba(153, 27, 27, 0.3);
        }

        .card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-tag {
            background-color: #7F1D1D;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        .btn-tag:hover {
            background-color: #991B1B;
        }

        .hover-item {
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }

        .hover-item:hover {
            background-color: #f3f4f6;
            border-left: 3px solid #991B1B;
        }

        .btn-edit {
            color: #F59E0B;
            transition: all 0.2s ease;
        }

        .btn-edit:hover {
            color: #D97706;
        }

        .btn-delete {
            color: #EF4444;
            transition: all 0.2s ease;
        }

        .btn-delete:hover {
            color: #DC2626;
        }

        .page-title {
            position: relative;
            display: inline-block;
        }

        .page-title:after {
            content: '';
            position: absolute;
            width: 40%;
            height: 3px;
            background-color: #991B1B;
            bottom: -6px;
            left: 0;
            border-radius: 2px;
        }
    </style>
</head>

<body class="min-h-screen flex text-gray-800">
    @include('partials.sidebar')

    <main class="flex-1 p-10">
        <h1 class="text-3xl font-semibold text-red-900 mb-8">
            <i class="fas fa-box-archive mr-2"></i>Kategori Barang
        </h1>

        <div class="grid md:grid-cols-2 gap-8">
            {{-- Form tambah kategori --}}
            <div>
                <form action="{{ route('kategori.store') }}" method="POST" class="card p-6 mb-8">
                    @csrf
                    <h2 class="text-xl font-medium text-gray-700 mb-4">Tambah Kategori Baru</h2>
                    <div class="mb-4">
                        <label for="nama" class="block text-gray-700 font-medium mb-2">Nama Kategori</label>
                        <input
                            type="text"
                            id="nama"
                            name="nama"
                            placeholder="Masukkan nama kategori"
                            required
                            class="input-style w-full px-4 py-3 rounded-lg focus:outline-none transition">
                    </div>
                    <button
                        type="submit"
                        class="btn-blue w-full py-3 rounded-lg shadow-sm transition hover:shadow-lg font-medium flex items-center justify-center">
                        <i class="fas fa-plus mr-2"></i>Tambah Kategori
                    </button>
                </form>
            </div>

            {{-- Daftar kategori --}}
            <div class="card p-6">
                <h2 class="text-xl font-medium text-gray-700 mb-4">Daftar Kategori</h2>
                <ul class="space-y-3">
                    @foreach ($kategori as $item)
                    <li class="text-gray-800 flex justify-between items-center hover-item py-3 px-4 rounded-lg">
                        <span class="font-medium">{{ $item->nama }}</span>

                        <div class="flex space-x-5">
                            <!-- Tombol Edit -->
                            <a href="{{ route('kategori.edit', $item->id) }}"
                                class="btn-edit font-medium hover:underline flex items-center">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>

                            <!-- Tombol Hapus -->
                            <form action="{{ route('kategori.destroy', $item->id) }}" method="POST" class="inline-block"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete font-medium hover:underline flex items-center">
                                    <i class="fas fa-trash-alt mr-1"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </li>
                    @endforeach
                </ul>

                <!-- Empty state -->
                @if(count($kategori) == 0)
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-folder-open text-4xl mb-3"></i>
                    <p>Belum ada kategori yang tersedia</p>
                </div>
                @endif
            </div>
        </div>
    </main>
</body>

</html>