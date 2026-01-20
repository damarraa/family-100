{{-- <div class="min-h-screen bg-gray-50 pb-20">
    
    <div class="bg-white border-b border-gray-200 sticky top-0 z-30 shadow-sm">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="text-2xl">🎛️</span>
                <h1 class="text-xl font-bold text-gray-800 tracking-tight">K3 Control Room</h1>
            </div>

            @if($session)
                <div class="flex items-center gap-3 animate-pulse">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Live Score</span>
                    <div class="bg-indigo-600 text-white px-4 py-1 rounded-full font-mono font-bold text-xl shadow-lg shadow-indigo-200">
                        {{ $session->total_score }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        @if(!$session)
            <div class="space-y-6">
                <div class="flex justify-between items-end">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Pilih Pertanyaan</h2>
                        <p class="text-gray-500 text-sm mt-1">Klik "Mulai" untuk menampilkan soal di layar proyektor.</p>
                    </div>
                </div>

                <div class="grid gap-4">
                    @forelse($questions as $q)
                        <div class="group bg-white p-5 rounded-xl shadow-sm border border-gray-200 hover:shadow-md hover:border-indigo-300 transition-all duration-200 flex flex-col md:flex-row md:items-center justify-between gap-4">
                            
                            <div class="flex gap-4 items-start">
                                <div class="bg-indigo-50 text-indigo-700 font-bold w-10 h-10 flex items-center justify-center rounded-lg shrink-0">
                                    {{ $loop->iteration }}
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800 group-hover:text-indigo-600 transition-colors">
                                        {{ $q->question }}
                                    </h3>
                                    <div class="flex gap-2 mt-2">
                                        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded border">
                                            {{ $q->answers->count() }} Jawaban
                                        </span>
                                        @if($q->is_active)
                                            <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded border border-green-200 font-bold">
                                                Active Last Time
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <button wire:click="startGame({{ $q->id }})" 
                                    wire:confirm="Yakin ingin memulai soal ini?"
                                    class="bg-gray-900 hover:bg-indigo-600 text-white px-6 py-2.5 rounded-lg font-bold text-sm shadow transition-all transform active:scale-95 shrink-0 flex items-center gap-2">
                                <span>TAMPILKAN</span> 🚀
                            </button>
                        </div>
                    @empty
                        <div class="text-center py-12 bg-white rounded-xl border border-dashed border-gray-300">
                            <p class="text-gray-500">Belum ada soal. Silakan input di menu Admin.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        @endif

        @if($session)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
                        <span class="text-xs font-bold text-indigo-500 uppercase tracking-widest">Pertanyaan Aktif</span>
                        <h2 class="text-2xl font-bold text-gray-800 mt-2 leading-snug">
                            {{ $session->question->question }}
                        </h2>
                        <div class="mt-6 border-t pt-6 space-y-3">
                            <button wire:click="resetGame" 
                                    wire:confirm="Reset skor menjadi 0 dan tutup semua jawaban?"
                                    class="w-full bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 px-4 py-3 rounded-lg font-bold text-sm flex items-center justify-center gap-2 transition">
                                🔄 Reset Ronde Ini
                            </button>

                            <button wire:click="closeGameView" 
                                    class="w-full bg-white hover:bg-gray-50 text-gray-600 border border-gray-300 px-4 py-3 rounded-lg font-bold text-sm flex items-center justify-center gap-2 transition">
                                🚪 Kembali ke Menu
                            </button>
                        </div>
                    </div>

                    <div class="bg-indigo-900 text-white p-6 rounded-2xl shadow-lg relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 text-indigo-800 opacity-30 text-9xl font-bold select-none">?</div>
                        <div class="relative z-10">
                            <p class="text-indigo-200 text-sm font-semibold mb-1">Total Skor</p>
                            <p class="text-5xl font-mono font-bold">{{ $session->total_score }}</p>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 h-full">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="font-bold text-gray-700">Panel Jawaban</h3>
                            <span class="text-xs text-gray-400">Klik untuk reveal di proyektor</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($session->question->answers as $answer)
                                <button wire:click="reveal({{ $answer->id }})" 
                                        wire:loading.attr="disabled" 
                                        @disabled($answer->is_revealed)
                                        class="relative group w-full text-left p-5 rounded-xl border-2 transition-all duration-200 flex items-center justify-between
                                        {{ $answer->is_revealed 
                                            ? 'bg-gray-100 border-gray-200 opacity-60 cursor-not-allowed' 
                                            : 'bg-white border-indigo-100 hover:border-indigo-500 hover:shadow-md hover:-translate-y-1' 
                                        }}">
                                    
                                    <div class="absolute left-0 top-0 bottom-0 w-1.5 rounded-l-xl {{ $answer->is_revealed ? 'bg-green-500' : 'bg-gray-300' }}"></div>

                                    <div class="pl-4">
                                        <p class="font-bold text-lg {{ $answer->is_revealed ? 'text-gray-500 decoration-line-through' : 'text-gray-800' }}">
                                            {{ $answer->answer_text }}
                                        </p>
                                    </div>

                                    <div class="flex flex-col items-end gap-1">
                                        <span class="font-mono font-bold text-lg {{ $answer->is_revealed ? 'text-gray-400' : 'text-indigo-600' }}">
                                            {{ $answer->point }}
                                        </span>
                                        
                                        @if($answer->is_revealed)
                                            <span class="text-[10px] font-bold text-green-600 uppercase bg-green-100 px-2 py-0.5 rounded-full">
                                                OPEN
                                            </span>
                                        @else
                                            <span class="text-[10px] font-bold text-gray-400 uppercase bg-gray-100 px-2 py-0.5 rounded-full group-hover:bg-indigo-100 group-hover:text-indigo-600">
                                                HIDDEN
                                            </span>
                                        @endif
                                    </div>
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div> --}}

<div class="min-h-screen bg-gray-50 pb-20">
    
    {{-- HEADER OPERATOR --}}
    <div class="bg-white border-b border-gray-200 sticky top-0 z-30 shadow-sm">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            
            {{-- KIRI: JUDUL --}}
            <div class="flex items-center gap-2">
                <span class="text-2xl">🎛️</span>
                <h1 class="text-xl font-bold text-gray-800 tracking-tight">K3 Control Room</h1>
            </div>

            {{-- KANAN: SCORE & USER ACTION --}}
            <div class="flex items-center gap-4">
                
                {{-- SCORE (Hanya muncul jika ada game aktif) --}}
                @if($session)
                    <div class="flex items-center gap-2 animate-pulse mr-2">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider hidden sm:block">Live Score</span>
                        <div class="bg-indigo-600 text-white px-3 py-1 rounded-full font-mono font-bold text-lg shadow-lg shadow-indigo-200">
                            {{ $session->total_score }}
                        </div>
                    </div>
                @endif

                {{-- USER PROFILE & LOGOUT --}}
                <div class="flex items-center gap-3 border-l pl-4 border-gray-200">
                    {{-- Nama User --}}
                    <div class="text-right hidden sm:block">
                        <p class="text-xs text-gray-400 font-medium">Operator</p>
                        <p class="text-sm font-bold text-gray-700 leading-none">{{ auth()->user()->name ?? 'User' }}</p>
                    </div>

                    {{-- Tombol Logout --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="flex items-center gap-1 text-sm font-bold text-red-500 hover:text-red-700 hover:bg-red-50 px-3 py-2 rounded-lg transition-colors"
                                title="Keluar Aplikasi">
                            <span>🚪</span>
                            <span class="hidden md:inline">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- VIEW 1: DAFTAR SOAL (Mode Standby) --}}
        @if(!$session)
            <div class="space-y-6">
                <div class="flex justify-between items-end">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Pilih Pertanyaan</h2>
                        <p class="text-gray-500 text-sm mt-1">Klik "Mulai" untuk menampilkan soal di layar proyektor.</p>
                    </div>
                </div>

                <div class="grid gap-4">
                    @forelse($questions as $q)
                        <div class="group bg-white p-5 rounded-xl shadow-sm border border-gray-200 hover:shadow-md hover:border-indigo-300 transition-all duration-200 flex flex-col md:flex-row md:items-center justify-between gap-4">
                            
                            <div class="flex gap-4 items-start">
                                <div class="bg-indigo-50 text-indigo-700 font-bold w-10 h-10 flex items-center justify-center rounded-lg shrink-0">
                                    {{ $loop->iteration }}
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800 group-hover:text-indigo-600 transition-colors">
                                        {{ $q->question }}
                                    </h3>
                                    <div class="flex gap-2 mt-2">
                                        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded border">
                                            {{ $q->answers->count() }} Jawaban
                                        </span>
                                        @if($q->is_active)
                                            <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded border border-green-200 font-bold">
                                                Active Last Time
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <button wire:click="startGame({{ $q->id }})" 
                                    wire:confirm="Yakin ingin memulai soal ini?"
                                    class="bg-gray-900 hover:bg-indigo-600 text-white px-6 py-2.5 rounded-lg font-bold text-sm shadow transition-all transform active:scale-95 shrink-0 flex items-center gap-2">
                                <span>TAMPILKAN</span> 🚀
                            </button>
                        </div>
                    @empty
                        <div class="text-center py-12 bg-white rounded-xl border border-dashed border-gray-300">
                            <p class="text-gray-500">Belum ada soal. Silakan input di menu Admin.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        @endif

        {{-- VIEW 2: PANEL GAME (Mode Live) --}}
        @if($session)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- Kolom Kiri: Info Soal & Kontrol Utama --}}
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
                        <span class="text-xs font-bold text-indigo-500 uppercase tracking-widest">Pertanyaan Aktif</span>
                        <h2 class="text-2xl font-bold text-gray-800 mt-2 leading-snug">
                            {{ $session->question->question }}
                        </h2>
                        <div class="mt-6 border-t pt-6 space-y-3">
                            <button wire:click="resetGame" 
                                    wire:confirm="Reset skor menjadi 0 dan tutup semua jawaban?"
                                    class="w-full bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 px-4 py-3 rounded-lg font-bold text-sm flex items-center justify-center gap-2 transition">
                                🔄 Reset Ronde Ini
                            </button>

                            <button wire:click="closeGameView" 
                                    class="w-full bg-white hover:bg-gray-50 text-gray-600 border border-gray-300 px-4 py-3 rounded-lg font-bold text-sm flex items-center justify-center gap-2 transition">
                                🚪 Kembali ke Menu
                            </button>
                        </div>
                    </div>

                    <div class="bg-indigo-900 text-white p-6 rounded-2xl shadow-lg relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 text-indigo-800 opacity-30 text-9xl font-bold select-none">?</div>
                        <div class="relative z-10">
                            <p class="text-indigo-200 text-sm font-semibold mb-1">Total Skor</p>
                            <p class="text-5xl font-mono font-bold">{{ $session->total_score }}</p>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Grid Jawaban (Controller) --}}
                <div class="lg:col-span-2">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 h-full">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="font-bold text-gray-700">Panel Jawaban</h3>
                            <span class="text-xs text-gray-400">Klik untuk reveal di proyektor</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($session->question->answers as $answer)
                                <button wire:click="reveal({{ $answer->id }})" 
                                        wire:loading.attr="disabled" 
                                        @disabled($answer->is_revealed)
                                        class="relative group w-full text-left p-5 rounded-xl border-2 transition-all duration-200 flex items-center justify-between
                                        {{ $answer->is_revealed 
                                            ? 'bg-gray-100 border-gray-200 opacity-60 cursor-not-allowed' 
                                            : 'bg-white border-indigo-100 hover:border-indigo-500 hover:shadow-md hover:-translate-y-1' 
                                        }}">
                                    
                                    {{-- Nomor Urut --}}
                                    <div class="absolute left-0 top-0 bottom-0 w-1.5 rounded-l-xl {{ $answer->is_revealed ? 'bg-green-500' : 'bg-gray-300' }}"></div>

                                    <div class="pl-4">
                                        <p class="font-bold text-lg {{ $answer->is_revealed ? 'text-gray-500 decoration-line-through' : 'text-gray-800' }}">
                                            {{ $answer->answer_text }}
                                        </p>
                                    </div>

                                    <div class="flex flex-col items-end gap-1">
                                        <span class="font-mono font-bold text-lg {{ $answer->is_revealed ? 'text-gray-400' : 'text-indigo-600' }}">
                                            {{ $answer->point }}
                                        </span>
                                        
                                        @if($answer->is_revealed)
                                            <span class="text-[10px] font-bold text-green-600 uppercase bg-green-100 px-2 py-0.5 rounded-full">
                                                OPEN
                                            </span>
                                        @else
                                            <span class="text-[10px] font-bold text-gray-400 uppercase bg-gray-100 px-2 py-0.5 rounded-full group-hover:bg-indigo-100 group-hover:text-indigo-600">
                                                HIDDEN
                                            </span>
                                        @endif
                                    </div>
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>