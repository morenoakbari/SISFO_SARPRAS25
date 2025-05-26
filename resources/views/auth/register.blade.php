<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');
    body {
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>
<body class="bg-gradient-to-br from-white to-blue-100 flex items-center justify-center min-h-screen">

  <div class="bg-white bg-opacity-80 backdrop-blur-lg p-10 rounded-3xl shadow-2xl w-full max-w-md border border-blue-100">
    <h2 class="text-3xl font-extrabold mb-8 text-center text-blue-800 tracking-tight">Register</h2>

    @if ($errors->any())
    <div class="mb-6 text-red-600 text-sm font-semibold">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <form action="{{ route('register') }}" method="POST">
      @csrf

      <div class="mb-5">
        <label class="block text-blue-900 font-semibold mb-2">Name</label>
        <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-5 py-3 border border-blue-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-300 transition duration-300 bg-blue-50" />
      </div>

      <div class="mb-5">
        <label class="block text-blue-900 font-semibold mb-2">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-5 py-3 border border-blue-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-300 transition duration-300 bg-blue-50" />
      </div>

      <div class="mb-5">
        <label class="block text-blue-900 font-semibold mb-2">Password</label>
        <input type="password" name="password" required class="w-full px-5 py-3 border border-blue-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-300 transition duration-300 bg-blue-50" />
      </div>

      <div class="mb-7">
        <label class="block text-blue-900 font-semibold mb-2">Confirm Password</label>
        <input type="password" name="password_confirmation" required class="w-full px-5 py-3 border border-blue-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-300 transition duration-300 bg-blue-50" />
      </div>

      <button type="submit" class="w-full bg-blue-700 hover:bg-blue-800 text-white font-bold py-3 rounded-xl transition duration-300 shadow-md">Register</button>

      <p class="mt-6 text-center text-sm text-blue-700">
        Sudah punya akun? 
        <a href="{{ route('login.form') }}" class="text-blue-800 font-semibold hover:underline">Login di sini</a>
      </p>
    </form>
  </div>
</body>
</html>
