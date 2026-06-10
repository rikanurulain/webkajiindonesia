{{-- resources/views/trainer/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Dashboard Trainer – KAJI Indonesia</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700;800&family=Cormorant+Garamond:wght@600;700&display=swap" rel="stylesheet">
<style>

.form-input:invalid:not(:placeholder-shown),
.form-textarea:invalid:not(:placeholder-shown),
.form-select:invalid {
    border-color: var(--accent2);
    background: #fff8f7;
}
.form-input:valid:not(:placeholder-shown),
.form-textarea:valid:not(:placeholder-shown) {
    border-color: #a7d7c5;
}
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
.btn-secondary:hover { background: #2e5a7a; transform: translateY(-1px); }
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
.chip-event     { background: #fff0ed; color: var(--accent2); border-color: #e76f5166; }

/* ============ KURIKULUM BLOCK ============ */
.section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; }
.section-title { font-size: 16px; font-weight: 700; }
.section-title span { color: var(--text-muted); font-weight: 400; font-size: 14px; margin-left: 8px; }
.section-actions { display: flex; gap: 10px; align-items: center; }

.kurikulum-block { margin-bottom: 28px; }
.kurikulum-block-header { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius) var(--radius) 0 0; padding: 16px 20px; display: flex; align-items: center; gap: 12px; }
.kurikulum-block-header .k-title { font-size: 15px; font-weight: 700; flex: 1; }
.kurikulum-block-header .k-meta { font-size: 12px; color: var(--text-muted); display: flex; gap: 12px; flex-wrap: wrap; }
.modul-list { border: 1px solid var(--border); border-top: none; border-radius: 0 0 var(--radius) var(--radius); overflow: hidden; }
.modul-row { display: flex; align-items: center; gap: 14px; padding: 12px 20px; border-bottom: 1px solid var(--border); background: var(--surface); transition: background .15s; }
.modul-row:last-child { border-bottom: none; }
.modul-row:hover { background: #f9f7f4; }
.modul-info { flex: 1; }
.modul-title { font-size: 13px; font-weight: 600; color: var(--accent); }
.modul-meta { font-size: 11px; color: var(--text-muted); margin-top: 2px; }

.btn-icon { width: 30px; height: 30px; border-radius: 8px; border: 1px solid var(--border); background: var(--surface2); color: var(--text-muted); display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all .2s; font-size: 13px; }
.btn-icon:hover { background: var(--accent-light); border-color: var(--accent); color: var(--accent); }
.btn-icon-danger:hover { background: #fff0ed; border-color: var(--accent2); color: var(--accent2) !important; }

/* ============ ABSENSI STYLES ============ */
.absensi-bar { border: 1px solid var(--border); border-top: none; background: linear-gradient(135deg, #f0f9f4 0%, #fafffe 100%); padding: 14px 20px; display: flex; align-items: center; gap: 16px; flex-wrap: wrap; }
.absensi-bar.absensi-active { background: linear-gradient(135deg, #e8f5e9 0%, #f0fff4 100%); border-color: #a7d7c5; }
.absensi-bar.absensi-upcoming { background: linear-gradient(135deg, #fffbea 0%, #fffdf5 100%); border-color: #fcd34d66; }
.absensi-bar.absensi-ended { background: var(--surface2); border-color: var(--border); opacity: 0.8; }
.btn-absensi-live { display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: var(--accent); color: #fff; border: none; border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer; font-family: inherit; text-decoration: none; animation: pulse-green 2s infinite; transition: all .2s; }
.btn-absensi-live:hover { background: #1f4e37; transform: translateY(-1px); }
@keyframes pulse-green { 0%, 100% { box-shadow: 0 0 0 0 rgba(45,106,79,.4); } 50% { box-shadow: 0 0 0 6px rgba(45,106,79,0); } }
.absensi-countdown { display: flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 600; }
.countdown-timer { font-size: 13px; font-weight: 800; font-family: 'Courier New', monospace; letter-spacing: 1px; color: var(--accent); background: var(--accent-light); padding: 4px 10px; border-radius: 6px; border: 1px solid #a7d7c566; }
.countdown-timer.warning { color: #b45309; background: #fffbea; border-color: #fcd34d66; }
.countdown-timer.upcoming { color: #b45309; background: #fffbea; border-color: #fcd34d66; }
.absensi-label { font-size: 12px; font-weight: 600; display: flex; align-items: center; gap: 6px; }
.absensi-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--accent); animation: blink 1s infinite; }
@keyframes blink { 0%,100%{opacity:1} 50%{opacity:.3} }
.absensi-schedule-info { font-size: 11px; color: var(--text-muted); display: flex; align-items: center; gap: 4px; }

/* Toggle absensi dalam form */
.absensi-toggle-section { background: var(--surface2); border: 1.5px solid var(--border); border-radius: 12px; overflow: hidden; margin-bottom: 0; }
.absensi-toggle-header { display: flex; align-items: center; justify-content: space-between; padding: 14px 16px; cursor: pointer; user-select: none; transition: background .15s; }
.absensi-toggle-header:hover { background: var(--border); }
.absensi-toggle-header-left { display: flex; align-items: center; gap: 10px; font-size: 13px; font-weight: 700; color: var(--text); }
.absensi-toggle-body { display: none; padding: 16px; border-top: 1px solid var(--border); background: var(--surface); }
.absensi-toggle-body.open { display: block; }

/* Switch toggle */
.switch { position: relative; display: inline-block; width: 40px; height: 22px; flex-shrink: 0; }
.switch input { opacity: 0; width: 0; height: 0; }
.switch-slider { position: absolute; cursor: pointer; inset: 0; background: #ccc; border-radius: 22px; transition: .3s; }
.switch-slider:before { content: ''; position: absolute; height: 16px; width: 16px; left: 3px; bottom: 3px; background: white; border-radius: 50%; transition: .3s; }
.switch input:checked + .switch-slider { background: var(--accent); }
.switch input:checked + .switch-slider:before { transform: translateX(18px); }

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
.form-input, .form-textarea, .form-select { width: 100%; padding: 11px 14px; background: var(--surface2); border: 1.5px solid var(--border); border-radius: 10px; color: var(--text); font-family: inherit; font-size: 14px; transition: border .2s; }
.form-input:focus, .form-textarea:focus, .form-select:focus { outline: none; border-color: var(--accent); background: #fff; }
.form-textarea { min-height: 100px; resize: vertical; }
.form-static { padding: 11px 14px; background: var(--bg); border: 1.5px solid var(--border); border-radius: 10px; font-size: 14px; color: var(--text); }
.form-hint { font-size: 11px; color: var(--text-muted); margin-top: 5px; }
.form-divider { border: none; border-top: 1px solid var(--border); margin: 8px 0 18px; }
.form-section-title { font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 14px; }

.radio-group { display: flex; gap: 12px; }
.radio-option { flex: 1; }
.radio-option input[type="radio"] { display: none; }
.radio-option label { display: flex; align-items: center; justify-content: center; gap: 8px; padding: 10px; border: 1.5px solid var(--border); border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all .2s; background: var(--surface2); color: var(--text-muted); }
.radio-option input[type="radio"]:checked + label { border-color: var(--accent); background: var(--accent-light); color: var(--accent); }

.upload-area { position: relative; width: 100%; min-height: 110px; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 8px; padding: 24px; border: 2px dashed #2d6a4f66; border-radius: 14px; background: #faf8f5; text-align: center; cursor: pointer; transition: all .2s; }
.upload-area:hover { background: #eef8f1; border-color: var(--accent); }
.upload-area .upload-icon { font-size: 36px; line-height: 1; }
.upload-area .upload-text { font-size: 13px; color: var(--text-muted); line-height: 1.6; }
.upload-area .upload-text span { color: var(--accent); font-weight: 700; }
.upload-fname { margin-top: 4px; font-size: 12px; font-weight: 600; color: var(--accent); word-break: break-word; }

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

.alert { padding: 14px 18px; border-radius: 10px; font-size: 13px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
.alert-success { background: var(--accent-light); color: var(--accent); border: 1px solid #a7d7c566; }
.alert-error   { background: #fff0ed; color: var(--accent2); border: 1px solid #e76f5166; }

.notice-box { background: #fffbea; border: 1px solid #fcd34d66; border-radius: 12px; padding: 16px 20px; display: flex; align-items: center; gap: 14px; margin-bottom: 20px; }
.notice-box .notice-text { font-size: 13px; color: #92400e; line-height: 1.6; }

.page-section { display: none; }
.page-section.active { display: block; }

.empty-state { text-align: center; padding: 60px 20px; color: var(--text-muted); }
.empty-state .empty-icon { font-size: 48px; margin-bottom: 16px; }
.empty-state h3 { font-size: 16px; font-weight: 600; margin-bottom: 8px; color: var(--text); }
.empty-state p { font-size: 13px; line-height: 1.6; }

::-webkit-scrollbar { width: 5px; }
::-webkit-scrollbar-track { background: var(--bg); }
::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }

.btn-resubmit { animation: pulse-orange 2s infinite; }
@keyframes pulse-orange { 0%, 100% { box-shadow: 0 0 0 0 rgba(231,111,81,.3); } 50% { box-shadow: 0 0 0 4px rgba(231,111,81,0); } }

/* Upload area portrait 9:16 */
.upload-area-portrait {
    position: relative;
    width: 100%;
    max-width: 200px;
    margin: 0 auto;
    border: 2px dashed #2d6a4f66;
    border-radius: 14px;
    background: #faf8f5;
    cursor: pointer;
    transition: all .2s;
    overflow: hidden;
}
.upload-area-portrait::before {
    content: '';
    display: block;
    padding-top: 177.78%; /* 9:16 = 100/(9/16) */
}
.upload-area-portrait:hover { background: #eef8f1; border-color: var(--accent); }
.upload-area-portrait-inner {
    position: absolute;
    inset: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 16px;
    text-align: center;
}
.upload-area-portrait img.portrait-preview {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 12px;
    z-index: 1;
}
.upload-area-portrait .portrait-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,.45);
    border-radius: 12px;
    z-index: 2;
    display: none;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 6px;
}
.upload-area-portrait-label {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 11px;
    font-weight: 700;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 6px;
}
.upload-area-portrait-label span {
    background: var(--accent-light);
    color: var(--accent);
    border: 1px solid #a7d7c566;
    padding: 2px 8px;
    border-radius: 20px;
    font-size: 10px;
}
.upload-error { font-size: 11px; color: var(--accent2); margin-top: 5px; display: none; }
/* ============ ALAMAT GROUP ============ */
/* Selalu tampil, tidak disembunyikan agar selalu terkirim */
#k-alamat-group { display: block; }
#k-alamat-group.hidden-alamat {
    display: none !important;
}

/* ============ HAMBURGER BUTTON ============ */
.hamburger {
    display: none;
    flex-direction: column;
    gap: 5px;
    cursor: pointer;
    padding: 8px;
    border-radius: 10px;
    background: var(--surface2);
    border: 1px solid var(--border);
    flex-shrink: 0;
}
.hamburger span {
    display: block;
    width: 20px;
    height: 2px;
    background: var(--text);
    border-radius: 2px;
    transition: all .3s;
}

/* ============ SIDEBAR OVERLAY (mobile) ============ */
.sidebar-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.45);
    z-index: 99;
    backdrop-filter: blur(2px);
}
.sidebar-overlay.open { display: block; }

/* ============ RESPONSIVE: LARGE SCREEN (≥1400px) ============ */
@media (min-width: 1400px) {
    .content { padding: 36px 48px; }
    .stats-grid { grid-template-columns: repeat(4, 1fr); gap: 20px; }
    .stat-value { font-size: 34px; }
}

/* ============ RESPONSIVE: TABLET (769px – 1100px) ============ */
@media (min-width: 769px) and (max-width: 1100px) {
    .sidebar { width: 220px; }
    .main { margin-left: 220px; }
    .stats-grid { grid-template-columns: repeat(2, 1fr); }
    .content { padding: 24px 20px; }
    .topbar { padding: 14px 20px; }
    .modal { width: 90vw !important; }
}

/* ============ RESPONSIVE: MOBILE (≤768px) ============ */
@media (max-width: 768px) {
    /* Sidebar */
    .sidebar {
        transform: translateX(-100%);
        transition: transform .3s ease;
        width: 260px;
        z-index: 100;
        box-shadow: 4px 0 24px rgba(0,0,0,.2);
    }
    .sidebar.open {
        transform: translateX(0);
    }

    /* Main */
    .main { margin-left: 0; }

    /* Topbar */
    .topbar { padding: 12px 16px; gap: 10px; }
    .topbar-title { font-size: 18px; }
    .hamburger { display: flex; }

    /* Sembunyikan tombol lihat website di mobile */
    .topbar .btn-ghost { display: none; }

    /* Greeting teks */
    .topbar > div > span { display: none; }

    /* Content */
    .content { padding: 16px; }

    /* Stats grid */
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin-bottom: 20px;
    }
    .stat-value { font-size: 24px; }
    .stat-card { padding: 16px; }

    /* Tables */
    .table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }

    /* Khusus tabel Status Terbaru di beranda — sembunyikan kolom Tanggal */
    @media (max-width: 480px) {
        /* Sembunyikan kolom Tanggal (kolom ke-3) */
        #page-beranda table thead th:nth-child(3),
        #page-beranda table tbody td:nth-child(3) {
            display: none;
        }
        /* Sembunyikan kolom Lokasi di tabel event (kolom ke-2) */
        #page-event table thead th:nth-child(2),
        #page-event table tbody td:nth-child(2) {
            display: none;
        }
        /* Perkecil padding sel tabel */
        tbody td, thead th { padding: 10px 10px; }
        
        /* Perkecil font badge di tabel */
        .badge { font-size: 10px; padding: 3px 7px; }
        .chip  { font-size: 10px; padding: 2px 8px; }
    }

    /* Form rows */
    .form-row { grid-template-columns: 1fr; gap: 0; }

    /* Kurikulum block header */
    .kurikulum-block-header {
        flex-wrap: wrap;
        gap: 10px;
        padding: 14px;
    }
    .kurikulum-block-header > div:last-child {
        width: 100%;
        justify-content: flex-end;
        flex-wrap: wrap;
    }
    .k-meta { gap: 8px; }

    /* Section header */
    .section-header { flex-direction: column; align-items: flex-start; gap: 12px; }
    .section-actions { width: 100%; display: flex; flex-wrap: wrap; gap: 8px; }
    .section-actions .btn { flex: 1; justify-content: center; }

    /* Modal */
    .modal-overlay { align-items: flex-end; }
    .modal {
        width: 100% !important;
        max-height: 92vh;
        border-radius: 20px 20px 0 0;
        padding: 24px 20px;
    }

    /* Profile hero */
    .profile-hero { flex-direction: column; text-align: center; gap: 16px; padding: 24px 20px; }
    .profile-hero button { margin-left: 0 !important; width: 100%; justify-content: center; }

    /* Absensi bar */
    .absensi-bar { padding: 12px 14px; gap: 10px; }
    .btn-absensi-live { width: 100%; justify-content: center; }

    /* Radio group */
    .radio-group { flex-direction: column; }

    /* Modul row */
    .modul-row { flex-wrap: wrap; gap: 10px; }
    .modul-row > div:last-child { margin-left: auto; }

    /* User card di sidebar */
    .user-name { font-size: 12px; }
}

/* ============ CARD TABLE MOBILE ============ */
@media (max-width: 768px) {
    /* Hapus min-width paksa */
    table { min-width: unset; width: 100%; }

    /* Sembunyikan thead */
    #page-beranda .table-wrap thead,
    #page-event .table-wrap thead { display: none; }

    /* Ubah tbody jadi block */
    #page-beranda .table-wrap tbody,
    #page-event .table-wrap tbody { display: block; }

    /* Setiap baris jadi kartu */
    #page-beranda .table-wrap tbody tr,
    #page-event .table-wrap tbody tr {
        display: flex;
        flex-direction: column;
        border: 1px solid var(--border);
        border-radius: 12px;
        margin: 10px 12px;
        padding: 12px 14px;
        background: var(--surface);
        box-shadow: var(--shadow);
        gap: 6px;
    }

    /* Semua td jadi block */
    #page-beranda .table-wrap tbody td,
    #page-event .table-wrap tbody td {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 2px 0;
        font-size: 13px;
        border: none;
    }

    /* Label otomatis sebelum setiap kolom */
    #page-beranda .table-wrap tbody td::before,
    #page-event .table-wrap tbody td::before {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--text-muted);
        min-width: 60px;
        flex-shrink: 0;
    }

    /* Beranda: Nama, Tipe, Tanggal, Status */
    #page-beranda .table-wrap tbody td:nth-child(1)::before { content: 'Nama'; }
    #page-beranda .table-wrap tbody td:nth-child(2)::before { content: 'Tipe'; }
    #page-beranda .table-wrap tbody td:nth-child(3)::before { content: 'Tanggal'; }
    #page-beranda .table-wrap tbody td:nth-child(4)::before { content: 'Status'; }

    /* Event: Nama, Lokasi, Tanggal, Kapasitas, Status, Aksi */
    #page-event .table-wrap tbody td:nth-child(1)::before  { content: 'Event'; }
    #page-event .table-wrap tbody td:nth-child(2)::before  { content: 'Lokasi'; }
    #page-event .table-wrap tbody td:nth-child(3)::before  { content: 'Tanggal'; }
    #page-event .table-wrap tbody td:nth-child(4)::before  { content: 'Kapasitas'; }
    #page-event .table-wrap tbody td:nth-child(5)::before  { content: 'Status'; }
    #page-event .table-wrap tbody td:nth-child(6)::before  { content: 'Aksi'; }

    /* Kolom nama rata atas (karena ada catatan admin) */
    #page-event .table-wrap tbody td:nth-child(1) { align-items: flex-start; }

    /* Hapus border antar baris lama */
    #page-beranda .table-wrap tbody tr,
    #page-event .table-wrap tbody tr { border-bottom: none !important; }

    /* Tambah garis pemisah antar label-value */
    #page-beranda .table-wrap tbody td:not(:last-child),
    #page-event .table-wrap tbody td:not(:last-child) {
        padding-bottom: 6px;
        border-bottom: 1px solid var(--surface2);
    }

    /* Stat card teks tidak terpotong */
    .stat-label { font-size: 11px; }
    .stat-sub   { font-size: 11px; }

    /* Topbar greeting sembunyikan di mobile */
    .topbar > div > span { display: none; }
}
/* ============ RESPONSIVE: MOBILE KECIL (≤400px) ============ */
@media (max-width: 400px) {
    .stats-grid { grid-template-columns: 1fr; }
    .stat-value { font-size: 28px; }
    .topbar-title { font-size: 16px; }
}

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
                <div class="brand-name">KAJI Indonesia</div>
                <div class="brand-role">Trainer</div>
            </div>
        </div>
    </div>
    <div class="nav-section">
        <div class="nav-label">Menu Utama</div>
        <div class="nav-item active" onclick="showPage('beranda')">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
            Beranda
        </div>
        <div class="nav-item" onclick="showPage('program')">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            Program / Pelatihan
            @if(isset($pendingPelatihanCount) && $pendingPelatihanCount > 0)
                <span class="nav-badge">{{ $pendingPelatihanCount }}</span>
            @endif
        </div>
        <div class="nav-item" onclick="showPage('event')">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            Event
            @if(isset($pendingEventCount) && $pendingEventCount > 0)
                <span class="nav-badge">{{ $pendingEventCount }}</span>
            @endif
        </div>
    </div>
    <div class="nav-section">
        <div class="nav-label">Akun</div>
        <div class="nav-item" onclick="showPage('profil')">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            Profil Saya
        </div>
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-item">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
            Keluar
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">@csrf</form>
    </div>
    <div class="sidebar-user">
        <div class="user-card" onclick="showPage('profil')">
        <div class="user-avatar">
        @php $fotoSidebar = $trainer?->foto ?? null; @endphp
@if($fotoSidebar)
    <img src="{{ asset('storage/' . $fotoSidebar) }}" alt="{{ auth()->user()->name }}">
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

<div class="sidebar-overlay" id="sidebar-overlay" onclick="closeSidebar()"></div>

{{-- ============ MAIN ============ --}}
<main class="main">
<header class="topbar">
    <button class="hamburger" onclick="toggleSidebar()" aria-label="Toggle Menu">
        <span></span>
        <span></span>
        <span></span>
    </button>
    <div class="topbar-title" id="page-title">Dashboard Trainer</div>
    <div style="display:flex;gap:10px;align-items:center">
        <span style="font-size:13px;color:var(--text-muted)">Halo, {{ auth()->user()->name }} 👋</span>
        <a href="{{ url('/') }}" target="_blank" class="btn btn-ghost" style="font-size:13px;padding:8px 16px">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M12 2a10 10 0 100 20A10 10 0 0012 2z"/>
                <path d="M2 12h20M12 2a15.3 15.3 0 010 20M12 2a15.3 15.3 0 000 20"/>
            </svg>
            Lihat Website
        </a>
    </div>
</header>

<div class="content">

    {{-- ============ BERANDA ============ --}}
    <div class="page-section active" id="page-beranda">
        @if(session('success'))<div class="alert alert-success">✅ {{ session('success') }}</div>@endif
        @if(session('error'))<div class="alert alert-error">⚠️ {{ session('error') }}</div>@endif

        <div class="stats-grid">
            <div class="stat-card green">
                <div class="stat-icon">📚</div>
                <div class="stat-label">Total Kurikulum</div>
                <div class="stat-value">{{ $totalKurikulum ?? 0 }}</div>
                <div class="stat-sub">Kurikulum yang diajukan</div>
            </div>
            <div class="stat-card teal">
                <div class="stat-icon">📝</div>
                <div class="stat-label">Total Modul</div>
                <div class="stat-value">{{ $totalModul ?? 0 }}</div>
                <div class="stat-sub">Modul dalam kurikulum</div>
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
            <div class="section-title">Status Terbaru <span>program & modul</span></div>
        </div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>Nama</th><th>Tipe</th><th>Tanggal</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse($recentSubmissions ?? [] as $item)
                    <tr>
                        <td style="font-weight:500">{{ $item->judul ?? $item->nama }}</td>
                        <td><span class="chip chip-{{ $item->tipe ?? 'kurikulum' }}">{{ ucfirst($item->tipe ?? '-') }}</span></td>
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
                    <tr><td colspan="4" style="text-align:center;padding:40px;color:var(--text-muted)">Belum ada program atau event yang diajukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ============ PROGRAM ============ --}}
    <div class="page-section" id="page-program">
        @if(session('success'))<div class="alert alert-success">✅ {{ session('success') }}</div>@endif
        @if(session('error'))<div class="alert alert-error">⚠️ {{ session('error') }}</div>@endif

        <div class="section-header">
            <div class="section-title">Program / Pelatihan <span>{{ ($totalKurikulum ?? 0) + ($totalModul ?? 0) }} total</span></div>
            <div class="section-actions">
                <button class="btn btn-secondary" onclick="openModalModul()">
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    + Tambah Modul
                </button>
                <button class="btn btn-primary" onclick="openModal('modal-kurikulum')">
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                    + Tambah Kurikulum
                </button>
            </div>
        </div>

        @php
            $kurikulumList   = isset($pelatihanList) ? $pelatihanList->where('tipe', 'kurikulum') : collect();
            $modulList       = isset($pelatihanList) ? $pelatihanList->where('tipe', 'modul')     : collect();
            $adaKurikulumVar = $kurikulumList->count() > 0;
        @endphp

        @if($adaKurikulumVar)
            @foreach($kurikulumList as $k)
            @php
                $modulDalamK = $modulList->where('kurikulum_id', $k->id)->sortBy('urutan');
                $absensiAktif   = !empty($k->absensi_mulai) && !empty($k->absensi_selesai) && $k->absensi_aktif;
                $absensiMulai   = $absensiAktif ? \Carbon\Carbon::parse($k->absensi_mulai, 'Asia/Jakarta') : null;
$absensiSelesai = $absensiAktif ? \Carbon\Carbon::parse($k->absensi_selesai, 'Asia/Jakarta') : null;                $absensiUrl     = $k->absensi_url ?? '#';
                $now            = \Carbon\Carbon::now();
                $statusAbsensi  = null;
                if ($absensiAktif) {
                    if ($now->lt($absensiMulai))                           $statusAbsensi = 'upcoming';
                    elseif ($now->between($absensiMulai, $absensiSelesai)) $statusAbsensi = 'active';
                    else                                                   $statusAbsensi = 'ended';
                }
                $jumlahAbsensi = \App\Models\AbsensiPeserta::where('pelatihan_id', $k->id)->count();
            @endphp
            <div class="kurikulum-block">
                <div class="kurikulum-block-header">
                    <div style="width:42px;height:42px;border-radius:10px;background:var(--surface2);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;overflow:hidden;">
                        @if($k->gambar)
                            <img src="{{ asset('storage/'.$k->gambar) }}" style="width:100%;height:100%;object-fit:cover;">
                        @else 📚 @endif
                    </div>
                    <div style="flex:1">
                        <div class="k-title">{{ $k->judul }}</div>
                        <div class="k-meta">
                            <span>{{ $modulDalamK->count() }} materi</span>
                            @if($k->total_jam) <span>⏱ {{ (int) $k->total_jam }} jam</span> @endif
                            @if($k->jumlah_sesi) <span>📅 {{ $k->jumlah_sesi }} sesi</span> @endif
                            @if($k->sertifikat) <span>🏆 Sertifikat</span> @endif
                            @if($k->tingkat) <span>{{ ucfirst($k->tingkat) }}</span> @endif
                            @if($k->metode) <span>{{ ucfirst($k->metode) }}</span> @endif
                            @if($k->alamat) <span>📍 {{ Str::limit($k->alamat, 30) }}</span> @endif
                        </div>
                    </div>
                    <div style="display:flex;align-items:center;gap:10px;flex-shrink:0">
                        @if(($k->status ?? '') === 'approved')
                            <span class="badge badge-approved"><span class="badge-dot"></span>Disetujui</span>
                        @elseif(($k->status ?? '') === 'rejected')
                            <span class="badge badge-rejected"><span class="badge-dot"></span>Ditolak</span>
                        @else
                            <span class="badge badge-pending"><span class="badge-dot"></span>Menunggu</span>
                        @endif

                        <button class="btn btn-sm" style="background:#e8f5e9;color:#2d6a4f;border:1.5px solid #a7d7c5;font-weight:700;gap:6px;flex-shrink:0"
                            onclick="bukaDaftarAbsensi({{ $k->id }}, '{{ addslashes($k->judul) }}')">
                            👥 Absensi
                            @if($jumlahAbsensi > 0)
                                <span style="background:#2d6a4f;color:#fff;font-size:10px;font-weight:700;padding:1px 7px;border-radius:20px;margin-left:2px">{{ $jumlahAbsensi }}</span>
                            @endif
                        </button>

                        <button class="btn btn-sm btn-outline" onclick="openModalModulDenganKurikulum({{ $k->id }}, '{{ addslashes($k->judul) }}')">+ Modul</button>

                        <button class="btn-icon btn-edit-kurikulum"
                            data-id="{{ $k->id }}"
                            data-judul="{{ $k->judul }}"
                            data-deskripsi="{{ $k->deskripsi ?? '' }}"
                            data-metode="{{ $k->metode ?? '' }}"
                            data-tingkat="{{ $k->tingkat ?? '' }}"
                            data-bahasa="{{ $k->bahasa ?? 'Bahasa Indonesia' }}"
                            data-total-jam="{{ $k->total_jam ?? '' }}"
                            data-jumlah-sesi="{{ $k->jumlah_sesi ?? '' }}"
                            data-sertifikat="{{ $k->sertifikat ? 1 : 0 }}"
                            data-phone="{{ $k->phone ?? auth()->user()->phone ?? '' }}"
                            data-biaya="{{ $k->biaya ?? '' }}"
                            data-absensi-aktif="{{ !empty($k->absensi_mulai) ? 1 : 0 }}"
                            data-absensi-mulai="{{ $k->absensi_mulai ?? '' }}"
                            data-absensi-selesai="{{ $k->absensi_selesai ?? '' }}"
                            data-absensi-url="{{ $k->absensi_url ?? '' }}"
                        data-alamat="{{ json_encode($k->alamat ?? '') }}"
                        data-gambar-url="{{ $k->gambar ? asset('storage/'.$k->gambar) : '' }}"
                            title="Edit Kurikulum">
                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        </button>

                        <button class="btn-icon btn-icon-danger" onclick="hapusItem({{ $k->id }}, 'kurikulum')" title="Hapus">
                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6M9 6V4h6v2"/></svg>
                        </button>
                    </div>
                </div>

                @if($absensiAktif)
                <div class="absensi-bar absensi-{{ $statusAbsensi }}"
                     id="absensi-bar-{{ $k->id }}"
                     data-mulai="{{ $absensiMulai ? $absensiMulai->timestamp : 0 }}"
                     data-selesai="{{ $absensiSelesai ? $absensiSelesai->timestamp : 0 }}"
                     data-url="{{ $absensiUrl }}">
                    @if($statusAbsensi === 'active')
                        <div class="absensi-label"><span class="absensi-dot"></span>Absensi Sedang Berlangsung</div>
                        <a href="{{ $absensiUrl }}" target="_blank" class="btn-absensi-live">✅ Buka Link Absensi</a>
                        <div class="absensi-countdown">
                            <span style="color:var(--text-muted);font-size:11px">Berakhir dalam</span>
                            <span class="countdown-timer" id="timer-{{ $k->id }}">--:--:--</span>
                        </div>
                    @elseif($statusAbsensi === 'upcoming')
                        <div style="font-size:20px">⏰</div>
                        <div>
                            <div class="absensi-label" style="color:#92400e">Absensi Akan Dibuka</div>
                            <div class="absensi-schedule-info">{{ $absensiMulai->translatedFormat('d M Y, H:i') }} – {{ $absensiSelesai->format('H:i') }} WIB</div>
                        </div>
                        <div class="absensi-countdown" style="margin-left:auto">
                            <span style="color:var(--text-muted);font-size:11px">Dibuka dalam</span>
                            <span class="countdown-timer upcoming" id="timer-{{ $k->id }}">--:--:--</span>
                        </div>
                    @else
                        <div style="font-size:18px">🔒</div>
                        <div>
                            <div class="absensi-label" style="color:var(--text-muted)">Absensi Telah Ditutup</div>
                            <div class="absensi-schedule-info">Selesai {{ $absensiSelesai->translatedFormat('d M Y, H:i') }} WIB</div>
                        </div>
                    @endif
                </div>
                @endif

                @if($modulDalamK->count() > 0)
                <div class="modul-list">
                    @foreach($modulDalamK as $m)
                    <div class="modul-row">
                        <div style="width:32px;height:32px;border-radius:50%;background:var(--accent);color:#fff;font-size:13px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;">{{ $m->urutan ?? $loop->iteration }}</div>
                        <div class="modul-info">
                            <div class="modul-title">{{ $m->judul }}</div>
                            @if($m->deskripsi)<div class="modul-meta">{{ $m->deskripsi }}</div>@endif
                        </div>
                        <div style="display:flex;align-items:center;gap:8px;flex-shrink:0">
                            @if(($m->status ?? '') === 'approved')
                                <span class="badge badge-approved" style="font-size:10px;padding:3px 8px"><span class="badge-dot"></span>Disetujui</span>
                            @elseif(($m->status ?? '') === 'rejected')
                                <span class="badge badge-rejected" style="font-size:10px;padding:3px 8px"><span class="badge-dot"></span>Ditolak</span>
                            @else
                                <span class="badge badge-pending" style="font-size:10px;padding:3px 8px"><span class="badge-dot"></span>Menunggu</span>
                            @endif
                            <button class="btn-icon" onclick="editModul({{ $m->id }}, {{ $m->kurikulum_id ?? 'null' }}, '{{ addslashes($m->judul) }}', '{{ addslashes($m->deskripsi ?? '') }}', '{{ $m->urutan ?? $loop->iteration }}')" title="Edit Modul">
                                <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </button>
                            <button class="btn-icon btn-icon-danger" onclick="hapusItem({{ $m->id }}, 'modul')" title="Hapus">
                                <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6M9 6V4h6v2"/></svg>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="modul-list">
                    <div style="padding:20px 24px;font-size:13px;color:var(--text-muted);display:flex;align-items:center;gap:10px">
                        <span>📭</span> Belum ada modul.
                        <button class="btn btn-sm btn-outline" style="margin-left:4px" onclick="openModalModulDenganKurikulum({{ $k->id }}, '{{ addslashes($k->judul) }}')">Tambah sekarang</button>
                    </div>
                </div>
                @endif

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
                    <p>Mulai dengan membuat kurikulum, lalu tambahkan modul ke dalamnya.</p>
                </div>
            </div>
        @endif
    </div>

    {{-- ============ EVENT ============ --}}
    <div class="page-section" id="page-event">
        @if(session('success'))<div class="alert alert-success">✅ {{ session('success') }}</div>@endif
        <div class="section-header">
            <div class="section-title">Event <span>{{ $totalEvent ?? 0 }} total</span></div>
            <button class="btn btn-primary" onclick="openModal('modal-event')">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Event
            </button>
        </div>
        @if(isset($eventList) && $eventList->count() > 0)
            <div class="table-wrap">
                <table>
                    <thead><tr><th>Nama Event</th><th>Lokasi</th><th>Tanggal</th><th>Kapasitas</th><th>Status</th><th>Aksi</th></tr></thead>
                    <tbody>
                    @foreach($eventList as $event)
                        @php
                            $eTanggal      = \Carbon\Carbon::parse($event->tanggal)->format('Y-m-d');
                            $eWaktuMulai   = $event->waktu_mulai   ? \Carbon\Carbon::parse($event->waktu_mulai)->format('H:i')   : '';
                            $eWaktuSelesai = $event->waktu_selesai ? \Carbon\Carbon::parse($event->waktu_selesai)->format('H:i') : '';
                            $eGambar       = $event->gambar        ? asset('storage/' . $event->gambar) : '';
                        @endphp
                        <tr>
                            <td>
                                <div style="display:flex;align-items:flex-start;gap:10px;">
                                    <div style="width:42px;height:42px;border-radius:8px;overflow:hidden;background:#f0f0f0;flex-shrink:0;border:1px solid var(--border);display:flex;align-items:center;justify-content:center;font-size:18px;">
                                        @if($event->gambar)
                                            <img src="{{ asset('storage/' . $event->gambar) }}" alt="{{ $event->judul }}" style="width:100%;height:100%;object-fit:cover;">
                                        @else 🎪 @endif
                                    </div>
                                    <div style="flex:1;min-width:0;">
                                        <div style="font-weight:600;font-size:13px;">{{ $event->judul ?? $event->nama }}</div>
                                        @if($event->status === 'rejected' && $event->catatan_admin)
                                            <div style="margin-top:5px;background:#fff0ed;border:1px solid #e76f5166;border-radius:8px;padding:6px 10px;">
                                                <div style="font-size:10px;font-weight:700;color:var(--accent2);text-transform:uppercase;letter-spacing:.06em;margin-bottom:2px;">📋 Catatan Admin</div>
                                                <div style="font-size:12px;color:#b45309;line-height:1.5;">{{ $event->catatan_admin }}</div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td style="font-size:13px;">{{ $event->lokasi ?? '-' }}</td>
                            <td style="font-size:13px;">{{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('d M Y') }}</td>
                            <td style="font-size:13px;">{{ $event->kapasitas ?? '-' }}</td>
                            <td>
                                @if($event->status === 'approved') <span class="badge badge-approved"><span class="badge-dot"></span>Disetujui</span>
                                @elseif($event->status === 'rejected') <span class="badge badge-rejected"><span class="badge-dot"></span>Ditolak</span>
                                @else <span class="badge badge-pending"><span class="badge-dot"></span>Menunggu</span>
                                @endif
                            </td>
                            <td>
                                <div style="display:flex;gap:6px;align-items:center;">
                                    <button class="btn-icon {{ $event->status === 'rejected' ? 'btn-resubmit' : '' }}"
                                        style="{{ $event->status === 'rejected' ? 'background:#fff0ed;border-color:#e76f51;color:#e76f51;' : '' }}"
                                        onclick="editEvent({{ $event->id }},'{{ addslashes($event->judul ?? $event->nama) }}','{{ $eTanggal }}','{{ $eWaktuMulai }}','{{ $eWaktuSelesai }}','{{ addslashes($event->lokasi ?? '') }}','{{ $event->kapasitas ?? '' }}','{{ addslashes($event->biaya ?? '') }}','{{ addslashes($event->deskripsi ?? '') }}','{{ $eGambar }}','{{ $event->phone ?? auth()->user()->phone ?? '' }}')"
                                        title="{{ $event->status === 'rejected' ? 'Edit & Kirim Ulang' : 'Edit' }}">
                                        @if($event->status === 'rejected')
                                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 11-2.12-9.36L23 10"/></svg>
                                        @else
                                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                        @endif
                                    </button>
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
    </div>

    {{-- ============ PROFIL ============ --}}
    <div class="page-section" id="page-profil">
        @if(session('success'))<div class="alert alert-success">✅ {{ session('success') }}</div>@endif
        <div class="profile-hero">
        <div class="profile-avatar-xl">
        @php $fotoHero = $trainer?->foto ?? null; @endphp
@if($fotoHero)
    <img src="{{ asset('storage/' . $fotoHero) }}" alt="{{ auth()->user()->name }}">
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
        <div class="profile-form-card">
    <div class="form-row">
        <div class="form-group">
            <div class="form-label">Nama Lengkap</div>
            <div class="form-static">{{ auth()->user()->name }}</div>
        </div>
        <div class="form-group">
            <div class="form-label">Nama & Gelar (Publik)</div>
            <div class="form-static">{{ $trainer?->academic_degree ?? auth()->user()->name }}</div>
            <div class="form-hint">Yang tampil di halaman daftar trainer</div>
        </div>
        <div class="form-group">
            <div class="form-label">Email</div>
            <div class="form-static">{{ auth()->user()->email }}</div>
        </div>
        <div class="form-group">
            <div class="form-label">No. Telepon / WhatsApp</div>
            <div class="form-static" style="display:flex;align-items:center;gap:8px">
                @if(auth()->user()->phone)
                    <span style="color:#25d366">✓</span> {{ auth()->user()->phone }}
                @else
                    <span style="color:var(--text-muted);font-style:italic">Belum diisi</span>
                @endif
            </div>
        </div>
        <div class="form-group" style="grid-column: 1 / -1">
            <div class="form-label">Bidang Keahlian Ditampilkan</div>
            @php
                $keahlianList = array_values(array_filter(
                    array_map('trim', explode(',', $trainer?->keahlian ?? ''))
                ));
            @endphp
            <div class="form-static">
                {{ $trainer?->displayed_bidang ?? ($keahlianList[0] ?? '-') }}
            </div>
            <div class="form-hint">Klik "Edit Profil" untuk mengubah.</div>
        </div>
    </div>
    <div class="form-group">
        <div class="form-label">Bio / Tentang Saya</div>
        <div class="form-static" style="min-height:80px;line-height:1.7">
            {{ $trainer?->bio ?? 'Belum ada bio.' }}
            </div>
</div>
</div> 
</div> 
</div>
</div> 
</main>

{{-- ============ MODAL KURIKULUM ============ --}}
<div class="modal-overlay" id="modal-kurikulum">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">
                <span id="modal-kurikulum-title-text">Tambah Kurikulum</span>
                <small id="modal-kurikulum-subtitle">Isi detail kurikulum, modul dapat ditambah setelah kurikulum tersimpan</small>
            </div>
            <button class="modal-close" onclick="resetKurikulumModal(); closeModal('modal-kurikulum')">×</button>
        </div>
        <form id="form-kurikulum" method="POST" enctype="multipart/form-data" action="{{ route('trainer.kurikulum.store') }}">
            @csrf
            <input type="hidden" name="tipe" value="kurikulum">
            <input type="hidden" name="_method" id="kurikulum-method" value="POST">
            <input type="hidden" name="kurikulum_edit_id" id="kurikulum-edit-id">

            <div class="form-group">
                <label class="form-label">Nama Kurikulum <span style="color:var(--accent2)">*</span></label>
                <input class="form-input" type="text" name="judul" id="k-judul" placeholder="Contoh: Kursus Digital Marketing Terapan..." required>
            </div>
            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <textarea class="form-textarea" name="deskripsi" id="k-deskripsi" rows="3" placeholder="Jelaskan tujuan dan isi kurikulum ini..." maxlength="500" required></textarea>
            </div>

            <hr class="form-divider">
            <div class="form-section-title">Informasi Kurikulum</div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px">
                <div class="form-group">
                    <label class="form-label">Total Jam Pelajaran <span style="color:var(--accent2)">*</span></label>
                    <input class="form-input" type="number" name="total_jam" id="k-total-jam" placeholder="Contoh: 20" min="1" step="1" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Jumlah Sesi <span style="color:var(--accent2)">*</span></label>
                    <input class="form-input" type="number" name="jumlah_sesi" id="k-jumlah-sesi" placeholder="Contoh: 5" min="1" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Ada Sertifikat?</label>
                <div class="radio-group">
                    <div class="radio-option"><input type="radio" name="sertifikat" id="sertifikat-ya" value="1"><label for="sertifikat-ya">🏆 Ya, ada sertifikat</label></div>
                    <div class="radio-option"><input type="radio" name="sertifikat" id="sertifikat-tidak" value="0" checked><label for="sertifikat-tidak">Tidak ada sertifikat</label></div>
                </div>
            </div>

            <hr class="form-divider">
            <div class="form-section-title">Informasi Tambahan</div>

            <div class="form-row">
            <div class="form-group">
                    <label class="form-label">Metode <span style="color:var(--accent2)">*</span></label>
                    <select class="form-select" name="metode" id="k-metode" onchange="toggleAlamat(this.value)" required>
                        <option value="" disabled selected>-- Pilih --</option>
                        <option value="online">Online</option>
                        <option value="offline">Offline</option>
                        <option value="hybrid">Online & Offline / Hybrid</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Tingkat <span style="color:var(--accent2)">*</span></label>
                    <select class="form-select" name="tingkat" id="k-tingkat" required>
                        <option value="" disabled selected>-- Pilih --</option>
                        <option value="pemula">Pemula</option>
                        <option value="menengah">Menengah</option>
                        <option value="lanjut">Lanjut</option>
                    </select>
                </div>
            </div>

            {{-- 
                PENTING: Field alamat SELALU ada di DOM dan SELALU terkirim.
                Visibilitas dikontrol via CSS class, bukan display:none pada elemen berisi name=
            --}}
            <div class="form-group" id="k-alamat-group">
                <label class="form-label">Alamat Lokasi</label>
                <textarea class="form-textarea" name="alamat" id="k-alamat" rows="2"
                    placeholder="Contoh: Jl. Raya Darmo No. 45, Surabaya"></textarea>
                <div class="form-hint">Alamat tempat pelatihan offline/hybrid berlangsung</div>
            </div>

            <div class="form-group">
                <label class="form-label">No. WhatsApp untuk Pendaftaran <span style="color:var(--accent2)">*</span></label>
                <input class="form-input" type="text" name="phone" id="k-phone"
                       value="{{ auth()->user()->phone ?? '' }}"
                       placeholder="Contoh: 6281234567890"
                       pattern="^[0-9]{9,15}$"
                       title="Masukkan nomor WhatsApp valid (9–15 digit angka)"
                       required>
                <div class="form-hint">Otomatis diisi dari profil. Ubah jika ingin nomor berbeda untuk kurikulum ini.</div>
            </div>

            <div class="form-row">
    <div class="form-group">
        <label class="form-label">Bahasa <span style="color:var(--accent2)">*</span></label>
        <input class="form-input" type="text" name="bahasa" id="k-bahasa"
               value="Bahasa Indonesia" placeholder="Contoh: Bahasa Indonesia" required>
    </div>
    <div class="form-group">
        <label class="form-label">Biaya <span style="color:var(--accent2)">*</span></label>
        <select class="form-select" name="biaya" id="k-biaya" required>
            <option value="" disabled selected>-- Pilih --</option>
            <option value="Gratis">Gratis</option>
            <option value="Berbayar">Berbayar</option>
        </select>
    </div>
</div>

<div class="form-group">
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px">
                    <div class="form-label" style="margin-bottom:0">Poster Kurikulum <span style="color:var(--accent2)">*</span></div>
                    <span style="background:var(--accent-light);color:var(--accent);border:1px solid #a7d7c566;padding:2px 8px;border-radius:20px;font-size:10px;font-weight:700;letter-spacing:.5px">📐 9 : 16 PORTRAIT</span>
                </div>
                <div style="display:flex;gap:16px;align-items:flex-start;flex-wrap:wrap">
                    {{-- Preview area portrait --}}
                    <label for="k-gambar" id="k-gambar-area"
                           style="position:relative;width:120px;flex-shrink:0;border:2px dashed #2d6a4f66;border-radius:14px;background:#faf8f5;cursor:pointer;transition:all .2s;overflow:hidden;display:block"
                           onmouseover="this.style.borderColor='var(--accent)';this.style.background='#eef8f1'"
                           onmouseout="this.style.borderColor='#2d6a4f66';this.style.background='#faf8f5'">
                        {{-- padding-top 177.78% = rasio 9:16 --}}
                        <div style="padding-top:177.78%"></div>
                        {{-- Placeholder --}}
                        <div id="k-gambar-placeholder"
                             style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:6px;padding:12px;text-align:center">
                            <div style="font-size:28px">🖼️</div>
                            <div style="font-size:11px;color:var(--text-muted);line-height:1.5">Upload<br><span style="color:var(--accent);font-weight:700">PNG / JPG</span></div>
                        </div>
                        {{-- Preview gambar --}}
                        <img id="k-gambar-preview" src="" alt="preview"
                             style="display:none;position:absolute;inset:0;width:100%;height:100%;object-fit:cover;border-radius:12px;z-index:1">
                        {{-- Overlay ganti --}}
                        <div id="k-gambar-overlay"
                             style="display:none;position:absolute;inset:0;background:rgba(0,0,0,.5);border-radius:12px;z-index:2;flex-direction:column;align-items:center;justify-content:center;gap:4px">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#fff" stroke-width="2">
                                <path d="M23 19a2 2 0 01-2 2H3a2 2 0 01-2-2V8a2 2 0 012-2h4l2-3h6l2 3h4a2 2 0 012 2z"/>
                                <circle cx="12" cy="13" r="4"/>
                            </svg>
                            <span style="font-size:10px;font-weight:700;color:#fff">Ganti</span>
                        </div>
                    </label>
                    {{-- Info & feedback --}}
                    <div style="flex:1;min-width:150px">
                        <div style="background:#fffbea;border:1px solid #fcd34d66;border-radius:10px;padding:11px 13px;font-size:12px;color:#92400e;line-height:1.8;margin-bottom:8px">
                            <strong>📐 Wajib rasio 9:16 (portrait)</strong><br>
                            Ukuran yang disarankan:<br>
                            • <strong>1080 × 1920</strong> px (Full HD)<br>
                            • <strong>720 × 1280</strong> px<br>
                            • <strong>540 × 960</strong> px
                        </div>
                        <div class="upload-fname" id="k-gambar-name" style="font-size:12px;word-break:break-word"></div>
                        <div id="k-gambar-error"
                             style="display:none;font-size:11px;color:var(--accent2);background:#fff0ed;border:1px solid #e76f5166;border-radius:8px;padding:8px 10px;margin-top:6px;line-height:1.5">
                            ⚠️ Gambar harus portrait <strong>9:16</strong>.<br>Contoh ukuran: 1080×1920 px.
                        </div>
                    </div>
                </div>
                <input type="file" id="k-gambar" name="gambar" accept="image/*" style="display:none"
                       onchange="onKurikulumGambarChange(this)">
            </div>

            <hr class="form-divider">
            <div class="absensi-toggle-section">
                <div class="absensi-toggle-header" onclick="toggleAbsensiSection()">
                    <div class="absensi-toggle-header-left">
                        <span style="font-size:18px">✅</span>
                        <div>
                            <div style="font-size:13px;font-weight:700">Tombol Absensi Otomatis</div>
                            <div style="font-size:11px;font-weight:400;color:var(--text-muted);margin-top:2px">Atur jadwal buka & tutup absensi</div>
                        </div>
                    </div>
                    <div style="display:flex;align-items:center;gap:10px">
                        <label class="switch" onclick="event.stopPropagation()">
                            <input type="checkbox" id="k-absensi-aktif" name="absensi_aktif" value="1" onchange="toggleAbsensiSection(this.checked)">
                            <span class="switch-slider"></span>
                        </label>
                        <svg id="absensi-chevron" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" style="color:var(--text-muted);transition:transform .2s"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                </div>
                <div class="absensi-toggle-body" id="absensi-body">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px">
                        <div class="form-group" style="margin-bottom:0">
                            <label class="form-label">Waktu Mulai Absensi <span style="color:var(--accent2)">*</span></label>
                            <input class="form-input" type="datetime-local" name="absensi_mulai" id="k-absensi-mulai">
                            <div class="form-hint">Tombol absensi muncul mulai jam ini</div>
                        </div>
                        <div class="form-group" style="margin-bottom:0">
                            <label class="form-label">Waktu Selesai Absensi <span style="color:var(--accent2)">*</span></label>
                            <input class="form-input" type="datetime-local" name="absensi_selesai" id="k-absensi-selesai">
                            <div class="form-hint">Tombol absensi hilang otomatis jam ini</div>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top:14px;margin-bottom:0">
                        <label class="form-label">Link / URL Absensi</label>
                        <input class="form-input" type="url" name="absensi_url" id="k-absensi-url" placeholder="https://forms.gle/...">
                        <div class="form-hint">Kosongkan untuk menggunakan halaman absensi bawaan sistem.</div>
                    </div>
                    <div id="absensi-preview" style="display:none;margin-top:14px;background:#f0f9f4;border:1px solid #a7d7c566;border-radius:10px;padding:12px 16px">
                        <div style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:8px">Preview tombol absensi</div>
                        <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap">
                            <div style="display:flex;align-items:center;gap:6px;font-size:12px;font-weight:600;color:var(--accent)">
                                <span style="width:8px;height:8px;border-radius:50%;background:var(--accent);display:inline-block"></span>Absensi Berlangsung
                            </div>
                            <div style="background:var(--accent);color:#fff;padding:8px 16px;border-radius:8px;font-size:13px;font-weight:700">✅ Buka Link Absensi</div>
                            <div style="font-size:12px;color:var(--text-muted)">Berakhir dalam <strong id="absensi-preview-dur" style="color:var(--accent)">–</strong></div>
                        </div>
                        <div id="absensi-preview-schedule" style="font-size:11px;color:var(--text-muted);margin-top:8px"></div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" onclick="resetKurikulumModal(); closeModal('modal-kurikulum')">Batal</button>
                <button type="submit" class="btn btn-primary" id="kurikulum-submit-btn">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    <span id="kurikulum-submit-text">Kirim untuk Disetujui</span>
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ============ MODAL MODUL ============ --}}
<div class="modal-overlay" id="modal-modul">
    <div class="modal" style="width:520px">
        <div class="modal-header">
            <div class="modal-title">
                <span id="modal-modul-title-text">Tambah Modul Pembelajaran</span>
                <small id="modal-modul-subtitle">Modul akan tampil sebagai daftar bernomor di halaman kurikulum</small>
            </div>
            <button class="modal-close" onclick="resetModulModal(); closeModal('modal-modul')">×</button>
        </div>
        @php $adaKurikulum = isset($pelatihanList) && $pelatihanList->where('tipe','kurikulum')->count() > 0; @endphp
        @if(!$adaKurikulum)
        <div class="notice-box">
            <div style="font-size:22px;flex-shrink:0">⚠️</div>
            <div class="notice-text">
                <strong>Belum ada kurikulum.</strong> Buat kurikulum terlebih dahulu sebelum menambahkan modul.
                <br><a href="#" onclick="closeModal('modal-modul'); openModal('modal-kurikulum')" style="color:var(--accent);font-weight:700">Buat kurikulum sekarang →</a>
            </div>
        </div>
        @endif
        <form id="form-modul" method="POST" action="{{ route('trainer.modul.store') }}">
            @csrf
            <input type="hidden" name="_method" id="modul-method" value="POST">
            <input type="hidden" name="modul_edit_id" id="modul-edit-id">
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
            <div class="form-group">
                <label class="form-label">Nomor Urutan <span style="color:var(--accent2)">*</span></label>
                <input class="form-input" type="number" name="urutan" id="m-urutan" placeholder="1, 2, 3..." min="1" required {{ !$adaKurikulum ? 'disabled' : '' }}>
            </div>
            <div class="form-group">
                <label class="form-label">Judul Modul <span style="color:var(--accent2)">*</span></label>
                <input class="form-input" type="text" name="judul" id="m-judul" placeholder="Contoh: Pengenalan Dunia UMKM" required {{ !$adaKurikulum ? 'disabled' : '' }}>
            </div>
            <div class="form-group">
                <label class="form-label">Deskripsi Singkat</label>
                <textarea class="form-textarea" name="deskripsi" id="m-deskripsi" rows="3" placeholder="Deskripsi singkat isi modul..." maxlength="300" {{ !$adaKurikulum ? 'disabled' : '' }}></textarea>
            </div>
            @if($adaKurikulum)
            <div style="background:var(--surface2);border:1px solid var(--border);border-radius:12px;padding:14px 16px;margin-bottom:18px">
                <div style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:10px">Preview tampilan publik</div>
                <div style="display:flex;align-items:flex-start;gap:12px;padding:10px 14px;background:var(--surface);border:1px solid var(--border);border-radius:10px">
                    <div style="width:28px;height:28px;border-radius:50%;background:var(--accent);color:#fff;font-size:12px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px" id="preview-num">1</div>
                    <div>
                        <div style="font-size:13px;font-weight:700;color:var(--accent)" id="preview-judul">Judul modul...</div>
                        <div style="font-size:12px;color:var(--text-muted);margin-top:3px;line-height:1.5" id="preview-desc">Deskripsi modul...</div>
                    </div>
                </div>
            </div>
            @endif
            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" onclick="resetModulModal(); closeModal('modal-modul')">Batal</button>
                <button type="submit" class="btn btn-primary" id="modul-submit-btn" {{ !$adaKurikulum ? 'disabled' : '' }} style="{{ !$adaKurikulum ? 'opacity:.5;cursor:not-allowed' : '' }}">
                    <span id="modul-submit-text">Simpan Modul</span>
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ============ MODAL EVENT ============ --}}
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
                <input class="form-input" type="text" name="judul" id="event-judul" placeholder="Contoh: Festival Kuliner UMKM 2025" required>
            </div>
            <div class="form-group">
                <label class="form-label">Tanggal <span style="color:var(--accent2)">*</span></label>
                <input class="form-input" type="date" name="tanggal" id="event-tanggal" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Waktu Mulai</label>
                    <input class="form-input" type="time" name="waktu_mulai" id="event-waktu-mulai">
                    <div class="form-hint">Contoh: 08:00</div>
                </div>
                <div class="form-group">
                    <label class="form-label">Waktu Selesai</label>
                    <input class="form-input" type="time" name="waktu_selesai" id="event-waktu-selesai">
                    <div class="form-hint">Contoh: 15:00</div>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Lokasi</label>
                <input class="form-input" type="text" name="lokasi" id="event-lokasi" placeholder="Contoh: Gedung KAJI Indonesia, Surabaya">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Kapasitas Peserta</label>
                    <input class="form-input" type="number" name="kapasitas" id="event-kapasitas" min="1" placeholder="Contoh: 100">
                </div>
                <div class="form-group">
                    <label class="form-label">Biaya</label>
                    <input class="form-input" type="text" name="biaya" id="event-biaya" placeholder="Gratis / Rp 50.000">
                    <div class="form-hint">Kosongkan atau isi "Gratis" jika tidak berbayar</div>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">No. WhatsApp</label>
                <input class="form-input" type="text" name="phone" id="event-phone" value="{{ auth()->user()->phone ?? '' }}" placeholder="Contoh: 6281234567890">
                <div class="form-hint">Otomatis diisi dari profil. Ubah jika ingin nomor berbeda untuk event ini.</div>
            </div>
            <div class="form-group">
                <label class="form-label">Deskripsi Event <span style="color:var(--accent2)">*</span></label>
                <textarea class="form-textarea" name="deskripsi" id="event-deskripsi" rows="4" placeholder="Jelaskan detail event ini..." required></textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Gambar / Banner Event</label>
                <label class="upload-area" for="event-gambar" id="event-upload-area">
                    <img id="event-gambar-preview" src="" alt="preview" style="display:none;width:100%;height:100%;object-fit:cover;border-radius:12px;position:absolute;top:0;left:0;">
                    <div class="upload-icon" id="event-upload-icon">🖼️</div>
                    <div class="upload-text" id="event-upload-text">Klik untuk upload atau <span>drag & drop</span><br>PNG, JPG hingga 5MB</div>
                    <div class="upload-fname" id="event-gambar-name"></div>
                </label>
                <input type="file" id="event-gambar" name="gambar" accept="image/*" style="display:none" onchange="onEventGambarChange(this)">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" onclick="resetEventModal(); closeModal('modal-event')">Batal</button>
                <button type="submit" class="btn btn-primary">Kirim untuk Disetujui</button>
            </div>
        </form>
    </div>
</div>

{{-- ============ MODAL PROFIL ============ --}}
<div class="modal-overlay" id="modal-profil">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">Edit Profil</div>
            <button class="modal-close" onclick="closeModal('modal-profil')">×</button>
        </div>
        <form method="POST" action="{{ route('trainer.profil.update') }}" enctype="multipart/form-data" autocomplete="off">
            @csrf @method('PUT')
            <div class="form-row">
    <div class="form-group">
        <label class="form-label">Nama Lengkap *</label>
        <input class="form-input" type="text" name="name" value="{{ auth()->user()->name }}" required>
    </div>
    <div class="form-group">
        <label class="form-label">Nama Lengkap & Gelar Akademik</label>
        <input class="form-input" type="text" name="academic_degree"
               value="{{ $trainer->academic_degree ?? auth()->user()->name }}"
               placeholder="Contoh: {{ auth()->user()->name }}, S.E., M.M.">
        <div class="form-hint">Yang tampil di halaman publik trainer</div>
    </div>
    <div class="form-group">
        <label class="form-label">Email *</label>
        <input class="form-input" type="email" name="email" value="{{ auth()->user()->email }}" required>
    </div>
    <div class="form-group">
        <label class="form-label">No. Telepon</label>
        <input class="form-input" type="text" name="phone" value="{{ auth()->user()->phone ?? '' }}">
    </div>
</div>

{{-- Bidang Keahlian --}}
<div class="form-group">
    <label class="form-label">Bidang Keahlian</label>
    @php
        $presets = [
            'Leadership & Manajemen', 'Public Speaking', 'Digital Marketing',
            'Keuangan & Akuntansi', 'SDM & HRD', 'Kewirausahaan',
            'Penjualan & Negosiasi', 'Komunikasi Bisnis', 'Pengembangan Diri',
            'Produktivitas & Time Management', 'Teknologi Informasi', 'Hukum Bisnis',
            'K3 & Safety', 'Ekspor Impor', 'Pemasaran Konten',
        ];
        $savedKeahlian = $trainer->keahlian ?? '';
        $savedArr = $savedKeahlian ? array_map('trim', explode(',', $savedKeahlian)) : [];
    @endphp
    <div style="display:flex;flex-wrap:wrap;gap:7px;margin-bottom:10px" id="profil-chips">
        @foreach($presets as $preset)
            <button type="button"
                class="profil-chip"
                onclick="toggleProfilChip(this)"
                style="padding:5px 12px;border-radius:20px;font-size:12px;font-weight:500;border:1.5px solid {{ in_array($preset, $savedArr) ? 'var(--accent)' : '#d1d5db' }};background:{{ in_array($preset, $savedArr) ? 'var(--accent)' : '#f9fafb' }};color:{{ in_array($preset, $savedArr) ? '#fff' : '#4b5563' }};cursor:pointer;font-family:inherit;transition:all .15s">
                {{ $preset }}
            </button>
        @endforeach
    </div>
    {{-- Custom tag yang sudah tersimpan --}}
    <div style="display:flex;flex-wrap:wrap;gap:6px;margin-bottom:8px" id="profil-custom-tags">
        @foreach($savedArr as $item)
            @if(!in_array($item, $presets) && $item !== '')
                <span style="display:inline-flex;align-items:center;gap:5px;padding:4px 10px;border-radius:20px;font-size:12px;font-weight:500;background:#ede9fe;color:#5b21b6;border:1.5px solid #c4b5fd">
                    {{ $item }}
                    <button type="button" onclick="removeProfilTag(this, '{{ $item }}')"
                        style="background:none;border:none;cursor:pointer;font-size:15px;line-height:1;color:inherit;padding:0;opacity:.7">×</button>
                </span>
            @endif
        @endforeach
    </div>
    <div style="display:flex;gap:8px;margin-bottom:6px">
        <input type="text" id="profil-custom-input" placeholder="Tambah keahlian lain..."
               class="form-input" style="flex:1"
               onkeydown="if(event.key==='Enter'){event.preventDefault();addProfilCustom();}">
        <button type="button" onclick="addProfilCustom()"
                style="padding:9px 14px;font-size:12px;font-weight:600;color:#fff;background:var(--accent);border:none;border-radius:8px;cursor:pointer;font-family:inherit;white-space:nowrap">
            + Tambah
        </button>
    </div>
    <input type="hidden" name="bidang_keahlian" id="profil-keahlian-value" value="{{ $savedKeahlian }}">
<div style="font-size:11px;color:var(--text-muted)" id="profil-keahlian-counter">
    <span id="profil-keahlian-count">{{ count($savedArr) }}</span> bidang dipilih
</div>

{{-- Dropdown bidang yang ditampilkan --}}
{{-- DENGAN ini: --}}
<div class="form-group" style="margin-top:14px;margin-bottom:0">
    <label class="form-label">Bidang yang Ditampilkan di Publik</label>
    <select name="displayed_bidang" id="profil-displayed-bidang" class="form-select">
        @foreach($savedArr as $item)
            <option value="{{ $item }}"
                {{ ($trainer->displayed_bidang === $item) ? 'selected' : '' }}>
                {{ $item }}
            </option>
        @endforeach
    </select>
    <div class="form-hint">Bidang ini yang muncul di kartu trainer halaman publik.</div>
</div>
</div>

<div class="form-group">
    <label class="form-label">Bio</label>
    <textarea class="form-textarea" name="bio">{{ $trainer->bio ?? '' }}</textarea>
</div>
<div class="form-group">
    <label class="form-label">Foto Profil</label>
    <label class="upload-area" for="profil-foto" id="profil-foto-area"
           style="position:relative;overflow:hidden;min-height:110px">

        {{-- Preview foto existing --}}
        @php $fotoAktif = $trainer?->foto ?? null; @endphp
        @if($fotoAktif)
            <img id="profil-foto-preview"
                 src="{{ asset('storage/' . $fotoAktif) }}"
                 alt="Foto Profil"
                 style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;border-radius:12px;z-index:1">
            <div id="profil-foto-overlay"
                 style="position:absolute;inset:0;background:rgba(0,0,0,.45);border-radius:12px;z-index:2;
                        display:flex;flex-direction:column;align-items:center;justify-content:center;gap:6px">
                <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#fff" stroke-width="2">
                    <path d="M23 19a2 2 0 01-2 2H3a2 2 0 01-2-2V8a2 2 0 012-2h4l2-3h6l2 3h4a2 2 0 012 2z"/>
                    <circle cx="12" cy="13" r="4"/>
                </svg>
                <span style="font-size:12px;font-weight:600;color:#fff">Ganti Foto</span>
                <div class="upload-fname" id="profil-foto-name" style="color:#fff;z-index:3"></div>
            </div>
        @else
            <div id="profil-foto-preview" style="display:none;position:absolute;inset:0;width:100%;height:100%;object-fit:cover;border-radius:12px;z-index:1"></div>
            <div id="profil-foto-overlay" style="display:none"></div>
            <div id="profil-foto-placeholder" style="display:flex;flex-direction:column;align-items:center;gap:8px">
                <div class="upload-icon">📷</div>
                <div class="upload-text">Klik untuk upload foto atau <span>drag & drop</span></div>
            </div>
            <div class="upload-fname" id="profil-foto-name"></div>
        @endif

    </label>
    <input type="file" id="profil-foto" name="foto" accept="image/*"
           style="display:none" onchange="onProfilFotoChange(this)">
    <div style="font-size:11px;color:var(--text-muted);margin-top:5px">JPG, PNG · Maks 2 MB</div>
</div>
            <hr class="form-divider">
            <div class="form-group">
    <label class="form-label">Password Baru <span style="color:var(--text-muted);font-weight:400;text-transform:none;letter-spacing:0">(kosongkan jika tidak diubah)</span></label>
    <div style="position:relative">
    <input class="form-input" type="password" name="password" id="input-password-baru"
           placeholder="Min. 8 karakter" style="padding-right:44px"
           autocomplete="new-password">
        <button type="button" onclick="togglePassword('input-password-baru', 'eye-baru')"
                style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text-muted);padding:0;display:flex;align-items:center">
            <svg id="eye-baru" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                <circle cx="12" cy="12" r="3"/>
            </svg>
        </button>
    </div>
    <div style="font-size:11px;color:var(--text-muted);margin-top:5px">Min. 8 karakter, kombinasi huruf dan angka disarankan</div>
</div>

<div class="form-group">
    <label class="form-label">Konfirmasi Password Baru</label>
    <div style="position:relative">
    <input class="form-input" type="password" name="password_confirmation" id="input-password-confirm"
               placeholder="Ulangi password baru" style="padding-right:44px"
               autocomplete="new-password">
        <button type="button" onclick="togglePassword('input-password-confirm', 'eye-confirm')"
                style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text-muted);padding:0;display:flex;align-items:center">
            <svg id="eye-confirm" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                <circle cx="12" cy="12" r="3"/>
            </svg>
        </button>
    </div>
    <div id="password-match-hint" style="font-size:11px;margin-top:5px;display:none"></div>
</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" onclick="closeModal('modal-profil')">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

{{-- ============ MODAL DAFTAR ABSENSI ============ --}}
<div class="modal-overlay" id="modal-absensi-daftar">
    <div class="modal" style="width:700px;max-width:95vw">
        <div class="modal-header">
            <div class="modal-title">
                👥 Daftar Absensi
                <small id="modal-abs-subtitle" style="display:block;margin-top:3px">–</small>
            </div>
            <button class="modal-close" onclick="closeModal('modal-absensi-daftar')">×</button>
        </div>
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;flex-wrap:wrap;gap:10px">
            <div style="display:flex;align-items:center;gap:8px">
                <span style="font-size:13px;color:var(--text-muted)">Total hadir:</span>
                <span id="abs-total-badge" style="background:var(--accent);color:#fff;font-size:12px;font-weight:700;padding:3px 12px;border-radius:20px">–</span>
            </div>
            <div style="display:flex;gap:8px">
                <button class="btn btn-sm btn-ghost" onclick="exportAbsensiCsv()" style="gap:6px">
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    Export CSV
                </button>
                <button class="btn btn-sm btn-ghost" onclick="refreshAbsensi()" style="gap:6px">
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 11-2.12-9.36L23 10"/></svg>
                    Refresh
                </button>
            </div>
        </div>
        <div id="abs-loading" style="text-align:center;padding:44px;color:var(--text-muted);font-size:13px">⏳ Memuat data...</div>
        <div id="abs-table-wrap" style="display:none">
            <div class="table-wrap" style="margin-bottom:0;max-height:400px;overflow-y:auto">
                <table>
                    <thead><tr><th style="width:48px">#</th><th>Nama</th><th>Email</th><th>Waktu Absen</th></tr></thead>
                    <tbody id="abs-tbody"></tbody>
                </table>
            </div>
        </div>
        <div id="abs-empty" style="display:none;text-align:center;padding:50px 20px;color:var(--text-muted)">
            <div style="font-size:42px;margin-bottom:12px">📭</div>
            <div style="font-size:14px;font-weight:600;color:var(--text);margin-bottom:6px">Belum ada yang absen</div>
            <div style="font-size:13px">Peserta akan muncul di sini saat absensi aktif</div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-ghost" onclick="closeModal('modal-absensi-daftar')">Tutup</button>
        </div>
    </div>
</div>

<form id="form-hapus" method="POST" style="display:none">@csrf @method('DELETE')</form>
<form id="form-hapus-event" method="POST" style="display:none">@csrf @method('DELETE')</form>

<script>

/* ================================================================
   KURIKULUM GAMBAR — VALIDASI PORTRAIT 9:16
================================================================ */
function onKurikulumGambarChange(input) {
    const errorEl  = document.getElementById('k-gambar-error');
    const nameEl   = document.getElementById('k-gambar-name');
    const preview  = document.getElementById('k-gambar-preview');
    const overlay  = document.getElementById('k-gambar-overlay');
    const pholder  = document.getElementById('k-gambar-placeholder');
    if (!input.files || !input.files[0]) return;
    const file = input.files[0];

    // Validasi ukuran maks 5MB
    if (file.size > 5 * 1024 * 1024) {
        errorEl.innerHTML  = '⚠️ Ukuran file terlalu besar. Maks <strong>5 MB</strong>.';
        errorEl.style.display = 'block';
        nameEl.textContent = '';
        preview.style.display = 'none';
        overlay.style.display = 'none';
        pholder.style.display = 'flex';
        input.value = '';
        return;
    }

    const imgCheck = new Image();
    const url = URL.createObjectURL(file);
    imgCheck.onload = function () {
        URL.revokeObjectURL(url);
        const w = imgCheck.naturalWidth, h = imgCheck.naturalHeight;
        const ratio       = w / h;
        const targetRatio = 9 / 16;   // 0.5625
        const tolerance   = 0.06;     // toleransi ±6%
        const valid       = (h > w) && (Math.abs(ratio - targetRatio) / targetRatio <= tolerance);

        if (!valid) {
            errorEl.innerHTML  = '⚠️ Gambar harus <strong>portrait 9:16</strong>.<br>'
                + 'Ukuran Anda: ' + w + '×' + h + ' px. '
                + 'Contoh yang benar: 1080×1920 px.';
            errorEl.style.display = 'block';
            nameEl.textContent    = '';
            preview.style.display = 'none';
            overlay.style.display = 'none';
            pholder.style.display = 'flex';
            input.value = '';
            return;
        }

        // Gambar valid — tampilkan preview
        errorEl.style.display = 'none';
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src           = e.target.result;
            preview.style.display = 'block';
            overlay.style.display = 'flex';
            pholder.style.display = 'none';
            nameEl.innerHTML = '✅ <strong>' + file.name + '</strong><br>'
                + '<span style="color:var(--text-muted)">' + w + '×' + h + ' px · '
                + (file.size / 1024).toFixed(0) + ' KB</span>';
        };
        reader.readAsDataURL(file);
    };
    imgCheck.src = url;
}

