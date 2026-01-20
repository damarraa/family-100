<?php
namespace App\Livewire\Admin;

use App\Models\Answer;
use App\Models\Question;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.game')]
class QuestionIndex extends Component
{
    public $question_text;
    public $answers      = [];
    public $question_id  = null;
    public $is_form_open = false;

    public function mount()
    {
        $this->resetForm();
    }

    public function render()
    {
        return view('livewire.admin.question-index', [
            'questions' => Question::withCount('answers')->latest()->get(),
        ]);
    }

    public function resetForm()
    {
        $this->question_text = '';
        $this->question_id   = null;
        $this->answers       = [];

        for ($i = 0; $i < 3; $i++) {
            $this->answers[] = ['id' => null, 'text' => '', 'point' => 0];
        }

        $this->is_form_open = false;
    }

    public function addAnswer()
    {
        $this->answers[] = ['id' => null, 'text' => '', 'point' => 0];
    }

    public function removeAnswer($index)
    {
        unset($this->answers[$index]);
        $this->answers = array_values($this->answers);
    }

    public function create()
    {
        $this->resetForm();
        $this->is_form_open = true;
    }

    public function edit($id)
    {
        $q = Question::with(['answers' => function ($query) {
            $query->orderBy('order_rank', 'asc');
        }])->findOrFail($id);

        $this->question_id   = $q->id;
        $this->question_text = $q->question;

        $this->answers = [];
        foreach ($q->answers as $ans) {
            $this->answers[] = [
                'id'    => $ans->id,
                'text'  => $ans->answer_text,
                'point' => $ans->point,
            ];
        }

        $this->is_form_open = true;
    }

    public function save()
    {
        $this->validate([
            'question_text'   => 'required|string|max:255',
            'answers.*.text'  => 'nullable|string|max:255',
            'answers.*.point' => 'nullable|integer',
        ]);

        usort($this->answers, function ($a, $b) {
            return (int) $b['point'] <=> (int) $a['point'];
        });

        if ($this->question_id) {
            $q = Question::find($this->question_id);
            $q->update(['question' => $this->question_text]);
        } else {
            $q = Question::create(['question' => $this->question_text]);
        }

        $keptAnswerIds = [];

        foreach ($this->answers as $index => $ans) {
            if (empty($ans['text'])) {
                continue;
            }

            $currentRank = $index + 1;

            if (isset($ans['id']) && $ans['id']) {
                $existingAnswer = Answer::find($ans['id']);
                if ($existingAnswer) {
                    $existingAnswer->update([
                        'answer_text' => $ans['text'],
                        'point'       => (int) $ans['point'],
                        'order_rank'  => $currentRank,
                    ]);
                    $keptAnswerIds[] = $ans['id'];
                }
            } else {
                $newAnswer = $q->answers()->create([
                    'answer_text' => $ans['text'],
                    'point'       => (int) $ans['point'],
                    'order_rank'  => $currentRank,
                    'is_revealed' => false,
                ]);
                $keptAnswerIds[] = $newAnswer->id;
            }
        }

        if ($this->question_id) {
            try {
                $q->answers()->whereNotIn('id', $keptAnswerIds)->delete();
            } catch (\Exception $e) {
                //
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
