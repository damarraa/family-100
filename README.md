# 🎮 Cerdas Cermat K3 – Family 100 Style

Web Apps **Cerdas Cermat K3** adalah aplikasi kuis interaktif berbasis web yang dirancang khusus untuk kebutuhan **event, pelatihan, dan sosialisasi K3**, dengan konsep **Dual Screen System** seperti acara *Family 100*.

Aplikasi ini memungkinkan **Operator/MC** mengontrol jalannya permainan dari satu layar, sementara **Peserta** melihat tampilan visual yang atraktif dan responsif di layar proyektor atau TV besar.

---

## ✨ Fitur Utama

- 🎥 **Dual Screen System**  
  - **Layar Operator**: Kontrol soal, buka jawaban, skor, dan efek
  - **Layar Proyektor**: Tampilan visual untuk peserta (real-time)

- 📝 **Manajemen Soal Dinamis**  
  - Jumlah jawaban **tidak dibatasi** (1 – N)
  - Poin dapat diatur per jawaban

- 🔍 **Smart Search Jawaban**  
  - Operator cukup mengetik 3 huruf pertama untuk mencari jawaban peserta

- 🔔 **Sound Effect Interaktif**  
  - Jawaban benar → *Ding!*  
  - Jawaban salah → *Tetot!*

- ❌ **Tombol Hukuman (TETOT!)**  
  - Menampilkan animasi hukuman di layar proyektor

- 📺 **Mode Proyektor Responsif**  
  - Optimal untuk layar besar (TV / Proyektor)
  - Mendukung berbagai rasio layar (16:9, 4:3)

- ⚡ **Real-time Update (Polling)**  
  - Tidak perlu refresh halaman
  - Stabil untuk live event

---

## 🧱 Tech Stack

- **Laravel 12** – Backend Framework
- **Laravel Breeze** – Authentication
- **Livewire** – Reactive UI & real-time interaction
- **Tailwind CSS** – Styling & responsive design
- **MySQL** – Database

---
<!-- 
## 🖥️ Cara Menggunakan (Demo)

### 1️⃣ Layar Operator (Admin / MC)
Digunakan untuk mengontrol permainan.

🔗 Link:  
```
/login
```

📌 Contoh akun demo:
```
Email    : admin@example.com
Password : password123
```

Disarankan menggunakan **Laptop atau HP Operator**. -->

### 2️⃣ Layar Proyektor (Peserta)
Digunakan sebagai tampilan utama untuk peserta.

🔗 Link:
```
/play
```

📢 Catatan:
- Aktifkan **audio/speaker** untuk efek suara
- Tampilan otomatis full screen & responsif

---

## 🔄 Alur Permainan Singkat

1. Operator login ke dashboard
2. Operator memilih soal
3. Game dimulai (status: *playing*)
4. Peserta menyebutkan jawaban
5. Operator membuka jawaban yang sesuai
6. Skor otomatis terakumulasi
7. Game dapat di-reset atau dilanjutkan ke soal berikutnya

---

## 🗂️ Struktur Komponen Utama

```
app/
├── Livewire/
│   ├── Admin/
│   │   └── QuestionIndex.php
│   └── Game/
│       ├── GameControl.php   # Operator Panel
│       └── Play.php          # Layar Proyektor
│
├── Services/
│   └── GameService.php       # Core game logic & rules
```

---

## 🔐 Keamanan & Game Rules

- Jawaban yang sudah terbuka **tidak bisa dibuka ulang**
- Jawaban tidak bisa dibuka jika game belum dimulai
- Double click dicegah (UI & backend guarded)
- State game dikontrol di **Service Layer**

---

## 📦 Instalasi Lokal (Development)

```bash
# Clone repository
git clone https://github.com/username/cerdas-cermat-k3.git

cd cerdas-cermat-k3

# Install dependencies
composer install
npm install

# Copy env
cp .env.example .env

# Generate key
php artisan key:generate

# Migrate database
php artisan migrate --seed

# Run dev server
php artisan serve
npm run dev
```

---

## 🚀 Status Project

✅ **Production Ready**  
✅ Digunakan untuk event & simulasi  
✅ Stabil untuk live event

---

## 📄 Lisensi

Project ini dikembangkan untuk kebutuhan internal & event.  
Penggunaan ulang atau distribusi ulang harap seizin pengembang.

---

## 👨‍💻 Author

**E. Andhika Alfira Damara**  
Fullstack Developer (Laravel)

---

> "Build for the stage, not just for the screen." 🎤✨