function resetKurikulumGambarPreview() {
    const preview = document.getElementById('k-gambar-preview');
    const overlay = document.getElementById('k-gambar-overlay');
    const pholder = document.getElementById('k-gambar-placeholder');
    const nameEl  = document.getElementById('k-gambar-name');
    const errorEl = document.getElementById('k-gambar-error');
    if (preview) { preview.src = ''; preview.style.display = 'none'; }
    if (overlay) overlay.style.display = 'none';
    if (pholder) pholder.style.display = 'flex';
    if (nameEl)  nameEl.textContent = '';
    if (errorEl) errorEl.style.display = 'none';
}
/* ================================================================
   toggleAlamat — pisah antara "show/hide saja" vs "reset nilai"
================================================================ */
function _setVisibilityAlamat(tampil) {
    var grup = document.getElementById('k-alamat-group');
    if (tampil) {
        grup.style.maxHeight    = '200px';
        grup.style.overflow     = 'visible';
        grup.style.opacity      = '1';
        grup.style.marginBottom = '18px';
    } else {
        grup.style.maxHeight    = '0';
        grup.style.overflow     = 'hidden';
        grup.style.opacity      = '0';
        grup.style.marginBottom = '0';
    }
}

// Dipanggil saat USER memilih metode dari dropdown — boleh kosongkan alamat
function toggleAlamat(val) {
    var isOfflineOrHybrid = (val === 'offline' || val === 'hybrid');
    _setVisibilityAlamat(isOfflineOrHybrid);
    // Kosongkan alamat hanya jika user memilih online (bukan saat load data edit)
    if (!isOfflineOrHybrid) {
        document.getElementById('k-alamat').value = '';
    }
}

