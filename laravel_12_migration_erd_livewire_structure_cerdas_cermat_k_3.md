# 🚀 Laravel 12 – Migration, ERD, & Livewire Structure
Project: **Web Apps Cerdas Cermat K3 (Family 100)**

Dokumen ini merupakan turunan teknis dari schema yang sudah disepakati, mencakup:
1) Migration Laravel 12
2) ERD sederhana
3) Rancangan struktur Livewire (best practice)

---

# 1️⃣ MIGRATION LARAVEL 12

> Catatan:
> - Menggunakan `foreignId()->constrained()`
> - Boolean default disesuaikan gameplay
> - Aman untuk Livewire & realtime interaction

## 📄 create_users_table
*(default Laravel, hanya tambahan role)*

```php
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->string('password');
    $table->enum('role', ['admin', 'operator'])->default('operator');
    $table->timestamps();
});
```

---

## 📄 create_questions_table

```php
Schema::create('questions', function (Blueprint $table) {
    $table->id();
    $table->text('question');
    $table->boolean('is_active')->default(false);
    $table->timestamps();
});
```

---

## 📄 create_answers_table

```php
Schema::create('answers', function (Blueprint $table) {
    $table->id();
    $table->foreignId('question_id')->constrained()->cascadeOnDelete();
    $table->string('answer_text');
    $table->integer('point')->default(0);
    $table->integer('order_rank')->nullable();
    $table->boolean('is_revealed')->default(false);
    $table->timestamps();
});
```

---

## 📄 create_game_sessions_table

```php
Schema::create('game_sessions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('question_id')->constrained()->cascadeOnDelete();
    $table->integer('total_score')->default(0);
    $table->enum('status', ['waiting', 'playing', 'finished'])->default('waiting');
    $table->timestamps();
});
```

---

## 📄 create_game_logs_table (opsional tapi direkomendasikan)

```php
Schema::create('game_logs', function (Blueprint $table) {
    $table->id();
    $table->foreignId('game_session_id')->constrained()->cascadeOnDelete();
    $table->foreignId('answer_id')->constrained()->cascadeOnDelete();
    $table->foreignId('selected_by')->constrained('users')->cascadeOnDelete();
    $table->timestamps();
});
```

---

# 2️⃣ ERD SEDERHANA (TEXTUAL)

```
USERS (admin / operator)
  └───< GAME_LOGS >───┐
                       │
QUESTIONS ───< ANSWERS
    │
    └───< GAME_SESSIONS ───< GAME_LOGS
```

### Penjelasan singkat:
- **1 Question** punya banyak **Answers**
- **1 Question** bisa dimainkan di beberapa **Game Sessions**
- **Game Logs** mencatat jawaban apa yang diklik operator di sesi tertentu

ERD ini sederhana tapi sangat aman untuk live event.

---

# 3️⃣ RANCANGAN LIVEWIRE COMPONENT STRUCTURE

Struktur ini fokus pada:
- Separation of concerns
- Mudah debug saat live
- Cepat dikembangkan

## 📂 app/Livewire

```
Livewire/
├── Admin/
│   ├── QuestionIndex.php        // list & CRUD soal
│   ├── QuestionForm.php         // create / edit soal
│   └── AnswerForm.php           // manage jawaban
│
├── Operator/
│   ├── GameControl.php          // pilih soal, klik jawaban
│   └── ScoreBoard.php           // skor realtime
│
├── Game/
│   ├── Play.php                 // layar utama (reveal jawaban)
│   └── Present.php              // fullscreen / projector mode
│
└── Components/
    ├── Timer.php                // (opsional)
    └── ModalConfirm.php         // konfirmasi reset, dll
```

---

## 🔄 Alur Livewire Realtime

- **Operator/GameControl**
  - Klik jawaban
  - Update `is_revealed`
  - Tambah `total_score`

- **Game/Play & Present**
  - Listen event
  - Auto update tanpa refresh

> Gunakan:
> - `dispatch()`
> - `#[On('answer-revealed')]`

---

# 4️⃣ BEST PRACTICE PENTING

- Logic gameplay berat → **Service Class** (`App\Services\GameService`)
- Livewire hanya orchestration
- Hindari logic kompleks di Blade
- Reset game = transaction

---

# 🧠 PENUTUP

Dengan struktur ini kamu mendapatkan:
- Arsitektur rapi
- Aman untuk demo live
- Mudah scale (multi ronde / kategori)

Dokumen ini bisa langsung kamu pakai sebagai **technical blueprint** sebelum mulai ngoding.

✍️ *Disusun untuk mendukung eksekusi cepat & minim revisi.*

