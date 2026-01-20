<div wire:poll.visible.750ms
    class="min-h-screen bg-gradient-to-br from-slate-900 via-blue-900 to-indigo-900 flex flex-col items-center justify-center px-8 py-6 text-white">

    @if($question)
        <div class="w-full max-w-6xl text-center mb-10">
            <h1
                class="text-4xl md:text-6xl font-extrabold tracking-wide text-yellow-300 drop-shadow-[0_4px_8px_rgba(0,0,0,0.8)]">
                {{ $question->question }}
            </h1>
        </div>

        <div class="w-full max-w-5xl grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($question->answers as $index => $answer)
                <div class="relative h-28 rounded-2xl border-4 shadow-2xl overflow-hidden flex items-center
                                {{ $answer->is_revealed
                    ? 'bg-gradient-to-r from-green-600 to-emerald-600 border-green-300'
                    : 'bg-slate-800 border-slate-600'
                                }}">

                    @if($answer->is_revealed)
                        <div class="flex-grow px-6">
                            <span class="text-2xl md:text-3xl font-bold uppercase tracking-wider drop-shadow">
                                {{ $answer->answer_text }}
                            </span>
                        </div>

                        <div class="w-24 h-full bg-black/40 flex items-center justify-center border-l-2 border-white/30">
                            <span class="text-4xl font-mono font-extrabold text-yellow-300">
                                {{ $answer->point }}
                            </span>
                        </div>
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <div
                                class="w-16 h-16 rounded-full bg-slate-700 border-4 border-slate-500 flex items-center justify-center shadow-inner">
                                <span class="text-2xl font-bold text-slate-200">
                                    {{ $index + 1 }}
                                </span>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <div
            class="mt-14 px-10 py-4 rounded-full bg-black/50 border-4 border-yellow-400 shadow-2xl flex items-center gap-6">
            <span class="text-2xl uppercase tracking-widest text-yellow-300 font-bold">
                Total Skor
            </span>
            <span class="text-6xl font-mono font-extrabold text-white drop-shadow">
                {{ $currentScore }}
            </span>
        </div>

    @else
        <div class="text-center">
            <h2 class="text-5xl font-extrabold text-yellow-300 animate-pulse">
                Menunggu Operator
            </h2>
            <p class="mt-4 text-xl text-slate-300">
                Game akan segera dimulai…
            </p>
        </div>
    @endif

</div>