// Dipanggil saat LOAD DATA EDIT — tidak boleh mengosongkan nilai
function _tampilkanAlamatTanpaReset(val) {
    var isOfflineOrHybrid = (val === 'offline' || val === 'hybrid');
    _setVisibilityAlamat(isOfflineOrHybrid);
    // TIDAK mengosongkan nilai
}

document.addEventListener('DOMContentLoaded', function() {
    var grup = document.getElementById('k-alamat-group');
    if (grup) {
        grup.style.transition = 'max-height .3s ease, opacity .3s ease, margin-bottom .3s ease';
        grup.style.maxHeight    = '0';
        grup.style.overflow     = 'hidden';
        grup.style.opacity      = '0';
        grup.style.marginBottom = '0';
    }
});

/* ================================================================
   SIDEBAR TOGGLE (MOBILE)
================================================================ */
function toggleSidebar() {
    const sidebar  = document.querySelector('.sidebar');
    const overlay  = document.getElementById('sidebar-overlay');
    sidebar.classList.toggle('open');
    overlay.classList.toggle('open');
    document.body.style.overflow = sidebar.classList.contains('open') ? 'hidden' : '';
}
function closeSidebar() {
    document.querySelector('.sidebar').classList.remove('open');
    document.getElementById('sidebar-overlay').classList.remove('open');
    document.body.style.overflow = '';
}

