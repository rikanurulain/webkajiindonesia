<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Produk;
use App\Models\Program;
use App\Models\User;
use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AdminController extends Controller
{
    // ═════════════════════════════════════════════════════════════════════
    // BERANDA / DASHBOARD
    // ═════════════════════════════════════════════════════════════════════
    public function index()
    {
        $stats = [
            'total_pending'    => Program::where('status', 'pending')->count()
                                + Produk::where('status', 'pending')->count()
                                + Event::where('status', 'pending')->count()
                                + User::where('trainer_status', 'pending')->count(),
            'pending_produk'   => Produk::where('status', 'pending')->count(),
            'pending_program'  => Program::where('status', 'pending')->count(),
            'pending_event'    => Event::where('status', 'pending')->count(),
            'pending_trainer'  => User::where('trainer_status', 'pending')->count(),
            'pending_mentor'   => User::where('mentor_status', 'pending')->count(),
            'pending_hari_ini' => Produk::where('status', 'pending')->whereDate('created_at', today())->count()
                                + Program::where('status', 'pending')->whereDate('created_at', today())->count()
                                + Event::where('status', 'pending')->whereDate('created_at', today())->count()
                                + User::where('trainer_status', 'pending')->whereDate('trainer_applied_at', today())->count(),
            'disetujui_bulan'  => Program::where('status', 'approved')->whereMonth('updated_at', now()->month)->count()
                                + Produk::where('status', 'approved')->whereMonth('updated_at', now()->month)->count()
                                + Event::where('status', 'approved')->whereMonth('updated_at', now()->month)->count(),
            'total_users'      => User::count(),
            'total_umkm'       => User::where('role', 'umkm')->count(),
            'total_pembimbing' => User::where('role', 'pembimbing')->count(),
        ];
        $pendingProgram = $stats['pending_program'];
        $pendingEvent   = $stats['pending_event'];
        $totalProgram   = Program::where('status', 'approved')->count();
        $totalPengguna  = User::count();
        $antrian_terbaru = collect()
            ->merge(
                Program::with('trainer')->where('status', 'pending')->latest()->take(3)->get()
                    ->map(fn($p) => [
                        'id'             => $p->id,
                        'type'           => 'program',
                        'nama'           => $p->judul ?? 'Program',
                        'submitter'      => optional($p->trainer)->name ?? 'trainer',
                        'submitter_role' => 'trainer',
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
        $programPending = Program::with('trainer')
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();
        $eventPending = Event::with('trainer')
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();
        $pengguna_terbaru = User::latest()->take(5)->get();
        $produk_terbaru   = Produk::latest()->take(5)->get();
        return view('admin.dashboard-admin', compact(
            'stats',
            'antrian_terbaru',
            'pengguna_terbaru',
            'produk_terbaru',
            'pendingProgram',
            'pendingEvent',
            'totalProgram',
            'totalPengguna',
            'programPending',
            'eventPending'
        ));
    }

    // ═════════════════════════════════════════════════════════════════════
    // APPROVAL PROGRAM (kurikulum + modul)
    // ═════════════════════════════════════════════════════════════════════
    public function approvalProgram(Request $request)
    {
        $status = $request->get('status', 'pending');
        $tipe   = $request->get('tipe', 'all');
        $programs = Program::with('trainer')
            ->when($status !== 'all', fn($q) => $q->where('status', $status))
            ->when($tipe   !== 'all', fn($q) => $q->where('tipe', $tipe))
            ->latest()
            ->paginate(15)
            ->withQueryString();
        $counts = [
            'pending'  => Program::where('status', 'pending')->count(),
            'approved' => Program::where('status', 'approved')->count(),
            'rejected' => Program::where('status', 'rejected')->count(),
        ];
        $tipeBase = $status !== 'all'
            ? Program::where('status', $status)
            : Program::query();
        $countTipe = [
            'all'       => (clone $tipeBase)->count(),
            'kurikulum' => (clone $tipeBase)->where('tipe', 'kurikulum')->count(),
            'modul'     => (clone $tipeBase)->where('tipe', 'modul')->count(),
        ];
        return view('admin.approval-program', compact(
            'programs',
            'counts',
            'countTipe',
            'status',
            'tipe'
        ));
    }
    public function detailProgram(Program $program)
    {
        return response()->json($program->load('trainer'));
    }
    public function approveProgram(Request $request, Program $program)
    {
        $request->validate(['catatan' => 'nullable|string|max:1000']);
        $program->update([
            'status'        => 'approved',
            'catatan_admin' => $request->catatan,
            'approved_at'   => now(),
            'approved_by'   => Auth::id(),
            'rejected_at'   => null,
            'rejected_by'   => null,
        ]);
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Program berhasil disetujui.', 'program' => $program]);
        }
        return back()->with('success', "Program \"{$program->judul}\" berhasil disetujui.");
    }
    public function rejectProgram(Request $request, Program $program)
    {
        $request->validate(['alasan' => 'required|string|max:1000']);
        $program->update([
            'status'        => 'rejected',
            'catatan_admin' => $request->alasan,
            'rejected_at'   => now(),
            'rejected_by'   => Auth::id(),
            'approved_at'   => null,
            'approved_by'   => null,
        ]);
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Program berhasil ditolak.']);
        }
        return back()->with('success', "Program \"{$program->judul}\" telah ditolak.");
    }

    // ═════════════════════════════════════════════════════════════════════
    // APPROVAL PRODUK
    // ═════════════════════════════════════════════════════════════════════
    public function approvalProduk(Request $request)
    {
        $pending  = Produk::with('umkm')->where('status', 'pending')->latest()->get();
        $approved = Produk::with('umkm')->where('status', 'approved')->latest()->get();
        $rejected = Produk::with('umkm')->where('status', 'rejected')->latest()->get();

        $counts = [
            'pending'  => $pending->count(),
            'approved' => $approved->count(),
            'rejected' => $rejected->count(),
        ];

        return view('admin.approval-produk', compact('pending', 'approved', 'rejected', 'counts'));
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
            'approved_by'   => Auth::id(),
        ]);
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Produk berhasil disetujui.', 'produk' => $produk]);
        }
        return redirect()->route('admin.approval.produk', ['tab' => 'approved'])
            ->with('success', 'Produk berhasil disetujui.');
    }
    public function rejectProduk(Request $request, Produk $produk)
    {
        $request->validate(['alasan' => 'required|string|max:1000']);
        $produk->update([
            'status'        => 'rejected',
            'catatan_admin' => $request->alasan,
            'rejected_at'   => now(),
            'rejected_by'   => Auth::id(),
        ]);
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Produk berhasil ditolak.']);
        }
        return redirect()->route('admin.approval.produk', ['tab' => 'rejected'])
            ->with('success', 'Produk telah ditolak.');
    }
    // ── BARU: Hapus produk (approved / rejected) ──────────────────────
    public function destroyProduk(Produk $produk)
    {
        $nama = $produk->nama;
        $produk->delete();
        return back()->with('success', "Produk \"{$nama}\" berhasil dihapus.");
    }

    // ═════════════════════════════════════════════════════════════════════
    // APPROVAL EVENT — (diperbarui dari AdminEventController)
    // ═════════════════════════════════════════════════════════════════════
    public function approvalEvent(Request $request)
    {
        $status = $request->get('status', 'pending');
        $events = Event::with('trainer')
            ->where('status', $status)
            ->latest()
            ->get();
        return view('admin.approval-event', compact('events', 'status'));
    }
    public function detailEvent(Event $event)
    {
        return response()->json($event->load('trainer'));
    }
    public function approveEvent($id)
    {
        $event = Event::findOrFail($id);
        $event->update([
            'status'        => 'approved',
            'approved_at'   => now(),
            'approved_by'   => Auth::id(),
            'rejected_at'   => null,
            'rejected_by'   => null,
            'catatan_admin' => null,
        ]);
        return back()->with('success', 'Event "' . $event->judul . '" berhasil disetujui.');
    }
    public function rejectEvent(Request $request, $id)
    {
        $request->validate([
            'catatan_admin' => 'required|string|max:500',
        ]);
        $event = Event::findOrFail($id);
        $event->update([
            'status'        => 'rejected',
            'rejected_at'   => now(),
            'rejected_by'   => Auth::id(),
            'catatan_admin' => $request->catatan_admin,
            'approved_at'   => null,
            'approved_by'   => null,
        ]);
        return back()->with('success', 'Event "' . $event->judul . '" ditolak dengan catatan.');
    }

    // ═════════════════════════════════════════════════════════════════════
    // MANAJEMEN PENGGUNA
    // ═════════════════════════════════════════════════════════════════════
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

    // ═════════════════════════════════════════════════════════════════════
    // APPROVAL TRAINER
    // ═════════════════════════════════════════════════════════════════════
    public function approvalTrainer()
    {
        $pending = User::where('trainer_status', 'pending')
            ->whereNotNull('nik')
            ->latest('trainer_applied_at')
            ->get();
        $approved = User::where('trainer_status', 'approved')
            ->latest('updated_at')
            ->get();
        $rejected = User::where('trainer_status', 'rejected')
            ->latest('updated_at')
            ->get();
        $counts = [
            'pending'  => $pending->count(),
            'approved' => $approved->count(),
            'rejected' => $rejected->count(),
        ];
        return view('admin.approval-trainer', compact('pending', 'approved', 'rejected', 'counts'));
    }
    public function approveTrainer(User $user)
    {
        $user->update([
            'role'                  => 'trainer',
            'trainer_status'        => 'approved',
            'is_pembimbing'         => true,
            'pembimbing_expired_at' => now()->addYear(),
        ]);
        return redirect()->to('/admin/approval/trainer')
            ->with('success', "{$user->name} berhasil disetujui sebagai Trainer.");
    }
    public function rejectTrainer(Request $request, User $user)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);
        $user->update([
            'trainer_status'   => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);
        return redirect()->route('admin.approval.trainer')
            ->with('success', "Pendaftaran {$user->name} telah ditolak.");
    }

    public function destroyTrainer(User $user)
    {
        // Hapus file storage yang terupload saat pendaftaran trainer
        $fileCols = ['ktp_scan', 'bnsp_certificate', 'white_bg_photo', 'ijazah_file', 'bukti_transfer'];
        foreach ($fileCols as $col) {
            if (!empty($user->$col)) {
                \Storage::disk('public')->delete($user->$col);
            }
        }

        // Reset semua kolom pendaftaran trainer ke null
        // sehingga user hilang dari halaman approval trainer DAN halaman daftar trainer
        $user->update([
            'role'                     => 'umum',  // ← reset ke role biasa; ENUM: umum|admin|trainer|umkm|mentor
            'trainer_status'           => null,
            'trainer_applied_at'       => null,
            'rejection_reason'         => null,
            'is_pembimbing'            => false,
            'pembimbing_expired_at'    => null,
            'location'                 => null,
            'gmaps_location'           => null,
            'provinsi'                 => null,
            'kabupaten'                => null,
            'kecamatan'                => null,
            'kelurahan'                => null,
            'nik'                      => null,
            'npwp'                     => null,
            'academic_degree'          => null,
            'experience'               => null,
            'bio'                      => null,
            'ijazah_type'              => null,
            'ijazah_file'              => null,
            'ktp_scan'                 => null,
            'bnsp_certificate'         => null,
            'white_bg_photo'           => null,
            'drive_link_documentation' => null,
            'bukti_transfer'           => null,
        ]);

        return redirect()->route('admin.approval.trainer')
            ->with('success', "Data trainer {$user->name} berhasil dihapus.");
    }

    // ═════════════════════════════════════════════════════════════════════
    // APPROVAL MENTOR
    // ═════════════════════════════════════════════════════════════════════
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