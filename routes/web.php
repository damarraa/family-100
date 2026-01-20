<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Operator\GameControl;
use App\Livewire\Game\Play;
use App\Livewire\Admin\QuestionIndex;

Route::get('/', fn() => redirect()->route('game.play'));
Route::get('/play', Play::class)->name('game.play');

Route::middleware(['auth'])->group(function () {
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin', fn() => view('admin.dashboard'));
        Route::get('/admin/questions', QuestionIndex::class)->name('admin.questions');
    });

    Route::middleware(['role:operator,admin'])->group(function () {
        Route::get('/operator', GameControl::class)->name('operator.dashboard');
    });

    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.questions');
        }
        return redirect()->route('operator.dashboard');
    })->name('dashboard');

    Route::post('/logout', function () {
        auth()->guard('web')->logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect('/login');
    })->name('logout');
});

require __DIR__ . '/auth.php';
