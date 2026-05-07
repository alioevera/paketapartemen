<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Paket Anda Sudah Tiba</title>
</head>
<body style="margin:0; padding:0; background:#f6f6f4; font-family:Arial, Helvetica, sans-serif; color:#121212;">
    <div style="max-width:640px; margin:0 auto; padding:32px 20px;">
        <div style="background:#ffffff; border-radius:20px; padding:32px; box-shadow:0 8px 24px rgba(0,0,0,0.06);">
            <h1 style="margin:0 0 16px; font-size:26px; font-weight:800;">
                Paket Anda Sudah Tiba di Resepsionis
            </h1>

            <p style="margin:0 0 20px; font-size:15px; line-height:1.8;">
                Halo <strong>{{ $penghuni->nama_penghuni }}</strong>, paket Anda sudah diterima oleh resepsionis.
                Silakan tunjukkan QR code berikut saat pengambilan paket.
            </p>

            <table style="width:100%; border-collapse:collapse; margin-bottom:24px;">
                <tr>
                    <td style="padding:10px 0; font-weight:700; width:180px;">Nomor Unit</td>
                    <td style="padding:10px 0;">{{ $paket->unit ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding:10px 0; font-weight:700;">Nomor Resi</td>
                    <td style="padding:10px 0;">{{ $paket->nomor_resi ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding:10px 0; font-weight:700;">Ekspedisi</td>
                    <td style="padding:10px 0;">{{ $paket->expedisi?->expedisi_name ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding:10px 0; font-weight:700;">Bentuk Paket</td>
                    <td style="padding:10px 0;">{{ $paket->bentuk_paket ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding:10px 0; font-weight:700;">Jumlah Paket</td>
                    <td style="padding:10px 0;">{{ $paket->jumlah_paket ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding:10px 0; font-weight:700;">Lokasi Simpan</td>
                    <td style="padding:10px 0;">{{ $paket->lokasi_simpan ?? '-' }}</td>
                </tr>
            </table>

            <div style="margin:24px 0; padding:20px; border:1px solid #e5e7eb; border-radius:16px; background:#fafaf9; text-align:center;">
                <p style="margin:0 0 14px; font-size:14px; font-weight:700;">
                    QR Code Pengambilan Paket
                </p>

                <img
                    src="{{ $message->embedData($qrPng, 'qr-paket.png', 'image/png') }}"
                    alt="QR Code Paket"
                    style="display:block; margin:0 auto 12px; width:220px; height:220px; object-fit:contain;"
                >

                <p style="margin:0; font-size:13px; color:#555;">
                    Tunjukkan QR code ini kepada resepsionis saat pengambilan paket.
                </p>

                <p style="margin:10px 0 0; font-size:12px; color:#888;">
                    Kode verifikasi: <strong>{{ $qrValue }}</strong>
                </p>
            </div>

            <p style="margin:20px 0 0; font-size:14px; line-height:1.8;">
                Jika QR code tidak dapat dipindai, resepsionis tetap dapat melakukan verifikasi menggunakan
                kode: <strong>{{ $qrValue }}</strong>.
            </p>
        </div>
    </div>
</body>
</html>