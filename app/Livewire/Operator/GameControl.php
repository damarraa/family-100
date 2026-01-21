<?php

namespace App\Livewire\Operator;

use App\Models\{Question, GameSession, Answer};
use App\Services\GameService;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.game')]
class GameControl extends Component
{
    public ?GameSession $session = null;
    public $search = '';

    public function startGame(int $questionId, GameService $gameService)
    {
        $question = Question::with('answers')->findOrFail($questionId);
        $this->session = $gameService->startGame($question);

        $this->dispatch('game-started');
    }

    public function reveal(int $answerId, GameService $gameService)
    {
        if (!$this->session || $this->session->status !== 'playing') {
            return;
        }

        $answer = Answer::findOrFail($answerId);

        if (!$answer->is_revealed) {
            $gameService->revealAnswer($answer, $this->session);
            $this->session->refresh();

            $this->dispatch('play-correct');

            $unrevealed = $this->session->question->answers()->where('is_revealed', false);
            if ($unrevealed === 0) {
                $this->dispatch('play-perfect');
            }
        }
    }

    public function addStrike()
    {
        if ($this->session && $this->session->strikes < 3) {
            $this->session->increment('strikes');
            $this->session->refresh();
            $this->dispatch('play-wrong');
        }
    }

    public function resetStrikes()
    {
        if ($this->session) {
            $this->session->update(['strikes' => 0]);
            $this->session->refresh();
        }
    }

    public function resetGame(GameService $gameService)
    {
        if ($this->session) {
            $gameService->resetGame($this->session);
            $this->session->update(['strikes' => 0]);
        }

        $this->session = null;
        $this->dispatch('game-reset');
    }

    public function closeGameView()
    {
        $this->session = null;
    }

    public function render()
    {
        return view('livewire.operator.game-control', [
            'questions' => Question::with('answers')->get(),
        ]);
    }
}
