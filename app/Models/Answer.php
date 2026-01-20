<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $table = 'answers';

    protected $fillable = [
        'question_id',
        'answer_text',
        'point',
        'order_rank',
        'is_revealed',
    ];

    protected $casts = [
        'is_revealed' => 'boolean',
        'point' => 'integer',
    ];

    /**
     * Relasi untuk jawaban milik satu pertanyaan.
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Relasi untuk jawaban bisa tercatat di banyak log game.
     */
    public function gameLogs()
    {
        return $this->hasMany(GameLog::class);
    }
}
