<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard UMKM – Kaji Indonesia</title>
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
    --text: #1a1a2e;
    --text-muted: #7a7065;
    --radius: 16px;
    --shadow: 0 2px 16px rgba(45,106,79,.07);
  }
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: 'DM Sans', sans-serif; background: var(--bg); color: var(--text); display: flex; min-height: 100vh; }

  /* SIDEBAR */
  .sidebar {
    width: 265px; min-height: 100vh; background: var(--accent);
    display: flex; flex-direction: column; position: fixed; top: 0; left: 0; z-index: 100;
  }
  .sidebar-brand { padding: 28px 24px 20px; border-bottom: 1px solid rgba(255,255,255,.12); }
  .brand-box { display: flex; align-items: center; gap: 12px; }
  .brand-icon { width: 42px; height: 42px; background: rgba(255,255,255,.15); border-radius: 12px; display: flex; align-items: center; justify-content: center; }
  .brand-icon svg { color: #fff; }
  .brand-name { font-family: 'Cormorant Garamond', serif; font-size: 20px; color: #fff; font-weight: 700; }
  .brand-role { font-size: 11px; color: rgba(255,255,255,.6); letter-spacing: 1.5px; text-transform: uppercase; }

  .nav-section { padding: 20px 16px 8px; }
  .nav-label { font-size: 10px; color: rgba(255,255,255,.4); letter-spacing: 2px; text-transform: uppercase; margin-bottom: 8px; padding-left: 10px; }
  .nav-item {
    display: flex; align-items: center; gap: 12px; padding: 11px 14px; border-radius: 12px;
    cursor: pointer; color: rgba(255,255,255,.7); font-size: 14px; font-weight: 500; margin-bottom: 3px; transition: all .2s;
  }
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

  /* MAIN */
  .main { margin-left: 265px; flex: 1; }

  .topbar { background: var(--surface); border-bottom: 1px solid var(--border); padding: 16px 32px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 50; box-shadow: var(--shadow); }
  .topbar-title { font-family: 'Cormorant Garamond', serif; font-size: 24px; font-weight: 700; color: var(--text); }
  .btn { display: inline-flex; align-items: center; gap: 8px; padding: 9px 18px; border-radius: 10px; font-size: 13px; font-weight: 600; border: none; cursor: pointer; transition: all .2s; font-family: inherit; }
  .btn-primary { background: var(--accent); color: #fff; }
  .btn-primary:hover { background: #1f4e37; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(45,106,79,.3); }
  .btn-ghost { background: var(--surface2); color: var(--text); border: 1px solid var(--border); }
  .btn-ghost:hover { background: var(--border); }

  .content { padding: 32px; }

  /* STATS */
  .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 32px; }
  .stat-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 22px; box-shadow: var(--shadow); position: relative; overflow: hidden; }
  .stat-card.mentor-active-box { border-left: 4px solid var(--accent); }
  .stat-card.mentor-empty-box { border-left: 4px solid var(--accent2); }
  .stat-icon { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 14px; }
  .stat-icon.green { background: var(--accent-light); }
  .stat-icon.orange { background: #fff3ed; }
  .stat-icon.blue { background: #e3f0fa; }
  .stat-icon.yellow { background: #fffbea; }
  .stat-label { font-size: 12px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 6px; }
  .stat-value { font-size: 28px; font-weight: 800; color: var(--text); }
  .stat-sub { font-size: 12px; color: var(--text-muted); margin-top: 4px; }

  /* PRODUCTS */
  .section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; }
  .section-title { font-size: 17px; font-weight: 700; }
  .section-title span { color: var(--text-muted); font-weight: 400; font-size: 14px; margin-left: 8px; }

  .product-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 28px; }
  .product-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; box-shadow: var(--shadow); transition: all .25s; }
  .product-card:hover { transform: translateY(-3px); box-shadow: 0 12px 36px rgba(45,106,79,.12); border-color: var(--accent); }
  .product-img { width: 100%; height: 160px; background: var(--surface2); display: flex; align-items: center; justify-content: center; font-size: 48px; position: relative; overflow: hidden; }
  .product-img img { width: 100%; height: 100%; object-fit: cover; }
  .product-status-badge { position: absolute; top: 10px; right: 10px; }
  .product-body { padding: 18px; }
  .product-category { font-size: 10px; color: var(--accent); text-transform: uppercase; letter-spacing: 1.5px; font-weight: 700; margin-bottom: 6px; }
  .product-name { font-size: 15px; font-weight: 700; margin-bottom: 6px; }
  .product-desc { font-size: 12px; color: var(--text-muted); line-height: 1.6; margin-bottom: 14px; }
  .product-price { font-size: 18px; font-weight: 800; color: var(--accent); margin-bottom: 14px; }
  .product-footer { display: flex; align-items: center; justify-content: space-between; }
  .btn-sm { padding: 6px 14px; font-size: 12px; border-radius: 8px; }
  .btn-outline { background: transparent; border: 1.5px solid var(--accent); color: var(--accent); }
  .btn-outline:hover { background: var(--accent); color: #fff; }

  /* TABLE */
  .table-wrap { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; margin-bottom: 28px; box-shadow: var(--shadow); }
  table { width: 100%; border-collapse: collapse; }
  thead th { padding: 14px 18px; text-align: left; font-size: 11px; letter-spacing: 1.5px; text-transform: uppercase; color: var(--text-muted); background: var(--surface2); border-bottom: 1px solid var(--border); }
  tbody tr { border-bottom: 1px solid var(--border); transition: background .15s; }
  tbody tr:last-child { border-bottom: none; }
  tbody tr:hover { background: #f9f7f4; }
  tbody td { padding: 14px 18px; font-size: 13px; }
  .badge { display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
  .badge-pending { background: #fff8e1; color: #f59e0b; border: 1px solid #fcd34d66; }
  .badge-approved { background: var(--accent-light); color: var(--accent); border: 1px solid #a7d7c566; }
  .badge-rejected { background: #fff0ed; color: var(--accent2); border: 1px solid #e76f5166; }
  .badge-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }

  .page-section { display: none; }
  .page-section.active { display: block; }

  ::-webkit-scrollbar { width: 5px; }
  ::-webkit-scrollbar-track { background: var(--bg); }
  ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }

  /* ===================== RESPONSIVE MOBILE - DASHBOARD UMKM ===================== */

  @media (max-width: 768px) {

    /* Sidebar: sembunyikan, muncul lewat hamburger */
    .sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s ease;
        z-index: 1000;
    }
    .sidebar.open { transform: translateX(0); }

    /* Overlay gelap */
    .sidebar-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.5);
        z-index: 999;
    }
    .sidebar-overlay.active { display: block; }

    /* Main: full lebar */
    .main { margin-left: 0 !important; }

    /* Topbar: padding lebih kecil */
    .topbar {
        padding: 12px 16px !important;
        gap: 8px;
    }

    .topbar-title {
        font-size: 18px !important;
    }

    /* Tombol kembali: teks lebih pendek */
    .topbar a.btn {
        font-size: 11px !important;
        padding: 7px 10px !important;
    }

    /* Hamburger button */
    .hamburger-btn {
        display: flex !important;
        flex-direction: column;
        justify-content: center;
        gap: 5px;
        width: 38px;
        height: 38px;
        background: var(--surface2);
        border: 1px solid var(--border);
        border-radius: 10px;
        cursor: pointer;
        padding: 8px;
        flex-shrink: 0;
    }
    .hamburger-btn span {
        display: block;
        width: 100%;
        height: 2px;
        background: var(--text);
        border-radius: 2px;
    }

    /* Content padding */
    .content { padding: 16px !important; }

    /* Stats grid: 2 kolom */
    .stats-grid {
        grid-template-columns: 1fr 1fr !important;
        gap: 10px !important;
        margin-bottom: 16px !important;
    }

    /* Stat card ke-3 (Program Diikuti): span full */
    .stats-grid .stat-card:nth-child(3) {
        grid-column: span 2 !important;
    }

    .stat-card {
        padding: 14px !important;
    }

    .stat-icon {
        width: 36px !important;
        height: 36px !important;
        font-size: 16px !important;
        margin-bottom: 10px !important;
    }

    .stat-value {
        font-size: 22px !important;
    }

    .stat-label {
        font-size: 10px !important;
    }

    .stat-sub {
        font-size: 10px !important;
    }

    /* Mentor card: susun vertikal */
    .stat-card.mentor-active-box,
    .stat-card.mentor-empty-box {
        flex-direction: column !important;
        align-items: flex-start !important;
        gap: 12px !important;
        padding: 14px !important;
    }

    .stat-card.mentor-active-box > div:first-child,
    .stat-card.mentor-empty-box > div:first-child {
        gap: 10px !important;
    }

    .stat-card.mentor-active-box a,
    .stat-card.mentor-empty-box a {
        width: 100% !important;
        justify-content: center !important;
        font-size: 13px !important;
    }

    /* Section header */
    .section-header {
        flex-direction: column !important;
        align-items: flex-start !important;
        gap: 6px !important;
        margin-bottom: 12px !important;
    }

    /* Tabel status pengajuan */
    .table-wrap {
        border-radius: 12px !important;
        overflow: hidden !important;
    }

    .table-wrap table {
        table-layout: fixed !important;
        width: 100% !important;
    }

    /* Sembunyikan kolom Kategori(2) dan Diajukan(3) */
    .table-wrap table thead tr th:nth-child(2),
    .table-wrap table tbody tr td:nth-child(2),
    .table-wrap table thead tr th:nth-child(3),
    .table-wrap table tbody tr td:nth-child(3) {
        display: none !important;
    }

    .table-wrap table thead tr th:nth-child(1),
    .table-wrap table tbody tr td:nth-child(1) { width: 60% !important; }
    .table-wrap table thead tr th:nth-child(4),
    .table-wrap table tbody tr td:nth-child(4) { width: 40% !important; }

    thead th { padding: 10px 12px !important; font-size: 9px !important; }
    tbody td { padding: 10px 12px !important; font-size: 12px !important; }

    /* Product grid: 1 kolom */
    .product-grid {
        grid-template-columns: 1fr !important;
        gap: 14px !important;
    }

    .product-img {
        height: 140px !important;
    }

    .product-body {
        padding: 14px !important;
    }

    /* Tabel program: sembunyikan Pembimbing(2), Tipe(3), Tanggal(4) */
    #page-program .table-wrap table {
        table-layout: fixed !important;
        width: 100% !important;
    }

    #page-program .table-wrap table thead tr th:nth-child(2),
    #page-program .table-wrap table tbody tr td:nth-child(2),
    #page-program .table-wrap table thead tr th:nth-child(3),
    #page-program .table-wrap table tbody tr td:nth-child(3),
    #page-program .table-wrap table thead tr th:nth-child(4),
    #page-program .table-wrap table tbody tr td:nth-child(4) {
        display: none !important;
    }

    #page-program .table-wrap table thead tr th:nth-child(1),
    #page-program .table-wrap table tbody tr td:nth-child(1) { width: 45% !important; }
    #page-program .table-wrap table thead tr th:nth-child(5),
    #page-program .table-wrap table tbody tr td:nth-child(5) { width: 25% !important; }
    #page-program .table-wrap table thead tr th:nth-child(6),
    #page-program .table-wrap table tbody tr td:nth-child(6) { width: 30% !important; }

    /* Tombol Detail di tabel program */
    #page-program .btn-primary.btn-sm {
        font-size: 11px !important;
        padding: 5px 8px !important;
        min-width: unset !important;
    }
  }

  /* Hamburger: sembunyikan di desktop */
  .hamburger-btn { display: none; }

