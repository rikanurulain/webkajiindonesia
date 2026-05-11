<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Produk;
use App\Models\Program;
use App\Models\User;
use App\Models\Mentor;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // ─────────────────────────────────────────────
    // BERANDA / OVERVIEW
    // ─────────────────────────────────────────────

    public function index()
    {
        $stats = [
            'total_pending'   => Program::where('status', 'pending')->count()
                               + Produk::where('status', 'pending')->count()
                               + Event::where('status', 'pending')->count()
                               + User::where('trainer_status', 'pending')->count(),
            'pending_produk'  => Produk::where('status', 'pending')->count(),
            'pending_program' => Program::where('status', 'pending')->count(),
            'pending_event'   => Event::where('status', 'pending')->count(),
            'pending_trainer' => User::where('trainer_status', 'pending')->count(),
            'pending_mentor' => User::where('mentor_status', 'pending')->count(),
            'pending_hari_ini'=> Produk::where('status', 'pending')->whereDate('created_at', today())->count()
                               + Program::where('status', 'pending')->whereDate('created_at', today())->count()
                               + Event::where('status', 'pending')->whereDate('created_at', today())->count()
                               + User::where('trainer_status', 'pending')->whereDate('updated_at', today())->count(),
            'disetujui_bulan' => Program::where('status', 'approved')->whereMonth('updated_at', now()->month)->count()
                               + Produk::where('status', 'approved')->whereMonth('updated_at', now()->month)->count()
                               + Event::where('status', 'approved')->whereMonth('updated_at', now()->month)->count(),
            'total_users'      => User::count(),
            'total_umkm'       => User::where('role', 'umkm')->count(),
            'total_pembimbing' => User::where('role', 'pembimbing')->count(),
        ];

        $antrian_terbaru = collect()
            ->merge(
                Program::with('pembimbing')->where('status', 'pending')->latest()->take(3)->get()
                    ->map(fn($p) => [
                        'id'             => $p->id,
                        'type'           => 'program',
                        'nama'           => $p->nama ?? $p->judul ?? 'Program',
                        'submitter'      => optional($p->pembimbing)->name ?? 'Pembimbing',
                        'submitter_role' => 'Pembimbing',
                        'tanggal'        => $p->created_at,
                        'avatar_color'   => 'var(--accent)',
                    ])
            )
            ->merge(
                Produk::with('umkm')->where('status', 'pending')->latest()->take(3)->get()
                    ->map(fn($p) => [
                        'id'             => $p->id,
                        'type'           => 'produk',
                        'nama'           => $p->nama ?? 'Produk',
                        'foto'           => $p->foto ?? null,
                        'submitter'      => optional($p->umkm)->name ?? 'UMKM',
                        'submitter_role' => 'UMKM',
                        'tanggal'        => $p->created_at,
                        'avatar_color'   => 'var(--accent3)',
                    ])
            )
            ->sortByDesc('tanggal')
            ->take(5)
            ->values();

        $pengguna_terbaru = User::latest()->take(5)->get();
        $produk_terbaru   = Produk::latest()->take(5)->get();

        return view('admin.dashboard-admin', compact('stats', 'antrian_terbaru', 'pengguna_terbaru', 'produk_terbaru'));
    }

    // ─────────────────────────────────────────────
    // APPROVAL PROGRAM
    // ─────────────────────────────────────────────

    public function approvalProgram(Request $request)
    {
        $status = $request->get('status', 'pending');

        $programs = Program::with('pembimbing')
            ->when($status !== 'all', fn($q) => $q->where('status', $status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $counts = [
            'pending'  => Program::where('status', 'pending')->count(),
            'approved' => Program::where('status', 'approved')->count(),
            'rejected' => Program::where('status', 'rejected')->count(),
        ];

        return view('admin.approval-program', compact('programs', 'counts', 'status'));
    }

    public function detailProgram(Program $program)
    {
        return response()->json($program->load('pembimbing'));
    }

    public function approveProgram(Request $request, Program $program)
    {
        $request->validate(['catatan' => 'nullable|string|max:1000']);

        $program->update([
            'status'        => 'approved',
            'catatan_admin' => $request->catatan,
            'approved_at'   => now(),
            'approved_by'   => auth()->id(),
        ]);

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Program berhasil disetujui.', 'program' => $program]);
        }

        return back()->with('success', 'Program berhasil disetujui.');
    }

    public function rejectProgram(Request $request, Program $program)
    {
        $request->validate(['alasan' => 'required|string|max:1000']);

        $program->update([
            'status'        => 'rejected',
            'catatan_admin' => $request->alasan,
            'rejected_at'   => now(),
            'rejected_by'   => auth()->id(),
        ]);

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Program berhasil ditolak.']);
        }

        return back()->with('success', 'Program telah ditolak.');
    }

    // ─────────────────────────────────────────────
    // APPROVAL PRODUK
    // ─────────────────────────────────────────────

    public function approvalProduk(Request $request)
    {
        $status = $request->get('status', 'pending');

        $produks = Produk::with('umkm')
            ->when($status !== 'all', fn($q) => $q->where('status', $status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $counts = [
            'pending'  => Produk::where('status', 'pending')->count(),
            'approved' => Produk::where('status', 'approved')->count(),
            'rejected' => Produk::where('status', 'rejected')->count(),
        ];

        return view('admin.approval-produk', compact('produks', 'counts', 'status'));
    }

    public function detailProduk(Produk $produk)
    {
        return response()->json($produk->load('umkm'));
    }

    public function approveProduk(Request $request, Produk $produk)
    {
        $request->validate(['catatan' => 'nullable|string|max:1000']);

        $produk->update([
            'status'        => 'approved',
            'catatan_admin' => $request->catatan,
            'approved_at'   => now(),
            'approved_by'   => auth()->id(),
        ]);

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Produk berhasil disetujui.', 'produk' => $produk]);
        }

        return back()->with('success', 'Produk berhasil disetujui.');
    }

    public function rejectProduk(Request $request, Produk $produk)
    {
        $request->validate(['alasan' => 'required|string|max:1000']);

        $produk->update([
            'status'        => 'rejected',
            'catatan_admin' => $request->alasan,
            'rejected_at'   => now(),
            'rejected_by'   => auth()->id(),
        ]);

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Produk berhasil ditolak.']);
        }

        return back()->with('success', 'Produk telah ditolak.');
    }

    // ─────────────────────────────────────────────
    // APPROVAL EVENT
    // ─────────────────────────────────────────────

    public function approvalEvent(Request $request)
    {
        $status = $request->get('status', 'pending');

        $events = Event::with('pembimbing')
            ->when($status !== 'all', fn($q) => $q->where('status', $status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $counts = [
            'pending'  => Event::where('status', 'pending')->count(),
            'approved' => Event::where('status', 'approved')->count(),
            'rejected' => Event::where('status', 'rejected')->count(),
        ];

        return view('admin.approval-event', compact('events', 'counts', 'status'));
    }

    public function detailEvent(Event $event)
    {
        return response()->json($event->load('pembimbing'));
    }

    public function approveEvent(Request $request, Event $event)
    {
        $request->validate(['catatan' => 'nullable|string|max:1000']);

        $event->update([
            'status'        => 'approved',
            'catatan_admin' => $request->catatan,
            'approved_at'   => now(),
            'approved_by'   => auth()->id(),
        ]);

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Event berhasil disetujui.', 'event' => $event]);
        }

        return back()->with('success', 'Event berhasil disetujui.');
    }

    public function rejectEvent(Request $request, Event $event)
    {
        $request->validate(['alasan' => 'required|string|max:1000']);

        $event->update([
            'status'        => 'rejected',
            'catatan_admin' => $request->alasan,
            'rejected_at'   => now(),
            'rejected_by'   => auth()->id(),
        ]);

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Event berhasil ditolak.']);
        }

        return back()->with('success', 'Event telah ditolak.');
    }

    // ─────────────────────────────────────────────
    // MANAJEMEN PENGGUNA
    // ─────────────────────────────────────────────

    public function pengguna(Request $request)
    {
        $users = User::when($request->role, fn($q) => $q->where('role', $request->role))
            ->when($request->search, fn($q) => $q->where(function ($q2) use ($request) {
                $q2->where('name', 'like', "%{$request->search}%")
                   ->orWhere('email', 'like', "%{$request->search}%");
            }))
            ->latest()
            ->paginate(20)
            ->withQueryString();
    
        return view('admin.pengguna', compact('users'));
    }
    public function verifikasiPengguna(Request $request, User $user)
    {
        $user->update(['status' => 'active', 'email_verified_at' => now()]);

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Pengguna berhasil diverifikasi.']);
        }

        return back()->with('success', 'Pengguna berhasil diverifikasi.');
    }

    public function suspendPengguna(Request $request, User $user)
    {
        $user->update(['status' => 'suspended']);

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Pengguna berhasil di-suspend.']);
        }

        return back()->with('success', 'Pengguna berhasil di-suspend.');
    }

    // ─────────────────────────────────────────────
    // APPROVAL TRAINER (BARU)
    // ─────────────────────────────────────────────

    public function approvalTrainer(Request $request)
    {
        $status = $request->get('status', 'pending');

        $applicants = User::where('trainer_status', '!=', 'none')
            ->when($status !== 'all', fn($q) => $q->where('trainer_status', $status))
            ->latest()
            ->paginate(15);

        $counts = [
            'pending'  => User::where('trainer_status', 'pending')->count(),
            'approved' => User::where('trainer_status', 'approved')->count(),
            'rejected' => User::where('trainer_status', 'rejected')->count(),
        ];

        return view('admin.approval-trainer', compact('applicants', 'counts', 'status'));
    }

    public function approveTrainer(User $user)
    {
        $user->update([
            'role'           => 'pembimbing', // atau 'trainer' sesuai keinginanmu
            'trainer_status' => 'approved',
            'is_pembimbing'  => true,
            'pembimbing_expired_at' => now()->addYear(), // Aktif 1 tahun
        ]);

        return back()->with('success', "{$user->name} berhasil disetujui sebagai Trainer.");
    }

    public function rejectTrainer(Request $request, User $user)
    {
        $user->update([
            'trainer_status' => 'rejected',
        ]);

        return back()->with('success', "Pendaftaran {$user->name} telah ditolak.");
    }

