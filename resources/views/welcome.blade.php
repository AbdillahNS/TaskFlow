<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }} - TaskFlow</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
        <style>
            :root {
                --bg: #f5efe6;
                --panel: rgba(255, 255, 255, 0.72);
                --panel-strong: #fffaf4;
                --text: #1f1b17;
                --muted: #6b6259;
                --brand: #f97316;
                --brand-dark: #c2410c;
                --accent: #0f766e;
                --line: rgba(31, 27, 23, 0.12);
                --shadow: 0 24px 80px rgba(60, 38, 18, 0.14);
            }

            * { box-sizing: border-box; }
            html { scroll-behavior: smooth; }
            body {
                margin: 0;
                font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
                color: var(--text);
                background:
                    radial-gradient(circle at top left, rgba(249, 115, 22, 0.20), transparent 32%),
                    radial-gradient(circle at right center, rgba(15, 118, 110, 0.16), transparent 28%),
                    linear-gradient(180deg, #fffaf4 0%, var(--bg) 100%);
                min-height: 100vh;
            }

            .shell {
                position: relative;
                overflow: hidden;
            }

            .shell::before,
            .shell::after {
                content: '';
                position: absolute;
                width: 24rem;
                height: 24rem;
                border-radius: 999px;
                filter: blur(24px);
                opacity: 0.45;
                z-index: 0;
            }

            .shell::before {
                top: -7rem;
                right: -6rem;
                background: rgba(249, 115, 22, 0.18);
            }

            .shell::after {
                left: -7rem;
                bottom: -9rem;
                background: rgba(15, 118, 110, 0.16);
            }

            .container {
                position: relative;
                z-index: 1;
                width: min(1120px, calc(100% - 2rem));
                margin: 0 auto;
                padding: 1.25rem 0 3rem;
            }

            .topbar {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 1rem;
                padding: 0.25rem 0 2rem;
            }

            .brand {
                display: inline-flex;
                align-items: center;
                gap: 0.85rem;
                text-decoration: none;
                color: inherit;
            }

            .brand-mark {
                width: 3rem;
                height: 3rem;
                border-radius: 1rem;
                display: grid;
                place-items: center;
                background: linear-gradient(135deg, var(--brand), #fb7185);
                color: white;
                box-shadow: 0 18px 30px rgba(249, 115, 22, 0.25);
                font-weight: 700;
                letter-spacing: -0.04em;
            }

            .brand-text strong {
                display: block;
                font-size: 1.05rem;
                line-height: 1.1;
            }

            .brand-text span {
                color: var(--muted);
                font-size: 0.93rem;
            }

            .actions {
                display: flex;
                gap: 0.75rem;
                flex-wrap: wrap;
            }

            .btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
                border-radius: 999px;
                padding: 0.85rem 1.25rem;
                text-decoration: none;
                font-weight: 600;
                border: 1px solid transparent;
                transition: transform 160ms ease, box-shadow 160ms ease, background 160ms ease, border-color 160ms ease;
            }

            .btn:hover { transform: translateY(-1px); }

            .btn-primary {
                background: linear-gradient(135deg, var(--brand), #ea580c);
                color: white;
                box-shadow: 0 16px 34px rgba(249, 115, 22, 0.25);
            }

            .btn-secondary {
                background: rgba(255, 255, 255, 0.76);
                color: var(--text);
                border-color: var(--line);
                backdrop-filter: blur(12px);
            }

            .hero {
                display: grid;
                grid-template-columns: 1.15fr 0.85fr;
                gap: 1.5rem;
                align-items: stretch;
            }

            .panel {
                background: var(--panel);
                backdrop-filter: blur(18px);
                border: 1px solid rgba(255, 255, 255, 0.68);
                border-radius: 1.75rem;
                box-shadow: var(--shadow);
            }

            .hero-copy {
                padding: 3rem;
            }

            .eyebrow {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.5rem 0.85rem;
                border-radius: 999px;
                background: rgba(249, 115, 22, 0.1);
                color: var(--brand-dark);
                font-weight: 600;
                font-size: 0.92rem;
            }

            .hero h1 {
                margin: 1rem 0 0.9rem;
                font-size: clamp(2.5rem, 6vw, 4.8rem);
                line-height: 0.96;
                letter-spacing: -0.06em;
            }

            .hero p {
                margin: 0;
                max-width: 58ch;
                color: var(--muted);
                font-size: 1.05rem;
                line-height: 1.7;
            }

            .hero-actions {
                display: flex;
                gap: 0.9rem;
                flex-wrap: wrap;
                margin: 1.7rem 0 2rem;
            }

            .mini-stats {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 0.9rem;
            }

            .stat {
                border-radius: 1.25rem;
                background: rgba(255, 255, 255, 0.75);
                border: 1px solid rgba(31, 27, 23, 0.08);
                padding: 1rem;
            }

            .stat strong {
                display: block;
                font-size: 1.45rem;
                letter-spacing: -0.04em;
            }

            .stat span {
                color: var(--muted);
                font-size: 0.92rem;
            }

            .side {
                padding: 1.25rem;
                display: grid;
                gap: 1rem;
            }

            .role-card {
                border-radius: 1.5rem;
                padding: 1.3rem;
                background: linear-gradient(180deg, rgba(255,255,255,0.88), rgba(255,255,255,0.68));
                border: 1px solid rgba(31, 27, 23, 0.08);
            }

            .role-card h2 {
                margin: 0 0 0.45rem;
                font-size: 1.05rem;
            }

            .role-card p {
                margin: 0;
                color: var(--muted);
                font-size: 0.96rem;
                line-height: 1.6;
            }

            .role-badge {
                display: inline-flex;
                align-items: center;
                padding: 0.45rem 0.8rem;
                border-radius: 999px;
                font-size: 0.82rem;
                font-weight: 700;
                letter-spacing: 0.02em;
                margin-bottom: 0.9rem;
            }

            .badge-admin { background: rgba(249, 115, 22, 0.12); color: var(--brand-dark); }
            .badge-pegawai { background: rgba(15, 118, 110, 0.12); color: var(--accent); }

            .workflow {
                margin-top: 1.5rem;
                display: grid;
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 1rem;
            }

            .step {
                padding: 1.2rem;
                border-radius: 1.25rem;
                background: rgba(255, 255, 255, 0.68);
                border: 1px solid rgba(31, 27, 23, 0.08);
            }

            .step .num {
                display: inline-flex;
                width: 2rem;
                height: 2rem;
                align-items: center;
                justify-content: center;
                border-radius: 999px;
                background: linear-gradient(135deg, var(--brand), #fb7185);
                color: white;
                font-weight: 700;
                margin-bottom: 0.8rem;
            }

            .step h3 {
                margin: 0 0 0.5rem;
                font-size: 1rem;
            }

            .step p {
                margin: 0;
                font-size: 0.95rem;
                color: var(--muted);
                line-height: 1.6;
            }

            .section-title {
                display: flex;
                justify-content: space-between;
                align-items: end;
                gap: 1rem;
                margin: 2rem 0 1rem;
            }

            .section-title h2 {
                margin: 0;
                font-size: 1.55rem;
                letter-spacing: -0.04em;
            }

            .section-title span {
                color: var(--muted);
                font-size: 0.95rem;
            }

            .feature-grid {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 1rem;
            }

            .feature {
                padding: 1.25rem;
                border-radius: 1.25rem;
                background: var(--panel-strong);
                border: 1px solid rgba(31, 27, 23, 0.08);
            }

            .feature svg {
                margin-bottom: 0.85rem;
            }

            .feature h3 {
                margin: 0 0 0.45rem;
                font-size: 1.02rem;
            }

            .feature p {
                margin: 0;
                color: var(--muted);
                line-height: 1.6;
            }

            .footer-cta {
                margin-top: 1.5rem;
                padding: 1.4rem 1.5rem;
                border-radius: 1.5rem;
                background: linear-gradient(135deg, rgba(249, 115, 22, 0.14), rgba(15, 118, 110, 0.14));
                border: 1px solid rgba(31, 27, 23, 0.08);
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 1rem;
                flex-wrap: wrap;
            }

            .footer-cta strong {
                display: block;
                font-size: 1.05rem;
                margin-bottom: 0.25rem;
            }

            .footer-cta span {
                color: var(--muted);
            }

            @media (max-width: 960px) {
                .hero,
                .workflow,
                .feature-grid {
                    grid-template-columns: 1fr;
                }

                .topbar,
                .section-title,
                .footer-cta {
                    align-items: flex-start;
                }

                .hero-copy {
                    padding: 2rem;
                }

                .mini-stats {
                    grid-template-columns: 1fr;
                }
            }

            @media (max-width: 640px) {
                .container {
                    width: min(100% - 1rem, 1120px);
                    padding-top: 0.75rem;
                }

                .topbar {
                    flex-direction: column;
                    align-items: flex-start;
                }

                .hero-copy {
                    padding: 1.5rem;
                }
            }
        </style>
    </head>
    <body>
        <div class="shell">
            <div class="container">
                <header class="topbar">
                    <a class="brand" href="{{ url('/') }}">
                        <span class="brand-mark">TF</span>
                        <span class="brand-text">
                            <strong>TaskFlow</strong>
                            <span>Admin dan pegawai dalam satu alur kerja</span>
                        </span>
                    </a>

                    @if (Route::has('login'))
                        <nav class="actions">
                            @auth
                                <a class="btn btn-primary" href="{{ url('/dashboard') }}">Masuk Dashboard</a>
                            @else
                                <a class="btn btn-secondary" href="{{ route('login') }}">Login</a>
                                @if (Route::has('register'))
                                    <a class="btn btn-primary" href="{{ route('register') }}">Daftar</a>
                                @endif
                            @endauth
                        </nav>
                    @endif
                </header>

                <main class="hero">
                    <section class="panel hero-copy">
                        <span class="eyebrow">Task management untuk admin / manajer dan pegawai</span>
                        <h1>Kelola tugas dari penugasan sampai selesai, tanpa berantakan.</h1>
                        <p>
                            TaskFlow membantu admin memberi tugas, memantau progres, dan menyusun seluruh pekerjaan
                            secara terpusat. Pegawai menerima tugas, melihat daftar pekerjaan, lalu menandai tugas
                            ketika sudah selesai.
                        </p>

                        <div class="hero-actions">
                            <a class="btn btn-primary" href="{{ route('login') }}">Mulai Login</a>
                            @if (Route::has('register'))
                                <a class="btn btn-secondary" href="{{ route('register') }}">Buat Akun</a>
                            @endif
                        </div>

                        <div class="mini-stats">
                            <div class="stat">
                                <strong>2 Role</strong>
                                <span>Admin / Manajer dan Pegawai</span>
                            </div>
                            <div class="stat">
                                <strong>CRUD Task</strong>
                                <span>Buat, ubah, hapus, pantau tugas</span>
                            </div>
                            <div class="stat">
                                <strong>Status Real</strong>
                                <span>Menunggu, dikerjakan, selesai</span>
                            </div>
                        </div>
                    </section>

                    <aside class="panel side">
                        <div class="role-card">
                            <span class="role-badge badge-admin">Admin / Manajer</span>
                            <h2>Membuat dan memantau tugas</h2>
                            <p>
                                Admin menambahkan tugas, mengedit detail, menentukan pegawai, lalu melihat seluruh
                                progres pekerjaan dari satu dashboard.
                            </p>
                        </div>

                        <div class="role-card">
                            <span class="role-badge badge-pegawai">Pegawai</span>
                            <h2>Menerima dan menyelesaikan tugas</h2>
                            <p>
                                Pegawai hanya fokus pada tugas yang diberikan. Setelah selesai, status bisa langsung
                                diperbarui agar admin tahu pekerjaan sudah tuntas.
                            </p>
                        </div>

                        <div class="role-card">
                            <h2>Alur kerja cepat</h2>
                            <p>
                                Login, lihat daftar tugas, kerjakan, lalu selesaikan. Semua alur dibuat sederhana
                                agar operasional tetap rapi.
                            </p>
                        </div>
                    </aside>
                </main>

                <section>
                    <div class="section-title">
                        <h2>Alur TaskFlow</h2>
                        <span>Langkah kerja dari admin ke pegawai</span>
                    </div>

                    <div class="workflow">
                        <article class="step">
                            <span class="num">1</span>
                            <h3>Admin membuat tugas</h3>
                            <p>Admin input detail tugas, memilih pegawai, dan menentukan prioritas kerja.</p>
                        </article>

                        <article class="step">
                            <span class="num">2</span>
                            <h3>Task masuk ke pegawai</h3>
                            <p>Pegawai melihat tugas yang ditugaskan kepadanya di halaman pegawai.</p>
                        </article>

                        <article class="step">
                            <span class="num">3</span>
                            <h3>Pegawai menyelesaikan</h3>
                            <p>Setelah dikerjakan, pegawai menandai tugas sebagai selesai.</p>
                        </article>

                        <article class="step">
                            <span class="num">4</span>
                            <h3>Admin memantau</h3>
                            <p>Admin memantau progres dan status keseluruhan tugas secara real time.</p>
                        </article>
                    </div>
                </section>

                <section>
                    <div class="section-title">
                        <h2>Fitur Utama</h2>
                        <span>Fokus untuk kebutuhan operasional TaskFlow</span>
                    </div>

                    <div class="feature-grid">
                        <article class="feature">
                            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <rect x="4" y="4" width="32" height="32" rx="10" fill="rgba(249,115,22,0.12)"/>
                                <path d="M12 20H28M20 12V28" stroke="#c2410c" stroke-width="2.25" stroke-linecap="round"/>
                            </svg>
                            <h3>CRUD Tugas</h3>
                            <p>Admin bisa membuat, mengubah, melihat, dan menghapus tugas dengan mudah.</p>
                        </article>

                        <article class="feature">
                            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <rect x="4" y="4" width="32" height="32" rx="10" fill="rgba(15,118,110,0.12)"/>
                                <path d="M12 20L17 25L28 14" stroke="#0f766e" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <h3>Status Penyelesaian</h3>
                            <p>Pegawai menandai task selesai supaya progres langsung terlihat oleh admin.</p>
                        </article>

                        <article class="feature">
                            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <rect x="4" y="4" width="32" height="32" rx="10" fill="rgba(59,130,246,0.12)"/>
                                <path d="M12 25C14.5 21.5 17 20 20 20C23 20 25.5 21.5 28 25" stroke="#2563eb" stroke-width="2.25" stroke-linecap="round"/>
                                <circle cx="16" cy="16" r="2" fill="#2563eb"/>
                                <circle cx="24" cy="16" r="2" fill="#2563eb"/>
                            </svg>
                            <h3>Monitoring Terpusat</h3>
                            <p>Admin memantau semua tugas dan pegawai dari satu halaman kontrol.</p>
                        </article>
                    </div>
                </section>

                <div class="footer-cta">
                    <div>
                        <strong>Mulai dari halaman login atau daftar dulu.</strong>
                        <span>Setelah itu kita lanjut ke dashboard admin dan halaman pegawai.</span>
                    </div>

                    @if (Route::has('login'))
                        <div class="actions">
                            <a class="btn btn-secondary" href="{{ route('login') }}">Login</a>
                            @if (Route::has('register'))
                                <a class="btn btn-primary" href="{{ route('register') }}">Register</a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </body>
</html>