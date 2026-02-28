<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $notification->title }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px;
            text-align: center;
            color: white;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }

        .header p {
            margin: 5px 0 0 0;
            font-size: 12px;
            opacity: 0.9;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .content {
            padding: 40px 30px;
        }

        .greeting {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
        }

        .notification-box {
            background-color: #f8f9fa;
            border-left: 4px solid;
            padding: 20px;
            margin: 20px 0;
            border-radius: 4px;
        }

        .notification-box.info {
            border-color: #3b82f6;
            background-color: #eff6ff;
        }

        .notification-box.success {
            border-color: #10b981;
            background-color: #f0fdf4;
        }

        .notification-box.warning {
            border-color: #f59e0b;
            background-color: #fffbeb;
        }

        .notification-box.danger {
            border-color: #ef4444;
            background-color: #fef2f2;
        }

        .notification-title {
            font-size: 20px;
            font-weight: 700;
            color: #1f2937;
            margin: 0 0 10px 0;
        }

        .notification-message {
            font-size: 16px;
            color: #4b5563;
            margin: 0;
        }

        .button {
            display: inline-block;
            padding: 14px 28px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            margin-top: 20px;
            transition: transform 0.2s;
        }

        .button:hover {
            transform: translateY(-2px);
        }

        .info-section {
            background-color: #f9fafb;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: #6b7280;
            font-size: 14px;
        }

        .info-value {
            color: #1f2937;
            font-size: 14px;
        }

        .footer {
            background-color: #f9fafb;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }

        .footer p {
            margin: 5px 0;
            color: #6b7280;
            font-size: 14px;
        }

        .footer-links {
            margin-top: 15px;
        }

        .footer-links a {
            color: #667eea;
            text-decoration: none;
            margin: 0 10px;
            font-size: 13px;
        }

        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge.info {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .badge.success {
            background-color: #d1fae5;
            color: #065f46;
        }

        .badge.warning {
            background-color: #fef3c7;
            color: #92400e;
        }

        .badge.danger {
            background-color: #fee2e2;
            color: #991b1b;
        }

        @media only screen and (max-width: 600px) {
            .container {
                margin: 20px;
                border-radius: 8px;
            }

            .header,
            .content,
            .footer {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🔔 Notifikasi BPS</h1>
            <p>Sistem Penjadwalan Pegawai</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Halo, <strong>{{ $user->name }}</strong>
            </div>

            <p style="color: #6b7280; margin-bottom: 20px;">
                Anda memiliki notifikasi baru dari Sistem Penjadwalan Pegawai BPS.
            </p>

            <!-- Notification Box -->
            <div class="notification-box {{ $notification->type }}">
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 10px;">
                    <h2 class="notification-title">{{ $notification->title }}</h2>
                    <span class="badge {{ $notification->type }}">
                        {{ strtoupper($notification->type) }}
                    </span>
                </div>
                <p class="notification-message">{{ $notification->message }}</p>
            </div>

            <!-- Action Button -->
            @if ($notification->url)
                <div style="text-align: center; margin-top: 30px;">
                    <a href="{{ config('app.url') }}{{ $notification->url }}" class="button">
                        📋 Lihat Detail
                    </a>
                </div>
            @endif

            <!-- Info Section -->
            <div class="info-section">
                <div class="info-item">
                    <span class="info-label">Tanggal & Waktu:</span>
                    <span class="info-value">{{ $notification->created_at->format('d F Y, H:i') }} WITA</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Penerima:</span>
                    <span class="info-value">{{ $user->name }} ({{ $user->role }})</span>
                </div>
                @if ($user->seksi)
                    <div class="info-item">
                        <span class="info-label">Seksi:</span>
                        <span class="info-value">{{ $user->seksi }}</span>
                    </div>
                @endif
            </div>

            <p
                style="color: #9ca3af; font-size: 13px; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
                💡 <strong>Tips:</strong> Anda dapat melihat semua notifikasi di dashboard dengan mengklik menu
                "Notifikasi" atau ikon lonceng di bagian atas.
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p style="margin-bottom: 15px;">
                <strong>Badan Pusat Statistik</strong><br>
                Sistem Penjadwalan Pegawai
            </p>
            <p style="font-size: 12px; color: #9ca3af;">
                Email ini dikirim secara otomatis oleh sistem. Mohon tidak membalas email ini.
            </p>
            <div class="footer-links">
                <a href="{{ config('app.url') }}">Dashboard</a>
                <a href="{{ config('app.url') }}/pegawai/jadwal">Jadwal</a>
                <a href="{{ config('app.url') }}/pegawai/notifications">Notifikasi</a>
            </div>
            <p style="font-size: 11px; color: #d1d5db; margin-top: 20px;">
                © {{ date('Y') }} Badan Pusat Statistik. All rights reserved.
            </p>
        </div>
    </div>
</body>

</html>
