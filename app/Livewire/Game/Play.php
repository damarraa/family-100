<?php

namespace App\Livewire\Game;

use App\Models\{Question, GameSession};
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.game')]
class Play extends Component
{
    protected $listeners = [
        'game-started' => '$refresh',
        'answer-revealed' => '$refresh',
        'game-reset' => '$refresh',
    ];

    public function render()
    {
        $session = GameSession::with([
            'question.answers' => function ($query) {
                $query->orderBy('order_rank', 'asc');
            }
        ])
            ->where('status', 'playing')
            ->latest()
            ->first();

        $isStrikeOut = false;
        $isPerfect = false;

        if ($session) {
            $isStrikeOut = $session->strikes >= 3;

            $unrevealedCount = $session->question->answers->where('is_revealed', false)->count();
            $isPerfect = $unrevealedCount === 0;
        }

        return view('livewire.game.play', [
            'gameSession' => $session,
            'question' => $session ? $session->question : null,
            'currentScore' => $session ? $session->total_score : 0,
            'isStrikeOut' => $isStrikeOut,
            'isPerfect' => $isPerfect,
        ]);
    }
}