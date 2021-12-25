Soal No 3:

# General Installation

- Clone Repository
- cd coding-test/soal3
- composer install
- copy .env.example -> .env
- php artisan key:generate
- php artisan migrate
- npm install && npm run dev

# Untuk mengaktifkan Pembayaran dengan tripay

- daftar atau login akun tripay
- masuk ke simulator mode pada menu Api & Integrasi lalu pilih simulator
- pilih menu Merchant> Detail
- Copy code merchant,Api key, dan Private Key pastekan di .env (Scrool ke yang paling bawah)
- settting url callback https://yoursite/api/callback/tripay

## Agar Pembayaran Berhasil

- Diusahakan isi url callback dengan url site yang online saya menggunakan ngrok untuk development
- Konfirmasi Pembayaran Melalui Transaksi klik pada no referensi> ubah status
- setting Kirim Callback dengan Ya

# Saran Pengembangan Selanjutnya

- Untuk Pengembangan Selanjutnya bisa ditambahkan Menu Untuk Pembelian Pulsa, Listrik , Dll
- bisa melakukan transfer saldo
