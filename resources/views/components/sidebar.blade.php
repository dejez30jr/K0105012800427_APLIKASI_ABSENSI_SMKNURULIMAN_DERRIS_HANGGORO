<aside class="fixed top-0 bg-gray-900 text-white left-0 z-50 w-64 h-screen backdrop-blur-lg border border-white/30 flex flex-col justify-between">
    
    <div>
        <div class="flex items-center justify-center h-20 border-b border-gray-100">
            <h1 class="text-2xl font-black text-white">ABSENSI DIGITAL</h1>
        </div>

        <nav class="p-4 space-y-2 mt-4">
            
            <a href="{{ route('dashboard') }}" class="block px-4 py-3 rounded-lg text-sm transition-all {{ request()->routeIs('dashboard') ? 'bg-white text-black font-bold shadow-lg' : 'text-white hover:bg-white/10 hover:text-white font-medium' }}">
                Home
            </a>
            
            <a href="{{ route('absensi.index') }}" class="block px-4 py-3 rounded-lg text-sm transition-all {{ request()->routeIs('absensi.*') ? 'bg-white text-black font-bold shadow-lg' : 'text-white hover:bg-white/10 hover:text-white font-medium' }}">
                Data Absensi
            </a>

            <a href="{{ route('siswa.index') }}" class="block px-4 py-3 rounded-lg text-sm transition-all {{ request()->routeIs('siswa.*') ? 'bg-white text-black font-bold shadow-lg' : 'text-white hover:bg-white/10 hover:text-white font-medium' }}">
                Data Siswa
            </a>

            @if(auth()->user()->role == 'admin')
                <a href="{{ route('pengguna.index') }}" class="block px-4 py-3 rounded-lg text-sm transition-all {{ request()->routeIs('pengguna.*') ? 'bg-white text-black font-bold shadow-lg' : 'text-white hover:bg-white/10 hover:text-white font-medium' }}">
                    Pengguna (Admin)
                </a>
            @endif

        </nav>
    </div>

    <div class="bg-white/10 m-2 rounded-lg border border-white/30">
        
        <div class="p-4 flex border-b border-white/30 items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-black text-white flex items-center justify-center font-bold text-lg">
                {{ substr(auth()->user()->nama, 0, 1) }}
            </div>
            
            <div class="overflow-hidden">
                <p class="text-sm font-bold text-white truncate">{{ auth()->user()->nama }}</p>
                <p class="text-xs text-gray-400 uppercase tracking-wide">
                    {{ auth()->user()->role }}
                </p>
            </div>
        </div>

        <div class="p-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full flex items-center justify-center gap-2 bg-red-500 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Keluar Aplikasi
                </button>
            </form>
        </div>

    </div>
</aside>