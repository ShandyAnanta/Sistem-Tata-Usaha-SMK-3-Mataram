@extends('layouts.app')

@section('title','Ubah Surat Masuk')

@section('content')
<form method="post" action="{{ route('surat-masuk.update', $item->id) }}" enctype="multipart/form-data" class="space-y-4 max-w-2xl">
    @csrf
    @method('PUT')

    <div>
        <label class="block mb-1 text-sm text-gray-700">Pengirim</label>
        <input name="pengirim" value="{{ old('pengirim', $item->pengirim) }}" class="w-full rounded border px-3 py-2" required>
        @error('pengirim') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div>
            <label class="block mb-1 text-sm text-gray-700">Tanggal Surat</label>
            <input type="date" name="tanggal_surat" value="{{ old('tanggal_surat', $item->tanggal_surat) }}" class="w-full rounded border px-3 py-2" required>
            @error('tanggal_surat') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
        </div>
        <div>
            <label class="block mb-1 text-sm text-gray-700">Nomor Surat</label>
            <input name="nomor_surat" value="{{ old('nomor_surat', $item->nomor_surat) }}" class="w-full rounded border px-3 py-2" required>
            @error('nomor_surat') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
        </div>
    </div>

    <div>
        <label class="block mb-1 text-sm text-gray-700">Keterangan Isi</label>
        <input name="keterangan_isi" value="{{ old('keterangan_isi', $item->keterangan_isi) }}" class="w-full rounded border px-3 py-2" required>
        @error('keterangan_isi') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
    </div>

    <div>
        <label class="block mb-1 text-sm text-gray-700">Tanggal Surat Masuk (Agenda)</label>
        <input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk', $item->tanggal_masuk) }}" class="w-full rounded border px-3 py-2">
        @error('tanggal_masuk') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
    </div>

    <div>
        <label class="block mb-1 text-sm text-gray-700">Ganti File (opsional)</label>
        <input type="file" name="file" class="w-full rounded border px-3 py-2">
        @error('file') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
        @if($item->file_path)
            <p class="mt-1 text-sm">File saat ini: <a class="text-blue-600" href="{{ asset('storage/'.$item->file_path) }}" target="_blank">Lihat</a></p>
        @endif
    </div>

    <div class="flex gap-2">
        <button class="rounded bg-blue-600 px-4 py-2 text-white">Simpan Perubahan</button>
        <a href="{{ route('surat-masuk.show', $item->id) }}" class="rounded border px-4 py-2">Batal</a>
    </div>
</form>
@endsection
