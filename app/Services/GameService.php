<?php

namespace App\Services;

use App\Models\Question;
use App\Models\Answer;
use App\Models\GameSession;
use App\Models\GameLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GameService
{
    /**
     * Memulai sesi permainan baru untuk pertanyaan tertentu.
     * Otomatis mereset status jawaban sebelumnya agar tertutup kembali.
     */
    public function startGame(Question $question): GameSession
    {
        return DB::transaction(function () use ($question) {
            Question::where('id', '!=', $question->id)->update(['is_active' => false]);
            $question->update(['is_active' => true]);
            $question->answers()->update(['is_revealed' => false]);

            // Opsional jika ke depannya mau buat banyak session aktif.
            // GameSession::where('status', 'playing')->update(['status' => 'finished']);

            return GameSession::create([
                'question_id' => $question->id,
                'total_score' => 0,
                'status' => 'playing',
            ]);
        });
    }

    /**
     * Membuka jawaban dan menambahkan poin ke sesi.
     * Termasuk mencatat log siapa operator yang menekan tombol.
     */
    public function revealAnswer(Answer $answer, GameSession $session): void
    {
        if ($session->status !== 'playing') {
            return;
        }

        if ($answer->is_revealed) {
            return;
        }

        DB::transaction(function () use ($answer, $session) {
            $answer->update(['is_revealed' => true]);
            $session->increment('total_score', $answer->point);

            GameLog::create([
                'game_session_id' => $session->id,
                'answer_id' => $answer->id,
                'selected_by' => Auth::id(),
            ]);
        });
    }

    /**
     * Mereset permainan di tengah jalan jika terjadi kesalahan input
     * atau ingin mengulang soal yang sama tanpa buat sesi baru.
     */
    public function resetGame(GameSession $session): void
    {
        DB::transaction(function () use ($session) {
            $session->update(['total_score' => 0]);
            $session->question->answers()->update(['is_revealed' => false]);
        });
    }
}