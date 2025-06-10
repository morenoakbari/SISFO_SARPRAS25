<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style> 
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');
    body {
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>
<body class="bg-gradient-to-br from-white to-red-100 flex items-center justify-center min-h-screen">

  <div class="bg-white bg-opacity-80 backdrop-blur-lg p-10 rounded-3xl shadow-2xl w-full max-w-md border border-red-100">
    <h2 class="text-3xl font-extrabold mb-8 text-center text-red-800 tracking-tight">Login</h2>

    @if (session('success'))
    <div class="mb-6 text-green-600 text-sm font-semibold">
      {{ session('success') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="mb-6 text-red-600 text-sm font-semibold">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <form action="{{ route('login') }}" method="POST">
      @csrf
      <div class="mb-5">
        <label class="block text-red-900 font-semibold mb-2">Email</label>
        <input type="email" name="email" required class="w-full px-5 py-3 border border-red-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-red-300 transition duration-300 bg-red-50" />
      </div>

      <div class="mb-7">
        <label class="block text-red-900 font-semibold mb-2">Password</label>
        <input type="password" name="password" required class="w-full px-5 py-3 border border-red-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-red-300 transition duration-300 bg-red-50" />
      </div>

      <button type="submit" class="w-full bg-red-700 hover:bg-red-800 text-white font-bold py-3 rounded-xl transition duration-300 shadow-md">Login</button>

      <p class="mt-6 text-center text-sm text-red-700">
        Belum punya akun? 
        <a href="{{ route('register.form') }}" class="text-red-800 font-semibold hover:underline">Daftar di sini</a>
      </p>
    </form>
  </div>
</body>
</html>