/* ================================================================
   NAVIGASI
================================================================ */
function showPage(id) {
    if (window.innerWidth <= 768) closeSidebar();
    document.querySelectorAll('.page-section').forEach(el => el.classList.remove('active'));
    document.querySelectorAll('.nav-item').forEach(el => el.classList.remove('active'));
    document.getElementById('page-' + id).classList.add('active');
    const titles = { beranda:'Dashboard Trainer', program:'Program / Pelatihan', event:'Event', profil:'Profil Saya' };
    document.getElementById('page-title').textContent = titles[id] || 'Dashboard';
    document.querySelectorAll('.nav-item').forEach(item => {
        if ((item.getAttribute('onclick') || '').includes("'" + id + "'")) item.classList.add('active');
    });
}

/* ================================================================
   MODAL HELPERS
================================================================ */
function openModal(id)  { document.getElementById(id).classList.add('open'); }
function closeModal(id) { document.getElementById(id).classList.remove('open'); }
document.querySelectorAll('.modal-overlay').forEach(m => {
    m.addEventListener('click', e => { if (e.target === m) m.classList.remove('open'); });
});
function showFileName(input, labelId) {
    const label = document.getElementById(labelId);
    if (input.files && input.files[0]) label.textContent = '✓ ' + input.files[0].name;
}

