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
        $question = Question::where('is_active', true)
            ->with('answers')
            ->first();

        $session = $question
            ? GameSession::where('question_id', $question->id)
                ->where('status', 'playing')
                ->latest()
                ->first()
            : null;

        return view('livewire.game.play', [
            'question' => $question,
            'currentScore' => $session?->total_score ?? 0,
        ]);
    }
}