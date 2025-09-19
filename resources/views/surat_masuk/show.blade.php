@extends('layouts.app')

@section('title','Detail Surat Masuk')

@section('content')
<div class="max-w-3xl space-y-6">
  {{-- Informasi utama surat --}}
  <div class="rounded border bg-white p-4">
    <div class="mb-3 text-lg font-semibold">Informasi Surat Masuk</div>
    <div class="grid grid-cols-1 gap-2 sm:grid-cols-2">
      <div><b>Pengirim:</b> {{ $item->pengirim }}</div>
      <div><b>Tanggal Surat:</b> {{ \Illuminate\Support\Carbon::parse($item->tanggal_surat)->format('d M Y') }}</div>
      <div><b>Nomor Surat:</b> {{ $item->nomor_surat }}</div>
      <div><b>Tanggal Masuk:</b> {{ $item->tanggal_masuk }}</div>
      <div class="sm:col-span-2"><b>Keterangan Isi:</b> {{ $item->keterangan_isi }}</div>
      <div><b>No Agenda:</b> {{ $item->agenda_number }}</div>
      <div><b>Status:</b> {{ $item->status }}</div>
    </div>
    @if($item->file_path)
      <div class="mt-3">
        <b>Berkas:</b> <a class="text-blue-600" href="{{ asset('storage/'.$item->file_path) }}" target="_blank">Lihat/unduh</a>
      </div>
    @endif
  </div>

  {{-- Aksi navigasi: kembali, ubah, hapus --}}
  <div class="flex gap-3">
    <a href="{{ route('surat-masuk.index') }}" class="rounded border px-4 py-2">Kembali</a>
    <a href="{{ route('surat-masuk.edit', $item->id) }}" class="rounded bg-blue-600 px-4 py-2 text-white">Ubah</a>
    <form method="post" action="{{ route('surat-masuk.destroy', $item->id) }}"
          onsubmit="return confirm('Hapus surat ini? Tindakan tidak bisa dibatalkan.')">
      @csrf
      @method('DELETE')
      <button class="rounded bg-red-600 px-4 py-2 text-white">Hapus</button>
    </form>
  </div>

  {{-- Form kirim disposisi --}}
  <div class="rounded border bg-white p-4">
    <div class="mb-3 text-lg font-semibold">Kirim Disposisi</div>
    <form method="post" action="{{ route('surat-masuk.kirim-disposisi', $item->id) }}" class="space-y-3">
      @csrf
      <div>
        <label class="block text-sm mb-1">Penerima</label>
        <select name="penerima_id" class="w-full rounded border px-3 py-2" required>
          @foreach(\App\Models\User::orderBy('name')->get() as $u)
            <option value="{{ $u->id }}">{{ $u->name }}</option>
          @endforeach
        </select>
        @error('penerima_id') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
      </div>
      <div>
        <label class="block text-sm mb-1">Instruksi (opsional)</label>
        <input name="instruksi" class="w-full rounded border px-3 py-2" placeholder="Tindak lanjuti, disposisikan, arsipkan, dll.">
        @error('instruksi') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
      </div>
      <button class="rounded bg-indigo-600 px-4 py-2 text-white">Kirim Disposisi</button>
    </form>
  </div>

  {{-- Riwayat disposisi --}}
  @if($item->disposisi && $item->disposisi->count())
    <div class="rounded border bg-white p-4">
      <div class="mb-3 text-lg font-semibold">Riwayat Disposisi</div>
      <ul class="list-disc pl-5 space-y-1">
        @foreach($item->disposisi as $d)
          <li>
            {{ $d->created_at->format('d M Y H:i') }}
            — ke: {{ optional($d->penerima)->name }}
            — oleh: {{ optional($d->pengirim)->name }}
            — instruksi: {{ $d->instruksi }}
          </li>
        @endforeach
      </ul>
    </div>
  @endif
</div>
@endsection
