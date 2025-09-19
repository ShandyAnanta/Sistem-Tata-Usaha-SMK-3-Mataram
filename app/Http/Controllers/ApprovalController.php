<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use App\Services\NumberSequenceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ApprovalController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','permission:surat-keluar.approve']);
    }

    // Disetujui oleh Kajur -> kirim ke Kepsek
    public function approveKajur(Request $request, SuratKeluar $surat_keluar)
    {
        return DB::transaction(function () use ($surat_keluar) {
            if ($surat_keluar->status !== 'pending_kajur') {
                return back()->with('error','Status tidak sesuai');
            }

            $surat_keluar->status = 'pending_kepsek';
            $surat_keluar->save();

            $surat_keluar->approvals()->updateOrCreate(
                ['level'=>1],
                ['approver_id'=>Auth::id(),'status'=>'approved','decided_at'=>now()]
            );

            $surat_keluar->approvals()->updateOrCreate(
                ['level'=>2],
                ['approver_id'=>$this->findKepsekId(),'status'=>'pending']
            );

            return back()->with('success','Disetujui Kajur dan dikirim ke Kepala Sekolah');
        });
    }

    // Disetujui final oleh Kepsek -> nomor surat
    public function approveKepsek(Request $request, SuratKeluar $surat_keluar, NumberSequenceService $seq)
    {
        return DB::transaction(function () use ($surat_keluar, $seq) {
            if ($surat_keluar->status !== 'pending_kepsek') {
                return back()->with('error','Status tidak sesuai');
            }

            $surat_keluar->approvals()->updateOrCreate(
                ['level'=>2],
                ['approver_id'=>Auth::id(),'status'=>'approved','decided_at'=>now()]
            );

            $prefix = ($surat_keluar->template?->kode_klasifikasi ?? 'GEN')
                    . '/' . \App\Services\NumberSequenceService::toRoman((int)date('n'))
                    . '/' . date('Y');
            $next = $seq->next($prefix);
            $nomor = sprintf('%s/%03d', $prefix, $next);

            $surat_keluar->nomor_surat = $nomor;
            $surat_keluar->status = 'approved';
            $surat_keluar->approved_at = now();
            $surat_keluar->save();

            return back()->with('success','Surat disetujui final dan diberi nomor');
        });
    }

    protected function findKepsekId(): int
    {
        return \App\Models\User::role('kepala_sekolah')->value('id') ?? Auth::id();
    }
}
