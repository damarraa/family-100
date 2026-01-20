<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameSession extends Model
{
    use HasFactory;

    protected $table = 'game_sessions';

    protected $fillable = [
        'question_id',
        'total_score',
        'status', // waiting, playing, finished
    ];

    /**
     * Relasi untuk sesi permainan terikat pada satu pertanyaan utama.
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Relasi untuk sesi punya banyak log aktivitas (jawaban yang dipilih).
     */
    public function gameLogs()
    {
        return $this->hasMany(GameLog::class);
    }
}
