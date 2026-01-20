<div> {{-- ROOT WRAPPER (Wajib untuk Livewire) --}}

    {{--
    LAYOUT UTAMA: H-Screen & Flex Column
    Mengadopsi style Game Control agar konsisten.
    --}}
    <div class="h-screen flex flex-col bg-gray-50/90 backdrop-blur-sm text-gray-800 font-sans">

        {{-- === HEADER CUSTOM (Mirip Operator) === --}}
        <header class="bg-white border-b border-gray-200 shadow-sm z-20 flex-none h-16">
            <div class="max-w-7xl mx-auto px-4 h-full flex items-center justify-between">

                {{-- KIRI: Brand & Title --}}
                <div class="flex items-center gap-3">
                    <div
                        class="bg-indigo-600 text-white w-8 h-8 rounded-lg flex items-center justify-center font-bold shadow-sm">
                        K3
                    </div>
                    <div class="flex flex-col">
                        <h1 class="text-lg font-bold tracking-tight leading-none text-gray-900">Admin Dashboard</h1>
                        <span class="text-[10px] text-gray-500 font-medium uppercase tracking-wide">Bank Soal
                            Management</span>
                    </div>
                </div>

                {{-- TENGAH: Status Indicator (Opsional) --}}
                <div
                    class="hidden md:flex items-center gap-2 bg-indigo-50 px-4 py-1.5 rounded-full border border-indigo-100">
                    <span class="relative flex h-2 w-2">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                    </span>
                    <span class="text-xs font-bold text-indigo-700">System Ready</span>
                </div>

                {{-- KANAN: User, Switch Mode & Logout --}}
                <div class="flex items-center gap-4">
                    {{-- Shortcut ke Operator Mode --}}
                    <a href="{{ route('operator.dashboard') }}" wire:navigate
                        class="hidden sm:flex items-center gap-2 text-xs font-bold text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 px-3 py-2 rounded-lg transition"
                        title="Beralih ke Operator Game">
                        <span>🎮</span> Mode Operator
                    </a>

                    <div class="h-8 w-px bg-gray-200 mx-1"></div>

                    {{-- User Profile --}}
                    <div class="text-right hidden md:block">
                        <p class="text-xs text-gray-400 font-medium">Administrator</p>
                        <p class="text-sm font-bold text-gray-800 leading-none">{{ auth()->user()->name }}</p>
                    </div>

                    {{-- Tombol Logout --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" title="Logout"
                            class="group flex items-center gap-2 bg-red-50 hover:bg-red-600 text-red-600 hover:text-white px-3 py-2 rounded-lg transition-all shadow-sm">
                            <span>🚪</span>
                            <span class="text-xs font-bold hidden lg:block group-hover:text-white">LOGOUT</span>
                        </button>
                    </form>
                </div>
            </div>
        </header>

        {{-- === KONTEN UTAMA (Scrollable) === --}}
        <main class="flex-grow overflow-y-auto p-4 sm:p-8">
            <div class="max-w-6xl mx-auto space-y-6">

                {{-- Flash Message --}}
                @if (session()->has('message'))
                    <div class="animate-fade-in-down flex items-center bg-green-50 border-l-4 border-green-500 px-4 py-3 rounded-r shadow-sm"
                        role="alert">
                        <svg class="h-5 w-5 text-green-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-sm font-bold text-green-800">{{ session('message') }}</p>
                    </div>
                @endif

                {{-- ACTION BAR (Judul Halaman & Tombol Tambah) --}}
                <div class="flex flex-col md:flex-row justify-between items-end gap-4 border-b border-gray-200 pb-5">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Daftar Pertanyaan</h2>
                        <p class="text-gray-500 text-sm mt-1">Total <strong
                                class="text-indigo-600">{{ $questions->count() }}</strong> soal tersimpan di database.
                        </p>
                    </div>

                    @if(!$is_form_open)
                        <button wire:click="create"
                            class="bg-gray-900 hover:bg-indigo-600 text-white font-bold py-2.5 px-6 rounded-xl shadow-lg transition-all transform active:scale-95 flex items-center gap-2">
                            <span>➕</span> Buat Soal Baru
                        </button>
                    @else
                        <button wire:click="resetForm"
                            class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-600 font-bold py-2.5 px-6 rounded-xl shadow-sm transition flex items-center gap-2">
                            <span>🔙</span> Batal & Kembali
                        </button>
                    @endif
                </div>

                {{-- FORM PANEL (Muncul saat Create/Edit) --}}
                @if($is_form_open)
                    <div
                        class="bg-white rounded-2xl shadow-xl border border-indigo-100 overflow-hidden animate-fade-in-down">
                        <div class="bg-indigo-50/50 px-8 py-4 border-b border-indigo-100 flex items-center gap-2">
                            <span class="text-xl">{{ $question_id ? '✏️' : '✨' }}</span>
                            <h3 class="font-bold text-indigo-900">
                                {{ $question_id ? 'Edit Pertanyaan' : 'Buat Pertanyaan Baru' }}
                            </h3>
                        </div>

                        <div class="p-6 md:p-8">
                            <form wire:submit.prevent="save">
                                {{-- Input Pertanyaan --}}
                                <div class="mb-8">
                                    <label class="block text-gray-700 text-sm font-bold mb-2 ml-1">Kalimat
                                        Pertanyaan</label>
                                    <textarea wire:model="question_text"
                                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-lg p-4 min-h-[100px]"
                                        placeholder="Contoh: Sebutkan jenis-jenis APD di area kilang..."></textarea>
                                    @error('question_text') <span
                                    class="text-red-500 text-xs mt-1 font-bold ml-1">{{ $message }}</span> @enderror
                                </div>

                                {{-- Input Jawaban --}}
                                <div class="mb-8">
                                    <div class="flex justify-between items-center mb-3 px-1">
                                        <label class="block text-gray-700 text-sm font-bold">Kunci Jawaban</label>
                                        <span
                                            class="text-[10px] bg-gray-100 text-gray-500 px-2 py-1 rounded font-mono">Auto-Sort
                                            by Point</span>
                                    </div>

                                    <div class="bg-gray-50 p-6 rounded-2xl border border-gray-200 space-y-3">
                                        @foreach($answers as $index => $answer)
                                            <div class="flex gap-3 items-center group">
                                                <div
                                                    class="w-8 h-8 rounded-lg bg-white border border-gray-300 flex items-center justify-center text-xs font-bold text-gray-400 shadow-sm shrink-0 group-hover:border-indigo-400 group-hover:text-indigo-500 transition-colors">
                                                    {{ $index + 1 }}
                                                </div>
                                                <div class="flex-grow">
                                                    <input type="text" wire:model="answers.{{ $index }}.text"
                                                        placeholder="Jawaban {{ $index + 1 }}"
                                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-200 text-sm py-2.5">
                                                </div>
                                                <div class="w-28 relative">
                                                    <input type="number" wire:model="answers.{{ $index }}.point" placeholder="0"
                                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-200 text-center font-mono font-bold text-indigo-600 text-sm py-2.5 pr-8">
                                                    <span
                                                        class="absolute right-3 top-2.5 text-xs text-gray-400 font-bold">Pts</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <p class="text-xs text-gray-400 mt-2 ml-1">*Biarkan kosong jika baris jawaban tidak
                                        diperlukan.</p>
                                </div>

                                <div class="flex justify-end pt-6 border-t border-gray-100">
                                    <button type="submit"
                                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg hover:shadow-indigo-500/30 transition transform hover:-translate-y-0.5 flex items-center gap-2">
                                        <span>💾</span> SIMPAN
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif

                {{-- TABEL DATA --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50/50">
                                <tr>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-16">
                                        #</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        Pertanyaan</th>
                                    <th
                                        class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider w-32">
                                        Jawaban</th>
                                    <th
                                        class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider w-40">
                                        Status</th>
                                    <th
                                        class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider w-40">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($questions as $q)
                                    <tr class="hover:bg-indigo-50/20 transition-colors group">
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-400 font-bold group-hover:text-indigo-500">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-bold text-gray-800">{{ $q->question }}</div>
                                            <div class="text-[10px] text-gray-400 mt-1 flex items-center gap-2">
                                                <span>ID: #{{ $q->id }}</span>
                                                <span>•</span>
                                                <span>{{ $q->created_at->diffForHumans() }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-gray-100 text-gray-600 border border-gray-200">
                                                {{ $q->answers_count }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if($q->is_active)
                                                <div
                                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-green-100 text-green-700 border border-green-200 shadow-sm">
                                                    <span class="relative flex h-2 w-2">
                                                        <span
                                                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                                        <span
                                                            class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                                                    </span>
                                                    LIVE
                                                </div>
                                            @else
                                                <button wire:click="toggleActive({{ $q->id }})"
                                                    class="text-gray-400 hover:text-indigo-600 font-bold text-[10px] uppercase border border-gray-200 hover:border-indigo-300 px-3 py-1 rounded-full transition bg-white hover:bg-indigo-50">
                                                    Set Aktif
                                                </button>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right whitespace-nowrap text-sm font-medium">
                                            <div
                                                class="flex justify-end gap-2 opacity-60 group-hover:opacity-100 transition-opacity">
                                                <button wire:click="edit({{ $q->id }})"
                                                    class="text-indigo-600 hover:text-white hover:bg-indigo-600 p-2 rounded-lg transition"
                                                    title="Edit Data">
                                                    ✏️
                                                </button>
                                                <button wire:click="delete({{ $q->id }})"
                                                    wire:confirm="⚠️ Hapus soal ini beserta history gamenya?"
                                                    class="text-red-500 hover:text-white hover:bg-red-500 p-2 rounded-lg transition"
                                                    title="Hapus Data">
                                                    🗑️
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-16 text-center">
                                            <div class="flex flex-col items-center justify-center opacity-50">
                                                <div class="bg-gray-100 p-4 rounded-full mb-3">
                                                    <span class="text-3xl">📭</span>
                                                </div>
                                                <p class="text-gray-600 font-bold">Belum ada soal tersedia</p>
                                                <p class="text-sm text-gray-400 mt-1">Tekan tombol "Buat Soal Baru" untuk
                                                    memulai</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Footer Kecil --}}
                <div class="text-center pt-4 pb-8">
                    <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold">Cerdas Cermat K3 System •
                        Admin Panel</p>
                </div>
            </div>
        </main>
    </div>

    {{-- STYLE ANIMASI --}}
    <style>
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-down {
            animation: fadeInDown 0.3s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }
    </style>

</div>