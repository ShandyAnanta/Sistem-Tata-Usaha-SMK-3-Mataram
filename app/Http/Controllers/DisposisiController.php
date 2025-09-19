<?php

namespace App\Http\Controllers;

use App\Models\Disposisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DisposisiController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','permission:disposisi.view'])->only(['index']);
        $this->middleware(['auth','permission:disposisi.create'])->only(['updateStatus']);
    }

    public function index(Request $request)
    {
        $items = Disposisi::with('suratMasuk')
            ->where('penerima_id', Auth::id())
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('disposisi.index', compact('items'));
    }

    public function updateStatus(Request $request, Disposisi $disposisi)
    {
        $action = $request->input('action'); // read / acted

        if ($action === 'read' && !$disposisi->read_at) {
            $disposisi->read_at = now();
            $disposisi->status  = 'dibaca';
        } elseif ($action === 'acted') {
            $disposisi->acted_at = now();
            $disposisi->status   = 'ditindaklanjuti';
        }
        $disposisi->save();

        return back()->with('success','Status disposisi diperbarui');
    }
}
