<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- Flash Message --}}
        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('message') }}
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">

                {{-- HEADER & TOMBOL TAMBAH --}}
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold">Bank Soal K3</h2>
                    @if(!$is_form_open)
                        <button wire:click="create"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            + Tambah Soal Baru
                        </button>
                    @else
                        <button wire:click="resetForm"
                            class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                            Batal / Kembali
                        </button>
                    @endif
                </div>

                {{-- FORM INPUT (Muncul jika tombol tambah/edit diklik) --}}
                @if($is_form_open)
                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 mb-6">
                        <form wire:submit.prevent="save">

                            {{-- Input Pertanyaan --}}
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Pertanyaan Utama</label>
                                <textarea wire:model="question_text"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    rows="2" placeholder="Contoh: Sebutkan APD wajib di kilang..."></textarea>
                                @error('question_text') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            {{-- Input Jawaban (Looping Array) --}}
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Kunci Jawaban & Poin</label>
                                <p class="text-xs text-gray-500 mb-2">*Isi secukupnya, kosongkan jika tidak perlu.</p>

                                @foreach($answers as $index => $answer)
                                    <div class="flex gap-4 mb-2">
                                        <div class="w-10 flex items-center justify-center font-bold text-gray-400">
                                            #{{ $index + 1 }}
                                        </div>
                                        <div class="flex-grow">
                                            <input type="text" wire:model="answers.{{ $index }}.text" placeholder="Teks Jawaban"
                                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        </div>
                                        <div class="w-24">
                                            <input type="number" wire:model="answers.{{ $index }}.point" placeholder="Poin"
                                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="flex justify-end mt-4">
                                <button type="submit"
                                    class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded">
                                    💾 SIMPAN SOAL
                                </button>
                            </div>
                        </form>
                    </div>
                @endif

                {{-- TABEL DAFTAR SOAL --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-2 px-4 border-b text-left w-10">No</th>
                                <th class="py-2 px-4 border-b text-left">Pertanyaan</th>
                                <th class="py-2 px-4 border-b text-center w-24">Jml Jawab</th>
                                <th class="py-2 px-4 border-b text-center w-32">Status</th>
                                <th class="py-2 px-4 border-b text-center w-40">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($questions as $q)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-2 px-4 border-b">{{ $loop->iteration }}</td>
                                    <td class="py-2 px-4 border-b font-medium text-gray-800">{{ $q->question }}</td>
                                    <td class="py-2 px-4 border-b text-center">
                                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                            {{ $q->answers_count }}
                                        </span>
                                    </td>
                                    <td class="py-2 px-4 border-b text-center">
                                        @if($q->is_active)
                                            <button disabled
                                                class="bg-green-500 text-white text-xs font-bold px-3 py-1 rounded cursor-default">
                                                ✅ AKTIF
                                            </button>
                                        @else
                                            <button wire:click="toggleActive({{ $q->id }})"
                                                class="bg-gray-200 text-gray-600 hover:bg-gray-300 text-xs font-bold px-3 py-1 rounded">
                                                Set Aktif
                                            </button>
                                        @endif
                                    </td>
                                    <td class="py-2 px-4 border-b text-center space-x-1">
                                        <button wire:click="edit({{ $q->id }})"
                                            class="text-blue-600 hover:text-blue-900 font-bold text-sm">Edit</button>
                                        <span class="text-gray-300">|</span>
                                        <button wire:click="delete({{ $q->id }})" wire:confirm="Yakin hapus soal ini?"
                                            class="text-red-600 hover:text-red-900 font-bold text-sm">Hapus</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-gray-500">
                                        Belum ada soal. Silakan klik "Tambah Soal Baru".
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>