</style>
</head>
<body>
<div class="sidebar-overlay" id="sidebar-overlay"></div>

<aside class="sidebar">
  <div class="sidebar-brand">
    <div class="brand-box">
      <div class="brand-icon">
        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
      </div>
      <div>
        <div class="brand-name">Kaji Indonesia</div>
        <div class="brand-role">UMKM</div>
      </div>
    </div>
  </div>

  <div class="nav-section">
    <div class="nav-label">Menu Utama</div>
    <div class="nav-item active" onclick="showPage('beranda')">
      <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
      Beranda
    </div>
    <div class="nav-item" onclick="showPage('produk')">
      <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4zM3 6h18M16 10a4 4 0 01-8 0"/></svg>
      Profil UMKM
      <span class="nav-badge"><?php echo e($stats['total_produk']); ?></span>
    </div>
    <div class="nav-item" onclick="showPage('program')">
      <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
      Program Tersedia
    </div>
  </div>

  <div class="sidebar-user">
    <div class="user-card" onclick="showPage('produk')">
      <div class="user-avatar">
        <?php if($user->profile_photo_path): ?>
          <img src="<?php echo e(asset('storage/' . $user->profile_photo_path)); ?>" style="width:100%; height:100%; object-fit:cover;">
        <?php else: ?>
          <?php echo e(substr($user->name, 0, 2)); ?>

        <?php endif; ?>
      </div>
      <div>
        <div class="user-name"><?php echo e($user->name); ?></div>
        <div class="user-role">Mitra UMKM · <?php echo e($user->location ?? 'Indonesia'); ?></div>
      </div>
    </div>
  </div>
