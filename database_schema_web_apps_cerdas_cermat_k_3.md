# 🗄️ DATABASE SCHEMA
Web Apps **Cerdas Cermat K3 (Family 100)**

Dokumen ini menjelaskan rancangan struktur database sebagai fondasi pengembangan aplikasi.

---

## 📌 Prinsip Desain
- Sederhana & mudah dikembangkan
- Aman dari scope creep
- Mendukung gameplay realtime
- Fleksibel untuk variasi jumlah jawaban

---

# 📊 DAFTAR TABEL

## 1️⃣ users (Admin / Operator)
Digunakan untuk autentikasi admin dan operator.

| Field | Tipe | Keterangan |
|------|-----|------------|
| id | bigint | Primary key |
| name | string | Nama pengguna |
| email | string | Email login |
| password | string | Password hash |
| role | enum | `admin`, `operator` |
| timestamps | — | created_at, updated_at |

---

## 2️⃣ questions
Menyimpan data pertanyaan quiz.

| Field | Tipe | Keterangan |
|------|-----|------------|
| id | bigint | Primary key |
| question | text | Isi pertanyaan |
| is_active | boolean | Status soal aktif |
| timestamps | — | created_at, updated_at |

> Catatan: hanya **1 soal aktif** dalam satu sesi permainan.

---

## 3️⃣ answers
Menyimpan daftar jawaban untuk setiap pertanyaan.

| Field | Tipe | Keterangan |
|------|-----|------------|
| id | bigint | Primary key |
| question_id | bigint | Relasi ke questions |
| answer_text | string | Teks jawaban |
| point | integer | Nilai jawaban |
| order_rank | integer (nullable) | Urutan jawaban (opsional) |
| is_revealed | boolean | Status tampil di layar |
| timestamps | — | created_at, updated_at |

> ⚠️ **order_rank boleh null** karena urutan bisa ditentukan saat game berjalan oleh operator.

---

## 4️⃣ game_sessions
Menyimpan sesi permainan aktif.

| Field | Tipe | Keterangan |
|------|-----|------------|
| id | bigint | Primary key |
| question_id | bigint | Soal yang dimainkan |
| total_score | integer | Akumulasi nilai |
| status | enum | `waiting`, `playing`, `finished` |
| timestamps | — | created_at, updated_at |

---

## 5️⃣ game_logs (opsional tapi direkomendasikan)
Menyimpan histori jawaban yang dipilih operator.

| Field | Tipe | Keterangan |
|------|-----|------------|
| id | bigint | Primary key |
| game_session_id | bigint | Relasi ke sesi |
| answer_id | bigint | Jawaban yang dipilih |
| selected_by | bigint | Operator (user_id) |
| timestamps | — | created_at |

Digunakan untuk:
- Audit
- Replay
- Debug saat live event

---

# 🔗 RELASI ANTAR TABEL

- **questions** 1 —— * **answers**
- **questions** 1 —— * **game_sessions**
- **game_sessions** 1 —— * **game_logs**
- **users** 1 —— * **game_logs**

---

# 🚀 CATATAN IMPLEMENTASI LARAVEL

- Gunakan **foreignId + constrained()**
- Aktifkan **soft delete** bila perlu
- Index pada `question_id`, `is_active`
- Logic gameplay sebaiknya di **service layer / Livewire component**

---

# 🧠 KESIMPULAN
Schema ini:
- Mendukung gameplay Family 100
- Fleksibel untuk operator-driven flow
- Aman untuk demo & event live