// ____________________________________________________________________
// APPROVEL MENTOR (BARU)
// ─────────────────────────────────────────────    
public function approvalMentor()
{
    $pending  = Mentor::where('status', 'pending')->get();
    $approved = Mentor::where('status', 'approved')->get();
    $rejected = Mentor::where('status', 'rejected')->get();

    $stats = [
        'pending'  => $pending->count(),
        'approved' => $approved->count(),
        'rejected' => $rejected->count(),
    ];

    return view('admin.approval-mentor', compact('pending', 'approved', 'rejected', 'stats'));
}

public function approveMentor(Mentor $mentor)
{
    $mentor->update([
        'status'      => 'approved',
        'reviewed_at' => now(),
    ]);

    return back()->with('success', "{$mentor->full_name} berhasil disetujui sebagai Mentor.");
}

public function rejectMentor(Request $request, Mentor $mentor)
{
    $request->validate(['rejection_reason' => 'required|string|max:1000']);

    $mentor->update([
        'status'           => 'rejected',
        'rejection_reason' => $request->rejection_reason,
        'reviewed_at'      => now(),
    ]);

    return back()->with('success', "Pendaftaran {$mentor->full_name} telah ditolak.");
}

public function destroyMentor(Mentor $mentor)
{
    $mentor->delete();
    return back()->with('success', 'Data mentor berhasil dihapus.');
}
}