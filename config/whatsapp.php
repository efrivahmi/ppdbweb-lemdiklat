<?php

return [
    /*
    |--------------------------------------------------------------------------
    | WhatsApp Configuration (Fonnte.com)
    |--------------------------------------------------------------------------
    |
    | Fonnte is a free Indonesian WhatsApp API service.
    | Register at https://fonnte.com to get your API token.
    |
    | Free tier includes:
    | - 500 messages/day
    | - No monthly cost
    |
    */

    'driver' => env('WHATSAPP_DRIVER', 'fonnte'),

    'fonnte' => [
        'token' => env('FONNTE_TOKEN', ''),
        'device' => env('FONNTE_DEVICE', ''),
        'base_url' => 'https://api.fonnte.com',
    ],

    /*
    |--------------------------------------------------------------------------
    | Message Templates
    |--------------------------------------------------------------------------
    */

    'templates' => [
        'welcome' => "🎓 *Selamat Datang di PPDB Lemdiklat Taruna Nusantara!*\n\nHai {nama}, pendaftaranmu berhasil!\n\n📋 *Langkah Selanjutnya:*\n1. Login ke dashboard\n2. Lengkapi data diri\n3. Upload berkas\n4. Lakukan pembayaran\n\n🔗 Login: {url}\n\n_Butuh bantuan? Balas pesan ini._",

        'incomplete_data' => "⚠️ *Pengingat Data PPDB*\n\nHai {nama}, data pendaftaranmu belum lengkap:\n\n{daftar_data_kosong}\n\n⏰ Segera lengkapi agar pendaftaran dapat diproses.\n\n🔗 Lengkapi: {url}",

        'payment_reminder' => "💳 *Pengingat Pembayaran PPDB*\n\nHai {nama}, pembayaran pendaftaran belum dilakukan.\n\n💰 Nominal: Rp {nominal}\n🏦 Bank: {bank}\n📝 No. Rek: {no_rek}\n\n⏰ Segera lakukan pembayaran.\n\nSetelah transfer, upload bukti di dashboard.\n🔗 {url}",

        'payment_verified' => "✅ *Pembayaran Diverifikasi*\n\nHai {nama}, pembayaranmu telah diverifikasi!\n\nStatus: *{status}*\n\n{pesan_tambahan}\n\n🔗 Cek detail: {url}",

        'status_update' => "📢 *Update Status PPDB*\n\nHai {nama}, status pendaftaranmu telah diperbarui:\n\n✅ Status: *{status}*\n\n{pesan_tambahan}\n\n🔗 Cek detail: {url}",

        'accepted' => "🎉 *SELAMAT! Kamu Diterima!*\n\nHai {nama},\n\nSelamat! Kamu telah *DITERIMA* di {sekolah}!\n\n📋 *Langkah Selanjutnya:*\n{instruksi}\n\n🔗 Detail: {url}\n\n_Selamat bergabung di keluarga besar Taruna Nusantara!_",

        'rejected' => "📢 *Pemberitahuan Status PPDB*\n\nHai {nama},\n\nMohon maaf, setelah melalui proses seleksi, status pendaftaranmu adalah: *Tidak Diterima*\n\nJangan menyerah! Tetap semangat untuk kesempatan berikutnya.\n\n_Terima kasih telah mendaftar._",
    ],

    /*
    |--------------------------------------------------------------------------
    | Notification Settings
    |--------------------------------------------------------------------------
    */

    'notifications' => [
        'send_welcome' => env('WA_SEND_WELCOME', true),
        'send_payment_reminder' => env('WA_SEND_PAYMENT_REMINDER', true),
        'send_data_reminder' => env('WA_SEND_DATA_REMINDER', true),
        'send_status_update' => env('WA_SEND_STATUS_UPDATE', true),
    ],
];
