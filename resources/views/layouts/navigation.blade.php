<nav x-data="{ open: false, profileDropdown: false }" class="bg-[#1b2569] text-white border-b border-[#141d52] sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            
            {{-- Left: Brand & Links --}}
            <div class="flex items-center gap-8">
                <!-- Logo & Brand (Matches STMIK Mardira) -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-white p-1 flex items-center justify-center shrink-0 shadow-xs">
                        <img src="{{ asset('images/logo.jpg') }}" alt="Logo STMIK Mardira Indonesia" class="w-full h-full object-contain rounded-full">
                    </div>
                    <div class="flex flex-col text-left">
                        <span class="text-[10px] sm:text-[11px] text-blue-200 font-medium leading-none tracking-wide">Helpdesk & LMS</span>
                        <span class="text-xs sm:text-sm font-bold text-white tracking-wide mt-1 leading-none">STMIK MARDIRA INDONESIA</span>
                    </div>
                </a>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-6 text-sm">
                    <a href="{{ route('dashboard') }}" 
                       class="font-medium transition-colors py-1 {{ request()->routeIs('dashboard*') ? 'text-white border-b-2 border-white font-semibold' : 'text-blue-100 hover:text-white' }}">
                        Home
                    </a>

                    <a href="{{ route('tickets.index') }}" 
                       class="font-medium transition-colors py-1 {{ request()->routeIs('tickets.index') ? 'text-white border-b-2 border-white font-semibold' : 'text-blue-100 hover:text-white' }}">
                        Daftar Pengaduan
                    </a>

                    @if(Auth::user()->role === 'mahasiswa')
                        <a href="{{ route('tickets.create.mahasiswa') }}" 
                           class="font-medium transition-colors py-1 {{ request()->routeIs('tickets.create*') ? 'text-white border-b-2 border-white font-semibold' : 'text-blue-100 hover:text-white' }}">
                            Buat Pengaduan
                        </a>
                    @elseif(Auth::user()->role === 'dosen')
                        <a href="{{ route('tickets.create.dosen') }}" 
                           class="font-medium transition-colors py-1 {{ request()->routeIs('tickets.create*') ? 'text-white border-b-2 border-white font-semibold' : 'text-blue-100 hover:text-white' }}">
                            Buat Pengaduan
                        </a>
                    @endif

                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('dashboard.admin') }}" 
                           class="inline-flex items-center px-3 py-1 rounded-md bg-blue-600/40 hover:bg-blue-600/60 text-blue-100 text-xs font-semibold border border-blue-400/30 transition-colors">
                            Admin Panel
                        </a>
                    @endif
                </div>
            </div>

            {{-- Right: Profile Button --}}
            <div class="hidden sm:flex sm:items-center sm:gap-3">
                <div class="relative" x-data="{ openDropdown: false }">
                    <button @click="openDropdown = !openDropdown" 
                            class="flex items-center gap-2 py-1.5 px-2.5 rounded-lg hover:bg-white/10 transition-colors focus:outline-hidden text-left">
                        <div class="w-8 h-8 rounded-full bg-[#00a8cc]/20 border border-[#00a8cc] text-[#00e5ff] flex items-center justify-center font-bold text-xs">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="hidden lg:block">
                            <div class="text-xs font-semibold text-white truncate max-w-[120px]">{{ Auth::user()->name }}</div>
                            <div class="text-[10px] text-blue-200 capitalize leading-none">{{ Auth::user()->role }}</div>
                        </div>
                        <svg class="w-3.5 h-3.5 text-blue-200 ml-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <!-- Dropdown Content -->
                    <div x-show="openDropdown" 
                         @click.outside="openDropdown = false"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 transform scale-100"
                         x-transition:leave-end="opacity-0 transform scale-95"
                         class="absolute right-0 mt-2 w-52 rounded-lg bg-white shadow-lg py-1.5 z-50 text-slate-800 border border-slate-200"
                         style="display: none;">
                        
                        <div class="px-4 py-2 border-b border-slate-100">
                            <p class="text-[11px] text-slate-400">Masuk sebagai</p>
                            <p class="text-xs font-bold text-slate-800 truncate">{{ Auth::user()->name }}</p>
                            <p class="text-[11px] text-slate-500 truncate">{{ Auth::user()->email }}</p>
                        </div>

                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50">
                            Profil Saya
                        </a>

                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('dashboard.admin') }}" class="block px-4 py-2 text-xs font-semibold text-indigo-700 hover:bg-indigo-50">
                                Buka Admin Panel
                            </a>
                        @endif

                        <div class="border-t border-slate-100 my-1"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Hamburger Button for Mobile -->
            <div class="-mr-2 flex items-center md:hidden">
                <button @click="open = !open" class="p-2 rounded-md text-blue-200 hover:text-white hover:bg-blue-900/50 focus:outline-hidden">
                    <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Dropdown Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden md:hidden bg-[#141d52] px-4 pt-2 pb-4 space-y-2 border-t border-blue-900/50">
        <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-blue-800">
            Home
        </a>
        <a href="{{ route('tickets.index') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-blue-800">
            Daftar Pengaduan
        </a>
        @if(Auth::user()->role === 'mahasiswa')
            <a href="{{ route('tickets.create.mahasiswa') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-blue-800">
                Buat Pengaduan
            </a>
        @elseif(Auth::user()->role === 'dosen')
            <a href="{{ route('tickets.create.dosen') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-blue-800">
                Buat Pengaduan
            </a>
        @endif
        @if(Auth::user()->role === 'admin')
            <a href="{{ route('dashboard.admin') }}" class="block px-3 py-2 rounded-md text-sm font-semibold text-cyan-300 hover:bg-blue-800">
                Admin Panel
            </a>
        @endif
        <div class="pt-3 border-t border-blue-800/80">
            <div class="text-xs text-blue-300 px-3">{{ Auth::user()->name }} ({{ Auth::user()->role }})</div>
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button type="submit" class="block w-full text-left px-3 py-2 rounded-md text-xs font-semibold text-rose-300 hover:bg-rose-900/50">
                    Log Out
                </button>
            </form>
        </div>
    </div>
</nav>