/* ================================================================
   ABSENSI TOGGLE
================================================================ */
function toggleAbsensiSection(forceState) {
    const checkbox = document.getElementById('k-absensi-aktif');
    const body     = document.getElementById('absensi-body');
    const chevron  = document.getElementById('absensi-chevron');
    if (typeof forceState === 'boolean') {
        checkbox.checked = forceState;
    } else {
        checkbox.checked = !checkbox.checked;
    }
    const isOpen = checkbox.checked;
    body.classList.toggle('open', isOpen);
    chevron.style.transform = isOpen ? 'rotate(180deg)' : '';
    if (!isOpen) {
        document.getElementById('k-absensi-mulai').value   = '';
        document.getElementById('k-absensi-selesai').value = '';
        document.getElementById('k-absensi-url').value     = '';
        document.getElementById('absensi-preview').style.display = 'none';
    }
}

/* ================================================================
   ABSENSI PREVIEW
================================================================ */
function updateAbsensiPreview() {
    const mulai   = document.getElementById('k-absensi-mulai').value;
    const selesai = document.getElementById('k-absensi-selesai').value;
    const preview = document.getElementById('absensi-preview');
    const durEl   = document.getElementById('absensi-preview-dur');
    const schEl   = document.getElementById('absensi-preview-schedule');
    if (!mulai || !selesai) { preview.style.display = 'none'; return; }
    const mDate = new Date(mulai);
    const sDate = new Date(selesai);
    if (sDate <= mDate) { preview.style.display = 'none'; return; }
    preview.style.display = 'block';
    const diffMin = Math.round((sDate - mDate) / 60000);
    if (diffMin < 60) { durEl.textContent = diffMin + ' menit'; }
    else {
        const h = Math.floor(diffMin / 60), m = diffMin % 60;
        durEl.textContent = h + ' jam' + (m ? ' ' + m + ' menit' : '');
    }
    const fmt = d => d.toLocaleDateString('id-ID', {day:'numeric',month:'short',year:'numeric'}) + ', ' + d.toLocaleTimeString('id-ID', {hour:'2-digit',minute:'2-digit'});
    schEl.textContent = 'Jadwal: ' + fmt(mDate) + ' – ' + fmt(sDate) + ' WIB';
}

