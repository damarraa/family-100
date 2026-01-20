<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'questions';

    protected $fillable = [
        'question',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /** 
     * Relasi satu pertanyaan punya banyak jawaban.
     */
    public function answers()
    {
        return $this->hasMany(Answer::class)->orderBy('order_rank', 'asc');
    }

    /**
     * Relasi satu pertanyaan bisa dimainkan dalam banyak sesi (history).
     */
    public function gameSessions()
    {
        return $this->hasMany(GameSession::class);
    }

    /**
     * Accessor cek total poin maksimal dari satu soal.
     */
    public function getTotalPointsAttribute()
    {
        return $this->answers->sum('point');
    }
}
