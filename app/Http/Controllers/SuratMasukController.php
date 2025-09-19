<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\User;
use App\Models\Disposisi;
use App\Services\NumberSequenceService;
use App\Notifications\DisposisiCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SuratMasukController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','permission:surat-masuk.view'])->only(['index','show']);
        $this->middleware(['auth','permission:surat-masuk.create'])->only(['create','store']);
        $this->middleware(['auth','permission:surat-masuk.update'])->only(['edit','update']);
        $this->middleware(['auth','permission:surat-masuk.delete'])->only(['destroy']);
    }

    public function index(Request $request)
    {
        $q = SuratMasuk::query();

        if ($s = $request->input('q')) {
            $q->where(function($qq) use ($s) {
                $qq->where('keterangan_isi','like',"%$s%")
                   ->orWhere('pengirim','like',"%$s%")
                   ->orWhere('nomor_surat','like',"%$s%")
                   ->orWhere('agenda_number','like',"%$s%");
            });
        }
        if ($from = $request->input('from')) {
            $q->whereDate('tanggal_surat','>=',$from);
        }
        if ($to = $request->input('to')) {
            $q->whereDate('tanggal_surat','<=',$to);
        }

        $items = $q->orderByDesc('tanggal_surat')->paginate(10);

        return view('surat_masuk.index', compact('items'));
    }

    public function create()
    {
        return view('surat_masuk.create');
    }

    public function store(Request $request, NumberSequenceService $seq)
    {
        $validated = $request->validate([
            'pengirim'        => 'required|string|max:191',
            'tanggal_surat'   => 'required|date',
            'nomor_surat'     => 'required|string|max:191',
            'keterangan_isi'  => 'required|string|max:255',
            'tanggal_masuk'   => 'nullable|date',
            'file'            => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $path = $request->file('file')->store('surat_masuk','public');

        // Generate agenda otomatis
        $prefix = 'AGD/'.date('Y');
        $next   = $seq->next($prefix);
        $agenda = sprintf('%s/%04d', $prefix, $next);

        // Gunakan tanggal_masuk dari form, jika kosong pakai hari ini
        $tanggal_masuk = $validated['tanggal_masuk'] ?? now()->toDateString();

        $item = SuratMasuk::create([
            'pengirim'       => $validated['pengirim'],
            'tanggal_surat'  => $validated['tanggal_surat'],
            'nomor_surat'    => $validated['nomor_surat'],
            'keterangan_isi' => $validated['keterangan_isi'],
            'tanggal_masuk'  => $tanggal_masuk,
            'file_path'      => $path,
            'agenda_number'  => $agenda,
            'status'         => 'baru',
        ]);

        return redirect()->route('surat-masuk.show', $item->id)->with('success','Surat masuk tersimpan');
    }

    public function show(SuratMasuk $surat_masuk)
    {
        $surat_masuk->load('disposisi.penerima','disposisi.pengirim');
        return view('surat_masuk.show', ['item'=>$surat_masuk]);
    }

    public function edit(SuratMasuk $surat_masuk)
    {
        return view('surat_masuk.edit', ['item'=>$surat_masuk]);
    }

    public function update(Request $request, SuratMasuk $surat_masuk)
    {
        $validated = $request->validate([
            'pengirim'        => 'required|string|max:191',
            'tanggal_surat'   => 'required|date',
            'nomor_surat'     => 'required|string|max:191',
            'keterangan_isi'  => 'required|string|max:255',
            'tanggal_masuk'   => 'nullable|date',
            'file'            => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048', // nullable untuk update
        ]);

        // Upload file baru jika ada
        if ($request->hasFile('file')) {
            if ($surat_masuk->file_path) {
                Storage::disk('public')->delete($surat_masuk->file_path);
            }
            $validated['file_path'] = $request->file('file')->store('surat_masuk','public');
        }

        // Update semua kecuali file_path yang sudah diurus di atas
        $surat_masuk->fill([
            'pengirim'        => $validated['pengirim'],
            'tanggal_surat'   => $validated['tanggal_surat'],
            'nomor_surat'     => $validated['nomor_surat'],
            'keterangan_isi'  => $validated['keterangan_isi'],
            'tanggal_masuk'   => $validated['tanggal_masuk'],
        ]);
        if (isset($validated['file_path'])) {
            $surat_masuk->file_path = $validated['file_path'];
        }
        $surat_masuk->save();

        return redirect()->route('surat-masuk.show',$surat_masuk->id)->with('success','Surat masuk diperbarui');
    }

    public function destroy(SuratMasuk $surat_masuk)
    {
        if ($surat_masuk->file_path) {
            Storage::disk('public')->delete($surat_masuk->file_path);
        }
        $surat_masuk->delete();
        return redirect()->route('surat-masuk.index')->with('success','Surat masuk dihapus');
    }

    public function kirimDisposisi(Request $request, SuratMasuk $surat_masuk)
    {
        $data = $request->validate([
            'penerima_id' => 'required|exists:users,id',
            'instruksi'   => 'nullable|string',
        ]);

        $disp = Disposisi::create([
            'surat_masuk_id' => $surat_masuk->id,
            'pengirim_id'    => Auth::id(),
            'penerima_id'    => $data['penerima_id'],
            'instruksi'      => $data['instruksi'] ?? '',
            'status'         => 'terkirim',
        ]);

        $disp->penerima->notify(new DisposisiCreated($surat_masuk->id, $surat_masuk->keterangan_isi, $disp->instruksi));

        return back()->with('success','Disposisi terkirim');
    }
}
