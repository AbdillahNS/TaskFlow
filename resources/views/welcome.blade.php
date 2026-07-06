<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TaskFlow — Kelola Tugas Tim dengan Mudah</title>
    <meta name="description" content="Platform manajemen tugas untuk admin dan pegawai. Assign, monitor, dan selesaikan tugas dalam satu sistem yang simpel.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Inter', sans-serif;
            background: #f8f7ff;
            color: #1e1b4b;
            overflow-x: hidden;
        }

        /* ── Animated gradient blob background ── */
        .bg-blobs {
            position: fixed; inset: 0; z-index: 0; pointer-events: none; overflow: hidden;
        }
        .blob {
            position: absolute; border-radius: 50%; filter: blur(80px); opacity: 0.35;
            animation: blobFloat 10s ease-in-out infinite;
        }
        .blob-1 { width: 600px; height: 600px; background: #818cf8; top: -200px; left: -150px; animation-delay: 0s; }
        .blob-2 { width: 500px; height: 500px; background: #a78bfa; top: 30%; right: -100px; animation-delay: 3s; }
        .blob-3 { width: 400px; height: 400px; background: #6366f1; bottom: -100px; left: 30%; animation-delay: 6s; }

        @keyframes blobFloat {
            0%,100% { transform: translateY(0) scale(1); }
            50%      { transform: translateY(-30px) scale(1.05); }
        }

        /* ── Layout ── */
        .wrapper { position: relative; z-index: 1; max-width: 1200px; margin: 0 auto; padding: 0 24px; }

        /* ── Navbar ── */
        nav {
            position: sticky; top: 0; z-index: 100;
            background: rgba(248, 247, 255, 0.85);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(99, 102, 241, 0.12);
        }
        .nav-inner {
            max-width: 1200px; margin: 0 auto; padding: 0 24px;
            display: flex; align-items: center; justify-content: space-between;
            height: 68px; gap: 16px;
        }
        .nav-logo {
            display: flex; align-items: center; gap: 10px;
            text-decoration: none;
        }
        .nav-logo-icon {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 8px 20px rgba(99,102,241,0.3);
        }
        .nav-logo-text {
            font-size: 1.2rem; font-weight: 800;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .nav-actions { display: flex; align-items: center; gap: 10px; }

        .btn {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 10px 20px; border-radius: 12px;
            font-size: 0.875rem; font-weight: 600;
            text-decoration: none; border: none; cursor: pointer;
            transition: all 0.2s ease;
        }
        .btn-outline {
            border: 1.5px solid rgba(99,102,241,0.3);
            color: #6366f1; background: transparent;
        }
        .btn-outline:hover { background: rgba(99,102,241,0.08); border-color: #6366f1; }

        .btn-primary {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            box-shadow: 0 6px 20px rgba(99,102,241,0.35);
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(99,102,241,0.45);
        }

        /* ── Hero ── */
        .hero {
            padding: 100px 0 80px;
            text-align: center;
        }
        .hero-eyebrow {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(99,102,241,0.1); border: 1px solid rgba(99,102,241,0.2);
            color: #6366f1; font-size: 0.8rem; font-weight: 700;
            padding: 6px 16px; border-radius: 999px;
            letter-spacing: 0.05em; text-transform: uppercase;
            margin-bottom: 28px;
            animation: fadeSlideDown 0.6s ease both;
        }
        .hero-title {
            font-size: clamp(2.8rem, 6vw, 5rem);
            font-weight: 900;
            line-height: 1.05;
            letter-spacing: -0.04em;
            color: #1e1b4b;
            animation: fadeSlideDown 0.7s ease 0.1s both;
        }
        .hero-title .gradient-text {
            background: linear-gradient(135deg, #6366f1, #a855f7, #ec4899);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .hero-desc {
            margin: 24px auto 40px;
            max-width: 580px;
            font-size: 1.1rem;
            color: #6b7280;
            line-height: 1.75;
            animation: fadeSlideDown 0.8s ease 0.2s both;
        }
        .hero-cta {
            display: flex; align-items: center; justify-content: center;
            gap: 14px; flex-wrap: wrap;
            animation: fadeSlideDown 0.9s ease 0.3s both;
        }
        .btn-hero {
            padding: 14px 32px; border-radius: 16px; font-size: 1rem; font-weight: 700;
        }

        @keyframes fadeSlideDown {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Stats bar ── */
        .stats-bar {
            display: flex; align-items: center; justify-content: center;
            gap: 40px; flex-wrap: wrap;
            margin: 60px 0 0;
            padding: 28px 40px;
            background: white;
            border: 1px solid rgba(99,102,241,0.12);
            border-radius: 24px;
            box-shadow: 0 4px 24px rgba(99,102,241,0.08);
            animation: fadeSlideDown 1s ease 0.4s both;
        }
        .stat-item { text-align: center; }
        .stat-value {
            font-size: 2rem; font-weight: 900; letter-spacing: -0.04em;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .stat-label { font-size: 0.82rem; color: #9ca3af; font-weight: 500; margin-top: 2px; }
        .stat-divider { width: 1px; height: 40px; background: #e5e7eb; }

        /* ── Roles section ── */
        .section { padding: 80px 0; }
        .section-label {
            display: inline-block;
            font-size: 0.75rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.1em;
            color: #6366f1; margin-bottom: 14px;
        }
        .section-title {
            font-size: clamp(1.8rem, 3.5vw, 2.6rem);
            font-weight: 800; letter-spacing: -0.03em;
            color: #1e1b4b; line-height: 1.2;
            margin-bottom: 16px;
        }
        .section-desc { font-size: 1rem; color: #6b7280; line-height: 1.7; max-width: 520px; }

        .roles-grid {
            display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-top: 48px;
        }
        .role-card {
            background: white;
            border: 1px solid rgba(99,102,241,0.12);
            border-radius: 24px;
            padding: 32px;
            position: relative; overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .role-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 48px rgba(99,102,241,0.14);
        }
        .role-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
        }
        .role-admin::before { background: linear-gradient(90deg, #6366f1, #8b5cf6); }
        .role-pegawai::before { background: linear-gradient(90deg, #10b981, #06b6d4); }

        .role-icon {
            width: 52px; height: 52px; border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; margin-bottom: 20px;
        }
        .role-icon-admin   { background: rgba(99,102,241,0.1); }
        .role-icon-pegawai { background: rgba(16,185,129,0.1); }

        .role-badge {
            display: inline-flex; align-items: center;
            padding: 4px 12px; border-radius: 999px;
            font-size: 0.75rem; font-weight: 700;
            margin-bottom: 12px;
        }
        .badge-admin   { background: rgba(99,102,241,0.1);  color: #6366f1; }
        .badge-pegawai { background: rgba(16,185,129,0.1);  color: #10b981; }

        .role-title { font-size: 1.25rem; font-weight: 700; color: #1e1b4b; margin-bottom: 10px; }
        .role-desc  { font-size: 0.9rem; color: #6b7280; line-height: 1.7; margin-bottom: 20px; }

        .role-features { list-style: none; space-y: 8px; }
        .role-features li {
            display: flex; align-items: center; gap: 8px;
            font-size: 0.875rem; color: #4b5563;
            padding: 4px 0;
        }
        .role-features li::before {
            content: ''; width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0;
        }
        .admin-feat li::before   { background: #6366f1; }
        .pegawai-feat li::before { background: #10b981; }

        /* ── Workflow steps ── */
        .steps-grid {
            display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;
            margin-top: 48px; position: relative;
        }
        .steps-grid::before {
            content: ''; position: absolute;
            top: 32px; left: calc(12.5% + 24px); right: calc(12.5% + 24px);
            height: 2px; background: linear-gradient(90deg, #e5e7eb, #c7d2fe, #e5e7eb);
            z-index: 0;
        }
        .step-card {
            background: white; border: 1px solid rgba(99,102,241,0.1);
            border-radius: 20px; padding: 28px 22px;
            text-align: center; position: relative; z-index: 1;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .step-card:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(99,102,241,0.12); }
        .step-num {
            width: 48px; height: 48px; border-radius: 14px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white; font-size: 1.2rem; font-weight: 800;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 18px; box-shadow: 0 8px 20px rgba(99,102,241,0.3);
        }
        .step-icon { font-size: 1.8rem; margin-bottom: 12px; display: block; }
        .step-title { font-size: 0.95rem; font-weight: 700; color: #1e1b4b; margin-bottom: 8px; }
        .step-desc  { font-size: 0.83rem; color: #6b7280; line-height: 1.6; }

        /* ── Features ── */
        .features-grid {
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;
            margin-top: 48px;
        }
        .feature-card {
            background: white; border: 1px solid rgba(99,102,241,0.1);
            border-radius: 20px; padding: 28px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .feature-card:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(99,102,241,0.12); }
        .feature-icon {
            width: 48px; height: 48px; border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem; margin-bottom: 18px;
        }
        .feature-title { font-size: 1rem; font-weight: 700; color: #1e1b4b; margin-bottom: 8px; }
        .feature-desc  { font-size: 0.87rem; color: #6b7280; line-height: 1.65; }

        /* ── CTA section ── */
        .cta-section {
            margin: 0 0 80px;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #6d28d9 100%);
            border-radius: 32px; padding: 64px 48px;
            text-align: center; position: relative; overflow: hidden;
        }
        .cta-section::before {
            content: ''; position: absolute; inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='30' cy='30' r='28' stroke='rgba(255,255,255,0.05)' fill='none'/%3E%3C/svg%3E") 0 0/60px 60px;
        }
        .cta-title { font-size: 2.5rem; font-weight: 900; color: white; margin-bottom: 16px; line-height: 1.15; }
        .cta-desc  { color: rgba(255,255,255,0.75); font-size: 1rem; max-width: 480px; margin: 0 auto 36px; line-height: 1.7; }
        .cta-buttons { display: flex; align-items: center; justify-content: center; gap: 14px; flex-wrap: wrap; }
        .btn-cta-white {
            background: white; color: #6366f1; font-weight: 700;
            padding: 14px 32px; border-radius: 14px; font-size: 0.95rem;
            text-decoration: none;
            transition: all 0.2s ease;
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        }
        .btn-cta-white:hover { transform: translateY(-2px); box-shadow: 0 14px 32px rgba(0,0,0,0.2); }
        .btn-cta-ghost {
            background: rgba(255,255,255,0.15); color: white; font-weight: 600;
            padding: 14px 32px; border-radius: 14px; font-size: 0.95rem;
            border: 1px solid rgba(255,255,255,0.3);
            text-decoration: none; backdrop-filter: blur(8px);
            transition: all 0.2s ease;
        }
        .btn-cta-ghost:hover { background: rgba(255,255,255,0.25); }

        /* ── Footer ── */
        footer {
            border-top: 1px solid rgba(99,102,241,0.1);
            padding: 32px 0;
            text-align: center;
            color: #9ca3af; font-size: 0.85rem;
        }
        .footer-logo {
            display: inline-flex; align-items: center; gap: 8px;
            margin-bottom: 12px; text-decoration: none;
        }
        .footer-logo-icon {
            width: 28px; height: 28px; border-radius: 8px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            display: flex; align-items: center; justify-content: center;
        }
        .footer-logo-text {
            font-weight: 800; font-size: 0.95rem;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }

        /* ── Responsive ── */
        @media (max-width: 900px) {
            .roles-grid, .features-grid { grid-template-columns: 1fr; }
            .steps-grid { grid-template-columns: 1fr 1fr; }
            .steps-grid::before { display: none; }
            .stat-divider { display: none; }
            .stats-bar { gap: 24px; padding: 24px; }
            .cta-section { padding: 48px 24px; }
            .cta-title { font-size: 2rem; }
        }
        @media (max-width: 600px) {
            .hero { padding: 60px 0 40px; }
            .steps-grid { grid-template-columns: 1fr; }
            .btn-hero { padding: 12px 24px; font-size: 0.9rem; }
            .section { padding: 56px 0; }
        }
    </style>
</head>
<body>

    <!-- Animated blobs -->
    <div class="bg-blobs">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div class="blob blob-3"></div>
    </div>

    <!-- ── NAVBAR ── -->
    <nav>
        <div class="nav-inner">
            <a href="{{ url('/') }}" class="nav-logo">
                <div class="nav-logo-icon">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:22px;height:22px;color:white">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
                <span class="nav-logo-text">TaskFlow</span>
            </a>
            <div class="nav-actions">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-primary">
                        <svg style="width:16px;height:16px" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Masuk Dashboard
                    </a>
                @else
                    @if(Route::has('login'))
                        <a href="{{ route('login') }}" class="btn btn-outline">Masuk</a>
                    @endif
                    @if(Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-primary">
                            Daftar Gratis
                            <svg style="width:14px;height:14px" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </nav>

    <!-- ── HERO ── -->
    <section class="section" style="padding-top: 80px; padding-bottom: 0;">
        <div class="wrapper">
            <div class="hero" style="padding: 60px 0 0;">
                <div class="hero-eyebrow">
                    ✨ Platform Manajemen Tugas Modern
                </div>
                <h1 class="hero-title">
                    Kelola Tugas Tim<br>
                    <span class="gradient-text">Lebih Cerdas & Efisien</span>
                </h1>
                <p class="hero-desc">
                    TaskFlow menghubungkan <strong>Admin/Manajer</strong> dengan <strong>Pegawai</strong> dalam satu sistem yang simpel.
                    Assign tugas, pantau progress, dan selesaikan — semuanya dalam satu platform.
                </p>
                <div class="hero-cta">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-hero">
                            Buka Dashboard Saya
                            <svg style="width:18px;height:18px" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-hero">
                            Mulai Sekarang
                            <svg style="width:18px;height:18px" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                        @if(Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-outline btn-hero" style="background:white;">
                                Buat Akun Gratis
                            </a>
                        @endif
                    @endauth
                </div>

                <!-- Stats bar -->
                <div class="stats-bar">
                    <div class="stat-item">
                        <div class="stat-value">2</div>
                        <div class="stat-label">Tipe User</div>
                    </div>
                    <div class="stat-divider"></div>
                    <div class="stat-item">
                        <div class="stat-value">3</div>
                        <div class="stat-label">Status Tugas</div>
                    </div>
                    <div class="stat-divider"></div>
                    <div class="stat-item">
                        <div class="stat-value">CRUD</div>
                        <div class="stat-label">Manajemen Tugas</div>
                    </div>
                    <div class="stat-divider"></div>
                    <div class="stat-item">
                        <div class="stat-value">Real-time</div>
                        <div class="stat-label">Progress Monitor</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ── ROLES ── -->
    <section class="section">
        <div class="wrapper">
            <div style="text-align:center; max-width:600px; margin:0 auto;">
                <div class="section-label">👥 Dua Peran Utama</div>
                <h2 class="section-title">Satu Platform, Dua Perspektif</h2>
                <p class="section-desc" style="margin:0 auto;">
                    TaskFlow dirancang khusus untuk dua jenis pengguna dengan tampilan dan fitur yang berbeda sesuai kebutuhan masing-masing.
                </p>
            </div>

            <div class="roles-grid">
                <!-- Admin Card -->
                <div class="role-card role-admin">
                    <div class="role-icon role-icon-admin">👑</div>
                    <span class="role-badge badge-admin">Admin / Manajer</span>
                    <h3 class="role-title">Kontrol Penuh atas Semua Tugas</h3>
                    <p class="role-desc">Admin memiliki akses penuh untuk membuat, mengatur, dan memantau seluruh tugas yang berjalan dalam tim.</p>
                    <ul class="role-features admin-feat">
                        <li>Buat & assign tugas ke pegawai</li>
                        <li>Edit dan hapus tugas kapan saja</li>
                        <li>Monitor progress semua tugas (dashboard)</li>
                        <li>Kelola akun pegawai (tambah/hapus)</li>
                        <li>Lihat statistik tugas secara real-time</li>
                    </ul>
                </div>

                <!-- Pegawai Card -->
                <div class="role-card role-pegawai">
                    <div class="role-icon role-icon-pegawai">👤</div>
                    <span class="role-badge badge-pegawai">Pegawai</span>
                    <h3 class="role-title">Fokus pada Tugas yang Diberikan</h3>
                    <p class="role-desc">Pegawai hanya melihat tugas yang diberikan kepadanya, sehingga bisa fokus bekerja tanpa distraksi.</p>
                    <ul class="role-features pegawai-feat">
                        <li>Lihat daftar tugas yang diterima</li>
                        <li>Mulai kerjakan tugas (status → Progress)</li>
                        <li>Tandai tugas selesai</li>
                        <li>Lihat deadline dan detail tugas</li>
                        <li>Dashboard progress pribadi</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- ── WORKFLOW ── -->
    <section class="section" style="background: linear-gradient(180deg, transparent, rgba(99,102,241,0.04));">
        <div class="wrapper">
            <div style="text-align:center; max-width:600px; margin:0 auto;">
                <div class="section-label">🔄 Alur Kerja</div>
                <h2 class="section-title">4 Langkah Sederhana</h2>
                <p class="section-desc" style="margin:0 auto;">
                    Dari pembuatan tugas hingga selesai, semuanya berjalan dengan alur yang jelas dan mudah diikuti.
                </p>
            </div>

            <div class="steps-grid">
                @foreach([
                    ['1', '✍️', 'Admin Buat Tugas', 'Admin mengisi judul, deskripsi, memilih pegawai, dan menetapkan deadline tugas.'],
                    ['2', '📬', 'Tugas Diterima', 'Pegawai langsung melihat tugas baru di dashboard dan halaman tugas mereka.'],
                    ['3', '⚡', 'Pegawai Kerjakan', 'Pegawai memulai tugas (status berubah jadi Progress) lalu menyelesaikannya.'],
                    ['4', '📊', 'Admin Pantau', 'Admin melihat update status tugas secara real-time dari dashboard monitoring.'],
                ] as [$num, $icon, $title, $desc])
                <div class="step-card">
                    <div class="step-num">{{ $num }}</div>
                    <span class="step-icon">{{ $icon }}</span>
                    <h4 class="step-title">{{ $title }}</h4>
                    <p class="step-desc">{{ $desc }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ── FEATURES ── -->
    <section class="section">
        <div class="wrapper">
            <div style="text-align:center; max-width:600px; margin:0 auto;">
                <div class="section-label">⚙️ Fitur Unggulan</div>
                <h2 class="section-title">Semua yang Kamu Butuhkan</h2>
                <p class="section-desc" style="margin:0 auto;">
                    Fitur-fitur yang dirancang untuk membuat pengelolaan tugas tim menjadi lebih mudah dan menyenangkan.
                </p>
            </div>

            <div class="features-grid">
                @php
                $features = [
                    ['bg'=>'rgba(99,102,241,0.1)',  'emoji'=>'📋', 'title'=>'CRUD Tugas Lengkap',      'desc'=>'Admin dapat membuat, melihat detail, mengedit, dan menghapus tugas kapan saja dengan mudah.'],
                    ['bg'=>'rgba(16,185,129,0.1)',   'emoji'=>'✅', 'title'=>'Update Status Real-Time', 'desc'=>'Pegawai memperbarui status tugas dari Pending → Progress → Selesai. Admin langsung tahu.'],
                    ['bg'=>'rgba(59,130,246,0.1)',   'emoji'=>'📊', 'title'=>'Dashboard Analitik',      'desc'=>'Statistik tugas dengan grafik progress, jumlah pending, progress, dan selesai dalam satu tampilan.'],
                    ['bg'=>'rgba(245,158,11,0.1)',   'emoji'=>'⏰', 'title'=>'Deadline Tracking',       'desc'=>'Setiap tugas dilengkapi deadline. Sistem otomatis menandai tugas yang melewati batas waktu.'],
                    ['bg'=>'rgba(139,92,246,0.1)',   'emoji'=>'👥', 'title'=>'Kelola Tim Pegawai',      'desc'=>'Admin dapat menambahkan dan menghapus akun pegawai langsung dari panel kelola pegawai.'],
                    ['bg'=>'rgba(236,72,153,0.1)',   'emoji'=>'🔔', 'title'=>'Notifikasi Toast',        'desc'=>'Setiap aksi memberikan feedback langsung melalui notifikasi toast yang muncul otomatis.'],
                ];
                @endphp
                @foreach($features as $f)
                <div class="feature-card">
                    <div class="feature-icon" style="background: {{ $f['bg'] }}; font-size: 1.4rem;">{{ $f['emoji'] }}</div>
                    <h4 class="feature-title">{{ $f['title'] }}</h4>
                    <p class="feature-desc">{{ $f['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ── CTA ── -->
    <section style="padding: 0 0 80px;">
        <div class="wrapper">
            <div class="cta-section">
                <!-- Decorative shapes -->
                <div style="position:absolute;top:-40px;right:-40px;width:180px;height:180px;border-radius:50%;background:rgba(255,255,255,0.06);"></div>
                <div style="position:absolute;bottom:-60px;left:-30px;width:240px;height:240px;border-radius:50%;background:rgba(255,255,255,0.04);"></div>

                <div style="position:relative;z-index:1;">
                    <div style="display:inline-block;background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.25);color:white;font-size:0.75rem;font-weight:700;padding:6px 16px;border-radius:999px;letter-spacing:0.08em;text-transform:uppercase;margin-bottom:20px;">
                        🚀 Siap Memulai?
                    </div>
                    <h2 class="cta-title">Mulai Kelola Tugas Tim<br>Hari Ini, Gratis!</h2>
                    <p class="cta-desc">Login dengan akun demo atau daftar sebagai admin baru untuk mulai menggunakan TaskFlow sekarang juga.</p>
                    <div class="cta-buttons">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn-cta-white">
                                Buka Dashboard →
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn-cta-white">
                                Login Sekarang →
                            </a>
                            @if(Route::has('register'))
                                <a href="{{ route('register') }}" class="btn-cta-ghost">
                                    Buat Akun Baru
                                </a>
                            @endif
                        @endauth
                    </div>

                    <!-- Demo credentials -->
                    @guest
                    <div style="margin-top:28px;display:inline-flex;gap:20px;flex-wrap:wrap;justify-content:center;">
                        <div style="background:rgba(255,255,255,0.12);border:1px solid rgba(255,255,255,0.2);border-radius:12px;padding:12px 20px;text-align:center;">
                            <p style="color:rgba(255,255,255,0.6);font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:4px;">👑 Admin Demo</p>
                            <p style="color:white;font-size:0.82rem;font-weight:600;">admin@gmail.com</p>
                            <p style="color:rgba(255,255,255,0.5);font-size:0.78rem;">password</p>
                        </div>
                        <div style="background:rgba(255,255,255,0.12);border:1px solid rgba(255,255,255,0.2);border-radius:12px;padding:12px 20px;text-align:center;">
                            <p style="color:rgba(255,255,255,0.6);font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:4px;">👤 Pegawai Demo</p>
                            <p style="color:white;font-size:0.82rem;font-weight:600;">pegawai@gmail.com</p>
                            <p style="color:rgba(255,255,255,0.5);font-size:0.78rem;">password</p>
                        </div>
                    </div>
                    @endguest
                </div>
            </div>
        </div>
    </section>

    <!-- ── FOOTER ── -->
    <footer>
        <div class="wrapper">
            <a href="{{ url('/') }}" class="footer-logo">
                <div class="footer-logo-icon">
                    <svg style="width:14px;height:14px;color:white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
                <span class="footer-logo-text">TaskFlow</span>
            </a>
            <p style="color:#9ca3af;font-size:0.82rem;">Platform manajemen tugas untuk admin dan pegawai. Dibuat dengan ❤️ menggunakan Laravel.</p>
            <p style="color:#d1d5db;font-size:0.78rem;margin-top:8px;">© {{ date('Y') }} TaskFlow. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>