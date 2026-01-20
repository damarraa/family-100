# 📄 BRIEF PROJECT

## Informasi Umum
- **Klien**: PT Kilang Pertamina Refinery Unit II Dumai
- **PIC**: Pak Azmi
- **Jenis Project**: Web Apps Cerdas Cermat K3
- **Referensi Konsep**: Quiz *Family 100*
- **Deadline**: ± 1 minggu
- **Platform**: Web-based (untuk laptop + proyektor)
- **Peran Developer**: Fullstack (logic, UI, admin)

---

## Tujuan Aplikasi
Menyediakan aplikasi quiz interaktif bertema **K3** yang dapat digunakan dalam acara internal (training, sosialisasi, lomba), dengan tampilan menarik seperti *Family 100* dan mudah dioperasikan oleh operator.

---

# 🎮 GAMBARAN ALUR PERMAINAN

1. **MC membacakan pertanyaan** kepada peserta
2. **Peserta menjawab secara lisan** (bebas, tanpa urutan)
3. **Operator memilih / klik jawaban** yang disebut peserta melalui panel operator
4. **Jawaban muncul (reveal)** di layar utama
5. **Nilai otomatis dijumlahkan**
6. Proses berlanjut hingga semua jawaban terungkap

> Catatan penting: Urutan jawaban **tidak harus ditentukan di awal**, operator menentukan secara manual saat game berjalan.

---

# 🧩 FITUR UTAMA APLIKASI

## 1️⃣ Manajemen Soal (Admin)
- Input pertanyaan
- Input banyak jawaban (1–5 atau lebih)
- Penentuan nilai/poin per jawaban
- Edit & hapus soal

## 2️⃣ Gameplay (Layar Utama)
- Tampilan seperti *Family 100*
- Reveal jawaban satu per satu
- Penjumlahan skor otomatis
- Tampilan skor total
- (Opsional) Timer per soal

## 3️⃣ Panel Operator
- Memilih soal aktif
- Klik jawaban yang disebut peserta
- Reset permainan
- Kontrol jalannya game

## 4️⃣ Mode Presentasi
- Fullscreen
- Optimasi tampilan untuk proyektor / layar besar

## 5️⃣ Realtime Experience
- Update jawaban & skor tanpa refresh halaman
- Interaksi cepat antara operator & layar utama

---

# ⚙️ TEKNOLOGI (RENCANA)

- **Backend**: Laravel
- **Frontend**: Blade + Livewire / Alpine.js
- **Database**: MySQL
- **Styling**: Tailwind CSS (opsional)

> Catatan: Dipilih untuk kecepatan development & stabilitas sesuai deadline singkat.

---

# 🗓️ ALUR PENGERJAAN (7 HARI)

## Hari 1
- Dokumentasi & finalisasi scope
- Desain database
- Setup project Laravel

## Hari 2
- CRUD soal & jawaban (Admin)
- Panel operator dasar

## Hari 3
- Gameplay utama (reveal jawaban, skor)

## Hari 4
- Mode presentasi & fullscreen
- UX flow MC–Operator

## Hari 5
- Polishing UI
- (Opsional) Timer & animasi ringan

## Hari 6
- Testing end-to-end
- Simulasi quiz
- Bug fixing

## Hari 7
- Demo ke klien
- Minor revisi
- Finalisasi

---

# 📌 OUTPUT YANG DIHARAPKAN
- Web apps siap digunakan
- Demo aplikasi untuk klien
- Aplikasi stabil untuk acara live

---

# 🧠 CATATAN PENTING
- Fokus pada **stabilitas & kemudahan operasional**
- Hindari fitur berlebihan di awal
- Operator experience adalah kunci