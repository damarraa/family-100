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
        $gameService->revealAnswer($answer, $this->session);

        $this->session->refresh();
        // $this->dispatch('answer-revealed');
    }

    public function resetGame(GameService $gameService)
    {
        $gameService->resetGame($this->session);
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