/* ================================================================
   ABSENSI COUNTDOWN
================================================================ */
function pad(n) { return String(n).padStart(2, '0'); }
function formatCountdown(ms) {
    if (ms <= 0) return '00:00:00';
    const s = Math.floor(ms / 1000);
    const h = Math.floor(s / 3600), m = Math.floor((s % 3600) / 60), ss = s % 60;
    return h > 0 ? pad(h)+':'+pad(m)+':'+pad(ss) : pad(m)+':'+pad(ss);
}
function initAbsensiTimers() {
    document.querySelectorAll('[id^="absensi-bar-"]').forEach(function(bar) {
        const tsMulai   = parseInt(bar.dataset.mulai, 10) * 1000;
        const tsSelesai = parseInt(bar.dataset.selesai, 10) * 1000;
        const timerId   = bar.id.replace('absensi-bar-', '');
        const timerEl   = document.getElementById('timer-' + timerId);
        if (!timerEl || isNaN(tsMulai) || isNaN(tsSelesai) || tsMulai === 0) return;
        var intervalId;
        function tick() {
            var now = Date.now();
            var msToMulai = tsMulai - now, msToSelesai = tsSelesai - now;
            if (msToMulai > 0) {
                timerEl.textContent = formatCountdown(msToMulai);
                timerEl.className   = 'countdown-timer upcoming';
            } else if (msToSelesai > 0) {
                timerEl.textContent = formatCountdown(msToSelesai);
                timerEl.className   = msToSelesai < 600000 ? 'countdown-timer warning' : 'countdown-timer';
                if (bar.classList.contains('absensi-upcoming')) location.reload();
            } else {
                clearInterval(intervalId);
                if (!bar.classList.contains('absensi-ended')) location.reload();
            }
        }
        tick();
        intervalId = setInterval(tick, 1000);
    });
}

