<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Form Peminjaman</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f4f8;
        }

        .form-container {
            max-width: 600px;
            margin: auto;
        }

        label {
            font-weight: 600;
        }

        select,
        input {
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            width: 100%;
        }

        button {
            background-color: #3b82f6;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col items-center justify-center">

    <div class="form-container bg-white p-8 rounded shadow-md">
        <h1 class="text-2xl font-bold text-blue-900 mb-6">Form Peminjaman Barang</h1>

        @if (session('error'))
        <div class="bg-red-500 text-white p-3 rounded mb-4">
            {{ session('error') }}
        </div>
        @endif

        <form action="{{ route('peminjaman.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="barang_id" class="block mb-2">Pilih Barang</label>
                <select name="barang_id" id="barang_id" required>
                    <option value="">-- Pilih Barang --</option>
                    @foreach ($barangs as $barang)
                    <option value="{{ $barang->id }}">{{ $barang->nama }} (Stok: {{ $barang->stok }})</option>
                    @endforeach
                </select>
                @error('barang_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="jumlah" class="block mb-2">Jumlah</label>
                <input type="number" name="jumlah" id="jumlah" min="1" value="1" required>
                @error('jumlah')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>


            <div class="mb-4">
                <label for="tanggal_pinjam" class="block mb-2">Tanggal Pinjam</label>
                <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" required>
                @error('tanggal_pinjam')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-between items-center mt-6">
                <a href="{{ route('peminjaman.index') }}" class="text-blue-600 hover:underline">← Kembali</a>
                <button type="submit" class="hover:bg-blue-700">Kirim Permintaan</button>
            </div>
        </form>
    </div>

</body>

</html>