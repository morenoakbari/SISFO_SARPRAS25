<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard with Active Navigation</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    .nav-item.active {
      background-color: #dbeafe;
      color: #2563eb;
      transform: translateX(0.25rem);
    }

    .nav-item:hover {
      background-color: #dbeafe;
      color: #2563eb;
      transform: translateX(0.25rem);
    }

    /* Dropdown specific styles */
    .submenu {
      display: none;
      margin-top: 0.5rem;
      padding-left: 1rem;
      border-radius: 0.5rem;
      background-color: #f8fafc;
      overflow: hidden;
      transition: all 0.3s ease;
    }

    .submenu.show {
      display: block;
    }
    
    .submenu a {
      padding: 0.75rem 1rem;
      display: flex;
      align-items: center;
      transition: all 0.2s ease;
      border-radius: 0.375rem;
      margin-bottom: 0.25rem;
    }
    
    .submenu a:hover {
      background-color: #dbeafe;
      color: #2563eb;
    }
    
    .submenu a.active {
      background-color: #dbeafe;
      color: #2563eb;
    }
  </style>
</head>

<body class="bg-gray-50 text-gray-800 font-inter">

  <!-- Sidebar -->
  <aside class="w-72 min-h-screen p-6 flex flex-col justify-between shadow-lg bg-gradient-to-br from-white to-gray-100 border-r border-gray-200">
    <div>
      <!-- Logo -->
      <div class="flex items-center mb-10">
        <i class="fas fa-clipboard-list text-2xl text-blue-700 mr-3"></i>
        <a href="{{ route('dashboard') }}" class="text-2xl font-bold text-blue-900 hover:underline">Dashboard</a>
      </div>

      <!-- Main Navigation -->
      <div class="text-xs text-gray-400 font-semibold uppercase tracking-wider mb-3 pl-2">Main Menu</div>
      <nav class="space-y-2">
        <a href="{{ route('user.list') }}"
          class="nav-item flex items-center py-2.5 px-4 rounded-lg text-gray-600 font-medium transition-all duration-150
                  {{ request()->routeIs('user.list') ? 'active' : '' }}">
          <i class="fas fa-users mr-3 text-lg"></i>User
        </a>
        <a href="{{ route('kategori.index') }}"
          class="nav-item flex items-center py-2.5 px-4 rounded-lg text-gray-600 font-medium transition-all duration-150
                  {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
          <i class="fas fa-tags mr-3 text-lg"></i>Kategori Barang
        </a>
        <a href="{{ route('barang.index') }}"
          class="nav-item flex items-center py-2.5 px-4 rounded-lg text-gray-600 font-medium transition-all duration-150
                  {{ request()->routeIs('barang.*') ? 'active' : '' }}">
          <i class="fas fa-box mr-3 text-lg"></i>Data Barang
        </a>
        <a href="{{ route('peminjaman.index') }}"
          class="nav-item flex items-center py-2.5 px-4 rounded-lg text-gray-600 font-medium transition-all duration-150
                  {{ request()->routeIs('peminjaman.*') ? 'active' : '' }}">
          <i class="fas fa-hand-holding mr-3 text-lg"></i>Peminjaman
        </a>
        <a href="{{ route('pengembalian.index') }}"
          class="nav-item flex items-center py-2.5 px-4 rounded-lg text-gray-600 font-medium transition-all duration-150
           {{ request()->routeIs('pengembalian.*') ? 'active' : '' }}">
          <i class="fas fa-undo-alt mr-3 text-lg"></i>Pengembalian
        </a>
        
        <!-- Dropdown for Laporan with JS toggle -->
        <div class="dropdown relative">
          <button id="laporan-toggle" 
                  class="nav-item flex items-center justify-between w-full py-2.5 px-4 rounded-lg text-gray-600 font-medium transition-all duration-150
                  {{ request()->is('laporan/*') ? 'active' : '' }}">
            <div class="flex items-center">
              <i class="fas fa-file-alt mr-3 text-lg"></i>
              <span>Laporan</span>
            </div>
            <i class="fas fa-chevron-down transition-transform duration-200" id="dropdown-icon"></i>
          </button>
          
          <div id="laporan-submenu" class="submenu w-full rounded-lg">
            <a href="" 
              class="text-gray-600 font-medium {{ request()->is('laporan/barang') ? 'active' : '' }}">
              <i class="fas fa-chart-bar mr-3"></i>
              <span>Laporan Barang</span>
            </a>
            <a href="" 
              class="text-gray-600 font-medium {{ request()->is('laporan/peminjaman') ? 'active' : '' }}">
              <i class="fas fa-file-upload mr-3"></i>
              <span>Laporan Peminjaman</span>
            </a>
            <a href="" 
              class="text-gray-600 font-medium {{ request()->is('laporan/pengembalian') ? 'active' : '' }}">
              <i class="fas fa-file-download mr-3"></i>
              <span>Laporan Pengembalian</span>
            </a>
          </div>
        </div>
      </nav>
    </div>

    <!-- Logout -->
    <form method="POST" action="{{ route('logout') }}" class="mt-10">
      @csrf
      <button type="submit" class="w-full py-3 bg-gradient-to-br from-red-500 to-red-600 text-white rounded-lg font-semibold flex items-center justify-center gap-2 shadow-md transition-all hover:translate-y-1 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-red-300">
        <i class="fas fa-sign-out-alt text-lg"></i> Logout
      </button>
    </form>
  </aside>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const laporanToggle = document.getElementById('laporan-toggle');
      const laporanSubmenu = document.getElementById('laporan-submenu');
      const dropdownIcon = document.getElementById('dropdown-icon');
      
      // Function to toggle submenu
      function toggleSubmenu() {
        laporanSubmenu.classList.toggle('show');
        dropdownIcon.classList.toggle('transform');
        dropdownIcon.classList.toggle('rotate-180');
      }
      
      // Click event for toggling submenu
      laporanToggle.addEventListener('click', function(e) {
        e.preventDefault();
        toggleSubmenu();
      });
      
      // Auto-expand if a submenu item is active
      if (laporanSubmenu.querySelector('.active')) {
        laporanSubmenu.classList.add('show');
        dropdownIcon.classList.add('transform', 'rotate-180');
      }
    });
  </script>
</body>

</html>