/* ================================================================
   EDIT KURIKULUM
================================================================ */
document.addEventListener('click', function(e) {
    const btn = e.target.closest('.btn-edit-kurikulum');
    if (!btn) return;
    const d = btn.dataset;

    document.getElementById('modal-kurikulum-title-text').textContent = 'Edit Kurikulum';
    document.getElementById('modal-kurikulum-subtitle').textContent   = 'Perubahan langsung tersimpan tanpa perlu persetujuan ulang';
    document.getElementById('kurikulum-submit-text').textContent      = 'Simpan Perubahan';
    document.getElementById('kurikulum-edit-id').value = d.id;
    document.getElementById('k-judul').value           = d.judul;
    document.getElementById('k-deskripsi').value       = d.deskripsi || '';
    document.getElementById('k-tingkat').value         = d.tingkat  || '';
    document.getElementById('k-bahasa').value          = d.bahasa   || '';
    document.getElementById('k-total-jam').value       = d.totalJam || '';
    document.getElementById('k-jumlah-sesi').value     = d.jumlahSesi || '';
    document.getElementById('k-phone').value           = d.phone    || '';
    document.getElementById('k-biaya').value = d.biaya || '';
    document.getElementById('kurikulum-method').value  = 'PUT';
    document.getElementById('form-kurikulum').action   = '/kurikulum/' + d.id;

    // ① ISI ALAMAT DULU — sebelum apapun
    try {
    document.getElementById('k-alamat').value = JSON.parse(d.alamat) || '';
} catch(e) {
    document.getElementById('k-alamat').value = d.alamat || '';
}

    // ② Set metode dropdown
    document.getElementById('k-metode').value = d.metode || '';

    // ③ Tampilkan/sembunyikan field alamat TANPA mengosongkan nilainya
    _tampilkanAlamatTanpaReset(d.metode || '');

    // Sertifikat
    if (d.sertifikat == '1') {
        document.getElementById('sertifikat-ya').checked = true;
    } else {
        document.getElementById('sertifikat-tidak').checked = true;
    }

    // Absensi
    const absensiAktif = d.absensiAktif === '1';
    document.getElementById('k-absensi-aktif').checked = absensiAktif;
    toggleAbsensiSection(absensiAktif);
    if (absensiAktif) {
        if (d.absensiMulai)   document.getElementById('k-absensi-mulai').value   = d.absensiMulai.substring(0, 16);
        if (d.absensiSelesai) document.getElementById('k-absensi-selesai').value = d.absensiSelesai.substring(0, 16);
        document.getElementById('k-absensi-url').value = d.absensiUrl || '';
        updateAbsensiPreview();
    }

      document.querySelectorAll('input[name="_token"]').forEach(el => {
        el.value = document.querySelector('meta[name="csrf-token"]').content;
    });

    // Preview gambar existing saat edit
    const gambarUrl = d.gambarUrl || '';
    if (gambarUrl) {
        const preview = document.getElementById('k-gambar-preview');
        const overlay = document.getElementById('k-gambar-overlay');
        const pholder = document.getElementById('k-gambar-placeholder');
        const nameEl  = document.getElementById('k-gambar-name');
        preview.src           = gambarUrl;
        preview.style.display = 'block';
        overlay.style.display = 'flex';
        pholder.style.display = 'none';
        nameEl.innerHTML      = '✅ <strong>Gambar tersimpan</strong> — klik area poster untuk mengganti';
    } else {
        resetKurikulumGambarPreview();
    }

    openModal('modal-kurikulum');
});

/* ================================================================
   EDIT MODUL
================================================================ */
function editModul(id, kurikulumId, judul, deskripsi, urutan) {
    document.getElementById('modal-modul-title-text').textContent = 'Edit Modul';
    document.getElementById('modal-modul-subtitle').textContent   = 'Perubahan langsung tersimpan tanpa perlu persetujuan ulang';
    document.getElementById('modul-submit-text').textContent      = 'Simpan Perubahan';
    document.getElementById('modul-edit-id').value  = id;
    document.getElementById('m-kurikulum-id').value = kurikulumId;
    document.getElementById('m-judul').value        = judul;
    document.getElementById('m-deskripsi').value    = deskripsi;
    document.getElementById('m-urutan').value       = urutan;
    document.getElementById('modul-method').value   = 'PUT';
    document.getElementById('form-modul').action    = '/modul/' + id;
    updatePreview();
    openModal('modal-modul');
}

/* ================================================================
   EDIT EVENT
================================================================ */
function editEvent(id, judul, tanggal, waktuMulai, waktuSelesai, lokasi, kapasitas, biaya, deskripsi, gambar, phone) {
    document.getElementById('modal-event-title').textContent    = 'Edit Event';
    document.getElementById('event-id').value                   = id;
    document.getElementById('event-judul').value                = judul;
    document.getElementById('event-tanggal').value              = tanggal;
    document.getElementById('event-waktu-mulai').value          = waktuMulai   || '';
    document.getElementById('event-waktu-selesai').value        = waktuSelesai || '';
    document.getElementById('event-lokasi').value               = lokasi       || '';
    document.getElementById('event-kapasitas').value            = kapasitas    || '';
    document.getElementById('event-biaya').value                = biaya        || '';
    document.getElementById('event-deskripsi').value            = deskripsi    || '';
    document.getElementById('event-method').value               = 'PUT';
    document.getElementById('form-event').action                = '/trainer/event/' + id;
    document.getElementById('event-phone').value                = phone        || '';
    if (gambar) {
        tampilkanPreviewEvent(gambar);
        document.getElementById('event-gambar-name').textContent = '✓ Gambar tersimpan — klik untuk mengganti';
    } else {
        resetPreviewEvent();
    }
    openModal('modal-event');
}

function resetEventModal() {
    document.getElementById('modal-event-title').textContent = 'Tambah Event';
    document.getElementById('event-method').value = 'POST';
    document.getElementById('form-event').action  = '{{ route("trainer.event.store") }}';
    document.getElementById('form-event').reset();
    resetPreviewEvent();
}

function onEventGambarChange(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) { tampilkanPreviewEvent(e.target.result); };
        reader.readAsDataURL(input.files[0]);
        document.getElementById('event-gambar-name').textContent = '✓ ' + input.files[0].name;
    }
}
function tampilkanPreviewEvent(src) {
    var p = document.getElementById('event-gambar-preview');
    p.src = src; p.style.display = 'block';
    document.getElementById('event-upload-icon').style.display = 'none';
    document.getElementById('event-upload-text').style.display = 'none';
}
function resetPreviewEvent() {
    var p = document.getElementById('event-gambar-preview');
    p.src = ''; p.style.display = 'none';
    document.getElementById('event-upload-icon').style.display = '';
    document.getElementById('event-upload-text').style.display = '';
    document.getElementById('event-gambar-name').textContent   = '';
}

/* ================================================================
   RESET MODAL KURIKULUM
================================================================ */
function resetKurikulumModal() {
    document.getElementById('modal-kurikulum-title-text').textContent = 'Tambah Kurikulum';
    document.getElementById('modal-kurikulum-subtitle').textContent   = 'Isi detail kurikulum, modul dapat ditambah setelah kurikulum tersimpan';
    document.getElementById('kurikulum-submit-text').textContent      = 'Kirim untuk Disetujui';
    document.getElementById('kurikulum-method').value = 'POST';
    document.getElementById('form-kurikulum').action  = '{{ route("trainer.kurikulum.store") }}';
    document.getElementById('form-kurikulum').reset();
    resetKurikulumGambarPreview();
    document.getElementById('sertifikat-tidak').checked  = true;
    document.getElementById('k-phone').value = '{{ auth()->user()->phone ?? "" }}';
    document.getElementById('k-absensi-aktif').checked = false;
    document.getElementById('k-alamat').value = '';
    document.getElementById('k-biaya').value = '';  
    toggleAlamat('');
    toggleAbsensiSection(false);
}

