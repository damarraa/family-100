<div wire:poll.500ms class="h-screen w-screen bg-slate-900 overflow-hidden relative font-sans select-none">
    <div class="absolute inset-0 bg-gradient-to-b from-blue-950 via-slate-900 to-black"></div>
    <div class="absolute inset-0 opacity-20"
        style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 30px 30px;">
    </div>

    @if ($isStrikeOut)
        <div
            class="absolute inset-0 z-[70] flex flex-col items-center justify-center bg-red-950/90 backdrop-blur-md animate-fade-in">
            <div class="relative w-48 h-48 md:w-64 md:h-64 mb-8 animate-pulse">
                <svg viewBox="0 0 100 100" class="w-full h-full drop-shadow-[0_0_50px_rgba(0,0,0,0.8)]">
                    <path d="M 20 20 L 80 80 M 80 20 L 20 80" stroke="#ef4444" stroke-width="15" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </div>
            <h1 class="text-5xl md:text-7xl font-black text-white uppercase tracking-widest drop-shadow-lg text-center">
                LOCKED
            </h1>
            <p
                class="text-red-200 text-xl md:text-2xl mt-4 font-bold uppercase tracking-wide bg-black/30 px-6 py-2 rounded-full">
                Ganti Giliran / Lempar Soal
            </p>
        </div>
    @endif

    @if ($isPerfect)
        <div
            class="absolute inset-0 z-[60] flex flex-col items-center justify-center bg-yellow-900/40 backdrop-blur-sm animate-fade-in pointer-events-none">
            <div class="absolute inset-0 overflow-hidden">
                <div class="confetti-container">
                    @for($c = 0; $c < 50; $c++)
                        <div class="confetti"
                            style="left: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 20) / 10 }}s; background-color: {{ ['#fbbf24', '#f59e0b', '#ffffff'][rand(0, 2)] }};">
                        </div>
                    @endfor
                </div>
            </div>

            <div
                class="relative bg-gradient-to-r from-yellow-300 via-yellow-500 to-yellow-300 p-1 rounded-3xl shadow-[0_0_100px_rgba(234,179,8,0.6)] animate-bounce-in">
                <div class="bg-black px-12 py-8 rounded-[20px] border-4 border-yellow-400/50 text-center">
                    <h1
                        class="text-5xl md:text-8xl font-black text-transparent bg-clip-text bg-gradient-to-b from-yellow-300 to-yellow-600 tracking-tighter filter drop-shadow">
                        PERFECT!
                    </h1>
                    <p class="text-yellow-100/80 text-lg md:text-xl font-bold uppercase tracking-[0.5em] mt-2">
                        Sapu Bersih
                    </p>
                </div>
            </div>
        </div>
    @endif

    @if ($gameSession && $gameSession->strikes > 0 && !$isStrikeOut)
        <div wire:key="strike-overlay-{{ $gameSession->strikes }}"
            class="absolute inset-0 z-[50] flex items-center justify-center bg-black/80 backdrop-blur-sm animate-overlay-sequence fill-mode-forwards pointer-events-none">

            <div class="flex gap-4 md:gap-12">
                @for ($i = 0; $i < $gameSession->strikes; $i++)
                    <div class="relative w-32 h-32 md:w-64 md:h-64 animate-bounce-in" style="animation-delay: {{ $i * 100 }}ms">
                        <div class="absolute inset-0 bg-red-600 rounded-full opacity-30 blur-2xl animate-pulse"></div>

                        <svg viewBox="0 0 100 100" class="w-full h-full drop-shadow-[0_0_50px_rgba(220,38,38,1)]">
                            <path d="M 20 20 L 80 80 M 80 20 L 20 80" stroke="#ef4444" stroke-width="12" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </div>
                @endfor
            </div>
        </div>
    @endif

    @if ($gameSession)
        <div class="absolute top-4 right-4 md:top-8 md:right-8 z-40 flex gap-2 md:gap-3">
            @for ($i = 1; $i <= 3; $i++)
                <div class="relative w-8 h-8 md:w-12 md:h-12 rounded-full border-2 flex items-center justify-center transition-all duration-500
                                                                    {{ $i <= $gameSession->strikes
                    ? 'border-red-500 bg-red-900/30 shadow-[0_0_15px_rgba(239,68,68,0.5)]'
                    : 'border-slate-700 bg-slate-800/50' }}">

                    @if ($i <= $gameSession->strikes)
                        <svg class="w-5 h-5 md:w-7 md:h-7 text-red-500 drop-shadow-md" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    @endif
                </div>
            @endfor
        </div>
    @endif

    <div
        class="relative z-10 h-full w-full max-w-[1920px] mx-auto grid grid-rows-[auto_1fr_auto] p-4 md:p-8 gap-4 md:gap-6">
        <div class="flex items-center justify-center max-h-[20vh]">
            @if ($question)
                <div
                    class="w-full max-w-6xl bg-blue-900/60 border border-blue-500/50 backdrop-blur-md rounded-2xl md:rounded-full px-6 md:px-10 py-4 shadow-[0_0_30px_rgba(59,130,246,0.3)] text-center transition-opacity duration-500 {{ $isStrikeOut ? 'opacity-20' : 'opacity-100' }}">
                    <h1 class="text-white font-extrabold uppercase leading-tight tracking-wide drop-shadow-lg"
                        style="font-size: clamp(1.4rem, 3.5vw, 3.2rem);">
                        {{ $question->question }}
                    </h1>
                </div>
            @else
                <div class="flex flex-col items-center animate-pulse">
                    <h2
                        class="text-5xl md:text-7xl font-black text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-yellow-600 tracking-widest">
                        MENUNGGU
                    </h2>
                    <p class="text-blue-300/80 mt-2 text-xl tracking-wider font-bold">MODE OPERATOR</p>
                </div>
            @endif
        </div>

        <div class="flex items-center justify-center w-full overflow-hidden">
            @if ($question)
                <div
                    class="w-full max-w-7xl h-full grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-x-12 md:gap-y-6 place-content-center transition-opacity duration-500 {{ $isStrikeOut ? 'opacity-10' : 'opacity-100' }}">
                    @foreach ($question->answers as $answer)
                        <div class="relative w-full aspect-[6/1] perspective-1000">
                            @if ($answer->is_revealed)
                                <div
                                    class="absolute inset-0 bg-gradient-to-b from-yellow-300 to-yellow-500 border-[3px] border-white rounded-xl shadow-[0_10px_30px_rgba(234,179,8,0.4)] flex items-center justify-between px-6 md:px-8 animate-flip-in overflow-hidden">
                                    <div class="flex-grow flex items-center pr-4">
                                        <span class="font-black text-slate-900 uppercase leading-none tracking-tight"
                                            style="font-size: clamp(1.2rem, 2.4vw, 2.4rem);">
                                            {{ $answer->answer_text }}
                                        </span>
                                    </div>
                                    <div class="flex-none flex items-center">
                                        <div class="bg-black text-yellow-400 font-mono font-bold px-4 py-1 rounded-lg border-2 border-yellow-600 shadow-inner min-w-[70px]"
                                            style="font-size: clamp(1.5rem, 2.8vw, 3rem);">
                                            {{ $answer->point }}
                                        </div>
                                    </div>
                                    <div class="absolute top-0 left-0 w-full h-1/2 bg-white/20"></div>
                                </div>
                            @else
                                <div
                                    class="absolute inset-0 bg-gradient-to-b from-blue-800 to-blue-950 border-[3px] border-blue-500/50 rounded-xl shadow-lg flex items-center justify-center">
                                    <div
                                        class="aspect-square h-[70%] rounded-full bg-blue-950/50 border-4 border-blue-600/50 flex items-center justify-center shadow-inner">
                                        <span class="font-black text-blue-400/80" style="font-size: clamp(2rem, 4vw, 4rem);">
                                            {{ $loop->iteration }}
                                        </span>
                                    </div>
                                    <div class="absolute inset-x-0 h-[1px] bg-blue-500/20 top-1/2"></div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        @if ($question)
            <div class="flex justify-center items-center pt-2 pb-2">
                <div
                    class="relative bg-black border-4 border-yellow-600 rounded-2xl px-10 py-2 shadow-[0_0_50px_rgba(234,179,8,0.25)] flex flex-col items-center overflow-hidden transition-opacity duration-500 {{ $isStrikeOut ? 'opacity-20' : 'opacity-100' }}">
                    <div class="absolute top-0 left-0 w-full h-1/2 bg-gradient-to-b from-white/10 to-transparent"></div>
                    <span class="text-yellow-600/80 font-bold text-xs md:text-sm uppercase tracking-[0.5em] mb-1">
                        Total Score
                    </span>
                    <span
                        class="font-mono font-black text-white leading-none tracking-widest drop-shadow-[0_0_10px_rgba(255,255,255,0.5)]"
                        style="font-size: clamp(3rem, 6vw, 6rem);">
                        {{ str_pad($currentScore, 3, '0', STR_PAD_LEFT) }}
                    </span>
                </div>
            </div>
        @endif
    </div>

    <style>
        .perspective-1000 {
            perspective: 1000px;
        }

        .fill-mode-forwards {
            animation-fill-mode: forwards;
        }

        @keyframes flipIn {
            0% {
                transform: rotateX(90deg);
                opacity: 0;
            }

            100% {
                transform: rotateX(0);
                opacity: 1;
            }
        }

        .animate-flip-in {
            animation: flipIn 0.45s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        }

        @keyframes bounceIn {
            0% {
                transform: scale(0);
                opacity: 0;
            }

            60% {
                transform: scale(1.2);
                opacity: 1;
            }

            100% {
                transform: scale(1);
            }
        }

        .animate-bounce-in {
            animation: bounceIn 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        }

        @keyframes overlaySequence {
            0% {
                opacity: 1;
                visibility: visible;
            }

            80% {
                opacity: 1;
                visibility: visible;
            }

            100% {
                opacity: 0;
                visibility: hidden;
            }
        }

        .animate-overlay-sequence {
            animation: overlaySequence 2.5s ease-out forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }

        .confetti {
            position: absolute;
            width: 10px;
            height: 10px;
            background-color: #f00;
            top: -10%;
            animation: fall linear forwards;
        }

        @keyframes fall {
            to {
                transform: translateY(110vh) rotate(720deg);
            }
        }

        .confetti:nth-child(2n) {
            animation-duration: 2.5s;
        }

        .confetti:nth-child(2n+1) {
            animation-duration: 4s;
        }

        .confetti:nth-child(3n) {
            animation-duration: 3s;
        }
    </style>
</div>