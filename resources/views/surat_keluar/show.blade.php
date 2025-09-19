@extends('layouts.app')
@section('title','Detail Surat Keluar')
@section('content')
<div class="max-w-3xl space-y-6">
  <div class="rounded border bg-white p-4">
    <div class="mb-2 text-lg font-semibold">Informasi Surat</div>
    <div class="grid grid-cols-1 gap-2 sm:grid-cols-2">
      <div><b>Tanggal:</b> {{ \Illuminate\Support\Carbon::parse($item->tanggal_surat)->format('d M Y') }}</div>
      <div><b>No Surat:</b> {{ $item->nomor_surat }}</div>
      <div><b>Nama (Penerima):</b> {{ $item->nama_penerima }}</div>
      <div><b>Keterangan Surat:</b> {{ $item->keterangan_surat }}</div>
    </div>
    @if($item->file_path)
      <div class="mt-3">
        <b>Berkas:</b> <a class="text-blue-600" href="{{ asset('storage/'.$item->file_path) }}" target="_blank">Lihat/unduh</a>
      </div>
    @endif
  </div>

  <div class="flex gap-3">
    <a href="{{ route('surat-keluar.index') }}" class="rounded border px-4 py-2">Kembali</a>
    <form method="post" action="{{ route('surat-keluar.destroy',$item->id) }}" onsubmit="return confirm('Hapus surat ini?')">
      @csrf
      @method('DELETE')
      <button class="rounded bg-red-600 px-4 py-2 text-white">Hapus</button>
    </form>
  </div>
</div>
@endsection