function resetModulModal() {
    document.getElementById('modal-modul-title-text').textContent = 'Tambah Modul Pembelajaran';
    document.getElementById('modal-modul-subtitle').textContent   = 'Modul akan tampil sebagai daftar bernomor di halaman kurikulum';
    document.getElementById('modul-submit-text').textContent      = 'Simpan Modul';
    document.getElementById('modul-method').value = 'POST';
    document.getElementById('form-modul').action  = '{{ route("trainer.modul.store") }}';
    document.getElementById('form-modul').reset();
    const pNum   = document.getElementById('preview-num');
    const pJudul = document.getElementById('preview-judul');
    const pDesc  = document.getElementById('preview-desc');
    if (pNum)   pNum.textContent   = '1';
    if (pJudul) pJudul.textContent = 'Judul modul...';
    if (pDesc)  pDesc.textContent  = 'Deskripsi modul...';
}

/* ================================================================
   HAPUS
================================================================ */
function hapusItem(id, tipe) {
    if (!confirm('Yakin ingin menghapus ' + tipe + ' ini?')) return;
    const form = document.getElementById('form-hapus');
    form.action = '/' + tipe + '/' + id;
    form.submit();
}
function hapusEvent(id) {
    if (!confirm('Yakin ingin menghapus event ini?')) return;
    const form = document.getElementById('form-hapus-event');
    form.action = '/trainer/event/' + id;
    form.submit();
}

/* ================================================================
   PREVIEW MODUL
================================================================ */
function updatePreview() {
    const judul  = document.getElementById('m-judul');
    const desc   = document.getElementById('m-deskripsi');
    const urutan = document.getElementById('m-urutan');
    const pJudul = document.getElementById('preview-judul');
    const pDesc  = document.getElementById('preview-desc');
    const pNum   = document.getElementById('preview-num');
    if (pJudul) pJudul.textContent = judul?.value  || 'Judul modul...';
    if (pDesc)  pDesc.textContent  = desc?.value   || 'Deskripsi modul...';
    if (pNum)   pNum.textContent   = urutan?.value || '1';
}

function openModalModul() {
    @if(!$adaKurikulum)
        if (!confirm('Kamu belum punya kurikulum. Buat kurikulum terlebih dahulu?')) return;
        openModal('modal-kurikulum'); return;
    @endif
    resetModulModal();
    openModal('modal-modul');
}
function openModalModulDenganKurikulum(kurikulumId, kurikulumJudul) {
    resetModulModal();
    document.getElementById('m-kurikulum-id').value = kurikulumId;
    document.getElementById('modal-modul-subtitle').textContent = 'Menambah modul ke: ' + kurikulumJudul;
    openModal('modal-modul');
}

/* ================================================================
   ABSENSI DAFTAR & EXPORT
================================================================ */
var _absPelId = null;
function bukaDaftarAbsensi(pelId, judul) {
    _absPelId = pelId;
    document.getElementById('modal-abs-subtitle').textContent = judul;
    document.getElementById('abs-total-badge').textContent    = '–';
    document.getElementById('abs-loading').style.display      = 'block';
    document.getElementById('abs-table-wrap').style.display   = 'none';
    document.getElementById('abs-empty').style.display        = 'none';
    openModal('modal-absensi-daftar');
    _muatAbsensi(pelId);
}
function refreshAbsensi() { if (_absPelId) _muatAbsensi(_absPelId); }
function _muatAbsensi(pelId) {
    document.getElementById('abs-loading').style.display    = 'block';
    document.getElementById('abs-table-wrap').style.display = 'none';
    document.getElementById('abs-empty').style.display      = 'none';
    fetch('/trainer/kurikulum/' + pelId + '/absensi', {
        headers: { 'Accept':'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
    })
    .then(r => r.json())
    .then(res => {
        document.getElementById('abs-loading').style.display = 'none';
        if (!res.success) { alert('Gagal: ' + res.message); return; }
        document.getElementById('abs-total-badge').textContent = res.total;
        if (res.total === 0) { document.getElementById('abs-empty').style.display = 'block'; return; }
        var tbody = document.getElementById('abs-tbody');
        tbody.innerHTML = '';
        res.peserta.forEach(p => {
            var tr = document.createElement('tr');
            tr.innerHTML = '<td style="font-weight:600;color:var(--text-muted)">' + p.no + '</td>'
                + '<td style="font-weight:500">' + _esc(p.nama) + '</td>'
                + '<td style="font-size:12px;color:var(--text-muted)">' + _esc(p.email) + '</td>'
                + '<td style="font-size:12px;color:var(--text-muted)">' + _esc(p.waktu) + '</td>';
            tbody.appendChild(tr);
        });
        document.getElementById('abs-table-wrap').style.display = 'block';
    })
    .catch(() => { document.getElementById('abs-loading').style.display = 'none'; alert('Gagal terhubung ke server.'); });
}
function exportAbsensiCsv() { if (_absPelId) window.location.href = '/trainer/kurikulum/' + _absPelId + '/absensi/export'; }
function _esc(s) {
    if (s == null) return '–';
    return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}

/* ================================================================
   INIT
================================================================ */
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('k-absensi-mulai').addEventListener('change', updateAbsensiPreview);
    document.getElementById('k-absensi-selesai').addEventListener('change', updateAbsensiPreview);
    ['m-judul', 'm-deskripsi', 'm-urutan'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.addEventListener('input', updatePreview);
    });
    initAbsensiTimers();
    const hash = window.location.hash.replace('#', '');
    if (['beranda', 'program', 'event', 'profil'].includes(hash)) {
        showPage(hash);
    } else {
        @if(session('active_page'))
            showPage('{{ session("active_page") }}');
        @endif
    }
});

/* ================================================================
   PROFIL CHIPS — BIDANG KEAHLIAN
================================================================ */
function getProfilKeahlianArray() {
    const val = document.getElementById('profil-keahlian-value').value;
    return val ? val.split(',').map(s => s.trim()).filter(Boolean) : [];
}
function toggleProfilChip(btn) {
    const label = btn.textContent.trim();
    let arr = getProfilKeahlianArray();
    if (btn.style.background.includes('var(--accent)') || btn.style.background === 'var(--accent)') {
        btn.style.background = '#f9fafb';
        btn.style.borderColor = '#d1d5db';
        btn.style.color = '#4b5563';
        arr = arr.filter(v => v !== label);
    } else {
        btn.style.background = 'var(--accent)';
        btn.style.borderColor = 'var(--accent)';
        btn.style.color = '#fff';
        if (!arr.includes(label)) arr.push(label);
    }
    setProfilKeahlianValue(arr);
}
function addProfilCustom() {
    const input = document.getElementById('profil-custom-input');
    const label = input.value.trim();
    if (!label) return;
    let arr = getProfilKeahlianArray();
    if (arr.includes(label)) { input.value = ''; return; }
    arr.push(label);
    setProfilKeahlianValue(arr); // ← ini sudah update dropdown

    const container = document.getElementById('profil-custom-tags');
    const tag       = document.createElement('span');
    tag.style.cssText = 'display:inline-flex;align-items:center;gap:5px;padding:4px 10px;border-radius:20px;font-size:12px;font-weight:500;background:#ede9fe;color:#5b21b6;border:1.5px solid #c4b5fd';
    tag.dataset.value = label;
    tag.innerHTML = label + ` <button type="button" onclick="removeProfilTag(this,'${label.replace(/'/g,"\\'")}') " style="background:none;border:none;cursor:pointer;font-size:15px;line-height:1;color:inherit;padding:0;opacity:.7">×</button>`;
    container.appendChild(tag);

    // ← Auto-pilih keahlian baru di dropdown displayed_bidang
    const select = document.getElementById('profil-displayed-bidang');
    if (select) select.value = label;

    input.value = '';
    input.focus();
}
function removeProfilTag(btn, label) {
    btn.closest('span').remove();
    let arr = getProfilKeahlianArray();
    arr = arr.filter(v => v !== label);
    setProfilKeahlianValue(arr);
}

function setProfilKeahlianValue(arr) {
    document.getElementById('profil-keahlian-value').value = arr.join(',');
    const counter = document.getElementById('profil-keahlian-count');
    if (counter) counter.textContent = arr.length;

    const select   = document.getElementById('profil-displayed-bidang');
    if (!select) return;
    const currentVal = select.value; // simpan pilihan sebelumnya
    select.innerHTML = '';
    arr.forEach(item => {
        const opt      = document.createElement('option');
        opt.value      = item;
        opt.textContent = item;
        // ← pertahankan pilihan sebelumnya, atau otomatis pilih item terakhir ditambah
        if (item === currentVal) opt.selected = true;
        select.appendChild(opt);
    });

    // Kalau pilihan sebelumnya sudah tidak ada di arr, pilih item pertama
    if (arr.length > 0 && !arr.includes(currentVal)) {
        select.value = arr[0];
    }
}

/* ================================================================
   TOGGLE PASSWORD VISIBILITY
================================================================ */
function togglePassword(inputId, eyeId) {
    const input = document.getElementById(inputId);
    const eye   = document.getElementById(eyeId);
    const isHidden = input.type === 'password';
    input.type = isHidden ? 'text' : 'password';
    eye.innerHTML = isHidden
        ? `<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94"/>
           <path d="M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19"/>
           <line x1="1" y1="1" x2="23" y2="23"/>`
        : `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
           <circle cx="12" cy="12" r="3"/>`;
}

/* ================================================================
   PASSWORD MATCH CHECKER
================================================================ */
document.addEventListener('DOMContentLoaded', function () {
    const pw1  = document.getElementById('input-password-baru');
    const pw2  = document.getElementById('input-password-confirm');
    const hint = document.getElementById('password-match-hint');
    if (!pw1 || !pw2 || !hint) return;

    function checkMatch() {
        if (!pw2.value) { hint.style.display = 'none'; return; }
        hint.style.display = 'block';
        if (pw1.value === pw2.value) {
            hint.textContent = '✓ Password cocok';
            hint.style.color = 'var(--accent)';
            pw2.style.borderColor = 'var(--accent)';
        } else {
            hint.textContent = '✗ Password tidak cocok';
            hint.style.color = 'var(--accent2)';
            pw2.style.borderColor = 'var(--accent2)';
        }
    }
    pw1.addEventListener('input', checkMatch);
    pw2.addEventListener('input', checkMatch);
});

/* ================================================================
   PROFIL FOTO PREVIEW
================================================================ */
function onProfilFotoChange(input) {
    if (!input.files || !input.files[0]) return;
    const file   = input.files[0];
    const reader = new FileReader();

    reader.onload = function (e) {
        const src         = e.target.result;
        const preview     = document.getElementById('profil-foto-preview');
        const overlay     = document.getElementById('profil-foto-overlay');
        const placeholder = document.getElementById('profil-foto-placeholder');
        const nameEl      = document.getElementById('profil-foto-name');

        // Tampilkan preview
        if (preview.tagName === 'IMG') {
            preview.src = src;
        } else {
            // Kalau sebelumnya tidak ada foto, ganti div jadi img
            const img = document.createElement('img');
            img.id = 'profil-foto-preview';
            img.src = src;
            img.alt = 'Preview';
            img.style.cssText = 'position:absolute;inset:0;width:100%;height:100%;object-fit:cover;border-radius:12px;z-index:1';
            preview.replaceWith(img);
        }

        // Tampilkan overlay
        if (overlay) {
            overlay.style.display = 'flex';
            overlay.style.flexDirection = 'column';
            overlay.style.alignItems = 'center';
            overlay.style.justifyContent = 'center';
            overlay.style.gap = '6px';
            overlay.innerHTML = `
                <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#fff" stroke-width="2">
                    <path d="M23 19a2 2 0 01-2 2H3a2 2 0 01-2-2V8a2 2 0 012-2h4l2-3h6l2 3h4a2 2 0 012 2z"/>
                    <circle cx="12" cy="13" r="4"/>
                </svg>
                <span style="font-size:12px;font-weight:600;color:#fff">✓ ${file.name}</span>
            `;
        }

        // Sembunyikan placeholder kalau ada
        if (placeholder) placeholder.style.display = 'none';
        if (nameEl) nameEl.textContent = '';
    };

    reader.readAsDataURL(file);
}
</script>
</body>
</html>