</aside>

<main class="main">
  <header class="topbar">
    <button class="hamburger-btn" onclick="toggleSidebar()">
        <span></span><span></span><span></span>
    </button>
    <div class="topbar-title" id="page-title">Dashboard UMKM</div>
    <div style="display:flex;gap:10px;align-items:center">
      <a href="<?php echo e(route('profile')); ?>" class="btn btn-ghost" style="gap:6px;font-size:13px; text-decoration: none;">
        ← Kembali ke Profil
      </a>
    </div>
  </header>

  <div class="content">

    
    <?php if(session('success')): ?>
      <div style="padding: 14px; background: #e8f5e9; border: 1px solid #a7d7c5; color: #2d6a4f; border-radius: 10px; margin-bottom: 20px; font-size: 14px; font-weight: 600;">
           ✅ <?php echo e(session('success')); ?>

      </div>
    <?php endif; ?>

    <div class="page-section active" id="page-beranda">
      
      <div class="stats-grid">
        <div class="stat-card">
          <div class="stat-icon green">🛍️</div>
          <div class="stat-label">Total UMKM</div>
          <div class="stat-value"><?php echo e($stats['total_produk']); ?></div>
          <div class="stat-sub"><?php echo e($stats['pending_produk']); ?> pending persetujuan</div>
        </div>
        <div class="stat-card">
          <div class="stat-icon orange">⏳</div>
          <div class="stat-label">Menunggu Acc</div>
          <div class="stat-value"><?php echo e($stats['pending_produk']); ?></div>
          <div class="stat-sub">UMKM baru diajukan</div>
        </div>
        <div class="stat-card">
          <div class="stat-icon blue">📋</div>
          <div class="stat-label">Program Diikuti</div>
          <div class="stat-value"><?php echo e($stats['program_diikuti']); ?></div>
          <div class="stat-sub">Terdaftar aktif</div>
        </div>
      </div>

      
      <?php
        $myUmkmData = $myProducts->first();
      ?>

      <?php if($myUmkmData && $myUmkmData->mentor_id && $myUmkmData->mentor): ?>
        <div class="stat-card mentor-active-box" style="margin-bottom: 32px; display: flex; align-items: center; justify-content: space-between; gap: 20px; flex-wrap: wrap;">
          <div style="display: flex; align-items: center; gap: 16px;">
            <div class="stat-icon green" style="margin-bottom: 0; font-size: 22px; width: 48px; height: 48px; border-radius: 50%;">👨‍🏫</div>
            <div>
              <div class="stat-label" style="font-size: 10px; color: var(--accent); font-weight: 700; letter-spacing: 1.5px;">Mentor Pendamping Anda</div>
              <div style="font-size: 17px; font-weight: 700; color: var(--text); margin-top: 2px;"><?php echo e($myUmkmData->mentor->full_name ?? $myUmkmData->mentor->nama); ?></div>
              <div style="font-size: 12px; color: var(--text-muted); margin-top: 3px;">
                📞 <?php echo e($myUmkmData->mentor->phone ?? '-'); ?> &nbsp;|&nbsp; 📧 <?php echo e($myUmkmData->mentor->email ?? '-'); ?>

              </div>
            </div>
          </div>
          <?php if($myUmkmData->mentor->phone): ?>
            <a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $myUmkmData->mentor->phone)); ?>" 
               target="_blank" 
               class="btn btn-primary" 
               style="font-size: 12px; padding: 8px 16px; border-radius: 8px; text-decoration: none; background: #25d366; box-shadow: none;">
               💬 Chat Konsultasi
            </a>
          <?php endif; ?>
        </div>
      <?php else: ?>
        <div class="stat-card mentor-empty-box" style="margin-bottom: 32px; display: flex; align-items: center; justify-content: space-between; gap: 20px; flex-wrap: wrap; background: #fffcfb;">
          <div style="display: flex; align-items: center; gap: 16px;">
            <div class="stat-icon orange" style="margin-bottom: 0; font-size: 22px; width: 48px; height: 48px; border-radius: 50%;">📢</div>
            <div>
              <div style="font-size: 15px; font-weight: 700; color: var(--text);">Anda Belum Memiliki Mentor Pendamping</div>
              <div style="font-size: 12px; color: var(--text-muted); margin-top: 2px;">Hubungkan unit UMKM Anda dengan pembimbing terbaik kami untuk konsultasi usaha intensif gratis.</div>
            </div>
          </div>
          <a href="<?php echo e(route('umkm.pembimbing')); ?>" class="btn btn-ghost" style="font-size: 12px; padding: 8px 16px; border-radius: 8px; text-decoration: none; border-color: var(--accent2); color: var(--accent2);">
              Cari Mentor Terbaik →
          </a>
        </div>
      <?php endif; ?>

      <div class="section-header">
        <div class="section-title">Status Pengajuan UMKM <span>terbaru</span></div>
      </div>
      <div class="table-wrap">
        <table>
          <thead><tr><th>Nama UMKM</th><th>Kategori</th><th>Diajukan</th><th>Status</th></tr></thead>
          <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $myProducts->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
              <td><?php echo e($product->nama); ?></td>
              <td><?php echo e($product->kategori); ?></td>
              <td><?php echo e($product->created_at->translatedFormat('d M Y')); ?></td>
              <td>
                <?php if($product->status == 'approved'): ?>
                  <span class="badge badge-approved"><span class="badge-dot"></span>Disetujui</span>
                <?php elseif($product->status == 'rejected'): ?>
                  <span class="badge badge-rejected"><span class="badge-dot"></span>Ditolak</span>
                <?php else: ?>
                  <span class="badge badge-pending"><span class="badge-dot"></span>Pending</span>
                <?php endif; ?>
              </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
              <td colspan="4" style="text-align: center; color: #7a7065;">Belum ada riwayat pengajuan UMKM.</td>
            </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="page-section" id="page-produk">
      <div class="section-header">
        <div class="section-title">Profil UMKM <span><?php echo e($stats['total_produk']); ?> unit</span></div>
      </div>
      <div class="product-grid">
        <?php $__empty_1 = true; $__currentLoopData = $myProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="product-card">
          <div class="product-img">
            <?php if($product->foto_produk): ?>
              <img src="<?php echo e(asset('storage/' . $product->foto_produk)); ?>" alt="<?php echo e($product->nama); ?>">
            <?php else: ?>
              🛍️
            <?php endif; ?>
            <div class="product-status-badge">
              <?php if($product->status == 'approved'): ?>
                <span class="badge badge-approved"><span class="badge-dot"></span>Aktif</span>
              <?php else: ?>
                <span class="badge badge-pending"><span class="badge-dot"></span>Non-Aktif</span>
              <?php endif; ?>
            </div>
          </div>
          <div class="product-body">
            <div class="product-category"><?php echo e($product->kategori); ?></div>
            <div class="product-name"><?php echo e($product->nama); ?></div>
            <div class="product-desc"><?php echo e($product->deskripsi); ?></div>
            
            <div class="product-footer" style="display: flex; align-items: center; justify-content: space-between; width: 100%; margin-top: 10px;">
              <div>
                <?php if($product->status == 'approved'): ?>
                  <span class="badge badge-approved"><span class="badge-dot"></span>Disetujui</span>
                <?php elseif($product->status == 'rejected'): ?>
                  <span class="badge badge-rejected"><span class="badge-dot"></span>Ditolak</span>
                <?php else: ?>
                  <span class="badge badge-pending"><span class="badge-dot"></span>Pending</span>
                <?php endif; ?>
              </div>

              <a href="<?php echo e(route('dashboard.produk.edit', $product->id)); ?>" 
                 class="btn btn-outline btn-sm" 
                 style="text-decoration: none; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 600; display: inline-flex; align-items: center; gap: 4px;">
                ✏️ Edit
              </a>
            </div>

          </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div style="grid-column: span 3; text-align: center; padding: 40px; color: #7a7065;">
           Belum ada profil usaha yang diunggah.
        </div>
        <?php endif; ?>
      </div>
    </div>

    
    <div class="page-section" id="page-program">
      <div class="section-header">
        <div class="section-title">Program Tersedia <span>dari Pembimbing/Trainer</span></div>
      </div>
      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th>Nama Program</th>
              <th>Pembimbing/Trainer</th>
              <th>Tipe</th>
              <th>Tanggal</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $availablePrograms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
              <td><strong><?php echo e($program->judul); ?></strong></td>
              <td><?php echo e($program->trainer->name ?? 'Trainer Profesional'); ?></td>
              <td><span style="text-transform: capitalize;"><?php echo e($program->tipe); ?></span></td>
              <td><?php echo e($program->tanggal ? $program->tanggal->translatedFormat('d M Y') : '-'); ?></td>
              <td><span class="badge badge-approved"><span class="badge-dot"></span>Dibuka</span></td>
              
              
              <td>
                <a href="<?php echo e(route('pelatihan.detail', $program->id)); ?>" 
                   class="btn btn-primary btn-sm" 
                   style="text-decoration: none; padding: 6px 14px; text-align: center; min-width: 80px; display: inline-flex; justify-content: center;">
                   Detail
                </a>
              </td>
              
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
              <td colspan="6" style="text-align: center; color: #7a7065; padding: 20px;">
                Belum ada program pelatihan aktif dari Trainer saat ini.
              </td>
            </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</main>

