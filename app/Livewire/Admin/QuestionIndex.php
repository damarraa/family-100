<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Question;
use App\Models\Answer;

#[Layout('components.layouts.game')]
class QuestionIndex extends Component
{
    public $question_text;
    public $answers = [];
    public $question_id = null;
    public $is_form_open = false;

    public function mount()
    {
        $this->resetForm();
    }

    public function render()
    {
        return view('livewire.admin.question-index', [
            'questions' => Question::withCount('answers')->latest()->get()
        ]);
    }

    public function resetForm()
    {
        $this->question_text = '';
        $this->question_id = null;
        $this->answers = [];

        for ($i = 0; $i < 5; $i++) {
            $this->answers[] = ['text' => '', 'point' => 0];
        }

        $this->is_form_open = false;
    }

    public function create()
    {
        $this->resetForm();
        $this->is_form_open = true;
    }

    public function edit($id)
    {
        $q = Question::with('answers')->findOrFail($id);
        $this->question_id = $q->id;
        $this->question_text = $q->question;

        
        foreach ($q->answers as $ans) {
            $this->answers[] = [
                'text' => $ans->answer_text,
                'point' => $ans->point,
                'id' => $ans->id
            ];
        }

        while (count($this->answers) < 5) {
            $this->answers[] = ['text' => '', 'point' => 0];
        }

        $this->is_form_open = true;
    }

    public function save()
    {
        $this->validate([
            'question_text' => 'required|string|max:255',
            'answers.*.text' => 'nullable|string|max:255',
            'answers.*.point' => 'nullable|integer',
        ]);

        if ($this->question_id) {
            $q = Question::find($this->question_id);
            $q->update(['question' => $this->question_text]);

            $q->answers()->delete();
        } else {
            $q = Question::create(['question' => $this->question_text]);
        }

        foreach ($this->answers as $index => $ans) {
            if (!empty($ans['text'])) {
                $q->answers()->create([
                    'answer_text' => $ans['text'],
                    'point' => (int) $ans['point'],
                    'order_rank' => $index + 1,
                    'is_revealed' => false
                ]);
            }
        }

        session()->flash('message', 'Soal berhasil disimpan!');
        $this->resetForm();
    }

    public function delete($id)
    {
        Question::find($id)->delete();
        session()->flash('message', 'Soal dihapus.');
    }

    public function toggleActive($id)
    {
        $q = Question::find($id);
        Question::query()->update(['is_active' => false]);
        $q->update(['is_active' => true]);
        $q->answers()->update(['is_revealed' => false]);
    }
}