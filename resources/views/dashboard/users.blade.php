<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pengguna</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f0f4f8; /* Warna latar belakang putih biru */
    }

    /* Styling untuk tombol dengan warna biru */
    .btn-blue {
      background-color: #3B82F6;
      color: white;
    }

    .btn-blue:hover {
      background-color: #2563EB;
    }

    /* Styling untuk input dan form */
    .input-style {
      background-color: #ffffff;
      border: 1px solid #ddd;
      color: #333;
    }

    .input-style:focus {
      outline-color: #3B82F6; /* Fokus biru */
      border-color: #3B82F6;
    }

    /* Styling untuk card dan daftar */
    .card {
      background-color: #ffffff;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    /* Styling untuk label dan tombol */
    .btn-tag {
      background-color: #2563EB;
      color: white;
      padding: 4px 8px;
      border-radius: 12px;
    }

    .btn-tag:hover {
      background-color: #1D4ED8;
    }

    /* Hover untuk item tabel */
    .hover-item:hover {
      background-color: #f3f4f6;
    }

  </style>
</head>

<body class="min-h-screen flex text-gray-800">

  @include('partials.sidebar')

  <main class="flex-1 p-10">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-bold text-blue-900">Pengguna</h1>
      @if (Auth::user()->role === 'admin')
      <button onclick="toggleForm()" class="btn-blue px-4 py-2 rounded-lg">
        + Tambah User
      </button>
      @endif
    </div>

    {{-- Display Success Message --}}
    @if (session('success'))
    <div class="bg-green-500 text-white p-4 rounded-lg mb-6">
      {{ session('success') }}
    </div>
    @endif

    {{-- Form Tambah User --}}
    <div id="userForm" class="hidden card p-6 mb-8">
      <form method="POST" action="{{ route('user.store') }}">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <input type="text" name="name" placeholder="Nama" required class="input-style p-2 rounded w-full" />
          <input type="email" name="email" placeholder="Email" required class="input-style p-2 rounded w-full" />
          <select name="role" required class="input-style p-2 rounded w-full">
            <option value="admin">Admin</option>
            <option value="user">User</option>
          </select>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
          <input type="password" name="password" placeholder="Password" required class="input-style p-2 rounded w-full" />
          <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required class="input-style p-2 rounded w-full" />
        </div>
        <button type="submit" class="btn-blue w-full mt-4 py-2 rounded-lg">
          Simpan
        </button>
      </form>
    </div>

    {{-- Daftar Pengguna --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
      {{-- Admin Section --}}
      <div>
        <h2 class="text-xl font-semibold mb-2">Admin <span class="text-sm font-normal">Total: {{ $admins->count() }} Admin</span></h2>
        <input type="text" placeholder="Cari Admin..." class="input-style w-full p-2 mb-4" />
        <div class="card p-6">
          @foreach ($admins as $admin)
          <div class="bg-gray-100 p-4 mb-2 rounded flex justify-between items-center hover-item">
            <div>
              <strong>{{ $loop->iteration }}. {{ $admin->name }}</strong>
            </div>
            <span class="btn-tag">Admin</span>
          </div>
          @endforeach
        </div>
      </div>

      {{-- User Section --}}
      <div>
        <h2 class="text-xl font-semibold mb-2">User <span class="text-sm font-normal">Total: {{ $users->where('role', 'user')->count() }} User</span></h2>
        <input type="text" placeholder="Cari User..." class="input-style w-full p-2 mb-4" />
        <div class="card p-6">
          @foreach ($users->where('role', 'user') as $user)
          <div class="bg-gray-100 p-4 mb-2 rounded flex justify-between items-center hover-item">
            <div>
              <strong>{{ $loop->iteration }}. {{ $user->name }}</strong>
            </div>
            <span class="btn-tag">User</span>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </main>

  <script>
    function toggleForm() {
      const form = document.getElementById('userForm');
      form.classList.toggle('hidden');
    }
  </script>
</body>

</html>
