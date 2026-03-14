# Panduan Belajar Integrasi Flutter & Laravel

Halo! Saya sudah menyelesaikan integrasi aplikasi Flutter kamu dengan backend Laravel. Sekarang aplikasimu sudah bersifat **Full-Stack** (Data di Flutter langsung ngambil dari database Laravel).

Berikut adalah ringkasan sistem yang baru saja kita bangun:

## 1. Backend: Laravel API (Pintu Masuk Data)
Agar HP bisa ngobrol dengan server, kita butuh "Pintu Masuk" yang namanya API.
- **Sanctum**: Kita pakai fitur Laravel Sanctum buat keamanan. Jadi nggak sembarang orang bisa akses data buku, harus Login dulu dan dapet **Token** (seperti KTP digital).
- **Route API**: Bisa cek di `routes/api.php`. Di sana ada daftar perintah seperti `/login`, `/buku`, dan `/transaksi`.
- **Controller API**: Di `app/Http/Controllers/Api/`, ada logika buat nyari buku di database terus dirubah jadi format **JSON** (format bahasa yang dimengerti Flutter).

## 2. Frontend: Flutter (Tampilan & Jaringan)
- **Shared Preferences**: Dipakai buat "ingatan" aplikasi. Token login dari Laravel kita simpan di sini supaya pas aplikasi dibuka lagi, user nggak usah login ulang.
- **ApiService (`lib/core/api_service.dart`)**: Ini adalah jidatnya aplikasi. Di sini ada fungsi `getBooks()` yang tugasnya request ke Laravel.
- **Model (`lib/models/user.dart`)**: Ini cuma buat nampung data user biar gampang dibaca sama Flutter.

## 3. Alur Belajarnya (Workflow):
1. **User Login** di Flutter -> Flutter panggil `ApiService.login()`.
2. **Laravel** cek email & password -> Kalau oke, Laravel kasih **Token**.
3. **Flutter** simpan Token itu -> Pindah ke halaman **Home**.
4. **Halaman Home** panggil `ApiService.getBooks()` sambil bawa Token tadi.
5. **Laravel** validasi Token -> Kasih data daftar buku.
6. **Flutter** nampilin datanya di `ListView`.

### Saran untuk Eksperimen:
- Coba tambah buku baru di **Admin Panel** Laravel, lalu buka aplikasi Flutter dan klik tombol **Refresh** (ikon putar) di pojok kanan atas. Bukunya pasti langsung muncul!
- Coba klik tombol **Pinjam**, nanti stok buku di database Laravel akan otomatis berkurang.
- Klik ikon **History** (jam) di pojok kanan atas untuk melihat daftar buku yang sedang kamu pinjam.

## 4. Fitur Riwayat (Baru!)
Sekarang user bisa melihat apa saja yang sudah dipinjam.
- **Relasi User-Anggota**: Saya sudah menghubungkan tabel `users` dengan tabel `anggota`. Jadi Laravel tahu kalau yang sedang login itu anggota yang mana.
- **History Screen**: Di Flutter ada `lib/screens/history_screen.dart` yang tugasnya menampilkan data dari endpoint `/api/transaksi`.

Kalau ada bagian kode yang kamu bingung (misalnya bagian `Future` atau `async/await`), tanya aja ya! Saya siap jelasin detail kodenya.