<script>
  function showPage(id) {
    document.querySelectorAll('.page-section').forEach(el => el.classList.remove('active'));
    document.querySelectorAll('.nav-item').forEach(el => el.classList.remove('active'));
    document.getElementById('page-' + id).classList.add('active');
    
    const titles = { beranda: 'Dashboard UMKM', produk: 'Profil UMKM', program: 'Program Tersedia' };
    document.getElementById('page-title').textContent = titles[id] || '';
    document.querySelectorAll('.nav-item').forEach(item => {
      if (item.getAttribute('onclick') && item.getAttribute('onclick').includes("'" + id + "'")) item.classList.add('active');
    });
  }

  function toggleSidebar() {
    document.querySelector('.sidebar').classList.toggle('open');
    document.getElementById('sidebar-overlay').classList.toggle('active');
  }

  document.getElementById('sidebar-overlay').addEventListener('click', function() {
    document.querySelector('.sidebar').classList.remove('open');
    this.classList.remove('active');
  });

  // Tutup sidebar saat klik nav item
  document.querySelectorAll('.nav-item').forEach(function(item) {
    item.addEventListener('click', function() {
      document.querySelector('.sidebar').classList.remove('open');
      document.getElementById('sidebar-overlay').classList.remove('active');
    });
  });

</script>
</body>
</html><?php /**PATH C:\laragon\www\webkajiindonesia\resources\views/profile/dashboard-umkm.blade.php ENDPATH**/ ?>