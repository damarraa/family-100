<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameLog extends Model
{
    use HasFactory;

    protected $table = 'game_logs';
    public $timestamps = false;

    protected $fillable = [
        'game_session_id',
        'answer_id',
        'selected_by',
        'created_at'
    ];

    /**
     * Relasi ke sesi.
     */
    public function gameSession()
    {
        return $this->belongsTo(GameSession::class);
    }

    /**
     * Relasi ke jawaban yang dipilih.
     */
    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }

    /**
     * Relasi ke operator yang meng-klik
     */
    public function operator()
    {
        return $this->belongsTo(User::class, 'selected_by');
    }
}
