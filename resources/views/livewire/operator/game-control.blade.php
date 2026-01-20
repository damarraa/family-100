{{-- 
    WRAPPER UTAMA 
    Kita set h-screen & overflow-hidden supaya pas di layar.
    Lalu bagian dalamnya kita kasih overflow-y-auto biar bisa di-scroll.
--}}
<div class="h-screen flex flex-col text-gray-800 bg-gray-50/90 backdrop-blur-sm">

    {{-- HEADER KHUSUS OPERATOR (Pengganti Navbar Breeze) --}}
    <header class="bg-white border-b border-gray-200 shadow-sm z-20 flex-none h-16">
        <div class="max-w-7xl mx-auto px-4 h-full flex items-center justify-between">
            
            {{-- KIRI: Brand & Role --}}
            <div class="flex items-center gap-3">
                <div class="bg-indigo-600 text-white w-8 h-8 rounded-lg flex items-center justify-center font-bold">
                    K3
                </div>
                <h1 class="text-lg font-bold tracking-tight hidden sm:block">Control Room</h1>
                
                @if(auth()->user()->role === 'admin')
                    <span class="bg-purple-100 text-purple-700 text-[10px] font-bold px-2 py-0.5 rounded border border-purple-200 uppercase tracking-wider">
                        Admin Access
                    </span>
                @endif
            </div>

            {{-- TENGAH: Live Score (Hanya muncul jika main) --}}
            @if($session)
                <div class="absolute left-1/2 transform -translate-x-1/2 bg-indigo-900 text-white px-6 py-1 rounded-full shadow-lg flex items-center gap-2 animate-pulse">
                    <span class="text-[10px] uppercase font-bold text-indigo-300">Score</span>
                    <span class="font-mono font-bold text-lg">{{ $session->total_score }}</span>
                </div>
            @endif

            {{-- KANAN: User & Logout --}}
            <div class="flex items-center gap-4">
                {{-- Nama User --}}
                <div class="text-right hidden md:block">
                    <p class="text-xs text-gray-400 font-medium">Operator</p>
                    <p class="text-sm font-bold text-gray-800 leading-none">{{ auth()->user()->name }}</p>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center gap-2 border-l pl-4 border-gray-200">
                    {{-- Shortcut ke Admin (Khusus Admin) --}}
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.questions') }}" title="Kelola Soal" class="p-2 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition">
                            ⚙️
                        </a>
                    @endif

                    {{-- TOMBOL LOGOUT (Wajib Ada) --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" title="Logout" class="group flex items-center gap-2 bg-red-50 hover:bg-red-600 text-red-600 hover:text-white px-3 py-2 rounded-lg transition-all">
                            <span>🚪</span>
                            <span class="text-xs font-bold hidden lg:block group-hover:text-white">KELUAR</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    {{-- KONTEN SCROLLABLE --}}
    <main class="flex-grow overflow-y-auto p-4 sm:p-8">
        <div class="max-w-6xl mx-auto">
            
            {{-- VIEW 1: DAFTAR SOAL (Mode Standby) --}}
            @if(!$session)
                <div class="space-y-6">
                    {{-- Hero Card --}}
                    <div class="bg-gradient-to-r from-gray-900 to-indigo-900 rounded-2xl p-8 text-white shadow-xl relative overflow-hidden">
                        <div class="relative z-10">
                            <h2 class="text-3xl font-bold mb-2">Siap Bermain? 🎮</h2>
                            <p class="text-indigo-200 max-w-xl">
                                Pilih paket soal di bawah ini untuk memulai sesi Cerdas Cermat K3 Family 100.
                                Pastikan layar proyektor sudah siap di halaman <code class="bg-white/10 px-1 rounded text-white">/play</code>.
                            </p>
                        </div>
                        {{-- Hiasan Background --}}
                        <div class="absolute right-0 top-0 h-full w-1/3 bg-white/5 skew-x-12 transform translate-x-10"></div>
                    </div>

                    {{-- List Soal --}}
                    <div class="grid gap-4 pb-10">
                        @forelse($questions as $q)
                            <div class="group bg-white p-5 rounded-xl shadow-sm border border-gray-200 hover:shadow-md hover:border-indigo-500 transition-all duration-200 flex flex-col md:flex-row md:items-center justify-between gap-4">
                                <div class="flex gap-4 items-center">
                                    <div class="bg-gray-100 text-gray-600 group-hover:bg-indigo-600 group-hover:text-white font-bold w-12 h-12 flex items-center justify-center rounded-xl transition-colors text-lg">
                                        {{ $loop->iteration }}
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-lg text-gray-800">{{ $q->question }}</h3>
                                        <div class="flex gap-3 mt-1">
                                            <span class="text-xs bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded font-medium">
                                                {{ $q->answers->count() }} Jawaban
                                            </span>
                                            @if($q->is_active)
                                                <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded font-bold flex items-center gap-1">
                                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                                                    Terakhir Dimainkan
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <button wire:click="startGame({{ $q->id }})" 
                                        wire:confirm="Mulai soal ini di layar proyektor?"
                                        class="bg-gray-900 hover:bg-indigo-600 text-white px-6 py-3 rounded-xl font-bold text-sm shadow-lg transition-all transform active:scale-95 flex items-center gap-2 whitespace-nowrap">
                                    <span>MULAI GAME</span> ▶
                                </button>
                            </div>
                        @empty
                            <div class="text-center py-12 bg-white rounded-xl border-2 border-dashed border-gray-300">
                                <p class="text-gray-400 font-medium">Belum ada data soal.</p>
                                @if(auth()->user()->role === 'admin')
                                    <a href="{{ route('admin.questions') }}" class="text-indigo-600 font-bold hover:underline mt-2 inline-block">Input Soal Sekarang</a>
                                @endif
                            </div>
                        @endforelse
                    </div>
                </div>
            @endif

            {{-- VIEW 2: PANEL GAME (Mode Live) --}}
            @if($session)
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 h-full">
                    
                    {{-- SIDEBAR KIRI: Info & Reset --}}
                    <div class="lg:col-span-4 space-y-4">
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
                            <span class="text-[10px] font-bold text-indigo-500 uppercase tracking-widest bg-indigo-50 px-2 py-1 rounded">Sedang Tayang</span>
                            <h2 class="text-xl font-bold text-gray-800 mt-3 leading-snug">
                                {{ $session->question->question }}
                            </h2>
                            
                            <div class="grid grid-cols-2 gap-3 mt-6">
                                <button wire:click="resetGame" 
                                        wire:confirm="Reset skor 0 dan tutup jawaban?"
                                        class="bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 px-4 py-3 rounded-xl font-bold text-xs transition flex flex-col items-center justify-center gap-1">
                                    <span class="text-lg">🔄</span>
                                    RESET
                                </button>
                                <button wire:click="closeGameView" 
                                        class="bg-gray-50 hover:bg-gray-100 text-gray-600 border border-gray-200 px-4 py-3 rounded-xl font-bold text-xs transition flex flex-col items-center justify-center gap-1">
                                    <span class="text-lg">🚪</span>
                                    KEMBALI
                                </button>
                            </div>
                        </div>

                        {{-- Card Skor Mobile (Hidden on desktop, visible on small) --}}
                        <div class="bg-indigo-900 text-white p-6 rounded-2xl shadow-lg lg:hidden text-center">
                            <p class="text-indigo-300 text-xs font-bold uppercase">Total Skor</p>
                            <p class="text-5xl font-mono font-bold">{{ $session->total_score }}</p>
                        </div>
                    </div>

                    {{-- AREA KANAN: Tombol Jawaban --}}
                    <div class="lg:col-span-8">
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 min-h-[400px]">
                            <div class="flex justify-between items-center mb-6 border-b pb-4">
                                <h3 class="font-bold text-gray-700 flex items-center gap-2">
                                    <span>🎹</span> Papan Tombol
                                </h3>
                                <span class="text-xs text-gray-400">Operator Mode</span>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach($session->question->answers as $answer)
                                    <button wire:click="reveal({{ $answer->id }})" 
                                            wire:loading.attr="disabled" 
                                            @disabled($answer->is_revealed)
                                            class="relative w-full text-left p-4 rounded-xl border-2 transition-all duration-150 group
                                            {{ $answer->is_revealed 
                                                ? 'bg-gray-100 border-gray-200 opacity-50 grayscale cursor-not-allowed' 
                                                : 'bg-white border-indigo-100 hover:border-indigo-500 hover:shadow-lg hover:-translate-y-1' 
                                            }}">
                                        
                                        <div class="flex justify-between items-center">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-lg flex items-center justify-center font-bold text-sm
                                                    {{ $answer->is_revealed ? 'bg-gray-300 text-gray-500' : 'bg-indigo-100 text-indigo-700' }}">
                                                    {{ $loop->iteration }}
                                                </div>
                                                <span class="font-bold text-gray-800 {{ $answer->is_revealed ? 'line-through' : '' }}">
                                                    {{ $answer->answer_text }}
                                                </span>
                                            </div>

                                            <span class="font-mono font-bold text-lg {{ $answer->is_revealed ? 'text-gray-400' : 'text-indigo-600' }}">
                                                {{ $answer->point }}
                                            </span>
                                        </div>

                                        {{-- Indikator Status --}}
                                        @if($answer->is_revealed)
                                            <div class="absolute inset-0 flex items-center justify-center">
                                                <span class="bg-green-500 text-white text-xs font-bold px-2 py-1 rounded transform -rotate-6 opacity-90">SUDAH TERBUKA</span>
                                            </div>
                                        @endif
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </main>
</div>