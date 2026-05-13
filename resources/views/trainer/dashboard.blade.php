<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Dashboard Trainer – Kaji Indonesia</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700;800&family=Cormorant+Garamond:wght@600;700&display=swap" rel="stylesheet">
<style>
:root {
    --bg: #f8f4ef;
    --surface: #ffffff;
    --surface2: #f2ede7;
    --border: #e8e0d6;
    --accent: #2d6a4f;
    --accent-light: #e8f5e9;
    --accent2: #e76f51;
    --accent3: #457b9d;
    --warning: #f59e0b;
    --text: #1a1a2e;
    --text-muted: #7a7065;
    --radius: 16px;
    --shadow: 0 2px 16px rgba(45,106,79,.07);
}
* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: 'DM Sans', sans-serif; background: var(--bg); color: var(--text); display: flex; min-height: 100vh; }

/* ============ SIDEBAR ============ */
.sidebar { width: 265px; min-height: 100vh; background: var(--accent); display: flex; flex-direction: column; position: fixed; top: 0; left: 0; z-index: 100; }
.sidebar-brand { padding: 28px 24px 20px; border-bottom: 1px solid rgba(255,255,255,.12); }
.brand-box { display: flex; align-items: center; gap: 12px; }
.brand-icon { width: 42px; height: 42px; background: rgba(255,255,255,.15); border-radius: 12px; display: flex; align-items: center; justify-content: center; }
.brand-icon svg { color: #fff; }
.brand-name { font-family: 'Cormorant Garamond', serif; font-size: 20px; color: #fff; font-weight: 700; }
.brand-role { font-size: 11px; color: rgba(255,255,255,.6); letter-spacing: 1.5px; text-transform: uppercase; }
.nav-section { padding: 20px 16px 8px; }
.nav-label { font-size: 10px; color: rgba(255,255,255,.4); letter-spacing: 2px; text-transform: uppercase; margin-bottom: 8px; padding-left: 10px; }
.nav-item { display: flex; align-items: center; gap: 12px; padding: 11px 14px; border-radius: 12px; cursor: pointer; color: rgba(255,255,255,.7); font-size: 14px; font-weight: 500; margin-bottom: 3px; transition: all .2s; text-decoration: none; }
.nav-item:hover { background: rgba(255,255,255,.1); color: #fff; }
.nav-item.active { background: rgba(255,255,255,.18); color: #fff; font-weight: 600; }
.nav-item svg { width: 18px; height: 18px; flex-shrink: 0; }
.nav-badge { margin-left: auto; background: var(--accent2); color: #fff; font-size: 10px; font-weight: 700; padding: 2px 7px; border-radius: 20px; }
.sidebar-user { margin-top: auto; padding: 16px; border-top: 1px solid rgba(255,255,255,.12); }
.user-card { display: flex; align-items: center; gap: 12px; padding: 10px; border-radius: 12px; cursor: pointer; transition: background .2s; }
.user-card:hover { background: rgba(255,255,255,.1); }
.user-avatar { width: 40px; height: 40px; border-radius: 12px; background: rgba(255,255,255,.2); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px; color: #fff; flex-shrink: 0; border: 2px solid rgba(255,255,255,.3); overflow: hidden; }
.user-avatar img { width: 100%; height: 100%; object-fit: cover; }
.user-name { font-size: 13px; font-weight: 600; color: #fff; }
.user-role { font-size: 11px; color: rgba(255,255,255,.55); }

/* ============ MAIN ============ */
.main { margin-left: 265px; flex: 1; }
.topbar { background: var(--surface); border-bottom: 1px solid var(--border); padding: 16px 32px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 50; box-shadow: var(--shadow); }
.topbar-title { font-family: 'Cormorant Garamond', serif; font-size: 24px; font-weight: 700; color: var(--text); }

.btn { display: inline-flex; align-items: center; gap: 8px; padding: 9px 18px; border-radius: 10px; font-size: 13px; font-weight: 600; border: none; cursor: pointer; transition: all .2s; font-family: inherit; text-decoration: none; }
.btn-primary { background: var(--accent); color: #fff; }
.btn-primary:hover { background: #1f4e37; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(45,106,79,.3); }
.btn-secondary { background: var(--accent3); color: #fff; }
.btn-secondary:hover { background: #2e5a7a; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(69,123,157,.3); }
.btn-ghost { background: var(--surface2); color: var(--text); border: 1px solid var(--border); }
.btn-ghost:hover { background: var(--border); }
.btn-danger { background: #fff0ed; color: var(--accent2); border: 1px solid #e76f5166; }
.btn-danger:hover { background: var(--accent2); color: #fff; }
.btn-sm { padding: 6px 14px; font-size: 12px; border-radius: 8px; }
.btn-outline { background: transparent; border: 1.5px solid var(--accent); color: var(--accent); }
.btn-outline:hover { background: var(--accent); color: #fff; }

.content { padding: 32px; }

/* ============ STATS ============ */
.stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 32px; }
.stat-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 22px; box-shadow: var(--shadow); position: relative; overflow: hidden; }
.stat-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; }
.stat-card.green::before { background: linear-gradient(90deg, var(--accent), #52b788); }
.stat-card.teal::before { background: linear-gradient(90deg, #0d9488, #34d399); }
.stat-card.blue::before { background: linear-gradient(90deg, var(--accent3), #60a5fa); }
.stat-card.orange::before { background: linear-gradient(90deg, var(--accent2), #f4a261); }
.stat-icon { width: 42px; height: 42px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 18px; margin-bottom: 12px; }
.stat-card.green .stat-icon { background: var(--accent-light); }
.stat-card.teal .stat-icon { background: #e6faf8; }
.stat-card.blue .stat-icon { background: #e3f0fa; }
.stat-card.orange .stat-icon { background: #fff0ed; }
.stat-label { font-size: 12px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; }
.stat-value { font-size: 30px; font-weight: 800; color: var(--text); }
.stat-sub { font-size: 12px; color: var(--text-muted); margin-top: 4px; }

/* ============ SECTION ============ */
.section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; }
.section-title { font-size: 16px; font-weight: 700; }
.section-title span { color: var(--text-muted); font-weight: 400; font-size: 14px; margin-left: 8px; }
.section-actions { display: flex; gap: 10px; align-items: center; }

/* ============ TABLE ============ */
.table-wrap { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; margin-bottom: 28px; box-shadow: var(--shadow); }
table { width: 100%; border-collapse: collapse; }
thead th { padding: 14px 18px; text-align: left; font-size: 11px; letter-spacing: 1.5px; text-transform: uppercase; color: var(--text-muted); background: var(--surface2); border-bottom: 1px solid var(--border); }
tbody tr { border-bottom: 1px solid var(--border); transition: background .15s; }
tbody tr:last-child { border-bottom: none; }
tbody tr:hover { background: #f9f7f4; }
tbody td { padding: 14px 18px; font-size: 13px; }

.badge { display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
.badge-pending  { background: #fffbea; color: var(--warning); border: 1px solid #fcd34d66; }
.badge-approved { background: var(--accent-light); color: var(--accent); border: 1px solid #a7d7c566; }
.badge-rejected { background: #fff0ed; color: var(--accent2); border: 1px solid #e76f5166; }
.badge-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }

.chip { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; background: var(--surface2); color: var(--text-muted); border: 1px solid var(--border); text-transform: capitalize; }
.chip-kurikulum { background: #e3f0fa; color: var(--accent3); border-color: #bdd5ea; }
.chip-materi    { background: var(--accent-light); color: var(--accent); border-color: #a7d7c5; }

/* ============ CARD GRID ============ */
.card-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; margin-bottom: 28px; }
.item-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; transition: all .2s; box-shadow: var(--shadow); }
.item-card:hover { border-color: var(--accent); transform: translateY(-2px); box-shadow: 0 8px 30px rgba(45,106,79,.12); }
.item-card-img { width: 100%; height: 140px; background: var(--surface2); display: flex; align-items: center; justify-content: center; font-size: 40px; overflow: hidden; }
.item-card-img img { width: 100%; height: 100%; object-fit: cover; }
.item-card-body { padding: 16px; }
.item-card-title { font-size: 14px; font-weight: 700; margin-bottom: 4px; }
.item-card-meta  { font-size: 11px; color: var(--text-muted); margin-bottom: 8px; display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
.item-card-desc { font-size: 12px; color: var(--text-muted); line-height: 1.6; margin-bottom: 12px; }
.item-card-footer { display: flex; align-items: center; justify-content: space-between; }
.btn-icon { width: 30px; height: 30px; border-radius: 8px; border: 1px solid var(--border); background: var(--surface2); color: var(--text-muted); display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all .2s; font-size: 13px; }
.btn-icon:hover { background: var(--accent-light); border-color: var(--accent); }
.btn-icon-danger:hover { background: #fff0ed; border-color: var(--accent2); }

/* ── Kartu materi di bawah kurikulum ── */
.kurikulum-block { margin-bottom: 28px; }
.kurikulum-block-header {
    background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius) var(--radius) 0 0;
    padding: 16px 20px; display: flex; align-items: center; gap: 12px;
}
.kurikulum-block-header .k-title { font-size: 15px; font-weight: 700; flex: 1; }
.kurikulum-block-header .k-meta { font-size: 12px; color: var(--text-muted); display: flex; gap: 12px; }
.materi-list { border: 1px solid var(--border); border-top: none; border-radius: 0 0 var(--radius) var(--radius); overflow: hidden; }
.materi-row { display: flex; align-items: center; gap: 14px; padding: 12px 20px; border-bottom: 1px solid var(--border); background: var(--surface); transition: background .15s; }
.materi-row:last-child { border-bottom: none; }
.materi-row:hover { background: #f9f7f4; }
.materi-num { width: 26px; height: 26px; border-radius: 8px; background: var(--surface2); border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; color: var(--text-muted); flex-shrink: 0; }
.materi-info { flex: 1; }
.materi-title { font-size: 13px; font-weight: 600; }
.materi-meta { font-size: 11px; color: var(--text-muted); margin-top: 2px; display: flex; gap: 8px; }
.tipe-icon { font-size: 14px; }

/* ============ PROFILE ============ */
.profile-hero { background: linear-gradient(135deg, var(--accent) 0%, #1b4332 100%); border-radius: var(--radius); padding: 32px; margin-bottom: 24px; display: flex; align-items: center; gap: 24px; box-shadow: var(--shadow); }
.profile-avatar-xl { width: 80px; height: 80px; border-radius: 18px; background: rgba(255,255,255,.2); display: flex; align-items: center; justify-content: center; font-size: 26px; font-weight: 800; color: #fff; border: 3px solid rgba(255,255,255,.3); flex-shrink: 0; overflow: hidden; }
.profile-avatar-xl img { width: 100%; height: 100%; object-fit: cover; border-radius: 15px; }
.profile-hero-info h2 { font-size: 20px; font-weight: 700; color: #fff; margin-bottom: 4px; }
.profile-hero-info p { color: rgba(255,255,255,.7); font-size: 14px; }
.profile-form-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 28px; box-shadow: var(--shadow); }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.form-group { margin-bottom: 18px; }
.form-label { display: block; font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; }
.form-input, .form-textarea, .form-select {
    width: 100%; padding: 11px 14px; background: var(--surface2); border: 1.5px solid var(--border);
    border-radius: 10px; color: var(--text); font-family: inherit; font-size: 14px; transition: border .2s;
}
.form-input:focus, .form-textarea:focus, .form-select:focus { outline: none; border-color: var(--accent); background: #fff; }
.form-textarea { min-height: 100px; resize: vertical; }
.form-static { padding: 11px 14px; background: var(--bg); border: 1.5px solid var(--border); border-radius: 10px; font-size: 14px; color: var(--text); }
.form-hint { font-size: 11px; color: var(--text-muted); margin-top: 5px; }

/* ── Radio group (sertifikat) ── */
.radio-group { display: flex; gap: 12px; }
.radio-option { flex: 1; }
.radio-option input[type="radio"] { display: none; }
.radio-option label {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    padding: 10px; border: 1.5px solid var(--border); border-radius: 10px;
    font-size: 13px; font-weight: 600; cursor: pointer; transition: all .2s;
    background: var(--surface2); color: var(--text-muted);
}
.radio-option input[type="radio"]:checked + label { border-color: var(--accent); background: var(--accent-light); color: var(--accent); }

/* ── Tipe konten toggle ── */
.tipe-tabs { display: flex; gap: 8px; margin-bottom: 16px; }
.tipe-tab { flex: 1; padding: 9px; border: 1.5px solid var(--border); border-radius: 10px; font-size: 12px; font-weight: 700; text-align: center; cursor: pointer; transition: all .2s; background: var(--surface2); color: var(--text-muted); text-transform: uppercase; letter-spacing: .5px; }
.tipe-tab.active { border-color: var(--accent); background: var(--accent-light); color: var(--accent); }
.tipe-block { display: none; }
.tipe-block.visible { display: block; }

/* ============ ALERT ============ */
.alert { padding: 14px 18px; border-radius: 10px; font-size: 13px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
.alert-success { background: var(--accent-light); color: var(--accent); border: 1px solid #a7d7c566; }
.alert-error   { background: #fff0ed; color: var(--accent2); border: 1px solid #e76f5166; }

/* ── No-kurikulum notice ── */
.notice-box { background: #fffbea; border: 1px solid #fcd34d66; border-radius: 12px; padding: 16px 20px; display: flex; align-items: center; gap: 14px; margin-bottom: 20px; }
.notice-box .notice-icon { font-size: 22px; flex-shrink: 0; }
.notice-box .notice-text { font-size: 13px; color: #92400e; line-height: 1.6; }
.notice-box .notice-text strong { color: #78350f; }

/* ============ MODAL ============ */
.modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.45); backdrop-filter: blur(4px); z-index: 200; align-items: center; justify-content: center; }
.modal-overlay.open { display: flex; }
.modal { background: var(--surface); border-radius: 20px; width: 640px; max-height: 90vh; overflow-y: auto; padding: 30px; box-shadow: 0 24px 80px rgba(0,0,0,.2); animation: popIn .25s ease; border: 1px solid var(--border); }
@keyframes popIn { from { transform: scale(.95); opacity: 0; } to { transform: scale(1); opacity: 1; } }
.modal-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; }
.modal-title { font-family: 'Cormorant Garamond', serif; font-size: 22px; font-weight: 700; }
.modal-title small { font-family: 'DM Sans', sans-serif; font-size: 12px; font-weight: 500; color: var(--text-muted); display: block; margin-top: 2px; }
.modal-close { width: 34px; height: 34px; border-radius: 10px; background: var(--surface2); border: 1px solid var(--border); cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 18px; color: var(--text-muted); }
.modal-close:hover { background: #fee; border-color: var(--accent2); color: var(--accent2); }
.modal-footer { display: flex; justify-content: flex-end; gap: 10px; margin-top: 24px; padding-top: 20px; border-top: 1px solid var(--border); }
.form-divider { border: none; border-top: 1px solid var(--border); margin: 8px 0 18px; }
.form-section-title { font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 14px; }

.upload-area { width: 100%; min-height: 110px; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 8px; padding: 24px; border: 2px dashed #2d6a4f66; border-radius: 14px; background: #faf8f5; text-align: center; cursor: pointer; transition: all .2s; }
.upload-area:hover { background: #eef8f1; border-color: var(--accent); }
.upload-area .upload-icon { font-size: 36px; line-height: 1; }
.upload-area .upload-text { font-size: 13px; color: var(--text-muted); line-height: 1.6; }
.upload-area .upload-text span { color: var(--accent); font-weight: 700; }
.upload-fname { margin-top: 4px; font-size: 12px; font-weight: 600; color: var(--accent); word-break: break-word; }

/* ============ PAGE SECTIONS ============ */
.page-section { display: none; }
.page-section.active { display: block; }

/* ============ EMPTY STATE ============ */
.empty-state { text-align: center; padding: 60px 20px; color: var(--text-muted); }
.empty-state .empty-icon { font-size: 48px; margin-bottom: 16px; }
.empty-state h3 { font-size: 16px; font-weight: 600; margin-bottom: 8px; color: var(--text); }
.empty-state p { font-size: 13px; line-height: 1.6; }

::-webkit-scrollbar { width: 5px; }
::-webkit-scrollbar-track { background: var(--bg); }
::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }
</style>
</head>
<body>

{{-- ============ SIDEBAR ============ --}}
<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="brand-box">
            <div class="brand-icon">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                </svg>
            </div>
            <div>
                <div class="brand-name">Kaji Indonesia</div>
                <div class="brand-role">Trainer</div>
            </div>
        </div>
    </div>
    <div class="nav-section">
        <div class="nav-label">Menu Utama</div>
        <div class="nav-item active" onclick="showPage('beranda')">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                <rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/>
            </svg>
            Beranda
        </div>
        <div class="nav-item" onclick="showPage('program')">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            Program / Pelatihan
            @if(isset($pendingPelatihanCount) && $pendingPelatihanCount > 0)
                <span class="nav-badge">{{ $pendingPelatihanCount }}</span>
            @endif
        </div>
        <div class="nav-item" onclick="showPage('event')">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <rect x="3" y="4" width="18" height="18" rx="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            Event
            @if(isset($pendingEventCount) && $pendingEventCount > 0)
                <span class="nav-badge">{{ $pendingEventCount }}</span>
            @endif
        </div>
    </div>
    <div class="nav-section">
        <div class="nav-label">Akun</div>
        <div class="nav-item" onclick="showPage('profil')">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/>
            </svg>
            Profil Saya
        </div>
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-item">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            Keluar
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">@csrf</form>
    </div>
    <div class="sidebar-user">
        <div class="user-card" onclick="showPage('profil')">
            <div class="user-avatar">
                @if(auth()->user()->foto)
                    <img src="{{ asset('storage/' . auth()->user()->foto) }}" alt="{{ auth()->user()->name }}">
                @else
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                @endif
            </div>
            <div>
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">Trainer</div>
            </div>
        </div>
    </div>
</aside>

{{-- ============ MAIN ============ --}}
<main class="main">
    <header class="topbar">
        <div class="topbar-title" id="page-title">Dashboard Trainer</div>
        <div style="display:flex;gap:10px;align-items:center">
            <span style="font-size:13px;color:var(--text-muted)">Halo, {{ auth()->user()->name }} 👋</span>
        </div>
    </header>

    <div class="content">

        {{-- ============ BERANDA ============ --}}
        <div class="page-section active" id="page-beranda">
            @if(session('success'))
                <div class="alert alert-success">✅ {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">⚠️ {{ session('error') }}</div>
            @endif

            <div class="stats-grid">
                <div class="stat-card green">
                    <div class="stat-icon">📚</div>
                    <div class="stat-label">Total Kurikulum</div>
                    <div class="stat-value">{{ $totalKurikulum ?? 0 }}</div>
                    <div class="stat-sub">Kurikulum yang diajukan</div>
                </div>
                <div class="stat-card teal">
                    <div class="stat-icon">📝</div>
                    <div class="stat-label">Total Materi</div>
                    <div class="stat-value">{{ $totalMateri ?? 0 }}</div>
                    <div class="stat-sub">Materi dalam kurikulum</div>
                </div>
                <div class="stat-card blue">
                    <div class="stat-icon">📅</div>
                    <div class="stat-label">Total Event</div>
                    <div class="stat-value">{{ $totalEvent ?? 0 }}</div>
                    <div class="stat-sub">Event yang diajukan</div>
                </div>
                <div class="stat-card orange">
                    <div class="stat-icon">⏳</div>
                    <div class="stat-label">Menunggu Persetujuan</div>
                    <div class="stat-value">{{ $pendingTotal ?? 0 }}</div>
                    <div class="stat-sub">Perlu tindakan admin</div>
                </div>
            </div>

            <div class="section-header">
                <div class="section-title">Status Terbaru <span>program & materi</span></div>
            </div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Nama</th><th>Tipe</th><th>Tanggal</th><th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentSubmissions ?? [] as $item)
                        <tr>
                            <td style="font-weight:500">{{ $item->judul ?? $item->nama }}</td>
                            <td>
                                @if(isset($item->jenis) && $item->jenis === 'Event')
                                    <span class="chip">Event</span>
                                @else
                                    <span class="chip chip-{{ $item->tipe ?? 'kurikulum' }}">{{ ucfirst($item->tipe ?? '-') }}</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') }}</td>
                            <td>
                                @if(($item->status ?? '') === 'approved')
                                    <span class="badge badge-approved"><span class="badge-dot"></span>Disetujui</span>
                                @elseif(($item->status ?? '') === 'rejected')
                                    <span class="badge badge-rejected"><span class="badge-dot"></span>Ditolak</span>
                                @else
                                    <span class="badge badge-pending"><span class="badge-dot"></span>Menunggu</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="text-align:center;padding:40px;color:var(--text-muted)">
                                Belum ada program atau event yang diajukan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>{{-- /page-beranda --}}

        {{-- ============ PROGRAM / PELATIHAN ============ --}}
        <div class="page-section" id="page-program">
            @if(session('success'))
                <div class="alert alert-success">✅ {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">⚠️ {{ session('error') }}</div>
            @endif

            <div class="section-header">
                <div class="section-title">
                    Program / Pelatihan
                    <span>{{ ($totalKurikulum ?? 0) + ($totalMateri ?? 0) }} total</span>
                </div>
                {{-- ── DUA BUTTON ── --}}
                <div class="section-actions">
                    <button class="btn btn-secondary" onclick="openModalMateri()">
                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        + Tambah Materi
                    </button>
                    <button class="btn btn-primary" onclick="openModal('modal-kurikulum')">
                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                        </svg>
                        + Tambah Kurikulum
                    </button>
                </div>
            </div>

            {{-- ── List kurikulum + materi nested ── --}}
            @php
                $kurikulumList = isset($pelatihanList) ? $pelatihanList->where('tipe', 'kurikulum') : collect();
                $materiList    = isset($pelatihanList) ? $pelatihanList->where('tipe', 'materi')    : collect();
                $materiStandalone = $materiList->whereNull('kurikulum_id');
            @endphp

            @if($kurikulumList->count() > 0)
                @foreach($kurikulumList as $k)
                @php $materiDalamK = $materiList->where('kurikulum_id', $k->id)->sortBy('urutan'); @endphp
                <div class="kurikulum-block">
                    {{-- Header kurikulum --}}
                    <div class="kurikulum-block-header">
                        <div style="width:42px;height:42px;border-radius:10px;background:var(--surface2);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;">
                            @if($k->gambar)
                                <img src="{{ asset('storage/'.$k->gambar) }}" style="width:100%;height:100%;object-fit:cover;border-radius:10px;">
                            @else
                                📚
                            @endif
                        </div>
                        <div style="flex:1">
                            <div class="k-title">{{ $k->judul }}</div>
                            <div class="k-meta">
                                <span>{{ $materiDalamK->count() }} materi</span>
                                @if($k->total_jam) <span>⏱ {{ $k->total_jam }} jam</span> @endif
                                @if($k->jumlah_sesi) <span>📅 {{ $k->jumlah_sesi }} sesi</span> @endif
                                @if($k->sertifikat) <span>🏆 Sertifikat</span> @endif
                                @if($k->tingkat) <span>{{ ucfirst($k->tingkat) }}</span> @endif
                                @if($k->metode) <span>{{ ucfirst($k->metode) }}</span> @endif
                            </div>
                        </div>
                        <div style="display:flex;align-items:center;gap:10px">
                            @if(($k->status ?? '') === 'approved')
                                <span class="badge badge-approved"><span class="badge-dot"></span>Disetujui</span>
                            @elseif(($k->status ?? '') === 'rejected')
                                <span class="badge badge-rejected"><span class="badge-dot"></span>Ditolak</span>
                            @else
                                <span class="badge badge-pending"><span class="badge-dot"></span>Menunggu</span>
                            @endif
                            {{-- Tombol tambah materi langsung ke kurikulum ini --}}
                            <button class="btn btn-sm btn-outline"
                                onclick="openModalMateriDenganKurikulum({{ $k->id }}, '{{ addslashes($k->judul) }}')">
                                + Materi
                            </button>
                            @if(($k->status ?? '') !== 'approved')
                            <button class="btn-icon" onclick="editKurikulum({{ $k->id }}, '{{ addslashes($k->judul) }}', '{{ addslashes($k->deskripsi ?? '') }}', '{{ $k->metode ?? '' }}', '{{ $k->tingkat ?? '' }}', '{{ $k->bahasa ?? '' }}', '{{ $k->jumlah_materi ?? '' }}', '{{ $k->total_jam ?? '' }}', '{{ $k->jumlah_sesi ?? '' }}', {{ $k->sertifikat ? 1 : 0 }})" title="Edit">
                                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                            </button>
                            @endif
                            <button class="btn-icon btn-icon-danger" onclick="hapusItem({{ $k->id }}, 'kurikulum')" title="Hapus">
                                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6"/>
                                    <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                                    <path d="M10 11v6M14 11v6M9 6V4h6v2"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Materi di dalam kurikulum ini --}}
                    @if($materiDalamK->count() > 0)
                    <div class="materi-list">
                        @foreach($materiDalamK as $m)
                        <div class="materi-row">
                            <div class="materi-num">{{ $m->urutan ?? $loop->iteration }}</div>
                            <div class="tipe-icon">
                                @if($m->metode === 'video') 🎬
                                @elseif($m->metode === 'file') 📄
                                @else 📝
                                @endif
                            </div>
                            <div class="materi-info">
                                <div class="materi-title">{{ $m->judul }}</div>
                                <div class="materi-meta">
                                    @if($m->metode) <span>{{ ucfirst($m->metode) }}</span> @endif
                                    @if($m->durasi) <span>⏱ {{ $m->durasi }} menit</span> @endif
                                    @if($m->deskripsi) <span>{{ Str::limit($m->deskripsi, 60) }}</span> @endif
                                </div>
                            </div>
                            <div style="display:flex;align-items:center;gap:8px">
                                @if(($m->status ?? '') === 'approved')
                                    <span class="badge badge-approved" style="font-size:10px;padding:3px 8px"><span class="badge-dot"></span>Disetujui</span>
                                @elseif(($m->status ?? '') === 'rejected')
                                    <span class="badge badge-rejected" style="font-size:10px;padding:3px 8px"><span class="badge-dot"></span>Ditolak</span>
                                @else
                                    <span class="badge badge-pending" style="font-size:10px;padding:3px 8px"><span class="badge-dot"></span>Menunggu</span>
                                @endif
                                @if(($m->status ?? '') !== 'approved')
                                <button class="btn-icon" onclick="editMateri({{ $m->id }}, '{{ addslashes($m->judul) }}', {{ $m->kurikulum_id ?? 'null' }}, '{{ addslashes($m->deskripsi ?? '') }}', '{{ $m->metode ?? 'teks' }}', '{{ addslashes($m->konten_materi ?? '') }}', '{{ addslashes($m->link_video ?? '') }}', '{{ $m->durasi ?? '' }}', '{{ $m->urutan ?? '' }}')" title="Edit">
                                    <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                                        <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                    </svg>
                                </button>
                                @endif
                                <button class="btn-icon btn-icon-danger" onclick="hapusItem({{ $m->id }}, 'materi')" title="Hapus">
                                    <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"/>
                                        <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                                        <path d="M10 11v6M14 11v6M9 6V4h6v2"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="materi-list">
                        <div style="padding:20px 24px;font-size:13px;color:var(--text-muted);display:flex;align-items:center;gap:10px">
                            <span>📭</span> Belum ada materi.
                            <button class="btn btn-sm btn-outline" style="margin-left:4px"
                                onclick="openModalMateriDenganKurikulum({{ $k->id }}, '{{ addslashes($k->judul) }}')">
                                Tambah sekarang
                            </button>
                        </div>
                    </div>
                    @endif

                    {{-- Catatan admin jika ditolak --}}
                    @if(($k->status ?? '') === 'rejected' && $k->catatan_admin)
                    <div style="padding:10px 16px;background:#fff0ed;border:1px solid #e76f5166;border-top:none;border-radius:0 0 var(--radius) var(--radius);font-size:12px;color:var(--accent2)">
                        <strong>Catatan Admin:</strong> {{ $k->catatan_admin }}
                    </div>
                    @endif
                </div>
                @endforeach
            @else
                <div class="table-wrap">
                    <div class="empty-state">
                        <div class="empty-icon">📚</div>
                        <h3>Belum ada kurikulum</h3>
                        <p>Mulai dengan membuat kurikulum, lalu tambahkan materi ke dalamnya.</p>
                    </div>
                </div>
            @endif
        </div>{{-- /page-program --}}

        {{-- ============ EVENT ============ --}}
        <div class="page-section" id="page-event">
            @if(session('success'))
                <div class="alert alert-success">✅ {{ session('success') }}</div>
            @endif
            <div class="section-header">
                <div class="section-title">Event <span>{{ $totalEvent ?? 0 }} total</span></div>
                <button class="btn btn-primary" onclick="openModal('modal-event')">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Tambah Event
                </button>
            </div>
            @if(isset($eventList) && $eventList->count() > 0)
                <div class="table-wrap">
                    <table>
                        <thead><tr><th>Nama Event</th><th>Lokasi</th><th>Tanggal</th><th>Kapasitas</th><th>Status</th><th>Aksi</th></tr></thead>
                        <tbody>
                            @foreach($eventList as $event)
                            <tr>
                                <td style="font-weight:500">{{ $event->judul ?? $event->nama }}</td>
                                <td>{{ $event->lokasi ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('d M Y') }}</td>
                                <td>{{ $event->kapasitas ?? '-' }}</td>
                                <td>
                                    @if(($event->status ?? '') === 'approved')
                                        <span class="badge badge-approved"><span class="badge-dot"></span>Disetujui</span>
                                    @elseif(($event->status ?? '') === 'rejected')
                                        <span class="badge badge-rejected"><span class="badge-dot"></span>Ditolak</span>
                                    @else
                                        <span class="badge badge-pending"><span class="badge-dot"></span>Menunggu</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="display:flex;gap:6px">
                                        @if(($event->status ?? '') !== 'approved')
                                        <button class="btn-icon" onclick="editEvent({{ $event->id }},'{{ addslashes($event->judul ?? $event->nama) }}','{{ $event->tipe ?? '' }}','{{ $event->tanggal }}','{{ addslashes($event->lokasi ?? '') }}','{{ $event->kapasitas ?? '' }}','{{ addslashes($event->biaya ?? '') }}','{{ addslashes($event->deskripsi ?? '') }}')" title="Edit">
                                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                        </button>
                                        @endif
                                        <button class="btn-icon btn-icon-danger" onclick="hapusEvent({{ $event->id }})" title="Hapus">
                                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6M9 6V4h6v2"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="table-wrap">
                    <div class="empty-state">
                        <div class="empty-icon">📅</div>
                        <h3>Belum ada event</h3>
                        <p>Klik "Tambah Event" untuk mengajukan event baru.</p>
                    </div>
                </div>
            @endif
        </div>{{-- /page-event --}}

        {{-- ============ PROFIL ============ --}}
        <div class="page-section" id="page-profil">
            @if(session('success'))<div class="alert alert-success">✅ {{ session('success') }}</div>@endif
            <div class="profile-hero">
                <div class="profile-avatar-xl">
                    @if(auth()->user()->foto)
                        <img src="{{ asset('storage/' . auth()->user()->foto) }}" alt="{{ auth()->user()->name }}">
                    @else
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    @endif
                </div>
                <div class="profile-hero-info">
                    <h2>{{ auth()->user()->name }}</h2>
                    <p>Trainer · Bergabung sejak {{ \Carbon\Carbon::parse(auth()->user()->created_at)->translatedFormat('F Y') }}</p>
                </div>
                <button class="btn" style="background:rgba(255,255,255,.15);color:#fff;border:1.5px solid rgba(255,255,255,.3);margin-left:auto" onclick="openModal('modal-profil')">Edit Profil</button>
            </div>
            <div class="profile-form-card">
                <div class="form-row">
                    <div class="form-group"><div class="form-label">Nama Lengkap</div><div class="form-static">{{ auth()->user()->name }}</div></div>
                    <div class="form-group"><div class="form-label">Email</div><div class="form-static">{{ auth()->user()->email }}</div></div>
                    <div class="form-group"><div class="form-label">No. Telepon</div><div class="form-static">{{ auth()->user()->no_hp ?? '-' }}</div></div>
                    <div class="form-group"><div class="form-label">Bidang Keahlian</div><div class="form-static">{{ auth()->user()->bidang_keahlian ?? '-' }}</div></div>
                </div>
                <div class="form-group"><div class="form-label">Bio / Tentang Saya</div><div class="form-static" style="min-height:80px;line-height:1.7">{{ auth()->user()->bio ?? 'Belum ada bio.' }}</div></div>
            </div>
        </div>

    </div>{{-- /content --}}
</main>

{{-- ================================================================ --}}
{{-- MODAL: TAMBAH / EDIT KURIKULUM                                    --}}
{{-- ================================================================ --}}
<div class="modal-overlay" id="modal-kurikulum">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">
                <span id="modal-kurikulum-title-text">Tambah Kurikulum</span>
                <small>Isi detail kurikulum, materi dapat ditambah setelah kurikulum tersimpan</small>
            </div>
            <button class="modal-close" onclick="resetKurikulumModal(); closeModal('modal-kurikulum')">×</button>
        </div>

        <form id="form-kurikulum" method="POST" enctype="multipart/form-data" action="{{ route('trainer.kurikulum.store') }}">
            @csrf
            <input type="hidden" name="_method" id="kurikulum-method" value="POST">
            <input type="hidden" name="kurikulum_edit_id" id="kurikulum-edit-id">

            {{-- Nama --}}
            <div class="form-group">
                <label class="form-label">Nama Kurikulum <span style="color:var(--accent2)">*</span></label>
                <input class="form-input" type="text" name="judul" id="k-judul" placeholder="Contoh: Kursus Digital Marketing Terapan..." required>
            </div>

            {{-- Deskripsi --}}
            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <textarea class="form-textarea" name="deskripsi" id="k-deskripsi" rows="3" placeholder="Jelaskan tujuan dan isi kurikulum ini..." maxlength="500"></textarea>
                <div class="form-hint">Maks. 500 karakter.</div>
            </div>

            <hr class="form-divider">
            <div class="form-section-title">Informasi Kurikulum</div>

            {{-- Jumlah materi + total jam + jumlah sesi --}}
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px">
                <div class="form-group">
                    <label class="form-label">Jumlah Materi</label>
                    <input class="form-input" type="number" name="jumlah_materi" id="k-jumlah-materi" placeholder="0" min="0">
                </div>
                <div class="form-group">
                    <label class="form-label">Total Jam</label>
                    <input class="form-input" type="number" name="total_jam" id="k-total-jam" placeholder="0" min="0" step="0.5">
                </div>
                <div class="form-group">
                    <label class="form-label">Jumlah Sesi</label>
                    <input class="form-input" type="number" name="jumlah_sesi" id="k-jumlah-sesi" placeholder="0" min="0">
                </div>
            </div>

            {{-- Sertifikat --}}
            <div class="form-group">
                <label class="form-label">Ada Sertifikat?</label>
                <div class="radio-group">
                    <div class="radio-option">
                        <input type="radio" name="sertifikat" id="sertifikat-ya" value="1">
                        <label for="sertifikat-ya">🏆 Ya, ada sertifikat</label>
                    </div>
                    <div class="radio-option">
                        <input type="radio" name="sertifikat" id="sertifikat-tidak" value="0" checked>
                        <label for="sertifikat-tidak">Tidak ada sertifikat</label>
                    </div>
                </div>
            </div>

            <hr class="form-divider">
            <div class="form-section-title">Informasi Tambahan</div>

            {{-- Metode + Tingkat --}}
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Metode</label>
                    <select class="form-select" name="metode" id="k-metode">
                        <option value="">-- Pilih --</option>
                        <option value="online">Online</option>
                        <option value="offline">Offline</option>
                        <option value="hybrid">Online & Offline / Hybrid</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Tingkat</label>
                    <select class="form-select" name="tingkat" id="k-tingkat">
                        <option value="">-- Pilih --</option>
                        <option value="pemula">Pemula</option>
                        <option value="menengah">Menengah</option>
                        <option value="lanjut">Lanjut</option>
                    </select>
                </div>
            </div>

            {{-- Bahasa --}}
            <div class="form-group">
                <label class="form-label">Bahasa</label>
                <input class="form-input" type="text" name="bahasa" id="k-bahasa" placeholder="Bahasa Indonesia" value="Bahasa Indonesia">
            </div>

            {{-- Gambar --}}
            <div class="form-group">
                <label class="form-label">Gambar Kurikulum</label>
                <label class="upload-area" for="k-gambar">
                    <div class="upload-icon">📁</div>
                    <div class="upload-text">Klik untuk upload atau <span>drag & drop</span><br>PNG, JPG hingga 5MB</div>
                    <div class="upload-fname" id="k-gambar-name"></div>
                </label>
                <input type="file" id="k-gambar" name="gambar" accept="image/*" style="display:none" onchange="showFileName(this, 'k-gambar-name')">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" onclick="resetKurikulumModal(); closeModal('modal-kurikulum')">Batal</button>
                <button type="submit" class="btn btn-primary">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    Kirim untuk Disetujui
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ================================================================ --}}
{{-- MODAL: TAMBAH / EDIT MATERI                                       --}}
{{-- ================================================================ --}}
<div class="modal-overlay" id="modal-materi">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">
                <span id="modal-materi-title-text">Tambah Materi</span>
                <small id="modal-materi-subtitle">Pilih kurikulum dan isi detail materi</small>
            </div>
            <button class="modal-close" onclick="resetMateriModal(); closeModal('modal-materi')">×</button>
        </div>

        {{-- Notice jika tidak ada kurikulum --}}
        @php $adaKurikulum = isset($pelatihanList) && $pelatihanList->where('tipe','kurikulum')->count() > 0; @endphp
        @if(!$adaKurikulum)
        <div class="notice-box">
            <div class="notice-icon">⚠️</div>
            <div class="notice-text">
                <strong>Belum ada kurikulum.</strong> Kamu perlu membuat kurikulum terlebih dahulu sebelum menambahkan materi.
                <br><a href="#" onclick="closeModal('modal-materi'); openModal('modal-kurikulum')" style="color:var(--accent);font-weight:700">Buat kurikulum sekarang →</a>
            </div>
        </div>
        @endif

        <form id="form-materi" method="POST" enctype="multipart/form-data" action="{{ route('trainer.materi.store') }}">
            @csrf
            <input type="hidden" name="_method" id="materi-method" value="POST">
            <input type="hidden" name="materi_edit_id" id="materi-edit-id">

            {{-- Pilih kurikulum --}}
            <div class="form-group">
                <label class="form-label">Masukkan ke Kurikulum <span style="color:var(--accent2)">*</span></label>
                <select class="form-select" name="kurikulum_id" id="m-kurikulum-id" required {{ !$adaKurikulum ? 'disabled' : '' }}>
                    <option value="">-- Pilih kurikulum --</option>
                    @if(isset($pelatihanList))
                        @foreach($pelatihanList->where('tipe','kurikulum') as $k)
                            <option value="{{ $k->id }}">{{ $k->judul }}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            {{-- Judul materi --}}
            <div class="form-group">
                <label class="form-label">Judul Materi <span style="color:var(--accent2)">*</span></label>
                <input class="form-input" type="text" name="judul" id="m-judul" placeholder="Contoh: Pengantar SEO On-Page..." required {{ !$adaKurikulum ? 'disabled' : '' }}>
            </div>

            {{-- Deskripsi --}}
            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <textarea class="form-textarea" name="deskripsi" id="m-deskripsi" rows="2" placeholder="Ringkasan singkat materi ini..." {{ !$adaKurikulum ? 'disabled' : '' }}></textarea>
            </div>

            {{-- Urutan + Durasi --}}
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Nomor Urutan / Sesi</label>
                    <input class="form-input" type="number" name="urutan" id="m-urutan" placeholder="1" min="1" {{ !$adaKurikulum ? 'disabled' : '' }}>
                </div>
                <div class="form-group">
                    <label class="form-label">Durasi (menit)</label>
                    <input class="form-input" type="number" name="durasi" id="m-durasi" placeholder="60" min="1" {{ !$adaKurikulum ? 'disabled' : '' }}>
                </div>
            </div>

            <hr class="form-divider">
            <div class="form-section-title">Tipe Konten</div>

            {{-- Tabs tipe konten --}}
            <div class="tipe-tabs" id="tipe-tabs">
                <div class="tipe-tab active" onclick="switchTipe('teks')">📝 Teks</div>
                <div class="tipe-tab" onclick="switchTipe('video')">🎬 Video</div>
                <div class="tipe-tab" onclick="switchTipe('file')">📄 File</div>
            </div>
            <input type="hidden" name="tipe_konten" id="m-tipe-konten" value="teks">

            {{-- Konten teks --}}
            <div class="tipe-block visible" id="tipe-block-teks">
                <div class="form-group">
                    <label class="form-label">Isi Materi</label>
                    <textarea class="form-textarea" name="konten_materi" id="m-konten" rows="5" placeholder="Tuliskan isi materi (HTML diperbolehkan)..." {{ !$adaKurikulum ? 'disabled' : '' }}></textarea>
                </div>
            </div>

            {{-- Konten video --}}
            <div class="tipe-block" id="tipe-block-video">
                <div class="form-group">
                    <label class="form-label">Link Video</label>
                    <input class="form-input" type="url" name="link_video" id="m-link-video" placeholder="https://youtube.com/watch?v=..." {{ !$adaKurikulum ? 'disabled' : '' }}>
                    <div class="form-hint">YouTube, Vimeo, atau link video lainnya.</div>
                </div>
                <div class="form-group">
                    <label class="form-label">Deskripsi Video (opsional)</label>
                    <textarea class="form-textarea" rows="3" name="konten_materi" placeholder="Deskripsi atau catatan video..." {{ !$adaKurikulum ? 'disabled' : '' }}></textarea>
                </div>
            </div>

            {{-- Konten file --}}
            <div class="tipe-block" id="tipe-block-file">
                <div class="form-group">
                    <label class="form-label">Upload File Materi</label>
                    <label class="upload-area" for="m-file">
                        <div class="upload-icon">📎</div>
                        <div class="upload-text">Klik untuk upload atau <span>drag & drop</span><br>PDF, DOC, PPT, ZIP hingga 20MB</div>
                        <div class="upload-fname" id="m-file-name"></div>
                    </label>
                    <input type="file" id="m-file" name="file_materi" accept=".pdf,.doc,.docx,.ppt,.pptx,.zip" style="display:none"
                        onchange="showFileName(this, 'm-file-name')" {{ !$adaKurikulum ? 'disabled' : '' }}>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" onclick="resetMateriModal(); closeModal('modal-materi')">Batal</button>
                <button type="submit" class="btn btn-primary" {{ !$adaKurikulum ? 'disabled style=opacity:.5;cursor:not-allowed' : '' }}>
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    Kirim untuk Disetujui
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ================================================================ --}}
{{-- MODAL: TAMBAH / EDIT EVENT                                         --}}
{{-- ================================================================ --}}
<div class="modal-overlay" id="modal-event">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title" id="modal-event-title">Tambah Event</div>
            <button class="modal-close" onclick="resetEventModal(); closeModal('modal-event')">×</button>
        </div>
        <form id="form-event" method="POST" enctype="multipart/form-data" action="{{ route('trainer.event.store') }}">
            @csrf
            <input type="hidden" name="_method" id="event-method" value="POST">
            <input type="hidden" name="event_id" id="event-id">
            <div class="form-group">
                <label class="form-label">Nama Event <span style="color:var(--accent2)">*</span></label>
                <input class="form-input" type="text" name="judul" id="event-judul" placeholder="Nama event..." required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Tipe Event</label>
                    <select class="form-select" name="tipe" id="event-tipe">
                        <option value="Seminar">Seminar</option><option value="Workshop">Workshop</option>
                        <option value="Bootcamp">Bootcamp</option><option value="Webinar">Webinar</option>
                        <option value="Talkshow">Talkshow</option><option value="Pelatihan">Pelatihan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal <span style="color:var(--accent2)">*</span></label>
                    <input class="form-input" type="date" name="tanggal" id="event-tanggal" required>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Lokasi</label>
                <input class="form-input" type="text" name="lokasi" id="event-lokasi" placeholder="Kota / Nama Venue">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Kapasitas Peserta</label>
                    <input class="form-input" type="number" name="kapasitas" id="event-kapasitas" placeholder="200" min="1">
                </div>
                <div class="form-group">
                    <label class="form-label">Biaya <span class="form-hint" style="display:inline">(kosong = gratis)</span></label>
                    <input class="form-input" type="text" name="biaya" id="event-biaya" placeholder="Rp 0">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Deskripsi Event <span style="color:var(--accent2)">*</span></label>
                <textarea class="form-textarea" name="deskripsi" id="event-deskripsi" placeholder="Jelaskan detail event ini..." required></textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Banner Event</label>
                <label class="upload-area" for="event-gambar">
                    <div class="upload-icon">🖼️</div>
                    <div class="upload-text">Klik untuk upload atau <span>drag & drop</span><br>PNG, JPG hingga 5MB</div>
                    <div class="upload-fname" id="event-gambar-name"></div>
                </label>
                <input type="file" id="event-gambar" name="gambar" accept="image/*" style="display:none" onchange="showFileName(this, 'event-gambar-name')">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" onclick="resetEventModal(); closeModal('modal-event')">Batal</button>
                <button type="submit" class="btn btn-primary">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    Kirim untuk Disetujui
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ================================================================ --}}
{{-- MODAL: EDIT PROFIL                                                 --}}
{{-- ================================================================ --}}
<div class="modal-overlay" id="modal-profil">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">Edit Profil</div>
            <button class="modal-close" onclick="closeModal('modal-profil')">×</button>
        </div>
        <form method="POST" action="{{ route('trainer.profil.update') }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="form-row">
                <div class="form-group"><label class="form-label">Nama Lengkap <span style="color:var(--accent2)">*</span></label><input class="form-input" type="text" name="name" value="{{ auth()->user()->name }}" required></div>
                <div class="form-group"><label class="form-label">Email <span style="color:var(--accent2)">*</span></label><input class="form-input" type="email" name="email" value="{{ auth()->user()->email }}" required></div>
                <div class="form-group"><label class="form-label">No. Telepon</label><input class="form-input" type="text" name="no_hp" value="{{ auth()->user()->no_hp ?? '' }}" placeholder="+62 812-xxxx-xxxx"></div>
                <div class="form-group"><label class="form-label">Bidang Keahlian</label><input class="form-input" type="text" name="bidang_keahlian" value="{{ auth()->user()->bidang_keahlian ?? '' }}" placeholder="Contoh: Digital Marketing"></div>
            </div>
            <div class="form-group"><label class="form-label">Bio / Tentang Saya</label><textarea class="form-textarea" name="bio" placeholder="Ceritakan tentang dirimu...">{{ auth()->user()->bio ?? '' }}</textarea></div>
            <div class="form-group"><label class="form-label">URL LinkedIn</label><input class="form-input" type="url" name="linkedin" value="{{ auth()->user()->linkedin ?? '' }}" placeholder="https://linkedin.com/in/username"></div>
            <div class="form-group">
                <label class="form-label">Foto Profil</label>
                <label class="upload-area" for="profil-foto">
                    <div class="upload-icon">📷</div>
                    <div class="upload-text">Klik untuk upload foto baru atau <span>drag & drop</span></div>
                    <div class="upload-fname" id="profil-foto-name"></div>
                </label>
                <input type="file" id="profil-foto" name="foto" accept="image/*" style="display:none" onchange="showFileName(this, 'profil-foto-name')">
            </div>
            <hr class="form-divider">
            <div class="form-group"><label class="form-label">Password Baru <span style="font-weight:400;text-transform:none;font-size:11px">(kosongkan jika tidak diubah)</span></label><input class="form-input" type="password" name="password" placeholder="Min. 8 karakter"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" onclick="closeModal('modal-profil')">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

{{-- Form hapus tersembunyi --}}
<form id="form-hapus" method="POST" style="display:none">@csrf @method('DELETE')</form>
<form id="form-hapus-event" method="POST" style="display:none">@csrf @method('DELETE')</form>

<script>
// ── PAGE NAVIGATION ──
function showPage(id) {
    document.querySelectorAll('.page-section').forEach(el => el.classList.remove('active'));
    document.querySelectorAll('.nav-item').forEach(el => el.classList.remove('active'));
    document.getElementById('page-' + id).classList.add('active');
    const titles = { beranda:'Dashboard Trainer', program:'Program / Pelatihan', event:'Event', profil:'Profil Saya' };
    document.getElementById('page-title').textContent = titles[id] || 'Dashboard';
    document.querySelectorAll('.nav-item').forEach(item => {
        if ((item.getAttribute('onclick') || '').includes("'" + id + "'")) item.classList.add('active');
    });
}

// ── MODAL ──
function openModal(id)  { document.getElementById(id).classList.add('open'); }
function closeModal(id) { document.getElementById(id).classList.remove('open'); }
document.querySelectorAll('.modal-overlay').forEach(m => {
    m.addEventListener('click', e => { if (e.target === m) m.classList.remove('open'); });
});

// ── FILE UPLOAD ──
function showFileName(input, labelId) {
    const label = document.getElementById(labelId);
    if (input.files && input.files[0]) label.textContent = '✓ ' + input.files[0].name;
}

// ── TIPE KONTEN TABS (MATERI) ──
function switchTipe(tipe) {
    document.querySelectorAll('.tipe-tab').forEach((t, i) => {
        const tipes = ['teks','video','file'];
        t.classList.toggle('active', tipes[i] === tipe);
    });
    document.querySelectorAll('.tipe-block').forEach(b => b.classList.remove('visible'));
    document.getElementById('tipe-block-' + tipe).classList.add('visible');
    document.getElementById('m-tipe-konten').value = tipe;
}

// ── OPEN MODAL MATERI (cek kurikulum) ──
function openModalMateri() {
    @if(!$adaKurikulum)
        if (!confirm('Kamu belum punya kurikulum. Buat kurikulum terlebih dahulu?')) return;
        openModal('modal-kurikulum');
        return;
    @endif
    resetMateriModal();
    openModal('modal-materi');
}

function openModalMateriDenganKurikulum(kurikulumId, kurikulumJudul) {
    resetMateriModal();
    document.getElementById('m-kurikulum-id').value = kurikulumId;
    document.getElementById('modal-materi-subtitle').textContent = 'Menambah materi ke: ' + kurikulumJudul;
    openModal('modal-materi');
}

// ── EDIT KURIKULUM ──
function editKurikulum(id, judul, deskripsi, metode, tingkat, bahasa, jumlahMateri, totalJam, jumlahSesi, sertifikat) {
    document.getElementById('modal-kurikulum-title-text').textContent = 'Edit Kurikulum';
    document.getElementById('kurikulum-edit-id').value = id;
    document.getElementById('k-judul').value           = judul;
    document.getElementById('k-deskripsi').value       = deskripsi;
    document.getElementById('k-metode').value          = metode;
    document.getElementById('k-tingkat').value         = tingkat;
    document.getElementById('k-bahasa').value          = bahasa;
    document.getElementById('k-jumlah-materi').value   = jumlahMateri;
    document.getElementById('k-total-jam').value       = totalJam;
    document.getElementById('k-jumlah-sesi').value     = jumlahSesi;
    document.getElementById('kurikulum-method').value  = 'PUT';
    document.getElementById('form-kurikulum').action   = '/trainer/kurikulum/' + id;
    if (sertifikat == 1) {
        document.getElementById('sertifikat-ya').checked = true;
    } else {
        document.getElementById('sertifikat-tidak').checked = true;
    }
    openModal('modal-kurikulum');
}

// ── EDIT MATERI ──
function editMateri(id, judul, kurikulumId, deskripsi, tipeKonten, konten, linkVideo, durasi, urutan) {
    document.getElementById('modal-materi-title-text').textContent = 'Edit Materi';
    document.getElementById('materi-edit-id').value  = id;
    document.getElementById('m-judul').value         = judul;
    document.getElementById('m-kurikulum-id').value  = kurikulumId;
    document.getElementById('m-deskripsi').value     = deskripsi;
    document.getElementById('m-konten').value        = konten;
    document.getElementById('m-link-video').value    = linkVideo;
    document.getElementById('m-durasi').value        = durasi;
    document.getElementById('m-urutan').value        = urutan;
    document.getElementById('materi-method').value   = 'PUT';
    document.getElementById('form-materi').action    = '/trainer/materi/' + id;
    switchTipe(tipeKonten || 'teks');
    openModal('modal-materi');
}

// ── EDIT EVENT ──
function editEvent(id, judul, tipe, tanggal, lokasi, kapasitas, biaya, deskripsi) {
    document.getElementById('modal-event-title').textContent = 'Edit Event';
    document.getElementById('event-id').value       = id;
    document.getElementById('event-judul').value    = judul;
    document.getElementById('event-tipe').value     = tipe;
    document.getElementById('event-tanggal').value  = tanggal;
    document.getElementById('event-lokasi').value   = lokasi;
    document.getElementById('event-kapasitas').value = kapasitas;
    document.getElementById('event-biaya').value    = biaya;
    document.getElementById('event-deskripsi').value = deskripsi;
    document.getElementById('event-method').value   = 'PUT';
    document.getElementById('form-event').action    = '/trainer/event/' + id;
    openModal('modal-event');
}

// ── RESET MODALS ──
function resetKurikulumModal() {
    document.getElementById('modal-kurikulum-title-text').textContent = 'Tambah Kurikulum';
    document.getElementById('kurikulum-method').value = 'POST';
    document.getElementById('form-kurikulum').action  = '{{ route("trainer.kurikulum.store") }}';
    document.getElementById('form-kurikulum').reset();
    document.getElementById('k-gambar-name').textContent = '';
    document.getElementById('sertifikat-tidak').checked  = true;
}
function resetMateriModal() {
    document.getElementById('modal-materi-title-text').textContent = 'Tambah Materi';
    document.getElementById('modal-materi-subtitle').textContent   = 'Pilih kurikulum dan isi detail materi';
    document.getElementById('materi-method').value = 'POST';
    document.getElementById('form-materi').action  = '{{ route("trainer.materi.store") }}';
    document.getElementById('form-materi').reset();
    document.getElementById('m-file-name').textContent = '';
    switchTipe('teks');
}
function resetEventModal() {
    document.getElementById('modal-event-title').textContent = 'Tambah Event';
    document.getElementById('event-method').value = 'POST';
    document.getElementById('form-event').action  = '{{ route("trainer.event.store") }}';
    document.getElementById('form-event').reset();
    document.getElementById('event-gambar-name').textContent = '';
}

// ── HAPUS ──
function hapusItem(id, tipe) {
    if (!confirm('Yakin ingin menghapus ' + tipe + ' ini? Tindakan tidak dapat dibatalkan.')) return;
    const form = document.getElementById('form-hapus');
    form.action = '/trainer/' + tipe + '/' + id;
    form.submit();
}
function hapusEvent(id) {
    if (!confirm('Yakin ingin menghapus event ini?')) return;
    const form = document.getElementById('form-hapus-event');
    form.action = '/trainer/event/' + id;
    form.submit();
}

// ── AUTO-OPEN ──
const hash = window.location.hash.replace('#', '');
if (['beranda','program','event','profil'].includes(hash)) {
    showPage(hash);
} else {
    @if(session('active_page'))
        showPage('{{ session("active_page") }}');
    @endif
}
</script>
</body>
</html>