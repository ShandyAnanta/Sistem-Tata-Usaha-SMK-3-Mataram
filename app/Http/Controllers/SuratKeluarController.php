<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratKeluarController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','permission:surat-keluar.view'])->only(['index','show']);
        $this->middleware(['auth','permission:surat-keluar.create'])->only(['create','store']);
        $this->middleware(['auth','permission:surat-keluar.update'])->only(['edit','update']);
        $this->middleware(['auth','permission:surat-keluar.delete'])->only(['destroy']);
    }

    public function index(Request $request)
    {
        $q = SuratKeluar::query();

        if ($s = $request->input('q')) {
            $q->where(function($qq) use ($s) {
                $qq->where('keterangan_surat','like',"%$s%")
                   ->orWhere('nama_penerima','like',"%$s%")
                   ->orWhere('nomor_surat','like',"%$s%");
            });
        }

        if ($from = $request->input('from')) $q->whereDate('tanggal_surat','>=',$from);
        if ($to   = $request->input('to'))   $q->whereDate('tanggal_surat','<=',$to);

        $items = $q->orderByDesc('tanggal_surat')->paginate(10);

        return view('surat_keluar.index', compact('items'));
    }

    public function create()
    {
        return view('surat_keluar.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tanggal_surat'    => 'required|date',
            'nama_penerima'    => 'required|string|max:191',
            'keterangan_surat' => 'required|string|max:255',
            'nomor_surat'      => 'required|string|max:191',
            'file'             => 'required|mimetypes:application/pdf,application/x-pdf,image/jpeg,image/png|max:2048',
        ]);

        $path = $request->file('file')->store('surat_keluar', 'public');

        $item = SuratKeluar::create([
            'tanggal_surat'    => $data['tanggal_surat'],
            'nama_penerima'    => $data['nama_penerima'],
            'keterangan_surat' => $data['keterangan_surat'],
            'nomor_surat'      => $data['nomor_surat'],
            'file_path'        => $path,
            'status'           => 'draft', // atau hapus jika tidak dipakai
        ]);

        return redirect()->route('surat-keluar.show', $item->id)->with('success','Surat keluar tersimpan');
    }

    public function show(SuratKeluar $surat_keluar)
    {
        // Hapus eager load approvals jika FK belum siap untuk menghindari error 1054
        return view('surat_keluar.show', ['item'=>$surat_keluar]);
    }

    public function destroy(SuratKeluar $surat_keluar)
    {
        if ($surat_keluar->file_path) {
            Storage::disk('public')->delete($surat_keluar->file_path);
        }
        $surat_keluar->delete();

        return redirect()->route('surat-keluar.index')->with('success','Surat keluar dihapus');
    }
}
